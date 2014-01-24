<?php 

	$myGuid = $_POST["myGuid"];

	$result = array();

	if(!empty($myGuid)) {
		include 'connMagicBandit.php';

		$sql  = 'DELETE FROM devices ';
		$sql .= ' WHERE device_number = "' . $myGuid . '"';
		$rsDevices = mysql_query($sql, $connMB);

		if($rsDevices === FALSE) {
			die(mysql_error());
		} else {
			$result = array("status"=>"success");
		}
	} else {
		$result = array("status"=>"failure");
	}

	echo json_encode($result);

?>