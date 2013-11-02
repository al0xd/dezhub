<?php
class Home extends BaseHome
{
	public $db,$s;
	function __construct() {
		parent::__construct();
	}
	
	function run($task="")
	{	
		switch($task){
			case "frond":
			 break;
			case "home": default: 
			 $this->_home_form();
			 break;
		}
				
	}
	
}
?>