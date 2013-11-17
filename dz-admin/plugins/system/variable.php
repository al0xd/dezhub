<?php defined('SITE_DIR') or exit('Direct script access is not allowed!');
/*
******************************************************************************************   

  Package            : Dezhub  [ Web Application Framework ]
  Version            : 2.0.1
      
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
class AdminVariable extends BaseVariable  
{
	public $quickForm,$table,$_prefix,$base;
	public $db;
	function __construct(){
		parent::__construct();
		parent::setTitle();
		parent::initForm();
		$this->base = new BaseVariable();
		$this->table = "dz_system";
		$this->_prefix = "System_";
		$this->dezDB->setPrimaryKey($this->_prefix."ID");
		$this->dezDB->setTable($this->table);
		$this->submit_url= parent::getModuleUrl();
		if($this->isPost()){
			$this->arr_fields = array(
				$this->_prefix.'Name' => stripcslashes($_POST[$this->_prefix.'Name']),
				$this->_prefix.'Value' =>stripcslashes($_POST[$this->_prefix.'Value']),
				$this->_prefix.'Code' => $_POST[$this->_prefix.'Code'],
				$this->_prefix.'Type' => $_POST[$this->_prefix.'Type'],
				$this->_prefix.'LangID' => stripcslashes($_POST[$this->_prefix.'LangID']),
			);
		}
	
	}
	
	function run( $task )
	{	global $oSmarty;
		//$oSmarty->compile_check =true;
		switch ( $task )
		{
			default:
				$this -> listItem();
				break;
		}		
	}
	
	function listItem()
	{
		//$slogan = admin_system::get_slogan();
		$arr_variable = array("contact_email","video","logo","home_about","google_analytics","footer_context");
		$this->getPath();
		foreach($arr_variable as $k){
			$data[$k] = $this->base->get_value_variable_by_code($k);
		}
		parent::setFormData($data);
		if(isset($_SESSION['msg'])){
			$msq = '<div class="alert alert-success pulsate-regular" style="width:250px;margin-bottom:0">
			<button class="close" data-dismiss="alert"></button>
			'.$_SESSION['msg'].'.
			</div>';
			$this->quickForm -> addStatic ('static' , NULL,array("label"=>"","content"=>$msq));	
		}
		unset($_SESSION['msg']);
		
		$labelglobal = parent::setFormFieldSet("Thiết lập chung");
		$labelglobal -> addElement('text', "contact_email",array("style" => "height:150px"),array("label"=>"Email nhận liên hệ"));
		$labelglobal -> addElement('imagepopup', "logo",array("data-folder"=>"Images"))->setLabel('Logo');	
		$labelglobal -> addElement('textarea', "google_analytics",array("data-help-block"=>'Không cần thêm các thẻ &lt;script&gt;,&lt;/script&gt;',"style" => "height:150px"))->setLabel("Google Analytics");
		$labelglobal -> addElement('text', "video",array("data-help-block"=>"VD: http://www.youtube.com/watch?v=JDtg-FZHIV4","style" => "height:150px"),array("label"=>"Video url"));
		$labelglobal -> addElement('editor', "home_about")->setLabel("Bài giới thiệu ngắn ở trang chủ");
		$labelglobal -> addElement('editor', "footer_context")->setLabel("Nội dung cuối trang");
	
		parent::insertSubmitButton();
		if(parent::validate())
		{
			$formval = $this->quickForm->getValue();
			foreach($arr_variable as $k){
				$data[$k] = $this->base->update_variable_by_code($k,array("System_Value"=>$formval[$k]));
			}
			//$admin->save_variable($formval);
			$_SESSION['msg'] = "Đã lưu cấu hình";
			$this->quickForm->toggleFrozen(true);
			$this -> redirect("?".$this->submit_url);	
			
		}
		parent::displayForm();
		
	}	
	
}
?>
