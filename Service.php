<?php

include_once('Reflection.php');
include_once('DatabaseMS.php');
include_once('DatabasePG.php');

use PanTadeusz as PT;
use MysqlDatabase as MS;
use PostgresqlDatabase as PG;

class Service{

	private $reflections;
	private $database;
	
	public function __construct($hostname, $database, $username, $password1, $password2, $type)
	{
		$this->reflections= array();
		if ($type=='MS') {
			$this->database = new MS\Database($hostname, $database, $username, $password2);
		}else {
			$this->database = new PG\Database($hostname, $database, $username, $password1);
		}
		
	}

	public function getFromDatabase(){
		$query="SELECT * FROM reflections";
		$reflections=$this->database->queryExecute($query);
		for($i=0; $i<sizeof($reflections);$i++){
			$this->reflections[$i] = new PT\Reflection($reflections[$i]['title'], $reflections[$i]['content']);
			$this->reflections[$i]->setId($reflections[$i]['id']);
		}
		return $this->reflections;
	}

	public function addToDatabase($title, $comment){
		$reflection = new PT\Reflection($title, $comment);
		$query="INSERT into reflections (title, content) values ('".$reflection->getTitle()."', '".$reflection->getReflection()."');";
		$result = $this->database->queryExecute($query);
		if ($result){
			$this->sendEmail('wojcikk@wizard.uek.krakow.pl', 'Katarzyna Wójcik', $reflection);
		}
	}

	public function sendEmail($email, $name, $reflection){
		$url = 'https://mandrillapp.com/api/1.0/messages/send.json';
		$params = [
			'message' => array(
				'subject' => $reflection->getTitle(),
				'text' => $reflection->getReflection(),
				'html' => '<p>'.$reflection->getReflection().'</p>',
				'from_email' => 'wojcikk@v-ie.uek.krakow.pl',
				'to' => array(
					array(
						'email' => $email,
						'name' => $name
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
	}

	public function displayReflections(){
		echo "
			<table class='table table-hover'>
				<thead>
					<tr>
						<th>Id</th>
						<th>Tytuł</th>
						<th>Treść</th>
					<tr>
				</thead>
				<tbody>";
					for($i=0; $i<sizeof($this->reflections);$i++){
						echo "<tr>";
						echo "<td>".$this->reflections[$i]->getId()."</td>";
						echo "<td>".$this->reflections[$i]->getTitle()."</td>";
						echo "<td>".$this->reflections[$i]->getReflection()."</td>";
						echo "</tr>";
					}
		echo "
				</tbody>
			</table>";
	}
}