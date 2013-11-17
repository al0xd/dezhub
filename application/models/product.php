<?php 
__MODEL("option,paging");
class BaseProduct extends Module_Base
{
	var $table;
	var $quickForm;
	public $db,$s,$grid,$type,$type_item,$submit_url,$_prefix,$dezDB,$option;
	public function __construct() {
		parent::__construct();
		parent::isLogin();
		parent::initForm();
		parent::setTitle();
		$this->option= new BaseOption;
		$this->table = "dz_post";
		$this->dezDB->setPrimaryKey('id');
		$this->dezDB->setTable($this->table);
		$this->type='product';
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
				$this->_prefix.'content' => stripcslashes($form[$this->_prefix.'content']),
				$this->_prefix.'status' => $form[$this->_prefix.'status'],
				$this->_prefix.'type' =>$this->type,
				$this->_prefix.'createtime' => $createtime,
				$this->_prefix.'updatetime' => $updatetime,
				$this->_prefix."uid"=>($_COOKIE['dzh_uid'])?$_COOKIE['dzh_uid']:0
			);
			if(checkMultiLang())
				$this->arr_fields [$this->_prefix.'lang_id'] = $form[$this->_prefix.'lang_id'];
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
//		$this->removephoto($id);
		$this->dezDB->deleteWithPk($id);
//		$this->option->delete_option($id,$this->type."_skin");
		$this->option->delete_meta($id,$this->type);
		$this->delete_gallery($id,$this->type);
		$_SESSION['msg'] =$this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);	
	}
	
	protected function multiDelete()
	{
		$arrId = $_GET['arr_check'];	
		foreach ( $arrId as $iId ){
//			$this->removephoto($iId);
			$this->dezDB->deleteWithPk($iId);
//			$this->option->delete_option($iId,$this->type."_skin");
			$this->option->delete_meta($iId,$this->type);
			$this->delete_gallery($iId,$this->type);
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
	protected function home(){
		$sql= "type='product' and active=1";
		$row = $this->dezDB->getAllLimit("dz_category",$sql,"z_index","asc");
		$pre = "post_";
		if($row)
			foreach($row as $k=>$v){
				$sql = "select distinct t1.{$pre}id, t1.* from {$this->table} t1 join dz_group_attribute t2 
				on t1.{$pre}id=t2.attribute_id and t1.{$pre}type='{$this->type}' 
				and t2.group_id={$v['id']}";
				$row[$k]["sub"] = $this->dezDB->getAllSql($sql);
				if($row[$k]['sub'])
					foreach($row[$k]['sub'] as $ks=>$vs){
						$row[$k]['sub'][$ks][$this->_prefix.'price'] = 
						$this->option->get_option_by_id($vs[$this->_prefix.'id'],$this->type."_price");

					}
				
			}
		$this->s->assign("home_product",$row);
		$this->s->display("product_home.tpl");
		
	}
	protected function list_item($post=null){
		if($post){
			$cond = " keycode='$post'";
			$category = $this->dezDB->getRowTable("dz_category",$cond);
			$this->s->assign("category",$category);	
			$id = $category['id'];
			$table = "dz_post";
			$sql = "select count(distinct t1.{$this->_prefix}id) as _count from {$table} t1 join dz_group_attribute t2 on t1.post_id=t2.attribute_id
			where t2.group_id=".intval($id);
			$iTotalRecord = $this->db->getOne($sql);
			$iCurrentPage = (isset($_GET['page'])&&$_GET['page']>0)?$_GET['page']:1;
			$iPerpage = 10;
			$sLimit = " LIMIT ".($iCurrentPage-1)*$iPerpage.",".$iPerpage; 
			$sUrlPath="product/".$_GET['post_id']."/page/{i}";
			$oPaging = new Paging($iPerpage, $iTotalRecord, $iCurrentPage, $sUrlPath);
			$sPaging = $oPaging->getStringPaging();
			$sql = "select distinct t1.{$this->_prefix}id as _key,t1.* from {$table} t1 join dz_group_attribute t2 on t1.post_id=t2.attribute_id
			where t2.group_id=".intval($id);
			
			$list = $this->db->getAll($sql.$sOrder.$sLimit);
			if($list)
				foreach($list as $k=>$v){
					$list[$k]['post_keyword'] = Module_Base::getTagsbyID($v['post_id'],$this->type);
					$list[$k][$this->_prefix.'price'] = 
					$this->option->get_option_by_id($v[$this->_prefix.'id'],$this->type."_price");

				}
			$this->s->assign("sPaging",$sPaging);	
			$this->s->assign("list_post",$list);
			$this->s->display("product_list".TPL,"page");
			
		}
	}
	protected function view_item($id=null){
		if($id){
			$gid = $_GET['gid'];
			$category = $this->dezDB->getRowTable("dz_category","keycode='$gid'");
			$this->s->assign("category",$category);
			$row = $this->dezDB->getRowTable("dz_post",$this->_prefix."code='$id'");
			$keyword = Module_Base::getTagsbyID($row['post_id'],$this->type);
			$this->s->assign("row",$row);
			$this->s->assign("keyword",$keyword);
			$cond = $this->_prefix."type='{$this->type}' and {$this->_prefix}id in 
				(select attribute_id from dz_group_attribute where group_id='".$category['id']."'
				and post_type='{$this->type}') and {$this->_prefix}id<>".$row[$this->_prefix."id"]."
			";
			$other = $this->dezDB->getAllLimit($this->table,$cond,$this->_prefix."id","desc");
			if($other)
				foreach($other as $ks=>$vs){
					$other[$ks][$this->_prefix.'price'] = 
					$this->option->get_option_by_id($vs[$this->_prefix.'id'],$this->type."_price");

				}
			$this->s->assign("other",$other);
			$this->s->assign("author",Module_Base::getUserbyId($row['post_uid']));
			$this->s->display("product_view".TPL,"page");
		}
	}
	public function  getPageInfo($sTask){
		$aPageinfo['title'] = $this->s->getConfigVariable("title_home");
		$aPageinfo['keyword'] = $this->s->getConfigVariable("keyword_home");
		$aPageinfo['description'] = $this->s->getConfigVariable("description_home");
		$aPageinfo['image'] = SITE_URL."public/img/logo.jpg";
		switch($sTask){
			case "view":
				$id = $_GET['post_id'];
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