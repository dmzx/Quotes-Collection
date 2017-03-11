<?php
/**
*
* @package phpBB Extension - Quotes Collection
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* Nederlandse vertaling @ Solidjeuh <https://www.froddelpower.be>
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
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'DM_QC_TITLE'				=> 'DM Citaten Collectie',
	'DM_QC_HEADER'				=> 'Willekeurig citaat',
	'DM_QC_QUOTE_TITLE'			=> 'Citaten',
	'DM_QC_ADD'					=> 'Voeg citaat toe',
	'DM_QC_OWN'					=> 'Eigen citaten',
	'DM_QC_ALL'					=> 'Toon alle citaten',
	'DM_QC_NO_AUTHOR'			=> 'Onbekende auteur',
	'DM_QC_QUOTE_AUTHOR'		=> 'door %1$s',
	'DM_QC_QUOTE'				=> 'Citaat',
	'DM_QC_QUOTE_EXPLAIN'		=> 'Plaats hier je citaat',
	'DM_QC_QUOTES'				=> '<strong>Citaat:</strong>',
	'DM_QC_AUTHOR'				=> 'Auteur',
	'DM_QC_AUTHOR_EXPLAIN'		=> 'Plaats hier de auteur van het citaat. Indien je dit niet weet kan je het veld leeg laten.',
	'DM_QC_POSTER'				=> 'Gepost door',
	'DM_QC_DATE'				=> 'Gepost op',
	'DM_QC_SINGLE'				=> '1 citaat',
	'DM_QC_MULTI'				=> ' %1$s citaten',
	'DM_QC_NO_QUOTES'			=> 'Er zijn geen citaten om weer te geven.',
	'DM_QC_ALL_TITLE'			=> 'Toon alle citaten',
	'DM_QC_ALL_TITLE_DESC'		=> 'Hier kan je alle goedgekeurde citaten bekijken.<br /><br />',
	'DM_QC_OWN_TITLE'			=> 'Eigen citaten',
	'DM_QC_OWN_TITLE_DESC'		=> 'Hier kan je alle citaten bekijken die jij gepost hebt. Je kan ook zien of er nog niet goedgekeurde citaten zijn van jou.<br /><br />',
	'DM_QC_ADD_TITLE'			=> 'Voeg citaat toe',
	'DM_QC_ADD_TITLE_DESC'		=> 'Hier kan je je eigen citaten toevoegen. Typ op zijn minst het citaat! Indien je weet van wie het citaat is, vul dit dan ook in aub!<br /><br />',
	'DM_QC_APPROVAL'			=> 'Goedgekeurd',
	'DM_QC_QUOTE_ERROR'			=> 'Je moet op zijn minst het citaat invullen!',
	'DM_QC_BACK_TO_PREV'		=> 'Terug naar de laatste pagina',
	'DM_QC_QUOTE_SUCCESS'		=> 'Je opgave werd succesvol toegevoegd<br /><br />',
	'DM_QC_QUOTE_SUC_APP'		=> 'Je opgave werd succesvol toegevoegd, maar moet nog goedgekeurd worden alvorens deze zichtbaar is.<br /><br />',
	'DM_QC_BACK_TO_MAIN'		=> 'Terug naar de DM Citaten Collectie',
	'DM_QC_CHECK_QUOTE'			=> 'Er is <strong>1</strong> nieuw citaat beschikbaar dat wacht op vrijgave!',
	'DM_QC_CHECK_QUOTES'		=> 'Er zijn <strong>%1$s</strong> citaten beschikbaar die wachten op vrijgave!',
	'DM_QC_CHECK_ACP'			=> 'Klik %shier%s om naar jouw ACP te gaan.',
	'DM_QC_POSTED_BY'			=> 'Gepost door %1$s',
	'DM_QC_OPTIONS'				=> 'Opties',
	'DM_QC_QUOTE_SUC_UPS' 		=> 'Super bedankt om een citaat te posten!<br />We hebben %1$s %2$s overgeschreven op je account!',
	'DM_QC_QUOTE_SUC_UPS_APP' 	=> 'Super bedankt om een citaat te posten!<br />Van zodra een beheerder deze vrijgeeft zullen we %1$s %2$s overschrijven naar jouw account!',
	'DM_QC_DELETE'				=> 'Verwijder citaat',
	'DM_QC_DELETED'				=> 'Het citaat werd succesvol verwijderd.',
	'DM_QC_REALLY_DELETE'		=> 'Ben je zeker dat je het geselecteerde citaat wenst te verwijderen?',
	'DM_QC_BACK'				=> 'Klik %shier%s om terug te keren naar de laatste pagina',
	'DM_QC_DELAY_ERROR'			=> 'Sorry. De configuratie van de DM Citaten Collectie zegt dat je maar om de <strong>%1$s %2$s</strong> een citaat kan toevoegen. Gelieve later opnieuw te proberen.',
	'DM_QC_MINUTES'				=> 'minuten',
	'DM_QC_MINUTE'				=> 'minuut',
	'DM_QC_ALL_QUOTES'			=> 'Alle',
	'DM_QC_SORT_AUTHOR'			=> 'Auteur',
	'DM_QC_SORT_POSTER'			=> 'Poster',
	'DM_QC_SORT_DATE'			=> 'Datum',
	'DM_QC_VERSION'				=> 'Versie',
	'QUOTE_COLLAPSE_TITLE'		=> 'Klap citaten uit',
));
