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

/**
 * class Dez_Db
 * @version 1.0
 * 
 * @author dinhhungvn
 * dinhhungvn@gmail.com
 * 
 * @date 01 Oct 2008
 * @desc Features:
 * - provide method oriented tables
 * 		+ insert
 * 		+ update with PK
 * 		+ update with FK
 * 		+ delete with PK
 * 		+ delete with FK
 * 		+ empty table
 * - provide element for Quick Form
 * - provide element for Datagrid
 * 
 * @desc Purpose
 * - Cung cap cac ham xu ly chung doi voi tat ca cac Module
 * - Tao chuan xu ly chung cho cac Module
 *
 */
class Dez_Db
{
	private $table;
	private $showColumns;
	private $primaryKey;
	private $hasPrimaryKey = false;
	private $foreignKey = array();
	private $hasForeignKey = false;
	private $indexKey = array();
	private $uniqueKey = array();
	private $fields = array();
	private $startVal = '(';
	private $endVal = ')';
	private $adoDb;
	private $_debug = false;
	public function __construct(&$adoDb)

	{

		$this->adoDb = $adoDb;		

		

	}

	/**

	 * setTable

	 *

	 * @param string $table

	 */

	public function setTable($table)

	{

		$this->table = $table;

		$this->hasPrimaryKey = false;

		$this->hasForeignKey = false;

		

		$this->analyzeTable();

	}

	

	/**

	 * setTable

	 *

	 * @param string $table

	 */

	public function setPrimaryKey($pk)

	{

		$this->primaryKey = $pk;

	

	}

	

	/**

	 * getTable	

	 */

	public function getTable(){
		return $this -> table;
	}

	

	/**

		* getFields

	*/

	public function getFields ()

	{

		return $this->fields;

	}

	

	/**

	 * analyzeTable

	 * 

	 * @desc

	 * Field Attributes:

	 * Field 	Type 	Collation 	Null 	Key 	Default 	Extra 	Privileges 	Comment 

	 * 

	 * Input Tag Attributes for HTML Form:

	 * InputType

	 * Title

	 * Value

	 * maxlength

	 * ...Open atributes

	 *

	 */

	public function analyzeTable()

	{

		$this->showColumns = $this->adoDb->Execute("SHOW FULL COLUMNS FROM {$this->table}");
		$db = new PEAR;
		if($db->isError($this->showColumns))

		{

			die($this->showColumns->getMessage());

		}

		else 

		{

			

			while($row = $this->showColumns->fetchRow())

			{

				$this->fields[$row['Field']] = $row;

				

				$arrayInputType = $this->setInputType($row['Type']);

				$this->fields[$row['Field']] = array_merge($this->fields[$row['Field']], $arrayInputType);

				$this->fields[$row['Field']]['Attributes']['id'] = $row['Field'];

				$this->fields[$row['Field']]['Attributes']['title'] = $row['Comment'];

				

				switch ($row['Key'])

				{

					case 'MUL': 

						$this->indexKey[] = $row['Field'];

						break;

					case 'UNI';

						$this->uniqueKey[] = $row['Field'];

						break;

					case 'PRI';

						if ($row['Extra'] == 'auto_increment')

						{

							$this->primaryKey = $row['Field'];

							$this->hasPrimaryKey = true;

						}

						else 

						{

							$this->foreignKey[] = $row['Field'];

							$this->hasForeignKey = true;

						}

						break;

				}

				

			}

			

			//$this->test($this->fields);

			

		}

	}

	/**

	 * isPrimaryKey

	 *

	 * @param string $field

	 * @return boolean

	 * @desc check input field is primary key

	 */

	public function isPrimaryKey($field)

	{

		return ($this->hasPrimaryKey && $this->primaryKey == $field) ? true : false;

	}

	/**

	 * isForeignKey

	 *

	 * @param string $field

	 * @return boolean

	 * @desc check input field is foreign key

	 */

	public function isForeignKey($field)

	{

		return ($this->hasForeignKey && $this->inArray($field,$this->foreignKey)) ? true : false;

	}

	/**

	 * isUniqueKey

	 *

	 * @param string $field

	 * @return boolean

	 * @desc check input field is unique key

	 */

