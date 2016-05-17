<?php

class SQL {
    protected $_dbHandle;
    protected $_result;

    function connect($host, $user, $pwd, $db) {	// 建立数据库连接
        $this->_dbHandle = new MySQLi($host, $user, $pwd, $db);
        if($this->_dbHandle->connect_errno)
        {
            return 0;
        }
        return 1;
    }

    function disconnect() {	// 关闭数据库连接
        mysqli_close($this->_dbHandle);
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
        $this->_result = $this->_dbHandle->query($query);
        if (preg_match("/select/i",$query)) {
            return $this->_result->fetch_array();
        }
        return $this->_result;
    }

    function getError() {	// 错误信息
        return mysqli_error($this->_dbHandle);
    }

}