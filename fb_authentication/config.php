<?php
	session_start();

	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '394262151484952',
		'app_secret' => 'd4a93d631a0a959f58ed1b7512c9132e',
		'default_graph_version' => 'v2.10'
	]);

	$helper = $FB->getRedirectLoginHelper();
	// $_SESSION['FBRLH_state']=$_GET['state'];

?>