<?php
class dataGrid{
	var $aField = array();
	var $sTable = "";
	var $where = "";
	var $aFilter = array();
	var $aTask = array();
	var $sMethod = "GET";
	var $sSubmitUrl = "";
	var $aTaskAll = array();
	var $bDebug = false;
	var $hideIndex = false;
	var $sRootPath = "";
	var $iActionWidth = 70;
	var $sMessage = "";
	var $sPrimarykey = "id";
	
	function dataGrid($db, $smarty){
		$this->db=$db;
		$this->smarty=$smarty;	
	}
	
	function setTable($table){
		$this->sTable=$table;
	}
	
	function where($sql){
		$this->where=$sql;
	}
	
	function setPrimaryKey($sPkey="id"){
		$this->sPrimarykey = $sPkey;
	}
	
	function setField($aField=array()){
		$this->aField=$aField;
	}
	
	function setFilter($aFilter=array()){
		$this->aFilter=$aFilter;
	}
	
	function setMethod($sSubmitUrl="",$sMethod="GET"){
		$this->sSubmitUrl=$sSubmitUrl;
		$this->sMethod=$sMethod;
	}
	
	function setTask($aTask=array()){
		$this->aTask=$aTask;
	}
	
	function setTaskAll($aTaskAll=array()){
		$this->aTaskAll=$aTaskAll;
	}
	
	function setRootPath($sRootPath){
		$this->sRootPath=$sRootPath;
	}
	
	function setMessage($sMsg=""){
		$this->sMessage=$sMsg;
	}
	
	function debug(){
		$this->bDebug=true;
	}
	
	function setOption($iActionWidth=80,$hideIndex=false){
		$this->iActionWidth=$iActionWidth;
		$this->hideIndex=$hideIndex;
	}
	
	function addField($field){
		$this->aField[] = $field;
	}
	
	function addFilter($filter){
		$this->aFilter[] = $filter;
	}
	
	function addTask($task){
		$this->aTask[] = $task;
	}
	
	function addTaskAll($taskAll){
		$this->aTaskAll[]=$taskAll;
	}
	
