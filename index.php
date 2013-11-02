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




		ob_start();
		session_start(true);
//		error_reporting(E_ALL ^ E_NOTICE);
//		error_reporting(E_ERROR | E_PARSE);
//		ini_set("display_errors",false);
		define("SITE_DIR", dirname(__FILE__)."/");
		// set time zone default
		date_default_timezone_set("Asia/Ho_Chi_Minh"); 
		//define version
		define("VER", "1.0");
/**
	define web root
*/	
		define('PUBLICFOLDER', 'public');



/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 *
 * NO TRAILING SLASH!
 *
 */
/* 
*define SITE PATH 
*
*/	
	define("SITE_URL", "http://{$_SERVER['SERVER_NAME']}/");
	
/* 
*define Application PATH 
*
*/	
	
	$application_folder = 'application';
	define('APPPATH', SITE_DIR.$application_folder.'/');
/* 
*define controller path 
*
*/	
	define('CONTROLPATH', SITE_DIR.$application_folder.'/controller/');
/* 
*define interfaces path 
*
*/	
	define('INFACEPATH', SITE_DIR.$application_folder.'/interfaces/');
/* 
*define model path 
*
*/	
	
	define('MODELPATH',SITE_DIR. $application_folder.'/models/');
/* 
*define view path 
*
*/	
	define('VIEWPATH', SITE_DIR.$application_folder.'/view/');

/* 
*define EXT FILE
*
*/	
	define("____EXTPHP", ".php");
/* 
*define TPL FILE
*
*/	
	define("TPL", ".tpl");


/**
	define CACHE DATA
*/	

	define('CACHE_DATA', true); // false tat cache, true bat cache 
	define('CACHE_TIME', 10); // thoi gian luu cache, chi tac dung khi cache duoc bat
		
		
		
	require_once(SITE_DIR."config/dezhub.php");
	$oSmarty->clearCache(null,"page");

/** 

*

*

*

*
/* End of file index.php */
/* Location: ./index.php */


