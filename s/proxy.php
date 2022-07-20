<?php

class Proxy{

	public function __construct(){
		
		$this->api = "https://api.myip.com";
	}
	
	//
	
	public function getStatus($proxy){
		
		//
		
		$serv = sprintf("%s:%s", $proxy["ip"], $proxy["port"]);
		$auth = sprintf("%s:%s", $proxy["login"], $proxy["pass"]);
		
		//
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->api);
		curl_setopt($ch, CURLOPT_PROXY, $serv);
		curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5000);

		//

		$respone = curl_exec($ch);

		//

		$data = !empty($respone) ? json_decode($respone, true) : "" ;

		//

		if(!empty($data)) return true;
		else return false;
	}
	
	//
	
	public function check($proxy){
		
		if($this->getStatus($proxy)) return array("active" => true, "last" => date("Y-m-d\TH:i:s.u")) + $proxy;
		else return array("active" => false, "last" => date("Y-m-d\TH:i:s.u")) + $proxy;
	}
}