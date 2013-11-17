<?php	 defined('SITE_DIR') or exit('Direct script access is not allowed!');
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


	global $oSmarty;	
	if(!is_object($oSmarty))

	{	

		define('SMARTY_RESOURCE_CHAR_SET', 'UTF-8');	
		require_once(SITE_DIR."lib/Smarty/SmartyBC.class.php");

		$oSmarty= new SmartyBC();

		if(isCache()){
			$oSmarty->caching = 1;
			$oSmarty->setCacheLifetime(CACHE_TIME); //set cache in 30 seconds.
			
		}

//		$oSmarty->debugging = false;
		$oSmarty->setTemplateDir("application/view");
				
		$oSmarty->setConfigDir( "languages")
		->setCompileDir(PUBLICFOLDER ."/templates_c")
		->setCacheDir(PUBLICFOLDER ."/cache");

		
	}
