<?php

class ExecuteModel extends Model{
	
	public function dataExists($login, $service){
		
		$projection = array("_id" => 1, "login" => 1);
		
		//
		
		$filter = array("document" => "data", "login" => $login, "service" => $service);
		$params = array("projection" => $projection);
		
		
		//
		
		$res = $this->db->query("data", $filter, $params);
		
		//
		
		if(!empty($res[0]["login"]) && $res[0]["login"] == $login) return true;
		else return false;
	}
	
	public function dataDelete($login, $service){
		
		$filter = array("login" => $login, "service" => $service);
		$option = array("limit" => 1);
		
		//
		
		$array[] = array($filter, $option);
		
		//
		
		$this->db->delete("data", $array);
	}
}