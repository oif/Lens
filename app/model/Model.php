<?php

class Model extends SQL {
	protected $properties = array();
	protected $table;

	public function __get($property) {
		if (array_key_exists($property, $this->properties)) {	// 检测是否存在
			return $this->properties[$property];
		}
	}

	public function __set($property, $value) {
		$this->properties[$property] = $value;
	}

	function __construct() {
		// 连接数据库
        $this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // 根据类名获得表名，命名规则例如 User 则表名为 users
        $this->table = strtolower(get_class($this).'s');
	}

}

