<?php

class Cache{

	public function __construct(){
		
		$this->memcache = new Memcache();
		$this->memcache->connect(MEMCACHE_HOST, MEMCACHE_PORT) or die("memcache false");
	}
	
	//
	
	public function check($key, $return = false){
		
		if(!empty($res = $this->memcache->get($key))){
			
			if($return) return $res;
			else return true;
		}
		else return false;
	}
	
	//
	
	public function add($key, $data, $time){
		
		$this->memcache->set($key, $data, false, $time);
	}
}