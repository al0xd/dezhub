<?php defined('SITE_DIR') or exit('Direct script access is not allowed!');
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
	class AdminNav  extends BaseNav
	{
		public $quickForm,$s,$dezDB,$submit_url;
			function __construct(){
				parent::__construct();
			}
			
			function run( $task )
			{	
				switch ( $task )
				{
					default:
						$this -> listItem();
						break;
					case "new":
						$this -> add_menu();
						break;
					case "delete":
						$this -> delete_menu(intval($_GET['menu']));
						break;
					case "save_menu":
						$this -> save_menu();
						break;
				}		
			}
			function delete_menu($id=0){
				if($id>0){
					$cond = "post_id in(select attribute_id from
							dz_group_attribute where post_type='nav_menu_item' and group_id=$id)";
					$this->dezDB->del_rec("dz_post",$cond);
					$cond="post_type='nav_menu_item' and group_id=$id";
					$this->dezDB->del_rec("dz_group_attribute",$cond);
					$cond="type='nav_menu' and id=$id";
					$this->dezDB->del_rec("dz_category",$cond);
					
					$cond="taxonomy='nav_menu_item' and parent=$id";
					$this->dezDB->del_rec("dz_term_taxonomy",$cond);
					$_SESSION['msg']="Đã xóa thành công!";
					$this->redirect("?{$this->submit_url}");
				}
			}
			function save_menu(){
				if(parent::isPost() && isset($_POST['btn_save_menu'])){
					$menu_id =  intval($_POST['menu']);
					if(isset($_POST['menu']) && $menu_id>0){
						parent::clear_nav_data($menu_id);
						if($_POST['is_primary'])
							$this->set_primary_menu($menu_id);
						if($_POST['menu_postion'])
							$this->set_position_menu($menu_id,$_POST['menu_postion']);
						$content = htmlspecialchars_decode($_POST['menu_item']);
						$json = (array)json_decode($content);
						if(is_array($json)){
							foreach($json as $k=>$v){
								$v = (array)$v;
								self::insert_menu_item_repeat($v,0,$k);
							}
						}
					}
					
				}
				$_SESSION['msg'] = "Đã lưu menu thành công!";
				parent::redirect("?{$this->submit_url}&menu=$menu_id");
			}
			function insert_menu_item_repeat($item,$parent=0,$index=0){
				$id = parent::insert_menu_item($item,$parent,$index);
				if(is_array($item['children'])){
					foreach($item['children'] as $ks=>$vs){
						$vs = (array)$vs;
						self::insert_menu_item_repeat($vs,$id,$ks);
					}
				}
			}
			function listItem(){
				$this -> getPath();
				$msg = $_SESSION['msg'];
				$this->s->assign("msg",$msg);
				unset($_SESSION['msg']);
				if(isset($_REQUEST['menu'])){
					$id = intval($_REQUEST['menu']);
					$menu = $this->get_menu_by_id($id);
				}else{
					$menu = $this->get_primary_menu();
				}
				$listmenu = $this->get_all_menu();
				$category = $this->get_all_category();
				$page = $this->get_all_page();
				$this->s->assign("category",$category);
				$this->s->assign("page",$page);
				$this->s->assign("listmenu",$listmenu);
				$this->s->assign("menu",$menu);
				$this->s->assign("type_menu",$this->type_menu);
				if(checkMultiLang())
					$this->s->assign("language",$this->getAssocLang());
				$this->s->display("nav.tpl");
			}
	}
?>