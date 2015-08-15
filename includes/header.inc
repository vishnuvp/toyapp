<?php
	require_once("/var/www/html/toyapp/includes/session.inc");
	require_once("/var/www/html/toyapp/includes/authenticate.inc");
	if(!is_session_active()) {
		header("Location:/toyapp");
	}
	$user = get_user_info();

?>
<div class="header-wrapper">
<div id="header">
		<a href="/toyapp/views/home.php" style="text-decoration:none;color:white">SecureShare</a>
</div>
<div id="welcome-msg">Hi, <?php echo $user['name'].'['.$user['uid'].']' ?></div>
</div>