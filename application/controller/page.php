<?php
class Page extends BasePage implements InterfacePage
{
	public $db,$s;
	public function run($task="")
	{	
		switch($task){
			case "home": default: 
			$page = $_GET['page_id'];
			 parent::viewpage($page);
			 break;
			case "build":
			$this->buildPage();
			break;
			
		}
				
	}
	
}
?>