	public function isUniqueKey($field)

	{

		return $this->inArray($field, $this->uniqueKey);

	}

	/**

	 * isIndexKey

	 *

	 * @param string $field

	 * @return boolean

	 * @desc check input field is index key

	 */

	public function isIndexKey($field)

	{

		return $this->inArray($field, $this->indexKey);

	}

	/**

	 * isField

	 *

	 * @param string $field

	 * @return boolean

	 * @desc check input field is field of table

	 */

	public function isField($field)

	{

		return array_key_exists($field, $this->fields) ? true : false;

	}

	

	public function getRow($id)

	{

		
		$sSql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
		if(isCache())
			$row = $this->adoDb->CacheGetRow($sSql);
		else
			$row = $this->adoDb->GetRow($sSql);
			
		
		if (empty($row)|| !$row)
			return false;
		else 
			return $row;
	}

	/**

	 * insert

	 *

	 * @param array $aData - Array Insert Data

	 * @return mixed - false if error && $insertId if sucess

	 */
	public function insert($aData){
	
	
		 $rs = $this->adoDb->Execute('SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = \'-1\'');
		 if (!$insertSQL = $this->adoDb->GetInsertSQL($rs, (array) $aData, true)) {
				return false;
		 }

		 if (!$this->adoDb->Execute($insertSQL)) {
				return false;
		}

		$id = $this->adoDb->Insert_ID();
		return (integer) $id;
	}
	

	

	/**

	 * updateWithPk

	 *

	 * @param Integer $id - Primary Key

	 * @param array $aData - Array Update Data

	 * @return boolean

	 * 

	 * @desc Update with Primary Key

	 */

	public function updateWithPk($id, $aData)

	{

		$sSql = "UPDATE {$this->table} SET ";

		

		$sUpdate = "";

		$doUpdate = false;



		foreach ($aData as $field => $value)

		{

			if($this->isField($field) && !$this->isPrimaryKey($field))

			{

				$sUpdate .= "`{$field}`='{$this->prepareInput($value)}',";

				$doUpdate = true;

			}

		}

		

		if($doUpdate)

		{

			//remove last comma

			$sUpdate = substr($sUpdate,0,strlen($sUpdate)-1);

			

			$sSql .= $sUpdate;

			$sSql .= " WHERE {$this->primaryKey} in ({$id})";	

			//echo $sSql;die;

			$result = $this->adoDb->Execute($sSql);

			
			$db = new PEAR;
			if ($db->isError($result))

			{

				return false;

			}

			else 

			{

				return true;

			}

		}

		return false;

	}

	

	/**

	 * updateWithFk

	 *

	 * @param Array $aFk - Array Foreign Key

	 * @param Array $aData - Array Update Data

	 * @return boolean

	 * 

	 * @desc Update with Foreign Keys

	 */

	public function updateWithFk($aFk, $aData)

	{

		$sSql = "UPDATE {$this->table} SET ";

		

		$sUpdate = "";

		$sWhere = " WHERE ";

		$doUpdate = false;

		$foundOneFkey = false;

		foreach ($aData as $field => $value)

		{

			if($this->isField($field) && !$this->isPrimaryKey($field) && !$this->isForeignKey($field))

			{

				$sUpdate .= "`{$field}`='{$this->prepareInput($value)}',";

				$doUpdate = true;

			}

		}

		

		foreach ($aFk as $field => $value)

		{

			if($this->isForeignKey($field))

			{

				$sWhere .= "`{$field}`='{$this->prepareInput($value)}',";

				$foundOneFkey = true;

			}

		}

		

		if($doUpdate && $foundOneFkey)

		{

			//remove last comma

			$sUpdate = substr($sUpdate,0,strlen($sUpdate)-1);

			$sWhere = substr($sWhere,0,strlen($sWhere)-1);

			

			$sSql .= $sUpdate . $sWhere;

			

			$result = $this->adoDb->Execute($sSql);

			$db = new PEAR;

			if ($db->isError($result))

			{

				

				return false;

			}

			else 

			{

				return true;

			}

		}

		return false;

	}

	

