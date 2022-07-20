<?php

class ExecuteController extends Controller{
	
	private $schedule;
	private $parser;
	private $trigger;
	private $mode;
	private $proxyes;
	private $param;
	
	private $standalone;
	
	private $tool_parser;
	
	public function def(){
		
		$this->data["title"] = "Парсинг";
		$this->template = "execute/def";
		
		$this->data["bread"][] = $this->render->ahref(array("controller" => "schedule"), "Планировки");
		
		//
		
		$this->tool_parser = $this->loader->controller("tool/parser", "Parser");
		$this->loger = $this->loader->controller("tool/loger", "Loger");
		
		$this->loger->create("Парсинг");
		
		// check and prepare
		
		$this->loger->lead("inf", "Проверка входящих данных");
		
		if(!$this->shexp->isValidMongoId($this->vars->get["_id"])){
			$this->data["error"][] = "Невалидный id планировки";
			$this->loger->lead("msg", "Невалидный id планировки");
			$this->modelStandalone->insert("log", $this->loger->complete(false));
			return;
		}
		
		// load schedule
		
		if(!$this->schedule = $this->modelStandalone->get("schedule", $this->vars->get["_id"])){
			$this->data["error"][] = "Планировка не существует в базе";
			$this->loger->lead("msg", "Планировка не существует в базе");
			$this->modelStandalone->insert("log", $this->loger->complete(false));
			return;
		}
		
		// check parser
		
		$this->loger->lead("inf", "Проверка конфигурации планировки");
		
		if(!$this->checkParser()){
			$this->data["error"][] = "Конфигурация парсера нарушена";
			$this->modelStandalone->insert("log", $this->loger->complete(false));
			return;
		}
		
		// link to current schedule edit
		
		$this->data["bread"][] = $this->render->ahref(array("controller" => "schedule", "method" => "edit", "_id" => $this->vars->get["_id"]), "Редактировать текущую планировку");
		
		// prepare proxy
		
		$this->loger->lead("inf", "Загрузка и проверка прокси");	
		$this->prepareProxy();
		
		// check prepared
		
		if($this->schedule["proxyOnly"] && empty($this->proxyes)){
			$this->data["error"][] = "Нет валидных прокси в режиме PROXYONLY";
			$this->loger->lead("msg", "Нет валидных прокси в режиме PROXYONLY");
			$this->modelStandalone->insert("log", $this->loger->complete(false, $this->schedule["name"]));
			return;
		}
		
		// prepare params
		
		$this->prepareParams();
		$this->startLink = sprintf("%s%s", $this->parser["link"], (!empty($this->param) ? $this->render->linker($this->param) : ""));
		
		// parse source
		
		$this->loger->lead("inf", "Получение данных");
		
		if($this->schedule["proxyOnly"]){
			
			foreach($this->proxyes AS $proxy){
				
				if($result = $this->checkResult($this->startLink, $this->parser["method"], $this->parser["start"], $proxy)) break;
			}
			
			//
			
			if(!$result){
				$this->data["error"][] = "Прокси перестали отвечать к моменту парсинга(Возможно левая ссылка)";
				$this->loger->lead("msg", "Прокси перестали отвечать к моменту парсинга(Возможно левая ссылка)");
				$this->modelStandalone->insert("log", $this->loger->complete(false, $this->schedule["name"]));
				return;
			}
		}
		else{
			
			if(isset($this->proxyes) && !empty($this->proxyes)){
				
				foreach($this->proxyes AS $proxy){
				
					if($result = $this->checkResult($this->startLink, $this->parser["method"], $this->parser["start"], $proxy)) break;
				}	
			}
			
			//
			
			if(!isset($result) || !$result){
				if(!$result = $this->checkResult($this->startLink, $this->parser["method"], $this->parser["start"], array(/*proxy*/))){
					$this->data["error"][] = "Данные не получены(Проверить подключение сервера к сети интернет или ссылку в настройках парсера)";
					$this->loger->lead("msg", "Данные не получены(Проверить подключение сервера к сети интернет или ссылку в настройках парсера)");
					$this->modelStandalone->insert("log", $this->loger->complete(false, $this->schedule["name"]));
					return;
				}
			}
		}
		
		//
		
		$this->loger->lead("inf", "Извлечение данных");
		$this->corrupted = 0;
		
		if($this->mode == "trigger") $data = $this->byTrigger($result);
		if($this->mode == "usually") $data = $this->byUsually($result);
		
		//
		
		if($data){
			$this->loger->lead("inf", "Обработка данных");
			$this->handle($data);
		}
		else{
			$this->data["error"][] = "Отсутствуют данные для обработки";
			$this->modelStandalone->insert("log", $this->loger->complete(false, $this->schedule["name"]));
		}
	}
	
