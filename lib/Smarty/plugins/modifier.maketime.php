<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty string_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     string_format<br>
 * Purpose:  format strings via sprintf
 * @link http://smarty.php.net/manual/en/language.modifier.string.format.php
 *          string_format (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @return string
 */
date_default_timezone_set("Asia/Ho_Chi_Minh"); 
function smarty_modifier_maketime($string)
{
    $mktime = strtotime($string);
	$aData=array(
		"nam" =>  date("Y",$mktime),
		"thang" => date("m",$mktime),
		"ngay" => date("j",$mktime),
		"gio" => date("g",$mktime),
		"phut" => date("i",$mktime),
		"giay" => date("s",$mktime),
		"buoi" => reBuoi(date("a",$mktime)),
		"ago" => ago($mktime),
	);
	return $aData;
}
function reBuoi($string){
	$aB = array("am"=>"sáng","pm"=>"chiều");
	return $aB[$string];
}

function ago($time)
{
   $periods = array("giây", "phút", "giờ", "ngày", "tuần", "tháng", "năm", "thập kỷ");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

 //  if($difference != 1) {
 //      $periods[$j].= "s";
 //  }

   return "$difference $periods[$j]";
}

/* vim: set expandtab: */

?>
