<?php 

	set_time_limit(480);

	require_once("../src/FoursquareAPI.class.php");
	$client_key = "QFIHNHOUKTNJTPN5OML0TN0HU5LDG4PZKTQGQYGCVHONH2O5";
	$client_secret = "B4HYVK40ERADAGCTECDHJ2LHE5KNS5ZE3UD32WCB4Z0I5YZF";

	$foursquare = new FoursquareAPI($client_key,$client_secret);

	$cityState = "Sauípe";

	include 'connMagicBandit.php';

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

		<div class="city">
			<h2><?php echo $cityState; ?></h2>

			<?php 
				$lat = -12.442841;
				$lng = -37.9225974;
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

						$treasures = rand(2,5) ;

						if(rand(0,100)>75) {
							$treasures = $treasures . ' | 1 ' ;
						} else {
							$treasures = $treasures . ' | 0 ' ;
						}

						for ($i=0; $i < 4; $i++) { 
							if(rand(0,100)>92) {
								$treasures = $treasures . ' | 1 ' ;
							} else {
								$treasures = $treasures . ' | 0 ' ;
							}
						}

						$category = $venue->categories['0']->name;
						$sql = 'INSERT INTO place (name, lat, lng, foursquare_id, foursquare_category, foursquare_city, treasures)';
						$sql = $sql . 'VALUES ("'. ucwords(strtolower(mysql_real_escape_string($venue->name))) . '",' ;
						$sql = $sql . $venue->location->lat.',' ;
						$sql = $sql . $venue->location->lng.',' ;
						$sql = $sql . '"'. $venue->id .'",' ;
						$sql = $sql . '"'. ucwords(strtolower(mysql_real_escape_string($category))) .'",' ;
						$sql = $sql . '"'. ucwords(strtolower(mysql_real_escape_string($cityState))) .'",' ;
						$sql = $sql . '"'. $treasures .'")' ;
						$rs = mysql_query($sql, $connMB) ;
						if($rs === FALSE) {
							die(mysql_error());
						}
					} else {
						while($res=mysql_fetch_array($search, MYSQL_ASSOC)) {
							$treasures = $res["treasures"];
						}
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

	</body>

</html>