	private function handle($data){
		
		$this->modelExecute = $this->loader->model("execute", "ExecuteModel");
		
		//
		
		switch($this->schedule["function"]){
			case "clone":
				$action = "Клонировано";
				break;
			case "replace":
				$action = "Заменено";
				break;
			case "append":
				$action = "Обновлено";
				break;
			case "pass":
				$action = "Пропущено";
				break;
			default:
				$action = "Пропущено";
				break;
		}
		
		$new = 0;
		$func = 0;
		
		//
		
		foreach($data AS $row){
			
			if($this->modelExecute->dataExists($row["login"], $this->parser["service"])){
				
				$func++;
				
				switch($this->schedule["function"]){
					case "clone":
						$row["login"] = sprintf("_%s", $row["login"]);
						$this->modelStandalone->insert("data", $row);
						break;
					case "replace":
						$this->modelExecute->dataDelete($row["login"], $this->parser["service"]);
						$this->modelStandalone->insert("data", $row);
						// IMAGE KILLER
						break;
					case "append":
						$this->modelStandalone->update("data", array("login" => $row["login"], "service" => $this->parser["service"]), $row);
						// IMAGE KILLER IF IMAGE EXISTS
						break;
					case "pass":
						//pass
						break;
					default:
						//pass
						break;
				}
			}
			else{
				
				$new++;
				
				$this->modelStandalone->insert("data", $row);
			}
		}
		
		//
		
		$msg = sprintf("Добавлено - %s; %s - %s;", $new, $action, $func);
		
		//
		
		$this->modelStandalone->insert("log", $this->loger->complete(true, $this->schedule["name"], $msg));
		
		//
		
		$this->data["new"] = $new;
		$this->data["func"] = $func;		
		$this->data["func_name"] = $action;

		//
	}
	
	//
	
	private function byTrigger($data){
		
		//$this->checkSetting($this->trigger["field"]);
		$this->loger->lead("inf", "(Trigger mode)", true);
		
		$tmp = array();
		
		foreach($data AS $row){
			
			if($login = $this->dig($row, $this->parser["login"])){
				
				$link = sprintf(str_replace(MAGIC, "%s", $this->trigger["link"]), $login);
				
				if($this->schedule["proxyOnly"]){
					
					foreach($this->proxyes AS $proxy){
					
						if($result = $this->checkResult($link, $this->trigger["method"], $this->trigger["start"], $proxy)) break;
					}
			
					if($result) $tmp[] = $result;
				}
				else{
					
					foreach($this->proxyes AS $proxy){
				
						if($result = $this->checkResult($this->startLink, $this->trigger["method"], $this->trigger["start"], $proxy)) break;
					}
					
					if($result) $tmp[] = $result;
					else{
						
						if($result = $this->checkResult($this->startLink, $this->trigger["method"], $this->trigger["start"], array(/**/))) $tmp[] = $result;
					}
				}
			}
		}
		
		//
		
		if(empty($tmp)){
			$this->data["attention"][] = "Данные получены, но не имеют нужных параметров(Проверить login тригера)";
			$this->loger->lead("msg", "Данные получены, но не имеют нужных параметров(Проверить login тригера)");
			return false;
		}
		
		//
		
		$this->fields->charge($this->trigger["field"]);
		
		$insert = array();
		
		foreach($tmp AS $row){
			
			if($withdrawed = $this->withdraw($row)){
				
				$insert[] = $withdrawed;
			}
			else $this->corrupted++;
		}
		
		//
		
		if(empty($insert)){
			$this->data["warning"][] = "Из полученых данных не удалось ничего спарсить, совсем";
			$this->loger->lead("msg", "Из полученых данных не удалось ничего спарсить, совсем");
			return false;
		}
		else{
			$this->data["success"][] = "Данные спарсены";
			return $insert;
		}
	}
	
