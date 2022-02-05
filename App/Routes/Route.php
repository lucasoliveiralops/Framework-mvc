<?php

namespace App\Routes;

class Route {
	private $routes;
	private $routeController =  "App\\Controller\\";
	private $routeConfig = "App\\Routes\\configRoutes.json";

	public function __construct() {
		$this->initRoutes();
		$this->run($this->getUrl());
	}
	public function getRoutes() {
		return $this->routes;
	}

	public function getUrl(){
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}

	public function setRoutes(array $routes){
		$this->routes = $routes;
	}

	public function initRoutes(){
		if(file_exists($this->routeConfig)){
			$routes = file_get_contents($this->routeConfig);
			$routes = \App\Lib\Util::jsonDecode($routes);
		}
		$this->setRoutes($routes);
	}

	public function run($url){
		foreach ($this->getRoutes() as $key => $route){
			if($url == $route['route']){
				$class = $this->routeController . ucfirst($route['controller']);
				$method = $route['method'];
				$controller = new $class;
				$controller->$method();
				return;
			}
		}
		$this->notFoundRoute();
	}

	public function notFoundRoute(){
		header('Location: /404');
		exit();
	}
}