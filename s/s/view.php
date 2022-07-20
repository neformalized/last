<?php

class View{
	
	public function __construct($template, $data){
		
		foreach($data AS $key=>$value) $$key = $value;
		
		require_once(sprintf("%s%s", TPL, "main/head.tpl"));
		require_once(sprintf("%s%s%s.tpl", TPL, "template/", $template));
		require_once(sprintf("%s%s", TPL, "main/foot.tpl"));
	}
}