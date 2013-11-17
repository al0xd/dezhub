<?php 
class BaseNav extends Module_Base
{
	var $table;
	var $quickForm;
	public $db,$s,$type,$type_item,$submit_url,$_prefix,$dezDB;
	public function __construct() {
		
		parent::__construct();
		parent::initForm();
		parent::setTitle();
		$this->table = "dz_post";
		$this->dezDB->setPrimaryKey('id');
		$this->dezDB->setTable($this->table);
		$this->type='nav_menu';
		$this->type_item='nav_menu_item';
		$this->_prefix='post_';
		$this->submit_url= parent::getModuleUrl();
		$this->type_menu= array(
			"slidebar_menu" =>"Menu cột trái",
			"header_menu"=>"Menu header"
		);
	}
	public function delete_menu(){
		$id = intval($_REQUEST['menu']);
		$where = " id = $id and type='nav_menu'";
		$this->dezDB->del_rec("dz_category",$where);
		$_SESSION['msg'] = "Xóa menu thành công!";
		parent::redirect("?{$this->submit_url}");
	}
	public function clear_nav_data($id){
		$item  = $this->dezDB->getAllLimit("dz_group_attribute"," group_id=$id and post_type='nav_menu_item' ","attribute_id");
		if($item)
			foreach($item as $k=>$v){
				$cond="parent=$id and taxonomy='nav_menu_item'";
				$this->dezDB->del_rec("dz_term_taxonomy",$cond);
				$this->dezDB->del_rec("dz_post"," post_type='nav_menu_item' and post_id=".$v['attribute_id']);
				
			}
		
		$this->dezDB->del_rec("dz_group_attribute","post_type='nav_menu_item' and group_id=$id");
	}
	public function add_menu(){
		$type = 'nav_menu';
		
		if(parent::isPost() && isset($_POST['btn_new_menu'])){
			$adata = array(
				"name" =>$_REQUEST['nav_menu'],
				"lang_id" =>$_REQUEST['lang_id'],
				"active"=>1,
				"type"=>$type,
				"z_index"=>0,
				"keycode"=>removeMarks($_REQUEST['nav_menu']),
				
			);
			$nav_id = $this->dezDB->add_rec("dz_category",$adata);
			parent::redirect("?{$this->submit_url}&menu=$nav_id");
		}
	}
	public function insert_menu_item($data =array(),$parent=0,$index=0){
		$menu_id = intval($_POST['menu']);
		$type = "nav_menu_item";
		$rec = array(
			"post_title" =>$_POST['name_menu_item_'.$data['id']],
			"post_description" =>$_POST['option_menu_item_'.$data['id']],
			"post_type" =>$type,
			"post_content" =>$data['type'],
		);
		if($data['type']=='nav_link'){
			$rec = array(
			"post_title" =>$_POST['name_menu_item_'.$data['id']],
			"post_description" =>$_POST['option_menu_item_'.$data['id']],
			"post_type" =>$type,
			"post_content" =>$data['type'],
			"post_gid" =>$_POST['url_menu_item_'.$data['id']],
			);
		}
		$nav_id = $this->dezDB->add_rec("dz_post",$rec);
		$taxonomy = array(
			"group_id"=>$menu_id,
			"attribute_id"=>$nav_id,
			"post_type"=>$type,
			"parent_id"=>$parent,
			"z_index"=>$index
		);
		$this->dezDB->add_rec("dz_group_attribute",$taxonomy);
		if($data['type']!='nav_link'){
			$tax= array(
				"term_id"=>$nav_id,
				"taxonomy"=>'nav_menu_item',
				"parent"=>$menu_id,
				"description"=>$data['pid'],
			);
			$this->dezDB->add_rec("dz_term_taxonomy",$tax);
		}
		return $nav_id;
	//	parent::redirect("?{$this->submit_url}");
	}
	public function get_menu_by_id($id = null){
		if($id){
			$sql = "id=$id and type='{$this->type}'";
			$record = $this->dezDB->getRowTable("dz_category",$sql);
			$record['position_menu']= $this->get_positon_by_menu_id($record['id']);
			$record['items'] = self::get_menu_item_by_id($record['id']);
			$sql = "select t1.term_taxonomy_id from dz_term_taxonomy t1 join dz_category t2 
			on t1.term_id=t2.id
			 where t1.taxonomy='primary_menu' and t2.id=$id";
			if($this->dezDB->getOne($sql)>0)
				$record['isprimary']=1;
			//var_dump($record['items']);
			return $record;
		}
	}
	public function get_positon_by_menu_id($id){
		$sql = "select description from dz_term_taxonomy where
		 term_id=$id and taxonomy='position_menu'";
		$res = $this->dezDB->getOne($sql);
		return $res;
	}
	public function get_menu_item_by_id($id=null){
		if($id){
			$child = self::_menu_tree($id,0);
			$submenu = $child['items'];
			if(is_array($submenu)){
				foreach($submenu as $k=>$v){
					$child = self::_menu_tree($id,$v['attribute_id']);
					$submenu[$k]['sub'] = $child["items"];
					if($child['active'])
						$submenu[$k]['active']="active";
						
					if($submenu[$k]['sub'])
						foreach($submenu[$k]['sub'] as $sk=>$sv){
							$child = self::_menu_tree($id,$sv['attribute_id']);
							$submenu[$k]['sub'][$sk]['sub'] = $child['items'];
							if($child['active'])
								$submenu[$k]['sub'][$sk]['active']="active";
								
							if($submenu[$k]['sub'][$sk]['sub'])
								foreach($submenu[$k]['sub'][$sk]['sub'] as $ssk=>$ssv){
									$child = self::_menu_tree($id,$ssv['attribute_id']);
									$submenu[$k]['sub'][$sk]['sub'][$ssk]['sub'] = $child['items'];
									
									if($child['active'])
										$submenu[$k]['sub'][$sk]['sub'][$ssk]['active']="active";
									
									
									if($submenu[$k]['sub'][$sk]['sub'][$ssk]['sub'])
										foreach($submenu[$k]['sub'][$sk]['sub'][$ssk]['sub'] as $sssk=>$sssv){
											$child = self::_menu_tree($id,$sssv['attribute_id']);
											$submenu[$k]['sub'][$sk]['sub'][$ssk]['sub'][$sssk]['sub'] = $child['items'];
											if($child['active'])
												$submenu[$k]['sub'][$sk]['sub'][$ssk]['sub'][$sssk]['active']="active";
										}
								}
						}
				}
			}
			return $submenu;
		}
	}
	public function _menu_tree($menu_id,$parent=0){
		
		$type = parent::_type_category();
		$active = false;
		$where  = "group_id={$menu_id} and parent_id={$parent} and post_type='nav_menu_item'";
		$items = $this->dezDB->getAllLimit("dz_group_attribute",$where,"z_index","asc");
		if($items){
			foreach($items as $k=>$v){
				$cond="post_id={$v['attribute_id']} and post_type='nav_menu_item'";
				$rec = $this->dezDB->getRowTable("dz_post",$cond);
				$sql = "select t1.* from dz_category t1 join dz_term_taxonomy t2 on t1.id =t2.description
				where t2.term_id={$v['attribute_id']}";
				$row = $this->dezDB->querySql($sql);
				$cate = $row[0];
				//var_dump($cate);
				$items[$k]['post_title'] = $items[$k]['post_name']= $rec['post_title'];
				$items[$k]['post_gid'] = $rec['post_gid'];
				$items[$k]['post_content'] = $rec['post_content'];
				$items[$k]['post_description'] = $rec['post_description'];
				$items[$k]['post_id'] = $items[$k]['pid'] = $rec['post_id'];
				$items[$k]['type_name'] = $type[$rec['post_content']]['title'];
				$items[$k]["src"] = $this->get_link_menu_item($rec);
				$items[$k]["active"] = $this->link_selected($rec,$items[$k]["src"]);
				if($items[$k]["active"]=='active')
					$active=true;
				if($cate){
					$items[$k]['post_name'] = $cate['name'];
					$items[$k]['pid'] = $cate['id'];
				}
				if($rec['post_content']=='page'){
					$sql = "select t1.* from dz_post t1 join dz_term_taxonomy t2 on t1.post_id =t2.description
					where t2.term_id={$v['attribute_id']}";
					$cate = $this->db->getRow($sql);
					$items[$k]['post_name'] = $cate['post_title'];
					$items[$k]['pid'] = $cate['post_id'];
				}
			}
			return array("items"=>$items,"active"=>$active);
		}
		
	}
	public function get_link_menu_item($row){
		$id = $row['post_id'];
		switch($row['post_content']){
			case "nav_link":
			$src = $row['post_gid']; break;
			case "page":	
				$sql = "select t1.* from dz_post t1 join dz_term_taxonomy t2 on t1.post_id = t2.description where t2.term_id=$id";
				$post = $this->db->getRow($sql);
				$src = $this->rewrite_link("mod=page&page_id=".$post['post_id'],$post); 
				break;
			case "post":
				$sql = "select t1.* from dz_category t1 join dz_term_taxonomy t2 on t1.id = t2.description where t2.term_id=$id";
				$post = $this->db->getRow($sql);
				$src = $this->rewrite_link("mod=post&post_id=".$post['id'],$post);  break;
			default:
				$sql = "select t1.* from dz_category t1 join dz_term_taxonomy t2 on t1.id = t2.description where t2.term_id=$id";
				$post = $this->db->getRow($sql);
				$src = $this->rewrite_link("mod=".$row['post_content']."&post_id=".$post['id'],$post); 
				break;
				
		}
		return $src;
	}
	public function link_selected($row,$link){
		$self_url= selfURL();
		if(preg_match("/^(http|https)\:\/\//i",$self_url)){
			$self_url = preg_replace ("/^(http|https)\:\/\//i","",$self_url);
			$self_url = str_replace($_SERVER['HTTP_HOST']."/","",$self_url);
		}
		if(preg_match("/^(http|https)\:\/\//i",$link)){
			$link = preg_replace ("/^(http|https)\:\/\//i","",$link);
			$link = str_replace($_SERVER['HTTP_HOST']."/","",$link);
		}
		
		if(checkMultiLang()){
			if(preg_match("/^[a-z]{2}/i",$self_url)){
				$self_url = preg_replace ("/^[a-z]{2}\//i","",$self_url);
			}
		}
		$arr1 = str_split($link);
		$arr2 = str_split($self_url);
		//$active = true;
		if(is_array($arr1))
			foreach($arr1 as $k=>$v){
				if($v!=$arr2[$k]){
					return false;
					break;
				}
			}
		return "active";
	}
	public function get_primary_menu(){
		if(checkMultiLang())
			$where = " and t1.lang_id=".$_SESSION['lang_id'];
		$sql = "select t1.* from dz_category t1 join dz_term_taxonomy t2 on
		t1.id=t2.term_id 
		and t1.type='{$this->type}' and t2.taxonomy='primary_menu'
		$where
		";
		$row = $this->dezDB->querySql($sql);
		$record = $row[0];
		$record['position_menu']= $this->get_positon_by_menu_id($record['id']);
		$record['items'] = self::get_menu_item_by_id($record['id']);
		$record['isprimary'] = 1;
		return $record;
	}
	public function get_all_menu(){
		$table="dz_category";
		$menu = $this->dezDB->getAssocTable($table,"id,name"," type = '{$this->type}'");
		return $menu;
	}
	public function get_all_category(){
		$type_category = parent::_type_category();
		$category = array();
		if($type_category){
			$i=0;
			foreach($type_category as $k=>$v){
				$category[$i]['type'] = $k; 
				$category[$i]['title'] = $v['title']; 
				$category[$i]['items'] = $this->get_category_nav($k,$v); 
				$i++;
			}
			return $category;
		}else
			return false;
	}
	public function get_category_nav($type= null,$v=null){
		$table  = "dz_category";
		$aData = $this -> multiLevel( $table, "id",  "parent_id","*"," type='$type'");
		
		foreach ( $aData as $key => $row){
			$space = "";
			if( $row['level'] > 0){	
				$space = str_repeat( "&nbsp;&nbsp;", $row['level']);	
			}
			$space.="<input type=\"checkbox\" data-type='{$type}' data-type-name='{$v['title']}' data-name='{$row['name']}' name='cate_nav[]' value=\"{$row['id']}\" />";		
			$aData[$key][ "name"] = $space.$row[ "name"];
		}
		return $aData;
		
	}
	public function get_all_page(){
		$table = "dz_post";
		$type="page";
		$prx= "post_";
		$where = $prx."type='{$type}'";
		$items = $this->dezDB->getAllLimit($table,$where,$prx."id","desc");
		return $items;
	}
	public function get_menu_by_position($position=null){
		if($position){
			if(checkMultiLang())
				$where = " and t1.lang_id=".$_SESSION['lang_id'];
			$sql = "select t1.* from dz_category t1 join dz_term_taxonomy t2 on
			t1.id=t2.term_id 
			and t1.type='{$this->type}' and t2.taxonomy='position_menu' and t2.description='{$position}'
			$where
			";
			$row = $this->dezDB->querySql($sql);
			$record = $row[0];
			$record['items'] = self::get_menu_item_by_id($record['id']);
			return $record;
			
		}
	
	}
	public function set_position_menu($menu_id=0,$position=""){
		$type="position_menu";
		if($menu_id>0){
			$where = "";
			if(checkMultiLang())
				$where = " and t2.lang_id=".$_POST['lang_id'];
			$sql = "select t1.term_taxonomy_id from dz_term_taxonomy t1 join dz_category t2
			on t1.term_id=t2.id  where
			t1.taxonomy='{$type}' and t1.description='{$position}'
			$where ";
			$id = $this->db->getOne($sql);
			// delete
			$tbl = "dz_term_taxonomy";
			if($id){
				$cond = " term_taxonomy_id=$id";
				$this->dezDB->del_rec($tbl,$cond);
			}
			$acr = array(
				"term_id"=>$menu_id,
				"description"=>$position,
				"taxonomy"=>$type
			);
			$this->dezDB->add_rec($tbl,$acr);
		}
	
	}
	public function set_primary_menu($menu_id=0,$type="primary_menu"){
		if($menu_id>0){
			//$type="primary_menu";
			$where = "";
			if(checkMultiLang())
				$where = " and t2.lang_id=".$_POST['lang_id'];
			$sql = "select t1.term_taxonomy_id from dz_term_taxonomy t1 join dz_category t2
			on t1.term_id=t2.id  where
			t1.taxonomy='{$type}'
			$where ";
			$id = $this->db->getOne($sql);
			// delete
			$tbl = "dz_term_taxonomy";
			if($id){
				$cond = " term_taxonomy_id=$id";
				$this->dezDB->del_rec($tbl,$cond);
			}
			$acr = array("term_id"=>$menu_id,"taxonomy"=>$type);
			$this->dezDB->add_rec($tbl,$acr);
		}
	}
	public function rewrite_link($src="",$item= array()){
		$link ="";
		$__a = explode("&",$src);
		if(is_array($__a)){
			foreach($__a as $k=>$v){
				$rc = explode("=",$v);
				if($rc[0]=='mod'){
					switch($rc[1]){
						case "post":
							$link.="news/".$item['keycode']; break;
						case "page":
							$link.=$item['post_code']; break;
						default:
							$link.=$item['type']."/".$item['keycode']; break;
					}
						
				}
			}
		}
		return $link;
	}
}
?>