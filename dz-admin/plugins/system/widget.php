<?php
/************************************************
**
**
************************************************/
namespace Admin\System;
	class Widget  extends \Models\Widget
	{
		public $quickForm,$s,$dezDB,$submit_url;
			function __construct(){
				
				parent::__construct();
				$this->s = $oSmarty;
				
			}
			
			function run( $task )
			{	
				switch ( $task )
				{
					default:
						$this -> listItem();
						break;
				}		
			}
			function listItem(){
				$this -> getPath();
				$msg = $_SESSION['msg'];
				$this->s->assign("msg",$msg);
				unset($_SESSION['msg']);
				$this->s->display("widget.tpl");
			}
	}
?>