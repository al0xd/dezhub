<?php defined('SITE_DIR') or exit('Direct script access is not allowed!');
/*
******************************************************************************************   

  Package            : Dezhub  [ Web Application Framework ]
      
  Lead Architect     : Hung Dinh. [ dinhhungvn@gmail.com ]     
  Year               : 2013 - 2014                                                      

  Site               : http://www.dezhub.com/
  Contact / Support  : dinhhungvn@gmail.com

  Copyright (C) 2013 by Dezhub

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
  
******************************************************************************************   
*/

/*	start define const */

	define("SITE_URL", "http://{$_SERVER['SERVER_NAME']}/");
	define("MULTILANG", "No");
	define("BASEAPP", SITE_DIR."application/");
	define("DEFAULT_LANG", "vn");

/*	end define const */


if(!function_exists ("loadModule")){
	function loadModule($modul, $task= NULL, $other= array())	
	{
		global $oDb, $oSmarty;
		if($task==NULL && isset($_REQUEST['task']))
			$task= $_REQUEST['task'];
		$template_dir= $oSmarty->template_dir;
			$oSmarty->setTemplateDir("application/view/$modul")->setCompileDir(PUBLICFOLDER."/templates_c");
		$model= ucfirst($modul);
		if(file_exists(CONTROLPATH."$modul".____EXTPHP)) {
			if(file_exists(MODELPATH."{$modul}".____EXTPHP)) {
				include_once(MODELPATH."{$modul}".____EXTPHP);
			}
			if(file_exists(INFACEPATH."{$modul}".____EXTPHP)) {
				include_once(INFACEPATH."{$modul}".____EXTPHP);
			}
			include_once(CONTROLPATH."$modul".____EXTPHP);
			$mod = new $model();
			return $mod->run($task);
		}else{
			echo "Chức năng đang cập nhật...";
		}
	}
}


function cutString ($string, $separate)

{

	if(strlen(trim($string))==0)

	{

		return false;

	} 

	elseif(strpos($string, $separate)===false)

	{

		return $string;

	}

	else 

	{

		$separateLen 	= strlen($separate);

		$separatePos	= strpos($string, $separate);

		

		if($separatePos === false || $separateLen ==0)

		{

			$part[0] = $string;

			$part[1] = '';

		}

		else 

		{

			$part[0] = substr($string, 0, $separatePos);

			$part[1] = substr($string, $separatePos + $separateLen);

		}

		return $part;

	}

	

}


function __MODEL($model=null){
	if($model){
		$m = explode(",",$model);
		if(is_array($m))
			foreach($m as $k){
				if($k!="")
					require_once(MODELPATH.$k.____EXTPHP);
			}
	}

}



function removeMarks($string,$keyunsset=NULL)

