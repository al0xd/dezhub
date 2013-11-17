<?php
class AdminGroup extends Module_Base{
	private $arr_fields;
	public $quickForm,$dezDB;
	function __construct(){
		
		parent::__construct();
		parent::initForm();
		if($_REQUEST['task']!='popup')
			parent::setTitle();
		$this -> dezDB -> setTable('dz_user_type');
		$this->admin_table='dz_admin_menu';
		$this->submit_url = parent::getModuleUrl();
		if(parent::isPost()){
			$form = $this->quickForm->getValue();
			$this->arr_fields = array(
				"name" => $form['name'],
				"permission" =>  $form['permission'],
			);
		}
	}	
	
	function run( $task )
	{
		switch ( $task )
		{
			default:
				$this -> listUserType();
				break;
			case "add":
				$this -> addUserType();
				break;
			case "edit":
				$this -> editUserType();
				break;
			case "delete":
				$this -> deleteUserType();
				break;
			case "multi_delete":
				$this -> deleteMultiUserType();
				break;
			case "popup":
				$this -> addModule( intval($_GET['id']) );
				break;
		}
	}
		
	function addUserType()
	{
		$this -> buildForm();
	}
	
	function editUserType()
	{
		$id = $_GET['id'];
		
		$row = $this -> dezDB -> getRow( $id );
		$this -> buildForm( $row );
	}

	function deleteUserType()
	{
		
		$id = $_GET["id"];
		if($id==1){
			$_SESSION['msg'] = "Bạn không thể xóa nhóm này vì nhóm có quyền cao nhất!";
		}else{	
			$sql = "user_type_id ='{$id}'";
			$res = $this->dezDB->del_rec("dz_usertype_moduleroll",$sql)	;	
			$this->dezDB -> deleteWithPk( $id );
			$_SESSION['msg'] =$this->get_config_vars('msg_delete');
		}
		$this -> redirect("?".$this->submit_url);
	}
	
	function deleteMultiUserType()
	{
		
		$aItems	 = $_GET['arr_check'];
		if(is_array( $aItems) && count( $aItems) > 0){
			if(in_array(1,$aItems)){
				$_SESSION['msg'] = "Bạn không thể xóa nhóm này vì nhóm có quyền cao nhất!";
			}else{
				$sItems = implode( ',', $aItems );
				$sql = "delete from dz_usertype_moduleroll where user_type_id in ($sItems)";
				$res = $this->dezDB -> querySql( $sql );		
				$this -> dezDB -> deleteWithPk( $sItems );
				$_SESSION['msg'] =$this->get_config_vars('msg_delete');
			}
		}
			$this -> redirect("?".$this->submit_url);
	}
	
	function buildForm( $data=array() , $msg = ''){
		$this->getPath();
		
		parent::setFormData($data);
		$form = parent::setFormFieldSet();
		$name = $form -> addElement('text', 'name',array('size' => 50, 'maxlength' => 255))->setLabel("Tên ");
		$form -> addElement('textarea', 'permission', array('rows'=> 10, "cols"=> 80))->setLabel("Miêu tả ");
		parent::insertSubmitButton();      
      
		$name->addRule('required', 'Bắt buộc nhập');
       // $form -> addRule('name','Name cannot be blank','required',null,'client');
		
		if( parent:: validate() ){
			if( !$_POST['id'] ){				
				 $this -> dezDB -> insert($this->arr_fields);
				 $_SESSION['msg'] =$this->get_config_vars('msg_insert');
			}else {
				$id = $_POST['id'];
				$this -> dezDB -> updateWithPk($id, $this->arr_fields);
				 $_SESSION['msg'] =$this->get_config_vars('msg_edit');
			}
			
			$this -> redirect("?".$this->submit_url);
		}
		
		parent::displayForm();

	}
	
	function listUserType( $sMsg = '')
	{		
		
		$this->getPath();
		$this->grid->setMethod($this->submit_url);
		$table = "dz_user_type";
		$this->grid->setTable($table);
		 
		$this->grid->addField(array("field" => "id",	'display' => 'ID',"primary_key" =>true,"sortable" => true));
		$this->grid->addField(array("field" => "name","display" => "Tên nhóm","sortable" => true));
		$this->grid->addField(array("field" => "permission","display" => "Miêu tả nhóm","sortable" => true));
//		$this->grid->addField(array("field" => "editable","visible" => "hidden"));
		
		$aAction = $this->getAct();
		$aAction[1]['display'] = array('field' => 'editable', 'operation' => 'equal', 'value' => '1');		
		$aAction[2]['display'] = array('field' => 'editable', 'operation' => 'equal', 'value' => '1');		
		
		$this->grid->addTask($this->getAct("add"));
		$this->grid->addTask($this->getAct("edit"));
		$this->grid->addTask($this->getAct("delete"));
		$result = array(
					"task" => "view",
					"text"=>"Quyền",
					"icon"=>"icon-lock",
					"action"=>"open_win",
					"tooltip" => "Thiết lập quyền quản trị"		
				);
				
					
		$this->grid->addTask($result);
	#	print_r($aAction);
		if( $_SESSION['msg'] )
			$this->grid -> setMessage( $_SESSION['msg'] );
		$this->grid->displayGrid();	
		unset ( $_SESSION['msg'] );
		
	}

