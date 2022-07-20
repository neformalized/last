<?php

class DataController extends Controller{

	public function def(){
			
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
			$this->render->ahref(array("controller" => "data", "method" => "add"), "Добавить")
		);
		
		//
		
		//meganav
		
		//
		
		$datas = $this->modelStandalone->gets("data", array("login" => 1, "service" => 1, "active" => 1, "top" => 1, "date" => 1, "field.gender" => 1));
		
		foreach($datas AS $data){
		
			$temp["login"] = $data["login"];
			$temp["service"] = empty($data["service"]) ? "-" : $data["service"];
			$temp["gender"] = $data["field"]["gender"];
			$temp["active"] = ($data["active"]) ? "true" : "false" ;
			$temp["style"] = ($data["active"]) ? "green" : "red" ;
			$temp["top"] = $data["top"];
			$temp["date"] = date_format(date_create($data["date"]), "Y/m/d H:i:s");
			
			$temp["action"] = array(
				"edit" => $this->render->ahref(array("controller" => "data", "method" => "edit", "_id" => $data["_id"]), "Редактировать"),
				"del" => $this->render->ahref(array("controller" => "data", "method" => "del", "_id" => $data["_id"]), "Удалить"),
			);
			
			$this->data["datas"][] = $temp;
		}
		
		//
		
		$this->data["title"] = "Данные";
		$this->template = "data/list";
	}
	
	//
	
	private function del(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!$this->modelStandalone->idExists("data", $this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		$this->modelStandalone->del("data", $this->vars->get["_id"]);
		
		//
		
		$this->data["success"][] = "Данные удалены";
		$this->list();
	}
	
	//
	
	private function add(){
		
		if(!empty($this->vars->post)){
			
			if($data = $this->checkPost()){
				
				$this->modelStandalone->insert("data", $data);
				
				$this->data["success"][] = "Данные добавлены";
				
				$this->list();
				
				return;
			}
		}
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "data"), "Список")
		);
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "data", "method" => "add"));
		
		//
		
		$this->data["title"] = "Добавить";
		$this->template = "data/form";
	}
	
	//
	
	private function edit(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!$result = $this->modelStandalone->get("data", $this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!empty($this->vars->post)){
			
			if($data = $this->checkPost()){
				
				$this->modelStandalone->update("data", $this->vars->get["_id"], $data);
				
				$this->data["success"][] = "Данные обновлены";
				
				$this->vars->realCleanPost(true);
				
				$this->edit();
				
				return;
			}
		}
		
		//
		
		$_POST["login"] = empty($this->vars->post["login"]) ? $result["login"] : $this->vars->post["login"] ;
		$_POST["service"] = empty($this->vars->post["service"]) ? $result["service"] : $this->vars->post["service"] ;
		$_POST["top"] = empty($this->vars->post["top"]) ? $result["top"] : $this->vars->post["top"] ;
		$_POST["active"] = empty($this->vars->post["active"]) ? ($result["active"] ? "yes" : "no") : $this->vars->post["active"] ;
		
		//
		
		if(isset($result["field"])){
			
			foreach($result["field"] AS $k=>$v){
				
				if(is_array($v)){
					
					$tmp = "";
					foreach($v AS $val) $tmp .= sprintf("%s,", $val);
					$_POST[$k] = substr($tmp, 0, -1);
				}
				else $_POST[$k] = $v === false ? "false" : $v ;
			}
		}
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "data"), "Список"),
			$this->render->ahref(array("controller" => "data", "method" => "del", "_id" => $this->vars->get["_id"]), "Удалить текущие данные")
		);
		
		//
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "data", "method" => "edit", "_id" => $this->vars->get["_id"]));
		
		//
		
		$this->data["title"] = "Обновить";
		$this->template = "data/form";
	}
	
	//
	
	private function checkPost(){
		
		$insert = array();
		
		//
		
		if($this->shexp->isValidTitle($this->vars->post["login"])) $insert["login"] = $this->vars->post["login"];
		else{
			$this->data["attention"][] = "В названии парсера не допустимые символы";
			return false;
		}
		
		if($this->shexp->isValidService($this->vars->post["service"])) $insert["service"] = $this->vars->post["service"];
		else{
			$this->data["attention"][] = "В названии сервиса не допустимые символы";
			return false;
		}
		
		if($this->shexp->isValidNum($this->vars->post["top"])) $insert["top"] = $this->vars->post["top"];
		else{
			$this->data["attention"][] = "Top указан не верно";
			return false;
		}
		
		$insert["date"] = date("Y-m-d\TH:i:s.u");
		
		if($this->vars->post["active"] == "yes" || $this->vars->post["active"] == "no") $insert["active"] = ($this->vars->post["active"] == "yes" ? true: false);
		else{
			$this->data["attention"][] = "Активность указана не верно";
			return false;
		}
		
		//
		
		foreach($this->fields AS $k=>$v){

			if(!isset($this->vars->post[$k])) continue;
			
			//
			
			switch($v->type){
				case "string":
					
					if($v->isArray){
						
						$tmp = array();
						$vvs = explode(",", $this->vars->post[$k]);
						foreach($vvs AS $vv){ if($this->shexp->isValidTitle($vv)) $tmp[] = $vv; }
						if(empty($tmp)) continue;
						$insert["field"][$k] = $tmp;
					}
					else{
						
						if(!$this->shexp->isValidTitle($this->vars->post[$k])) continue;
						$insert["field"][$k] = $this->vars->post[$k];
					}
									
					break;
					
				case "int":
					
					if(!$this->shexp->isValidNum($this->vars->post[$k])) continue;
					$insert["field"][$k] = $this->vars->post[$k];
					
					break;
					
				case "boolean":
					
					if(isset($this->vars->post[$k]) && empty($this->vars->post[$k])) continue;
					$insert["field"][$k] = $this->vars->post[$k] == "true" ? true : false ;
					
					break;
			}
		}
		
		return $insert;
	}
}