{

  $trans = array ('"'=>'','"'=>'',' - '=>'-','!'=>'','.'=>'','&'=>'',','=>'',' & '=>'-','é' => 'e', "'" => "",  '"' => '', '"' => '', 'ẻ' => 'e', 'ẽ' => 'e', 'ằ' => 'a', 'ắ' => 'a', 'ọ' => 'o', 'ẽ' => 'e', 'ờ' => 'o', 'ẹ' => 'e', 'ặ' => 'a', 'ề' => 'e', 'ặ' => 'a', 'à' => 'a', 'á' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a', 'â' => 'a', 'ấ' => 'a', 'ầ' => 'a', 'ẫ' => 'a', 'ẩ' => 'a', 'ậ' => 'a', 'ú' => 'a', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u', 'à' => 'a', 'á' => 'a', 'ô' => 'o', 'ố' => 'o', 'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o', 'ó' => 'o', 'ò' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o', 'ê' => 'e', 'ế' => 'e', 'ề' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e', 'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i', 'ơ' => 'o', 'ớ' => 'o', 'ý' => 'y', 'ỳ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o', 'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u', 'đ' => 'd', 'À' => 'A', 'Á' => 'A', 'Ả' => 'A', 'Ã' => 'A', 'Ạ' => 'A', 'Â' => 'A', 'Ấ' => 'A', 'À' => 'A', 'Ẫ' => 'A', 'Ẩ' => 'A', 'Ậ' => 'A', 'Ú' => 'U', 'Ù' => 'U', 'Ủ' => 'U', 'Ũ' => 'U', 'Ụ' => 'U', 'Ô' => 'O', 'Ố' => 'O', 'Ồ' => 'O', 'Ổ' => 'O', 'Ỗ' => 'O', 'Ộ' => 'O', 'Ê' => 'E', 'Ế' => 'E', 'Ề' => 'E', 'Ể' => 'E', 'Ễ' => 'E', 'Ệ' => 'E', 'Í' => 'I', 'Ì' => 'I', 'Ỉ' => 'I', 'Ĩ' => 'I', 'Ị' => 'I', 'Ơ' => 'O', 'Ớ' => 'O', 'Ờ' => 'O', 'Ở' => 'O', 'Ỡ' => 'O', 'Ợ' => 'O', 'Ư' => 'U', 'Ừ' => 'U', 'Ứ' => 'U', 'Ử' => 'U', 'Ữ' => 'U', 'Ự' => 'U', 'Đ' => 'D', 'Ý' => 'Y', 'Ỳ' => 'Y', 'Ỷ' => 'Y', 'Ỹ' => 'Y', 'Ỵ' => 'Y', 'á' => 'a', 'à' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a', 'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a', 'â' => 'a', 'ấ' => 'a', 'ầ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a', 'ú' => 'u', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u', 'ư' => 'u', 'ứ' => 'u', 'ừ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u', 'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i', 'ó' => 'o', 'ò' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o', 'ô' => 'o', 'ố' => 'o', 'ồ' => 'ô', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o', 'ơ' => 'o', 'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o', 'đ' => 'd', 'Đ' => 'D', 'ý' => 'y', 'ỳ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y', 'Á' => 'A', 'À' => 'A', 'Ả' => 'A', 'Ã' => 'A', 'Ạ' => 'A', 'Ă' => 'A', 'Ắ' => 'A', 'Ẳ' => 'A', 'Ẵ' => 'A', 'Ặ' => 'A', 'Â' => 'A', 'Ấ' => 'A', 'Ẩ' => 'A', 'Ẫ' => 'A', 'Ậ' => 'A', 'É' => 'E', 'È' => 'E', 'Ẻ' => 'E', 'Ẽ' => 'E', 'Ẹ' => 'E', 'Ế' => 'E', 'Ề' => 'E', 'Ể' => 'E', 'Ễ' => 'E', 'Ệ' => 'E', 'Ú' => 'U', 'Ù' => 'U', 'Ủ' => 'U', 'Ũ' => 'U', 'Ụ' => 'U', 'Ư' => 'U', 'Ứ' => 'U', 'Ừ' => 'U', 'Ử' => 'U', 'Ữ' => 'U', 'Ự' => 'U', 'Í' => 'I', 'Ì' => 'I', 'Ỉ' => 'I', 'Ĩ' => 'I', 'Ị' => 'I', 'Ó' => 'O', 'Ò' => 'O', 'Ỏ' => 'O', 'Õ' => 'O', 'Ọ' => 'O', 'Ô' => 'O', 'Ố' => 'O', 'Ổ' => 'O', 'Ỗ' => 'O', 'Ộ' => 'O', 'Ơ' => 'O', 'Ớ' => 'O', 'Ờ' => 'O', 'Ở' => 'O', 'Ỡ' => 'O', 'Ợ' => 'O', 'Ý' => 'Y', 'Ỳ' => 'Y', 'Ỷ' => 'Y', 'Ỹ' => 'Y', 'Ỵ' => 'Y','?'=>'', ' ' => '-', '/'=>'');

  

  if(is_array($keyunsset)){

	  	foreach($keyunsset as $k){

	 	unset($trans[$k]);

		}

		$string= strtr(trim($string), $trans);

	   return strtolower($string);

	}else{

		$string= strtr(trim($string), $trans);

		$string     =    trim(preg_replace('/[^\w\d_ -]/si', '', $string));//remove all illegal chars

		$string = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $string);

		// return strtr(trim($string), $trans);

		return strtolower($string);

	}

}







