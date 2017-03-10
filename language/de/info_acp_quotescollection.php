<?php
/**
*
* @version $Id: info_acp_quotescollection.php 71 2017-03-10 14:33:53Z Scanialady $
* @package phpBB Extension - Quotes Collection (DEUTSCH)
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
//	‚ ‘ ’ « » „ “ ” …
//

$lang = array_merge($lang, array(
	'ACP_DM_QC'							=> 'DM Quotes Collection',
	'ACP_DM_QC_CONFIG'					=> 'Konfiguration',
	'ACP_DM_QC_RELEASE'					=> 'Zitate freigeben',
	'ACP_DM_QC_EDIT'					=> 'Zitate bearbeiten',
	//Log
	'LOG_DM_QC_CONFIG_SETTINGS'			=> '<strong>DM QC Konfiguration aktualisiert</strong>',
	'LOG_MODIFICATION_ADDED'			=> '<strong>Modifikation hinzugefügt</strong><br />» %s',
	'LOG_MODIFICATION_REMOVED'			=> '<strong>Modifikation entfernt</strong><br />» %s',
	'LOG_USER_QUOTE_ADDED'				=> '<strong>Zitat hinzugefügt</strong>',
	'LOG_USER_QUOTE_DELETED'			=> '<strong>Zitat Nr. %s gelöscht</strong>',
	'LOG_ADMIN_QUOTE_ADDED'				=> '<strong>Zitat hinzugefügt</strong>',
	'LOG_ADMIN_QUOTE_EDITED'			=> '<strong>Zitat Nr. %s bearbeitet</strong>',
	'LOG_ADMIN_QUOTE_DELETED'			=> '<strong>Zitat Nr. %s gelöscht</strong>',
	'LOG_ADMIN_QUOTE_RELEASED'			=> '<strong>Zitat Nr. %s freigegeben</strong>',
));
