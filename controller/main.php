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
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\request\request_interface;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\cache\service as cache_interface;
use phpbb\pagination;
use phpbb\log\log_interface;
use phpbb\extension\manager;

class main
{
	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var db_interface */
	protected $db;

	/** @var request_interface */
	protected $request;

	/** @var config */
	protected $config;

	/** @var helper */
	protected $helper;

	/** @var cache_interface */
	protected $cache;

	/** @var pagination */
	protected $pagination;

	/** @var log_interface */
	protected $log;

	/** @var manager */
	protected $extension_manager;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $dm_qc_table;

	/** @var string */
	protected $dm_qc_config_table;

	/**
	* Constructor
	*
	* @param template		 	$template
	* @param user				$user
	* @param auth				$auth
	* @param db_interface		$db
	* @param request_interface	$request
	* @param config				$config
	* @param helper		 		$helper
	* @param cache_interface	$cache
	* @param pagination			$pagination
	* @param log_interface		$log
	* @param manager			$extension_manager
	* @param string				$root_path
	* @param string				$php_ext
	* @param string				$dm_qc_table
	* @param string				$dm_qc_config_table
	*
	*/
	public function __construct(
		template $template,
		user $user,
		auth $auth,
		db_interface $db,
		request_interface $request,
		config $config,
		helper $helper,
		cache_interface $cache,
		pagination $pagination,
		log_interface $log,
		manager $extension_manager,
		$root_path,
		$php_ext,
		$dm_qc_table,
		$dm_qc_config_table
	)
	{
		$this->template 			= $template;
		$this->user 				= $user;
		$this->auth 				= $auth;
		$this->db 					= $db;
		$this->request 				= $request;
		$this->config 				= $config;
		$this->helper 				= $helper;
		$this->cache 				= $cache;
		$this->pagination 			= $pagination;
		$this->log 					= $log;
		$this->extension_manager	= $extension_manager;
		$this->root_path 			= $root_path;
		$this->php_ext 				= $php_ext;
		$this->dm_qc_table 			= $dm_qc_table;
		$this->dm_qc_config_table 	= $dm_qc_config_table;
	}

