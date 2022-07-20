<?php

class Parser{
	
	//
	
	public function parse($url, $method, $proxy = false){
		
		$ch = curl_init();
		
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
		);
		
		//

		if($proxy){
			
			array_push($options, array(CURLOPT_PROXY => sprintf("%s:%s", $proxy["ip"], $proxy["port"])));
			if(!empty($proxy["user"]) && !empty($proxy["pass"])) array_push($options, array(CURLOPT_PROXYUSERPWD => sprintf("%s:%s", $proxy["user"], $proxy["pass"])));
		}		
		
		//
		
		curl_setopt_array($ch, $options);
		
		//
		
		if(($respone = curl_exec($ch)) === false) return false;
		else return $respone;
	}
	
	//
	
	public function parseImg($url){
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if(($respone = curl_exec($ch)) === false) return false;
		return $respone;
	}
}