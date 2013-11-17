<?php
class BaseVariable extends Module_Base
{
	var $table;
	var $pk;
	var $_prefix;
	var $arr_fields;
	var $mod;
	var $type;
	var $quickForm;
	public $db,$s,$grid,$dezDB,$tbl_icon,$type_icon;
	public function __construct() {
		parent::__construct();
		$this->table= "dz_system";
		$this->dezDB->setTable($this->table);
		$this->_prefix="System_";
		$this->dezDB->setPrimaryKey($this->_prefix."ID");
	}
	public function get_variable_by_id($id=null){
		if($id){
		return $this->dezDB->getRow($id);
			
		}
	}
	public function get_variable_by_code($type=null){
		if($type){
			$cond  = "{$this->_prefix}Code='{$type}'";
			return $this->dezDB->getRowTable($this->table,$cond);
			
		}
	}
	public function get_value_variable_by_code($type=null){
		if($type){
			$cond  = "select {$this->_prefix}Value from {$this->table} where {$this->_prefix}Code='{$type}'";
			return $this->dezDB->getOne($cond);
			
		}
	}
	public function update_variable_by_code($code=null,$data=array()){
		if($code&& count($data)>0){
			$cond = $this->_prefix."Code='{$code}'";
			$this->dezDB->del_rec($this->table,$cond);
			$ainsert = array(
//				$this->_prefix."Name"	=>	$data[$this->_prefix."Name"],
				$this->_prefix."Value"	=>	$data[$this->_prefix."Value"],
				$this->_prefix."Code"	=>	$code,
//				$this->_prefix."Type"	=>	($data[$this->_prefix."Type"])?$data[$this->_prefix."Type"]:"variable",
//				$this->_prefix."LangID"	=>	$data[$this->_prefix."LangID"],
			);
			if(checkMultiLang())
				$ainsert[$this->_prefix."LangID"] = $data[$this->_prefix."LangID"];
			if($data[$this->_prefix."Type"])
				$ainsert[$this->_prefix."Type"] = $data[$this->_prefix."Type"];
			if($data[$this->_prefix."Name"])
				$ainsert[$this->_prefix."Name"] = $data[$this->_prefix."Name"];
			
			
			return $this->dezDB->add_rec($this->table,$ainsert);
		}
	}
	public function delete_variable_by_code($code=null){
		if($code){
			$cond = $this->_prefix."Code='{$code}'";
			$this->dezDB->del_rec($this->table,$cond);
	
		}
	}
}
?>