	private function byUsually($data){
		
		//$this->checkSetting($this->parser["field"]);
		$this->fields->charge($this->parser["field"]);
		
		$this->loger->lead("inf", "(Usually mode)", true);
		
		//
		
		$insert = array();
		
		foreach($data AS $row){
			
			if($withdrawed = $this->withdraw($row)){
				
				$insert[] = $withdrawed;
			}
			else $this->corrupted++;
		}
		
		if(empty($insert)){
			$this->data["warning"][] = "Из полученых данных не удалось ничего спарсить, совсем";
			$this->loger->lead("msg", "Из полученых данных не удалось ничего спарсить, совсем");
			return false;
		}
		else{
			$this->data["success"][] = "Данные спарсены"; 
			return $insert;
		}
	}
	
	//
	
	private function withdraw($array){
		
		$return = array();
		
		//
		
		if(!$login = $this->dig($array, $this->parser["login"])){
			$this->data["attention"][] = "Определяющий логин не был найден, пропуск парсинга текущей модели";
			$this->loger->lead("msg", "Определяющий логин не был найден, пропуск парсинга текущей модели");
			return false;
		}
		
		$return["login"] = $login;
		$return["service"] = $this->parser["service"];
		$return["active"] = true;
		$return["top"] = 0;
		$return["date"] = date("Y-m-d\TH:i:s.u");
		
		//
		
		$fields = array();
		
		//
		
		foreach($this->fields AS $key=>$obj){
			
			$tmp = array();
			
			//
			
			if(!$obj->status) continue;
			
			//
			
			if($key == "rate"){
				
				if($extracted = $this->magicExtractor($array, $obj)) $fields[$key] = $extracted;
				else{
					if($obj->required){
						$this->data["attention"][] = sprintf("Обязательное поле (%s) не было получено, сброс и пропуск парсинга текущей модели", $key);
						$this->loger->lead("msg", sprintf("Обязательное поле (%s) не было получено, сброс и пропуск парсинга текущей модели", $key));
						return false;
					}
				}
			}
			else{
				
				if($obj->isImage){
					
					if($extracted = $this->imageExtractor($array, $key, $obj)) $fields[$key] = $extracted;
					else{
						if($obj->required){
							$this->data["attention"][] = sprintf("Обязательное поле (%s) не было получено, сброс и пропуск парсинга текущей модели", $key);
							$this->loger->lead("msg", sprintf("Обязательное поле (%s) не было получено, сброс и пропуск парсинга текущей модели", $key));
							return false;
						}
					}
				}
				else{
					
					if($extracted = $this->simpleExtractor($array, $key, $obj)) $fields[$key] = ($extracted == "true" || $extracted == "false" ? ($extracted == "true" ? true : false ) : $extracted );
					else{
						if($obj->required){
							$this->data["attention"][] = sprintf("Обязательное поле (%s) не было получено, сброс и пропуск парсинга текущей модели", $key);
							$this->loger->lead("msg", sprintf("Обязательное поле (%s) не было получено, сброс и пропуск парсинга текущей модели", $key));
							return false;
						}
					}
				}
			}
		}
		
		$return["field"] = $fields;
		return $return;
	}
	
	//
	
	private function magicExtractor($array, $obj, $toArray = false){
		
		$pathes = explode(MAGIC, $obj->path);
		$regs = explode(MAGIC, $obj->regexp);
		
		if(!empty($regs[0])){
			if(count($regs) != count($pathes)){
				$this->data["attention"][] = "Magic extractor:(Число полей != числу выражений)";
				$this->loger->lead("msg", "Magic extractor:(Число полей != числу выражений)");
				return false;
			}
		}
		
		//
		
		$tmp = array();
		
		for($i = 0; $i < count($pathes); $i++){
			
			if(!$diged = $this->dig($array, $pathes[$i])) continue;
			if(is_array($diged)) continue;
			
			$tmp[] = !empty($regs[0]) ? $this->preg_r($diged, $regs[$i]) : $diged;
		}
		
		//
		
		if(empty($tmp)){
			$this->data["attention"][] = "Magic extractor:(Ни одно поле не было спарсено)";
			$this->loger->lead("msg", "Magic extractor:(Ни одно поле не было спарсено)");
			return false;
		}
		
		//
		
		$out = $toArray ? array() : 0;
		
		//
		
		foreach($tmp AS $value){
			
			if(!settype($value, $obj->type)) continue;
			
			if($toArray) array_push($out, $value);
			else $out += $value;
		}
		
		//
		
		if((is_array($out) && empty($out)) || $out == 0){
			$this->data["attention"][] = "Magic extractor:(Ни одно поле не подошло по типу)";
			$this->loger->lead("msg", "Magic extractor:(Ни одно поле не было спарсено)");
			return false;
		}
		
		//
		
		return $out;
	}
	
