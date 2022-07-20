<?php

class Fields{

	public function __construct(){
		
		$this->extid = $this->create("int");
		$this->status = $this->create("string");
		$this->username = $this->create("string");
		$this->displayname = $this->create("string");
		$this->platform = $this->create("string", true);
		$this->rate = $this->create("int");
		$this->new = $this->create("boolean");
		$this->gender = $this->create("string");
		$this->age = $this->create("int", false, false);
		$this->birth = $this->create("date");
		$this->lang = $this->create("string", true);
		$this->sublang = $this->create("string", true);
		$this->country = $this->create("string");
		$this->hiddenregions = $this->create("string", true);
		$this->tags = $this->create("string", true);
		$this->desc = $this->create("string");
		$this->ava = $this->create("string", false, true);
		$this->snap = $this->create("string", false, true);
		$this->prevs = $this->create("string", true, true);
		$this->starttime = $this->create("string");
		$this->quality = $this->create("string", true, false);
		$this->mobile = $this->create("boolean");
		$this->toy = $this->create("boolean");
		$this->link = $this->create("string");
		$this->params = $this->create("string", true);
		$this->ethnic = $this->create("string");
		$this->eyes = $this->create("string");
		$this->hair = $this->create("string");
		$this->height = $this->create("string");
		$this->body = $this->create("string");
		$this->b = $this->create("string");
		$this->a = $this->create("string");
		$this->ptype = $this->create("string");
		$this->sizec = $this->create("int");
		$this->cutted = $this->create("boolean");
	}
	
	public function charge($settings){ // i mean this settings MUST BE SAFED before now
		
		foreach($settings AS $name=>$setting){
			
			$this->$name->status = true;
			
			foreach($setting AS $key=>$value) $this->$name->$key = $value;
			
			if(!isset($this->$name->required)) $this->$name->required = false;
		}
	}
	
	//
	
	private function create($type, $array = false, $img = false){
		
		$created = (object) array();
		
		//
		
		$created->type = $type;
		$created->status = false;
		$created->isArray = $array;
		$created->isImage = $img;
		$created->regexp = null;
		
		//
		
		return $created;
	}
}