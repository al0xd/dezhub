<?php
class BaseCategory extends Module_Base
{
	var $table;
	var $pk;
	var $_prefix;
	var $arr_fields;
	var $mod;
	var $type;
	var $quickForm;
	public $db,$s,$grid,$dezDB;
	public function __construct() {
		parent::__construct();
		parent::initForm();
		$this -> table = "dz_category";
		$this->_prefix ="";
		$this->pk =  $this->_prefix.'id';	
		$this -> dezDB -> setTable( $this->table );
		$this->submit_url= self::getModuleUrl();
	}
	public function _setTypePost($type=""){
		$this->type=$type;
	}
	public function addItem()
	{		
		$this -> getPath();
		$this -> buildForm( 'add' );
	}
	
	public function editItem()
	{
		$id = intval($_GET['id']);		
		$this -> getPath();
		$row = $this->dezDB->getRow($id);	
		$this -> buildForm( 'edit', $row );
	}	
	
	public function listItem()
	{
		$this->getPath();		
	 	$this->grid->setMethod($this->submit_url);
		
		$table = $this->table;
		$where[] = "  type = '".$this->type."'";
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
	
		$this->grid->addField(array("field"=>"id","primary_key"=>true,"display"=>$this->get_config_vars('id'),"sortable"=>true,"width"=>50));
		$this->grid->addField(array("field"=>"name","display" => $this->get_config_vars('title'),"sortable" => true,"style"=>"text-align:left"));
$this->grid->addField(array("field"=>"keycode","display" => "Tên đường dẫn","sortable" => true,"style"=>"text-align:left"));
			if(checkMultiLang())
				$this->grid->addField(array("field"=>"lang","display" => "Ngôn ngữ","style"=>"text-align:left"));
	
		$this->grid->addField(array("field" => "z_index","display"=> "Order","datatype" => "order","sortable" => true,"order_default"=> "asc"));

		$this->grid->addField(array("field"=>$this->_prefix."active","display"=>$this->get_config_vars('publish'),"datatype"=>"publish"));
		
		$this->grid->addTaskAll(array("task" => "multi_delete","display" => $this->get_config_vars('delete')));
		$this->grid->setTask($this->getAct());
		
		$this->grid -> setMessage( $_SESSION['msg'] );
		unset( $_SESSION['msg'] );
		
		$this->grid->displayGridTable($aData);		
	}
	


	public function deleteItem()
	{
		$id = $_GET['id'];
		$sql = "delete from dz_group_attribute where group_id=$id and post_type='{$this->type}'";
		$this->dezDB->querySql($sql);
		$this -> dezDB -> deleteWithPk ($id);
		$_SESSION['msg'] = $this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);
	}
	
	public function multiDeleteItem()
	{
		$arrId = $_GET['arr_check'];
		$strId = implode(',',$arrId);
			foreach ( $arrId as $iId )
			{
				$sql = "delete from dz_group_attribute where group_id=$iId and post_type='{$this->type}'";
				$this->dezDB->querySql($sql);
				$this -> dezDB -> deleteWithPk ($iId);
			}
			$_SESSION['msg'] = $this->get_config_vars('msg_delete');
			$this -> redirect("?".$this->submit_url);
	}
	
	
	public function saveOrder()
	{
		$arrOrder = $_GET[ $this->_prefix.'z_index'];
		//var_dump($_GET); 
		foreach ( $arrOrder as $key => $value )		
			$this -> dezDB -> updateWithPk ( $key , array ( $this->_prefix.'z_index' => $value ));		
		
		$_SESSION['msg'] = $this->get_config_vars('msg_saveorder');
			$this -> redirect("?".$this->submit_url);
	}
	
	
	/** 
		get category as array with parent-child
	*/
	public function getParent($id,$idp=0,$type=""){

		$aResult = array();		
		$this -> setParent($aResult, $id, $idp,$type);		

		return  $aResult;
	
	}
	public function setParent(&$arrPanrent,$id,$idp=0,$type="",$text='', $partten = " --- ")
	{		
		$stbl = $this-> table;
		$sWhere = " parent_id={$idp} ";
		if($type)
			$sWhere.= " and type ='{$type}' ";
			
		if($id){
			$sWhere.= " and id<>{$id}";
		}
		
		$rows=$this->dezDB->getAssoc("id,name",$sWhere);
		if($rows){
		  	foreach($rows as $key=>$row)
		    {
				 $arrPanrent[$key] = $text. $row;
				 $this->setParent($arrPanrent,$id,$key,$type,$text.$partten);
			}
		}
	}

	/**
	 * Get Assoc 
	 *
	 * @param integer $lang_id
	 * @param string $type
	 * @return array
	 */
	public function getAssocGroupLangID($lang_id = NULL,$type='groupnews'){
		if($lang_id == NULL)
			$lang_id = $this->lang_id;		
	
		$where  = "Group_Type = '".$type."' AND Group_LangID =".$lang_id;		
		return  $this->dezDB->getAssocTable('dz_category',array('0'=>'Group_ID','1'=>'Group_Name'),$where);
	}
	
	public function changeLang()
	{
		$lang_id = $_GET['lang_id'];
		$categoryId = $_GET['categoryid'];
		$arrParent[0]='--- None ---';	
		$this->setParent($arrParent,$categoryId,0,'',$lang_id);
		
		$sContent.="<select name=\"{$this->_prefix}ParentID\" id=\"{$this->_prefix}ParentID\">";
		foreach($arrParent as $k=>$v){
			$sContent .= "<option value=\"{$k}\">{$v}</option>";
		}
		$sContent.="</select>";
		echo $sContent;
	}
	
	
	public function changeStatus(){
		$status =$_GET['status'];
		$id = $_GET['id'];
		$this->dezDB->updateWithPk($id, array("{$this->_prefix}active" => $status));
		return ;
	}
	
}
?>