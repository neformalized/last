<?php

class Bundle{
	
	public function __construct(){}
	
	public function sett($name, $thread){ $this->$name = $thread; }
	
	public function gett($name){ return $this->$name; }
}