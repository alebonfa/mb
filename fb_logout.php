<?php
	$appID = $_GET['appID'];
	session_start();
    unset($_SESSION['fb_' . $appID . '_code']);  
    unset($_SESSION['fb_' . $appID . '_access_token']);  
    unset($_SESSION['fb_' . $appID . '_user_id']);  
	// session_destroy();
	header('Location: http://localhost:81/mb/fb_test3.php');
?>