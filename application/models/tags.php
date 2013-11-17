<?php
__MODEL("category");
class BaseTags extends BaseCategory
{
	public $db,$s,$grid,$_prefix,$type;
	public function __construct() {
		parent::__construct();
		$this->type="post_tag";
		if($this->isPost()){
			$form = $this->quickForm->getValue();
			$this->arr_fields = array(
				$this->_prefix.'name' 		=> stripcslashes($form[$this->_prefix.'name']),
				$this->_prefix.'keycode' 		=> stripcslashes($form[$this->_prefix.'keycode']),
				$this->_prefix.'type' 			=> $this->type,
			);
			
			if(checkMultiLang())
				$this->arr_fields [$this->_prefix.'lang_id'] = $form[$this->_prefix.'lang_id'];
		}
		
	}
	
	public function listItem()
	{
		$this->getPath();		
	 	$this->grid->setMethod($this->submit_url);
		
		$table = $this->table;
		$where[] = "  type = '{$this->type}'";
		if($_GET['name']){
			$where[] = "  name like '%".$_GET['name']."%'";
		}
		$condition = implode(" AND ", $where);
		$order = ($_GET['sort_by'])?($_GET['sort_by']): $this->_prefix."id";
		$orderType = $_GET['sort_value'];
		$sSelectLang = ", (select name from dz_lang where dz_lang.id = lang_id ) as dz_lang";
		$aData = $this -> multiLevel( $table, "id",  "parent_id", "*{$sSelectLang}", "{$condition}", "{$order} {$orderType}");
		
		foreach ( $aData as $key => $row){
			if( $row['level'] > 0){				
				$aData[$key][ "name"] = $this -> getPrefix( $row['level']).$row[ "name"];
			}
		}
		
		$this->grid->setTable($table);
		
		$this->grid->addFilter(
			array(
				'field'=> 'name',
				'type'=>'text',
				'display' =>"Từ khóa",
				'name' => 'name',
				'selected'=> $_REQUEST['name']
			)
		);

		
		$this->grid->addField(array("field"=>"id","primary_key"=>true,"display"=>$this->get_config_vars('id'),"sortable"=>true,"width"=>50));
		$this->grid->addField(array("field"=>"name","display" => $this->get_config_vars('title'),"sortable" => true,"style"=>"text-align:left"));
		$this->grid->addField(array("field"=>"keycode","display" => "Slug","sortable" => true,"style"=>"text-align:left"));
			if(checkMultiLang())
				$this->grid->addField(array("field"=>"lang","display" => "Ngôn ngữ","style"=>"text-align:left"));
	
		$this->grid->addField(array("field"=>"type","display" => "Type","sortable" => true,"style"=>"text-align:left"));
		
		$this->grid->addTaskAll(array("task" => "multi_delete","display" => $this->get_config_vars('delete')));
		$this->grid->setTask($this->getAct());
		
		$this->grid -> setMessage( $_SESSION['msg'] );
		unset( $_SESSION['msg'] );
		
		$this->grid->displayGridTable($aData);		
	}
	

	public function buildForm ( $task, $arrData = array() )
	{
		$siteUrl = SITE_URL;	
		parent::setFormData($arrData);
		$dezhub = parent::setFormFieldSet('Edit form');
		if(checkMultiLang())
			$dezhub->addElement("select","lang_id",array("style"=>"width:200px"), array('options' => parent::getAssocLang(), 'label' => 'Ngôn ngữ'));
		$name = $dezhub->addElement('text', 'name', array('style' => 'width: 300px;',"data-marks"=>"removeMarks",
		"data-source"=>"keycode"))->setLabel("Tên từ khóa");
		$dezhub->addElement('text', 'keycode', array('style' => 'width: 300px;'), array('label' => 'Slug'));
		
		$name->addRule('required', 'Tên từ khóa bắt buộc nhập');
		parent::insertSubmitButton();
		 
	if (parent::validate()) {
				
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
	public function getAssocTags(){
		header('Content-type: text/json');
		header('Content-type: application/json');
		$sql = "select name as id,name as text from dz_category where type='{$this->type}' order by name asc";
		$data = $this->db->getAll($sql);
		echo json_encode($data);
	}
}
