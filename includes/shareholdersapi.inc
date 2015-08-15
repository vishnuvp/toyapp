<?php
require_once("DB_Abstraction.inc");

function add_shareholders($array, $owner, $n, $k) {

	$db_con = new DBConnection;
	$db_con->connect();
	$db_con->insert('file','status,owner,N,K',"0,'$owner',$n,$k");	
	$fid = $db_con->get_last_id();

	foreach ($array as $email) {
		$pass = md5(substr($email,4).trim("apple"));
		$db_con->insert('user','uid,password',"'$email','$pass'");
		if($email == $owner)
			$db_con->insert('file_group','fid,uid,status',"$fid,'$email',1");
		else 
			$db_con->insert('file_group','fid,uid,status',"$fid,'$email',0");
	}	

	$db_con->disconnect();

}

function get_shareholders($fid) {
	$db_con = new DBConnection;
	$db_con->connect();
	$res = $db_con->join_query("file_group f","user u","f.uid,u.name,f.status","f.uid=u.uid","f.fid = $fid",null,null,null);
	$db_con->disconnect();
	return $res;
}

function confirm_share($user,$fid) {
	$db_con = new DBConnection;
	$db_con->connect();
	$db_con->update("file_group",'status=1',"uid='$user' AND fid=$fid");
	$db_con->disconnect();
	check_status($fid);
}

function check_status($fid) {
	$db_con = new DBConnection;
	$db_con->connect();
	if(!$db_con->query("file_group",'status',"fid=$fid AND status=0",null,null,null)) {
		$db_con->update("file",'status=1',"fid=$fid");
	}
	$db_con->disconnect();
	
}

function get_file_info($fid) {
	$db_con = new DBConnection;
	$db_con->connect();

	$result = $db_con->query("file",'fid,owner, N, K',"fid=$fid",null,null,null);
	$db_con->disconnect();
	return $result[0];
}

function generate_secrets($fid) {

}
?>