<!DOCTYPE html>
<html>
<head>
<?php include_once("../includes/head_tags.php");?>
<title>Secure Your Images - ToyApp</title>
</head>
<body class="auth-user">
	<?php include_once("../includes/header.inc"); ?>
	<div id="dash-board">
		<?php
		require_once("../includes/shareholdersapi.inc");
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			//var_dump($_POST['email']);
			add_shareholders($_POST['email'], $_SESSION['user'], $_POST['N'],$_POST['K']);

		?>
		<div class="notification alert">All shareholders have been notified. You will be notified once all shareholders confirm</div>
		<?php
		}
		else {
		?>
			<div class="input-form">
			<form method="post" action="secure_share.php">
				<div class="input-row"><label>Number of share holders(n)</label><input name="N" type="number" min="0" id="threshold-input" /></div>
				<div class="input-row"><label>Threshold (k)</label><input type="number" name="K" min="0"/></div>
				<div class="input-row">Enter share holders' email ids</div>
				<div id="hctrl-block">
				</div>
				<div class="input-row"><input type="submit" value="submit" /></div>
			</form>
			</div>
		<?php
		}
		?>
	</div>
	<div id="footer">
		
	</div>

</body>
</html>