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
class AdminModule extends Module_Base{
public $quickForm,$table,$dezDB;
private $arr_fields;
	function __construct(){
		
		parent::__construct();
		parent::setTitle();
		parent::initForm();
		$this->table = "dz_admin_menu";
		$this -> dezDB -> setTable( $this->table );
		$this->submit_url= parent::getModuleUrl();
		if(parent::isPost()){
			$postval = $this->quickForm->getValue();
			$this->arr_fields  = array(
				"title" 	=> $postval['title'],
				"link" 		=> urlencode($postval['link']),
				"parent_id" => $postval['parent_id'],
				"z_index" 	=> $postval['z_index'],
				"showed" 	=> $postval['showed'],
				"icon" 		=> $postval['icon'],
				"create_date" 	=> date("Y-m-d h:i:s"),
			);
			
		}
	}
	function run($task=""){
		
		switch( $task ){
			case 'add':
				$this -> addItem();
				break;
			case 'edit':
				$this -> editItem();
				break;
			case 'delete':
				$this -> deleteItem();
				break;
			case 'delete_multile':
				$this -> deleteItems();
				break;
			case 'change_status':
				$this -> changeStatus($_GET['id'], $_GET['status']);
				break;
			case 'publish':						
				$this -> changeStatusMultiple( 1 );
				break;
			case 'unpublish':						
				$this -> changeStatusMultiple( 0 );
				break;
			case 'save_order':
				$this -> saveOrder();
				break;
			default:					
				$this -> listItem( $_GET['msg'] );		
				break;
		}							
	
	}
	function addItem()
	{
		$this->getPath();
		$this -> buildForm();
	}
	
	function editItem()
	{
		$this->getPath();
		$id = $_REQUEST['id'];
		$row = $this -> dezDB -> getRow( $id );
		$this -> buildForm( $row );
	}

