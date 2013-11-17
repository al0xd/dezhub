<?php
class AdminDropzone extends Module_Base
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
		$this -> table = "dz_category";
		$this->_prefix ="";
		$this->pk =  $this->_prefix.'id';			
		$this -> dezDB -> setTable( $this->table );
		$this->type="post_tag";	
		$this->submit_url= self::getModuleUrl();
		if($this->isPost()){
			
		}
		
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
			$file = $_FILES['file'];
			self::uploadPhoto($file);
		}
	}
	
	function uploadPhoto ($file="")
	{
			$tmp_name = $file["tmp_name"];
			$name = $file["name"];
			$uploads_dir = SITE_DIR.$_COOKIE['user_folder']."/images/dropzone";
			move_uploaded_file($tmp_name, $uploads_dir."/".$name);
	}
	
	function listItem()
	{
		
		$this -> getPath();
		$str = '           
	<p>
	<span class="label label-important">Lưu ý:</span>&nbsp;
	Plugin này chỉ hoạt động được trên các phiên bản mới nhất của: Chrome, Firefox, Safari, Opera & Internet Explorer 10.
	</p>
	<form action="?'.$this->submit_url.'&task=upload&ajax" class="dropzone" id="my-awesome-dropzone"></form>

';
	echo $str;
			
	}
}
?>