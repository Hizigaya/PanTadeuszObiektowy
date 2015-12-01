<?php

	include_once('parameters.php');
	include_once('DatabaseMS.php');
	include_once('Reflection.php');

	use PanTadeusz as PT;
	use MysqlDatabase as MD;

	$database = new MD\Database($hostname, $database, $username, $password2);

    $reflection = new PT\Reflection($_POST['title'], $_POST['content']);
	
	$query="INSERT into reflections (title, content) values ('".$reflection->getTitle()."', '".$reflection->getReflection()."');";

	$result=$database->queryExecute($query);

	$url = 'https://mandrillapp.com/api/1.0/messages/send.json';
	$params = [
		'message' => array(
			'subject' => $reflection->getTitle(),
			'text' => $reflection->getReflection(),
			'html' => '<p>'.$reflection->getReflection().'</p>',
			'from_email' => 'wojcikk@v-ie.uek.krakow.pl',
			'to' => array(
				array(
					'email' => 'wojcikk@wizard.uek.krakow.pl',
					'name' => 'Katarzyna Wójcik'
				)
			)
		)
	];

	$params['key'] = '1G6Ee5e6hCDaJTiU4QVkgw';
	$params = json_encode($params);
	$ch = curl_init(); 

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

	$head = curl_exec($ch); 
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	curl_close($ch); 

	header("Location: ".$_SERVER['HTTP_REFERER']);
