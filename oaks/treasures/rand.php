<?php
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

	echo $treasures ;
?>