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
		
		require_once(SITE_DIR."config/common".____EXTPHP);		
		require_once(SITE_DIR."config/database".____EXTPHP);		
		require_once(SITE_DIR."config/rewriteurl".____EXTPHP);
		
		
	// xu ly duong dan
		$rewrite_url = new rewrite_url();
		$rewrite_url->Navigation();
	
	
	// Khoi tao cac thu muc co so
	
		make_data_default();
/*//

// @	Cai dat adodb 
   @ 	Cai dat Smarty
   @	Cai dat QuickForm

*/
		require_once(SITE_DIR."config/smarty".____EXTPHP);
		require_once(SITE_DIR."config/pear_quickform".____EXTPHP);
		
/*
	@ Thiet lap cac lop co so  cho du lieu
	@ Thiet lap cac lop co so cho ham va xu ly ham chung
*/
		require_once(SITE_DIR."classes/db.class".____EXTPHP);
		require_once(SITE_DIR."classes/module.class".____EXTPHP);

/*
	@ chan get_content
*/	
		if(!$_SERVER["HTTP_ACCEPT_ENCODING"] && !$_SERVER["HTTP_ACCEPT_LANGUAGE"])
		{
				echo "";
				exit();
		}



/**
*/		
		getDefaultLang($_GET["lang"]);
		
/*//

// @ Load language.conf

//

//-------------------------------------------------------

*/
//-------------------------------------

// @ Common function

//------------------------	
	$oSmarty->configLoad($_SESSION["lang_file"]);
		if(isset($_GET['mod'])){
			$mod = $_GET['mod'];
		}
		if(isset($_GET['task']))	{
			$task = $_GET['task'];
		}
		if(isset($_GET['ajax'])){
			// when run ajax scripts
			loadModule( $mod, $task );
		}else{
			// layout module
			loadModule("layout");
		}
