<?php
class AdminPartner extends BasePartner  
{
	public $db,$s,$grid,$type,$type_item,$_prefix,$dezDB,$quickForm,$submit_url;
	function __construct() {
		parent::__construct();
	}
	
	function listItem()
	{
		parent::getPath();
	 	$this->grid->setMethod($this->submit_url);
	 	$this->grid->setTable($this->table);		
		$arr_cols= array(					
			array(
				"field" => $this->_prefix."id",					
				"primary_key" =>true,
				"display" => $this->get_config_vars('id'),
				"sortable" => true							
			),	
			array(
				"field" => $this->_prefix."photo",
				"display" => "Hình ảnh",
				"datatype" =>"img",
			),
			array(
				"field" => $this->_prefix."title",
				"display" => "Name",
				"sortable"	=> true
			),
			
//			array(
//				"field"	=> $this->_prefix."code",
//				"display"	=> "Email",
//				"datatype"	=> "text"				
//			),
			array(
				"field"	=> $this->_prefix."description",
				"display"	=> "Thứ tự",
				"datatype"	=> "order"				
			),
//			array(
//				"field"	=> $this->_prefix."content",
//				"display"	=> "Skyper",
//				"datatype"	=> "text"				
//			),
//			array(
//				"field"	=> $this->_prefix."updatetime",
//				"display"	=> "Cập nhật lần cuối",
//				"datatype"	=> "text"				
//			),
			array(
				"field"	=> $this->_prefix."status",
				"display"	=>"Hiển thị ",
				"datatype"	=> "publish",
				"sortable" => true									
				),
			
			
		);		
		
		$this->grid->setField($arr_cols);
		
		$this->grid->addFilter(
			array(
				'field'=>$this->_prefix. 'title',
				'type'=>'text',
				"operator"=>"like",
				'display' =>"Tìm kiếm",
				'name' => $this->_prefix.'title',
				'selected'=> $_REQUEST[$this->_prefix.'title']
			)
		);
		$this->grid->addFilter(
			array(
				'field'=> $this->_prefix.'createtime',
				'type'=>'date',
				'display' =>"Ngày khởi tạo",
				"operator"=>"=",
				'name' => $this->_prefix.'createtime',
				"style"=>"width:90px",
				'selected'=> $_REQUEST[$this->_prefix.'createtime']
			)
		);
		if(checkMultiLang())
			$this->grid->addFilter(
				array(
					'field'=>$this->_prefix.'lang_id',
					'display'=>'Language',
					'name'=>$this->_prefix.'lang_id',
					'selected'=>$_REQUEST[$this->_prefix.'lang_id'],
					'options'=>$this->getAssocLang()
				)
			);
			
		$this->grid->setTask($this->getAct());
		$this->grid->addTaskAll(parent::getAct('multi_delete'));
		$this->grid->addTaskAll(parent::getAct('publish'));
		$this->grid->addTaskAll(parent::getAct('unpublish'));
		$this->grid -> setMessage( $_SESSION['msg'] );
		$this->grid -> where( " {$this->_prefix}type = '{$this->type}'" );
		unset( $_SESSION['msg'] );
		$this->grid->displayGrid();
		
	}	

