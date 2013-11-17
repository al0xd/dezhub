<?php 
__MODEL("variable,partner");
class BaseSlidebar extends Module_Base
{
	public $s,$dezB;
	public function __construct() {
		parent::__construct();
		
	}
	public function run($task="")
	{	
		$variable = new BaseVariable;
		$video = $variable->get_value_variable_by_code("video");
		$this->s->assign("video",$video);
		$partner = new BasePartner;
		$row = $partner->_list();
		$this->s->assign("partner",$row);
		$this->s->display("slidebar".TPL,"page");
				
	}
}
?>