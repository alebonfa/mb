<?php

	$playerName = $_POST["playerName"];
	$playerPwd1 = $_POST["playerPwd1"];
	$playerPwd2 = $_POST["playerPwd2"];
	$mbDeviceID = $_POST["mbDeviceID"];
	$lat = $_POST["lat"];
	$lng = $_POST["lng"];
	$city = $_POST["city"];
	$country = $_POST["country"];

	if($playerPwd1 == $playerPwd2) {
		include 'connMagicBandit.php';
		$search = mysql_query("SELECT * FROM player AS p WHERE p.character_name LIKE '$playerName'", $connMB);
		if(@mysql_num_rows($search)==0) {
			$sql = "INSERT INTO player (character_name, pwd, city, country, creation_lat, creation_lng) ";
			$sql .= " VALUES('" . $playerName . "', " ;
			$sql .= " '" . md5($playerPwd1) . "', ";
			$sql .= " '" . $city . "', '" . $country . "', " . $lat . ", " . $lng . ") " ;
			$rs = mysql_query($sql, $connMB);
			if($rs === FALSE) {
				$result = array("status"=>"failure", "message"=>"Não foi possível se conectar ao Banco de Dados!");
				die(mysql_error());
			} else {
				$newPlayerID = mysql_insert_id();
				if(!empty($mbDeviceID)) {
					$search = mysql_query("SELECT * FROM devices AS d WHERE d.device_number = '$mbDeviceID'", $connMB);
					if(@mysql_num_rows($search)>0) {
						$delDevice = mysql_query("DELETE FROM devices WHERE device_number = '" . $mbDeviceID . "'", $connMB); 
					}
					$sql = "INSERT INTO devices (player_id, device_number) ";
					$sql .= "VALUES (" . $newPlayerID . ", '" . $mbDeviceID . "') ";
					$rsDevice = mysql_query($sql, $connMB); 
					if($rsDevice === true) {
						$result = array("status"=>"success", "message"=>"Jogador e Dispositivo Registrados! Pode começar a Coleta!", "playerName"=>$playerName, "playerID"=>$newPlayerID);
					} else {
						$result = array("status"=>"success", "message"=>"Somente Jogador Registrado! Pode começar a Coleta!", "playerName"=>$playerName, "playerID"=>$newPlayerID);
					}
				} else {
					$result = array("status"=>"success", "message"=>"Jogador Cadastrado! Pode começar a Coleta!", "playerName"=>$playerName, "playerID"=>$newPlayerID);
				}
			}
		} else {
			$result = array("status"=>"failure", "message"=>"Nome do Jogador já Existente!");
		}
	} else {
		$result = array("status"=>"failure", "message"=>"Digite Duas Vezes a Mesma Senha!");
	}

	echo json_encode($result);

?>