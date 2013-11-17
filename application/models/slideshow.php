<?php 
class BaseSlideshow extends Module_Base
{
	var $table;
	var $quickForm;
	public $db,$s,$type,$type_item,$submit_url,$_prefix,$dezDB;
	public function __construct() {
		parent::__construct();
		parent::initForm();
//		parent::setTitle();
		$this->table = "dz_term_taxonomy";
		$this->dezDB->setPrimaryKey('term_taxonomy_id');
		$this->dezDB->setTable($this->table);
		$this->type='';
		$this->type_item='post_shideshow';
		$this->_prefix='';
		$this->submit_url= parent::getModuleUrl();
	}
	public function get_gallery_by_id($id=null,$type='post'){
		$sql = "select description from dz_term_taxonomy where term_id=".intval($id)." and taxonomy='{$type}_gallery'";
		return $this->dezDB->getOne($sql);
	
	}
	public function buidForm($quickForm){
		$dezhub = parent::setFormFieldSet("Tạo gallery ảnh");		
		$dezhub->addElement('slideshow', 'gallery', array("data-folder"=>"Images"));
			
	}
	public function update($id=null,$type="post",$list=array()){
		$list = array_filter($list);
		if($id){
			$id = intval($id);
			$where = " term_id = $id and taxonomy='{$type}_gallery'";
			$this->dezDB->del_rec("dz_term_taxonomy",$where);
			if(count($list)>0){
				$arr = array(
					"taxonomy"=>$type."_gallery",
					"term_id"=>$id,
				);
				$arr["description"] =json_encode($list);
				$this->dezDB->add_rec("dz_term_taxonomy",$arr);
			}
		}
	}
	public function delete_gallery($id=null,$type=""){
		if($id && $type!=""){
			$this->dezDB->del_rec($this->table,"taxonomy='{$type}_gallery' and term_id=$id");
		}
	}
}
?>