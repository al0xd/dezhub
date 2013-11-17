<?php
class Css extends Module_Base
{
	public $css,$db,$s;
	function __construct(){
		parent::__construct();
	}
	function run($task=""){
		$modul = "home";
		if(isset($_GET['mod'])){
			$modul= $_GET["mod"];
		}
		if(isset($_GET['task'])){
			$task = $_GET['task'];
		}
		if(file_exists(CONTROLPATH."$modul.php")) {
			if(file_exists(MODELPATH."{$modul}.php")) {
				include_once(MODELPATH."{$modul}.php");
			}
			include_once(CONTROLPATH."$modul.php");
			$namespace  =  ucfirst($modul);
			$mod = new $namespace();
			if(method_exists($mod,"css")){
				$this->s->setTemplateDir(VIEWPATH.$modul);
				$mod->css($task);
			}else{
				$this->s->display("style".TPL,"page");
			}
		}
	
	}
}
?>