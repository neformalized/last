<?php

class ScheduleController extends Controller{

	public function def(){
		
		//$this->modelSchedule = $this->loader->model("schedule", "scheduleModel");
		
		switch(!empty($this->vars->get["method"]) ? $this->vars->get["method"] : "list"){
			
			case "list":
				$this->list();
				break;
			case "add":
				$this->add();
				break;
			case "edit":
				$this->edit();
				break;
			case "poly":
				$this->poly();
				break;
			case "del":
				$this->del();
				break;
			default:
				$this->list();
				break;
		}
	}
	
	//
	
	private function list(){
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "schedule", "method" => "add"), "Добавить")
		);
		
		//
		
		$schedules = $this->modelStandalone->gets("schedule", array("name" => 1, "parser" => 1, "trigger" => 1, "proxyOnly" => 1, "cron" => 1));
		
		foreach($schedules AS $schedule){
			
			$temp["name"] = $schedule["name"];
			$temp["parser"] = empty($schedule["parser"]) ? "-" : $this->modelStandalone->nameById("parser", $schedule["parser"]);
			$temp["trigger"] = empty($schedule["trigger"]) ? "-" : $this->modelStandalone->nameById("trigger", $schedule["trigger"]);
			$temp["proxy"] = ($schedule["proxyOnly"]) ? "true" : "false" ;
			$temp["style"] = ($schedule["proxyOnly"]) ? "green" : "red" ;
			$temp["cron"] = $schedule["cron"];
			$temp["status"] = "Загружен";
			
			$temp["action"] = array(
				"edit" => $this->render->ahref(array("controller" => "schedule", "method" => "edit", "_id" => $schedule["_id"]), "Редактировать"),
				"change" => $this->render->ahref(array("controller" => "schedule", "method" => "change", "_id" => $schedule["_id"]), "Отключить"),
				"execute" => $this->render->ahref(array("controller" => "execute", "_id" => $schedule["_id"]), "Парсить"),
				"delete" => $this->render->ahref(array("controller" => "schedule", "method" => "del", "_id" => $schedule["_id"]), "Удалить")
			);
			
			$this->data["schedule"][] = $temp;
		}
		
		//
		
		$this->data["title"] = "Планировки";
		$this->template = "schedule/list";
	}
	
	//
	
	private function del(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!$this->modelStandalone->idExists("schedule", $this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		$this->modelStandalone->del("schedule", $this->vars->get["_id"]);
		
		//
		
		$this->data["success"][] = "Планировка удалена";
		$this->list();
	}
	
	//
	
	private function add(){
		
		if(!empty($this->vars->post)){
			if($data = $this->checkPost()){
				
				$this->modelStandalone->insert("schedule", $data);
				
				$this->data["success"][] = "Создано";
				
				$this->list();
				
				return;
			}
		}
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "schedule"), "Список")
		);
		
		//
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "schedule", "method" => "add"));
		
		//
		
		$this->data["parsers"] = $this->getVariants("parser");
		$this->data["triggers"] = $this->getVariants("trigger");
		$this->data["proxyes"] = $this->getVariants("proxy");
		
		//
		
		$tmp = $this->postParams($this->vars->post);
		
		//
		
		if($tmp) $this->data["params"] = $tmp;
		
		//
		
		$this->data["scripts"][] = $this->render->jsr("schedule");
		
		$this->data["title"] = "Добавить планировку";
		$this->template = "schedule/form";
	}
	
	//
	
	private function edit(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!$result = $this->modelStandalone->get("schedule", $this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!empty($this->vars->post)){
			if($data = $this->checkPost()){
				
				$this->modelStandalone->update("schedule", $this->vars->get["_id"], $data);
				
				$this->data["success"][] = "Планировка обновлена";
				
				$this->vars->realCleanPost(true);
				
				$this->edit();
				
				return;
			}
		}
		
		//
		
		$_POST["name"] = empty($this->vars->post["name"]) ? $result["name"] : $this->vars->post["name"] ;
		$_POST["function"] = empty($this->vars->post["function"]) ? $result["function"] : $this->vars->post["function"] ;
		$_POST["parser"] = empty($this->vars->post["parser"]) ? $result["parser"] : $this->vars->post["parser"] ;
		$_POST["trigger"] = empty($this->vars->post["trigger"]) ? $result["trigger"] : $this->vars->post["trigger"] ;
		
		$_POST["proxyOnly"] = empty($this->vars->post["proxyOnly"]) ? ($result["proxyOnly"] ? "yes" : "no") : $this->vars->post["proxy"] ;
		$_POST["proxy"] = empty($this->vars->post["proxy"]) ? (empty($result["proxyes"]) ? array() : $result["proxyes"]) : $this->vars->post["proxy"] ;
		
		$_POST["min"] = empty($this->vars->post["min"]) ? $result["cron"]["min"] : $this->vars->post["min"] ;
		$_POST["hour"] = empty($this->vars->post["hour"]) ? $result["cron"]["hour"] : $this->vars->post["hour"] ;
		$_POST["day"] = empty($this->vars->post["day"]) ? $result["cron"]["day"] : $this->vars->post["day"] ;
		$_POST["month"] = empty($this->vars->post["month"]) ? $result["cron"]["month"] : $this->vars->post["month"] ;
		$_POST["weekday"] = empty($this->vars->post["weekday"]) ? $result["cron"]["weekday"] : $this->vars->post["weekday"] ;
		
		//
		
		$this->data["params"] = empty($this->vars->post) ? $this->objParams(isset($result["params"]) ? $result["params"] : false) : $this->postParams($this->vars->post) ;
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "schedule"), "Список"),
			$this->render->ahref(array("controller" => "schedule", "method" => "del", "_id" => $this->vars->get["_id"]), "Удалить планировку"),
			$this->render->ahref(array("controller" => "execute", "_id" => $this->vars->get["_id"]), "Парсить текущие настройки")
		);
		
		//
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "schedule", "method" => "edit", "_id" => $this->vars->get["_id"]));
		
		//
		
		$this->data["parsers"] = $this->getVariants("parser");
		$this->data["triggers"] = $this->getVariants("trigger");
		$this->data["proxyes"] = $this->getVariants("proxy");
		
		//
		
		$this->data["scripts"][] = $this->render->jsr("schedule");
		
		$this->data["title"] = "Обновить планировку";
		$this->template = "schedule/form";
	}
	
	//
	
	private function checkPost(){
		
		$insert = array();
		
		//
		
		if($this->shexp->isValidTitle($this->vars->post["name"])) $insert["name"] = $this->vars->post["name"];
		else{
			$this->data["attention"][] = "В названии прокси не допустимые символы";
			return false;
		}
		
		//
		
		if(in_array($this->vars->post["function"], array("clone", "replace", "append", "pass"))) $insert["function"] = $this->vars->post["function"];
		else{
			$this->data["attention"][] = "\"Левая\" функция для дублей";
			return false;
		}
		
		//
		
		if($this->shexp->isValidMongoId($this->vars->post["parser"])){
			if($this->modelStandalone->idExists("parser", $this->vars->post["parser"])) $insert["parser"] = $this->vars->post["parser"];
			else{
				$this->data["attention"][] = "Парсер не существует";
				return false;
			}
		}
		else{
			$this->data["attention"][] = "\"Левый\" парсер";
			return false;
		}
		
		//
		
		if(isset($this->vars->post["trigger"]) && !empty($this->vars->post["trigger"])){
			
			if($this->shexp->isValidMongoId($this->vars->post["trigger"])){
				if($this->modelStandalone->idExists("trigger", $this->vars->post["trigger"])) $insert["trigger"] = $this->vars->post["trigger"];
				else{
					$this->data["attention"][] = "Триггер не существует";
					return false;
				}
			}
			else{
				$this->data["attention"][] = "\"Левый\" триггер";
				return false;
			}
		}
		else $insert["trigger"] = "";
		
		//
		
		if($this->vars->post["proxyOnly"] == "yes" || $this->vars->post["proxyOnly"] == "no") $insert["proxyOnly"] = $this->vars->post["proxyOnly"] == "yes" ? true : false ;
		else{
			$this->data["attention"][] = "Обязательность прокси не указана";
			return false;
		}
		
		//
		
		if(isset($this->vars->post["proxy"])){
			if(is_array($this->vars->post["proxy"])){
				
				$tmp = array();
			
				foreach($this->vars->post["proxy"] AS $proxy){
					
					if($this->shexp->isValidMongoId($proxy) && $this->modelStandalone->idExists("proxy", $proxy)){
						
						$tmp[] = $proxy;
					}
				}
				
				$insert["proxyes"] = $tmp;
			}
		}
		
		//
		
		$params = $this->postParams($this->vars->post);
		
		if($params){
			
			$tmp = array();
			
			foreach($params AS $param) $tmp[$param["key"]] = $param["value"];
			
			$insert["params"] = $tmp;
		}
		
		//
		
		if($this->shexp->isValidCronValue($this->vars->post["min"])) $insert["cron"]["min"] = $this->vars->post["min"];
		else{
			$this->data["attention"][] = "Значение для крона указаны не правильно";
			return false;
		}
		
		//
		
		if($this->shexp->isValidCronValue($this->vars->post["hour"])) $insert["cron"]["hour"] = $this->vars->post["hour"];
		else{
			$this->data["attention"][] = "Значение для крона указаны не правильно";
			return false;
		}
		
		//
		
		if($this->shexp->isValidCronValue($this->vars->post["day"])) $insert["cron"]["day"] = $this->vars->post["day"];
		else{
			$this->data["attention"][] = "Значение для крона указаны не правильно";
			return false;
		}
		
		//
		
		if($this->shexp->isValidCronValue($this->vars->post["month"])) $insert["cron"]["month"] = $this->vars->post["month"];
		else{
			$this->data["attention"][] = "Значение для крона указаны не правильно";
			return false;
		}
		
		//
		
		if($this->shexp->isValidCronValue($this->vars->post["weekday"])) $insert["cron"]["weekday"] = $this->vars->post["weekday"];
		else{
			$this->data["attention"][] = "Значение для крона указаны не правильно";
			return false;
		}
		
		//
		
		$insert["counts"] = array("total" => array("good" => 0, "bad" => 0), "data" => array("good" => 0, "bad" => 0));
		
		return $insert;
	}
	
	//
	
	private function postParams($array){
		
		if(!isset($array["params"]) || !isset($array["values"])) return false;
		if(!is_array($array["params"]) || !is_array($array["values"])) return false;
		if(count($array["params"]) !== count($array["values"])) return false;
		
		$tmp = array();
		
		for($i = 0; $i < count($array["params"]); $i++){
			
			$key = $array["params"][$i];
			if(!$this->shexp->isValidKey($key)) continue;
			
			$value = $array["values"][$i];
			if(!$this->shexp->isValidValue($key)) continue;
			
			$tmp[] = array("key" => $key, "value" => $value);
		}
		
		return empty($tmp) ? false : $tmp ;
	}
	
	//
	
	private function objParams($obj){
	
		if(empty($obj)) return false;
	
		$tmp = array();
		
		foreach($obj AS $key=>$value) $tmp[] = array("key" => $key, "value" => $value);
		
		return $tmp;
	}
	
	//
	
	private function getVariants($from){
		
		return $this->modelStandalone->getFull($from);
	}
}