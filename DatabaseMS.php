<?php

namespace MysqlDatabase;

class Database{

	private $connection;
	private $username;
	private $password;
	private $hostname;
	private $database;

	public function __construct($hostname, $database, $username, $password){
		$this->hostname=$hostname;
		$this->database=$database;
		$this->username=$username;
		$this->password=$password;
		$this->connect();
	}

	public function __destruct(){
		$this->disconnect();
	}

	public function getHostname(){
		return $this->hostname;
	}
	public function setHostname($hostname){
		$this->hostname=$hostname;
	}
	public function getDatabase(){
		return $this->database;
	}
	public function setDatabase($database){
		$this->database=$database;
	}
	public function getUsername(){
		return $this->username;
	}
	public function setUsername($username){
		$this->username=$username;
	}
	private function getPassword(){
		return $this->password;
	}
	private function setPassword($password){
		$this->password=$password;
	}

	public function getConnection(){
		return $this->connection;
	}

	public function connect(){
		$this->connection = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
 	 	if (mysqli_connect_errno()) {
       		echo "Failed to connect to MySQL: " . mysqli_connect_error();
     	}
	}

	public function disconnect(){
		mysqli_close($this->connection);
	}

	public function queryExecute($query){
		$result = mysqli_query($this->connection, $query);
		if ($result===true) {
			return $result;
		} else {
			return $this->convertToArray($result);
		}
	}

	public function convertToArray($result){
		return mysqli_fetch_all($result, MYSQLI_ASSOC);
	}
}