	function deleteItem()
	{
		global  $oDb;
		$this->getPath();
		$id = $_GET["id"];
		$sql = "module_roll_id in (select id from dz_module_roll where module_id ='{$id}')";
		$res = $this->dezDB -> del_rec("dz_usertype_moduleroll", $sql );
		$sql = "module_id ='{$id}'";
		$res =  $this->dezDB -> del_rec("dz_module_roll", $sql );
		$this -> dezDB -> deleteWithPk( $id );
		$_SESSION['msg'] = $this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);
	}
	
	function deleteItems()
	{
		global $oDb;
		$aItems	 = $_GET['arr_check'];
		if(is_array( $aItems) && count( $aItems) > 0){
			$sItems = implode( ',', $aItems );
			$sql = "module_roll_id in (select id from dz_module_roll where module_id in ({$sItems}))";
		$this->dezDB -> del_rec( "dz_usertype_moduleroll",$sql );
		$sql = " module_id in ({$sItems})";
		$this->dezDB -> del_rec( "dz_module_roll",$sql );
			$this -> dezDB -> deleteWithPk( $sItems );
		}
		$_SESSION['msg'] = $this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);
	}
	
	function changeStatusMultiple( $status = 0 )
	{
		$aItems	 = $_GET['arr_check'];
		if(is_array( $aItems) && count( $aItems) > 0){
			$sItems = implode( ',', $aItems );
			$this -> dezDB -> updateWithPk( $sItems, array("showed" => $status) );
		}
		$_SESSION['msg'] = $this->get_config_vars('msg_change_status');
		$this -> redirect("?".$this->submit_url);
	}
	
	function saveOrder(){	
		$aItem = $_GET['z_index'];
		if(is_array($aItem) && count( $aItem ) > 0){
			// save order for item.
			foreach( $aItem as $key => $value){
				if( !is_numeric($value)) $value = 0;				
				$this -> dezDB -> updateWithPk( $key, array('z_index' => $value ));
			}
		}	
		$_SESSION['msg'] = $this->get_config_vars('msg_saveorder');
			$this -> redirect("?".$this->submit_url);
	}
	
	function getRoll($moduleId){
		global $oDb;
		$sResult = "";
		$stbl1 = 'dz_roll';
		$aChecked = array();
		if( $moduleId ){
			$stbl2 = 'dz_module_roll';
			if($moduleId ) $where = " and module_id = '{$moduleId}'";
			$sql = "SELECT t1.id FROM {$stbl1} t1 join (SELECT * FROM {$stbl2} WHERE 1 {$where}) t2 on(t1.id = t2.roll_id) WHERE 1";
			$aChecked = $this->dezDB -> getCol( $sql );
		}
		
		$result = $this->dezDB -> getAssocTable($stbl1,"id,title" );
		if(count($result) > 0){
			foreach ( $result as $key => $val){
				if( in_array( $key, $aChecked )) $sChecked = "checked=\"checked\"";
				else $sChecked = "";
				$sResult .= "<label class='checkbox'><input type=\"checkbox\" name=\"module_roll[]\" value=\"{$key}\" {$sChecked}>{$val}</label>";
			}
		}
		
		return $sResult;
	}
	
	function removeRoll( $moduleId ){
		$stbl ="dz_module_roll";
		if( $moduleId ){			
			$sql = "module_id = '{$moduleId}'";
			$this->dezDB -> del_rec ($stbl, $sql );
		}
	}
	
	function addRoll( $moduleId, $aRollId ){
		$stbl = "dz_module_roll";
		foreach( $aRollId as $key => $val ){
			$data = array(
				"module_id"=>$moduleId,
				"roll_id"=>$val
			);
			$this->dezDB -> add_rec ($stbl,$data );
		}
	}
	
	function buildForm( $data=array() , $msg = ''){
		

		// data source with default values:
		if($data){
			$data['link'] = urldecode($data['link']);
		}
		parent::setFormData($data);
		$this->quickForm -> addElement(
			'text', 
			'title', 
			array('size' => 50, 'maxlength' => 255), 
			array("label"=>"Tên")
		);
		$this->quickForm -> addElement(
			'text', 
			'link',  
			array('size' => 50, 'maxlength' => 255), 
			array("label"=>"Link")
		);
		 $this -> getAllCategory($aParent,0);
		$aParentt = array(0 => "- - - Root Module - - -" ) + $aParent;
		$this->quickForm -> addElement(
			'select', 
			'parent_id',  
			NULL,
			array("options"=>$aParentt,"label"=>"Parent")
		);
		$this->quickForm -> addElement(
			'text', 
			'icon', 
			array('size' => 50, 'maxlength' => 255), 
			array("label"=>"Class Css")
		);
		$this->quickForm -> addElement(
			'text', 
			'z_index',  
			array('size' => 10, 'maxlength' => 50,"style"=>"width:50px"), 
			array("label"=>"Số thứ tự")
		);
		$aShowed = array( 0 , 1);
		$this->quickForm -> addElement('checkbox', 'showed', null, array("label"=>"Hiển thị"));
		$this->quickForm -> addStatic("static", null, array("content"=> $this -> getRoll( $data['id']),"label"=>"Thiết lập quyền"));
		parent::insertSubmitButton();
		
		if( parent:: validate())
		{	
			
			if( !$_POST['id'] ){
				
				 $id = $this -> dezDB -> insert($this->arr_fields);
				 if( is_array($_POST['module_roll']) && count( $_POST['module_roll']) > 0){
				 	$this -> addRoll( $id, $_POST['module_roll']);
				 }
					$_SESSION['msg'] = $this->get_config_vars('msg_insert');
			}else {
				$id = $_REQUEST['id'];				
				$this -> dezDB -> updateWithPk($id, $this->arr_fields);
				$this -> removeRoll( $id );
				if( is_array($_POST['module_roll']) && count( $_POST['module_roll']) > 0){
				 	$this -> addRoll( $id, $_POST['module_roll']);
				}
					$_SESSION['msg'] = $this->get_config_vars('msg_edit');
			}
			
				$this->quickForm->toggleFrozen(true);
				$this -> redirect("?".$this->submit_url);
		}
		
		parent::displayForm();
	}
	function getAllCategory(&$arrPanrent,$idp=0, $partten = "")
	{		
		global $oDb;
		$stbl =$this->table;
		$_prefix = "";
		// type of category
		$sWhere = "{$_prefix}parent_id={$idp}";
		// if use language
		//if has id of current item, get other item
		
		$sql="select {$_prefix}id,{$_prefix}title from {$stbl} where {$sWhere}";	
		$rows=$this->dezDB->getAllSql($sql);
		if(count($rows)){
		  	foreach($rows as $row)
		    {
				 $arrPanrent[$row["{$_prefix}id"]] = $partten.$row["{$_prefix}title"];
				 self::getAllCategory($arrPanrent,$row["{$_prefix}id"],$partten." -- ");
			}
		}
	}

	
	function getParentModule(){
		$sTbl = $this -> dezDB -> getTable();

		$query = "SELECT id, title FROM {$sTbl} WHERE parent_id=0";
		$result = $this->dezDB -> getAssocSql( $query );
		
		return $result;
	}
	
	function changeStatus()
	{
		$id = $_GET['id'];
		$status = $_GET['status'];	
		$field  = $_GET['field'];	
		$this -> dezDB -> updateWithPk ( $id, array ( $field => $status));		
		
	}	

	function listItem( $sMsg= '' )
	{		
				
		
		$this->getPath();						
		$this->grid->setMethod($this->submit_url);
		
		$table = $this -> dezDB -> getTable();
		
		$order = ($_GET['sort_by'])?($_GET['sort_by']):'z_index';
		$orderType = $_GET['sort_value'];
		if( $_GET['filter_title']!= '')
			$where[] = " title like '{$_GET['filter_title']}'";
		if( $_GET['filter_show']!= '')
			$where[] = " showed = '{$_GET['filter_show']}'";
		
	//	$where[] = " editable = '1' ";	
		if( is_array( $where) && count( $where )> 0)
			$condition = implode( " and ", $where );
		
		$aData = $this -> multiLevel( $table, "id", "parent_id", "*", "{$condition}", "{$order} {$orderType}");
		
		foreach ( $aData as $key => $row){
			if( $row['level'] > 0){				
				$aData[$key]['title'] = $this -> getPrefix( $row['level']).$row['title'];
			}
		}
		
		$this->grid->setTable($table);
		
		$this->grid->addFilter(array('field' => 'title','display' => 'Title','type' => 'text','name' => 'filter_title','selected' => $_REQUEST['filter_title']));
		$this->grid->addFilter(array('field'=>'showed','display'=>'Showed','name'=>'filter_show','selected'=>$_REQUEST['filter_show'],'options'=>array('No','Yes')));
		
		$this->grid->addField(array("field" => "id","primary_key" =>true,"display" => "Id","sortable" => true));
		$this->grid->addField(array("field" => "title","display" => "Title","sortable" => true,"style"=>"text-align:left;"));
		$this->grid->addField(array("field" => "z_index","display"=> "Order","datatype" => "order","sortable" => true,"order_default"=> "asc"));
		$this->grid->addField(array("field" => "showed","display" => "Showed","datatype" => "publish","sortable" => true));
		$this->grid->addField(array("field" => "create_date","display" => "Create Date","sortable" => true));
		
		$this->grid->addTaskAll(array("task" => "delete_multile","display" => "Xóa"));
		$this->grid->addTaskAll(array("task" => "unpublish","display" => "Hủy kích hoạt"));
		
		$this->grid->setTask($this->getAct());
		
		$this->grid -> setMessage( $_SESSION['msg'] );
		$this->grid->displayGridTable($aData);		
		unset($_SESSION['msg']);
	}		
	
}

?>