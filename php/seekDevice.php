<?php 

	$myGuid = $_POST["myGuid"];

	$playerName = "";
	$playerID   = 0;

	$result = array();

	if(!empty($myGuid)) {
		include 'connMagicBandit.php';

		$sql  = 'SELECT * FROM devices As d ';
		$sql .= ' WHERE d.device_number = "' . $myGuid . '"';
		$rsDevices = mysql_query($sql, $connMB);
		if($rsDevices === FALSE) {
			die(mysql_error());
		}
		if(@mysql_num_rows($rsDevices)>0) {
			while($row = mysql_fetch_array($rsDevices, MYSQL_ASSOC)) {
				$playerID = $row["player_id"];
				break;
			}
		}

		$sql  = 'SELECT * FROM player As p ';
		$sql .= ' WHERE p.id = ' . $playerID ;
		$rsPlayer = mysql_query($sql, $connMB);
		if($rsPlayer === FALSE) {
			die(mysql_error());
		}
		if(@mysql_num_rows($rsPlayer)>0) {
			while($row = mysql_fetch_array($rsPlayer, MYSQL_ASSOC)) {
				$playerName = $row["character_name"];
				break;
			}
		}

		if(!empty($playerName) && $playerID>0) {
			$result = array("status"=>"success", "playerName"=>$playerName, "playerID"=>$playerID);
		} else {
			$result = array("status"=>"failure");
		}
	}

	echo json_encode($result);

?>