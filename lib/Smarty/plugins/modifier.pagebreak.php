<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     pagebreak<br>
 * Date:     Feb 26, 2003
 * Purpose:  convert \r\n, \r or \n to <<br>>
 * Input:<br>
 *         - contents = contents to replace
 *         - preceed_test = if true, includes preceeding break tags
 *           in replacement
 * Example:  {$text|nl2br}
 * @link http://smarty.php.net/manual/en/language.modifier.nl2br.php
 *          nl2br (Smarty online manual)
 * @version  1.0
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */

function smarty_modifier_pagebreak($haystack, $needle="page-break-after")
{
	if(strpos($haystack, $needle))
		return substr($haystack, 0, strpos($haystack, $needle)-12);
	else
		return $haystack;
/*
	$arr= explode($needle, $haystack);
	if(is_array($arr))
		return $arr[0];
	else
		return $haystack; */
}

/* vim: set expandtab: */

?>
