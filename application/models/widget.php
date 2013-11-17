<?php 
class BaseWidget extends Module_Base
{
	var $table;
	var $quickForm;
	public $db,$s,$type,$type_item,$submit_url,$_prefix,$dezDB;
	public function __construct() {
		
		parent::__construct();
		parent::initForm();
		parent::setTitle();
		$this->table = "dz_post";
		$this->dezDB->setPrimaryKey('id');
		$this->dezDB->setTable($this->table);
		$this->type='nav_menu';
		$this->type_item='nav_menu_item';
		$this->_prefix='post_';
		$this->submit_url= parent::getModuleUrl();
	}
}
?>