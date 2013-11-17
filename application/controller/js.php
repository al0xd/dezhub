<?php
class Js extends Module_Base
{
	public $s;
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
			$namespace  = ucfirst($modul);
			$mod = new $namespace();
			if(method_exists($mod,"js")){
				$this->s->setTemplateDir(VIEWPATH.$modul,"js");
				$mod->js($task);
			}else{
				$this->s->display("javascript".TPL,"page");
			}
		}
	
	}
	
 
}
?>