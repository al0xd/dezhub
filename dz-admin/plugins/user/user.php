<?php
class AdminUser extends Module_Base {	
	public $quickForm;
	private $arr_fields;
	
	function __construct(){
		parent::__construct();
		parent::initForm();
		parent::setTitle();
		$this->table = "dz_user";
		$this -> dezDB -> setTable($this->table);
		$this->submit_url= parent::getModuleUrl();
		if(parent::isPost()){
			$form = $this->quickForm->getValue();
			$this->arr_fields = array(
				"username" 		=> $form['username'],
				"email" => $form["email"],
				"phone" => $form["phone"],
				"job" => $form["job"],
				"gender" => $form["gender"],
				"avatar" => $form["avatar"],
				"user_type_id" => $form["user_type_id"],
				"interests" => stripcslashes($form["interests"]),
				"website" => urlencode($form["website"]),
				"facebook" => urlencode($form["facebook"]),
				"active" => $form["active"],
				"birthday" => $form["birthday"],
				"fullname" => $form["fullname"],
			);
		}
	}
	function run($task=""){
	
		switch ($task)
		{			
			case "edit":
				$this->editUser();
				break;
			case "delete":
				$this->deleteUser();
				break;
			case "multi_delete":
				$this->deleteMultiUser();
				break;					
			case "add":
				$this->addUser();
				break;
			default: case "list" :
				$this->listUser( $_GET['msg'] );
				 break;
		}				
	
	}	
	function addUser()
	{
		$this -> buildForm();
	}
	
	function editUser()
	{		
		$id = $_REQUEST['id'];		
		$row = $this -> dezDB -> getRow( $id );
		if($row){
			$row['dob'] = date('dMY', strtotime( $row['dob'] ));
			$row['password'] = '';
		}
		
		$this -> buildForm( $row, 'edit' );
	}

