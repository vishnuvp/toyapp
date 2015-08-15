<!DOCTYPE html>
<html>
<head>
<?php include_once("../includes/head_tags.php");?>
<title>Secure Your Images - ToyApp</title>
</head>

<body class="auth-user">
	<?php include_once("../includes/header.inc"); ?>
	<div id="dash-board">
	<div class="file-display-id">
		File <?php
		if($_SERVER['REQUEST_METHOD'] == 'POST')
			$_GET['f'] = $_POST['fid'];
		echo $_GET['f'];?>
	</div>
		<?php
#TODO: AUTHENTICATE SHAREHOLDER		
		require_once("../includes/shareholdersapi.inc");
		$current = get_user_info()['uid'];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			confirm_share($current, $_POST['fid']);
		}
		$shareholders = get_shareholders($_GET['f']);
		$status = array(0 => ' not confirmed yet', 1 => ' confirmed');
		?>
		
		<?php
		$my_status = '';
		 foreach ($shareholders as $row) {
			if($row['uid'] != $current) {
			?>
			<div class="shareholder-row"><?php echo $row['name'].'['.$row['uid'].'] has '. $status[$row['status']]; ?></div>
			<?php
			}
			else if($row['uid'] == $current) {
				$my_status = ($row['status']==0)?"You have not confirmed yet.<form method='post' action='status.php'><input type='submit' value='Confirm now' /><input type='hidden' name='fid' value='$_GET[f]'></form>":"You have confirmed";
			}
		}
		?>
		<div class="shareholder-accept-row"><?php echo $my_status; ?></div>
	</div>
	<div id="footer">
		
	</div>

</body>
</html>