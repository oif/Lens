<?php

class Controller {

    protected $controller;
    protected $action;
    protected $view;

    // 构造函数，初始化属性，并实例化对应模型
    function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
        $this->view = new View($controller, $action);
    }

    function __destruct() {
        $this->view->render();
    }

}