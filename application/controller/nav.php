<?php
class Nav extends BaseNav
{
	public $s,$db;
	function run($task="")
	{	
		$this->s->display("nav".TPL,"page");
				
	}
	
}
?>