	/**

	 * deleteWithPk

	 *

	 * @param integer $id

	 * @return boolean

	 */

	public function deleteWithPk ($str_id)

	{

		$result = $this->adoDb->Execute("DELETE FROM {$this->table} WHERE {$this->primaryKey} in ({$str_id})");

	
		$db = new PEAR;
		return ($db->isError($result)) ? false : true;

	}

	

	/**

	 * deleteWithFk

	 *

	 * @param array $aFk

	 * @return boolean

	 * 

	 * @desc

	 * Delete with Foreign Keys

	 * Delete if found at least one FK

	 */

	public function deleteWithFk ($aFk)

	{

		$sSql = "DELETE FROM {$this->table} WHERE 1 ";

		

		$sWhere = "";

		$foundOneFkey = false;

		

		foreach ($aFk as $field => $value)

		{

			if($this->isForeignKey($field))

			{

				$sWhere .= "AND {$field}='{$this->prepareInput($value)}' ";

				$foundOneFkey = true;

			}

		}

		

		if($foundOneFkey)

		{

			$sSql .= $sWhere;

			$result = $this->adoDb->Execute($sSql);

			
			$db = new PEAR;
			return ($db->isError($result)) ? false : true;

		}

		return false;

	}

	/**

	 * setInputType

	 *

	 * @param string $datatype - Data Type of Field on DB

	 * @return array Atribute - Array Attribute of HTML Input Tag

	 */

	private function setInputType($datatype)

	{

		$posStartVal = strpos($datatype, $this->startVal);

		$posEndVal = strpos($datatype, $this->endVal);

		if($posStartVal === false)

		{

			$type = $datatype;

			$val = false;

		}

		else 

		{

			$lengthVal = $posEndVal - $posStartVal - strlen($posStartVal);

			

			$type = substr($datatype, 0, $posStartVal);

			$val = substr($datatype, $posStartVal + 1, $lengthVal);

		}

		

		$type = strtolower($type);

		$array = array();

		$arrayAttr = array();

	

		

		switch ($type)

		{

			case 'varchar':

			case 'char':

				$array['InputType'] = 'text';

				

				if($val !== false)

				{

					//$arrayAttr['class'] = 'txtbox';

					$arrayAttr['maxlength'] = intval($val);

				}

				break;

			case 'text':

			case 'tinytext':

			case 'midiumtext':

			case 'longtext':

			case 'blob':

			case 'tinyblob':

			case 'midiumblob':

			case 'longblob':

				$array['InputType'] = 'textarea';

				break;

			case 'int':

			case 'smallint':

			case 'mediumint':

			case 'bigint':

				$array['InputType'] = 'text';

				if($val !== false)

				{

					$arrayAttr['maxlength'] = intval($val);

				}

				break;

			case 'tinyint':

				$array['InputType'] = 'checkbox';

				$array['TrueValue'] = 1; //or Yes

				break;

			case 'float':

			case 'double':

			case 'decimal':

				$array['InputType'] = 'text';

				if($val !== false)

				{

					$arrayAttr['maxlength'] = intval($val);

				}

				break;

			case 'time':

			case 'date':

			case 'datetime':

				//$array['InputType'] = 'date';

				//date is pear type

				//datetime is bsg type :)

				$array['InputType'] = 'datetime';

				break;

			case 'enum':

				$array['InputType'] = 'select';

				$val = str_replace("'",'',$val);

				$val = str_replace('"','',$val);

				$array['Options'] = explode(',',$val);

				break;

			default:

				$array['InputType'] = 'hidden';

				break;

		}

		

		if(isset($arrayAttr['maxlength']))

		{

			$arrayAttr['size'] = (round(sqrt($arrayAttr['maxlength']) * 2.5));

		}

		

		$array['Attributes'] = $arrayAttr;

		

		return $array;

	}

	

	/**

	 * prepareInput

	 *

	 * @param string $value

	 * @return string $value

	 * 

	 * @desc process data before input to db (remove tags, remove javascript, add slashes,...)

	 */

	private function prepareInput ($value)

	{

		return addslashes($value);

	}

	

	private function inArray($needle, $array)