/* end functions for friendly_url */

	

	/* truncate string with space character and limit character 

		@parameter:

			$data: string source.

			$limit_char: get limit character.

		@return : return string with number character greater or equal $limit_char

	*/

	function truncate( $data, $limit_char){

		if( strlen( $data) <= $limit_char) return $data;

		$max_word = 10;

		while ( substr( $data, $limit_char, 1 ) != ' ' && $max_word > 0 && $limit_char > 0) {

			$limit_char --;

			$max_word --;

		}

		

		if( $limit_char <= 0) return $data;

		else return substr( $data, 0, $limit_char);

	}

	

	

	/**

	 * Setup  default language of system

	 *

	 * @param string $lang

	 */

	function getDefaultLang($lang=null){

		global $oDb;
		$row=$oDb->getRow("select * from dz_lang order by isdefault desc limit 1");
		if(checkMultiLang()){
			if(!$lang){
				$row=$oDb->getRow("select * from dz_lang where isdefault=1");
				if(!isset($_SESSION['lang'])){	
					set_lang_variable($row);
				}
			}
			else{
				$sql = "select * from dz_lang where name='".$lang."' or filename='".$lang.".conf'";
				$row=$oDb->getRow($sql);
				set_lang_variable($row);
			}
			
		}else{
			set_lang_variable($row);
		}
		//setup lang variable
		

	}
	function set_lang_variable($row=array()){
		if(count($row)>0){
			$_SESSION["lang"]=  substr( $row['filename'], 0, strlen($row['filename']) - 5);
			$_SESSION["lang_id"] = $row['id'];		
			$_SESSION["lang_file"]=  $row['filename'];
		}
	}
	function pre($str)

	{

		echo "<pre align=\"left\" >";

		print_r($str);

		echo "</pre>";

	}

	
	

	function checkMultiLang(){

		$multiLang = MULTILANG;
		if($multiLang=='Yes') 
			return true;
		else  
			return false;

	}


function selfURL(){		

	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
}



function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

/**
 * Determine if SSL is used.
 *
 * @since 2.6.0
 *
 * @return bool True if SSL, false if not used.
 */
function is_ssl() {
	if ( isset($_SERVER['HTTPS']) ) {
		if ( 'on' == strtolower($_SERVER['HTTPS']) )
			return true;
		if ( '1' == $_SERVER['HTTPS'] )
			return true;
	} elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
		return true;
	}
	return false;
}
function checkUrl($link=""){
		if($link){
			$request = $_REQUEST;
			$link = urldecode($link);
			parse_str($link,$output);
			if(is_array($output)){
				$isfull = true;
				foreach($output as $k=>$v){
					if($request[$k]!=$v){
						$isfull=false;
					}
				}
				return $isfull;
			}
			
		}else
			return false;
	}	
function isPermission(){
		global $oDb;
		$user = getUserbyCookie();
		if($user['user_type_id']==1)
			return true;
		else{
			$task= $_REQUEST['task'];
			$coltask = $oDb->getCol("select name from dz_roll");
			$stbl ="dz_admin_menu";
			$_prefix = "";
			// type of category
			$sWhere = "showed=1";
			$twhere = "";
			
			$sql="select * from {$stbl} where {$sWhere} {$twhere}";	
			$rows=$oDb->getAll($sql);
			if($rows)
				foreach($rows as $k=>$v){
					$sql="select * from {$stbl} where {$sWhere} and parent_id=".$v['id'];	
					$haschild = $oDb->getOne($sql); // kiem tra khong con child menu
					if(checkUrl($v['link']) && !$haschild){
						if(in_array($task,$coltask)){
							$taskID = $oDb->getOne("select id from dz_roll where name='$task'");
							$sql = "select count(t1.id) from dz_module_roll t1 
								join dz_usertype_moduleroll t2 on t1.id = t2.module_roll_id
								where t1.module_id=".$v['id']." and t1.roll_id=".$taskID."
								 and t2.user_type_id=".$user['user_type_id'];
							$isPermission = $oDb->getOne($sql);
							//exit();
							if($isPermission==0)
								loginUpdatePermisson();
							else
								return true;
						}
					}
					
			}
		}
}
	function loginUpdatePermisson(){
		//clearCookie();
		//$url = selfURL();
		echo "Ban khong co quyen truy cap chuc nang nay!";
		//header("Location:".SITE_URL."dz-admin?task=login&backurl=".urlencode($url));
		exit();		
	
	}
	function clearCookie(){
		$time_save = time() - 3600;
		$domain = $_SERVER['HTTP_HOST'];
		setcookie("dzh_uid","",$time_save,"/",$domain);
		setcookie("dzh_hash","",$time_save,"/",$domain);
		setcookie("dzh_session","",$time_save,"/",$domain);
	}

	function getUserbyCookie(){
		global $oDb;
		$sql = "SELECT * FROM dz_user WHERE id = ".intval($_COOKIE['dzh_uid']);
		$user = $oDb->getRow($sql);
		if($user){
			return $user;
		}
		else
			return false;

	}

function isCache(){
		if(CACHE_DATA==true)
			return true;
		else
			return false;
	}

function make_data_default(){
	if(!is_dir(PUBLICFOLDER)){
		mkdir(PUBLICFOLDER,0777);
	}
	$dztemp=PUBLICFOLDER."/cache";
	if(!is_dir($dztemp)){
		mkdir($dztemp,0777);
	}
}