	private function simpleExtractor($array, $key, $obj){
		
		if(!$diged = $this->dig($array, $obj->path)) return false;
		
		//
		
		if($obj->isArray){
			
			$tmp = array();
			
			if(!is_array($diged)){
				
				$diged = $this->preg_r($diged, $obj->regexp);
				if(!settype($diged, $obj->type)) return false;
				$tmp[] = $diged;
			}
			else{
				
				foreach($diged AS $key=>$value){
					
					$value = $this->preg_r($value, $obj->regexp);
					if(!settype($value, $obj->type)) continue;
					$tmp[$key] = $value;
				}
			}
			
			return empty($tmp) ? false : $tmp;
		}
		else{
			
			if(is_array($diged)) return false;
			else{
				
				$diged = $this->preg_r($diged, $obj->regexp);
				
				if($obj->type == "date"){
					
					if(strtotime($diged) === false) return false;
					else return date($diged);
				}
				elseif($obj->type == "boolean"){}
				else{
					
					if(!settype($diged, $obj->type)) return false;
				}
				
				return $diged;
			}
		}
	}
	
	//
	
	private function imageExtractor($array, $key, $obj){
		
		switch($key){
			case "ava":
			
				if(!$link = $this->simpleExtractor($array, $key, $obj)){ return false; }
				if(!$string = $this->tool_parser->parseImg($this->preg_r($link, $obj->regexp))){
					echo $this->preg_r($link, $obj->regexp);
					return false;
				}
				//
				
				if($this->parser["imageresample"]) return $this->image->burn($this->image->build($string, $this->parser["image"]["width"], $this->parser["image"]["height"], $this->parser["image"]["r"], $this->parser["image"]["g"], $this->parser["image"]["b"]));
				else return $this->image->burn(imagecreatefromstring($string));
				
				//
				
				break;
				
			case "prevs":

				if(!$links = $this->magicExtractor($array, $obj, true)) return false;
				
				//
				
				$return = array();
				
				//
				
				foreach($links AS $link){
					
					if(!$string = $this->tool_parser->parseImg($this->preg_r($link, $obj->regexp))) continue;
					
					if($this->parser["imageresample"]) $return[] = $this->image->burn($this->image->build($string, $this->parser["image"]["width"], $this->parser["image"]["height"], $this->parser["image"]["r"], $this->parser["image"]["g"], $this->parser["image"]["b"]));
					else $return[] = $this->image->burn(imagecreatefromstring($string));
				}
				
				//
				
				return empty($return) ? false : $return;
				
				//
				
				break;
				
			case "snap":
				
				if(!$link = $this->simpleExtractor($array, $key, $obj)) return false;
				
				//
				
				if(isset($obj->url) && !empty($obj->url)){
					
					$url = str_replace(MAGIC, "%s", $this->url);
					$link = sprintf($url, $this->preg_r($link));
				}
				
				//
				
				if(!$string = $this->tool_parser->parseImg($link)) return false;
				
				//
				
				if($this->parser["imageresample"]) return $this->image->burn($this->image->build($string, $this->parser["image"]["width"], $this->parser["image"]["height"], $this->parser["image"]["r"], $this->parser["image"]["g"], $this->parser["image"]["b"]));
				else return $this->image->burn(imagecreatefromstring($string));
				
				//
				
				break;
		}
	}
	