	{

		return in_array($needle, $array) ? true : false;

	}
	public function Execute($sql=""){
		if($sql){
			$result = $this->adoDb->Execute($sql);
			return $result;
		}else
			return false;
		
		
		
	}
	public function querySql($sql)

	{
		if(isCache()){
			$result = $this->adoDb->CacheExecute($sql);
			if(!$recordSet->EOF)	
				return $result->_array;
			else
				return false;
		}
		else{
			$recordSet = $this->adoDb->Execute($sql);
			
			if($recordSet && !$recordSet->EOF)	
				return $recordSet->GetRows();
			else
				return false;
		}
		

	}
	public function SelectLimit($sql,$limit=1){
		$res = $this->adoDb->SelectLimit($sql,$limit);
		if(!$res->EOF && $res)
			return $res->GetArray(-1);
		else return false;
	
	}
	public function getAllSql($sql=null){
		if($sql){
			if(isCache()){
				$res = $this->adoDb->CacheGetAll($sql);
			}else{
				$res = $this->adoDb->GetAll($sql);
			}
		}
		if(!$res->EOF)
			return $res;
		else
			return false;
	}
	
	public function getOne($sql)

	{
		if(isCache())
			$result =  $this->adoDb->CacheGetOne($sql);
		else
			$result =  $this->adoDb->GetOne($sql);
		
		return $result;
	}
	public function getRowTable($table,$where="",$params=null)

	{	$sql_where = "";
		if($where)
			$sql_where = " where {$where} ";
		$sql = "select * from $table {$sql_where} {$params}";
		if(isCache()){
			$return =  $this->adoDb->CacheGetRow($sql);
		}
		else{
			$return =  $this->adoDb->GetRow($sql);
		}
		return $return;

	}

	/**

	 * Get All Record of Table with limit 

	 *

	 * @param string $table

	 * @param string $cond

	 * @param string $orderby

	 * @param string $sort

	 * @param integer $limit

	 * @return array

	 */

	

	 public function getAllLimit($table, $cond = '', $orderby = NULL, $sort = 'desc', $limit = NULL)

    {

        if($cond != '')

            $where = " where $cond ";

		if ($orderby === NULL or empty($orderby)) {

			$orderby = $this->primaryKey;

		}



        $sql = "select * from $table " . $where . ' order by ' . $orderby . ' ' . $sort;        

		if ($limit !== NULL) {

			$sql .= " LIMIT ". $limit;

		}

		//echo $sql;
		if(isCache())
			$res = $this -> adoDb -> CacheGetAll($sql);
		else
			$res = $this -> adoDb -> GetAll($sql);

		if ($this->_debug) {

			$this -> debug(array('Function Name'=>__FUNCTION__, 'Last_Query'=>$this->adoDb->last_query));

		}
		$db = new PEAR;
		if($db-> isError($res)){

            return false;

        }else{

        	return $res;

        }

    }

	public function getAssocSql($sql){
		if(isCache())
			$res = $this -> adoDb -> CacheGetAssoc($sql, false);
		else
			$res = $this -> adoDb -> GetAssoc($sql, false);
			
		return $res;
			
	}
	public function getAssoc($fieds = '', $where = null, $params = NULL) {

		$sql = "SELECT ";

		if (is_array($fieds)) {

			$sql .= implode(", ", $fieds);

		} else if ($fieds != '') {

			$sql .= " $fieds ";

		} else if ($fieds == '' or empty($fieds)) {

			$sql .= " * ";

		}

		  $sql .= " FROM ". $this->table;

		if (!empty($where)) {

			 $sql .= " WHERE ". $where;

		}

		if ($params !== NULL) {

			$sql .= " ". $params;

		}

		//echo $sql;

		if(isCache())
			$res = $this -> adoDb -> CacheGetAssoc($sql, false);
		else
			$res = $this -> adoDb -> GetAssoc($sql, false);

		if ($this->_debug) {

			$this -> debug(array('Function Name'=>__FUNCTION__, 'Last_Query'=>$this->adoDb->last_query));

		}
		$db = new PEAR;
		if($db-> isError($res)){

            return false;

        }else{

        	return $res;

        }

	}

	

	

