<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\quotescollection\migrations;

class quotescollection_install extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['dm_qc_version']) && version_compare($this->config['dm_qc_version'], '1.0.2', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v311');
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('dm_qc_version', '1.0.2')),
			// Add permissions
			array('permission.add', array('u_dm_qc_add', true)),
			array('permission.add', array('u_dm_qc_view', true)),
			array('permission.add', array('u_dm_qc_delete', true)),
			array('permission.add', array('a_dm_qc_manage', true)),
			// Set permissions
			array('permission.permission_set', array('GUESTS', 'u_dm_qc_view', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_dm_qc_view', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_dm_qc_add', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_dm_qc_delete', 'group')),
			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_DM_QC'
			)),
			array('module.add', array(
				'acp',
				'ACP_DM_QC',
				array(
					'module_basename'	=> '\dmzx\quotescollection\acp\quotescollection_module',
					'modes' => array(
						'config',
						'edit_quotes',
						'release_quotes'
					),
				),
			)),
			// Insert sample data
			array('custom', array(
				array(&$this, 'insert_sample_data')
			)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'dm_qc'	=> array(
					'COLUMNS'	=> array(
						'id'				=> array('UINT:11', null, 'auto_increment'),
						'quote'				=> array('MTEXT_UNI', ''),
						'author'			=> array('VCHAR', ''),
						'poster'			=> array('UINT:11', 0),
						'post_date'			=> array('UINT:11', 0),
						'approve'			=> array('TINT:1', 0),
						'bbcode_bitfield'	=> array('VCHAR', ''),
						'bbcode_uid'		=> array('VCHAR:8', ''),
						'bbcode_options'	=> array('UINT:4', 0),
					),
					'PRIMARY_KEY'	=> 'id',
				),
				$this->table_prefix . 'dm_qc_config'	=> array(
					'COLUMNS'	=> array(
						'pagination_acp'	=> array('TINT:3', 0),
						'pagination_user'	=> array('TINT:3', 0),
						'approval_needed'	=> array('TINT:1', 0),
						'qc_enable'			=> array('TINT:1', 0),
						'qc_guests'			=> array('TINT:1', 0),
						'ups_points'		=> array('DECIMAL', 0.00),
						'show_index'		=> array('TINT:1', 0),
						'delay_set'			=> array('UINT:8', 0),
					),
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_tables' => array(
				$this->table_prefix . 'dm_qc',
				$this->table_prefix . 'dm_qc_config',
			),
		);
	}

	public function insert_sample_data()
	{
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'dm_qc_config'))
		{
			$sql_ary = array(
				array(
					'pagination_acp' 	=> '5',
					'pagination_user'	=> '5',
					'approval_needed' 	=> '1',
					'qc_enable' 		=> '1',
					'qc_guests' 		=> '1',
					'ups_points' 		=> '0',
					'show_index' 		=> '1',
					'delay_set'			=> '0',
				),
			);
			// Insert sample data
			$this->db->sql_multi_insert($this->table_prefix . 'dm_qc_config', $sql_ary);
		}
	}
}
