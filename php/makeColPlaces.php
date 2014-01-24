<?php 

	$model = $_POST["model"];
	$data = date('Y-m-d');

	include 'connMagicBandit.php';

	$players = array();

	$sql  = 'SELECT p.id, p.name, count(pi.id) AS qty_players ';
	$sql .= ' FROM place As p, player_inventory As pi ';
	$sql .= ' WHERE pi.place_id = p.id ';

	if($model == "dia") {
		$sql .= ' AND pi.date LIKE "%' . $data . '%"';
	} else if($model == "semana") {
		$data = date('Y-m-d', strtotime("$data -1 week"));
		$sql .= ' AND pi.date >= "' . $data . '"';
	}

	$sql .= ' GROUP BY p.id ';

	$rsPlayers = mysql_query($sql, $connMB);

	if($rsPlayers === FALSE) {
		die(mysql_error());
	}

	while($row = mysql_fetch_array($rsPlayers, MYSQL_ASSOC)) {
		$players[] = $row;
	}

	echo json_encode($players);
?>