<?php

// 初始化系统常量
defined('ROOT') or define('ROOT', __DIR__.'/');
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('APP_DEBUG') or define('APP_DEBUG', false);
defined('CONFIG_PATH') or define('CONFIG_PATH', APP_PATH.'config/');
defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH.'runtime/');

// 文件扩展名
const EXT = '.php';

// 包含核心框架类
require 'Core.php';

// 实例化核心
$lens = new Lens;
$lens->run();

