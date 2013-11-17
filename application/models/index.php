<?php 
class BaseIndex extends Module_Base
{
	public $db,$s,$dezDB;
	public function __construct() {
		parent::__construct();
		$this->table="dz_helloworld";
		$this->dezDB->setTable($this->table);
		$this->dezDB->setPrimaryKey("id");
	}
	
	public function run($task= "")
	{
		$home = $this->dezDB->getRow(1);
		$this->s->assign("home",$home);
		$this->s->display("helloworld".TPL);
	}

	
}
?>