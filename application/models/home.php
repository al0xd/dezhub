<?php 
__MODEL("nav,variable");
class BaseHome extends Module_Base
{
	public $db,$s;
	public function __construct() {
		parent::__construct();
	}
	public function _home_form(){
		// function in here
		$nav = new BaseNav();
		$variable = new BaseVariable();

		$home_about = $variable->get_value_variable_by_code("home_about");
		$this->s->assign("home_about",$home_about);
		$menu = $nav->get_primary_menu();
		if(checkMultiLang())
			$this->s->assign("lang",$_SESSION['lang']."/");
			
		$this->s->display("home_default".TPL,"page");
	}
}
?>