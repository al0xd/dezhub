<?php 
__MODEL('variable');
class BaseFooter extends Module_Base
{
	public $db;
	public function __construct() {
		
		parent::__construct();
	}
	protected function show(){
		$variable = new BaseVariable();
		$footer_context = $variable->get_value_variable_by_code("footer_context");
		$this->s->assign("footer_context",$footer_context);
		$this->s->display("footer".TPL,"page");
	}
}
?>