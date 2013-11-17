<?php
require_once(MODELPATH."variable.php");
class Contact extends Module_base
{
	public $db,$s,$variable;
	function __construct() {
		parent::__construct();
		$this->variable = new BaseVariable();
	}
	
	function run($task="")
	{	
		switch($task){
			case "home": default: 
			$this->contact();
			 break;
		}
				
	}
	function contact(){
		if($this->isPost()){
			foreach($_POST as $k=> $val){
				if(in_array($k,array("hoten","email","dienthoai"))){
					if($val==""){
						$_e[$k] = "has-warning";
					}
					if($k=="email" || $k=="email2"){
						$regex = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
						if (!preg_match($regex, $val)) {
							$_e[$k] = "has-warning";
						}
					}
				}
			}
			if($_POST['captcha']!=$_SESSION['captcha']){
				$_e['captcha'] = "has-warning";
			}
				
			if($_e)	{
				$this->s -> assign("msg", $this->s->getConfigVariable('send_booking_failer'));
				$this->s -> assign("error", $_e);
			}
			else{	
				$headers  = 'MIME-Version: 1.0'."\r\n";
				$headers .= 'Content-type: text/html;charset=utf-8'."\r\n";			
				$headers .= 'From: '.$_POST['hoten'].' - <'.$_POST['email'].'>'."\r\n";			
				$this->s->assign("data",$_POST);
				$content = $this->s->fetch("contact_mail".TPL,"page");
				$subject = "Thư liên hệ";
				$to = $this->variable->get_value_variable_by_code("contact_email");
				
				$success = @mail($to, $subject, $content, $headers);
				if($success==1)
					$this->s -> assign("msg", $this->s->getConfigVariable('send_booking_sucess'));
				else
					$this->s -> assign("msg", $this->s->getConfigVariable('send_booking_failer'));
			}
		
		
		}
		$captcha['a'] = rand(1,20);
		$captcha['b'] = rand(1,20);
		$_SESSION['captcha'] = $captcha['a'] + $captcha['b'];
		$this->s -> assign("captcha", $captcha);
		$this->s->display("contact".TPL,"page");
	}
	
	function  getPageInfo($sTask){
		$aPageinfo['title'] =$this->s->getConfigVariable("title_home");
		$aPageinfo['keyword'] = $this->s->getConfigVariable("keyword_home");
		$aPageinfo['description'] = $this->s->getConfigVariable("description_home");
		$aPageinfo['image'] = SITE_URL."public/img/logo.jpg";
		return $aPageinfo;
	}
	
}
?>