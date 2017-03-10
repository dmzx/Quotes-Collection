<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\quotescollection\controller;

use phpbb\template\template;
use phpbb\user;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\request\request_interface;
use phpbb\config\config;
use phpbb\cache\service as cache_interface;
use phpbb\pagination;
use phpbb\log\log_interface;

class admin_controller
{
	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var db_interface */
	protected $db;

	/** @var request_interface */
	protected $request;

	/** @var config */
	protected $config;

	/** @var cache_interface */
	protected $cache;

	/** @var pagination */
	protected $pagination;

	/** @var log_interface */
	protected $log;

	/** @var string */
	protected $dm_qc_table;

	/** @var string */
	protected $dm_qc_config_table;

	/**
	* Constructor
	*
	* @param template		 	$template
	* @param user				$user
	* @param db_interface		$db
	* @param request_interface	$request
	* @param config				$config
	* @param cache_interface	$cache
	* @param pagination			$pagination
	* @param log_interface		$log
	* @param string				$dm_qc_table
	* @param string				$dm_qc_config_table
	*
	*/
	public function __construct(
		template $template,
		user $user,
		db_interface $db,
		request_interface $request,
		config $config,
		cache_interface $cache,
		pagination $pagination,
		log_interface $log,
		$dm_qc_table,
		$dm_qc_config_table
	)
	{
		$this->template 			= $template;
		$this->user 				= $user;
		$this->db 					= $db;
		$this->request 				= $request;
		$this->config 				= $config;
		$this->cache 				= $cache;
		$this->pagination 			= $pagination;
		$this->log 					= $log;
		$this->dm_qc_table 			= $dm_qc_table;
		$this->dm_qc_config_table 	= $dm_qc_config_table;
	}

