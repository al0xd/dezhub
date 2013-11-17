<?php
class Post extends BasePost implements InterfacePost
{
	public $db,$s;

	public function run($task="")
	{	
		switch($task){
			case "home": default: 
			$post_id = $_GET['post_id'];
			 parent::view_item($post_id);
			 break;
			case "list": 
			$page = $_GET['post_id'];
			 parent::list_item($page);
			 break;
		}
				
	}
}
?>