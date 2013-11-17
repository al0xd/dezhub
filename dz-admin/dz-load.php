<?php 
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

		require_once(ROOT_DIR."functions.php");		
		require_once(SITE_DIR."config/common".____EXTPHP);		
		require_once(SITE_DIR."config/database".____EXTPHP);		
		require_once(SITE_DIR.'classes/module.class.php');
		require_once(SITE_DIR.'classes/db.class.php');
		require_once(SITE_DIR."config/smarty.php");
		require_once(SITE_DIR."lib/datagrid/datagrid.php");
		require_once(SITE_DIR."config/pear_quickform.php");
		isPermission();
		checkMultiLang();
		$oSmarty->caching = false;
		$oSmarty->setTemplateDir("templates")		
		->setCompileDir("../public/templates_c")
		->setConfigDir("languages")
		->setCompileCheck(true);
		$oSmarty->configLoad("system.conf");

		$url = $_SERVER['REQUEST_URI'];
		$query = parse_url($url);
		if($query['path']){
			$url = $query['path'];
		}
		$url = str_replace("/dz-admin","",$url);
		$url = str_replace("/index.php","",$url);
		if($url!=""){
			$url = preg_replace("/^\//","",$url);
			$_lurl = explode("/",$url);
			if($_lurl[0]!="")
				$_GET['amod'] = $_REQUEST['amod'] = $_lurl[0];
			if($_lurl[1]!="")
				$_GET['atask'] = $_REQUEST['atask'] = $_lurl[1];
			if($_lurl[2]!="")
				$_GET['task'] = $_REQUEST['task'] = $_lurl[2];
			if($_lurl[3]!="")
				$_GET['id'] = $_REQUEST['id'] = $_lurl[3];
		}
		if($query['query']){
			parse_str($query['query'], $output);
			foreach($output as $k=>$v){
				$_GET[$k] = $v;
				$_REQUEST[$k] = $v;
			}
		}
