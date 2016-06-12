<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\quotescollection\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $phpEx;

	/** @var string */
	protected $dm_qc_table;

	/** @var string */
	protected $dm_qc_config_table;

	/**
	* Constructor
	*
	* @param \phpbb\user						$user
	* @param \phpbb\template\template			$template
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\auth\auth					$auth
	* @param \phpbb\controller\helper			$helper
	* @param \phpbb\cache\service		 		$cache
	* @param									$phpbb_root_path
	* @param									$phpEx
	* @param									$dm_qc_table
	* @param									$dm_qc_config_table
	*
	*/
	public function __construct(\phpbb\user $user, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\cache\service $cache, $phpbb_root_path, $phpEx, $dm_qc_table, $dm_qc_config_table)
	{
		$this->user					= $user;
		$this->template				= $template;
		$this->db					= $db;
		$this->auth 				= $auth;
		$this->helper 				= $helper;
		$this->cache 				= $cache;
		$this->phpbb_root_path 		= $phpbb_root_path;
		$this->phpEx 				= $phpEx;
		$this->dm_qc_table 			= $dm_qc_table;
		$this->dm_qc_config_table 	= $dm_qc_config_table;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=> 'load_language_on_setup',
			'core.permissions'					=> 'add_permission',
			'core.page_header'					=> 'page_header',
			'core.index_modify_page_title'		=> 'index_modify_page_title',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'dmzx/quotescollection',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_dm_qc_add'] = array('lang' => 'ACL_U_DM_QC_ADD', 'cat' => 'misc');
		$permissions['u_dm_qc_view'] = array('lang' => 'ACL_U_DM_QC_VIEW', 'cat' => 'misc');
		$permissions['u_dm_qc_delete'] = array('lang' => 'ACL_U_DM_QC_DELETE', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	public function page_header($event)
	{
		$this->template->assign_vars(array(
			'S_QC_EXIST'	=> true,
			'L_DM_QUOTES'	=> $this->user->lang['DM_QC_QUOTE_TITLE'],
			'U_DM_QUOTES'	=> $this->helper->route('dmzx_quotescollection_controller'),
		));
	}
	public function index_modify_page_title($event)
	{

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

		$sql = 'SELECT COUNT(id) AS number_quotes
			FROM ' . $this->dm_qc_table . '
			WHERE APPROVE = 0';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$number_quotes = $row['number_quotes'];
		$this->db->sql_freeresult($result);

		$sql = 'SELECT *
			FROM ' . $this->dm_qc_table . '
			WHERE APPROVE = 0';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row && $this->auth->acl_gets('a_dm_qc_manage') && $number_quotes == 1)
		{
			$go_acp = append_sid($this->phpbb_root_path . 'adm/index.' . $this->phpEx . '?sid=' . $this->user->session_id, 'i=-dmzx-quotescollection-acp-quotescollection_module&mode=release_quotes', true);
			$this->template->assign_vars(array(
				'S_ADMIN_CHECK'	=> true,
				'NUMBER_QUOTES'	=> $this->user->lang['DM_QC_CHECK_QUOTE'],
				'GO_ACP'		=> sprintf($this->user->lang['DM_QC_CHECK_ACP'], '<a href="' . $go_acp . '">', '</a>'),
			));
		}
		else if ($row && $this->auth->acl_gets('a_dm_qc_manage') && $number_quotes > 1)
		{
			$go_acp = append_sid($this->phpbb_root_path . 'adm/index.' . $this->phpEx . '?sid=' . $this->user->session_id, 'i=-dmzx-quotescollection-acp-quotescollection_module&mode=release_quotes', true);
			$this->template->assign_vars(array(
				'S_ADMIN_CHECK'	=> true,
				'NUMBER_QUOTES'	=> sprintf($this->user->lang['DM_QC_CHECK_QUOTES'], $number_quotes),
				'GO_ACP'		=> sprintf($this->user->lang['DM_QC_CHECK_ACP'], '<a href="' . $go_acp . '">', '</a>'),
			));
		}
		$sql_layer = $this->db->get_sql_layer();
		switch ($sql_layer)
		{
			case 'postgres':
				$order_by = 'RANDOM()';
			break;

			case 'mssql':
			case 'mssql_odbc':
				$order_by = 'NEWID()';
			break;

			default:
				$order_by = 'RAND()';
			break;
		}

		$sql = 'SELECT q.*, u.*
			FROM ' . $this->dm_qc_table . ' q
			LEFT JOIN ' . USERS_TABLE . ' u
				on q.poster = u.user_id
			WHERE APPROVE = 1
			ORDER BY ' . $order_by;
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);

		if (!$row || !$row['approve'])
		{
			return;
		}
		else
		{
			$quote = $row['quote'];
			$author = ($row['author'] == '') ? $this->user->lang['DM_QC_NO_AUTHOR'] : sprintf($this->user->lang['DM_QC_QUOTE_AUTHOR'], $row['author']);
			$poster = get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);

			if ($dm_qc_config['qc_enable'])
			{
				$this->template->assign_vars(array(
					'S_DM_QUOTES_ENABLE' => true,
				));
			}

			if ($dm_qc_config['qc_guests'])
			{
				$this->template->assign_vars(array(
					'S_DM_GUESTS_ENABLE' => true,
				));
			}

			if ($dm_qc_config['show_index'])
			{
				$this->template->assign_vars(array(
					'S_DM_SHOW_INDEX' => true,
				));
			}

			$this->template->assign_vars(array(
				'S_VIEW_QUOTE'	=> ($this->auth->acl_gets('u_dm_qc_view')) ? true : false,
				'S_ADD_QUOTE'	=> ($this->auth->acl_gets('u_dm_qc_add')) ? true : false,
				'QUOTE'			=> generate_text_for_display($row['quote'], $row['bbcode_uid'], $row['bbcode_bitfield'], $row['bbcode_options']),
				'AUTHOR'		=> $author,
				'POSTED_BY'		=> sprintf($this->user->lang['DM_QC_POSTED_BY'], $poster),
				'U_MAIN_QUOTE'	=> $this->helper->route('dmzx_quotescollection_controller'),
				'U_ADD_QUOTE'	=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'add')),
				'U_OWN_QUOTES'	=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'own')),
				'U_ALL_QUOTES'	=> $this->helper->route('dmzx_quotescollection_controller', array('mode' => 'all')),
			));

			return;
		}
	}
}