	function displayGrid(){
		setcookie("re_dir", $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
		
		/* field select */
		foreach($this->aField as $field)
		{	// primary key		
			if(isset($field['primary_key']) && $field['primary_key']){
				$this->sPrimarykey = $field['field'];
			}
			
			// order default when grid is loaded
			if(isset($field['order_default']) && $field['order_default'] != ''){
				$order_default = $field['field'];
				$sort = $field['order_default'];
			}
			
			// get fields to select sql
			if(!isset($field['primary_key']) || !$field['primary_key']){
				if(!isset($field["sql"]) || $field["sql"]==""){
					$sSelectSql.= ", ".'`'.$field["field"].'`';
				}else{
					$sSelectSql.= ", (".$field["sql"].") as ".'`'.$field["field"].'`';
				}

				if($field['datatype'] == 'img' && isset($field['tooltip']) && $field['tooltip'] != ''){
					$sSelectSql .= ", " .$field['tooltip'];
				}
			}			
		}
		
		/* filter condition */
		if(is_array($this->aFilter))
		{
			foreach($this->aFilter as $k=>$filter){
				// check type of filter: date:text:select or number
				switch ($filter['type']){	
					case 'date':
						if($filter["selected"] != ""){
							$filter['operator'] = ($filter['operator'])?$filter['operator']:"=";
							if(isset($filter['filter_condition']) && $filter['filter_condition'] != ''){
								$tmp[]= " ".$filter['filter_condition'];
							}else{
								$tmp[]= " DATE_FORMAT(".$filter["field"].",'%Y-%m-%d') ".$filter['operator']."'".date("Y-m-d",strtotime($filter["selected"]))."' ";
							}
						}
						break;
					case 'text':
						if($filter["selected"] != ""){
							$tmp[] = "lower(".$filter["field"].") like lower('%".trim($filter["selected"])."%')";							
						}
						break;
					case 'group':
						if($_REQUEST["{$filter['name']}_group"]!=''){
							$this->aFilter[$k]['fgroup_by'] = $_REQUEST["{$filter['name']}_group"];
						}
						if($_REQUEST[$filter['name']]!='' && $_REQUEST["{$filter['name']}_group"]!=''){
							$sFieldFilter = $_REQUEST["{$filter['name']}_group"];
							$valueFilter = $_REQUEST[$filter['name']];							
							switch ($filter['field'][$sFieldFilter][1]){
								case 'text':
									$tmp[] = " lower({$sFieldFilter}) like lower('%{$valueFilter}%')";
									break;
								default:
									$tmp[] = " {$sFieldFilter}='{$valueFilter}'";
									break;
							}
						}
						break;

					default:
						if($filter["selected"] != ""){
							if(isset($filter['filter_condition']) && $filter['filter_condition'] != ''){
								$tmp[]= " ".$filter['filter_condition'];
							}else{
								$tmp[]= " ".$filter["field"]."='".$filter["selected"]."' ";
							}
						}
						break;
				}
			}
			if($tmp != ''){
				$where.= implode(" and ", $tmp);			
			}
		}
		
		/* sort data */
		if(isset($_REQUEST["sort_by"]))	$sort_by = $_REQUEST["sort_by"];
		elseif($order_default) $sort_by = $order_default;
		else $sort_by = $this->sPrimarykey;
	
		if(isset($_REQUEST["sort_value"]))	$sort_value = $_REQUEST["sort_value"];
		elseif($order_default) $sort_value = "asc";
		else $sort_value = "desc";
		
		if($where!="")
			$where= " where  ". $where;
		else
			$where= " where  1";
		
		if($this->where!="")
			$where.= " and  ". $this->where;
		$order= " order by $sort_by $sort_value ";
		
		/* paging data */
		$per_page= (isset($_REQUEST["per_page"]) && is_numeric($_REQUEST["per_page"]) && $_REQUEST["per_page"]>0)?(int)$_REQUEST["per_page"]:20;
		$page= (isset($_REQUEST["page"]) && is_numeric($_REQUEST["page"]) && $_REQUEST["page"]>0)?(int)$_REQUEST["page"]:1;
		
		$totalRecord= $this->db->getOne("select count(*) from {$this->sTable} {$where}");
		if($this->bDebug){
			echo "Number record:";
			print_r($totalRecord);
		}
		
		if($totalRecord < $per_page*($page-1)) $page= ceil($totalRecord/$per_page);		
		$sql = "SELECT {$this->sPrimarykey} {$sSelectSql} FROM {$this->sTable}";
		$data = $this->db->limitQuery($sql.$where.$order,$per_page*($page-1),$per_page);
		
		if($this->bDebug){
			echo 'Data is:';
			print_r($data);
		}
		
		while ($row = $data -> fetchRow()){
			$arr_value[] = $row;
		}
		
		$number_col = count($this->aField) + 3;
		// path to directory contain datagrid.tpl
		$rootPath = SITE_URL."lib/datagrid/templates";				
		
		$this->smarty->assign("pkey", $this->sPrimarykey);
		$this->smarty->assign("sort_by", $sort_by);
		$this->smarty->assign("sort_value", $sort_value);		
		$this->smarty->assign("per_page", $per_page);
		$this->smarty->assign("page", $page);
		$this->smarty->assign("number_record", $totalRecord);
		$this->smarty->assign("index_start", $per_page*($page-1)+1);
		$this->smarty->assign("number_page", ceil($totalRecord/$per_page));
		$this->smarty->assign("number_cols", $number_col);
		$this->smarty->assign("arr_value", $arr_value);
		$this->smarty -> assign("object", $this);
		
		$path = str_replace('datagrid.php','',__FILE__);
		$this->smarty -> assign("path",$rootPath);
			
		$this->smarty->display("file:".$path."templates/datagrid.html");
		/* end function */
	}
	
	function displayGridTable($dataTable=array()){
		setcookie("re_dir", $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
		/* field select */
		foreach($this->aField as $field)
		{	// primary key		
			if(isset($field['primary_key']) && $field['primary_key']){
				$this->sPrimarykey = $field['field'];
			}					
		}
		
		/* sort data */
		if(isset($_REQUEST["sort_by"]))	$sort_by = $_REQUEST["sort_by"];
		elseif($order_default) $sort_by = $order_default;
		else $sort_by = $this->sPrimarykey;
	
		if(isset($_REQUEST["sort_value"]))	$sort_value = $_REQUEST["sort_value"];
		elseif($order_default) $sort_value = "asc";
		else $sort_value = "desc";
		
		/* paging data */
		$per_page= (isset($_REQUEST["per_page"]) && is_numeric($_REQUEST["per_page"]) && $_REQUEST["per_page"]>0)?(int)$_REQUEST["per_page"]:20;
		$page= (isset($_REQUEST["page"]) && is_numeric($_REQUEST["page"]) && $_REQUEST["page"]>0)?(int)$_REQUEST["page"]:1;
		
		$indexStart = $per_page*($page-1);
		$totalRecord = 0;
		if(is_array($dataTable) && count($dataTable)>0){
			$totalRecord = count($dataTable);
			if($totalRecord>$indexStart+$per_page) $indexEnd = $indexStart+$per_page;
			else $indexEnd = $totalRecord;
			for($i=$indexStart;$i<$indexEnd;$i++){
				$arr_value[] = $dataTable[$i];
			}
		}
		$number_col = count($this->aField) + 3;
		
		// path to directory contain datagrid.tpl
		$rootPath = SITE_URL."lib/datagrid/templates";		
		
		$this->smarty->assign("pkey", $this->sPrimarykey);
		$this->smarty->assign("sort_by", $sort_by);
		$this->smarty->assign("sort_value", $sort_value);		
		$this->smarty->assign("per_page", $per_page);
		$this->smarty->assign("page", $page);
		$this->smarty->assign("number_record", $totalRecord);
		$this->smarty->assign("index_start", $indexStart+1);
		$this->smarty->assign("number_page", ceil($totalRecord/$per_page));		
		$this->smarty->assign("arr_align", $arr_align);
		$this->smarty->assign("number_cols", $number_col);
		$this->smarty->assign("arr_value", $arr_value);
		$this->smarty -> assign("object", $this);
		
		
		$path = str_replace('datagrid.php','',__FILE__);
		$this->smarty -> assign("path",$rootPath);
		$this->smarty->display("file:".$path."templates/datagrid.html");
		/* end function */
	}
}


?>