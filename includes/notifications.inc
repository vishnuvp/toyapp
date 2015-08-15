<?php
require_once("DB_Abstraction.inc");
function get_notifications($user) {
	$db_con = new DBConnection;
	$db_con->connect();
	$result = $db_con->join_query("file_group","file","file_group.fid,file.owner,file.status","file_group.fid = file.fid", "file_group.uid='$user'",null,null,null);
	//var_dump($result);
	

	foreach ($result as $row) {
		if($row['owner'] == $user) {
			if($row['status']==0) {
				echo "<div class='notification-row'>Your request to share a document is pending confirmation from shareholders.<a href='/toyapp/views/status.php?f=$row[fid]' class='check-status'><button>Check status here</button></a></div>";
			}
			else if($row['status']==1) {
				echo "<div class='notification-row'>Your request to share a document has been confirmed by shareholders.<a href='/toyapp/views/generate_secret.php?f=$row[fid]' class='check-status'><button>Share Document</button></a></div>";	
			}
		}
		else {
			if($row['status']==0) {
				echo "<div class='notification-row'>$row[owner] has asked to share a document with you and is pending confirmation by shareholders.<a href='/toyapp/views/status.php?f=$row[fid]' class='confirm-btn'><button>Status</button></a></div>";	
			}
			else if($row['status']==1) {
				echo "<div class='notification-row'>$row[owner]'s document is ready to share.<a href='/toyapp/views/status.php?f=$row[fid]' class='confirm-btn'><button>Status</button></a></div>";
			}
		}
		
	}

	$result = $db_con->query("secrets","fid,secret", "uid='$user'",null,null,null);
	foreach ($result as $row) {
		echo "<div class='notification-row'>Document $row[fid] has been shared with you. Your secret share is <input type='text' value='$row[secret]' readonly='readonly'/>. Save it securely.</div>";
	}
	$db_con->delete("secrets","uid='$user'");
	$db_con->disconnect();

}

?>