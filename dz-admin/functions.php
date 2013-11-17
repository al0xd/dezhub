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
	function loadModule($modul, $task= NULL, $other= array())	
		{
			global $oDb;
			global $oSmarty;
			if($task==NULL && isset($_REQUEST['task']))
				$task= $_REQUEST['task'];
		
			$fmodul = ucfirst($modul);
			
			if(file_exists("$modul.php")) {
				include_once("$modul.php");
				$mod = new $fmodul();
				$mod->run($task);
			}
		}
	function checkConfirmPassword($val='',$array = array()){
		$confirpass = $_REQUEST['password'];
		if($val==$confirpass && $val!="")
			return true;
		else
			return false;
	}	
	function checkPassword($pass=""){
		global $oDb;
		if($pass){
			$uid = $_COOKIE['dzh_uid'];
			if($uid){
				$sql = "select password from dz_user where id = $uid";
				$_pass = $oDb->getOne($sql);
				if($_pass && md5($pass) == $_pass )
					return true;
				else
					return false;
			}
		}else return false;
	}
	function checkSamePassword($newpass=""){
		if($newpass){
			$oldpass = $_REQUEST['oldpassword'];
			if($oldpass == $newpass){
				return false;
			}else return true;
		}
	}
	
	    function CheckTitle($t)
    {
        global $Titles;
        return $t > 0 && isset($Titles[$t]);
    }

    // Check that the first name is one of an approved list, callback function:
    function checkFNfunc($name)
    {
	$OKlist = array('John', 'Bill');
	return strcmp(array_search($name, $OKlist), '');
    }

	
	
?>