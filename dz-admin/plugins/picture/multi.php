<?php
class AdminMulti extends Module_Base
{
	var $table;
	var $pk;
	var $_prefix;
	var $arr_fields;
	var $mod;
	var $submit_url;
	function __construct() {
		
		parent::__construct();
		if(!isset($_REQUEST['ajax']))
			parent::setTitle();
		$this->submit_url= self::getModuleUrl();
		
	}
	function run($task){
		
		switch ($task)
		{			
			case "upload":
				$this->uploadFile();
				break;
			default: 			
				$this->listItem();
				 break;
		}
	}
	
	function uploadFile()
	{		
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$file = $_FILES['files'];
			//print_r($_FILES);
			self::uploadPhoto($file);
		}
	}
	
	function uploadPhoto ($file="")
	{
			$result = array();
			$uploads_dir = $_COOKIE['user_folder']."/images/multiple";

			foreach ($file["error"] as $key => $error) {
				$tmp_name = $file["tmp_name"][$key];
				$name = $file["name"][$key];
				$size = $file["size"][$key];
				move_uploaded_file($tmp_name,SITE_DIR.$uploads_dir."/".$name);
				
				$image=array(
					"name"=>$name,
					"size"=>$size,
					"type"=> $file["type"][$key],
					"delete_type"=>"DELETE",
				);
				if(in_array($file['type'][$key],array("image/jpeg","image/png","image/gif"))){
					$image['thumbnail_url'] = SITE_URL.$uploads_dir."/".$name;
				}
				$result[] = $image;
			}
			header('Content-type: text/json');
			header('Content-type: application/json');	
			$output['files'] = $result;
			echo json_encode($output);		
	}
	
	function listItem()
	{
		
		$this -> getPath();
		$oSmarty->display("form_multiple_upload.tpl");        
	
			
	}
}
?>