<?php
__MODEL("category");
class BaseOption extends BaseCategory
{
	var $table;
	var $pk;
	var $_prefix;
	var $arr_fields;
	var $mod;
	var $type;
	var $quickForm;
	public $db,$s,$grid,$dezDB,$tbl_icon,$type_icon;
	public function __construct() {
		parent::__construct();
		parent::_setTypePost("portfolio_option");
		$this->tbl_icon = "dz_term_taxonomy";
		$this->type_icon="portfolio_icon";
	}
	public function get_list_option(){
		$cond ="type='{$this->type}'";
		$list = $this->dezDB->getAllLimit($this->table,$cond,"z_index","asc");
		return $list;
	
	}
	public function get_option_by_id($id=null,$type=""){
		if($id){
			$sql = "select description from {$this->tbl_icon} 
			where taxonomy='{$type}' and term_id=$id";
			return $this->dezDB->getOne($sql);
			
		}
	}
	public function _get_icon_by_id($id=null){
		if($id){
			$sql = "select description from {$this->tbl_icon} 
			where taxonomy='{$this->type_icon}' and term_id=$id";
			$icon = $this->dezDB->getOne($sql);
			return $icon;
		}
	}
	public function _update_icon($id=null,$val=""){
		if($id){
			$this->dezDB->del_rec($this->tbl_icon,"taxonomy='{$this->type_icon}' and term_id=$id");
			$ainsert = array(
				"term_id"=>$id,
				"taxonomy"=>$this->type_icon,
				"description"=>$val,
			);
			if($val!=""){
				$this->dezDB->add_rec($this->tbl_icon,$ainsert);
			}
		}
	}
	public function update_option($id=null,$val="",$type=""){
		if($id){
			$this->dezDB->del_rec($this->tbl_icon,"taxonomy='{$type}' and term_id=$id");
			if($val!=""){
				$ainsert = array(
					"term_id"=>$id,
					"taxonomy"=>$type,
					"description"=>$val,
				);
				$this->dezDB->add_rec($this->tbl_icon,$ainsert);
			}
		}
		
	}	
	public function delete_option($id=null,$type=""){
		if($id && $type!=""){
			$this->dezDB->del_rec($this->tbl_icon,"taxonomy='{$type}' and term_id=$id");
		}
	}
	public function delete_meta($id=null,$type=""){
		if($id && $type!=""){
			$cond = "(taxonomy='{$type}_meta_title' or taxonomy='{$type}_meta_description') and term_id=$id";
			$this->dezDB->del_rec($this->tbl_icon,$cond);
			$cond = "post_type ='{$type}_tag' and attribute_id=$id";
			$this->dezDB->del_rec("dz_group_attribute",$cond);
		}
	}
}
?>