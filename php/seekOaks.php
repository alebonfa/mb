<?php 
	require_once("../src/FoursquareAPI.class.php");
	$client_key = "QFIHNHOUKTNJTPN5OML0TN0HU5LDG4PZKTQGQYGCVHONH2O5";
	$client_secret = "B4HYVK40ERADAGCTECDHJ2LHE5KNS5ZE3UD32WCB4Z0I5YZF";

	include 'connMagicBandit.php';

	$foursquare = new FoursquareAPI($client_key,$client_secret);
	$location = array_key_exists("location",$_GET) ? $_GET['location'] : "CAMPINAS,SP";

	$rsTreasures = mysql_query("SELECT * FROM place As p WHERE p.foursquare_city like '$location%' ORDER BY p.foursquare_category, p.name", $connMB);

	if($rsTreasures === FALSE) {
		die(mysql_error());
	}

?>

<!doctype html>
<html>

	<head>
		<meta charset="utf-8">
		<title>MagicBandit - Treasures</title>
		<link rel="stylesheet" type="text/css" href="app.css">
	</head>

	<body>
		<h1>Magic Bandit - Treasure Places</h1>

		<p>
			Rastreie Treasures em...
			<form action="" method="GET">
				<input type="text" name="location" />
				<input type="submit" value="Buscar" />
			</form>
		</p>
		<p>Rastreando treasures em <?php echo $location; ?></p>

		<div class="city">
			<h2><?php echo $location; ?></h2>
		</div>

		<?php
			while($row = mysql_fetch_array($rsTreasures, MYSQL_ASSOC)) {
		?>

			<?php
				$response = $foursquare->GetVenue("venues/".$row["foursquare_id"]);
				$venues = json_decode($response);

				foreach($venues->response as $venue):

					echo '<div class="venue">';
					echo '<image class="icon" src="'.$venue->categories['0']->icon->prefix.'88.png"/>';
					echo '<a href="https://foursquare.com/v/'.$venue->id.'" target="_blank"/><b>';
					echo $venue->name;
					echo "</b></a><br/>";
		            if(isset($venue->categories['0'])) {
						echo $venue->categories['0']->name.'<br/>';
					}
					echo '<span style="color:#333;">' . $row["foursquare_city"] . '</span><br/>';
					echo '<span style="color:#444;">Bolotas : ' . substr($row["treasures"],0,5) . ' / </span>';
					echo '<span style="color:#444;">Artefatos : ' . substr($row["treasures"],8) . '</span><br/>';
			        echo '</div>';

				endforeach;

			?>

		<?php } ?>

	</body>

</html>
