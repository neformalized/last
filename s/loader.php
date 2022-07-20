<?php

class Loader{

	private $bundle_c;
	private $bundle_m;

	//

	public function __construct($bundle_c, $bundle_m){
		
		$this->bundle_c = $bundle_c;
		$this->bundle_m = $bundle_m;
	}
	
	//
	
	public function model($path, $class){
		
		if(!file_exists(sprintf("%s%s.php", MDL, $path))) return;
		
		require_once(sprintf("%s%s.php", MDL, $path));
		
		return new $class($this->bundle_m);
	}
	
	public function controller($path, $class){
		
		if(!file_exists(sprintf("%s%s.php", CTRL, $path))) return;
		
		require_once(sprintf("%s%s.php", CTRL, $path));
		
		return new $class($this->bundle_c);
	}
	
	public function standalone(){
		
		require_once(sprintf("%smodel.php", CORE));
		return new Model($this->bundle_m);
	}
}