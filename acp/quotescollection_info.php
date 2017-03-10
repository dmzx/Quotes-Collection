<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\quotescollection\acp;

class quotescollection_info
{
	function module()
	{
		return array(
			'filename'		=> '\dmzx\quotescollection\acp\quotescollection_module',
			'title'			=> 'ACP_DM_QC',
			'modes'			=> array(
				'config'			=> array('title' => 'ACP_DM_QC_CONFIG', 'auth' => 'ext_dmzx/quotescollection && acl_a_board', 'cat' => array('ACP_DM_QC')),
				'edit_quotes'		=> array('title' => 'ACP_DM_QC_EDIT', 'auth' => 'ext_dmzx/quotescollection && acl_a_board', 'cat' => array('ACP_DM_QC')),
				'release_quotes'	=> array('title' => 'ACP_DM_QC_RELEASE', 'auth' => 'ext_dmzx/quotescollection && acl_a_board', 'cat' => array('ACP_DM_QC')),
			),
		);
	}
}