	public function getAssocTable($table,$fieds = '', $where = null, $params = NULL) {

		$sql = "SELECT ";

		if (is_array($fieds)) {

			$sql .= implode(", ", $fieds);

		} else if ($fieds != '') {

			$sql .= " $fieds ";

		} else if ($fieds == '' or empty($fieds)) {

			$sql .= " * ";

		}

		  $sql .= " FROM ". $table;

		if (!empty($where)) {

			 $sql .= " WHERE ". $where;

		}

		if ($params !== NULL) {

			$sql .= " ". $params;

		}

		//echo $sql;ss
		if(isCache())
			$res = $this -> adoDb -> CacheGetAssoc($sql, false);
		else
			$res = $this -> adoDb -> GetAssoc($sql, false);

		if ($this->_debug) {

			$this -> debug(array('Function Name'=>__FUNCTION__, 'Last_Query'=>$this->adoDb->last_query));

		}
		$db = new PEAR;
		if($db-> isError($res)){

            return false;

        }else{

        	return $res;

        }

	}

	/**

	* get count record have in table

	* @author: dezhub.com

	* @return: integer

	*/

	public function getCount($where = NULL,$table = NULL) {

		if($table == NULL)

			$table = $this->table;

			

		$sql = "SELECT count(*) FROM ". $table;

		if (!empty ($where)) {

			$sql .= " WHERE " . $where;

		}

		//echo $sql;
		if(isCache())
			$res = $this->CacheGetOne($sql);
		else
			$res = $this->GetOne($sql);

		if ($this->_debug) {

			$this -> debug(array('Function Name'=>__FUNCTION__, 'Last_Query'=>$this->adoDb->last_query));

		}
		$db = new PEAR;
		if($db-> isError($res) OR empty($res)){

            return false;

		}

		return $res;

	}

	//---------------------------------------------------------------------------------------------------------------/

/**

 * add , edit , delete with table

 *

 */	

	public function add_rec($table, $arr_data= array())

    {

        $res = $this -> adoDb -> autoExecute($table, $arr_data, DB_AUTOQUERY_INSERT);
		$db = new PEAR;
		if($db-> isError($res)){

            if (isset($_SESSION['debug'])) {

				$this -> debug($res);

            }

            return false;

        }else{

        	$insertId = $this->adoDb->getOne( "SELECT last_insert_id()" );

        	return $insertId;

        }

    }



    public function edit_rec($table, $arr_data= array(), $cond)

    {

    	if($cond){				

			$res = $this -> adoDb -> autoExecute($table, $arr_data, DB_AUTOQUERY_UPDATE, $cond);
		$db = new PEAR;
		if($db-> isError($res)){

            if (isset($_SESSION['debug'])) {

				$this -> debug($res);

            }

            return false;

	        }else{

	        	return true;

	        }

    	} else{

	    	return false;

    	}

    }
	public function getCol($sql=""){
		if($sql){
			if(isCache()){
				$res = $this->adoDb->CacheGetCol($sql);
			}else{
				$res = $this->adoDb->GetCol($sql);
			}
			if(!$res->EOF)
				return $res;
			else return false;
		}else
			return false;
	}
    

    public function del_rec($table, $cond='')

    {

        if ($cond) {

        	$where = " where $cond ";

        }

        $sql = "delete from " . $table . $where;

        $res = $this -> adoDb -> Execute($sql);

		//echo $sql;
		$db = new PEAR;
        if($db-> isError($res)){

            if (isset($_SESSION['debug'])) {

				$this -> debug($res);

            }

            return false;

        }else{

        	return $res;

        }

    }

    

    public function get_edit($table, $cond)

    {

        $where = " where $cond";



        $sql = "select * from " . $table . $where;

//		echo $sql;
		if(isCache())
			$res = $this -> adoDb -> CacheGetRow($sql);
		else
			$res = $this -> adoDb -> GetRow($sql);
		$db = new PEAR;
		if($db-> isError($res)){

            if (isset($_SESSION['debug'])) {

				$this -> debug($res);

            }

            return false;

        }else{

        	return $res;

        }

    }

	

	private function debug($var)

    {

        print("<pre align='left'>");

       		print_r($var);

        print("</pre>");

    }



}



?>