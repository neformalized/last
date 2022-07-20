<?php

class Controller{
	
	public function __construct($bundle){
		
		foreach($bundle AS $key=>$throw) $this->$key = $throw;
		
		$this->modelStandalone = $this->loader->standalone();
	}
}