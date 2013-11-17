<?php	 defined('SITE_DIR') or exit('Direct script access is not allowed!');
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

class Layout
{	
	function run($task= "")
	{
		global $oSmarty;
	//	$modul = "home";
		if(!isset($_GET['mod'])){
			$_REQUEST['mod']='home';
			$_GET['mod']='home';
		}
		$modul = $_REQUEST['mod'];
		if(!isset($_GET['task'])){
			$_REQUEST['task']='undefine';
			$_GET['task']='undefine';
		}
		$aPageinfo = $this->getPageinfo($modul, $task);							
		$oSmarty->assign("aPageinfo",$aPageinfo);	
		//$url= md5(selfURL());
		$url = md5(json_encode($_REQUEST));
		if( is_file(VIEWPATH."layout/{$modul}".TPL)){
				$oSmarty->display("{$modul}".TPL,$url);
		}else{
				$oSmarty->display("default".TPL,$url);
		}
	}

	function getPageinfo($modul='home', $task="")
	{		
		if(file_exists(CONTROLPATH.$modul.____EXTPHP)) {
			
			if(file_exists(MODELPATH.$modul.____EXTPHP)) {
				require_once(MODELPATH.$modul.____EXTPHP);
			}
			if(file_exists(INFACEPATH.$modul.____EXTPHP)) {
				require_once(INFACEPATH.$modul.____EXTPHP);
			}
			require_once(CONTROLPATH.$modul.____EXTPHP);
			$namespace  = ucfirst($modul);
			$mod = new $namespace();
			if(method_exists($mod,"getPageinfo"))
				$aPageinfo = $mod->getPageinfo($task);
		}
		return $aPageinfo;
	}

}

?>