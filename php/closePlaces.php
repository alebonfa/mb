<?php 

	// set_time_limit(0);

	include 'connMagicBandit.php';

	$playerID = $_POST["playerID"];
	$La = $_POST["la"];
	$Lo = $_POST["lo"];
	$LaNW = $La -0.1;
	$LoNW = $Lo -0.1;
	$LaSE = $La +0.1;
	$LoSE = $Lo +0.1;

	$places = array();

	$sql  = 'SELECT p.*, max(pi.date) As lastColect FROM place As p ';
	$sql .= ' LEFT OUTER JOIN player_inventory As pi ';
	$sql .= ' ON p.id = pi.place_id ';
	$sql .= ' and pi.player_id = ' . $playerID;
	$sql .= ' WHERE p.lat >= ' . $LaNW . ' AND p.lng >= ' . $LoNW;
	$sql .= ' AND p.lat <= ' . $LaSE . ' AND p.lng <= ' . $LoSE;
	$sql .= ' GROUP BY p.id' ;

	$rsPlaces = mysql_query($sql, $connMB);

	if($rsPlaces === FALSE) {
		die(mysql_error());
	}

	while($row = mysql_fetch_array($rsPlaces, MYSQL_ASSOC)) {
		$places[] = $row;
	}

	echo json_encode($places);

?>