<?php

class Db{
	
	public $mongo;
	
	private $base;
	
	//
	
	public function __construct($base){
		
		$this->mongo = new MongoDB\Driver\Manager(MONGO_SERVER);
		$this->base = $base;
	}
	
	//
	
	public function query($collect, $filter, $param = array()){
		
		$query = new MongoDB\Driver\Query($filter, $param);
		$res = $this->mongo->executeQuery($this->collect($collect), $query);
		
		return $this->ex($res);
	}
	
	public function insert($collect, $data){
		
		$bulk = new MongoDB\Driver\BulkWrite;
		
		$bulk->insert($data);
		
		$this->mongo->executeBulkWrite($this->collect($collect), $bulk);
	}
	
	public function update($collect, $updates){
		
		$bulk = new MongoDB\Driver\BulkWrite;
		
		foreach($updates AS $update) $bulk->update($update[0], $update[1], $update[2]);
		
		$this->mongo->executeBulkWrite($this->collect($collect), $bulk);
	}
	
	public function delete($collect, $deletes){
		
		$bulk = new MongoDB\Driver\BulkWrite;
		
		foreach($deletes AS $delete) $bulk->delete($delete[0], $delete[1]);
		
		$this->mongo->executeBulkWrite($this->collect($collect), $bulk);
	}
	
	//
	
	public function letOI($id){
		
		return new MongoDB\BSON\ObjectId($id);
	}
	
	//
	
	private function collect($name){
		
		return sprintf("%s.%s", $this->base, $name);
	}
	
	//
	
	private function ex($results){
		
		$return = array();
		
		foreach($results AS $result) $return[] = $this->rec($result);
		
		return $return;
	}
	
	private function rec($array){
		
		$return = array();
		
		//
		
		foreach($array AS $k=>$v){
			
			if($k == "oid"){
				return (string) $v;
				continue;
			}
			
			//
			
			$return[$k] = gettype($v) == "object" ? $this->rec($v) : $v ;
		}
		
		//
		
		return $return;
	}
	
	//
}