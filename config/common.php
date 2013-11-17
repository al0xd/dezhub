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