	public function display_config()
	{
		// Read out the config table
		$sql = 'SELECT *
			FROM ' . $this->dm_qc_config_table;
		$result = $this->db->sql_query($sql);
		$dm_qc_config = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		// Here the action for the config
		if ($this->request->is_set_post('submit'))
		{
			$sql_ary = array (
				'qc_guests'			=> $this->request->variable('guests_enable', 0),
				'qc_enable'			=> $this->request->variable('qc_enable', 0),
				'approval_needed' 	=> $this->request->variable('approval_enable', 0),
				'pagination_acp'	=> $this->request->variable('pagination_acp', 0),
				'pagination_user' 	=> $this->request->variable('pagination_user', 0),
				'ups_points' 		=> $this->request->variable('ups_points', 0.00),
				'show_index' 		=> $this->request->variable('show_index', 0),
				'delay_set' 		=> $this->request->variable('delay_set', 0),
			);

			// Check if acp pagination is below 5
			$pagination_check_acp = $this->request->variable('pagination_acp', 0);
			$pagination_check_user = $this->request->variable('pagination_user', 0);

			if ($pagination_check_acp < 5 || $pagination_check_user < 5)
			{
				trigger_error($this->user->lang['ACP_DM_QC_PAGE_ERROR'] . adm_back_link($this->u_action), E_USER_WARNING);
			}
			// Update values in phpbb_points_values
			$sql = 'UPDATE ' . $this->dm_qc_config_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary);
			$this->db->sql_query($sql);

			// purge the cache
			$this->cache->destroy('_quote_config');

			// Add action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DM_QC_CONFIG_SETTINGS');

			trigger_error($this->user->lang['ACP_DM_QC_CONFIG_SUCCESS'] . adm_back_link($this->u_action));
		}
		else
		{
			$this->template->assign_vars(array(
				'S_QC_CONFIG'		=> true,
				'QC_ENABLE'			=> $dm_qc_config['qc_enable'],
				'GUESTS_ENABLE'		=> $dm_qc_config['qc_guests'],
				'APPROVAL_ENABLE' 	=> $dm_qc_config['approval_needed'],
				'PAGINATION_ACP' 	=> $dm_qc_config['pagination_acp'],
				'PAGINATION_USER' 	=> $dm_qc_config['pagination_user'],
				'SHOW_INDEX' 		=> $dm_qc_config['show_index'],
				'DELAY_SET' 		=> $dm_qc_config['delay_set'],
				'DM_QC_VERSION'		=> $this->config['dm_qc_version'],
			));
		}
	}

	public function display_edit_quotes()
	{
		$id	= $this->request->variable('id', 0);

		// Read out the config table
		$sql = 'SELECT *
			FROM ' . $this->dm_qc_config_table;
		$result = $this->db->sql_query($sql);
		$dm_qc_config = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$start = $this->request->variable('start', 0);
		$number = $dm_qc_config['pagination_acp'];

		$action = $this->request->variable('action', '');

		$sort_days	= $this->request->variable('st', 0);
		$sort_key	= $this->request->variable('sk', 'video_title');
		$sort_dir	= $this->request->variable('sd', 'a');
		$limit_days = array(0 => $this->user->lang['ACP_DM_QC_ALL'], 1 => $this->user->lang['1_DAY'], 7 => $this->user->lang['7_DAYS'], 14 => $this->user->lang['2_WEEKS'], 30 => $this->user->lang['1_MONTH'], 90 => $this->user->lang['3_MONTHS'], 180 => $this->user->lang['6_MONTHS'], 365 => $this->user->lang['1_YEAR']);

		$sort_by_text = array('i' => $this->user->lang['ACP_DM_QC_SORT_ID'], 'n' => $this->user->lang['ACP_DM_QC_SORT_AUTHOR'], 'p' => $this->user->lang['ACP_DM_QC_SORT_POSTER'],'d' => $this->user->lang['ACP_DM_QC_SORT_DATE'], 'a' => $this->user->lang['ACP_DM_QC_SORT_APPROVAL']);
		$sort_by_sql = array('i' => 'id', 'n' => 'author', 'p' => 'poster','d' => 'post_date', 'a' => 'approve');

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

		// Count number of quotes
		$sql = 'SELECT COUNT(id) AS total_quotes
			FROM ' . $this->dm_qc_table;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$total_quotes = $row['total_quotes'];
		$this->db->sql_freeresult($result);

		// List all quotes
		$sql = 'SELECT q.*, u.*
			FROM ' . $this->dm_qc_table . ' q
			LEFT JOIN ' . USERS_TABLE . ' u
				ON q.poster = u.user_id
			ORDER by q.'. $sql_sort_order;
		$result = $this->db->sql_query_limit($sql, $number, $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('quotes', array(
				'ID'			=> $row['id'],
				'QUOTE'			=> generate_text_for_display($row['quote'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']),
				'AUTHOR'		=> $row['author'],
				'POSTER'		=> $row['username'],
				'DATE'			=> $this->user->format_date($row['post_date']),
				'APPROVAL'		=> ($row['approve'] == 1) ? $this->user->lang['YES'] : $this->user->lang['NO'],
				'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;id=' .$row['id'],
				'U_DEL'			=> $this->u_action . '&amp;action=delete&amp;id=' .$row['id'],
			));
		}
		$this->db->sql_freeresult($result);

		$base_url = $this->u_action;
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_quotes, $number, $start);

		$this->template->assign_vars(array(
			'S_QC_LIST'			=> true,
			'S_QUOTES_ACTION' 	=> $this->u_action,
			'S_SELECT_SORT_DIR'	=> $s_sort_dir,
			'S_SELECT_SORT_KEY'	=> $s_sort_key,
			'TOTAL_QUOTES'		=> ($total_quotes == 1) ? $this->user->lang['ACP_DM_QC_SINGLE'] : sprintf($this->user->lang['ACP_DM_QC_MULTI'], $total_quotes),
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
				$lang_mode = $this->user->lang['ACP_DM_QC_ADD'];
				$pre_approved = $date = $poster = '';

				if ($dm_qc_config['approval_needed'] == 1)
				{
					$this->template->assign_vars(array(
						'S_QC_APPROVAL_NEEDED'	=> true,
					));
				}
				else
				{
					$pre_approved = 1;
				}

				$id			= $this->request->variable('id', 0);
				$quote		= $this->request->variable('quote', '', true);
				$author		= $this->request->variable('author', '', true);
				$approved	= $pre_approved;

				$this->template->assign_vars(array(
					'S_QC_ADD'			=> true,
					'S_QC_LIST'			=> false,
					'ID'				=> $id,
					'QUOTE'				=> $quote,
					'AUTHOR'			=> $author,
					'POSTER'			=> $poster,
					'DATE'				=> $date,
					'APPROVED'			=> $approved,
					'U_BACK'			=> $this->u_action,
					'U_ACTION'			=> $form_action,
					'L_MODE_TITLE'		=> $lang_mode,
				));
			break;

			case 'add_new':
				// Insert new quote
				$id			= $this->request->variable('id', 0);
				$quote		= $this->request->variable('quote', '', true);
				$author		= $this->request->variable('author', '', true);

				if ($dm_qc_config['approval_needed'] == 1)
				{
					$pre_approved = $this->request->variable('approved', 0);
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
					'quote'				=> $quote,
					'author' 			=> $author,
					'poster' 			=> $this->user->data['user_id'],
					'post_date' 		=> time(),
					'approve' 			=> $approved,
					'bbcode_bitfield' 	=> $bitfield,
					'bbcode_uid' 		=> $uid,
					'bbcode_options' 	=> $options,
				);

				$this->db->sql_query('INSERT INTO ' . $this->dm_qc_table .' ' . $this->db->sql_build_array('INSERT', $sql_ary_add));

				// Add action to the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ADMIN_QUOTE_ADDED');

				trigger_error($this->user->lang['ACP_DM_QC_ADDED'] . adm_back_link($this->u_action));

			break;

			// Edit an existing quote
			case 'edit':
				$this->page_title = 'ACP_DM_QC_EDIT';
				$this->tpl_name = 'acp_dm_qc';
				$form_action = $this->u_action. '&amp;action=update';
				$lang_mode = $this->user->lang['ACP_DM_QC_EDIT'];

				$id = $this->request->variable('id', '');

				if ($dm_qc_config['approval_needed'] == 1)
				{
					$this->template->assign_vars(array(
						'S_QC_APPROVAL_NEEDED'	=> true,
					));
				}

				$sql = 'SELECT q.*, u.*
					FROM ' . $this->dm_qc_table . ' q
					LEFT JOIN ' . USERS_TABLE . ' u
						ON q.poster = u.user_id
					WHERE id = ' . $id;
				$result = $this->db->sql_query_limit($sql,1);
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				$allow_bbcode = $allow_urls = $allow_smilies = true;
				decode_message($row['quote'], $row['bbcode_uid']);
				$quote_id = $row['id'];
				$poster_name = $row['username'];

				$this->template->assign_vars(array(
					'S_QC_EDIT'	=> true,
					'S_QC_LIST'	=> false,
					'ID'		=> $quote_id,
					'QUOTE'		=> $row['quote'],
					'AUTHOR'	=> $row['author'],
					'POSTER'	=> $poster_name,
					'DATE'		=> $row['post_date'],
					'APPROVED'	=> ($row['approve'] == '1') ? 'checked="checked"' : '',
				));

				$this->template->assign_vars(array(
					'U_ACTION'		=> $form_action,
					'L_MODE_TITLE'	=> $lang_mode,
				));
			break;

			// Change an existing quote
			case 'update':
				$quote		= $this->request->variable('quote', '', true);
				$author		= $this->request->variable('author', '', true);
				$approved	= $this->request->variable('approved', 0);
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

				if ($quote == '')
				{
					trigger_error($this->user->lang['ACP_DM_QC_NEED_DATA'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
				else
				{
					$this->db->sql_query('UPDATE ' . $this->dm_qc_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . ' WHERE id = ' . $id);

					// Add action to the admin log
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ADMIN_QUOTE_EDITED', false, array($id));

					trigger_error($this->user->lang['ACP_DM_QC_UPDATED'] . adm_back_link($this->u_action));
				}
			break;

			// Delete an existing video
			case 'delete':
				if (confirm_box(true))
				{
					$sql = 'DELETE FROM ' . $this->dm_qc_table . '
						WHERE id = '. $id;
					$this->db->sql_query($sql);

					// Add action to the admin log
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ADMIN_QUOTE_DELETED', false, array($id));

					trigger_error($this->user->lang['ACP_DM_QC_DELETED'] . adm_back_link($this->u_action));
				}
				else
				{
					confirm_box(false, $this->user->lang['ACP_DM_QC_REALY_DELETE'], build_hidden_fields(array(
						'id'		=> $id,
						'action'	=> 'delete',
						))
					);
				}
				redirect($this->u_action);
			break;
		}
	}

	public function display_release_quotes()
	{
		$action = $this->request->variable('action', '');
		$id		= $this->request->variable('id', 0);

		// List all quotes, which are not yet released
		$sql = 'SELECT q.*, u.*
			FROM ' . $this->dm_qc_table . ' q
			LEFT JOIN ' . USERS_TABLE . ' u
				ON q.poster = u.user_id
			WHERE approve = 0
			ORDER BY id';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('quotes', array(
				'ID'			=> $row['id'],
				'QUOTE'			=> generate_text_for_display($row['quote'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']),
				'AUTHOR'		=> $row['author'],
				'POSTER'		=> $row['username'],
				'DATE'			=> $this->user->format_date($row['post_date']),
				'APPROVAL'		=> ($row['approve'] == 1) ? $this->user->lang['YES'] : $this->user->lang['NO'],
				'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;id=' .$row['id'],
				'U_DEL'			=> $this->u_action . '&amp;action=delete&amp;id=' .$row['id'],
			));
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'S_QC_LIST'		=> true,
			'S_QC_RELEASE'	=> true,
		));

		// Now let's define, what to do within the module Release Videos
		switch ($action)
		{
			// Edit an existing quote
			case 'edit':
				$this->page_title = 'ACP_DM_QC_EDIT';
				$this->tpl_name = 'acp_dm_qc';
				$form_action = $this->u_action. '&amp;action=update';
				$lang_mode = $this->user->lang['ACP_DM_QC_EDIT'];

				$id = $this->request->variable('id', '');

				$sql = 'SELECT q.*, u.*
					FROM ' . $this->dm_qc_table . ' q
					LEFT JOIN ' . USERS_TABLE . ' u
						ON q.poster = u.user_id
					WHERE id = ' . $id;
				$result = $this->db->sql_query_limit($sql,1);
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				decode_message($row['quote'], $row['bbcode_uid']);
				$quote_id = $row['id'];
				$poster_name = $row['username'];
				$poster_id = $row['poster'];

				$this->template->assign_vars(array(
					'S_QC_EDIT'				=> true,
					'S_QC_LIST'				=> false,
					'S_QC_APPROVAL_NEEDED'	=> true,
					'ID'					=> $quote_id,
					'POSTER_ID'				=> $poster_id,
					'QUOTE'					=> $row['quote'],
					'AUTHOR'				=> $row['author'],
					'POSTER'				=> $poster_name,
					'DATE'					=> $row['post_date'],
					'APPROVED'				=> ($row['approve'] == '1') ? 'checked="checked"' : '',
				));

				$this->template->assign_vars(array(
					'U_ACTION'		=> $form_action,
					'L_MODE_TITLE'	=> $lang_mode,
				));
			break;

			// Change an existing quote
			case 'update':
				$poster_id 	= $this->request->variable('poster_id', 0);
				$quote		= $this->request->variable('quote', '', true);
				$author		= $this->request->variable('author', '', true);
				$approved	= $this->request->variable('approved', 0);
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

				if ($quote == '')
				{
					trigger_error($this->user->lang['ACP_DM_QC_NEED_DATA'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
				else
				{
					$this->db->sql_query('UPDATE ' . $this->dm_qc_table . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . ' WHERE id = ' . $id);

					// Add action to the admin log
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ADMIN_QUOTE_RELEASED', false, array($id));

					trigger_error($this->user->lang['ACP_DM_QC_UPDATED'] . adm_back_link($this->u_action));
				}

			break;

			// Delete quote
			case 'delete':
				if (confirm_box(true))
				{
					$sql = 'DELETE FROM ' . $this->dm_qc_table . '
						WHERE id = ' . $id;
					$this->db->sql_query($sql);

					// Add action to the admin log
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ADMIN_QUOTE_DELETED', false, array($id));

					trigger_error($this->user->lang['ACP_DM_QC_DELETED'] . adm_back_link($this->u_action));
				}
				else
				{
					confirm_box(false, $this->user->lang['ACP_DM_QC_REALY_DELETE'], build_hidden_fields(array(
						'id'		=> $id,
						'action'	=> 'delete',
						))
					);
				}
			break;
		}
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
