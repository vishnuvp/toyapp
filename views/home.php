<!DOCTYPE html>
<html>
<head>
<?php include_once("../includes/head_tags.php");
	  require_once("../includes/notifications.inc");?>
<title>Secure Your Images - ToyApp</title>
</head>
<body class="auth-user">
	<?php include_once("../includes/header.inc"); ?>
	<div id="dash-board">
		<ul class="dash-options">
			<a href="repo.php"><li>Your Repo</li></a>
			<a href="secure_share.php"><li>SecureShare Image</li></a>
			<a href="secure_reconstruct.php"><li>SecureReconstruct Image</li></a>
			<a href="../logout.php"><li>Logout</li></a>
		</ul>
		<div id="dash-notifications">
			<div class="noti-head">Notifications</div>
			<div class="noti-container">
				<?php $uinfo = get_user_info(); echo get_notifications($uinfo['uid']); ?>
			</div>
		</div>
	</div>
	<div id="footer">
		
	</div>
</body>