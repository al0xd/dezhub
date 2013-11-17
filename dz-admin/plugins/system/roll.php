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
class AdminRoll extends Module_Base{
	public $db,$dezDB,$grid,$quickForm;
	function __construct(){
		parent::__construct();
		parent::initForm();
		parent::setTitle();
		$this->table = "dz_roll";
		$this->submit_url= parent::getModuleUrl();
		$this -> dezDB -> setTable( $this->table );
		if($this->isPost()){
			$this->arr_fields = array(
				'name' => stripcslashes($_POST['name']),
				'title' => stripcslashes($_POST['title']),
				'icon' => stripcslashes($_POST['icon']),
				'ordered' => intval($_POST['ordered']),
			);
		}
	}
	function run($task=""){
		switch($task){
			case 'add':
				$this -> addItem();
				break;
			case 'edit':
				$this -> editItem( );
				break;
			case 'delete':
				$this -> deleteItem( );
				break;
			case 'save_order':
				$this -> saveOrder();
				break;
			default:
				$this -> listItem( $_REQUEST['msg']);
				break;
		}
	
	}	
	function addItem()
	{	
		$this -> getPath();
		self::buildForm();
	}

	function editItem()
	{
		$this -> getPath();
		$id = $_REQUEST['id'];
		$row = $this -> dezDB -> getRow( $id );
		$this -> buildForm( $row );
	}

	function deleteItem()
	{	
		$id = $_REQUEST["id"];
		$sql = " module_roll_id in (select id from dz_module_roll where roll_id ='{$id}')";
		$res = $this->dezDB-> del_rec( "dz_usertype_moduleroll", $sql );
		$sql = " roll_id ='{$id}'";
		$res = $this->dezDB -> del_rec("dz_module_roll", $sql );
		$this -> dezDB -> deleteWithPk( $id );
		$_SESSION['msg'] = $this->get_config_vars('msg_delete');
		$this -> listItem();
	}	
	
	function saveOrder(){	
		$aItem = $_GET['ordered'];
		if(is_array($aItem) && count( $aItem ) > 0){
			// save order for item.
			foreach( $aItem as $key => $value){
				if( !is_numeric($value)) $value = 0;				
				$this -> dezDB -> updateWithPk( $key, array('ordered' => $value ));
			}
		}	
		$_SESSION['msg'] = $this->get_config_vars('msg_saveorder');
		$this -> listItem( $msg );
	}
	
	function buildForm( $arrData=array()){
		
		parent::setFormData($arrData);

		$dezhub = parent::setFormFieldSet();

		$name = $dezhub->addElement('text', 'title', array('style' => 'width: 300px;'), array('label' => 'Tên quyền:'));
		$dezhub->addElement('text', 'name', array('style' => 'width: 300px;'), array('label' => 'Mã quyền'));
		$dezhub->addElement('text', 'icon', array('style' => 'width: 100px;'), array('label' => 'Icon class'));
		$dezhub->addElement('text', 'ordered', array('style' => 'width: 100px;'), array('label' => 'Thứ tự'));
	
		
		$name->addRule('required', 'Tên sản phẩm không được để trống');
//		$reins->addRule('required', 'Inst is required');
		parent::insertSubmitButton();

		
		if( parent::validate())
		{
			if( !$_POST['id'] ){
				 $this -> dezDB -> insert($this->arr_fields);
				$_SESSION['msg'] = $this->get_config_vars('msg_insert');
			}else {
				$id = $_POST['id'];
				$this -> dezDB -> updateWithPk($id, $this->arr_fields);
				$_SESSION['msg'] = $this->get_config_vars('msg_edit');
			}
			
			$this->quickForm->toggleFrozen(true);
			$this -> redirect("?".parent::getModuleUrl());
		}
		
		parent::displayForm();	
	}	
	
	function listItem( $sMsg = '')
	{		
		
		$this->getPath();						
		$this->grid->setMethod($this->submit_url);
		$this->grid->setTable($this->dezDB->getTable());
		
		$this->grid->addField(array("field" => "id","primary_key" =>true,"display" => "Id","sortable" => true));
		$this->grid->addField(array("field" => "title","display" => "Tên quyền","sortable" => true));
		$this->grid->addField(array("field" => "name","display" => "Mã quyền","sortable" => true));
		$this->grid->addField(array("field" => "ordered","display" => "Order","datatype"	=> "order","sortable" => true,"order_default"=> "asc"));
	//	$this->grid->addField(array("field" => "editable","visible" => "hidden"));
		
			$this->grid->addTask(parent::getAct("add"));
			$this->grid->addTask(parent::getAct("edit"));
			$this->grid->addTask(
				array(
					"task"=>"delete",
					"text"=>"Xóa",
					"icon"=>"icon-remove",
					"tooltip"=>"Xóa dữ liệu",
					"confirm"=>"Việc xóa này rất nguy hiểm, có thể sẽ ảnh hưởng tới hệ thống. Bạn có chắc chắn muốn xóa?"
				)
			);

		$this->grid -> setMessage( $_SESSION['msg'] );
		$this->grid->displayGrid();
		unset($_SESSION['msg']);
	}		
	
}

?>