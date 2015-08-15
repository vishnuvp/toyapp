<?php
require_once("repoapi.inc");
header('Content-Type: application/json');
$file_info = get_file_info($_GET['fid']);
$colluded_list = is_threshold_met($_GET['fid']);
//	print_r($colluded_list);print_r($file_info);
if($file_info['status'] != 4 ) {
	$colluded_list = is_threshold_met($_GET['fid']);
//	print_r($colluded_list);
	$ret = '';
	if($colluded_list['more'] <= 0 ) {
		$shares = get_shares_as_string($_GET['fid']);
		$info['shares'] = $shares;
		$info['file-name'] = get_file_name($_GET['fid']);
		$info['fid'] = $_GET['fid'];
//		print_r($info);
		$result = reconstruct($info);
		set_decryption_status($_GET['fid'],$result);
//		print_r($result);
		$data = "<a href='/toyapp/repo/$result'>Download file</a><br />";
		$ret = array(
	    'status'  => 'success',
	    'data' => $data
	);

	}
	else {
		
		$data = ''; 
		foreach ($colluded_list['list'] as $key => $value) {
			$data .= $value['uid'] . ', ' ;
		
		}

		//$data = trim($data);
		$data .= ' shared secrets. Needs '.$colluded_list['more'].' more shares.';
		$ret = array(
	    'status'  => 'fail',
	    'data' => $data
	);
	}
}
else {
	$file = get_file_path($_GET['fid']);
	if(!empty($file)) {
		$data = "<a href='/toyapp/repo/$file'>Download file</a><br />";	
	}
	else {
		$data = "Decryption failed";
	}
	
		$ret = array(
	    'status'  => 'success',
	    'data' => $data
	);
}
echo json_encode($ret);
?>