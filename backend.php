<?php

require_once("conf.php");
require_once("s/s/model.php");
require_once("s/fields.php");
require_once("s/db.php");
require_once("s/cache.php");
require_once("c/tool/loger.php");

//

class Backend{

	public function __construct(){
		
		$this->start = microtime(true);
		
		//
		
		if(!isset($_GET["api"]) || !preg_match("/^[a-z0-9]{24}$/", $_GET["api"])) die("Don't joke...");
		
		//
		
		$this->connectCache();
		
		//
		
		if($fastResult = $this->cache->check(sprintf("api_%s", $_GET["api"]), true)){
			if(isset($_GET["debug"])) $this->debug("cache", json_decode($fastResult));
			else echo $fastResult;
			return;
		}
		
		//
		
		$this->connectModel();
		
		//
		
		if(!$apiConf = $this->model->get("api", $_GET["api"])) die("Api id does not exist");
		if(!$apiConf["active"]) die("Api's off by adminushka");
		
		//
		
		$projection = array();
		$projection["service"] = 1;
		if(isset($apiConf["projection"]) && !empty($apiConf["projection"])){ foreach($apiConf["projection"] AS $value) $projection[sprintf("field.%s", $value)] = 1; }
		
		//
		
		$condition = array();
		if(isset($apiConf["condition"]) && !empty($apiConf["condition"])){
			//
			$fields = new Fields();
			//
			foreach($apiConf["condition"] AS $key=>$value){
				//
				switch($fields->$key->type){
					
					case "int":
					
						$tmp = array();
						//
						if(isset($value["a"])) $tmp["\$gt"] = $value["a"];
						if(isset($value["b"])) $tmp["\$lt"] = $value["b"];
						//
						$condition[] = array(sprintf("field.%s", $key) => $tmp);
						//
						unset($tmp);
						//
						break;
						
					case "boolean":
						
						$condition[] = array(sprintf("field.%s", $key) => $value);
						//
						break;
						
					case "string":
						
						if($fields->$key->isArray){
							$condition[] = array(sprintf("field.%s", $key) => array("\$all" => explode(",", $value)));
							continue;
						}
						
						$tmp = explode(",", $value);
						//
						if(count($tmp) == 1) $condition[] = array(sprintf("field.%s", $key) => $tmp[0]);
						else{
							
							$ors = array();
							//
							foreach($tmp AS $v)	$ors[] = array(sprintf("field.%s", $key) => $v);
							//
							$condition[] = array("\$or" => $ors);
						}
						//
						
						break;
						
					default:
						
						$condition[] = array(sprintf("field.%s", $key) => $fields->$key->isArray ? explode(",", $value) : $value);
						//
						break;
				//
				}
			}
		}
		
		//

		if(isset($apiConf["service"]) && !empty($apiConf["service"])) $condition[] = array("service" => $apiConf["service"]);
		
		//
		
		$params = array("limit" => $apiConf["limit"], "projection" => $projection);
		
		//
		
		$result = $this->model->gets("data", $params, $condition);
		
		//
		
		if(count($result) == 0) die("Api does not return any results");
		
		//
		
		$this->cache->add(sprintf("api_%s", $_GET["api"]), json_encode($result), $apiConf["cache"]);
		
		//
		
		if(isset($_GET["debug"])) $this->debug("mongo", $result);
		else echo json_encode($result);
	}
	
	private function debug($from, $result){
		echo "<pre>";
		print_r($result);
		echo "</pre>";
		echo "<pre>";
		echo sprintf("%s>%f", $from, (microtime(true) - $this->start));
		echo "</pre>";
	}
	
	//
	
	private function connectCache(){
		
		$this->cache = new Cache();
	}
	
	//
	
	private function connectModel(){
		
		$this->model = new Model(array("db" => new Db(BASE)));
	}
}

//

$backend = new Backend();