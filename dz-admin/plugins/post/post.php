<?php
class AdminPost extends BasePost  
{
	public $quickForm,$db,$s,$submit_url,$slideshow;
	function __construct(){
		parent::__construct();
	}
	
	function run( $task )
	{	
		
		switch ( $task )
		{
			default:
				$this -> listItem();
				break;
			case 'add':
				$this -> addItem() ;
				break;
			case 'edit': 
				$this -> editItem();
				break;
			case 'delete':
				$this -> deleteItem();
				break;
			case 'multi_delete':
				$this -> multiDelete();
				break;
			case 'change_status':
				$this -> changeStatus();
				break;
			case 'publish':
				$this->changeStatusMultiple(1);
				break;
			case "changeLang":
				$this->changeLang();
				break;	
			case 'unpublish':
				$this->changeStatusMultiple(0);
				break;
			case 'save_order':
				$this -> saveOrder();
				break;
		}		
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
				"display" => "Tiêu đề bài viết",
				"sortable"	=> true
			),
			
			array(
				"field"	=> $this->_prefix."createtime",
				"display"	=> "Ngày khởi tạo",
				"datatype"	=> "text"				
			),
			array(
				"field"	=> $this->_prefix."updatetime",
				"display"	=> "Cập nhật lần cuối",
				"datatype"	=> "text"				
			),
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
			$arrData[$this->type. '_meta_tag']= parent::getTagsbyID($arrData[$this->_prefix.'id'],$this->type);
			$arrData[$this->type. '_meta_title'] = parent::getMetaPageTitle($arrData[$this->_prefix.'id'],$this->type);	
			$arrData[$this->type. '_meta_description'] =  parent::getMetaPageDescription($arrData[$this->_prefix.'id'],$this->type);	
//			$arrData['gallery'] = _slide::get_gallery_by_id($arrData[$this->_prefix.'id'],$this->type);
		
		}
		parent::setFormData($arrData);
		// text input elements
		$dezhub = parent::setFormFieldSet("Thiết lập nội dung bài viết");
		if(checkMultiLang())
			$dezhub->addElement("select",$this->_prefix."lang_id",array("style"=>"width:200px"), array('options' => parent::getAssocLang(), 'label' => 'Ngôn ngữ'));


		$arrPanrent = $this->getParent(0,0);
		$name = $dezhub->addElement('text', $this->_prefix.'title', 
			array("data-marks"=>"removeMarks","data-source"=>$this->_prefix."code"))->setLabel("Tiêu đề bài viết");
//		$dezhub->addElement('inputnumber',$this->_prefix. 'number')->setLabel("Number");
//		$dezhub->addElement('inputdate',$this->_prefix. 'date')->setLabel("Ngày tháng");
//		$dezhub->addElement('inputcurrency',$this->_prefix. 'price',array("style"=>"width:200px"))->setLabel("Giá cũ");
//		$dezhub->addElement('inputcurrency',$this->_prefix. 'price2',array("style"=>"width:200px"))->setLabel("Giá mới");
		
		$select = $dezhub->addElement("select","group_id",array("style"=>"height:150px !important","multiple"=>"multiple"), 
		array('options' => $arrPanrent))->setLabel("Danh mục");
		$dezhub->addElement('imagepopup', $this->_prefix.'photo', array("data-folder"=>"Images"), array('label' => 'Ảnh đại diện:'));
		
		$editor = $dezhub -> addElement ('editor' ,$this->_prefix. 'content',
		array("style"=>"width:300px"))->setLabel("Nội dung");
//		_slide::buidForm($this->quickForm,$arrData[$this->_prefix.'id']);
		parent::insertFormMeta();
		$config = parent::setFormFieldSet("Cấu hình bài viết");
		$config->addElement(
			'checkbox', $this->_prefix.'status', null, array('content' => '', 'label' => 'Xuất bản:')
		);
		if($task=='edit'){
			$config->addElement('datetime',$this->_prefix. 'updatetime')->setLabel("Ngày cập nhật");
			$config->addElement('datetime',$this->_prefix. 'createtime')->setLabel("Ngày khởi tạo");
		}
		
		
		$name->addRule('required', 'Tên sản phẩm không được để trống');
		$select->addRule('required', 'Bắt buộc chọn danh mục');
		$editor->addRule('required', 'Bạn phải nhập nội dung cho bài viết!');
		parent::insertSubmitButton();

	if (parent::validate()) {
			// group
				if(isset($_POST['id']) && $_POST['id']){
					$news_id = 	$_POST['id'];
					parent::removeGroupAttr(null,$news_id,"attr",$this->type);
					$this->dezDB->updateWithPk($_POST['id'], $this->arr_fields);
					$_SESSION['msg'] = $this->get_config_vars('msg_edit');
				}else{				
					$news_id = $this->dezDB->insert($this->arr_fields);
					$_SESSION['msg'] = $this->get_config_vars('msg_insert');
				}
				if(is_array($_POST['group_id'])){
					$group_id = $_POST['group_id'];
					foreach($_POST['group_id'] as $val){
						parent::insertGroupAttr($val,$news_id,$this->type);
					}
				}
				parent::insertMetaPage($news_id,$this->type);
				parent::insertTagbyPost($news_id,$this->type);
		//		_slide::update($news_id,$this->type,$_POST['gallery']);
				$this->quickForm->toggleFrozen(true);
				$this -> redirect("?".$this->submit_url);
				
	}
	

		parent::displayForm();	
	
		
	}	
}
?>
