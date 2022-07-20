<?php

class Model{
	
	public function __construct($bundle){ foreach($bundle AS $key=>$throw) $this->$key = $throw; }
	
	// THE CRUD OF MY DREAM!!!!!!!!!!!!
	
	public function gets($subject, $projection, $condition = false){
		
		if($condition){ 
			array_push($condition, array("document" => $subject));
			$filter = array("\$and" => $condition);
			$params = $projection;
		}
		else{
			$filter = array("document" => $subject);
			$params = array("projection" => $projection);
		}
		
		//
		
		return $this->db->query($subject, $filter, $params);
	}
	
	//
	
	public function get($subject, $_id){
		
		$projection = array("_id" => 0);
		
		//
		
		$filter = array("document" => $subject, "_id" => $this->db->letOI($_id));
		$params = array("projection" => $projection);
		
		//
		
		$result = $this->db->query($subject, $filter, $params);
		return isset($result[0]) ? $result[0] : false ;
	}
	
	//
	
	public function update($subject, $_id, $data){
		
		if(is_array($_id)){ foreach($_id AS $key=>$value) $filter[$key] = $value; }
		else $filter = array("_id" => $this->db->letOI($_id));
		
		$option = array("upsert" => false, "multi" => false);
		
		//
		
		$array[] = array($filter, array("\$set" => $data), $option);
		
		//
		
		$this->db->update($subject, $array);
	}
	
	//
	
	public function insert($subject, $data){
				
		$this->db->insert($subject, array("document" => $subject) + $data);
	}
	
	public function inserts($subject, $datas){
		
		foreach($datas AS $data){
			
			$this->db->insert($subject, array("document" => $subject) + $data);
		}
	}
	
	//
	
	public function del($subject, $_id){
		
		if(is_array($_id)){ foreach($_id AS $k=>$v) $filter[$k] = $v; }
		else $filter = array("_id" => $this->db->letOI($_id));
		$option = array("limit" => 1);
		
		//
		
		$array[] = array($filter, $option);
		
		//
		
		$this->db->delete($subject, $array);
	}
	
	// Other joints
	
	public function nameByid($collect, $id){
		
		$projection = array("name" => 1);
		
		//
		
		$filter = array("_id" => $this->db->letOI($id));
		$params = array("projection" => $projection);
		
		//
		
		$res = $this->db->query($collect, $filter, $params);
		
		//
		
		if(is_array($res) && isset($res[0]["name"])) return $res[0]["name"];
		else return "удалено";
	}
	
	//
	
	public function getFull($collect){
		
		$projection = array("name" => 1);
		
		//
		
		$filter = array("document" => $collect);
		$params = array("projection" => $projection);
		
		//
		
		$res = $this->db->query($collect, $filter, $params);
		
		//
		
		return $res;
	}
	
	//
	
	public function idExists($collect, $id){
		
		$projection = array("_id" => 1);
		
		//
		
		$filter = array("document" => $collect, "_id" => $this->db->letOI($id));
		$params = array("projection" => $projection);
		
		//
		
		$res = $this->db->query($collect, $filter, $params);
		
		//
		
		if(!empty($res[0]["_id"]) && $res[0]["_id"] == $id) return true;
		else return false;
	}
}