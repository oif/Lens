<?php

class Route {

	private $routes;

	function __construct() {
		$this->routes = array();
	}

    public function set($route, $target) {
    	$this->routes[$route] = $target;
    }

    public function find($route) {
    	if (array_key_exists($route, $this->routes)) {
    		return $this->routes[$route];
    	}
    }
}

