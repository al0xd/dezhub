<?php
class AdminCategory extends BaseCategory
{
	public $db,$s,$grid,$_prefix;
	function __construct() {
		parent::_setTypePost("product");
		parent::__construct();		
		parent::setTitle();
		if($this->isPost()){
			$form = $this->quickForm->getValue();
			$this->arr_fields = array(
				$this->_prefix.'name' 		=> stripcslashes($form[$this->_prefix.'name']),
				$this->_prefix.'keycode' 		=> stripcslashes($form[$this->_prefix.'keycode']),
				$this->_prefix.'active' 		=> $form[$this->_prefix.'active'],
				$this->_prefix.'parent_id' 		=> $form[$this->_prefix.'parent_id'],
				$this->_prefix.'z_index' 		=> $form[$this->_prefix.'z_index'],
				$this->_prefix.'type' 			=> $this->type,
			);
			if(checkMultiLang())
				$this->arr_fields [$this->_prefix.'lang_id'] = $form[$this->_prefix.'lang_id'];
		}
		
	}
	function run($task){
		
		switch ($task)
		{			
			case "add":
				$this->addItem();
				break;
			case "edit":
				$this->editItem();
				break;
			case "delete":
				$this->deleteItem();
				break;
			case "multi_delete":
				$this->multiDeleteItem();
				break;
			case 'change_status':
				$this->changeStatus();
				break;		
			case "save_order":
				$this->saveOrder();
				break;	
			case "changeLang":
				$this->changeLang();
				break;			
			case "list" :	
			default: 			
				$this->listItem();
				 break;
		}
	}

	function buildForm ( $task, $arrData = array() )
	{
		
		parent::setFormData($arrData);
		$dezhub = parent::setFormFieldSet("Edit form");
		if(checkMultiLang())
			$dezhub->addElement("select","lang_id",array("style"=>"width:200px"), array('options' => parent::getAssocLang(), 'label' => 'Ngôn ngữ'));
		$name = $dezhub->addElement('text', 'name', array('style' => 'width: 300px;',"data-marks"=>"removeMarks","data-source"=>"keycode"), array('label' => 'Tên danh mục:'));
		$dezhub->addElement('text', 'keycode', array('style' => 'width: 300px;'), array('label' => 'Tên đường dẫn:'));
		
		$arrPanrent = $this->getParent(0,0,$this->type);
		$arrPanrent = array(0=>"&nbsp;") + $arrPanrent;
		$dezhub->addElement('select', 'parent_id', array('style' => 'width: 300px;'), array('options'=>$arrPanrent,'label' => 'Danh mục cha:'));
		$dezhub->addElement('text', 'z_index', array('style' => 'width: 100px;'), array('label' => 'Thứ tự:'));
		$dezhub->addElement(
			'checkbox', 'active', null, array('content' => '', 'label' => 'Hiển thị:')
		);
		
		$name->addRule('required', 'Name is required');
		
		parent::insertSubmitButton();
				 
	if ( parent::validate() ) {
				
				if(isset($_POST['id']) && $_POST['id']){
					$this->dezDB->updateWithPk($_POST['id'], $this->arr_fields);
					$_SESSION['msg'] = $this->get_config_vars('msg_edit');	
				}else{				
					$this->dezDB->insert($this->arr_fields);
					$_SESSION['msg'] = $this->get_config_vars('msg_insert');
				}
				
				$this -> redirect("?".$this->submit_url);
				
	}
	

		parent::displayForm();	
		
	}
}
?>