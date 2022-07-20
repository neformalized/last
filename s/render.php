<?php

class Render{
	
	public function ahref($array, $name, $id = "", $class = ""){
		
		$link = $this->linker($array);
		
		//
		
		$id = !empty($id) ? sprintf(" id=\"%s\"", $id) : "";
		$class = !empty($class) ? sprintf(" class=\"%s\"", $class) : "";
		
		//
		
		$pattern = "<a href=\"%s\"%s%s>%s</a>";
		
		//
		
		return sprintf($pattern, $link, $id, $class, $name);
	}
	
	public function ahrefv2($host, $array, $name){
		
		return sprintf("<a href=\"%s%s\">%s</a>", $host, $this->linker($array), $name);
	}
	
	public function linker($array){
		
		$return = "";
		
		foreach($array AS $k=>$v) $return .= sprintf("%s=%s&", $k, $v);
		
		return sprintf("?%s", substr($return, 0, -1));
	}
	
	public function jsr($path){
		
		return sprintf("<script src=\"v/js/%s.js\"></script>", $path);
	}
}