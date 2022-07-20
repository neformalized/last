<?php

class ProxyController extends Controller{
	
	public function def(){
		
		//
		
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
			case "fresh":
				$this->fresh();
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
			$this->render->ahref(array("controller" => "proxy", "method" => "add"), "Добавить")
		);
		
		//
		
		$proxyes = $this->modelStandalone->gets("proxy", array("name" => 1, "ip" => 1, "port" => 1, "type" => 1, "last" => 1, "active" => 1));
		
		foreach($proxyes AS $proxy){
			
			$temp["name"] = $proxy["name"];
			$temp["ip"] = $proxy["ip"];
			$temp["port"] = $proxy["port"];
			$temp["type"] = $proxy["type"];
			$temp["last"] = date("d/M/Y h:i:s", strtotime($proxy["last"]));
			$temp["active"] = ($proxy["active"]) ? "true" : "false" ;
			$temp["style"] = ($proxy["active"]) ? "green" : "red" ;
			
			$temp["action"] = array(
				"edit" => $this->render->ahref(array("controller" => "proxy", "method" => "edit", "_id" => $proxy["_id"]), "Редактировать"),
				"delete" => $this->render->ahref(array("controller" => "proxy", "method" => "del", "_id" => $proxy["_id"]), "Удалить"),
				"fresh" => $this->render->ahref(array("controller" => "proxy", "method" => "fresh", "_id" => $proxy["_id"]), "Апдейт")
			);
			
			$this->data["proxy"][] = $temp;
		}
		
		//
		
		$this->data["title"] = "Прокси";
		$this->template = "proxy/list";
	}
	
	//
	
	public function fresh(){
		
		$this->update();
		$this->list();
	}
	
	public function update(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!$result = $this->modelStandalone->get("proxy", $this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		$data = $this->proxy->check($result);
		$this->modelStandalone->update("proxy", $this->vars->get["_id"], $data);
		
		//
		
		$this->data["success"][] = sprintf("Апдейт %s - %s", $data["ip"], ($data["active"] ? "true" : "false"));
	}
	
	//
	
	private function add(){
		
		if(!empty($this->vars->post)){
			if($data = $this->checkPost()){
				
				$data = $this->proxy->check($data);
				
				$this->modelStandalone->insert("proxy", $data);
				
				$this->data["success"][] = "Прокси добавлены";
				
				$this->list();
				
				return;
			}
		}
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "proxy"), "Список")
		);
		
		//
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "proxy", "method" => "add"));
		
		//
		
		$this->data["title"] = "Добавить";
		$this->template = "proxy/form";
	}
	
	//
	
	private function edit(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!$result = $this->modelStandalone->get("proxy", $this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!empty($this->vars->post)){
			if($data = $this->checkPost()){
				
				$data = $this->proxy->check($data);
				
				$this->modelStandalone->update("proxy", $this->vars->get["_id"], $data);
				
				$this->data["success"][] = "Прокси обновлён";
				
				$this->vars->realCleanPost(true);
				
				$this->edit();
				
				return;
			}
		}
		
		//
		
		$_POST["name"] = empty($this->vars->post["name"]) ? $result["name"] : $this->vars->post["name"] ;
		$_POST["ip"] = empty($this->vars->post["ip"]) ? $result["ip"] : $this->vars->post["ip"] ;
		$_POST["port"] = empty($this->vars->post["port"]) ? $result["port"] : $this->vars->post["port"] ;
		$_POST["type"] = empty($this->vars->post["type"]) ? $result["type"] : $this->vars->post["type"] ;
		$_POST["login"] = empty($this->vars->post["login"]) ? $result["login"] : $this->vars->post["login"] ;
		$_POST["pass"] = empty($this->vars->post["pass"]) ? $result["pass"] : $this->vars->post["pass"] ;
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "proxy"), "Список прокси"),
			$this->render->ahref(array("controller" => "proxy", "method" => "del", "_id" => $this->vars->get["_id"]), "Удалить текущие прокси"),
			$this->render->ahref(array("controller" => "proxy", "method" => "ping", "_id" => $this->vars->get["_id"]), "Ping данных прокси")
		);
		
		//
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "proxy", "method" => "edit", "_id" => $this->vars->get["_id"]));
		
		//
		
		$this->data["title"] = "Обновить";
		$this->template = "proxy/form";
	}
	
	//
	
	private function del(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//
			$this->list();
			return;
		}
		
		//
		
		if(!$this->modelStandalone->idExists("proxy", $this->vars->get["_id"])){
			//
			$this->list();
			return;
		}
		
		//
		
		$this->modelStandalone->del("proxy", $this->vars->get["_id"]);
		
		//
		
		$this->data["success"][] = "Прокси удалены";
		$this->list();
	}
	
	/* - */
	
	private function checkPost(){
		
		$insert = array();
		
		//
		
		if($this->shexp->isValidTitle($this->vars->post["name"])) $insert["name"] = $this->vars->post["name"];
		else{
			$this->data["attention"][] = "В названии прокси не допустимые символы";
			return false;
		}
		
		if($this->shexp->isValidIp($this->vars->post["ip"])) $insert["ip"] = $this->vars->post["ip"];
		else{
			$this->data["attention"][] = "Ип введён не верно";
			return false;
		}
		
		if($this->shexp->isValidPort($this->vars->post["port"])) $insert["port"] = $this->vars->post["port"];
		else{
			$this->data["attention"][] = "Порт введён не верно";
			return false;
		}
		
		if($this->vars->post["type"] == "http" || $this->vars->post["type"] == "https" || $this->vars->post["type"] == "socks") $insert["type"] = $this->vars->post["type"];
		else{
			$this->data["attention"][] = "Тип прокси указан не верно";
			return false;
		}
		
		if($this->shexp->isValidAuthInput($this->vars->post["login"])) $insert["login"] = $this->vars->post["login"];
		else{
			if(!empty($this->vars->post["login"])){
				$this->data["attention"][] = "Логин введён не верно";
				return false;
			}else $insert["login"] = $this->vars->post["login"];
		}

		if($this->shexp->isValidAuthInput($this->vars->post["pass"])) $insert["pass"] = $this->vars->post["pass"];
		else{
			if(!empty($this->vars->post["pass"])){
				$this->data["attention"][] = "Пароль введён не верно";
				return false;
			}else $insert["pass"] = $this->vars->post["pass"];
		}
		
		//
		
		return $insert;
	}
}