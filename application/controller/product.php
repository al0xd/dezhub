<?php
class Product extends BaseProduct
{
	public $db,$s;

	public function run($task="")
	{	
		switch($task){
			case "view":
			$post_id = $_GET['post_id'];
			 parent::view_item($post_id);
			 break;
			case "home": 
			 $this->home();
			 break;
			case "list": 
			$page = $_GET['post_id'];
			 parent::list_item($page);
			 break;
		}
				
	}
}
?>