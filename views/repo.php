<!DOCTYPE html>
<html>
<head>
<?php include_once("../includes/head_tags.php");
	  require_once("../includes/repoapi.inc");?>
<title>Secure Your Images - ToyApp</title>
</head>
<body class="auth-user">
	<?php include_once("../includes/header.inc"); ?>
	<div id="dash-board">
		<ul class="dash-options">
			<?php  
				$uinfo = get_user_info(); 
				$file_array = get_repo($uinfo['uid']);
				foreach ($file_array as $file) {
					$f = explode('/',$file['url'])[3];
					?>
					<li><a href="secure_reconstruct.php?f=<?php  echo $f; ?>&i=<?php echo $file['fid'] ?>">File <?php echo $file['fid']; ?></a></li>
					<?php
				}
			?>
		</ul>
	</div>
	<div id="footer">
		
	</div>
</body>