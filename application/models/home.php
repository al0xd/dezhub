<?php 
class BaseHome extends Module_Base
{
	public $db,$s,$dezDB;
	public function __construct() {
		parent::__construct();
	}
	public function _home_form(){
		// function in here
		$table = "dz_helloword";
		$where = "dz_id=1";
		$row = $this->dezDB->getRowTable($table,$where);
		$this->s->assign("home",$row);
		$this->s->display("home_default".TPL,"page");
	}
}
?>