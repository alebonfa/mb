<?php 

	// set_time_limit(0);

	include 'connMagicBandit.php';

	$La = $_POST["la"];
	$Lo = $_POST["lo"];
	$LaNW = $La -0.1;
	$LoNW = $Lo -0.1;
	$LaSE = $La +0.1;
	$LoSE = $Lo +0.1;

	$places = array();

	$sql  = 'SELECT * FROM place As p ';
	$sql .= ' WHERE p.lat >= ' . $LaNW . ' and p.lng >= ' . $LoNW;
	$sql .= ' AND p.lat <= ' . $LaSE . ' and p.lng <= ' . $LoSE;
	$sql .= ' ORDER BY p.name' ;

	$rsPlaces = mysql_query($sql, $connMB);

	if($rsPlaces === FALSE) {
		die(mysql_error());
	}

	while($row = mysql_fetch_array($rsPlaces, MYSQL_ASSOC)) {
		$places[] = $row;
	}

	echo json_encode($places);

?>
