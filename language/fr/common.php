<?php
/**
*
* @package phpBB Extension - Quotes Collection
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
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'DM_QC_TITLE'				=> 'DM Quotes Collection',
	'DM_QC_HEADER'				=> 'Citations Aléatoires',
	'DM_QC_QUOTE_TITLE'			=> 'Citations',
	'DM_QC_ADD'					=> 'Ajouter une citation',
	'DM_QC_OWN'					=> 'Vos citations',
	'DM_QC_ALL'					=> 'Voir toutes les citations',
	'DM_QC_NO_AUTHOR'			=> 'Author inconnu',
	'DM_QC_QUOTE_AUTHOR'		=> 'par %1$s',
	'DM_QC_QUOTE'				=> 'Citation',
	'DM_QC_QUOTE_EXPLAIN'		=> 'Entrer votre citation ici',
	'DM_QC_QUOTES'				=> '<strong>Citation:</strong>',
	'DM_QC_AUTHOR'				=> 'Auteur',
	'DM_QC_AUTHOR_EXPLAIN'		=> 'Entrez ici l\'auteur de la citation. Si vous ne connaissez pas l\'auteur, laissez le champ vide.',
	'DM_QC_POSTER'				=> 'Posté par',
	'DM_QC_DATE'				=> 'Posté le',
	'DM_QC_SINGLE'				=> '1 citation',
	'DM_QC_MULTI'				=> ' %1$s citations',
	'DM_QC_NO_QUOTES'			=> 'Il n\'y a pas de citations à afficher.',
	'DM_QC_ALL_TITLE'			=> 'Voir toutes les citations',
	'DM_QC_ALL_TITLE_DESC'		=> 'Ici vous pouvez voir toutes les citations approuvées.<br /><br />',
	'DM_QC_OWN_TITLE'			=> 'Vos citations',
	'DM_QC_OWN_TITLE_DESC'		=> 'Ici vous pouvez voir toutes les citations, que vous avez publiés. Vous pouvez également voir quelle citation non-autorisée vous avez proposé.<br /><br />',
	'DM_QC_ADD_TITLE'			=> 'Ajouter des citations',
	'DM_QC_ADD_TITLE_DESC'		=> 'Ici vous pouvez ajouter vos propres citations. S\'il vous plaît entrer au moins une citation. Si vous connaissez l\'auteur de la citation, merci de le mentionner également!<br /><br />',
	'DM_QC_APPROVAL'			=> 'Approuvée',
	'DM_QC_QUOTE_ERROR'			=> 'Vous devez entrer au moins la citation elle-même!',
	'DM_QC_BACK_TO_PREV'		=> 'Retour à la dernière page',
	'DM_QC_QUOTE_SUCCESS'		=> 'Votre entrée à été ajoutée avec succés<br /><br />',
	'DM_QC_QUOTE_SUC_APP'		=> 'Votre entrée à été ajoutée avec succés, mais elle doit être approuvée avant d\'être visible.<br /><br />',
	'DM_QC_BACK_TO_MAIN'		=> 'Retour à DM Quotes Collection',
	'DM_QC_CHECK_QUOTE'			=> 'Il y a <strong>une</strong> nouvelle citation disponible, en attente d\'être approuvée!',
	'DM_QC_CHECK_QUOTES'		=> 'Il y a <strong>%1$s</strong> nouvelles citations disponibles, en attente d\'être approuvées!',
	'DM_QC_CHECK_ACP'			=> 'Clic %sici%s pour aller à l\'ACP.',
	'DM_QC_POSTED_BY'			=> 'Posté par %1$s',
	'DM_QC_OPTIONS'				=> 'Options',
	'DM_QC_QUOTE_SUC_UPS' 		=> 'Merci d\'avoir posté une citation !<br />Nous avons transféré %1$s %2$s sur votre compte pour cela!',
	'DM_QC_QUOTE_SUC_UPS_APP' 	=> 'Merci d\'avoir posté une citation !<br />Dès qu\'un administrateur valide cette citation, nous allons transférer %1$s %2$s sur votre compte!',
	'DM_QC_DELETE'				=> 'Supprimer la citation',
	'DM_QC_DELETED'				=> 'La citation a été supprimée avec succés.',
	'DM_QC_REALLY_DELETE'		=> 'Êtes-vous certain de vouloir supprimer les citations séléctionnées ?',
	'DM_QC_BACK'				=> 'Clic %sici%s pour retourner à la dernière page',
	'DM_QC_DELAY_ERROR'			=> 'Désolé. La configuration de DM Quote Collection indique, que vous pouvez entrer une nouvelle citation tout les <strong>%1$s %2$s</strong>. Alors s\'il vous plaît réessayer plus tard.',
	'DM_QC_MINUTES'				=> 'minutes',
	'DM_QC_MINUTE'				=> 'minute',
	'DM_QC_ALL_QUOTES'			=> 'Toutes',
	'DM_QC_SORT_AUTHOR'			=> 'Auteur',
	'DM_QC_SORT_POSTER'			=> 'Posteur',
	'DM_QC_SORT_DATE'			=> 'Date',
	'DM_QC_VERSION'				=> 'Version',
	'QUOTE_COLLAPSE_TITLE'		=> 'Citations effondrées',
));
