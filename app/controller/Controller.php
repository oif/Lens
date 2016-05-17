<?php

class Controller {
    protected $controller;
    protected $action;
    protected $view;    // 视图实力化
    protected $returnView;  // 自定义视图

    function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
        $this->view = new View();
    }

    function __destruct() {
        $this->view->render($this->returnView); // 设定的返回视图
    }

}

