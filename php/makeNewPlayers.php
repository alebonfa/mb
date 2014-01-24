<?php 

	$model = $_POST["model"];
	$data = date('Y-m-d');

	include 'connMagicBandit.php';

	$players = array();

	$sql  = 'SELECT p.city, count(p.id) AS qty_players ';
	$sql .= ' FROM player As p ';

	if($model == "dia") {
		$sql .= ' WHERE p.creation_time LIKE "%' . $data . '%"';
	} else if($model == "semana") {
		$data = date('Y-m-d', strtotime("$data -1 week"));
		$sql .= ' WHERE p.creation_time >= "' . $data . '"';
	}

	$sql .= ' GROUP BY p.city ';

	$rsPlayers = mysql_query($sql, $connMB);

	if($rsPlayers === FALSE) {
		die(mysql_error());
	}

	while($row = mysql_fetch_array($rsPlayers, MYSQL_ASSOC)) {
		$players[] = $row;
	}

	echo json_encode($players);
?>