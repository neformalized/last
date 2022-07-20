<?php

class Shexp{
	
	public function isValidName($word){ return preg_match("/^[a-zA-Z]{3,32}$/", $word) ? true : false ; }
	public function isValidService($service){ return preg_match("/^[a-zA-Z0-9]{3,32}$/", $service) ? true : false ; }
	public function isValidPath($path){ return preg_match("/^[a-zA-Z0-9\/\_]{1,32}$/", $path) ? true : false ; }
	public function isValidTitle($title){ return preg_match("/^[a-zA-Zа-яА-Я0-9\ \-\_\,]{2,32}$/", $title) ? true : false ; }
	public function isValidLink($link){ return preg_match("|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", $link) ? true : false ; }
	public function isValidMongoId($id){ return preg_match("/^[a-z0-9]{24}$/", $id) ? true : false ; }
	public function isValidIp($ip){ return filter_var($ip, FILTER_VALIDATE_IP) ? true : false ; }
	public function isValidPort($port){ return preg_match("/^[0-9]{1,5}$/", $port) ? true : false ; }
	public function isValidAuthInput($input){ return preg_match("/^[a-zA-Zа-яА-Я0-9]{2,64}$/", $input) ? true : false ; }
	public function isValidKey($key){ return preg_match("/^[a-zA-Z\_]{1,32}$/", $key) ? true : false ; }
	public function isValidValue($value){ return preg_match("/^[a-zA-Zа-яА-Я0-9\_]{1,64}$/", $value) ? true : false ; }
	public function isValidCronValue($cronValue){ return ($cronValue == "*" || preg_match("/^[0-9\,\/\-]{1,32}$/", $cronValue)) ? true : false ; }
	public function isValidNum($num){ return preg_match("/^[0-9]{1,10}$/", $num) ? true : false ; }
}