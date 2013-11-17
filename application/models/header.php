<?php 
__MODEL("nav,variable");
class BaseHeader extends Module_Base
{
	public $s,$dezB;
	public function __construct() {
		parent::__construct();
	}
	public function show(){
		$nav = new BaseNav();
		$variable = new BaseVariable();
		$logo = $variable->get_value_variable_by_code("logo");
		$this->s->assign("logo",$logo);
		
		$google_analytics = $variable->get_value_variable_by_code("google_analytics");
		$this->s->assign("google_analytics",$google_analytics);
		$primary_menu = $nav->get_primary_menu();
//		var_dump($primary_menu);
		$this->s->assign("primary_nav",$primary_menu);
		$header_menu = $nav->get_menu_by_position("header_menu");
		$this->s->assign("header_menu",$header_menu);
		if(checkMultiLang()){
			$this->s->assign("lang",$_SESSION['lang']."/");
			$where = " and post_lang_id=".$_SESSION['lang_id'];
		}
		$this->s->assign("primary_nav",$primary_menu);
		$sql = "post_type='slideshow' and post_status=1 {$where}";
		$slideshow = $this->dezDB->getAllLimit("dz_post",$sql,"post_description","asc");
//		var_dump($slideshow);
		$this->s->assign("slideshow",$slideshow);
		$this->s->display("header".TPL,"page");
	}
}
?>