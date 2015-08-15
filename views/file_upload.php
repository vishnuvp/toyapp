<!DOCTYPE html>
<html>
<head>
<?php include_once("../includes/head_tags.php");?>
<title>Secure Your Images - ToyApp</title>
</head>

<body class="auth-user">
	<?php include_once("../includes/header.inc"); ?>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	//var_dump($_FILES);
	if($_FILES['file']['type'] != 'image/jpeg') {
		echo "Invalid file format. Please upload a jpeg file.";
		die();
		//exit;
	}
	
	
	$fn = explode('/',$_FILES['file']['tmp_name'])[2];
	$file_name = '/var/www/html/toyapp/repo/'.$fn;
	move_uploaded_file($_FILES['file']['tmp_name'],$file_name);
	//$inputFileName = $_FILES['file']['name'];
	echo '<div style="color:#005387">Uploading..</div>';
	$sent = explode(';', $_POST['data']);
	$N = $sent[0];
	$K = $sent[1];
	$command = '/usr/bin/python /var/www/html/toyapp/toyapp-python/toyapp.py encrypt '.$file_name.' '.$N.' '.$K;
echo $command;
	//echo '<br />'.$command;
	//echo '<br />';
	#$result = #exec($command);#
	$result = json_decode(exec($command, $status), true);
	$size = sizeof($result);
	//print_r($result);
	$i = 0;
	require_once('../includes/shareholdersapi.inc');
	$shareholders = get_shareholders($sent[2]);
	//print_r($shareholders);
	require_once('../includes/DB_Abstraction.inc');

	$db_con = new DBConnection;
	$db_con->connect();

	foreach($result as $pair) {
		$uid = $shareholders[$i]['uid'];
		$db_con->insert('secrets','fid,uid,secret',"$sent[2],'$uid','[$pair[0],$pair[1]]'");
		$i++;
		echo "<br />Secret $i: <input type='text' readonly='readonly' value='[$pair[0],$pair[1]]'/>";
	}

	//print_r($result);//. ' <br />';
	
	$db_con->update('file',"url='\/toyapp\/repo\/$fn.enc',status=2","fid=$sent[2]");
	$db_con->disconnect();
	//unlink($file_name);
}
?>
</body>
</html>