<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\quotescollection\migrations;

class quotescollection_106 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\dmzx\quotescollection\migrations\quotescollection_105',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('dm_qc_version', '1.0.6')),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'dm_qc_config'	=> array(
					'qc_enable_viewforum'	=> array('TINT:1', 0),
					'qc_enable_viewtopic'	=> array('TINT:1', 0),
				),
			),
		);
	}
}
