<?php

class Route{

	public function __construct($bundle){
		
		// software defaults
		
		$defaultController = "api";
		$defaultMethod = "def";
		
		$controllerAfterfix = "controller";
		
		// check inputs
		
		$controller = isset($bundle->vars->get["controller"]) && $bundle->shexp->isValidName($bundle->vars->get["controller"]) ? strtolower($bundle->vars->get["controller"]) : $defaultController ;
		$method = isset($bundel->vars->get["method"]) && $bundle->shexp->isValidName($bundle->vars->get["method"]) ? strtolower($bundle->vars->get["method"]) : $defaultMethod ;
		
		// check file and include
		
		$controller = file_exists(sprintf("%s%s.php", CTRL, $controller)) ? $controller : $defaultController ;
		
		require_once(sprintf("%s%s.php", CTRL, $controller));
		
		// check method
		
		$controller = sprintf("%s%s", $controller, $controllerAfterfix);
		
		if(!method_exists($controller, $method)) $method = $defaultMethod;
		
		// workout
		
		$class = new $controller($bundle);
		$class->$defaultMethod(); // ATTENTION, this can be changed from to $_GET
		
		// render
		
		$view = new View($class->template, $class->data);
	}
}