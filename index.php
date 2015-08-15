<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<script src="scripts/jquery-1.11.1.min.js"></script>
<script src="scripts/script.js"></script>
<script src="scripts/jquery-2d-transform.js"></script>
<link rel="stylesheet" href="styles/style.css"/>
<title>Secure Your Images - ToyApp</title>
</head>
<body class="anonymous">
<div id="welcome-banner">
		    
</div>
<div id="main">
<div class="login-form">
	<?php
	require_once("includes/session.inc");
	require_once("includes/authenticate.inc");
	if(is_session_active()) 
		header("Location:views/home.php");
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$result = authenticate_user($_POST['username'], $_POST['password']);
		if($result) {
			start_new_session($_POST['username'],$result['name'], mktime());
			header("Location:views/home.php");

		}
		else {

			$error_code = array('msg' => 'Invalid Login Credentials. Please try again.', 'type' => 'error');
		}
	}
	?>
	<div class="login-form-head-label"><h2>LOGIN</h2></div>
	<?php 
	if(isset($error_code)) {
	?>
	<div class="status <?php echo $error_code['type'];?>"><?php echo $error_code['msg']; ?></div>
	<?php
	}

	?>
	<form name="loginForm" id="loginForm" method="post" action="index.php">
		 	<table style="width:100%">
		 		<tr><td><label for="username">Username </label></td>
		 			<td><input name="username" type="text" placeholder="Username"></td>
		 		</tr>
		 		<tr>
		 			<td><label for="password">Password</label></td>
		 			<td><input name="password" type="password" placeholder="Password"></td>
		 		</tr>
		 		<tr><td colspan="2" style="text-align:center"><input value="Login" type="submit"></td>
		 		</tr>
		 	</table>
	</form>
</div>
</div>	
</body>
</html>
