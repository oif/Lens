<?php

class SQL {
    private static $_dbHandle;

    function __construct()
    {
        $this->_dbHandle = new MySQLi(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if($this->_dbHandle->connect_errno) {
            return false;
        }
        return true;
    }

    // @Singleton
    public static function getInstance() {
        if (!(self::$_dbHandle instanceof self)) {
            self::$_dbHandle = new self;
        }
        return self::$_dbHandle;
    }

    function __destruct() {
        mysqli_close(self::$_dbHandle);
    }
}