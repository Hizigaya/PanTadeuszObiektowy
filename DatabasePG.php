<?php

namespace PostgresqlDatabase;

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
		$this->connection = pg_connect("host=".$this->hostname." port=5432 user=".$this->username." dbname=".$this->database." password=".$this->password."")
		or die ("Couldn't connect to database: ".pg_last_error($this->connection));
	}

	public function disconnect(){
		pg_close($this->connection);
	}

	public function queryExecute($query){
		$result = pg_query($this->connection, $query);
		if (pg_affected_rows($result)===1) {
			return true;
		} else {
			return $this->convertToArray($result);
		}
	}

	public function convertToArray($result){
		return pg_fetch_all($result);
	}
}
