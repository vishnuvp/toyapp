<?php
require_once("DB_Abstraction.inc");

function authenticate_user($user, $pass) {
	$db_connection = new DBConnection();
	$db_connection->connect();
	$query = 'uid = "'.$user.'" AND password = "'.md5(substr($user,4).trim($pass)).'"';
	$result = $db_connection->query('user','uid,name',$query,null,null,1);
	$db_connection->disconnect();
	if($result&&$result[0]['uid']==$user)
		return $result[0];
	return false;
}

?>