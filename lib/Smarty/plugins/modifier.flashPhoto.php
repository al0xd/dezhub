<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     lower<br>
 * Purpose:  convert string to lowercase
 * @link http://smarty.php.net/manual/en/language.modifier.lower.php
 *          lower (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_flashPhoto($filename, $path="", $tooltip="")
{
	$w=50;
	$h=50;
    $ext  = substr($filename, -3);
	if(strtolower($ext) !='swf'){
		if($path)
			$sData = "<img src=\"{$path}/{$filename}\" style=\"height:{$h}px\" border=\"0\" title=\"{$tooltip}\"/>";
		else
			$sData = "<img src=\"{$filename}\" style=\"height:{$h}px\" border=\"0\" title=\"{$tooltip}\"/>";
	}else{
		$temp_path = $path;
		if(substr($path, 0, 1) == '/') $temp_path = substr($path, 1);
		$width="50";

		list($width, $height, $type, $attr) = getimagesize("{$temp_path}{$filename}"); 		
		if($height>$h){
			$width = ceil($width*$h/$height);
			$height=$h;
		}
		
		$sData = "<object  style=\"cursor:pointer;\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=0,0,0,0\" width=\"{$width}\" height=\"{$height}\" >
                  <param name=\"movie\" value=\"{$path}{$filename}\" />
                  <param name=\"quality\" value=\"high\" />
                  <embed  style=\"cursor:pointer;\" src=\"{$path}/{$filename}\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"{$width}\" height=\"{$height}\" ></embed>
</object>";
	}
	return $sData;
}

?>
