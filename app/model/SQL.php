<?php

class SQL {
    protected $_dbHandle;
    protected $_result;

    /** 连接数据库 **/
    function connect($host, $user, $pwd, $db) {
        $this->_dbHandle = new MySQLi($host, $user, $pwd, $db);
        if($this->_dbHandle->connect_errno)
        {
            return 0;
        }
        return 1;
    }

    /** 从数据库断开 **/
    function disconnect() {
        mysqli_close($this->_dbHandle);
    }

    /** 查询所有 **/
    function selectAll() {
        $query = 'select * from `'.$this->table.'`';
        return $this->query($query);
    }

    /** 根据条件 (id) 查询 **/
    function select($id) {
        $query = 'select * from `'.$this->table.'` where `id` = \''.mysql_real_escape_string($id).'\'';
        return $this->query($query, 1);
    }

    /** 根据条件 (id) 删除 **/
    function delete($id) {
        $query = 'delete from `'.$this->table.'` where `id` = \''.mysql_real_escape_string($id).'\'';
        return $this->query($query);
    }

    /** 自定义SQL查询 **/
    function query($query, $singleResult = 0) {
        $this->_result = $this->_dbHandle->query($query);
        if (preg_match("/select/i",$query)) {
            return $this->_result->fetch_array();
        }
        return $this->_result;
    }

    /** 获取错误信息 **/
    function getError() {
        return mysqli_error($this->_dbHandle);
    }

}