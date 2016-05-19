<?php

/**
 * Lens 核心框架
 */
class Lens {

    private $route;

    // 运行程序
    function run() {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setRoutes();
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->callHook();
    }

    // 主请求方法，主要目的是拆分URL请求
    function callHook() {
        if (!empty($_SERVER['REQUEST_URI'])){
            $url = $_SERVER['REQUEST_URI'];
            $urlArray = explode("/",$url);

            $target = $this->route->find($url);
            if ($target) {
                $target = explode("@", $target);
            }
            $controller = empty($target[0]) ? 'IndexController' : $target[0];
            $action = empty($target[1]) ? 'index' : $target[1];

            //获取URL参数
            array_shift($urlArray);
            $queryString = empty($urlArray) ? array() : $urlArray;
        }

        // 数据为空的处理
        $action = empty($action) ? 'index' : $action;
        $queryString  = empty($queryString) ? array() : $queryString;

        // 实例化控制器
        $int = new $controller();

        // 如果控制器存和动作存在，这调用并传入URL参数
        if ((int)method_exists($controller, $action)) {
            call_user_func_array(array($int, $action), $queryString);
        }
    }

    function setRoutes() {
        $this->route = new Route;
        // $this->route->set('/user/register', 'UserController@register');
        // $this->route->set('/user/login', 'UserController@login');
    }


    // 设置 DEBUG 模式
    function setReporting() {
        error_reporting(E_ALL);
        if (APP_DEBUG == true) {
            ini_set('display_errors','On');
        } else {
            ini_set('display_errors','Off');    // 不报错
        }
    }

    // 删除敏感字符
    function stripSlashesDeep($value) {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
        return $value;
    }

    // 检测敏感字符并删除
    function removeMagicQuotes() {
        if ( get_magic_quotes_gpc() ) {
            $_GET = stripSlashesDeep($_GET);
            $_POST = stripSlashesDeep($_POST);
            $_COOKIE = stripSlashesDeep($_COOKIE);
            $_SESSION = stripSlashesDeep($_SESSION);
        }
    }

    // 检测自定义全局变量（register globals）并移除
    function unregisterGlobals() {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    //自动加载控制器和模型类
    static function loadClass($class) {
        $frameworks = ROOT . $class . EXT;
        $controllers = APP_PATH . 'app/controller/' . $class . EXT;
        $models = APP_PATH . 'app/model/' . $class . EXT;
        $view = APP_PATH . 'app/view/View.php';

        if (file_exists($frameworks)) {
            include $frameworks;    // 加载框架核心类
        } elseif (file_exists($controllers)) {
            include $controllers;   // 加载应用控制器类
        } elseif (file_exists($models)) {
            include $models;    // 加载应用模型类
        } elseif (file_exists($view)) {
            include $view;  // 加载基础视图类
        } else {
            /* 错误代码 */
        }
    }

}

