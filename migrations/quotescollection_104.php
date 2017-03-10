<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\quotescollection\migrations;

class quotescollection_104 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\dmzx\quotescollection\migrations\quotescollection_103',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('dm_qc_version', '1.0.4')),
		);
	}
}
