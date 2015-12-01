<?php

namespace PanTadeusz;

class Reflection{

	private $id;
	private $title;
	private $reflection;

	public function __construct($title, $reflection){
		$this->title=$title;
		$this->reflection=$reflection;
	}

	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id=$id;
	}

	public function getTitle(){
		return $this->title;
	}
	public function setTitle($title){
		$this->title=$title;
	}

	public function getReflection(){
		return $this->reflection;
	}
	public function setReflection($reflection){
		$this->reflection=$reflection;
	}
}