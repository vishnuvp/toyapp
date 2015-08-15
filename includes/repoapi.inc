<?php
require_once('DB_Abstraction.inc');

function get_repo($user) {
	$db_con = new DBConnection;
	$db_con->connect();
	$array = $db_con->join_query('file','file_group','file.url, file.fid',"file.fid = file_group.fid","file_group.uid='$user'",null,null,null);
	//var_dump($array);
	$db_con->disconnect();
	return $array;
}
function delete_shares($fid) {
	$db_con = new DBConnection;
	$db_con->connect();
	$db_con->delete('temp',"fid=$fid");
	$db_con->disconnect();
}
function reconstruct($info) {
	//echo $info['shares'];
	print_r($info);
	$shares = explode(" ",$info['shares']);
	$file_name = '/var/www/html'.$info['file-name'];
	$command = '/usr/bin/python /var/www/html/toyapp/toyapp-python/toyapp.py decrypt '.$file_name.' '.json_encode($shares);//implode(',',$shares).']';
	//echo '<br />'. $command.'</br />';
	$result = exec($command, $status);
	delete_shares($info['fid']);
	return $result;
}

function is_threshold_met($fid) {
	$db_con = new DBConnection;
	$db_con->connect();
	$K = $db_con->query('file','file.K',"file.fid=$fid",null,null,1)[0]['K'];
	$array = $db_con->query('temp','temp.uid',"temp.fid = $fid",null,null,null);
	$size = sizeof($array);
	$narray['more'] = $K - $size;
	$narray['list'] = $array;
	//$file = fopen("test.txt", 'a');
	//fwrite($file, print_r($narray));
	//fclose($file);
	$db_con->disconnect();
	return $narray;
}

function get_file_info($fid) {
	$db_con = new DBConnection;
	$db_con->connect();
	$file = $db_con->query('file','url,status',"fid=$fid",null,null,1)[0];
	$db_con->disconnect();
	return $file;
}
function get_file_path($fid) {
	$db_con = new DBConnection;
	$db_con->connect();
	$file = $db_con->query('temppath','path',"fid=$fid",null,null,1)[0]['path'];
	$db_con->disconnect();
	return $file;
}

function set_decryption_status($fid,$result) {
	$db_con = new DBConnection;
	$db_con->connect();
	$db_con->insert('temppath','fid,path',"$fid,'$result'");
	$db_con->update('file','status=4',"fid=$fid");
	$db_con->disconnect();
}

function get_file_name($fid) {
	$file = get_file_info($fid)['url'];
	return $file;
}


function get_shares_as_string($fid) {
	$db_con = new DBConnection;
	$db_con->connect();
	$array = $db_con->query('temp','share',"fid = $fid",null,null,null);
	$string = '';
	foreach ($array as $value) {
		$string .= $value['share'].' ';
	}
	$string = trim($string);
	$db_con->disconnect();
	return $string;
}

?>