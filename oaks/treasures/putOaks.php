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
			echo ucwords(strtolower(mysql_real_escape_string($venue->name)));
			echo "</b></a><br/>";
			echo ucwords(strtolower(mysql_real_escape_string($venue->categories['0']->name))) . '<br/>';
			echo 'Treasures:' . $treasures . '<br/>';
			echo '<i style="color:#f00;">' . $add . '</i><br/>';
	        echo '</div>';

	    }

	}
?>