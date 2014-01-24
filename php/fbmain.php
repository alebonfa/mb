<?php

	$fbconfig['appid']  = "390907424378928";
	$fbconfig['secret'] = "cb62dc04dd6104b49ef5049bed89183f";

	try {
		include_once 'libs/facebook/src/facebook.php';
	}
	catch(Exception $o){
		echo '<pre>';
		print_r($o);
		echo '</pre>';
	}

	$facebook = new Facebook(array(
		'appId' => $fbconfig['appid'],
		'secret' => $fbconfig['secret'],
		'cookie' => false
	));

	$fbme = null;

	if($facebook) {
		try {
			$uid = $facebook->getUser();
			$fbme = $facebook->api('/me');
		} catch(FacebookApiException $e) {
			d($e);
		}
	}

	function d($d) {
		echo '<pre>';
		echo 'Erros e mais erros!!!';
		print_r($d);
		echo '</pre>';
	}

?>