	function deleteUser()
	{
		$this -> getPath( );
		$id = $_REQUEST["id"];		
		$this -> dezDB -> deleteWithPk( $id );
		$_SESSION['msg'] =$this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);
	}
	
	function deleteMultiUser()
	{
		$this -> getPath( );
		$aItems	 = $_REQUEST['arr_check'];
		if(is_array( $aItems) && count( $aItems) > 0){
			$sItems = implode( ',', $aItems );
			$this -> dezDB -> deleteWithPk( $sItems );
		}
		$_SESSION['msg'] =$this->get_config_vars('msg_delete');
		$this -> redirect("?".$this->submit_url);
	}
	
	function getUserType(){
		
		$sTbl = "dz_user_type";
		$query = "1";
		$result = $this->dezDB -> getAssocTable($sTbl,"id,name", $query );
		return $result;
	}
	
	function buildForm( $data=array() , $msg = ''){
		$this->getPath();
		
		parent::setFormData($data);
		
		$aUserType = $this -> getUserType();
		$dezhub = parent::setFormFieldSet('Thông tin đăng nhập');
	
		$username = $dezhub -> addElement('text', 'username', 
			array('size' => 60, 'maxlength' => 40,
			"data-trigger"=>"hover",
			"data-content"=>"Tên đăng nhập viết liền không dấu, không có các kí tự đặc biệt",
			"data-original-title"=>"Lưu ý",
			"class"=>"popovers",
			)
		
		)->setLabel("Tên đăng nhập");
		$dezhub -> addElement('select', 'user_type_id',array('size' => 60),array("options"=>self::getUserType()))->setLabel("Nhóm thành viên");
		$email = $dezhub -> addElement('text', 'email',  array('size' => 60),array("label"=>"Email"));
		if($msg=='edit'){
			$messeger = '<div class="alert alert-success" style="width:400px; margin-bottom:0">
			<button class="close" data-dismiss="alert"></button>
			Nhập mật khẩu mới nếu bạn muốn đổi, nếu không hãy để trống!
			</div>';
			$dezhub -> addStatic ('static' , NULL,array("label"=>"","content"=>$messeger));	
		}
		$pwd = $dezhub -> addElement('strengpassword', 'password', array('size' => 40),array("label"=>"Mật khẩu"));
		$dezhub = parent::setFormFieldSet('Thông tin cá nhân');
			
		$dezhub->addElement(
			'text', 
			'fullname', 
			array('style' => 'width: 300px;')
			)->setLabel('Họ tên đầy đủ');
		$email = $dezhub->addElement(
			'text', 
			'email', 
			array('style' => 'width: 300px;')
			)->setLabel('Địa chỉ email');

		$dezhub->addElement('imagepopup', 'avatar', array("data-folder"=>"Images"), array('label' => 'Ảnh đại diện:'));
		$dezhub->addElement(
			'inputnumber', 
			'phone', 
			array('style' => 'width: 300px;')
			)->setLabel('Số điện thoại');
		$dezhub->addElement(
			'inputdate', 
			'birthday'
			)->setLabel('Ngày sinh');
		$dezhub -> addElement('select', 'gender', array("style"=>"width:100px"),array("label"=>"Giới tính","options"=>array(0=>"Nữ",1=>"Nam")));		
		$dezhub -> addElement('text', 'job')->setLabel("Chức vụ/ Nghề nghiệp");
		$dezhub -> addElement('text', 'website',
			array(
				"data-help-block"=>"Bắt đầu với http://",
				"placeholder"=>"http://",
				"data-type"=>"url",
			))->setLabel("Website");
		$dezhub->addElement(
			'text', 
			'facebook', 
			array('style' => 'width: 300px;',
			"data-help-block"=>"Bắt đầu với https://facebook.com/",
			"data-type"=>"url",
			"placeholder"=>"https://facebook.com/",
			)
			)->setLabel('Facebook');
		$dezhub -> addElement('textarea', 'interests',array("style"=>"height:150px"))->setLabel("Một vài điều về bản thân/sở thích");
		$dezhub -> addElement('checkbox', 'active',NULL,array("label"=>"Kích hoạt"));		
		
		parent::insertSubmitButton();
		$dezhub->addElement('hidden', 'oldUser', $data['username']);		
		$dezhub->addElement('hidden', 'oldEmail', $data['email']);
		$username->addRule('required', 'Bắt buộc nhập');
		$email->addRule('required', 'Bắt buộc nhập');
		if($msg != "edit"){
			$pwd->addRule('required', 'Password is required');
		
		}
		
		if( parent:: validate() ){
			
			if( !$_POST['id'] ){				
				$this->arr_fields['password'] = md5( $_POST['password'] );				
				$this -> dezDB -> insert( $this->arr_fields );
				$_SESSION['msg'] = $this->get_config_vars('msg_insert');
			}else {			
				$id = $_POST['id'];
				if( $_POST['password']){
					$this->arr_fields['password'] = md5( $_POST['password'] );
				}
				
				$this -> dezDB -> updateWithPk($id, $this->arr_fields);
				$_SESSION['msg'] = $this->get_config_vars('msg_edit');	
			}
			
			$this -> redirect("?".$this->submit_url);
		}
		
	parent::displayForm();

	}
	function checkExistUser( $username='' ){
		
		$sTbl = 'dz_user';
		$oldUser = $_POST['oldUser'];
		if( $oldUser != '' && $username == $oldUser )
			return true; 
		$query = "username='$username'";		
		$row = $this->dezDB -> getRowTable( $sTbl, $query );
		if( is_array($row) && count( $row ) > 0 ){
			return false;
		}		
		return true;
	}
	
	function checkExistEmail( $email='' ){
		
		$sTbl = 'dz_user';
		$oldEmail = $_POST['oldEmail'];
		if( $oldEmail != '' && $email == $oldEmail )
			return true; 
		$query = "email='$email'";		
		$row = $this->dezDB -> getRowTable($sTbl, $query );
		if( is_array($row) && count( $row ) > 0 ){
			return false;
		}		
		return true;
	}
	
	function listUser( $sMsg = "")
	{		
		
		$this->getPath($this->get_config_vars('list_root_user'));
		$this->grid->setMethod($this->submit_url);
		//$table = "(SELECT * FROM user) as user ";
		$this->grid->setTable($this->table);
		
		$this->grid->addFilter(array(
			"field"	=>"username",
			"display" => "Tên đăng nhập",
			"name"	=> "username",
			"type"=> "text",
			'selected'=> $_REQUEST['username']
		));
			
		$this->grid->addFilter(array("field"	=>"user_type_id","display"=> $this->get_config_vars('user_type'),"name"=> "user_type_id","selected"=> isset($_REQUEST["user_type_id"])?$_REQUEST["user_type_id"]:"","options"=> $this->dezDB->getAssocTable("dz_user_type","id,name")));

		$this->grid->addField(array("field" => "id",	"display" => $this->get_config_vars('id'),"primary_key" =>true,"sortable" => true));
		$this->grid->addField(array("field"=>"username","display"=>"Username","sortable"=> true));
		$this->grid->addField(array("field"=>"fullname","display"=>"Họ tên","sortable"=> true));
		$this->grid->addField(array("field" => "create_date","display" => $this->get_config_vars('create_date'),	"datatype" => "datetime","sortable" => true));
		$this->grid->addField(array("field"=> "user_type_id","display" => $this->get_config_vars('user_type'),"sql"=> "select name from dz_user_type where dz_user_type.id=user_type_id","sortable"=> true));
		$this->grid->addField(array("field" => "active","display" => $this->get_config_vars('active'),"datatype" => "publish","sortable" => true));
		
		$this->grid->addTaskAll(array("task" => "multi_delete","display" => "Delete"));
		
		$aAction = $this->getAct();				
		
		$aAction[1]['display'] = array('field' => 'user_type_id', 'operation' => 'notequal', 'value' => 'super admin');		
		$aAction[2]['display'] = array('field' => 'user_type_id', 'operation' => 'notequal', 'value' => 'super admin');		
		$this->grid->setTask($this->getAct());
		$this->grid -> setMessage( $_SESSION['msg'] );
		$this->grid->displayGrid();
		unset( $_SESSION['msg'] );
	}		
	
}

?>