	/**
	 * add module 
	 */
	function addModule($tid)
	{
			
		
		$currentUserType = self::getUserTypebyID(intval($tid));
		if($currentUserType){
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$id = intval($_POST['id']);
				$this->delete($id);				
				if(!$id){					
					$_SESSION['post'] = $_POST ;
				}else{
					foreach ($_POST['module'] as $value)
					{												
						foreach ($_POST['roll'.$value] as $val)
						{		
							$this->insert($id, $val, $value);
						}
					}			
					echo '<script type="text/javascript">window.close();	</script>';
				}
			}
			
			$table = $this->admin_table;
			$condition = " editable = 1";
			$order = "z_index";
			$modules = $this -> multiLevel( $table, "id", "parent_id", "*", "{$condition}", "{$order}");		
			//$modules = $oDb->getAll("SELECT * FROM admin_menu ");
			$basicroll = $this->dezDB->getAllLimit("dz_roll");
			
			foreach ($modules as $key => $value)		
			{
					$modules[$key]['title'] = $this -> getPrefix($value['level']). $value['title'];			
					$rolls = array();
					$sql = "SELECT t1.id, t2.id as module_roll_id 
						FROM dz_roll t1 
							join (SELECT * FROM 
								dz_module_roll WHERE module_id='{$value['id']}'
								) t2 
								on(t1.id=t2.roll_id) ORDER BY ordered";
					$rolls = $this->dezDB->getAssocSql($sql);	
					$broll = $basicroll;
					$modules[$key]['checked'] = "none";	
					foreach ($broll as $vkey =>$val)
					{
							if(!parent::checkChildModule($value)){
								$broll[$vkey]['checked'] = "none";
								if(in_array($val['id'],array_keys($rolls))){
									$sql = "SELECT id FROM dz_usertype_moduleroll 
									WHERE module_roll_id = ".$rolls[$val['id']]." AND user_type_id = $tid";				
									$res = $this->dezDB->getOne($sql);					
									if( $res > 0){
										$broll[$vkey]['checked'] = "checked";
									}
								}else{
									$broll[$vkey]['checked'] = "disable";
								}
							}else{
								$broll[$vkey]['checked'] = "error";
							}
							
					}
					$councheck = self::countArrayValue("checked",$broll);
					if($councheck>0)
						$modules[$key]['checked'] = "checked";	
					elseif($councheck>0)	
						$modules[$key]['checked'] = "none";	
					elseif(self::countArrayValue("disable",$broll)==count($basicroll))	
						$modules[$key]['checked'] = "disable";	
					elseif(self::countArrayValue("error",$broll)==count($basicroll))	
						$modules[$key]['checked'] = "error";	
	
					$modules[$key]['roll'] = $broll;
					
			}
			
			//print_r($basicroll);
			$this->s->assign("basicroll", $basicroll);
			$this->s->assign("modules", $modules);
			$this->s->assign("usertype", $currentUserType);
			//print_r($modules);
		}
		$this->s->display('assign_module.tpl');
				
	}
	function getUserTypebyID($id){
		$sql = "id=$id";
		$item = $this->dezDB->getRowTable("dz_user_type",$sql);
		if($item)
			return $item;
		else return false;
	}
	function countArrayValue($key="",$array = array()){
		$i=0;
		if($key && $array){
			foreach($array as $k=>$v){
				if($v['checked']==$key){
					$i++;	
				}
			}
		}
		return $i;
	
	}
	function insert($id, $roll, $module)
	{
		 $MRID = $this->dezDB->getOne("SELECT id FROM dz_module_roll WHERE module_id ='$module' and roll_id = '$roll'"); 
						
		if($MRID)
		{	
			$ar_usergroup = array(
				'module_roll_id' => $MRID,
				'user_type_id' => $id
			);	
			$this->dezDB->add_rec("dz_usertype_moduleroll",$ar_usergroup);				
		}
	}
	
	function delete($id)
	{		
		$sql = " user_type_id = {$id}";
		$this->dezDB->del_rec("dz_usertype_moduleroll",$sql);
		//$oDb->Execute($sql);	
	}
	
	
}

?>