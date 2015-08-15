<!DOCTYPE html>
<html>
<head>
<?php include_once("../includes/head_tags.php");?>
<title>Secure Your Images - ToyApp</title>
</head>

<body class="auth-user">
	<?php include_once("../includes/header.inc");
		require_once("../includes/shareholdersapi.inc");
		$shareholders = get_shareholders($_GET['f']);
		$current = get_user_info();
		$html = "";
		/*echo in_array($current['uid'], $shareholders)?"True":"False";
		print_r($current);
		print_r($shareholders);*/
		$flag = false;
		foreach ($shareholders as $shareholder) {
			if($shareholder['uid']==$current['uid']) {
				$flag = true;
			}
			$html .= "<div class='shareholder-row'>$shareholder[uid]</div>";
			
		}
		if(!$flag) {
			echo "You are not authorized to view this page";
				die();
		}
	 ?>
	<div id="dash-board">
	<div class="file-display-id">
		File <?php
		//if($_SERVER['REQUEST_METHOD'] == 'POST')
		//	$_GET['f'] = $_POST['fid'];
		if(isset($_GET['f'])) {
			echo $_GET['f'];
			$file = get_file_info($_GET['f']);
		}
		else {
			echo "You are not authorized to view this page";
			die();
		}
		?>

	</div>
	<div class="file-info">Number of shareholders: <?php echo $file['N'];?></div>
	<div class="file-info">Threshold: <?php echo $file['K'];?></div>
	<div class="file-info">Owner: <?php echo $file['owner'];?></div>
	<div class="shareholders">
		<div class="shareholders-header">Shareholders for this file</div>
		<?php echo $html; ?>
	</div>
	<?php
	if($current['uid'] == $file['owner']) {
		?>
		<form method="post" id="upload-form" action="file_upload.php" enctype="multipart/form-data">
			<div class="input-row"><label>Upload file</label><input type="file" name="file" placeholder="Upload image file"/></div>
			<input type="hidden" name="data" value="<?php echo $file['N'].';'.$file['K'].';'. $file['fid']?>"/>
			<div class="input-row"><input type="submit" value="Upload &amp; Generate Secret" /></div>
		</form>
	<?php 
	}
	?>

	</div>
	<div id="footer">
	</div>

</body>
</html>