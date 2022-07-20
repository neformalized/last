<?php

class ApiController extends Controller{
	
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
			$this->render->ahref(array("controller" => "api", "method" => "add"), "Добавить")
		);
		
		//
		
		$apis = $this->modelStandalone->gets("api", array("name" => 1, "service" => 1, "active" => 1, "limit" => 1));
		
		foreach($apis AS $api){
			
			$temp["name"] = $api["name"];
			$temp["service"] = empty($api["service"]) ? "-" : $api["service"];
			$temp["limit"] = $api["limit"];
			$temp["active"] = ($api["active"]) ? "true" : "false" ;
			$temp["style"] = ($api["active"]) ? "green" : "red" ;
			
			$temp["action"] = array(
				"edit" => $this->render->ahref(array("controller" => "api", "method" => "edit", "_id" => $api["_id"]), "Редактировать"),
				"del" => $this->render->ahref(array("controller" => "api", "method" => "del", "_id" => $api["_id"]), "Удалить"),
				"backend" => $this->render->ahrefv2("backend.php", array("api" => $api["_id"], "debug" => "true"), "Дебаг")
			);
			
			$this->data["api"][] = $temp;
		}
		
		//
		
		$this->data["title"] = "Api";
		$this->template = "api/list";
	}
	
	//
	
	private function del(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!$this->modelStandalone->idExists("api", $this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		$this->modelStandalone->del("api", $this->vars->get["_id"]);
		
		//
		
		$this->data["success"][] = "Api удалено";
		$this->list();
	}
	
	//
	
	private function add(){
		
		if(!empty($this->vars->post)){
			
			if($data = $this->checkPost()){
				
				$this->modelStandalone->insert("api", $data);
				
				$this->data["success"][] = "Api добавлено";
				
				$this->list();
				
				return;
			}
		}
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "api"), "Список Api")
		);
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "api", "method" => "add"));
		
		//
		
		$this->data["title"] = "Добавить";
		$this->template = "api/form";
	}
	
	//
	
	private function edit(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!$result = $this->modelStandalone->get("api", $this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!empty($this->vars->post)){
			
			if($data = $this->checkPost()){
				
				$this->modelStandalone->update("api", $this->vars->get["_id"], $data);
				
				$this->data["success"][] = "Api обновлено";
				
				$this->vars->realCleanPost(true);
				
				$this->edit();
				
				return;
			}
		}
		
		//
		
		$_POST["name"] = empty($this->vars->post["name"]) ? $result["name"] : $this->vars->post["name"] ;
		$_POST["service"] = empty($this->vars->post["service"]) ? $result["service"] : $this->vars->post["service"] ;
		$_POST["limit"] = empty($this->vars->post["limit"]) ? $result["limit"] : $this->vars->post["limit"] ;
		$_POST["cache"] = empty($this->vars->post["cache"]) ? $result["cache"] : $this->vars->post["cache"] ;
		$_POST["active"] = empty($this->vars->post["active"]) ? ($result["active"] ? "yes" : "no") : $this->vars->post["active"] ;
		
		//
		
		if(isset($result["condition"])){
			
			foreach($result["condition"] AS $k=>$v){
				
				if(is_array($v)){
					if(isset($v["a"])) $_POST[sprintf("%s_condition_a", $k)] = $v["a"];
					if(isset($v["b"])) $_POST[sprintf("%s_condition_b", $k)] = $v["b"];
				}
				else $_POST[sprintf("%s_condition", $k)] = $v === false ? "false" : $v ;
			}
		}
		
		if(isset($result["projection"])){ foreach($result["projection"] AS $value) $_POST[sprintf("%s_project", $value)] = "1"; }
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "api"), "Список api"),
			$this->render->ahref(array("controller" => "api", "method" => "del", "_id" => $this->vars->get["_id"]), "Удалить текущий api")
		);
		
		//
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "api", "method" => "edit", "_id" => $this->vars->get["_id"]));
		
		//
		
		$this->data["title"] = "Обновить";
		$this->template = "api/form";
	}
	
	//
	
	private function checkPost(){
		
		$insert = array();
		
		//
		
		if($this->shexp->isValidTitle($this->vars->post["name"])) $insert["name"] = $this->vars->post["name"];
		else{
			$this->data["attention"][] = "В названии api не допустимые символы";
			return false;
		}
		
		if(isset($this->vars->post["service"]) && !empty($this->vars->post["service"])){
			
			if($this->shexp->isValidService($this->vars->post["service"])) $insert["service"] = $this->vars->post["service"];
			else{
				$this->data["attention"][] = "В названии сервиса не допустимые символы";
				return false;
			}
			
		}else $insert["service"] = "";
		
		if($this->shexp->isValidNum($this->vars->post["limit"]) && (int) $this->vars->post["limit"] > 0 && (int) $this->vars->post["limit"] < 1001) $insert["limit"] = $this->vars->post["limit"];
		else{
			$this->data["attention"][] = "Limit указан не верно";
			return false;
		}
		
		if($this->shexp->isValidNum($this->vars->post["cache"]) && (int) $this->vars->post["cache"] > 0) $insert["cache"] = (int) $this->vars->post["cache"];
		else{
			$this->data["attention"][] = "Время кеширования задано не верно";
			return false;
		}
		
		if($this->vars->post["active"] == "yes" || $this->vars->post["active"] == "no") $insert["active"] = ($this->vars->post["active"] == "yes" ? true: false);
		else{
			$this->data["attention"][] = "Активность указана не верно";
			return false;
		}
		
		//
		
		foreach($this->fields AS $k=>$v){
			
			if(isset($this->vars->post[sprintf("%s_project", $k)])) $insert["projection"][] = $k;
			
			//
			
			if(isset($this->vars->post[sprintf("%s_condition", $k)]) || isset($this->vars->post[sprintf("%s_condition_a", $k)]) || isset($this->vars->post[sprintf("%s_condition_b", $k)])){
				
				switch($v->type){
					case "string":
					
						if(!$this->shexp->isValidTitle($this->vars->post[sprintf("%s_condition", $k)])) continue;
						$insert["condition"][$k] = $this->vars->post[sprintf("%s_condition", $k)];
						break;
						
					case "int":
						
						$tmp = array();
					
						$a = $this->vars->post[sprintf("%s_condition_a", $k)];
						$b = $this->vars->post[sprintf("%s_condition_b", $k)];
						
						//
						
						if(!empty($a)){
							if(!$this->shexp->isValidNum($a)) continue;
							$tmp["a"] = (int) $a;
						}
						
						if(!empty($b)){
							if(!$this->shexp->isValidNum($b)) continue;
							$tmp["b"] = (int) $b;
						}
						
						//
						
						if(!empty($tmp)) $insert["condition"][$k] = $tmp;
						
						break;
						
					case "boolean":
						
						if(isset($this->vars->post[sprintf("%s_condition", $k)]) && empty($this->vars->post[sprintf("%s_condition", $k)])) continue;
						$insert["condition"][$k] = $this->vars->post[sprintf("%s_condition", $k)] == "true" ? true : false ;
						break;
						
				}
				//
			}
			//
		}
		//
		
		if(!isset($insert["condition"])) $insert["condition"] = array();
		return $insert;
	}
}