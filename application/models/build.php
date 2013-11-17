<?php 
__MODEL("nav,variable");
class BaseBuild extends Module_Base
{
	public $s,$dezB;
	public function __construct() {
		parent::__construct();
		if(!parent::isLogin()){
			$backurl = selfURL();
			parent::redirect(SITE_URL."dz-admin/?task=login&backurl=".urlencode($backurl));
			exit();
		}
	}
	
	public function buildPage(){
		
		$this->s->display("build_page_service.tpl");
	}
}
?>