<?php

class View {
    protected $properties = array();

    public function __get($property) {
        if (array_key_exists($property, $this->properties)) {   // 检测是否存在
            return $this->properties[$property];
        }
    }

    public function __set($property, $value) {
        $this->properties[$property] = $value;
    }

    function render($view) { // 输出
        extract($this->properties);
        if (is_null($view)) {
            $view = 'api';
            $res = 'Empty';
        }
        include (APP_PATH . "app/view/$view.php");  // 自定义视图
    }

}

