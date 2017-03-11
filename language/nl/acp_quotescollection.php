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
	'ACP_DM_QC_ALL'						=> 'Alle',
	'ACP_DM_QC_SORT_ID'					=> 'ID',
	'ACP_DM_QC_SORT_AUTHOR'				=> 'Auteur',
	'ACP_DM_QC_SORT_DATE'				=> 'Datum',
	'ACP_DM_QC_SORT_APPROVAL'			=> 'Goedgekeurd',
	'ACP_DM_QC_SORT_POSTER'				=> 'Poster',
	'ACP_DM_QC_SINGLE'					=> '1 Citaat',
	'ACP_DM_QC_MULTI'					=> '%1$s citaten',
	'ACP_DM_QC_RELEASE'					=> 'Citaten vrijgeven',
	'ACP_DM_QC_RELEASE_EXPLAIN'			=> 'Hier kan je citaten vrijgeven',
	'ACP_DM_QC_CONFIG_EXPLAIN'			=> 'Hier kan je enkele basis waarden instellen',
	'ACP_DM_QC_APPROVAL'				=> 'Citaten vereisen goedkeuring',
	'ACP_DM_QC_APPROVAL_EXPLAIN'		=> 'Wil je alle citaten goedkeuren?',
	'ACP_DM_QC_PAGI_ACP'				=> 'Aantal citaten per pagina (ACP)',
	'ACP_DM_QC_PAGI_ACP_EXPLAIN'		=> 'Aantal citaten die je wenst te zien in het ACP',
	'ACP_DM_QC_PAGI_USER'				=> 'Aantal citaten op gebruikers pagina',
	'ACP_DM_QC_PAGI_USER_EXPLAIN'		=> 'Aantal citaten die gebruikers zullen zien indien ze selecteren om alle citaten te bekijken',
	'ACP_DM_QC_PAGE_ERROR'				=> 'Je kan geen waarde kiezen lager dan 5 voor het aantal citaten per pagina in het ACP of op de gebruikers pagina',
	'ACP_DM_QC_ENABLE'					=> 'Schakel DM Citaten collectie in',
	'ACP_DM_QC_ENABLE_EXPLAIN'			=> 'Wens je de DM Citaten collectie in te schakelen?',
	'ACP_DM_QC_INDEX'					=> 'Citaat op index',
	'ACP_DM_QC_INDEX_EXPLAIN'			=> 'Wil je een willekeurig citaat zien op de index pagina?',
	'ACP_DM_QC_GUESTS'					=> 'Citaten voor gasten',
	'ACP_DM_QC_GUESTS_EXPLAIN'			=> 'Wil je dat gasten de citaten ook kunnen bekijken?',
	'ACP_DM_QC_CONFIG_SUCCESS'			=> 'De configuratie werd succesvol geupdate',
	'ACP_DM_QC_EDIT'					=> 'Bewerk citaten',
	'ACP_DM_QC_EDIT_EXPLAIN'			=> 'Hier kan je citaten toevoegen, bewerken of verwijderen',
	'ACP_DM_QC_EDIT_QUOTE_EXPLAIN'		=> 'Hier kan je het geselecteerde citaat bewerken',
	'ACP_DM_QC_ID'						=> 'ID',
	'ACP_DM_QC_QUOTE'					=> 'Citaat',
	'ACP_DM_QC_QUOTE_EXPLAIN'			=> 'Plaats hier je citaat',
	'ACP_DM_QC_AUTHOR'					=> 'Auteur',
	'ACP_DM_QC_AUTHOR_EXPLAIN'			=> 'Plaats hier de originele auteur van het citaat',
	'ACP_DM_QC_POSTER'					=> 'gepost door',
	'ACP_DM_QC_DATE'					=> 'gepost op',
	'ACP_DM_QC_APPROVE'					=> 'Ingeschakeld',
	'ACP_DM_QC_APPROVE_EXPLAIN'			=> 'Kies hier ja indien je het citaat wil inschakelen',
	'ACP_DM_QC_ADD'						=> 'Voeg nieuw citaat toe',
	'ACP_DM_QC_ADD_EXPLAIN'				=> 'Hier kan je nieuwe citaten toevoegen. Gelieve alle velden in te vullen!',
	'ACP_DM_QC_ADDED'					=> 'Het citaat werd succesvol toegevoegd',
	'ACP_DM_QC_DELETED'					=> 'De opgave werd succesvol verwijderd',
	'ACP_DM_QC_REALY_DELETE'			=> 'Ben je zeker dat je de geselecteerde opgave west te verwijderen?',
	'ACP_DM_QC_NEED_DATA'				=> 'Je moet op zijn minst een citaat invullen ....',
	'ACP_DM_QC_UPDATED'					=> 'De opgave werd succesvol geupdate',
	'ACP_DM_QC_NO_QUOTES'				=> 'Geen citaten beschikbaar',
	'NOT_UPLOADED'						=> '',
	'ACP_DM_QC_DELAY'					=> 'tijdvertraging',
	'ACP_DM_QC_DELAY_EXPLAIN'			=> 'hier kan je een tijdvertraging in minuten opgeven alvorens een gebruiker een nieuw citaat kan toevoegen. Typ 0 op deze optie uit te schakelen..',
	'ACP_DM_QC_MINUTE'					=> 'minuut',
	'ACP_DM_QC_MINUTES'					=> 'minuten',
));
