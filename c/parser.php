<?php

class ParserController extends Controller{
	
	private $model;
	
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
			$this->render->ahref(array("controller" => "parser", "method" => "add"), "Добавить")
		);
		
		//
		
		$parsers = $this->modelStandalone->gets("parser", array("name" => 1, "active" => 1, "type" => 1, "link" => 1));
		
		foreach($parsers AS $parser){
			
			$temp["name"] = $parser["name"];
			$temp["type"] = $parser["type"];
			$temp["link"] = $parser["link"];
			$temp["active"] = ($parser["active"]) ? "true" : "false" ;
			$temp["style"] = ($parser["active"]) ? "green" : "red" ;
			
			$temp["action"] = array(
				"edit" => $this->render->ahref(array("controller" => "parser", "method" => "edit", "_id" => $parser["_id"]), "Редактировать"),
				"delete" => $this->render->ahref(array("controller" => "parser", "method" => "del", "_id" => $parser["_id"]), "Удалить")
			);
			
			$this->data["parser"][] = $temp;
		}
		
		//
		
		$this->data["title"] = "Парсеры";
		$this->template = "parser/list";
	}
	
	//
	
	private function del(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//
			$this->list();
			return;
		}
		
		//
		
		if(!$this->modelStandalone->idExists("parser", $this->vars->get["_id"])){
			//
			$this->list();
			return;
		}
		
		//
		
		$this->modelStandalone->del("parser", $this->vars->get["_id"]);
		
		//
		
		$this->data["success"][] = "Парсер удалён";
		$this->list();
	}
	
	//
	
	private function edit(){
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!$result = $this->modelStandalone->get("parser", $this->vars->get["_id"])){
			//maybe some logs
			$this->list();
			return;
		}
		
		//
		
		if(!empty($this->vars->post)){
			
			if($data = $this->checkPost()){
				
				$this->modelStandalone->update("parser", $this->vars->get["_id"], $data);
				
				$this->data["success"][] = "Парсер обновлён";
				
				$this->vars->realCleanPost(true);
				
				$this->edit();
				
				return;
			}
		}
		
		//
		
		$_POST["name"] = empty($this->vars->post["name"]) ? $result["name"] : $this->vars->post["name"] ;
		$_POST["service"] = empty($this->vars->post["service"]) ? $result["service"] : $this->vars->post["service"] ;
		$_POST["type"] = empty($this->vars->post["type"]) ? $result["type"] : $this->vars->post["type"] ;
		$_POST["method"] = empty($this->vars->post["method"]) ? $result["method"] : $this->vars->post["method"] ;
		$_POST["encode"] = empty($this->vars->post["encode"]) ? $result["encode"] : $this->vars->post["encode"] ;
		$_POST["link"] = empty($this->vars->post["link"]) ? $result["link"] : $this->vars->post["link"] ;
		$_POST["active"] = empty($this->vars->post["active"]) ? ($result["active"] ? "yes" : "no") : $this->vars->post["active"] ;
		$_POST["start"] = empty($this->vars->post["start"]) ? $result["start"] : $this->vars->post["start"] ;
		$_POST["login"] = empty($this->vars->post["login"]) ? $result["login"] : $this->vars->post["login"] ;
		
		$_POST["imageresample"] = empty($this->vars->post["imageresample"]) ? ($result["imageresample"] ? "yes" : "no") : $this->vars->post["imageresample"] ;
		
		$_POST["imagewidth"] = empty($this->vars->post["imagewidth"]) ? $result["image"]["width"] : $this->vars->post["imagewidth"] ;
		$_POST["imageheight"] = empty($this->vars->post["imageheight"]) ? $result["image"]["height"] : $this->vars->post["imageheight"] ;
		
		$_POST["imager"] = empty($this->vars->post["imager"]) ? $result["image"]["r"] : $this->vars->post["imager"] ;
		$_POST["imageg"] = empty($this->vars->post["imageg"]) ? $result["image"]["g"] : $this->vars->post["imageg"] ;
		$_POST["imageb"] = empty($this->vars->post["imageb"]) ? $result["image"]["b"] : $this->vars->post["imageb"] ;
		
		if(isset($result["field"])){
			
			foreach($result["field"] AS $k=>$v){
				
				foreach($v AS $kk=>$vv){
					
					$_POST[sprintf("%s_%s", $k, $kk)] = isset($_POST[sprintf("%s_%s", $k, $kk)]) ? $_POST[sprintf("%s_%s", $k, $kk)] : $vv;
				}
			}
		}
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "parser"), "Список парсеров"),
			$this->render->ahref(array("controller" => "parser", "method" => "del", "_id" => $this->vars->get["_id"]), "Удалить текущий парсер")
		);
		
		//
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "parser", "method" => "edit", "_id" => $this->vars->get["_id"]));
		
		//
		
		$this->data["title"] = "Обновить";
		$this->template = "parser/form";
	}
	
	//
	
	private function add(){
		
		if(!empty($this->vars->post)){
			
			if($data = $this->checkPost()){
				
				$this->modelStandalone->insert("parser", $data);
				
				$this->data["success"][] = "Парсер добавлен";
				
				$this->list();
				
				return;
			}
		}
		
		//
		
		$this->data["bread"] = array(
			$this->render->ahref(array("controller" => "parser"), "Список парсеров")
		);
		
		$this->data["formAction"] = $this->render->linker(array("controller" => "parser", "method" => "add"));
		
		//
		
		$this->data["title"] = "Добавить";
		$this->template = "parser/form";
	}	private function checkPost(){
		
		$insert = array();
		
		//
		
		if($this->shexp->isValidTitle($this->vars->post["name"])) $insert["name"] = $this->vars->post["name"];
		else{
			$this->data["attention"][] = "В названии парсера не допустимые символы";
			return false;
		}
		
		if($this->shexp->isValidService($this->vars->post["service"])) $insert["service"] = $this->vars->post["service"];
		else{
			$this->data["attention"][] = "В названии сервиса не допустимые символы";
			return false;
		}
		
		if($this->vars->post["type"] == "usually" || $this->vars->post["type"] == "trigger") $insert["type"] = $this->vars->post["type"];
		else{
			$this->data["attention"][] = "Тип указан не верно";
			return false;
		}
		
		if($this->vars->post["method"] == "GET" || $this->vars->post["method"] == "POST") $insert["method"] = $this->vars->post["method"];
		else{
			$this->data["attention"][] = "Метод указан не верно";
			return false;
		}
		
		if($this->vars->post["encode"] == "json" || $this->vars->post["encode"] == "xml") $insert["encode"] = $this->vars->post["encode"];
		else{
			$this->data["attention"][] = "Формат указан не верно";
			return false;
		}
		
		if($this->vars->post["active"] == "yes" || $this->vars->post["active"] == "no") $insert["active"] = ($this->vars->post["active"] == "yes" ? true: false);
		else{
			$this->data["attention"][] = "Активность указана не верно";
			return false;
		}
		
		if($this->shexp->isValidLink($this->vars->post["link"])) $insert["link"] = $this->vars->post["link"];
		else{
			$this->data["attention"][] = "Link указан не верно";
			return false;
		}


		$insert["start"] = $this->shexp->isValidPath($this->vars->post["start"]) ? $this->vars->post["start"] : "";

		
		if($this->shexp->isValidPath($this->vars->post["login"])) $insert["login"] = $this->vars->post["login"];
		else{
			$this->data["attention"][] = "Путь к логину не указан или не валидный";
			return false;
		}
		
		//
		
		if($this->vars->post["imageresample"] == "yes" || $this->vars->post["imageresample"] == "no") $insert["imageresample"] = ($this->vars->post["imageresample"] == "yes" ? true : false);
		else{
			$this->data["attention"][] = "Image resample указан не верно";
			return false;
		}
		
		//
		
		if($this->vars->post["imageresample"] == "yes"){
			
			if($this->shexp->isValidNum($this->vars->post["imagewidth"]) && (int) $this->vars->post["imagewidth"] > 50 && (int) $this->vars->post["imagewidth"] < 2000) $insert["image"]["width"] = (int) $this->vars->post["imagewidth"];
			else{
				$this->data["attention"][] = "Ширина для ресайза указан не верно";
				return false;
			}
			
			if($this->shexp->isValidNum($this->vars->post["imageheight"]) && (int) $this->vars->post["imageheight"] > 50 && (int) $this->vars->post["imageheight"] < 2000) $insert["image"]["height"] = (int) $this->vars->post["imageheight"];
			else{
				$this->data["attention"][] = "Высота для ресайза указан не верно";
				return false;
			}
			
			//
			
			if($this->shexp->isValidNum($this->vars->post["imager"]) && (int) $this->vars->post["imager"] >= 0 && (int) $this->vars->post["imager"] <= 255) $insert["image"]["r"] = (int) $this->vars->post["imager"];
			else{
				$this->data["attention"][] = "R канал указан не верно";
				return false;
			}
			
			if($this->shexp->isValidNum($this->vars->post["imageg"]) && (int) $this->vars->post["imageg"] >= 0 && (int) $this->vars->post["imageg"] <= 255) $insert["image"]["g"] = (int) $this->vars->post["imageg"];
			else{
				$this->data["attention"][] = "G канал указан не верно";
				return false;
			}
			
			if($this->shexp->isValidNum($this->vars->post["imageb"]) && (int) $this->vars->post["imageb"] >= 0 && (int) $this->vars->post["imageb"] <= 255) $insert["image"]["b"] = (int) $this->vars->post["imageb"];
			else{
				$this->data["attention"][] = "B канал указан не верно";
				return false;
			}
		}
		else{
			$insert["image"]["width"] = 0;
			$insert["image"]["height"] = 0;
			$insert["image"]["r"] = 0;
			$insert["image"]["g"] = 0;
			$insert["image"]["b"] = 0;
		}
		
		//
		
		foreach($this->fields AS $k=>$v){
			
			$tmp = array();
			
			if(empty($this->vars->post[sprintf("%s_path", $k)])) continue;
			
			if($this->shexp->isValidPath($this->vars->post[sprintf("%s_path", $k)])){
				
				$tmp["path"] = $this->vars->post[sprintf("%s_path", $k)];
				// ALL IFS MUST BE SAFED
				if(!empty($this->vars->post[sprintf("%s_regexp", $k)])) $tmp["regexp"] = $this->vars->post[sprintf("%s_regexp", $k)];
				if(!empty($this->vars->post[sprintf("%s_required", $k)])) $tmp["required"] = true;
				if(!empty($this->vars->post[sprintf("%s_delimiter", $k)])) $tmp["delimiter"] = $this->vars->post[sprintf("%s_delimiter", $k)];
				if(!empty($this->vars->post[sprintf("%s_url", $k)])) $tmp["url"] = $this->vars->post[sprintf("%s_url", $k)];
				
				$insert["field"][$k] = $tmp;
			}
			else{
				$this->data["attention"][] = sprintf("Недопустимый %s_path ", $k);
				return false;
			}
		}
		
		//
		
		return $insert;
	}
}