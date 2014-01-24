<?php 
	set_time_limit(480);
	require_once("../src/FoursquareAPI.class.php");
	// Set your client key and secret
	$client_key = "QFIHNHOUKTNJTPN5OML0TN0HU5LDG4PZKTQGQYGCVHONH2O5";
	$client_secret = "B4HYVK40ERADAGCTECDHJ2LHE5KNS5ZE3UD32WCB4Z0I5YZF";
	// Load the Foursquare API library

	if($client_key=="" or $client_secret=="")
	{
        echo 'Load client key and client secret from <a href="https://developer.foursquare.com/">foursquare</a>';
        exit;
	}

	include 'conn.php';
	include 'connMagicBandit.php';
	$rsCidades = mysql_query("SELECT c.localidade_nome AS nome, c.bigcity, e.estado_sigla AS uf FROM localidades AS c, estados AS e WHERE c.estado_id = e.estado_id ORDER BY e.estado_sigla, c.localidade_nome", $conn);

	if($rsCidades === FALSE) {
		die(mysql_error());
	}

	$foursquare = new FoursquareAPI($client_key,$client_secret);

?>

<!doctype html>
<html>

	<head>
		<meta charset="utf-8">
		<title>PHP-Foursquare :: Unauthenticated Request Example</title>
		<style>
			div.venue
			{   
				float: left;
				padding: 10px;
				background: #efefef;
				height: 90px;
				margin: 10px;
				width: 340px;
		    }
		    div.venue a
		    {
		    	color:#000;
		    	text-decoration: none;

		    }
		    div.venue .icon
		    {
		    	background: #000;
				width: 88px;
				height: 88px;
				float: left;
				margin: 0px 10px 0px 0px;
		    }
		    div.city
		    {
		    	background: #ababff;
		    	color: #1313ff;
		    	clear: both;
		    	margin-top: 20px;
		    }
		</style>
	</head>

	<body>
		<h1>Magic Bandit - Treasure Places</h1>

		<?php
			while($row = mysql_fetch_array($rsCidades, MYSQL_ASSOC)) {
				$cityState = $row["nome"] . ',' . $row["uf"];
		?>

			<div class="city">
				<h2><?php echo $cityState; ?> - Primeira Busca</h2>

				<?php 
					list($lat,$lng) = $foursquare->GeoLocate($cityState);
					$params = array("ll"=>"$lat,$lng");
					echo '<p>' . $lat . '/' . $lng . '</p>';
					$response = $foursquare->GetPublic("venues/search",$params);
					$venues = json_decode($response);
				?>
			
			</div>

			<?php foreach($venues->response->venues as $venue): ?>
					
			<?php 

				if(isset($venue->categories['0']) && property_exists($venue->categories['0'],"name") ) {

					if ($venue->categories['0']->name != 'Conjunto Habitacional' && $venue->categories['0']->name != 'Edifício Residencial' && $venue->categories['0']->name != 'Lar de Idosos' && $venue->categories['0']->name != 'Residência (particular)') {

						$add = 'New';
						$search = mysql_query("SELECT * FROM place WHERE foursquare_id = '$venue->id'", $connMB);
						if(@mysql_num_rows($search)==0) {
							$category = $venue->categories['0']->name;
							$sql = 'INSERT INTO place (name, lat, lng, foursquare_id, foursquare_category, foursquare_city)';
							$sql = $sql . 'VALUES ("'.$venue->name.'",' ;
							$sql = $sql . $venue->location->lat.',' ;
							$sql = $sql . $venue->location->lng.',' ;
							$sql = $sql . '"'.$venue->id.'",' ;
							$sql = $sql . '"'.$category.'",' ;
							$sql = $sql . '"'.$cityState.'")' ;
							$rs = mysql_query($sql, $connMB);
							if($rs === FALSE) {
								die(mysql_error());
							}
						} else {
							$add = 'Repeat';
						}

						echo '<div class="venue">';
						echo '<image class="icon" src="'.$venue->categories['0']->icon->prefix.'88.png"/>';
						echo '<a href="https://foursquare.com/v/'.$venue->id.'" target="_blank"/><b>';
						echo $venue->name;
						echo "</b></a><br/>";
							
			            if(isset($venue->categories['0']))
			            {
							echo ' <i> '.$venue->categories['0']->name.'</i><br/>';
						}
						
						echo '<i style="color:#f00;">' . $add . '</i><br/>';
			            echo '</div>';

			        }

		        }
				
			?>
					
			<?php endforeach; ?>

			<?php

				if($row["bigcity"]==1) {

					echo '<div class="city">';
						echo '<h2>Complemento</h2>';
						$lat = $lat + 0.05;
						$params = array("ll"=>"$lat,$lng");
						echo '<p>' . $lat . '/' . $lng . '</p>';
						$response = $foursquare->GetPublic("venues/search",$params);
						$venues = json_decode($response);
					echo '</div>';
					
					foreach($venues->response->venues as $venue):
							
						if(isset($venue->categories['0']) && property_exists($venue->categories['0'],"name") ) {

							if ($venue->categories['0']->name != 'Conjunto Habitacional' && $venue->categories['0']->name != 'Edifício Residencial' && $venue->categories['0']->name != 'Lar de Idosos' && $venue->categories['0']->name != 'Residência (particular)') {

								$add = 'New';
								$search = mysql_query("SELECT * FROM place WHERE foursquare_id = '$venue->id'", $connMB);
								if(@mysql_num_rows($search)==0) {
									$category = $venue->categories['0']->name;
									$sql = 'INSERT INTO place (name, lat, lng, foursquare_id, foursquare_category, foursquare_city)';
									$sql = $sql . 'VALUES ("'.$venue->name.'",' ;
									$sql = $sql . $venue->location->lat.',' ;
									$sql = $sql . $venue->location->lng.',' ;
									$sql = $sql . '"'.$venue->id.'",' ;
									$sql = $sql . '"'.$category.'",' ;
									$sql = $sql . '"'.$cityState.'")' ;
									$rs = mysql_query($sql, $connMB);
									if($rs === FALSE) {
										die(mysql_error());
									}
								} else {
									$add = 'Repeat';
								}

								echo '<div class="venue">';
								echo '<image class="icon" src="'.$venue->categories['0']->icon->prefix.'88.png"/>';
								echo '<a href="https://foursquare.com/v/'.$venue->id.'" target="_blank"/><b>';
								echo $venue->name;
								echo "</b></a><br/>";
									
					            if(isset($venue->categories['0']))
					            {
									echo ' <i> '.$venue->categories['0']->name.'</i><br/>';
								}
								
								echo '<i style="color:#f00;">' . $add . '</i><br/>';
					            echo '</div>';

					        }

				        }
						
					endforeach;
				}

			?>

		<?php } ?>

	</body>

</html>
