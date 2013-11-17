<?php	

/**

	@ DezHub Framework (DHF) v2.0
	@ © 2013 - 2014
	@ Author Hungdv
	@ Email dinhhungvn@gmail.com
	@ www.dezhub.com
	@ Mobile (84)977-167-006
	------------------------------------
	@ Package class security
	@ Description: Build firewall for POST & GET

*/

class security
{
    function secureSuperGlobalGET(&$value, $key)
    {
        if(is_array($_GET[$key])){
			foreach($_GET[$key] as $k=>$v){
				return self::secureSuperGlobalGET($v,$k);
			}
		}else
			$_GET[$key] = htmlspecialchars(stripslashes($_GET[$key]));
			$_GET[$key] = str_ireplace("script", "blocked", $_GET[$key]);
			$_GET[$key] = mysql_real_escape_string ($_GET[$key]);
       		 return $_GET[$key];
    }
   
    function secureSuperGlobalPOST(&$value, $key)
    {
         if(is_array($_POST[$key])){
			foreach($_POST[$key] as $k=>$v){
				return self::secureSuperGlobalPOST($v,$k);
			}
		}else{
			$_POST[$key] = htmlspecialchars(stripslashes($_POST[$key]));
			$_POST[$key] = str_ireplace("script", "blocked", $_POST[$key]);
			$_POST[$key] = mysql_real_escape_string ($_POST[$key]);
			return $_POST[$key];
		}
    }
       
    function secureGlobals()
    {
        array_walk($_GET, array($this, 'secureSuperGlobalGET'));
        array_walk($_POST, array($this, 'secureSuperGlobalPOST'));
    }
}	
?>