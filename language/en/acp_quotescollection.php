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
	'ACP_DM_QC_ALL'						=> 'All',
	'ACP_DM_QC_SORT_ID'					=> 'ID',
	'ACP_DM_QC_SORT_AUTHOR'				=> 'Author',
	'ACP_DM_QC_SORT_DATE'				=> 'Date',
	'ACP_DM_QC_SORT_APPROVAL'			=> 'Approved',
	'ACP_DM_QC_SORT_POSTER'				=> 'Poster',
	'ACP_DM_QC_SINGLE'					=> '1 Quote',
	'ACP_DM_QC_MULTI'					=> '%1$s quote',
	'ACP_DM_QC_RELEASE'					=> 'Release quotes',
	'ACP_DM_QC_RELEASE_EXPLAIN'			=> 'Here you can release quotes',
	'ACP_DM_QC_CONFIG_EXPLAIN'			=> 'Here you can set some basic values',
	'ACP_DM_QC_APPROVAL'				=> 'Quotes requires approval',
	'ACP_DM_QC_APPROVAL_EXPLAIN'		=> 'Do you want to approve every quote?',
	'ACP_DM_QC_PAGI_ACP'				=> 'Number of quotes per page (ACP)',
	'ACP_DM_QC_PAGI_ACP_EXPLAIN'		=> 'Number of quotes you like to see per page in the ACP',
	'ACP_DM_QC_PAGI_USER'				=> 'Number of quotes on users page',
	'ACP_DM_QC_PAGI_USER_EXPLAIN'		=> 'Number of quotes users will see, if they select to view all quotes',
	'ACP_DM_QC_PAGE_ERROR'				=> 'You cannot enter a value below 5 for the number of quotes per page in the ACP or on the users site',
	'ACP_DM_QC_ENABLE'					=> 'Enable DM Quotes Collection',
	'ACP_DM_QC_ENABLE_EXPLAIN'			=> 'Do you like to enable DM Quotes Collection?',
	'ACP_DM_QC_INDEX'					=> 'Quote on index',
	'ACP_DM_QC_INDEX_EXPLAIN'			=> 'Would you like to see a random quote on the index page?',
	'ACP_DM_QC_GUESTS'					=> 'Quotes for guests',
	'ACP_DM_QC_GUESTS_EXPLAIN'			=> 'Do you like guests to see the quotes?',
	'ACP_DM_QC_CONFIG_SUCCESS'			=> 'The configuration was successfully updated',
	'ACP_DM_QC_EDIT'					=> 'Edit quotes',
	'ACP_DM_QC_EDIT_EXPLAIN'			=> 'Here you can add, edit or delete quotes',
	'ACP_DM_QC_EDIT_QUOTE_EXPLAIN'		=> 'Here you can edit the selected quote',
	'ACP_DM_QC_ID'						=> 'ID',
	'ACP_DM_QC_QUOTE'					=> 'Quote',
	'ACP_DM_QC_QUOTE_EXPLAIN'			=> 'Enter here your quote',
	'ACP_DM_QC_AUTHOR'					=> 'Author',
	'ACP_DM_QC_AUTHOR_EXPLAIN'			=> 'Enter here the original author of the quote',
	'ACP_DM_QC_POSTER'					=> 'posted by',
	'ACP_DM_QC_DATE'					=> 'posted on',
	'ACP_DM_QC_APPROVE'					=> 'Enabled',
	'ACP_DM_QC_APPROVE_EXPLAIN'			=> 'Enter here, if you like to enable the quote',
	'ACP_DM_QC_ADD'						=> 'Add new quote',
	'ACP_DM_QC_ADD_EXPLAIN'				=> 'Here you can add new quotes. Please be so kind and fill all fields!',
	'ACP_DM_QC_ADDED'					=> 'The quote was added successfully',
	'ACP_DM_QC_DELETED'					=> 'The entry was deleted successfully',
	'ACP_DM_QC_REALY_DELETE'			=> 'Are you sure, you want to delete the selected entry?',
	'ACP_DM_QC_NEED_DATA'				=> 'You need to enter at least the quote itself ....',
	'ACP_DM_QC_UPDATED'					=> 'The entry was updated successfully',
	'ACP_DM_QC_NO_QUOTES'				=> 'No quotes available',
	'NOT_UPLOADED'						=> '',
	'ACP_DM_QC_DELAY'					=> 'Time delay',
	'ACP_DM_QC_DELAY_EXPLAIN'			=> 'Here you can set a time delay in minutes, before a user can add a new quote. Enter 0 die disable this option.',
	'ACP_DM_QC_MINUTE'					=> 'minute',
	'ACP_DM_QC_MINUTES'					=> 'minutes',
));
