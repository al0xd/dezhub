<?php
class AdminTags extends BaseTags
{
	var $table;
	var $quickForm;
	var $_prefix;
	var $arr_fields;
	var $mod;
	var $submit_url;
	public $type,$db,$s,$grid;
	function __construct() {
		parent::__construct();		
		parent::setTitle();
	}
	function run($task){
		
		switch ($task)
		{			
			case "add":
				BaseTags::addItem();
				break;
			case "edit":
				BaseTags::editItem();
				break;
			case "delete":
				BaseTags::deleteItem();
				break;
			case "multi_delete":
				BaseTags::multiDeleteItem();
				break;
			case 'change_status':
				BaseTags::changeStatus();
				break;		
			case "autocomplete":
				BaseTags::getAssocTags();
				break;
			case "list" :	
			default: 			
				BaseTags::listItem();
				 break;
		}
	}
	

}
?>