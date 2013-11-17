<?php 
class BasePartner extends Module_Base
{
	public $db,$s,$grid,$type,$type_item,$_prefix,$dezDB,$quickForm,$submit_url;
	
	public function __construct() {
		
		parent::__construct();
		parent::isLogin();
		parent::initForm();
		parent::setTitle();
		$this->table = "dz_post";
		$this->dezDB->setPrimaryKey('id');
		$this->dezDB->setTable($this->table);
		$this->type='partner';
		$this->_prefix='post_';
		$this->submit_url= parent::getModuleUrl();
		if($this->isPost()){
			$form = $this->quickForm->getValue();
			$createtime =  ($form[$this->_prefix.'createtime'])?$form[$this->_prefix.'createtime']:date("Y-m-d h:i:s");
			$updatetime =  ($form[$this->_prefix.'updatetime'])?$form[$this->_prefix.'updatetime']:date("Y-m-d h:i:s");
			$this->arr_fields = array(
				$this->_prefix.'title' => stripcslashes($form[$this->_prefix.'title']),
//				$this->_prefix.'code' => stripcslashes($form[$this->_prefix.'code']),
				$this->_prefix.'photo' => stripcslashes($form[$this->_prefix.'photo']),
				$this->_prefix.'gid' => stripcslashes($form[$this->_prefix.'gid']),
				$this->_prefix.'description' => stripcslashes($form[$this->_prefix.'description']),
//				$this->_prefix.'content' => stripcslashes($form[$this->_prefix.'content']),
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
	
	public function _list(){
		$cond = "{$this->_prefix}type='{$this->type}' and {$this->_prefix}status=1";
		$row = $this->dezDB->getAllLimit($this->table,$cond,$this->_prefix."description","asc");
		return $row;
	}
}
?>