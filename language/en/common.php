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
	'DM_QC_HEADER'				=> 'Random Quote',
	'DM_QC_QUOTE_TITLE'			=> 'Quotes',
	'DM_QC_ADD'					=> 'Add quote',
	'DM_QC_OWN'					=> 'Own quotes',
	'DM_QC_ALL'					=> 'Show all quotes',
	'DM_QC_NO_AUTHOR'			=> 'Unknown author',
	'DM_QC_QUOTE_AUTHOR'		=> 'by %1$s',
	'DM_QC_QUOTE'				=> 'Quote',
	'DM_QC_QUOTE_EXPLAIN'		=> 'Enter here your quote',
	'DM_QC_QUOTES'				=> '<strong>Quote:</strong>',
	'DM_QC_AUTHOR'				=> 'Author',
	'DM_QC_AUTHOR_EXPLAIN'		=> 'Enter here the author of the quote. If you don’t know, who it was, leave the field empty.',
	'DM_QC_POSTER'				=> 'Posted by',
	'DM_QC_DATE'				=> 'Posted on',
	'DM_QC_SINGLE'				=> '1 quote',
	'DM_QC_MULTI'				=> ' %1$s quotes',
	'DM_QC_NO_QUOTES'			=> 'There are no quotes to display.',
	'DM_QC_ALL_TITLE'			=> 'Show all quotes',
	'DM_QC_ALL_TITLE_DESC'		=> 'Here you can see all approved quotes.<br /><br />',
	'DM_QC_OWN_TITLE'			=> 'Own quotes',
	'DM_QC_OWN_TITLE_DESC'		=> 'Here you can see all quotes, which you have posted. You also can see, if there\'s any unapproved quote from you.<br /><br />',
	'DM_QC_ADD_TITLE'			=> 'Add quotes',
	'DM_QC_ADD_TITLE_DESC'		=> 'Here you can add your own quotes. Please enter at least the quote. If you know, from whom the quote is, please enter it too!<br /><br />',
	'DM_QC_APPROVAL'			=> 'Approved',
	'DM_QC_QUOTE_ERROR'			=> 'You need to enter at lease the quote itself!',
	'DM_QC_BACK_TO_PREV'		=> 'Back to last page',
	'DM_QC_QUOTE_SUCCESS'		=> 'Your entry was successfully added<br /><br />',
	'DM_QC_QUOTE_SUC_APP'		=> 'Your entry was successfully added, but it needs to be approved, before it’s visible.<br /><br />',
	'DM_QC_BACK_TO_MAIN'		=> 'Back to DM Quotes Collection',
	'DM_QC_CHECK_QUOTE'			=> 'There\'s <strong>one</strong> new quote available, which is waiting for being released!',
	'DM_QC_CHECK_QUOTES'		=> 'There are <strong>%1$s</strong> new quotes available, which are waiting for being released!',
	'DM_QC_CHECK_ACP'			=> 'Click %shere%s to go to your ACP.',
	'DM_QC_POSTED_BY'			=> 'Posted by %1$s',
	'DM_QC_OPTIONS'				=> 'Options',
	'DM_QC_QUOTE_SUC_UPS' 		=> 'Thanks a lot for posting a quote!<br />We transferred %1$s %2$s to your account for this!',
	'DM_QC_QUOTE_SUC_UPS_APP' 	=> 'Thanks a lot for posting a quote!<br />As soon as an administrator releases this quote, we will transfer %1$s %2$s to your account!',
	'DM_QC_DELETE'				=> 'Delete quote',
	'DM_QC_DELETED'				=> 'The quote was deleted successfully.',
	'DM_QC_REALLY_DELETE'		=> 'Are you sure you want to delete the selected quote?',
	'DM_QC_BACK'				=> 'Click %shere%s to return to the last page',
	'DM_QC_DELAY_ERROR'			=> 'Sorry. The configuration of the DM Quote Collection says, that you may enter a new quote only once every <strong>%1$s %2$s</strong>. So please try again later.',
	'DM_QC_MINUTES'				=> 'minutes',
	'DM_QC_MINUTE'				=> 'minute',
	'DM_QC_ALL_QUOTES'			=> 'All',
	'DM_QC_SORT_AUTHOR'			=> 'Author',
	'DM_QC_SORT_POSTER'			=> 'Poster',
	'DM_QC_SORT_DATE'			=> 'Date',
	'DM_QC_VERSION'				=> 'Version',
	'QUOTE_COLLAPSE_TITLE'		=> 'Collapse quotes',
));
