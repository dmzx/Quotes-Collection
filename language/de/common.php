<?php
/**
*
* @version $Id: common.php 71 2017-03-10 14:33:53Z Scanialady $
* @package phpBB Extension - Quotes Collection (deutsch)
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
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
	'DM_QC_TITLE'				=> 'DM Quotes Collection',
	'DM_QC_HEADER'				=> 'Zufälliges Zitat',
	'DM_QC_QUOTE_TITLE'			=> 'Zitate',
	'DM_QC_ADD'					=> 'Zitat hinzufügen',
	'DM_QC_OWN'					=> 'Eigene Zitate',
	'DM_QC_ALL'					=> 'Zeige alle Zitate',
	'DM_QC_NO_AUTHOR'			=> 'Unbekannter Autor',
	'DM_QC_QUOTE_AUTHOR'		=> 'von %1$s',
	'DM_QC_QUOTE'				=> 'Zitat',
	'DM_QC_QUOTE_EXPLAIN'		=> 'Gib hier dein Zitat ein',
	'DM_QC_QUOTES'				=> '<strong>Zitat:</strong>',
	'DM_QC_AUTHOR'				=> 'Autor',
	'DM_QC_AUTHOR_EXPLAIN'		=> 'Gib hier den Autor des Zitats ein. Wenn du nicht weisst, wer es war, dann lasse das Feld leer.',
	'DM_QC_POSTER'				=> 'Beitrag von',
	'DM_QC_DATE'				=> 'Gesendet am',
	'DM_QC_SINGLE'				=> '1 Zitat',
	'DM_QC_MULTI'				=> ' %1$s Zitate',
	'DM_QC_NO_QUOTES'			=> 'Keine Zitate zum anzeigen vorhanden.',
	'DM_QC_ALL_TITLE'			=> 'Zeige alle Zitate',
	'DM_QC_ALL_TITLE_DESC'		=> 'Hier kannst du alle genehmigten Zitate sehen.<br /><br />',
	'DM_QC_OWN_TITLE'			=> 'Eigene Zitate',
	'DM_QC_OWN_TITLE_DESC'		=> 'Hier kannst du alle Zitate sehen, welche du selbst beigetragen hast. Du kannst ausserdem sehen, ob da noch ein ungenehmigtes Zitat von dir ist.<br /><br />',
	'DM_QC_ADD_TITLE'			=> 'Zitate hinzufügen',
	'DM_QC_ADD_TITLE_DESC'		=> 'Hier kannst du deine eigenen Zitate hinzufügen. Gib bitte mindestens das Zitat ein. Wenn du weisst, von wem es stammt, gib das bitte auch ein!<br /><br />',
	'DM_QC_APPROVAL'			=> 'Genehmigt',
	'DM_QC_QUOTE_ERROR'			=> 'Du musst schon mindestens das Zitat selbst eingeben!',
	'DM_QC_BACK_TO_PREV'		=> 'Zurück zur letzten Seite',
	'DM_QC_QUOTE_SUCCESS'		=> 'Dein Eintrag wurde erfolgreich hinzugefügt<br /><br />',
	'DM_QC_QUOTE_SUC_APP'		=> 'Dein Eintrag wurde erfolgreich hinzugefügt, doch er muss noch genehmigt werden, ehe er sichtbar wird.<br /><br />',
	'DM_QC_BACK_TO_MAIN'		=> 'Zurück zu DM Quotes Collection',
	'DM_QC_CHECK_QUOTE'			=> 'Es ist <strong>ein</strong> neues Zitat verfügbar, welches auf Freischaltung wartet!',
	'DM_QC_CHECK_QUOTES'		=> 'Es sind <strong>%1$s</strong> neue Zitate verfügbar, welche auf Freischaltung warten!',
	'DM_QC_CHECK_ACP'			=> 'Klicke %shier%s, um ins ACP zu gehen.',
	'DM_QC_POSTED_BY'			=> 'Beigetragen von %1$s',
	'DM_QC_OPTIONS'				=> 'Optionen',
	'DM_QC_QUOTE_SUC_UPS' 		=> 'Vielen Dank für deinen Zitatbeitrag!<br />Wir haben dir dafür eine Belohnung von %1$s %2$s auf dein Konto gezahlt!',
	'DM_QC_QUOTE_SUC_UPS_APP' 	=> 'Vielen Dank für deinen Zitatbeitrag!<br />Sobald ein Administrator das Zitat freischaltet, werden wir dir dafür eine Belohung von %1$s %2$s auf dein Konto zahlen!',
	'DM_QC_DELETE'				=> 'Zitat löschen',
	'DM_QC_DELETED'				=> 'Das Zitat wurde erfolgreich gelöscht.',
	'DM_QC_REALLY_DELETE'		=> 'Bist du sicher, dass du das gewählte Zitat löschen möchtest?',
	'DM_QC_BACK'				=> 'Klicke %shier%s, um zur letzten Seite zurückzukehren',
	'DM_QC_DELAY_ERROR'			=> 'Tut mir leid. Die Konfiguration der DM Quote Collection besagt, dass du neue Zitate nur alle <strong>%1$s %2$s</strong> eintragen darfst. Versuche es bitte später noch einmal.',
	'DM_QC_MINUTES'				=> 'Minuten',
	'DM_QC_MINUTE'				=> 'Minute',
	'DM_QC_ALL_QUOTES'			=> 'Alle',
	'DM_QC_SORT_AUTHOR'			=> 'Autor',
	'DM_QC_SORT_POSTER'			=> 'Verfasser',
	'DM_QC_SORT_DATE'			=> 'Datum',
	'DM_QC_VERSION'			 	=> 'Version',
	'QUOTE_COLLAPSE_TITLE'		=> 'Zitate zuklappen',
));
