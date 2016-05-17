<?php

// 初始化系统常量
defined('ROOT') or define('ROOT', __DIR__.'/');
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('APP_DEBUG') or define('APP_DEBUG', false);

// 文件扩展名
const EXT = '.php';

// 包含核心框架类
require 'Core.php';

// 实例化核心
$lens = new Lens;
$lens->run();

