<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* Nederlandse vertaling @ Solidjeuh <https://www.froddelpower.be>
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
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_DM_QC'							=> 'DM Citaten Collectie',
	'ACP_DM_QC_CONFIG'					=> 'Configuratie',
	'ACP_DM_QC_RELEASE'					=> 'Citaten vrijgeven',
	'ACP_DM_QC_EDIT'					=> 'Bewerk citaten',
	//Log
	'LOG_DM_QC_CONFIG_SETTINGS'			=> '<strong>DM Citaten Collectie geupdate</strong>',
	'LOG_MODIFICATION_ADDED'			=> '<strong>Modificatie toegevoegd</strong><br />» %s',
	'LOG_MODIFICATION_REMOVED'			=> '<strong>Modificatie verwijderd</strong><br />» %s',
	'LOG_USER_QUOTE_ADDED'				=> '<strong>Citaat toegevoegd</strong>',
	'LOG_USER_QUOTE_DELETED'			=> '<strong>Citaat nr. %s verwijderd</strong>',
	'LOG_ADMIN_QUOTE_ADDED'				=> '<strong>Citaat toegevoegd</strong>',
	'LOG_ADMIN_QUOTE_EDITED'			=> '<strong>Citaat nr. %s bewerkt</strong>',
	'LOG_ADMIN_QUOTE_DELETED'			=> '<strong>Citaat nr. %s verwijderd</strong>',
	'LOG_ADMIN_QUOTE_RELEASED'			=> '<strong>Citaat nr. %s vrijgegeven</strong>',
));
