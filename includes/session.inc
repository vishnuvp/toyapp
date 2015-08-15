<?php
require_once("DB_Abstraction.inc");
function start_new_session($user, $name, $time) {

	if(isset($_SESSION['user'])) {
		session_destroy();
	}
	session_start();
	$_SESSION['user'] = $user;
	$_SESSION['time'] = $time;
	$_SESSION['name'] = $name;
	

}
function revive_session() {

	@session_start();
	if(isset($_SESSION['user'])) {
		$now = mktime();
		if(($now - 5000) < $_SESSION['time']) {
			$_SESSION['time'] = $now;
			//add code to revive login info in db
		}
		$db_con = new DBConnection;
		$db_con->connect();
		if($db_con->query('online','user','user="'.$_SESSION['user'].'"',null,null,null)) {
			$db_con->update('online','last_active_time=now()','user="'.$_SESSION['user'].'"');
		}
		else {
			$db_con->insert('online','user',"'".$_SESSION['user']."'");	
		}
		$db_con->disconnect();

	}

}
function get_user_info() {
	revive_session();
	if(isset($_SESSION['user']))
		return array('uid' =>$_SESSION['user'], 'name' =>$_SESSION['name']);
	return false;
}
function is_session_active() {
	revive_session();
	if(isset($_SESSION['user']))
		return true;
	return false;
}

function destroy_session() {
	revive_session();
	session_destroy();
}
?>