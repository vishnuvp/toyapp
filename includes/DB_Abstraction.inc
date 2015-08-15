<?php
class DBConnection {
	protected $hname = "localhost";
	protected $username = "m140163cs";
	protected $password = "m140163cs";
	protected $database = "db_toyapp";
	protected $dbhandle;

	/*function __construct($host="localhost", $user="root", $pwd="apple", $db="olm") {
		echo '<br />db connect2:';
		$this->$username = $user;
		$this->password = $pwd;
		$this->$database = $db;
		$this->hname = $host;
	}*/

	function connect() {
		$this->dbhandle = mysql_connect($this->hname, $this->username, $this->password);
		if($this->dbhandle) {
			mysql_select_db($this->database,$this->dbhandle);
		}
	}

	function disconnect() {

		mysql_close($this->dbhandle);
	}

	function insert($table, $cols, $values) {
		$query = "INSERT INTO $table($cols) VALUES($values)";
		//echo $query;
		return mysql_query($query, $this->dbhandle); 
	}

	function get_last_id() {
		return mysql_insert_id($this->dbhandle);
	}

	function update($tablename, $data, $where) {
		$query = "UPDATE $tablename SET $data WHERE $where";
		//echo $query;

		return mysql_query($query);
	}
	function join_query($table1,$table2,$cols,$on,$where,$having,$group_by,$limit) {
		
		$string = 'SELECT ';
		if(isset($cols))
			$string .= $cols;

		if(isset($table1)&&isset($table2))
			$string .= ' FROM ' . $table1 . ' JOIN ' . $table2;
		if(isset($on))
		 	$string .= ' ON '.$on;
		if(isset($where)) 
			$string .= ' WHERE '.$where;

		if(isset($having))
			$string .= ' HAVING '.$having;

		if(isset($group_by))
			$string .= ' GROUP BY '.$group_by;
		if(isset($limit)) 
			$string .= ' limit '. $limit;

		//echo $string."<br />";

		$result = mysql_query($string, $this->dbhandle);
		if(!$result)
			return false;
		$ret_array = array();
		$i = 0;
		while($row = mysql_fetch_assoc($result)) {
			$ret_array[$i++] = $row;
		}
		return $ret_array;	

	}
	function query($tablename, $cols, $where, $having, $group_by, $limit){
		$string = 'SELECT ';
		if(isset($cols))
			$string .= $cols;

		if(isset($tablename))
			$string .= ' FROM ' . $tablename;

		if(isset($where)) 
			$string .= ' WHERE '.$where;

		if(isset($having))
			$string .= ' HAVING '.$having;

		if(isset($group_by))
			$string .= ' GROUP BY '.$group_by;
		if(isset($limit)) 
			$string .= ' limit '. $limit;

		/*else {

			db_log('DB Query: Invalid query: table undefined', 'current_user()', mktime(time()), "error");
			return false;
		}*/
		$result = mysql_query($string, $this->dbhandle);
		if(!$result)
			return false;
		$ret_array = array();
		$i = 0;
		while($row = mysql_fetch_assoc($result)) {
			$ret_array[$i++] = $row;
		}
		return $ret_array;	
	}

	function delete($table, $where) {
		 mysql_query("DELETE FROM $table WHERE $where", $this->dbhandle);
	}
}