	function buildForm ( $task, $arrData = array() )
	{
		$sql = "select distinct group_id from dz_group_attribute where attribute_id=".$arrData[$this->_prefix.'id'].
		" and post_type='{$this->type}'";
		$arrData["group_id"] = $this->db->getCol($sql);
		if($task=='edit'){
			$arrData[$this->_prefix. 'updatetime'] = date("Y-m-d h:i:s",time());
//			$arrData[$this->type. '_meta_tag']= parent::getTagsbyID($arrData[$this->_prefix.'id'],$this->type);
//			$arrData[$this->type. '_meta_title'] = parent::getMetaPageTitle($arrData[$this->_prefix.'id'],$this->type);	
//			$arrData[$this->type. '_meta_description'] =  parent::getMetaPageDescription($arrData[$this->_prefix.'id'],$this->type);	
//			$arrData['gallery'] = _slide::get_gallery_by_id($arrData[$this->_prefix.'id'],$this->type);
		
		}
		parent::setFormData($arrData);
		// text input elements
		$dezhub = parent::setFormFieldSet("Thiết lập nội dung bài viết");
		if(checkMultiLang())
			$dezhub->addElement("select",$this->_prefix."lang_id",array("style"=>"width:200px"), array('options' => parent::getAssocLang(), 'label' => 'Ngôn ngữ'));


//		$arrPanrent = $this->getParent(0,0);
		$name = $dezhub->addElement('text', $this->_prefix.'title')->setLabel("Name");
		$dezhub->addElement('text', $this->_prefix.'gid')->setLabel("Trang web");
		$dezhub->addElement('imagepopup', $this->_prefix.'photo', array("data-folder"=>"Images"), array('label' => 'Ảnh đại diện:'));
//		$dezhub->addElement('text', $this->_prefix.'code')->setLabel("Email");
		$dezhub->addElement('text', $this->_prefix.'description')->setLabel("Thứ tự");
//		$dezhub->addElement('text', $this->_prefix.'content')->setLabel("Skyper");
		
//		parent::insertFormMeta();
		$config = parent::setFormFieldSet("Cấu hình bài viết");
		$config->addElement(
			'checkbox', $this->_prefix.'status', null, array('content' => '', 'label' => 'Xuất bản:')
		);
		if($task=='edit'){
			$config->addElement('datetime',$this->_prefix. 'updatetime')->setLabel("Ngày cập nhật");
			$config->addElement('datetime',$this->_prefix. 'createtime')->setLabel("Ngày khởi tạo");
		}
		
		
		$name->addRule('required', 'Name không được để trống');
		//$select->addRule('required', 'Bắt buộc chọn danh mục');
		//$editor->addRule('required', 'Bạn phải nhập nội dung cho bài viết!');
		parent::insertSubmitButton();

	if (parent::validate()) {
			// group
				if(isset($_POST['id']) && $_POST['id']){
					$news_id = 	$_POST['id'];
					$this->dezDB->updateWithPk($_POST['id'], $this->arr_fields);
					$_SESSION['msg'] = $this->get_config_vars('msg_edit');
				}else{				
					$news_id = $this->dezDB->insert($this->arr_fields);
					$_SESSION['msg'] = $this->get_config_vars('msg_insert');
				}
				$this->quickForm->toggleFrozen(true);
				$this -> redirect("?".$this->submit_url);
				
	}
	

		parent::displayForm();	
	
		
	}	
	function addItem()
	{		
		$this -> getPath();
		$this -> buildForm( 'add' );
	}
	
	function editItem()
	{
		$id = intval($_GET['id']);		
		$this -> getPath();
		$row = $this->dezDB->getRow($id);	
		$this -> buildForm( 'edit', $row );
	}	
	function getParent($id=0,$idp=0){

		$aResult = array();		

		$this -> setParent($aResult, $id, $idp);		

		return  $aResult;
	
	}
	function setParent(&$arrPanrent,$id,$idp=0,$text='', $partten = " --- ")
	{		
		$stbl ="dz_category";
		$sWhere = " parent_id={$idp} ";
		$sOrder = " order by id asc ";
		$sWhere .= " and type='{$this->type}' ";
		if($id){
			$sWhere.= " and id<>{$id}";
		}
		
		$sql="select id,name from {$stbl} where {$sWhere} {$sOrder}";	
		$rows=$this->db->getAssoc($sql);
		if($rows){
		  	foreach($rows as $key=>$row)
		    {
				 $arrPanrent[$key] = $text. $row;
				 $this->setParent($arrPanrent,$id,$key,$text.$partten);
			}
		}
	}
	function deleteItem()
	{
		$id = $_GET['id'];
//		$this->removephoto($id);
		$this->dezDB->deleteWithPk($id);
		$_SESSION['msg'] =$this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);	
	}
	
	function multiDelete()
	{
		$arrId = $_GET['arr_check'];	
		foreach ( $arrId as $iId ){
//			$this->removephoto($iId);
			$this->dezDB->deleteWithPk($iId);
		}
		$_SESSION['msg'] =$this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);	
	}
	
	function changeStatus()
	{
		$id = $_GET['id'];
		$status = $_GET['status'];	
		$field  = $_GET['field'];	
		$this -> dezDB -> updateWithPk ( $id, array ( $field => $status));		
		
	}	

	function saveOrder()
	{
		$arrOrder = $_GET[$this->_prefix.'description'];
		
		foreach ( $arrOrder as $key => $value )
		
			$this -> dezDB -> updateWithPk ( $key , array ( $this->_prefix.'description' => $value ));		
		
		$_SESSION['msg'] = $this->get_config_vars("msg_saveorder");
		$this -> redirect("?".$this->submit_url);	
	}
	
	function changeStatusMultiple($status)
	{		
		$sIds = implode(",", $_GET['arr_check']);
		$this -> dezDB -> updateWithPk ( $sIds , array ( $this->_prefix.'status' => $status ));				
		
		if($status==1)
			$_SESSION['msg'] = $this->get_config_vars("msg_publish");
		else 
			$_SESSION['msg'] = $this->get_config_vars("msg_unpublish");
		$this -> redirect("?".$this->submit_url);	
	}
}
?>