	public function handle_quotescollection()
	{
		/**
		* Exclude bots
		*/
		if ($this->user->data['is_bot'])
		{
			redirect(append_sid("{$this->root_path}index.$this->php_ext"));
		}

		/**
		* Check if user is allowed to see quotes
		*/
		if (!$this->auth->acl_get('u_dm_qc_view'))
		{
			trigger_error('NOT_AUTHORISED');
		}

		/**
		* Template variables for the navigation
		*/
		$this->template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $this->user->lang['DM_QC_TITLE'],
			'U_VIEW_FORUM'	=> $this->helper->route('dmzx_quotescollection_controller'),
		));

		/**
		* Read out the config table
		*/
		if (($dm_qc_config = $this->cache->get('_quote_config')) === false)
		{
			// Read out the config table
			$sql = 'SELECT *
				FROM ' . $this->dm_qc_config_table;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			$dm_qc_config = array(
				'qc_enable'			=> $row['qc_enable'],
				'qc_guests'			=> $row['qc_guests'],
				'show_index'		=> $row['show_index'],
				'pagination_acp'	=> $row['pagination_acp'],
				'pagination_user'	=> $row['pagination_user'],
				'approval_needed'	=> $row['approval_needed'],
				'delay_set'			=> $row['delay_set'],
				'ups_points'		=> $row['ups_points'],
			);
			// cache this data forever, can only change in ACP
			// this improves performance
			$this->cache->put('_quote_config', $dm_qc_config);
		}

		$start = $this->request->variable('start', 0);
		$number = $dm_qc_config['pagination_user'];

		$board_url = generate_board_url() . '/';

		$id = $quote = $author = $poster = $date = $approve = $approved = '';

		$mode = $this->request->variable('mode', '');

		switch ($mode)
		{
			case 'add':
				// Exclude Bots and Guests
				if ($this->user->data['is_bot'] || !$this->user->data['is_registered'] || !$this->auth->acl_get('u_dm_qc_add'))
				{
					trigger_error('NOT_AUTHORISED');
				}

				if ($this->request->is_set_post('submit'))
				{
					$id = $this->request->variable('id', 0);
					$quote = $this->request->variable('quote', '', true);
					$author = $this->request->variable('author', '', true);
					$poster = $this->user->data['user_id'];

					$uid = $bitfield = $options = '';
					$allow_bbcode = $allow_urls = $allow_smilies = true;
					generate_text_for_storage($quote, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);

					if ($dm_qc_config['approval_needed'])
					{
						$approved = 0;
					}
					else
					{
						$approved = 1;
					}

					if ($this->auth->acl_get('a_forum'))
					{
						$approved = 1;
					}

					if ($quote == '')
					{
						$message = $this->user->lang['DM_QC_QUOTE_ERROR'] . '<br /><br /><a href="' . $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'add')) . '">&laquo; ' . $this->user->lang['DM_QC_BACK_TO_PREV'] . '</a>';
						trigger_error($message);
					}

					//Make SQL Array
					$sql_ary = array(
						'quote'	=> $quote,
						'author' => $author,
						'poster' => $this->user->data['user_id'],
						'post_date' => time(),
						'approve' => $approved,
						'bbcode_bitfield' => $bitfield,
						'bbcode_uid' => $uid,
						'bbcode_options' => $options,
					);

					$this->db->sql_query('INSERT INTO ' . $this->dm_qc_table .' ' . $this->db->sql_build_array('INSERT', $sql_ary));

					// Add action to the user log
					$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_USER_QUOTE_ADDED', time(), array('reportee_id' => $this->user->data['user_id'], $this->user->data['username']));

					if ($dm_qc_config['approval_needed'] && ($dm_qc_config['ups_points'] == 0 || !defined('IN_ULTIMATE_POINTS') || !$this->config['points_enable']))
					{
						$message = $this->user->lang['DM_QC_QUOTE_SUC_APP'] . '<br /><br /><a href="' . $this->helper->route('dmzx_quotescollection_controller') . '">&laquo; ' . $this->user->lang['DM_QC_BACK_TO_MAIN'] . '</a>';
						trigger_error($message);
					}
					else
					{
						$message = $this->user->lang['DM_QC_QUOTE_SUCCESS'] . '<br /><br /><a href="' . $this->helper->route('dmzx_quotescollection_controller') . '">&laquo; ' . $this->user->lang['DM_QC_BACK_TO_MAIN'] . '</a>';
						trigger_error($message);
					}
				}
				else
				{
					// Check, if user added a quote within the last xx minutes
					if ($dm_qc_config['delay_set'] > 0)
					{
						$sql = 'SELECT post_date
							FROM ' . $this->dm_qc_table . '
							WHERE poster = ' . $this->user->data['user_id'] . '
							ORDER BY post_date DESC';
						$result = $this->db->sql_query_limit($sql, 1);
						$row = $this->db->sql_fetchrow($result);
						$last_post_date = $row['post_date'];
						$check_time = $last_post_date + (60 * $dm_qc_config['delay_set']);
						$this->db->sql_freeresult($result);

						if ($check_time > time())
						{
							// Show error
							$minutes = ($dm_qc_config['delay_set'] > 1) ? $this->user->lang['DM_QC_MINUTES'] : $this->user->lang['DM_QC_MINUTE'];
							$message = sprintf($this->user->lang['DM_QC_DELAY_ERROR'], $dm_qc_config['delay_set'], $minutes) . '<br /><br /><a href="' . $this->helper->route('dmzx_quotescollection_controller') . '">&laquo; ' . $this->user->lang['DM_QC_BACK_TO_MAIN'] . '</a>';
							trigger_error($message);
						}
					}

					$this->template->assign_vars(array(
						'S_DM_QC_ADD'	=> true,
						'ID'			=> $id,
						'QUOTE'			=> $quote,
						'AUTHOR'		=> $author,
						'POSTER'		=> $poster,
						'DATE'			=> $date,
						'APPROVED'		=> $approved,
						'U_DM_QC_MAIN' 	=> $this->helper->route('dmzx_quotescollection_controller'),
						'U_DM_QC_ADD' 	=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'add')),
						'U_DM_QC_OWN' 	=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'own')),
						'U_DM_QC_ALL' 	=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'all')),
					));
				}
			break;

			case 'own':
				// Exclude Bots and Guests
				if ($this->user->data['is_bot'] || !$this->user->data['is_registered'])
				{
					redirect(append_sid("{$this->root_path}ucp.$this->php_ext?mode=login"));
				}

				// Count number of quotes
				$sql = 'SELECT COUNT(id) AS total_quotes
					FROM ' . $this->dm_qc_table . '
					WHERE poster = ' . $this->user->data['user_id'];
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$total_quotes = $row['total_quotes'];
				$this->db->sql_freeresult($result);

				$sql = 'SELECT q.*, u.*
					FROM ' . $this->dm_qc_table . ' q
					LEFT JOIN ' . USERS_TABLE . ' u
						ON q.poster = u.user_id
					WHERE u.user_id = ' . $this->user->data['user_id'] . '
					ORDER by id';
				$result = $this->db->sql_query_limit($sql, $number, $start);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$this->template->assign_block_vars('quotes', array(
						'ID'			=> $row['id'],
						'QUOTE'			=> generate_text_for_display($row['quote'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']),
						'AUTHOR'		=> ($row['author']) ? $row['author'] : $this->user->lang['DM_QC_NO_AUTHOR'],
						'POSTER'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						'DATE'			=> $this->user->format_date($row['post_date']),
						'APPROVAL'		=> ($row['approve'] == 1) ? $this->user->lang['YES'] : $this->user->lang['NO'],
						'DELETE'		=> '<a href=" ' . $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'delete', 'id' => $row['id'])) . '"><img src="' . $board_url . 'ext/dmzx/quotescollection/styles/all/theme/images/icon_delete.gif" title="' . $this->user->lang['DM_QC_DELETE'] . '"></a>',
					));
				}
				$this->db->sql_freeresult($result);

				$pagination_url = $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'own'));
				//Start pagination
				$this->pagination->generate_template_pagination($pagination_url, 'pagination', 'start', $total_quotes, $number, $start);

				$this->template->assign_vars(array(
					'S_DM_QC_OWN'		=> true,
					'S_DELETE_QUOTE'	=> ($this->auth->acl_gets('u_dm_qc_delete')) ? true : false,
					'TOTAL_QUOTES'		=> ($total_quotes == 1) ? $this->user->lang['DM_QC_SINGLE'] : sprintf($this->user->lang['DM_QC_MULTI'], $total_quotes),
					'U_DM_QC_MAIN' 		=> $this->helper->route('dmzx_quotescollection_controller'),
					'U_DM_QC_ADD' 		=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'add')),
					'U_DM_QC_OWN' 		=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'own')),
					'U_DM_QC_ALL' 		=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'all')),
				));

			break;

			case 'delete':
				$delete_id = $this->request->variable('id', 0);
				$back_to = $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'own'));

				$s_hidden_fields = build_hidden_fields(array(
					'id'	=> $delete_id,
					'mode'	=> 'delete')
				);

				if (confirm_box(true))
				{
					$sql = 'DELETE FROM ' . $this->dm_qc_table . '
						WHERE id = ' . $delete_id;
					$this->db->sql_query($sql);

					// Add action to the user log
					$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_USER_QUOTE_DELETED', time(), array($delete_id, 'reportee_id' => $this->user->data['user_id'], $this->user->data['username']));

					trigger_error($this->user->lang['DM_QC_DELETED'] . '<br /><br />' . sprintf($this->user->lang['DM_QC_BACK'], '<a href="' . $back_to . '">', '</a>'));

				}
				else
				{
					if ($this->request->is_set_post('cancel'))
					{
						redirect($this->helper->route('dmzx_quotescollection_controller'));
					}
					else
					{
						confirm_box(false, $this->user->lang['DM_QC_REALLY_DELETE'], build_hidden_fields(array(
							'id'		=> $delete_id,
							'action'	=> 'delete',
							))
						);
					}
				}
			break;

			default:
			case 'all':
				// The sorting stuff
				$sort_days	= $this->request->variable('st', 0);
				$sort_key	= $this->request->variable('sk', 'quote');
				$sort_dir	= $this->request->variable('sd', 'ASC');
				$limit_days = array(0 => $this->user->lang['DM_QC_ALL_QUOTES'], 1 => $this->user->lang['1_DAY'], 7 => $this->user->lang['7_DAYS'], 14 => $this->user->lang['2_WEEKS'], 30 => $this->user->lang['1_MONTH'], 90 => $this->user->lang['3_MONTHS'], 180 => $this->user->lang['6_MONTHS'], 365 => $this->user->lang['1_YEAR']);

				$sort_by_text	= array('a' => $this->user->lang['DM_QC_SORT_AUTHOR'], 'p' => $this->user->lang['DM_QC_SORT_POSTER'], 't' => $this->user->lang['DM_QC_SORT_DATE']);
				$sort_by_sql 	= array('a' => 'LOWER(q.author)', 'p' => 'u.username_clean', 't' => 'q.post_date');

				$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
				$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

				// Count number of quotes
				$sql = 'SELECT COUNT(id) AS total_quotes
					FROM ' . $this->dm_qc_table . '
					WHERE approve = 1';
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$total_quotes = $row['total_quotes'];
				$this->db->sql_freeresult($result);

				$sql = 'SELECT q.*, u.*
					FROM ' . $this->dm_qc_table . ' q
					LEFT JOIN ' . USERS_TABLE . ' u
					ON q.poster = u.user_id
					WHERE q.approve = 1
					ORDER BY ' . $sql_sort_order;
				$results = $this->db->sql_query_limit($sql, $number, $start);

				while ($row = $this->db->sql_fetchrow($results))
				{
					$this->template->assign_block_vars('quotes_all', array(
						'ID'			=> $row['id'],
						'QUOTE'			=> generate_text_for_display($row['quote'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']),
						'AUTHOR'		=> ($row['author']) ? $row['author'] : $this->user->lang['DM_QC_NO_AUTHOR'],
						'POSTER'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						'DATE'			=> $this->user->format_date($row['post_date']),
					));
				}
				$this->db->sql_freeresult($results);

				$pagination_url = $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'all'));
				//Start pagination
				$this->pagination->generate_template_pagination($pagination_url, 'pagination', 'start', $total_quotes, $number, $start);

				$this->template->assign_vars(array(
					'S_DM_QC_ALL'		=> true,
					'S_QUOTE_ACTION' 	=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'all')),
					'S_SELECT_SORT_DIR'	=> $s_sort_dir,
					'S_SELECT_SORT_KEY'	=> $s_sort_key,
					'TOTAL_QUOTES'		=> ($total_quotes == 1) ? $this->user->lang['DM_QC_SINGLE'] : sprintf($this->user->lang['DM_QC_MULTI'], $total_quotes),
					'U_DM_QC_MAIN' 		=> $this->helper->route('dmzx_quotescollection_controller'),
					'U_DM_QC_ADD' 		=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'add')),
					'U_DM_QC_OWN' 		=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'own')),
					'U_DM_QC_ALL' 		=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'all')),
				));

			break;
		}

		$this->template->assign_vars(array(
			'S_VIEW_QUOTE'		=> ($this->auth->acl_gets('u_dm_qc_view')) ? true : false,
			'S_ADD_QUOTE'		=> ($this->auth->acl_gets('u_dm_qc_add')) ? true : false,
			'DM_QC_VERSION'		=> $this->config['dm_qc_version'],
			'DM_QC_FOOTER_VIEW'	=> true,
		));
		$this->assign_authors();

		return $this->helper->render('dmbody.html', $this->user->lang('DM_QC_TITLE'));
	}

	protected function assign_authors()
	{
		$md_manager = $this->extension_manager->create_extension_metadata_manager('dmzx/quotescollection', $this->template);
		$meta = $md_manager->get_metadata();
		$author_names = array();
		$author_homepages = array();

		foreach (array_slice($meta['authors'], 0, 1) as $author)
		{
			$author_names[] = $author['name'];
			$author_homepages[] = sprintf('<a href="%1$s" title="%2$s">%2$s</a>', $author['homepage'], $author['name']);
		}
		$this->template->assign_vars(array(
			'DM_QC_DISPLAY_NAME'		=> $meta['extra']['display-name'],
			'DM_QC_AUTHOR_NAMES'		=> implode(' &amp; ', $author_names),
			'DM_QC_AUTHOR_HOMEPAGES'	=> implode(' &amp; ', $author_homepages),
		));
	}
}
