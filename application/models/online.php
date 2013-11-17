<?php 
class BaseOnline extends Module_Base
{
	public $dezDB;
	public function __construct() {
		
		parent::__construct();
		$this->table="dz_useronline";
		$this->dezDB->setPrimaryKey('id');
		$this->dezDB->setTable($this->table);
	}


	var $timeout = 600;
	var $count = 0;
	var $error;
	var $i = 0;
	
	public function index () {
		$this->timestamp = time();
		$this->ip = $this->ipCheck();
		$this->new_user();
		$this->delete_user();
	//	return 1;
		$this->count_users();
	}
	
	public function ipCheck() {
	/*
	This public function will try to find out if user is coming behind proxy server. Why is this important?
	If you have high traffic web site, it might happen that you receive lot of traffic
	from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
	This public function tryes to get real IP address.
	Note that getenv() public function doesn't work when PHP is running as ISAPI module
	*/
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	public function new_user() {
//		$insert = mysql_query ("INSERT INTO useronline(timestamp, ip) VALUES ('$this->timestamp', '$this->ip')");
		
		$data = array(
			"timestamp"	=>	$this->timestamp,
			"ip"	=>	$this->ip,
		);
		$insert = $this->dezDB->insert($data);
		if (!$insert) {
			$this->error[$this->i] = "Unable to record new visitor\r\n";			
			$this->i ++;
		}
	}
	
	public function delete_user() {
	//	$delete = mysql_query ("DELETE FROM useronline WHERE timestamp < ($this->timestamp - $this->timeout)");
		$sql = "DELETE FROM {$this->table} WHERE timestamsp < ($this->timestamp - $this->timeout)";
		$delete = $this->dezDB->querySql($sql);
		if ($delete) {
			$this->error[$this->i] = "Unable to delete visitors";
			$this->i ++;
		}
	}
	
	public function count_users() {
		if (count($this->error) == 0) {
			//$count = mysql_num_rows ( mysql_query("SELECT DISTINCT ip FROM useronline"));
			$sql = "select count(DISTINCT ip) FROM {$this->table}";
			$count = $this->dezDB->getOne($sql);
			return $count;
		}
	}


}
?>