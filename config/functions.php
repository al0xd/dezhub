<?php defined('SITE_DIR') or exit('Direct script access is not allowed!');
/*
******************************************************************************************   

  Package            : Dezhub  [ Web Application Framework ]
  Version            : 2.0.1
      
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
function make_data_default(){
	if(!is_dir(PUBLICFOLDER)){
		mkdir(PUBLICFOLDER,0777);
	}
	$dztemp=PUBLICFOLDER."/cache";
	if(!is_dir($dztemp)){
		mkdir($dztemp,0777);
	}
}
function isCache(){
		if(CACHE_DATA==true)
			return true;
		else
			return false;
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



?>