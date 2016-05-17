<?php

class User extends Model {

	protected $data = array('name', 'password', 'avatar');

	private function modelChecker() {
		foreach ($this->data as $key) {
			if (is_null($this->$key)) {
				return false;
			}
		}
		return true;
	}

	protected function add() {
		if (!$this->modelChecker()) {
			return false;
		}

		$keys = implode(',', $this->data);
		$values = implode(',', $this->properties);

		$query = 'insert into `'. $this->table .'` ('. $keys .') values (\''. $values .'\')';
		return $this->query($query);
	}

	protected function auth($pass) {
		if (password_verify($pass, $this->password)) {	// 验证成功
			return true;
		}
		return false;
	}

	protected function findOrFail($name) {
		$query = 'select * from `'.$this->table.'` where `name` = \''.mysql_real_escape_string($name).'\'';
        $user = $this->query($query, 1);
        if (mysql_num_rows($user) == 0) {	// 没有找到用户
        	return false;
        }
        return $user;
	}

	protected function update($key) {	// 更新
		if (is_null($this->id) || is_null($this->$key)) {
			return false;
		}
		$query = 'update `'.$this->table.'` set '. $key .' = \''.mysql_real_escape_string($this->$key).'\' where `id` = \''.mysql_real_escape_string($this->id).'\'';
        return $this->query($query);
	}

}

