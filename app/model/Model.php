<?php

class Model {
	protected $properties = array();
	protected $table;
    protected $db;
    protected $_result;


	public function __get($property) {
		if (array_key_exists($property, $this->properties)) {	// 检测是否存在
			return $this->properties[$property];
		}
	}

	public function __set($property, $value) {
		$this->properties[$property] = $value;
	}

    function __construct() {
        // 获取数据库实例
        $this->db = SQL::getInstance();

        // 根据类名获得表名，命名规则例如 User 则表名为 users
        $this->table = strtolower(get_class($this).'s');
	}

    function selectAll() {	// 所有结果
        $query = 'select * from `'.$this->table.'`';
        return $this->query($query);
    }

    function select($id) {	//	根据 ID 查询
        $query = 'select * from `'.$this->table.'` where `id` = \''.$id.'\'';
        return $this->query($query);
    }

    function delete($id) {	// 根据 ID 删除
        $query = 'delete from `'.$this->table.'` where `id` = \''.$id.'\'';
        return $this->query($query);
    }

    function query($query) {	// SQL
        $this->_result = self::$_dbHandle->query($query);
        if (preg_match("/select/i",$query)) {
            return $this->_result->fetch_array();
        }
        return $this->_result;
    }

    function getError() {	// 错误信息
        return mysqli_error($this->db);
    }

}

