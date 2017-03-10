<?php
/**
*
* @version $Id: acp_quotescollection.php 71 2017-03-10 14:33:53Z Scanialady $
* @package phpBB Extension - Quotes Collection (deutsch)
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
	'ACP_DM_QC_ALL'						=> 'Alle',
	'ACP_DM_QC_SORT_ID'					=> 'ID',
	'ACP_DM_QC_SORT_AUTHOR'				=> 'Autor',
	'ACP_DM_QC_SORT_DATE'				=> 'Datum',
	'ACP_DM_QC_SORT_APPROVAL'			=> 'Genehmigt',
	'ACP_DM_QC_SORT_POSTER'				=> 'Verfasser',
	'ACP_DM_QC_SINGLE'					=> '1 Zitat',
	'ACP_DM_QC_MULTI'					=> '%1$s Zitate',
	'ACP_DM_QC_RELEASE'					=> 'Zitate freischalten',
	'ACP_DM_QC_RELEASE_EXPLAIN'			=> 'Hier kannst du Zitate veröffentlichen',
	'ACP_DM_QC_CONFIG_EXPLAIN'			=> 'Hier kannst du einige Grundwerte einstellen',
	'ACP_DM_QC_APPROVAL'				=> 'Zitate erfordern eine Genehmigung',
	'ACP_DM_QC_APPROVAL_EXPLAIN'		=> 'Möchtest du jedes Zitat genehmigen?',
	'ACP_DM_QC_PAGI_ACP'				=> 'Anzahl Zitate pro Seite (ACP)',
	'ACP_DM_QC_PAGI_ACP_EXPLAIN'		=> 'Anzahl an Zitaten, die du im ACP je Seite angezeigt haben möchtest.',
	'ACP_DM_QC_PAGI_USER'				=> 'Anzahl Zitate pro Benutzerseite',
	'ACP_DM_QC_PAGI_USER_EXPLAIN'		=> 'Anzahl an Zitaten, die Benutzer je Seite sehen können, wenn sie auswählen, dass alle Zitate angezeigt werden sollen',
	'ACP_DM_QC_PAGE_ERROR'				=> 'Du kannst keinen Wert unterhalb von 5 für die Anzahl der Zitate pro Seite im ACP oder auf den Benutzerseiten eingeben',
	'ACP_DM_QC_ENABLE'					=> 'Aktiviere DM Zitatesammlung',
	'ACP_DM_QC_ENABLE_EXPLAIN'			=> 'Möchtest du DM Zitatesammlung einschalten?',
	'ACP_DM_QC_INDEX'					=> 'Zitate auf dem Index',
	'ACP_DM_QC_INDEX_EXPLAIN'			=> 'Möchtest du ein zufälliges Zitat auf der Forenhauptseite sehen?',
	'ACP_DM_QC_GUESTS'					=> 'Zitate für Gäste',
	'ACP_DM_QC_GUESTS_EXPLAIN'			=> 'Möchtest du, dass Gäste die Zitate sehen können?',
	'ACP_DM_QC_CONFIG_SUCCESS'			=> 'Die Konfiguration wurde erfolgreich aktualisiert',
	'ACP_DM_QC_EDIT'					=> 'Zitate bearbeiten',
	'ACP_DM_QC_EDIT_EXPLAIN'			=> 'Hier kannst du Zitate hinzufügen, löschen oder bearbeiten',
	'ACP_DM_QC_EDIT_QUOTE_EXPLAIN'		=> 'Hier kannst du das ausgewählte Zitat bearbeiten',
	'ACP_DM_QC_ID'						=> 'ID',
	'ACP_DM_QC_QUOTE'					=> 'Zitat',
	'ACP_DM_QC_QUOTE_EXPLAIN'			=> 'Gib hier dein Zitat ein',
	'ACP_DM_QC_AUTHOR'					=> 'Autor',
	'ACP_DM_QC_AUTHOR_EXPLAIN'			=> 'Gib hier den Originalautor des Zitats ein',
	'ACP_DM_QC_POSTER'					=> 'beigetragen von',
	'ACP_DM_QC_DATE'					=> 'gesendet am',
	'ACP_DM_QC_APPROVE'					=> 'Aktiviert',
	'ACP_DM_QC_APPROVE_EXPLAIN'			=> 'Hier kannst du das Zitat aktivieren',
	'ACP_DM_QC_ADD'						=> 'Neues Zitat hinzufügen',
	'ACP_DM_QC_ADD_EXPLAIN'				=> 'Hier kannst du neue Zitate hinzufügen. Sei so gut und fülle alle Felder aus!',
	'ACP_DM_QC_ADDED'					=> 'Das Zitat wurde erfolgreich hinzugefügt',
	'ACP_DM_QC_DELETED'					=> 'Der Eintrag wurde erfolgreich gelöscht',
	'ACP_DM_QC_REALY_DELETE'			=> 'Bist du sicher, dass du den ausgewählten Eintrag löschen möchtest?',
	'ACP_DM_QC_NEED_DATA'				=> 'Du musst mindestens das Zitat selbst eingeben ....',
	'ACP_DM_QC_UPDATED'					=> 'Der Eintrag wurde erfolgreich aktualisiert',
	'ACP_DM_QC_NO_QUOTES'				=> 'Keine Zitate verfügbar',
	'NOT_UPLOADED'						=> '',
	'ACP_DM_QC_DELAY'					=> 'Zeitraum',
	'ACP_DM_QC_DELAY_EXPLAIN'			=> 'Hier kannst du einen Zeitraum in Minuten einstellen, bevor ein Benutzer ein neues Zitat hinzufügen kann. Gib 0 ein, um diese Option zu deaktivieren.',
	'ACP_DM_QC_MINUTE'					=> 'Minute',
	'ACP_DM_QC_MINUTES'					=> 'Minuten',
));
