<?php 

	// set_time_limit(0);

	include 'connMagicBandit.php';

	$placeID = $_POST["placeID"];
	$playerID = $_POST["playerID"];
	$lat = $_POST["lat"];
	$lng = $_POST["lng"];

	$places = array();

	$sql  = 'SELECT * FROM place As p ';
	$sql .= ' WHERE p.id = ' . $placeID ;

	$rsPlaces = mysql_query($sql, $connMB);

	if($rsPlaces === FALSE) {
		die(mysql_error());
	}

	while($row = mysql_fetch_array($rsPlaces, MYSQL_ASSOC)) {
		$places[] = $row;
		$treasures = $row['treasures'];
		break;
	}

	for ($i=1; $i < 5; $i++) { 
		$treasures = str_replace(' ', '', $treasures);
	}
	$treasures = str_replace('|', '', $treasures);

	for ($i=0; $i < 6; $i++) {
		$quantity = substr($treasures, $i, 1);
		if($quantity>0) {
			$sql  = 'INSERT INTO player_inventory (player_id, treasure_id, transaction_id, place_id, quantity, lat, lng) ';
			$sql .= 'VALUES (' . $playerID . ', ';
			$sql .= ($i+1) . ', 1, ';
			$sql .= $placeID . ', ';
			$sql .= $quantity . ', ';
			$sql .= $lat . ', ' ;
			$sql .= $lng . ') ';
			$rsAddTreasure = mysql_query($sql, $connMB);
			if($rsAddTreasure === FALSE) {
				die(mysql_error());
			}
		} 
	}

	echo json_encode($places);

?>