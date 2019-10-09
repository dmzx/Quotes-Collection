<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2019 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\quotescollection\migrations;

class quotescollection_107 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\quotescollection\migrations\quotescollection_106',
		];
	}

	public function update_data()
	{
		return [
			['config.update', ['dm_qc_version', '1.0.7']],
		];
	}
}