	private function preg_r($value, $preg = null){
		
		if($preg == null) return $value;
		
		//
		
		$pregs = explode(MAGIC, $preg);
		
		//
		
		foreach($pregs AS $preg){
			
			if(strlen($preg) <= 1) continue;
			
			switch($preg[0]){
				case "+":
				
					preg_match_all(sprintf("/%s/", substr($preg, 1)), $value, $matches);
					if(isset($matches[1][0]) && !empty($matches[1][0])) $value = $matches[1][0];
					
					break;
				case "-":
				
					$value = str_replace(substr($preg, 1), "", $value);
				
					break;
			}
		}
		
		//
		
		return $value;
	}
	
	//
	
	private function checkResult($link, $method, $start, $proxy = array()){
		
		if(!$result = $this->tool_parser->parse($link, $method, $proxy)){
			$this->data["warning"][] = "Данные не были спарсены(пустой ответ)";
			$this->loger->lead("msg", "Данные не были спарсены(пустой ответ)");
			return false;
		}
		
		//
		
		$jsoned = json_decode($result, true);
		
		
		if(json_last_error() !== JSON_ERROR_NONE){
			$this->data["warning"][] = "Данные не соответствуют типу json";
			$this->loger->lead("msg", "Данные не соответствуют типу json");
			return false;
		}
		
		//
		
		if(!empty($start)){
			
			if(!$this->shexp->isValidPath($start)){
				$this->data["warning"][] = "\"Путь начала\" в настройках парсера испорчен";
				$this->loger->lead("msg", "\"Путь начала\" в настройках парсера испорчен");
				return false;
			}
			
			if(is_array($return = $this->dig($jsoned, $start))) return $return;
			else{
				$this->data["warning"][] = "Не удалось найти стартовый путь, либо пуст, либо не массив(\"путь начала\ в настройках парсера)";
				$this->loger->lead("msg", "Не удалось найти стартовый путь, либо пуст, либо не массив(\"путь начала\ в настройках парсера)");
				return false;
			}
		}
		else{
			
			if(empty($jsoned) || !is_array($jsoned)){
				$this->data["warning"][] = "Не удалось найти стартовый путь, либо пуст, либо не массив(\"путь начала\ в настройках парсера)";
				$this->loger->lead("msg", "Не удалось найти стартовый путь, либо пуст, либо не массив(\"путь начала\ в настройках парсера)");
				return false;
			}
			else return $jsoned;
		}
	}
	
	//
	
	private function prepareParams(){
		
		if(!isset($this->schedule["params"]) && empty($this->schedule["params"])) return;
		
		foreach($this->schedule["params"] AS $key=>$value){
			
			if(!$this->shexp->isValidKey($key)) continue;
			if(!$this->shexp->isValidValue($value)) continue;
			
			$this->param[$key] = $value;
		}
	}
	
	//
	
	private function prepareProxy(){
		
		if(!isset($this->schedule["proxyes"]) && empty($this->schedule["proxyes"])) return;
		
		foreach($this->schedule["proxyes"] AS $id){
			
			if($this->shexp->isValidMongoId($id) && $this->modelStandalone->idExists("proxy", $id)) $proxy = $this->modelStandalone->get("proxy", $id);
			else{
				$this->err[] = "Испорченные прокси";
				$this->loger->lead("msg", "Испорченные прокси");
				continue;
			}
			
			if(!$proxy["active"]) continue;
			
			//
			
			$this->modelStandalone->update("proxy", $id, $proxy = $this->proxy->check($proxy));
			
			//
			
			if($proxy["active"]) $this->proxyes[] = $proxy;
		}
	}
	
	//
	
