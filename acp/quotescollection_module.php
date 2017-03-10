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
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $user;

		// Add the ACP lang file
		$user->add_lang_ext('dmzx/quotescollection', 'acp_quotescollection');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('dmzx.quotescollection.controller.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		switch ($mode)
		{
			case 'config':
				$this->page_title = $user->lang['ACP_DM_QC_CONFIG'];
				$this->tpl_name = 'acp_dm_qc';
				$admin_controller->display_config();
			break;
			case 'edit_quotes':
				$this->page_title = $user->lang['ACP_DM_QC_EDIT'];
				$this->tpl_name = 'acp_dm_qc';
				$admin_controller->display_edit_quotes();
			break;
			case 'release_quotes':
				$this->page_title = $user->lang['ACP_DM_QC_RELEASE'];
				$this->tpl_name = 'acp_dm_qc';
				$admin_controller->display_release_quotes();
			break;
		}
	}
}
