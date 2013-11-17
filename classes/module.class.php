<?php	 defined('SITE_DIR') or exit('Direct script access is not allowed!');
/*
******************************************************************************************   

  Package            : Dezhub  [ Web Application Framework ]
      
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




abstract class Module_Base

{

	public $db;
	public $smarty;
	public $dezDB; //Dez_Db
	public $grid;
	public $test='a';
	public $multilang;
	public $mod;
	public $lang_id;
	public $authorcode;
	public $pk ;
	/**

	 * quick form config

	 * 

	 * @var object HTML Quick Form

	 * @var array $aElement

	 * @var array $aElementNotShow

	 * 

	 */

	public $quickForm,$s;

	private $aElement = array();

	private $aElementNotShow = array();



	protected function run($task){
		
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
	

	protected function getPageInfo($task){}

	

	protected function __construct()

	{

		global $oDb,$oSmarty,$oDatagrid;
		$this->db	= $oDb;	
		$this->smarty = $oSmarty;
		$this->s = $oSmarty;
		if(class_exists ("dataGrid"))
			$this->grid =  new dataGrid($this->db, $this->smarty);
		$this->dezDB = new Dez_Db($oDb);
		$this->lang_id = $_SESSION['lang_id'];
		$this->mod = NULL;
		$this->authorcode= "ZGluaGh1bmd2bkBnbWFpbC5jb20=";

		if(isset($_REQUEST['amod'])){

			$this->mod = $_REQUEST['amod'];

		}

		if(isset($_REQUEST['atask'])){

			$this->mod = $_REQUEST['atask'];

		}

		$this -> arrAction = array(

			array(
				"task" => "add",
				"action" => "",
				"tooltip" => "Add record"		
			),	

			array(
				"task" => "edit",
				"text" => "Edit",
				"icon" => "icon-edit",
				"action" => "",
				"tooltip" => "Sửa dữ liệu"		
			),		

			array(
				"task" => "delete",
				"text" => "Delete",
				"icon" => "icon-trash",
				"confirm" => "Bạn thực sự muốn xóa ?",
				"action" => "",
				"tooltip" => "Delete record"
			)

		);

	}

	

	/****************************FUNCTIONS FOR QUICK FORM*************************************/

	/**

	 * initForm

	 *

	 * @param string $task

	 * @param array $aElement

	 * @param string $formName

	 * @param string $method

	 * @param string $action

	 * @param string $target

	 * @param array $attributes

	 * @param boolean $trackSubmit

	 */

	

	protected function initForm ()

	{

		$this->quickForm = new HTML_QuickForm2('elements');
		foreach($_REQUEST as $key=>$value)
			$this->quickForm->addHidden($key)->setValue($value);

	}

	/**

	 * setNotShowElement

	 *

	 * @param array $array

	 */
	

	protected function setFormData($aData=array(),$task="add")

	{
		if(is_array($aData))
			$this->quickForm->addDataSource(new HTML_QuickForm2_DataSource_Array($aData));
		if($task=='edit')
			$this->quickForm->addHidden('id')->setValue($aData['id']);

	}
	protected function validate(){
		return $this->quickForm->validate();
	}
	protected function setFormFieldSet($label="")

	{
		return $this->quickForm->addElement('fieldset')->setLabel($label);

	}

	protected function insertSubmitButton()

	{
		$this->quickForm->addSubmit('submit', array('value' => 'Lưu lại','data-back'=>true, 'id' => 'submit'));

	}



	/**

	 *  check array $GLOBALS['HTML_QUICKFORM_ELEMENT_TYPES']

	 *

	 */

	protected function displayForm()

	{

		$renderer = HTML_QuickForm2_Renderer::factory('default');
		$this->quickForm->render($renderer);
		echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
		echo $renderer;
	
	}

	

	/****************************FUNCTIONS FOR DATAGRID*************************************/

	protected function redir($url)
	{
		if(!headers_sent())
		{
			header("Location: " . $url);
		}
		else 
		{
			echo "<script type='text/javascript' language='javascript'>location.href='{$url}'</script>";
		}
	}
	/**
	 * Kiểm tran trang thái có post dư liệu lên server không
	 *
	 * @return boolean
	 */
	protected function isPost()
	{
		return (strtoupper($_SERVER['REQUEST_METHOD'])=='POST') ? true : false;
	}

	protected function redirect($url,$type="location") {
		$url = $url!='' ? $url : $this->url;
		header("Location:$url");
		exit();
	}

	protected function get_config_vars ($var = '', $default = '') {
		global $oSmarty;
		$value = $oSmarty->getConfigVariable($var);
		if ($value != '') {
			return (string) $value;
		} else {
			return $default;
		}
	}

//Function: setTitle
//Description: Dat tieu de cho module
//Author: Dinh Van Hung
//Website: www.dezhub.com
//Return: string
	protected function setTitle(){
		global $oDb;
		if(!isset($_REQUEST['ajax'])){
			$sql = "select * from dz_admin_menu";
			$row = $oDb->getAll($sql);
			if($row){
				foreach($row as $k=>$v){
					if(checkUrl($v['link'])){
						$str='<h3 class="page-title">';
						$title = "";
						$title=$v['title'];
						$str.=$title;
						$str.='<small></small></h3>';
						echo $str;
					}
				}
			}
		}else
			return false;
		
	}

	protected function getPath( $sRawPath = ''){
		global $oDb;
		$sRawPath="";
		$sql = "select * from dz_admin_menu";
		$menu = $oDb->getAll($sql);
		$row = array();
		if($menu)
			foreach($menu as $k=>$v){
				if(checkUrl($v['link'])){
					$row=$v;
				}
			}
		$sRawPath=$row["title"];
		if($row['parent_id']){
			$sql = "select * from dz_admin_menu where id=".$row['parent_id'];
			$row = $oDb->getRow($sql);
			$sRawPath.=">>".$row["title"];
			if($row['parent_id']){
				$sql = "select * from dz_admin_menu where id=".$row['parent_id'];
				$row = $oDb->getRow($sql);
				$sRawPath.=">>".$row["title"];
			}
	
		}
		$root_path_array = explode(">>",$sRawPath);
		$str = "<ul class=\"breadcrumb\">";
		$str.="<li>
								<i class=\"icon-home\"></i>
								<a href=\"/dz-admin\">Dashboard</a> 
							</li>";
		$root_path_array = array_reverse($root_path_array);
		$arrTask = array(
			"edit" =>"Sửa dữ liệu",
			"add" =>"Thêm mới dữ liệu",
			"list" =>"Danh sách dữ liệu",
			"default"=>"",
		);
		$task = ($_REQUEST['task'])?($arrTask[$_REQUEST['task']]):$arrTask['default'];
		if($_REQUEST['id']&&$_REQUEST['task']=='edit'){
			$id = " <strong>id : ".$_REQUEST['id']."</strong>";
		}
		if(is_array($root_path_array)){

			foreach($root_path_array as $value){

				$str.="<li> <i class=\"icon-angle-right\"></i>{$value}</li>";
			}
		}
		if($task!="")
			$str.="<li><i class=\"icon-angle-right\"></i> {$task} {$id}</li>";
		$str.="</ul>";
		if(!isset($_REQUEST['ajax']))						

			echo $str;

	}
	protected function getAct( $action=''){
		if(!$action){
			$act1 = $this-> getActionAdd();
			$act2 = $this-> getActionEdit();
			$act3 = $this-> getActionDelete();
			$result = array( $act1[0],	$act2[0],$act3[0]	);
		}else{
			$action = strtolower( $action );
			switch( $action ){
				case 'add':
					$result = $this-> getActionAdd();
					break;
				case 'edit':
					$result = $this-> getActionEdit();
					break;				
				case 'delete':
					$result = $this-> getActionDelete();
					break;
				default: $result = $this -> getActionOther( $action );
					break;
			}
			$result = $result[0];

		}
		return $result;
	}

	

	protected function getActionOther( $action ){
		global  $oDb;
		$user = self::getUserbyCookie();
		$sql = "select * from dz_roll where name='{$action}'";
		$roll = $oDb -> getRow( $sql );
		$rollId = $roll['id'];
		if( !$rollId ) return false;
		
		
		if( $this -> checkPermission( $rollId ) || $user['user_type_id']==1){
			$result = array(
						"task" => $action,
						"icon"=>$roll['icon'],
						"tooltip" => $roll['title']	,
						"display" => $roll['title']	
					);
					return array($result);
			
			}


		else return false;

	}

	protected function checkPermission( $rollId ){		
		global $oDb;
			$user = getUserbyCookie();
			$return = false;
			$roll_id=  $oDb->getOne("select id from dz_roll where id=$rollId");
			$stbl ="dz_admin_menu";
			$_prefix = "";
			// type of category
			$sWhere = "showed=1";
			$twhere = "";
			
			$sql="select * from {$stbl} where {$sWhere} {$twhere}";	
			$msMenu=$oDb->getAll($sql);
			//echo count($rows);
			if($msMenu)
				foreach($msMenu as $k=>$v){
					$sql="select count(*) from {$stbl} where {$sWhere} and parent_id=".$v['id'];	
					$haschild = $oDb->getOne($sql); // kiem tra khong con child menu
					if(checkUrl($v['link']) && !$haschild){
						$sql = "select count(t1.id) from dz_module_roll t1 
								join dz_usertype_moduleroll t2 on t1.id = t2.module_roll_id
								where t1.module_id=".$v['id']." and t1.roll_id=".$roll_id."
								 and t2.user_type_id=".$user['user_type_id'];
							$isPermission = $oDb->getOne($sql);
							if($isPermission==0) $return = false;
							else $return = true;
							break;
					}
				}
				
		return $return;

	}
	protected function getActionAdd(){
		global $oDb;
		$user = self::getUserbyCookie();
		$sql = "select * from dz_roll where name='add'";
		$roll = $oDb -> getRow( $sql );
		if( $this-> checkPermission( 1 ) || $user['user_type_id']==1){
		$result = array(
					"task" => "add",
					"icon"=>$roll['icon'],
					"tooltip" =>$roll['title'],
					"display" =>$roll['title'],
				);
				return array($result);
		}
		else 
			return false;
	}
	protected function getActionEdit(){
		global $oDb;
		$user = self::getUserbyCookie();
		$sql = "select * from dz_roll where name='edit'";
		$roll = $oDb -> getRow( $sql );

		$user = self::getUserbyCookie();
		if( $this-> checkPermission( 2 )|| $user['user_type_id']==1){
		$result = array(
					"task" => "edit",
					"text" => "Sửa",
					"icon" =>  $roll['icon'],
					"tooltip" =>$roll['title']	
				);
				return array($result);
		}
		else 
			return false;
	}
	protected function getActionDelete(){
		global $oDb;
		$user = self::getUserbyCookie();
		$sql = "select * from dz_roll where name='edit'";
		$roll = $oDb -> getRow( $sql );
		$user = self::getUserbyCookie();

		if( $this-> checkPermission( 4 )|| $user['user_type_id']==1){

		$result = array(

					"task" => "delete",					
					"text" => "Xóa",					
					"icon" => $roll['icon'],
					"confirm" => "Bạn thực sự muốn xóa ?",
					"tooltip" => $roll['title']			
				);
				return array($result);
		}
		else 
			return false;
	}

//--------------------------------------------------------------------------------------------------------------/	

	protected function showFlash( $file, $attribute = array("width" => 150, "height" => 110) ){

		$str = "<object style=\"cursor:pointer;\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=0,0,0,0\" width=\"{$attribute['width']}px\" height=\"{$attribute['height']}px\" >
                  <param name=\"movie\" value=\"{$file}\" />
                  <param name=\"quality\" value=\"high\" />
                  <embed  style=\"cursor:pointer;\" src=\"{$file}\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" 
				  type=\"application/x-shockwave-flash\" width=\"{$attribute['width']}px\" height=\"{$attribute['height']}\" ></embed>
</object>";
		return $str;
	}
	protected function multiLevel( $table, $pkey, $parent, $sql_select = '*', $where = '', $order=''){
		$aResult = array();		
		$this -> getCategoryMultiLevel($aResult, 0, 0, $table, $pkey, $parent, $sql_select, $where, $order );		
		return  $aResult;
	}



//--------------------------------------------------------------------------------------------------------------/

	protected function getCategoryMultiLevel( &$aRef, $parentId, $level=0, $table, $pkey, $parent, $sql_select, $where='' , $order='' ){
		global  $oDb ;
		if( $where ) $condition = " and {$where}";
		if( $order ) $condition .= " order by {$order}";
		if( $level == 0)
			$sql = "SELECT {$sql_select} FROM {$table} WHERE (`{$parent}` = '0' or `{$parent}` is NULL) {$condition}";
		else
			$sql = "SELECT {$sql_select} FROM {$table} WHERE `{$parent}` = '{$parentId}' {$condition}";
		$result = $oDb -> getAll( $sql );	 		

		if( $result ){

			if( $level > 0)

				$aRef[count($aRef)-1]['hashchild'] = true;

			foreach ( $result as $key => $val){

				$val['level'] = $level;				

				$aRef[] = $val;				

				$this -> getCategoryMultiLevel( $aRef, $val[$pkey], $level + 1, $table, $pkey, $parent, $sql_select, $where, $order  );
			}

		} 

	}

	protected function getPrefix( $level ){

		$prefix = ' -- ';

		return str_repeat( $prefix, $level );

	}
	/**

	* assign variable to smarty

	* @author: dezhub.com

	* @return: string

	*/

	protected function assign($var, $value) {
		$this->smarty->assign ($var, $value);
	}
	/**

	* assign variable to smarty

	* @author: dezhub.com

	* @return: string

	*/

	protected function display($file) {
		$this->smarty->display($file);
	}

//---------------------------------------------------------------------------------------------------------------/

/**

 * get array value of language

 *

 * @return array

 */

	protected function getAssocLang(){
		$arrLang = $this->dezDB->getAssocTable("dz_lang",array("id","name"),NULL,"order by isdefault desc");
		if (checkMultiLang())
			return  $arrLang;
		else 
		{
			foreach ($arrLang as $key=>$value)
			{
				$arrOneLang[$key] = $value;
				break;
			}
			return  $arrOneLang;
		}
	}

	

//---------------------------------------------------------------------------------------------------------------/

	/**

	 * Get value of language default

	 *

	 * @return interger;

	 */

	protected function getLangDefault()

	{

		return $this->dezDB->getOne("SELECT id FROM dz_lang order by isdefault desc");

	}


	protected function backurl(){
		$this -> redirect(makeUrlFriendly("index.php?".$this->submit_url));	
	}
	
	protected function getUserbyCookie(){
		global $oDb;
		$sql = "SELECT * FROM dz_user WHERE id = ".intval($_COOKIE['dzh_uid']);
		$user = $oDb->getRow($sql);
		if($user){
			return $user;
		}
		else
			return false;

	}
	protected function getUserbyId($id=null){
		global $oDb;
		if($id){
			$sql = "SELECT * FROM dz_user WHERE id = ".intval($id);
			$user = $oDb->getRow($sql);
			if($user){
				return $user;
			}else
				return false;
		}
		else
			return false;

	}

	protected function checkUserbyCookie(){
		global $oDb;
		$sql = "SELECT * FROM dz_user WHERE id = ".intval($_COOKIE['dzh_uid']);
		$user = $oDb->getRow($sql);
		// xoa cookie dang nhap loi
		$time_save = time() - 3600;
		$domain = $_SERVER['HTTP_HOST'];
		setcookie("error_login","",$time_save,"/",$domain);
		
		if($user){
			return true;
		}
		else
			return false;

	}
//	Function name: getModuleUrl
//	Description: Tra lai duong dan goc cua module
//	Author: Dinh Van Hung
//	Website: www.dezhub.com
//	Return: string
	protected function getModuleUrl(){
		$url ="amod={$_REQUEST['amod']}&atask={$_REQUEST['atask']}";
		if(isset($_REQUEST["ajax"]))
			$url.="&ajax";
		return $url;
		
	}
	
//	protected function name: checkChildModule
//	Description: Kiem tra su ton tai Module con cua Module hien tai
//	Author: Dinh Van Hung
//	W: www.dezhub.com
//	Return: boolean
	protected function checkChildModule($module){
		$sql = "select count(*) from dz_admin_menu where parent_id=".intval($module['id']);
		$count = $this->dezDB->getOne($sql);
		if($count)
			return true;
		else
			return false;
	}	
	
//	protected function name:isLogin
//	descriptio: Kiem tra tinh trang dang nhap cua thanh vien
//	author: dinh van hung
//	website: www.dezhub.com
//	return boolean
	protected function isLogin(){
	global $oDb;
	
	$author_code = $this->authorcode;
	if(!isset($_COOKIE['dzh_uid']) || !isset($_COOKIE['dzh_session']) || !isset($_COOKIE['dzh_hash'])){
		return false;
	}else{
		
		$oldcookies = md5($_COOKIE['dzh_uid'].$author_code.$_COOKIE['dzh_session']);

		if($oldcookies != $_COOKIE['dzh_hash']){

			self::clearCookie();	
			return false;
		}else{
			return self::checkUserbyCookie();			
		}
	}
	
}
	//f:loginRequired
	//d: kiem tra dang nhap va yeu cau dang nhap de tiep tuc
	//a: dinhhungvn
	//w: www.dezhub.com
	//return: direct
	protected function loginRequired(){
		if(!self::isLogin()){			
				$url = selfURL();
				header("Location:".SITE_URL."dz-admin?task=login&backurl=".urlencode($url));
				exit();		
		}
	}

	//F:clearCookie
	//D: xoa cookie khi logout
	//A: dinhhungvn
	//w: www.dezhub.com
	//r: null
	protected function clearCookie(){
		clearCookie();
	}

	protected function getAuthorCode(){
		return $this->authorcode;
	}		

	protected function insertGroupAttr($group=null,$attr=null,$post_stype="product"){
		global $oDb;
		if($group && $attr){
			$data = array(
				"group_id"=>intval($group),
				"attribute_id"=>intval($attr),
				"post_type"=>$post_stype,
			);
			return $this->dezDB->add_rec("dz_group_attribute",$data);
		}else
			return false;
	
	}
	protected function removeGroupAttr($group=null,$attr=null,$type="attr",$post_type="product"){
		global $oDb;
		if($group && $type=='group'){
			$where = "group_id=".intval($group)." and post_type='{$post_type}'";
		}
		if($attr && $type=='attr'){
			$where = "attribute_id=".intval($attr)." and post_type='{$post_type}'";
		}
		if($attr && $group && $type=='both'){
			$where = "attribute_id=".intval($attr)."
			and group_id=".intval($group)." and post_type='{$post_type}'";
		}
		$this->dezDB->del_rec("dz_group_attribute",$where);
	}
	protected function getTagsbyID($id=null,$type=null){
		global $oDb;
		if($id && $type){
			$sql = "select t1.name from dz_category t1 join dz_group_attribute t2 on t1.id = t2.group_id
			 where t1.type='post_tag' and t2.attribute_id=$id and t2.post_type='{$type}_tag'";
			$item =  $oDb->getCol($sql);
			return implode(", ",$item);
		}
	}
	protected function insertMetaPage($id=null,$type=null){
		if($id && $type){
			$where = " term_id =".intval($id)." and (taxonomy='{$type}_meta_title' or taxonomy='{$type}_meta_description')";
			$this->dezDB->del_rec("dz_term_taxonomy",$where);
			$arr = array($type."_meta_title",$type."_meta_description");
			foreach($arr as $k){
				$data = array(
					"term_id"=>intval($id),
					"taxonomy"=>$k,
					"description"=>$_REQUEST[$k],
					"parent"=>0,
					"count"=>0,
				);
				$this->dezDB->add_rec("dz_term_taxonomy",$data);
				unset($data);
			}
		}
	}
	protected function getMetaPageTitle($id=null,$type=null){
		if($id && $type){
			$sql = "select description from dz_term_taxonomy where term_id=".intval($id)." and taxonomy='{$type}_meta_title'";
			return $this->dezDB->getOne($sql);
		}
	}
	protected function getMetaPageDescription($id=null,$type=null){
		if($id && $type){
			$sql = "select description from dz_term_taxonomy where term_id=".intval($id)." and taxonomy='{$type}_meta_description'";
			return $this->dezDB->getOne($sql);
		}
	}
	protected function insertFormMeta(){
		
		$meta = self::setFormFieldSet("Cấu hình SEO");
		$slugstring = $meta->addElement('inputslug',$this->_prefix. 'code',
		array("data-title"=>SITE_URL."post/"))->setLabel("Slug");
		$meta->addElement('text',$this->type.'_meta_title')->setLabel("Tiêu đề trang");
		$meta->addElement('inputtags',$this->type. '_meta_tag')->setLabel("Từ khóa");
		$meta->addElement('textarea',$this->type.'_meta_description', 
		array('style' => 'width: 80%; height:150px'))->setLabel("Miêu tả trang");	
		$slugstring->addRule('required', 'Slug không được để trống.');
	
	}
	
	protected function insertTagbyPost($id=null,$type=null){
		if($id && $type){
			$where = "post_type='{$type}_tag' and attribute_id=".intval($id);
			$this->dezDB->del_rec("dz_group_attribute",$where);
			$tag = $_REQUEST[$type.'_meta_tag'];
			if($tag){
				$adata = explode(",",$tag);
				if(is_array($adata))
					foreach($adata as $k=>$v){
						$tagid = $this->dezDB->getOne("select id from dz_category where name='".trim($v)."' and type='post_tag'");
						if(!$tagid){
							$data = array(
								"name"=>$v,
								"type"=>"post_tag",
								"keycode"=>removeMarks($v),
							);
							$tagid = $this->dezDB->add_rec("dz_category",$data);
						}
							$attr = array(
								"group_id"=>$tagid,
								"attribute_id"=>intval($id),
								"post_type"=>$type."_tag",
							);
							$this->dezDB->add_rec("dz_group_attribute",$attr);
					
					}
			}
		}else
			return false;
	}
	
	protected function setFolderbyUser(){
		$path = SITE_DIR."public/upload/userfiles";
		$domain = $_SERVER['HTTP_HOST'];
		$ufolder = ($_COOKIE['dzh_uid'])?md5(intval($_COOKIE['dzh_uid'])):"guest";
		if(!isset($_COOKIE['user_folder']))
			setcookie("user_folder","public/upload/userfiles/$ufolder",0,"/",$domain);
			
	$uploads_dir = SITE_DIR."public";
		if(!is_dir($uploads_dir)){
			mkdir($uploads_dir,0777);
		}
		$uploads_dir.="/upload";
		if(!is_dir($uploads_dir)){
			mkdir($uploads_dir,0777);
		}
		$uploads_dir.="/userfiles";
		if(!is_dir($uploads_dir)){
			mkdir($uploads_dir,0777);
		}
		$uploads_dir.="/{$ufolder}";
		
		if(!is_dir($uploads_dir)){
			mkdir($uploads_dir,0777);
		}
		$uploads_dir.="/images";
		if(!is_dir($uploads_dir)){
			mkdir($uploads_dir,0777);
		}
	//	$uploads_dir.="/dropzone";
		
		if(!is_dir($uploads_dir."/dropzone")){
			mkdir($uploads_dir."/dropzone",0777);
		}
		if(!is_dir($uploads_dir."/multiple")){
			mkdir($uploads_dir."/multiple",0777);
		}
		
	}
	protected function _type_category(){
		$type= array(
			"post" => array(
				"title" => "Bài viết"
			),
			"product" => array(
				"title" => "Sản phẩm"
			),
			"page" => array(
				"title" => "Trang"
			),
			"nav_link" => array(
				"title" => "Custom link"
			),
		
		);
		return $type;
	}
	
	protected function _smatyrender(){
		
		HTML_QuickForm2_Renderer::register('smarty', 'HTML_QuickForm2_Renderer_Smarty');
		$renderer = HTML_QuickForm2_Renderer::factory('smarty');
	
		// Generate styles/output compatible with the old renderer (for old templates):
		$renderer->setOption('old_compat', true);
	
		// Errors in an array 'errors' in the form array keyed by the form name.
		// If false error are in the form field's array keyed 'error'.
		$renderer->setOption('group_errors', true);
	
		// The old Smarty renderer produced a string 'requirednote' that could be produced.
		// This is called 'required_note' in QF2. You may set the string as below - which is default.
		// It will be edited to be in a 'div class="reqnote"'. Old smarty it has the * styled red.
		// $renderer->setOption('required_note', '<em>*</em> denotes required fields.');
	
		// build the HTML for the form
		// $form->accept($renderer);
	
		// assign array with form data
		// $tpl->assign('FormData', $renderer->toArray());
		$res =  $this->quickForm->render($renderer);
/*		$renderer->setJavascriptBuilder(new HTML_QuickForm2_JavascriptBuilder(SITE_URL.'dz-admin/includes/scripts/abc.js'));
foreach ($renderer->getJavascriptBuilder()->getLibraries() as $link) {
    echo $link . "\n";
}
*/		
		return $res->toArray();
	
		// This is where the header is inserted directly into the array for smarty:
		//$FormData['header']['DemoHeader'] = 'Quickform Demo';
	
	}
	
}
