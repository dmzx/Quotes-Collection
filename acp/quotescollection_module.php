<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\quotescollection\acp;

class quotescollection_module
{
	var $u_action;
	function main($id, $mode)
	{
		// Let's first set some globals, includes, variables and the base template
		global $cache, $db, $phpbb_container, $user, $phpbb_root_path, $phpEx, $template, $u_action, $request,	$config;

		$table_dm_qc = $phpbb_container->getParameter('dmzx.quotescollection.table.dm_qc');
		$table_dm_qc_config = $phpbb_container->getParameter('dmzx.quotescollection.table.dm_qc_config');
		$pagination = $phpbb_container->get('pagination');

		$action = $request->variable('action', '');
		$id		= $request->variable('id', 0);

		// Read out the config table
		$sql = 'SELECT *
			FROM ' . $table_dm_qc_config;
		$result = $db->sql_query($sql);
		$dm_qc_config = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$start = $request->variable('start', 0);
		$number = $dm_qc_config['pagination_acp'];

		$template->assign_vars(array(
			'BASE'		=> $this->u_action,
		));

		// Here we set the main switches to use within the ACP
		switch ($mode)
		{
			// Set the main switch for managing categories
			case 'config':
				$this->page_title = 'ACP_DM_QC_CONFIG';
				$this->tpl_name = 'acp_dm_qc';

				// Here the action for the config
				if ( isset($_POST['submit']) )
				{
					$sql_ary = array (
						'qc_guests'			=> $request->variable('guests_enable', 0),
						'qc_enable'			=> $request->variable('qc_enable', 0),
						'approval_needed' 	=> $request->variable('approval_enable', 0),
						'pagination_acp'	=> $request->variable('pagination_acp', 0),
						'pagination_user' 	=> $request->variable('pagination_user', 0),
						'ups_points' 		=> $request->variable('ups_points', 0.00),
						'show_index' 		=> $request->variable('show_index', 0),
						'delay_set' 		=> $request->variable('delay_set', 0),
					);

					// Check if acp pagination is below 5
					$pagination_check_acp = $request->variable('pagination_acp', 0);
					$pagination_check_user = $request->variable('pagination_user', 0);

					if ( $pagination_check_acp < 5 || $pagination_check_user < 5 )
					{
						trigger_error($user->lang['ACP_DM_QC_PAGE_ERROR'] . adm_back_link($this->u_action), E_USER_WARNING);
					}
					// Update values in phpbb_points_values
					$sql = 'UPDATE ' . $table_dm_qc_config . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary);
					$db->sql_query($sql);

					// purge the cache
					$cache->destroy('_quote_config');

					// Add logs
					add_log('admin', 'LOG_DM_QC_CONFIG_SETTINGS');
					trigger_error($user->lang['ACP_DM_QC_CONFIG_SUCCESS'] . adm_back_link($this->u_action));
				}
				else
				{
					if ( defined('IN_ULTIMATE_POINTS') && $config['points_enable'] )
					{
						$template->assign_vars(array(
							'S_UPS_INSTALLED'		=> true,
							'UPS_POINTS'			=> $dm_qc_config['ups_points'],
							'ACP_DM_QC_UPS'			=> sprintf($user->lang['ACP_DM_QC_UPS'], $config['points_name']),
							'ACP_DM_QC_UPS_EXPLAIN'	=> sprintf($user->lang['ACP_DM_QC_UPS_EXPLAIN'], $config['points_name']),
						));
					}

					$template->assign_vars(array(
						'S_QC_CONFIG'		=> true,
						'QC_ENABLE'			=> $dm_qc_config['qc_enable'],
						'GUESTS_ENABLE'		=> $dm_qc_config['qc_guests'],
						'APPROVAL_ENABLE' 	=> $dm_qc_config['approval_needed'],
						'PAGINATION_ACP' 	=> $dm_qc_config['pagination_acp'],
						'PAGINATION_USER' 	=> $dm_qc_config['pagination_user'],
						'SHOW_INDEX' 		=> $dm_qc_config['show_index'],
						'DELAY_SET' 		=> $dm_qc_config['delay_set'],
					));
				}
			break;

			// Set the main switch for editing videos
			case 'edit_quotes':
				$this->page_title = 'ACP_DM_QC_EDIT';
				$this->tpl_name = 'acp_dm_qc';

				$sort_days	= $request->variable('st', 0);
				$sort_key	= $request->variable('sk', 'video_title');
				$sort_dir	= $request->variable('sd', 'a');
				$limit_days = array(0 => $user->lang['ACP_DM_QC_ALL'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);

				$sort_by_text = array('i' => $user->lang['ACP_DM_QC_SORT_ID'], 'n' => $user->lang['ACP_DM_QC_SORT_AUTHOR'], 'p' => $user->lang['ACP_DM_QC_SORT_POSTER'],'d' => $user->lang['ACP_DM_QC_SORT_DATE'], 'a' => $user->lang['ACP_DM_QC_SORT_APPROVAL']);
				$sort_by_sql = array('i' => 'id', 'n' => 'author', 'p' => 'poster','d' => 'post_date', 'a' => 'approve');

				$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
				$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

				// Count number of quotes
				$sql = 'SELECT COUNT(id) AS total_quotes
					FROM ' . $table_dm_qc;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$total_quotes = $row['total_quotes'];
				$db->sql_freeresult($result);

				// List all quotes
				$sql = 'SELECT q.*, u.*
					FROM ' . $table_dm_qc . ' q
					LEFT JOIN ' . USERS_TABLE . ' u
						ON q.poster = u.user_id
					ORDER by q.'. $sql_sort_order;
				$result = $db->sql_query_limit($sql, $number, $start);

				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('quotes', array(
						'ID'			=> $row['id'],
						'QUOTE'			=> generate_text_for_display($row['quote'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']),
						'AUTHOR'		=> $row['author'],
						'POSTER'		=> $row['username'],
						'DATE'			=> $user->format_date($row['post_date']),
						'APPROVAL'		=> ($row['approve'] == 1) ? $user->lang['YES'] : $user->lang['NO'],
						'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;id=' .$row['id'],
						'U_DEL'			=> $this->u_action . '&amp;action=delete&amp;id=' .$row['id'],
						)
					);
				}
				$db->sql_freeresult($result);

				$base_url = $this->u_action;
				$pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_quotes, $number, $start);

				$template->assign_vars(array(
					'S_QC_LIST'			=> true,
					'S_QUOTES_ACTION' 	=> $this->u_action,
					'S_SELECT_SORT_DIR'	=> $s_sort_dir,
					'S_SELECT_SORT_KEY'	=> $s_sort_key,
					'TOTAL_QUOTES'		=> ($total_quotes == 1) ? $user->lang['ACP_DM_QC_SINGLE'] : sprintf($user->lang['ACP_DM_QC_MULTI'], $total_quotes),
					'U_EDIT_ACTION'		=> $this->u_action,
					'U_ADD_QUOTE'		=> $this->u_action . '&amp;action=add_quote',
				));

				// Now let's define, what to do within the module edit quotes
				switch ($action)
				{
					// Add a new quote
					case 'add_quote';
						$this->page_title = 'ACP_DM_QC_ADD';
						$this->tpl_name = 'acp_dm_qc';
						$form_action = $this->u_action. '&amp;action=add_new';
						$lang_mode = $user->lang['ACP_DM_QC_ADD'];
						$pre_approved = $date = $poster = '';

						$action = ((isset($_POST['submit']) && !$_POST['id']) ? 'add_new' : $action );

						if ( $dm_qc_config['approval_needed'] == 1 )
						{
							$template->assign_vars(array(
								'S_QC_APPROVAL_NEEDED'	=> true,
							));
						}
						else
						{
							$pre_approved = 1;
						}

						$id			= $request->variable('id', 0);
						$quote		= $request->variable('quote', '', true);
						$author		= $request->variable('author', '', true);
						$approved	= $pre_approved;
						$uid = $bitfield = $options = '';
						$allow_bbcode = $allow_urls = $allow_smilies = true;
						generate_text_for_storage($quote, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);

						$template->assign_vars(array(
							'S_QC_ADD'	=> true,
							'S_QC_LIST'	=> false,
							'ID'		=> $id,
							'QUOTE'		=> $quote,
							'AUTHOR'	=> $author,
							'POSTER'	=> $poster,
							'DATE'		=> $date,
							'APPROVED'	=> $approved,

							'U_BACK'			=> $this->u_action,
							'U_ACTION'			=> $form_action,
							'L_MODE_TITLE'		=> $lang_mode,
						));
					break;

					case 'add_new':
						// Insert new quote
						$id			= $request->variable('id', 0);
						$quote		= $request->variable('quote', '', true);
						$author		= $request->variable('author', '', true);

						if ( $dm_qc_config['approval_needed'] == 1 )
						{
							$pre_approved = $request->variable('approved', 0);
						}
						else
						{
							$pre_approved = 1;
						}

						$approved = $pre_approved;
						$uid = $bitfield = $options = '';
						$allow_bbcode = $allow_urls = $allow_smilies = true;
						generate_text_for_storage($quote, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);

						$sql_ary_add = array(
							'quote'	=> $quote,
							'author' => $author,
							'poster' => $user->data['user_id'],
							'post_date' => time(),
							'approve' => $approved,
							'bbcode_bitfield' => $bitfield,
							'bbcode_uid' => $uid,
							'bbcode_options' => $options,
						);

						$db->sql_query('INSERT INTO ' . $table_dm_qc .' ' . $db->sql_build_array('INSERT', $sql_ary_add));
						add_log('admin', 'LOG_ADMIN_QUOTE_ADDED');
						trigger_error($user->lang['ACP_DM_QC_ADDED'] . adm_back_link($this->u_action));

					break;

					// Edit an existing quote
					case 'edit':
						$this->page_title = 'ACP_DM_QC_EDIT';
						$this->tpl_name = 'acp_dm_qc';
						$form_action = $this->u_action. '&amp;action=update';
						$lang_mode = $user->lang['ACP_DM_QC_EDIT'];

						$action = ((isset($_POST['submit']) && !$_POST['id']) ? 'update' : $action );

						$id = $request->variable('id', '');

						if ( $dm_qc_config['approval_needed'] == 1 )
						{
							$template->assign_vars(array(
								'S_QC_APPROVAL_NEEDED'	=> true,
							));
						}

						$sql = 'SELECT q.*, u.*
							FROM ' . $table_dm_qc . ' q
							LEFT JOIN ' . USERS_TABLE . ' u
								ON q.poster = u.user_id
							WHERE id = ' . $id;
						$result = $db->sql_query_limit($sql,1);
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						$allow_bbcode = $allow_urls = $allow_smilies = true;
						decode_message($row['quote'], $row['bbcode_uid']);
						$quote_id = $row['id'];
						$poster_name = $row['username'];

						$template->assign_vars(array(
							'S_QC_EDIT'	=> true,
							'S_QC_LIST'	=> false,
							'ID'		=> $quote_id,
							'QUOTE'		=> $row['quote'],
							'AUTHOR'	=> $row['author'],
							'POSTER'	=> $poster_name,
							'DATE'		=> $row['post_date'],
							'APPROVED'	=> ($row['approve'] == '1') ? 'checked="checked"' : '',
							)
						);

						$template->assign_vars(array(
							'U_ACTION'		=> $form_action,
							'L_MODE_TITLE'	=> $lang_mode,
							)
						);
					break;

					// Change an existing quote
					case 'update':
						$quote		= $request->variable('quote', '', true);
						$author		= $request->variable('author', '', true);
						$approved	= $request->variable('approved', 0);
						$uid = $bitfield = $options = '';
						$allow_bbcode = $allow_urls = $allow_smilies = true;
						generate_text_for_storage($quote, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);

						$sql_ary = array(
							'quote'				=> $quote,
							'author'			=> $author,
							'approve'			=> $approved,
							'bbcode_uid'		=> $uid,
							'bbcode_bitfield'	=> $bitfield,
							'bbcode_options'	=> $options,
						);

						if ( $quote == '' )
						{
							trigger_error($user->lang['ACP_DM_QC_NEED_DATA'] . adm_back_link($this->u_action), E_USER_WARNING);
						}
						else
						{
							$db->sql_query('UPDATE ' . $table_dm_qc . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . ' WHERE id = ' . $id);
							add_log('admin', 'LOG_ADMIN_QUOTE_EDITED', $id);
							trigger_error($user->lang['ACP_DM_QC_UPDATED'] . adm_back_link($this->u_action));
						}
					break;

					// Delete an existing video
					case 'delete':
						if (confirm_box(true))
						{
							$sql = 'DELETE FROM ' . $table_dm_qc . '
								WHERE id = '. $id;
							$db->sql_query($sql);
							add_log('admin', 'LOG_ADMIN_QUOTE_DELETED', $id);
							trigger_error($user->lang['ACP_DM_QC_DELETED'] . adm_back_link($this->u_action));
						}
						else
						{
							confirm_box(false, $user->lang['ACP_DM_QC_REALY_DELETE'], build_hidden_fields(array(
								'id'		=> $id,
								'action'	=> 'delete',
								))
							);
						}
						redirect($this->u_action);
					break;
				}

			break;

			// Set the main switch for releasing quotes
			case 'release_quotes':
				$this->page_title = 'ACP_DM_QC_RELEASE';
				$this->tpl_name = 'acp_dm_qc';

				// List all quotes, which are not yet released
				$sql = 'SELECT q.*, u.*
					FROM ' . $table_dm_qc . ' q
					LEFT JOIN ' . USERS_TABLE . ' u
						ON q.poster = u.user_id
					WHERE approve = 0
					ORDER BY id';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('quotes', array(
						'ID'			=> $row['id'],
						'QUOTE'			=> generate_text_for_display($row['quote'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']),
						'AUTHOR'		=> $row['author'],
						'POSTER'		=> $row['username'],
						'DATE'			=> $user->format_date($row['post_date']),
						'APPROVAL'		=> ($row['approve'] == 1) ? $user->lang['YES'] : $user->lang['NO'],
						'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;id=' .$row['id'],
						'U_DEL'			=> $this->u_action . '&amp;action=delete&amp;id=' .$row['id'],
					));
				}
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'S_QC_LIST'		=> true,
					'S_QC_RELEASE'	=> true,
					)
				);

				// Now let's define, what to do within the module Release Videos
				switch ($action)
				{
					// Edit an existing quote
					case 'edit':
						$this->page_title = 'ACP_DM_QC_EDIT';
						$this->tpl_name = 'acp_dm_qc';
						$form_action = $this->u_action. '&amp;action=update';
						$lang_mode = $user->lang['ACP_DM_QC_EDIT'];

						$action = ((isset($_POST['submit']) && !$_POST['id']) ? 'add' : $action );

						$id = $request->variable('id', '');

						$sql = 'SELECT q.*, u.*
							FROM ' . $table_dm_qc . ' q
							LEFT JOIN ' . USERS_TABLE . ' u
								ON q.poster = u.user_id
							WHERE id = ' . $id;
						$result = $db->sql_query_limit($sql,1);
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);
						decode_message($row['quote'], $row['bbcode_uid']);
						$quote_id = $row['id'];
						$poster_name = $row['username'];
						$poster_id = $row['poster'];

						$template->assign_vars(array(
							'S_QC_EDIT'	=> true,
							'S_QC_LIST'	=> false,
							'S_QC_APPROVAL_NEEDED'	=> true,
							'ID'		=> $quote_id,
							'POSTER_ID'	=> $poster_id,
							'QUOTE'		=> $row['quote'],
							'AUTHOR'	=> $row['author'],
							'POSTER'	=> $poster_name,
							'DATE'		=> $row['post_date'],
							'APPROVED'	=> ($row['approve'] == '1') ? 'checked="checked"' : '',
							)
						);

						$template->assign_vars(array(
							'U_ACTION'		=> $form_action,
							'L_MODE_TITLE'	=> $lang_mode,
							)
						);
					break;

					// Change an existing quote
					case 'update':
						$poster_id 	= $request->variable('poster_id', 0);
						$quote		= $request->variable('quote', '', true);
						$author		= $request->variable('author', '', true);
						$approved	= $request->variable('approved', 0);
						$allow_bbcode = $allow_urls = $allow_smilies = true;
						$uid = $bitfield = $options = '';
						generate_text_for_storage($quote, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);

						$sql_ary = array(
							'quote'				=> $quote,
							'author'			=> $author,
							'approve'			=> $approved,
							'bbcode_uid'		=> $uid,
							'bbcode_bitfield'	=> $bitfield,
							'bbcode_options'	=> $options,
						);

						if ( $quote == '' )
						{
							trigger_error($user->lang['ACP_DM_QC_NEED_DATA'] . adm_back_link($this->u_action), E_USER_WARNING);
						}
						else
						{
							$db->sql_query('UPDATE ' . $table_dm_qc . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . ' WHERE id = ' . $id);

							if ( defined('IN_ULTIMATE_POINTS') && $dm_qc_config['ups_points'] > 0 )
							{
								if ( !function_exists('add_points') )
								{
									include($phpbb_root_path . 'includes/points/functions_points.' . $phpEx);
								}
								add_points($poster_id, $dm_qc_config['ups_points']);
							}
							add_log('admin', 'LOG_ADMIN_QUOTE_RELEASED', $id);
							trigger_error($user->lang['ACP_DM_QC_UPDATED'] . adm_back_link($this->u_action));
						}

					break;

					// Delete an existing video
					case 'delete':
						if (confirm_box(true))
						{
							$sql = 'DELETE FROM ' . $table_dm_qc . '
								WHERE id = '. $id;
							$db->sql_query($sql);
							add_log('admin', 'LOG_ADMIN_QUOTE_DELETED', $id);
							trigger_error($user->lang['ACP_DM_QC_DELETED'] . adm_back_link($this->u_action));
						}
						else
						{
							confirm_box(false, $user->lang['ACP_DM_QC_REALY_DELETE'], build_hidden_fields(array(
								'id'		=> $id,
								'action'	=> 'delete',
								))
							);
						}
					break;
				}
			break;
		}
	}
}
