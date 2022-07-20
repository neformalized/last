<?php

class Vars{

	public $get;
	public $post;

	public function __construct(){
		
		if(!empty($_GET)) foreach($_GET AS $key=>$value) $this->get[$key] = $value;
		if(!empty($_POST)) foreach($_POST AS $key=>$value) $this->post[$key] = $value;
	}
	
	//
	
	public function realCleanPost($parent){
		unset($_POST);
		if($parent) unset($this->post);
	}
	
	public function realCleanGet($parent){
		unset($_GET);
		if($parent) unset($this->get);
	}
}