	private function checkParser(){
		
		if(!$this->shexp->isValidMongoId($this->schedule["parser"])){
			$this->data["attention"][] = "Id парсера испорчен";
			$this->loger->lead("msg", "Id парсера испорчен");
			return false;
		}
		
		if(!$this->parser = $this->modelStandalone->get("parser", $this->schedule["parser"])){
			$this->data["attention"][] = "Парсер не существует";
			$this->loger->lead("msg", "Парсер не существует");
			return false;
		}
		
		//
		
		if(!$this->shexp->isValidService($this->parser["service"])){
			$this->data["attention"][] = "Парсер \"service\" испорчен";
			$this->loger->lead("msg", "Парсер не существует");
			return false;
		}
		
		//
		
		if(!$this->parser["active"]){
			$this->data["attention"][] = "Парсер выключен!";
			$this->loger->lead("msg", "Парсер выключен!");
			return false;
		}
		
		// check standart
		
		if(!in_array($this->parser["type"], array("usually", "trigger"))){
			$this->data["attention"][] = "Тип испорчен";
			$this->loger->lead("msg", "Тип испорчен");
			return false;
		}
		
		if(!in_array($this->parser["method"], array("POST", "GET"))){
			$this->data["attention"][] = "Метод испорчен";
			$this->loger->lead("msg", "Метод испорчен");
			return false;
		}
		
		if(!in_array($this->parser["encode"], array("json", "xml"))){
			$this->data["attention"][] = "Тип данных испорчен";
			$this->loger->lead("msg", "Тип данных испорчен");
			return false;
		}
		
		if(!$this->shexp->isValidLink($this->parser["link"])){
			$this->data["attention"][] = "Ссылка испорчена";
			$this->loger->lead("msg", "Ссылка испорчена");
			return false;
		}
		
		//
		
		if(!$this->shexp->isValidPath($this->parser["login"])){
			$this->data["attention"][] = "\"Путь к логину\" испорчен";
			$this->loger->lead("msg", "\"Путь к логину\" испорчен");
			return false;
		}
		
		
		// get trigger
		
		if(!empty($this->parser["trigger"])){
			
			if($this->shexp->isValidMongoId($this->parser["trigger"]) && $this->modelStandalone->idExists("parser", $this->parser["trigger"])) $this->trigger = $this->modelStandalone->get("parser", $this->parser["trigger"]);
			else $this->trigger = "";
		}
		else $this->trigger = "";
		
		//
		
		if($this->parser["imageresample"]){
			
			if(!$this->shexp->isValidNum($this->parser["image"]["width"]) || (int) $this->parser["image"]["width"] < 50 || (int) $this->parser["image"]["width"] > 2000){
			
				$this->data["attention"][] = "Ширина для ресайза указан не верно";
				$this->loger->lead("msg", "Ширина для ресайза указан не верно");
				return false;
			}
			
			if(!$this->shexp->isValidNum($this->parser["image"]["height"]) || (int) $this->parser["image"]["height"] < 50 || (int) $this->parser["image"]["height"] > 2000){
			
				$this->data["attention"][] = "Высота для ресайза указан не верно";
				$this->loger->lead("msg", "Высота для ресайза указан не верно");
				return false;
			}
			
			//
			
			if(!$this->shexp->isValidNum($this->parser["image"]["r"]) || (int) $this->parser["image"]["r"] < 0 || (int) $this->parser["image"]["r"] > 255){
				$this->data["attention"][] = "R канал указан не верно";
				$this->loger->lead("msg", "R канал указан не верно");
				return false;
			}
			
			if(!$this->shexp->isValidNum($this->parser["image"]["g"]) || (int) $this->parser["image"]["g"] < 0 || (int) $this->parser["image"]["g"] > 255){
				$this->data["attention"][] = "G канал указан не верно";
				$this->loger->lead("msg", "G канал указан не верно");
				return false;
			}
			
			if(!$this->shexp->isValidNum($this->parser["image"]["b"]) || (int) $this->parser["image"]["b"] < 0 || (int) $this->parser["image"]["b"] > 255){
				$this->data["attention"][] = "B канал указан не верно";
				$this->loger->lead("msg", "B канал указан не верно");
				return false;
			}
		}
		
		// check emptyness
		
		if(empty($this->trigger) && empty($this->parser["field"])){
			$this->data["attention"][] = "Нет настроек значений [field] для парсинга";
			$this->loger->lead("msg", "Нет настроек значений [field] для парсинга");
			return false;
		}
		
		// final

		if(empty($this->trigger)) $this->mode = "usually";
		else $this->mode = "trigger";
		
		//
		
		return true;
	}
	
	private function dig($array, $path){
		
		$parts = explode("/", $path);
		
		foreach($parts AS $part){
			if(!isset($array[$part])) return false;
			$array = ($array[$part] === true || $array[$part] === false) ? ($array[$part] ? "true" : "false") : $array[$part] ;
		}
		
		return $array;
	}
}