<?php
class AdminProfile extends Module_Base  
{
	public $quickForm,$dezDB;
	function __construct(){
		
		parent::__construct();
		parent::setTitle();
		parent::initForm();
		$this->table = "dz_user";
		$this->dezDB->setPrimaryKey('id');
		$this->dezDB->setTable($this->table);
		$this->submit_url= parent::getModuleUrl();
		if($this->isPost()){
			$form = $this->quickForm->getValue();
			$this->arr_fields = array(
				'password' => md5($form['password']),
			);
		}
	
	}
	
	function run( $task )
	{	global $oSmarty;
		//$oSmarty->compile_check =true;
		
		switch ( $task )
		{
			case "changepassword":
				$this -> changePassword();
				break;
			default:
				$this -> myProfile();
				break;
		}		
	}
	function changePassword ()
	{
		global $oDb;
		
		$this->getPath();
		// data source with default values:
		$sql = "select distinct group_id from dz_group_attribute where attribute_id=".$arrData['id'];
		$arrData["group_id"] = $oDb->getCol($sql);
		parent::setFormData($arrData);
		// text input elements
		$dezhub = parent::setFormFieldSet();
		if($_SESSION['msg']){
			$msq = '<div class="alert alert-success pulsate-regular" style="width:250px;margin-bottom:0">
			<button class="close" data-dismiss="alert"></button>
			Đổi mật khẩu thành công.
			</div>';
			$dezhub -> addStatic ('static' , NULL,array("label"=>"","content"=>$msq));	
			unset($_SESSION['msg']);

		}
		$rename = $dezhub->addElement(
			'password', 
			'oldpassword', 
			array('style' => 'width: 300px;')
			)->setLabel('Mật khẩu cũ');

		$newpassword = $dezhub->addElement(
			'strengpassword', 
			'password', 
			array('style' => 'width: 300px;')
			)->setLabel('Mật khẩu mới');
		$confirmpass = $dezhub->addElement(
			'password', 
			'password_confirm', 
			array('style' => 'width: 300px;')
			)->setLabel('Xác nhận mật khẩu');

	
		$rename->addRule('callback', 'Mật khẩu cũ chưa chính xác!',array('callback' => 'checkPassword'));
		$confirmpass->addRule('callback','Xác nhận mật khẩu chưa chính xác!',
		array('callback' => 'checkConfirmPassword'));
		$newpassword->addRule('callback','Mật khẩu mới phải khác mật khẩu cũ.',
		array('callback' => 'checkSamePassword'));
		parent::insertSubmitButton();
	if (parent::validate()) {
				if(isset($_COOKIE['dzh_uid'])){
					$this->dezDB->updateWithPk($_COOKIE['dzh_uid'], $this->arr_fields);
					$_SESSION['msg'] = $this->get_config_vars('msg_edit');
				}
				
				$this -> redirect("?".$this->submit_url."&task=".$_REQUEST['task']);
				
	}
	

	parent::displayForm();	
		
	}		



	function myProfile ()
	{
		global $oDb;
		
		$this->getPath();
		
		// data source with default values:
		$arrData= parent::getUserbyCookie();
//		$form->addDataSource(new HTML_QuickForm2_DataSource_Array($arrData));
		parent::setFormData($arrData);
		// text input elements
//		$dezhub = $form->addElement('fieldset');
		$dezhub = parent::setFormFieldSet("");
		if($_SESSION['msg']){
			$msq = '<div class="alert alert-success pulsate-regular" style="width:250px; margin-bottom:0">
			<button class="close" data-dismiss="alert"></button>
			Đổi thông tin cá nhân thành công.
			</div>';
			$dezhub -> addStatic ('static' , NULL,array("label"=>"","content"=>$msq));	
			unset($_SESSION['msg']);

		}
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

	
		//$newpassword->addRule('required', 'Bạn phải nhập mật khẩu mới');
		//$confirmpass->addRule('required', 'Bạn phải xác nhận mật khẩu');
		parent::insertSubmitButton();
	if (parent::validate()) {
		$form = $this->quickForm->getValue();
				$arr_fields = array(
					"email" => $form["email"],
					"phone" => $form["phone"],
					"job" => $form["job"],
					"gender" => $form["gender"],
					"avatar" => $form["avatar"],
					"interests" => stripcslashes($form["interests"]),
					"website" => urlencode($form["website"]),
					"facebook" => urlencode($form["facebook"]),
					"birthday" => $form["birthday"],
					"fullname" => $form["fullname"],
				);
				// group
	    $this->quickForm->toggleFrozen(true);
				
				if(isset($_COOKIE['dzh_uid'])){
					$this->dezDB->updateWithPk($_COOKIE['dzh_uid'], $arr_fields);
					$_SESSION['msg'] = $this->get_config_vars('msg_edit');
				}
				
				$this -> redirect("?".$this->submit_url."&task=".$_REQUEST['task']);
				
	}
	


		parent::displayForm();	
	
		
	}		


}
?>
