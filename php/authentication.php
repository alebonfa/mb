<?php
	$result = array();

	$playerName = $_POST["playerName"];
	$playerPwd  = $_POST["playerPwd"];
	$mbDeviceID = $_POST["mbDeviceID"];


	$playerPwd  = md5($playerPwd);

	if(!empty($playerName) && !empty($playerPwd)) {
		include 'connMagicBandit.php';
		$sql = "SELECT * FROM player " ;
		$sql .= "WHERE character_name = '$playerName' ";
		$sql .= "and pwd = '$playerPwd' ";
		$search = mysql_query($sql, $connMB);
		if(@mysql_num_rows($search)==1) {
			while($row = mysql_fetch_array($search, MYSQL_ASSOC)) {
				$playerID = $row["id"];
				break;
			}
			if(!empty($mbDeviceID)) {
				$searchDevice = mysql_query("SELECT * FROM devices AS d WHERE d.device_number = '$mbDeviceID'", $connMB);
				if(@mysql_num_rows($search)>0) {
					$delDevice = mysql_query("DELETE FROM devices WHERE device_number = '" . $mbDeviceID . "'", $connMB); 
				}
				$sql = "INSERT INTO devices (player_id, device_number) ";
				$sql .= "VALUES (" . $playerID . ", '" . $mbDeviceID . "') ";
				$rsDevice = mysql_query($sql, $connMB); 
			}
			$result = array("status"=>"success", "playerName"=>$playerName, "playerID"=>$playerID);
		} else {
			$result = array("status"=>"failure", "message"=>"Jogador ou Senha Inválido");
		}
	} else {
		$result = array("status"=>"failure", "message"=>"Jogador ou Senha Inválido");
	}

	echo json_encode($result);

?>