<?php 
__MODEL("slideshow,option");
class BasePage extends Module_Base
{
	var $table;
	var $quickForm;
	public $db,$s,$grid,$type,$type_item,$submit_url,$_prefix,$dezDB,$option,$slide;
	public function __construct() {
		parent::__construct();
		$this->slide = new BaseSlideshow();
		$this->option = new BaseOption();
		parent::initForm();
//		parent::setTitle();
		$this->table = "dz_post";
		$this->dezDB->setPrimaryKey('id');
		$this->dezDB->setTable($this->table);
		$this->type='page';
		$this->_prefix='post_';
		$this->submit_url= parent::getModuleUrl();
		if($this->isPost()){
			$form = $this->quickForm->getValue();
			$createtime =  ($form[$this->_prefix.'createtime'])?$form[$this->_prefix.'createtime']:date("Y-m-d h:i:s");
			$updatetime =  ($form[$this->_prefix.'updatetime'])?$form[$this->_prefix.'updatetime']:date("Y-m-d h:i:s");
			$this->arr_fields = array(
				$this->_prefix.'title' => stripcslashes($form[$this->_prefix.'title']),
				$this->_prefix.'code' => stripcslashes($form[$this->_prefix.'code']),
				$this->_prefix.'photo' => stripcslashes($form[$this->_prefix.'photo']),
				$this->_prefix.'description' => stripcslashes($form[$this->_prefix.'description']),
				$this->_prefix.'content' => $form[$this->_prefix.'content'],
				$this->_prefix.'status' => $form[$this->_prefix.'status'],
				$this->_prefix.'lang_id' => $form[$this->_prefix."lang_id"],
				$this->_prefix.'type' =>$this->type,
				$this->_prefix.'createtime' => $createtime,
				$this->_prefix.'updatetime' => $updatetime,
				$this->_prefix."uid"=>($_COOKIE['dzh_uid'])?$_COOKIE['dzh_uid']:0
			);
		}
	}
	protected function addItem()
	{		
		$this -> getPath();
		$this -> buildForm( 'add' );
	}
	
	protected function editItem()
	{
		$id = intval($_GET['id']);		
		$this -> getPath();
		$row = $this->dezDB->getRow($id);	
		$this -> buildForm( 'edit', $row );
	}	
	protected function getParent($id=0,$idp=0){

		$aResult = array();		

		$this -> setParent($aResult, $id, $idp);		

		return  $aResult;
	
	}
	protected function setParent(&$arrPanrent,$id,$idp=0,$text='', $partten = " --- ")
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
	protected function deleteItem()
	{
		$id = $_GET['id'];
		$this->dezDB->deleteWithPk($id);
		$this->option->delete_option($id,$this->type."_skin");
		$this->option->delete_meta($id,$this->type);
//		$this->delete_gallery($id,$this->type);
		$_SESSION['msg'] =$this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);	
	}
	
	protected function multiDelete()
	{
		$arrId = $_GET['arr_check'];	
		foreach ( $arrId as $iId ){
			$this->option->delete_option($iId,$this->type."_skin");
			$this->option->delete_meta($iId,$this->type);
//			$this->delete_gallery($id,$this->iId);
			$this->dezDB->deleteWithPk($iId);
		}
		$_SESSION['msg'] =$this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);	
	}
	
	protected function changeStatus()
	{
		$id = $_GET['id'];
		$status = $_GET['status'];	
		$field  = $_GET['field'];	
		$this -> dezDB -> updateWithPk ( $id, array ( $field => $status));		
		
	}	

	protected function saveOrder()
	{
		$arrOrder = $_GET['z_index'];
		
		foreach ( $arrOrder as $key => $value )
		
			$this -> dezDB -> updateWithPk ( $key , array ( 'z_index' => $value ));		
		
		$_SESSION['msg'] = $this->get_config_vars("msg_saveorder");
		$this -> redirect("?".$this->submit_url);	
	}
	
	protected function changeStatusMultiple($status)
	{		
		$sIds = implode(",", $_GET['arr_check']);
		$this -> dezDB -> updateWithPk ( $sIds , array ( $this->_prefix.'status' => $status ));				
		
		if($status==1)
			$_SESSION['msg'] = $this->get_config_vars("msg_publish");
		else 
			$_SESSION['msg'] = $this->get_config_vars("msg_unpublish");
		$this -> redirect("?".$this->submit_url);	
	}
	
	protected function viewpage($page=""){
		if($page){
			$where = "post_type='page' and post_code='$page'";
			$row = $this->dezDB->getRowTable("dz_post",$where);
			$keyword = Module_Base::getTagsbyID($row['post_id'],"page");
			$this->s->assign("row",$row);
			$this->s->assign("keyword",$keyword);
			$this->s->assign("author",Module_Base::getUserbyId($row['post_uid']));
			$is_slidebar = $this->option->get_option_by_id($row[$this->_prefix.'id'],$this->type."_skin");
		//	$this->s->assign("is_slidebar",$is_slidebar);
			if($is_slidebar!="")
				$this->s->display($is_slidebar."".TPL,"page");
			else
				$this->s->display("page_view".TPL,"page");
		}
		
	}
	
	public function  getPageInfo($sTask){
		$aPageinfo['title'] = $this->s->getConfigVariable("title_home");
		$aPageinfo['keyword'] = $this->s->getConfigVariable("keyword_home");
		$aPageinfo['description'] = $this->s->getConfigVariable("description_home");
		$aPageinfo['image'] = SITE_URL."public/img/logo.jpg";
		switch($sTask){
			case "view": default:
				$id = $_GET[$this->type.'_id'];
				$row = $this->dezDB->getRowTable("dz_post",$this->_prefix."code='$id'");
				$keyword = Module_Base::getTagsbyID($row['post_id'],$this->type);
				$aPageinfo['keyword']= parent::getTagsbyID($row[$this->_prefix.'id'],$this->type);
				$title = parent::getMetaPageTitle($row[$this->_prefix.'id'],$this->type);
				$aPageinfo['title'] = $title  ? $title  : $row[$this->_prefix.'title'];
				$aPageinfo['description'] =  parent::getMetaPageDescription($row[$this->_prefix.'id'],$this->type);	
				
			break;
			
			case "list":
			$post = $_GET['post_id'];
			$row = $this->dezDB->getRowTable("dz_category","keycode='$post'");

			$aPageinfo['keyword']=  $row['name'].",".$aPageinfo['keyword_home'];
			$aPageinfo['title'] = $row['name']."| ".$aPageinfo['title'];
			
			break;
		}
		return $aPageinfo;
	}
	
	
}
?>