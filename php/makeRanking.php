<?php 
	include 'connMagicBandit.php';

	$players = array();

	$sql  = 'SELECT p.id, p.character_name As name, SUM(pi.quantity*t.value) As points '; 
	$sql .= ' FROM player As p, player_inventory As pi, treasure As t ';
	$sql .= ' WHERE pi.player_id = p.id ';
	$sql .= ' AND pi.treasure_id = t.id ';
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