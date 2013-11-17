<?php
class Home extends BaseHome
{
	public $db,$s;
	function __construct() {
		BaseHome::__construct();
	}
	
	function run($task="")
	{	
		global $oSmarty,$oDb;
		switch($task){
			case "frond":
			 break;
			case "home": default: 
			 BaseHome::_home_form();
			 break;
		}
				
	}
	
	function  getPageInfo($sTask){
		$aPageinfo['title'] = $this->s->getConfigVariable("title_home");
		$aPageinfo['keyword'] = $this->s->getConfigVariable("keyword_home");
		$aPageinfo['description'] = $this->s->getConfigVariable("description_home");
		$aPageinfo['image'] = SITE_URL."public/img/logo.jpg";
		return $aPageinfo;
	}	
}
?>