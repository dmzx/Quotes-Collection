<?php
/**
*
* @package phpBB Extension - Quotes Collection
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
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_DM_QC_ALL'						=> 'Toutes',
	'ACP_DM_QC_SORT_ID'					=> 'ID',
	'ACP_DM_QC_SORT_AUTHOR'				=> 'Auteur',
	'ACP_DM_QC_SORT_DATE'				=> 'Date',
	'ACP_DM_QC_SORT_APPROVAL'			=> 'Approvée',
	'ACP_DM_QC_SORT_POSTER'				=> 'Postée',
	'ACP_DM_QC_SINGLE'					=> '1 Citation',
	'ACP_DM_QC_MULTI'					=> '%1$s citation',
	'ACP_DM_QC_RELEASE'					=> 'Validation des Citations',
	'ACP_DM_QC_RELEASE_EXPLAIN'			=> 'Ici vous pouvez valider les citations',
	'ACP_DM_QC_CONFIG_EXPLAIN'			=> 'Ici vous pouvez choisir les valeurs par défaut',
	'ACP_DM_QC_APPROVAL'				=> 'Les citations requièrent l\'approbation',
	'ACP_DM_QC_APPROVAL_EXPLAIN'		=> 'Voulez-vous approuver chaque citation?',
	'ACP_DM_QC_PAGI_ACP'				=> 'Nombre de citations par page dans l\'administration (ACP)',
	'ACP_DM_QC_PAGI_ACP_EXPLAIN'		=> 'Nombre de citations par page que vous voulez voir dans l\'administration ACP',
	'ACP_DM_QC_PAGI_USER'				=> 'Nombre de citations dans la page de l\'utilisateur',
	'ACP_DM_QC_PAGI_USER_EXPLAIN'		=> 'Nombre de citations que les utilisateurs verront, s\'ilschoisissent de voir toutes les citations',
	'ACP_DM_QC_PAGE_ERROR'				=> 'Vous ne pouvez pas entrer une valeur inférieure à 5 pour le nombre de citations par page dans les pages ACP ou sur le site pour les utilisateurs',
	'ACP_DM_QC_ENABLE'					=> 'Activer DM Quotes Collection',
	'ACP_DM_QC_ENABLE_EXPLAIN'			=> 'Voulez-vous activer DM Quotes Collection?',
	'ACP_DM_QC_INDEX'					=> 'Citation sur l\'index',
	'ACP_DM_QC_INDEX_EXPLAIN'			=> 'Voulez vous afficher les citations aléatoire sur l\'index?',
	'ACP_DM_QC_GUESTS'					=> 'Citations pour les visiteurs anonymes',
	'ACP_DM_QC_GUESTS_EXPLAIN'			=> 'Voulez-vous que les visiteurs anonymes puissent voir les citations?',
	'ACP_DM_QC_CONFIG_SUCCESS'			=> 'La configuration a été mise à jour avec succés',
	'ACP_DM_QC_EDIT'					=> 'Edition des Citations',
	'ACP_DM_QC_EDIT_EXPLAIN'			=> 'Ici vous pouvez ajouter, éditer, ou supprimer les citations',
	'ACP_DM_QC_EDIT_QUOTE_EXPLAIN'		=> 'Ici vous pouvez éditer une citation',
	'ACP_DM_QC_ID'						=> 'ID',
	'ACP_DM_QC_QUOTE'					=> 'Citation',
	'ACP_DM_QC_QUOTE_EXPLAIN'			=> 'Entrer ici votre citation',
	'ACP_DM_QC_AUTHOR'					=> 'Auteur',
	'ACP_DM_QC_AUTHOR_EXPLAIN'			=> 'Entrer ici l\'auteur original de la citation',
	'ACP_DM_QC_POSTER'					=> 'posté par',
	'ACP_DM_QC_DATE'					=> 'posté le',
	'ACP_DM_QC_APPROVE'					=> 'Activée',
	'ACP_DM_QC_APPROVE_EXPLAIN'			=> 'Saisissez ici, si vous voulez activer la citation',
	'ACP_DM_QC_ADD'						=> 'Ajouter une nouvelle citation',
	'ACP_DM_QC_ADD_EXPLAIN'				=> 'Ici, vous pouvez ajouter de nouvelles citations. Merci de remplir tous les champs!',
	'ACP_DM_QC_ADDED'					=> 'la citation a été ajoutée avec succés',
	'ACP_DM_QC_DELETED'					=> 'L\'entrée a été supprimée avec succés',
	'ACP_DM_QC_REALY_DELETE'			=> 'Êtes-vous sur de vouloir supprimer cette entrée?',
	'ACP_DM_QC_NEED_DATA'				=> 'Vous devez entrer au moins la citation....',
	'ACP_DM_QC_UPDATED'					=> 'L\'entrée a été mise à jour avec succés',
	'ACP_DM_QC_NO_QUOTES'				=> 'Pas de citation disponible',
	'NOT_UPLOADED'						=> '',
	'ACP_DM_QC_DELAY'					=> 'Temporisation ( Temps d\'attente )',
	'ACP_DM_QC_DELAY_EXPLAIN'			=> 'Ici vous pouvez définir un délai de temps en minutes, avant qu\'un utilisateur puisse ajouter une nouvelle citation. Entrez 0 pour désactiver cette option.',
	'ACP_DM_QC_MINUTE'					=> 'minute',
	'ACP_DM_QC_MINUTES'					=> 'minutes',
));
