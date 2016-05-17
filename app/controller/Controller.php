<?php

class Controller {
    protected $controller;
    protected $action;
    protected $view;    // 视图实力化
    protected $returnView;  // 自定义视图

    function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
        $this->view = new View;
    }

    function __destruct() {
        $this->view->render($this->returnView); // 设定的返回视图
    }


    public function __call($name, $args) {
        $field = preg_match('/^push(\w+)/', $name, $matches);
        if ($field && $matches[1]) {
            $matches[1] = lcfirst($matches[1]); // 调整命名规则（驼峰）
            return $this->view->$matches[1] = $args[0];
        }
    }

    protected function view($view) {
        $this->returnView = $view;
    }

}

