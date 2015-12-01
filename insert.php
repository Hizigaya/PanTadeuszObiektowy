<?php

	include_once('parameters.php');
	include_once('Service.php');

	use PanTadeusz as PT;

	$service = new Service($hostname, $database, $username, $password1, $password2, $_GET['type']);	
	$service->addToDatabase($_POST['title'], $_POST['content']);

	header("Location: ".$_SERVER['HTTP_REFERER']);

