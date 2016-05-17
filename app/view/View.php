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

    function render() {
        include (APP_PATH . 'app/views/api.php');
    }

}