<?php

class Loger{
	
	public $module;
	public $name;
	public $time_start;
	public $time_end;
	public $logs;
	public $status;
	public $msg;
	
	public function create($module){
		
		$this->module = $module;
		$this->logs = array();
		$this->time_start = date("Y-m-d\TH:i:s.u");
	}
	
	public function lead($type, $msg, $toLast = false){
		
		if($toLast){ $this->logs[count($this->logs) - 1]["msg"] .= sprintf(" %s", $msg); }
		else{ array_push($this->logs, array("type" => $type, "msg" => $msg)); }
	}
	
	public function complete($status, $name = false, $msg = false){
		
		$this->name = $name ? $name : "???";
		$this->status = $status;
		
		//
		
		$this->msg = $msg ? $msg : $this->logs[count($this->logs) - 1]["msg"];
		
		//
		
		$this->time_end = date("Y-m-d\TH:i:s.u");
		
		//
		
		$return = array();
		
		foreach($this AS $key=>$value) $return[$key] = $value;
		
		return $return;
	}
}