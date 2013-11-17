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
	class AdminLanguage extends Module_Base
	{
		private $arr_fields;
		public $quickForm,$dezDB;
		function __construct(){
			
			parent::__construct();
			parent::setTitle();
			parent::initForm();
			$sTbl = "dz_lang";
			$this -> dezDB -> setTable( $sTbl );
			$this->submit_url= parent::getModuleUrl();
			$this->dezDB->setPrimaryKey('id');
			if(parent::isPost()){
				$val = $this->quickForm->getValue();
				$this->arr_fields = array(
					"name"=>$val['name'],
					"filename"=>$val['filename'],
					"content"=>$val['content'],
				);
			}
		}
        
		function run($task=""){
			switch( $task ){
				case 'add':
					$this -> addLang();
					break;
				case 'edit':
					$this -> editLang();
					break;
				case 'delete':
					$this -> deleteLang($_GET['id']);
					break;
				case 'set_default':
					$this -> setDefault( $_GET['id'] );
					break;
				default:						
					$this -> listLang();
					break;
			}
		
		}
        function listLang( $msg= '')
		{
			
			$this->getPath();			
			$this->grid->setTable($this -> dezDB -> getTable());
			$this->grid->setMethod(parent::getModuleUrl());
			
			$this->grid->addField(array("field" => "id","display" => $this->get_config_vars('id'),"primary_key" => true,"sortable" => true));
			$this->grid->addField(array("field" => "name","display" => $this->get_config_vars('name'),"sortable" => true));
			$this->grid->addField(array("field" => "filename","display" => $this->get_config_vars('file_config'),"sortable" => true));
			$this->grid->addField(array("field" => "isdefault","display" => $this->get_config_vars('default'),"datatype" => "boolean"));
						
			
			$this->grid->addTask($this->getAct("add"));
			$this->grid->addTask($this->getAct("edit"));
			$this->grid->addTask($this->getAct("delete"));
			$this->grid->addTask(
				array(
					"task"=>"set_default",
					"icon"=>"icon-flag",
					"tooltip"=>$this->get_config_vars("toltip_default"),
					"confirm"=>$this->get_config_vars("default_lang_confim")
				)
			);
			$this->grid -> setMessage( $_SESSION['msg'] );
			$this->grid -> displayGrid();
			unset($_SESSION['msg']);
		}

		function buildForm($data, $type = '')
		{
			
		$this->getPath();
		
		parent::setFormData($data);
			
		$fsText = parent::setFormFieldSet();
		$abt = array('style' => 'width: 100px');
		
		if($data["id"]){
			$abt['readonly'] ="readonly";
		}
		$rename = $fsText->addElement('text', 'name', null, array('label' => "Tên ngôn ngữ"));
		$filename = $fsText->addElement('text', 'filename', $abt, array('label' => $this->get_config_vars('file_config')));
		$fsText -> addElement('textarea', "content",  array("style" => "width:600px; height:600px;"),array("label"=>"Nội dung"));
		$rename->addRule('required', 'Tên ngôn ngữ không được để trống');
		$filename->addRule('required', 'Tên file không được để trống');
		parent::insertSubmitButton();
		
			
			if(parent::validate())
			{
				$data = array(
					"name" => $this->arr_fields['name'],
					"filename" =>  $this->arr_fields['filename']
				);
				
				if( !$_POST['id'] )
				{	
					$this -> createFile( $data['filename'] );
					$this -> write_file_config($data['filename'], $this->arr_fields['content']);
					$this -> dezDB -> insert($data);
				 	$_SESSION['msg'] = $this->get_config_vars('msg_insert');
				}
				else
				{
					$id = $_POST['id'];
					$this -> write_file_config($data['filename'], $this->arr_fields['content']);
					$this -> dezDB -> updateWithPk($id, $data);
					$_SESSION['msg'] = $this->get_config_vars('msg_edit');
				}
				
				$this->redirect("?".parent::getModuleUrl());
			}
			
			parent::displayForm();
		}
		
		function checkExistLang( $langName='' ){
			global $oDb;
			$sTbl = 'lang';
			
			$query = "name='{$langName}'";		
			$row = $this->dezDB -> getRowTable( $sTbl,$query );
			if( is_array($row) && count( $row ) > 0 ){
				return false;
			}		
			return true;
		}
		
		function addLang()
		{
			global $oDb;
			$data = array();
			$table = $this -> dezDB -> getTable();
			$sql = "select filename from {$table} where `isdefault` ='1'";
			$default_file = $this->dezDB -> getOne($sql);
			
			$data['content'] = $this -> read_file_config($default_file);			
			$this -> buildForm($data,'');
		}
		
		function editLang()
		{
			$id = $_GET['id'];
			$result = $this -> dezDB -> getRow( $id );
			
			$result['content'] = $this -> read_file_config($result['filename']);	
					
			$this -> buildForm($result, 'edit');
		}	
		
		function deleteLang($id)
		{
			$table = $this -> dezDB -> getTable();
			if($id){			
				$sql = "id = '$id'";
				$aLang = $this->dezDB -> getRowTable($table,$sql);
				if( $aLang['isdefault'] == '1'){
					$_SESSION['msg'] = $this->get_config_vars("do_not_delete_default_lang");
					$this -> listLang();
					return;
				}
				$conf_file = $aLang['filename'];
				if($conf_file)
				{
					$file_path = SITE_DIR."languages/".$conf_file;
					if(is_file($file_path))
					{
						@unlink($file_path);
					}
				}
				
				$sql = " id = '$id'";
				$res = $this->dezDB -> del_rec($table,$sql);
				$_SESSION['msg'] = "Item has been deleted at ". date('Y-m-d h:i:s');
				parent::redirect($_COOKIE['re_dir']);
			}
		}
		
		function setDefault( $langId ){
			if( $langId ){
				$table = $this->dezDB->getTable();
				$sql = "select count(*) from {$table} where id='$langId'";
				$check = $this->dezDB -> getOne($sql );
				if( $check ){
					$sql = "update {$table} set isdefault='0' where 1";
					$this->dezDB ->Execute($sql);
					$sql = "update {$table} set isdefault='1' where id='{$langId}'";
					$this->dezDB -> Execute($sql);
				}else{
					$msg = "Language is not exist !";
					$this -> listLang( $msg );
				}
			}else{
				$_SESSION['msg'] = $this->get_config_vars('no_lang_chose');
				$this -> listLang();
			}
			
				$_SESSION['msg'] = $this->get_config_vars('lang_has_save');
			$this -> listLang();
			$this->redirect("?".parent::getModuleUrl());
		}
		
		function read_file_config($filename)
		{
			$file_path = SITE_DIR."languages/".$filename;
			if(is_file($file_path))
			{
				$handle = fopen($file_path,'r');
				$filesize = filesize($file_path);
				if($filesize)
					$contents = fread($handle, $filesize);	
				else $contents="";
				fclose($handle);
			}
			return $contents;		
		}
		
		function write_file_config($filename,$content)
		{
			$file_path = SITE_DIR."languages/".$filename;			
			$handle = fopen($file_path,'w');
			$contents = fwrite($handle, $content);	
			fclose($handle);				
		}
		
		function createFile( $filename ){
			if( $filename != ''){
				$table = $this -> dezDB -> getTable();
				$sql = "select filename from {$table} where `isdefault` ='1'";
				$default_file = $this->dezDB -> getOne($sql);
				$sSourceFile = SITE_DIR."languages/".$default_file;				
				$sDesFile = SITE_DIR."languages/".$filename;
				@copy( $sSourceFile, $sDesFile); 
				@chmod( $sDesFile, 0777);				
			}
		}
	}
?>