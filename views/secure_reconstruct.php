<!DOCTYPE html>
<html>
<head>
<?php include_once("../includes/head_tags.php");
	  require_once("../includes/notifications.inc");
	  require_once("../includes/repoapi.inc"); 
	  require_once("../includes/DB_Abstraction.inc"); ?>
<title>Secure Your Images - ToyApp</title>
</head>
<body class="auth-user">
	<?php include_once("../includes/header.inc"); ?>
	<div id="dash-board">
		<?php
			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				$uinfo = get_user_info();
				$db = new DBConnection;
				$db->connect();
				$fid = substr($_POST['fid'], 4);
				$db->insert('temp','fid,uid,share',"$fid,'$uinfo[uid]','$_POST[shares]'");
				$db->disconnect();
				//put ajax fecth code n finally display url
?>
<script>
function ajaxify(timer) {
		$.ajax({
			dataType : 'json',
			url: '/toyapp/includes/decrypt.inc.php?fid=<?php echo $fid?>',
			type: 'get',
			success: function(data) {	
				//alert(data['status']+' '+ data['data']);
				//ndata = JSON.parse(data);	
				

				if(data['status'] == 'success') {
					$("#ajax-data-display").html(data['data']);
					clearInterval(timer);
				}
				else {
					$("#ajax-data-display").html(data['data']);
				}
		}
		});	
}
var timer = setInterval(function() {ajaxify(timer);}, 1000);

</script>
<div id="ajax-data-display">

</div>
<?php			}
			else {
				if(!isset($_GET['i'])) {
					echo 'Error: Something went wrong (No file chosen)';
				}
				else {
		?>
		<div class="input-form">
			<form method="post" action="secure_reconstruct.php">
				<div class="input-row">Enter shares seperated by space</div>
				<div class="input-row"><textarea name="shares" style="width:30em;height: 10em" placeholder="Enter shares seperated by space"></textarea></div>
				<div class="input-row"><label for="file-name">File name</label><input type="text" name="fid" placeholder="Enter filename" value="<?php if(isset($_GET['i']))echo 'File'.$_GET['i']; ?>"/></div>
				<div class="input-row"><input type="submit" value="Secure Decrypt"/></div>
			</form>
		</div>
		<?php 
		}} ?>
	</div>
	<div id="footer">
		
	</div>
</body>
