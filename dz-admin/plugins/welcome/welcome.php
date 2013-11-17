<?php
include_once(MODELPATH."category".____EXTPHP);
class AdminWelcome extends Module_Base{	
	public $db,$s,$dezDB;
	function __construct() {
		parent::__construct();
	}
	function run($atask="")
	{
		$sql = "select count(*) from dz_post  where post_type='post'";
		$data['countpost'] = $this->dezDB->getOne($sql);
		
		$sql = "select count(*) from dz_category where type='post'";
		$data['countcategory'] = $this->dezDB->getOne($sql);
		$sql = "select count(*) from dz_category where type='post_tag'";
		$data['counttags'] = $this->dezDB->getOne($sql);
		$sql = "select count(*) from dz_user";
		$data['countuser'] = $this->dezDB->getOne($sql);
		
		//$sql = "select * from dz_post where post_type='post' order by post_id desc limit 5";
		$data['post'] = $this->dezDB->getAllLimit("dz_post","post_type='post'","post_id","desc",5);
		
		$category  = new BaseCategory();
		$cate =  $category->getParent(0,0,"post");
		$data['category']= array();
		$i=0;
		if(is_array($cate))
			foreach($cate as $k=>$v){
				if($i<=4){
					$cond = "id=$k";
					$pref = $this->dezDB->getRowTable("dz_category",$cond);
					$pref['name'] = $v;
					$data['category'][$i++]=$pref;
				}
			}
		$this->s->assign("welcome",$data);
		$this->s -> display("welcome.tpl");
		
	}
}

?>