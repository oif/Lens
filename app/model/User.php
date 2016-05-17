<?php

class User extends Model {

	protected $key = array('name', 'password', 'avatar', 'token', 'expire');

	private function modelChecker() {
		foreach ($this->key as $key) {
			if (is_null($this->$key)) {
				return false;
			}
		}
		return true;
	}

	private static function tokenGen($length = 128) {	// 默认128位
		$seed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$code = '';
	    for ($i=0; $i < $length; $i++) {
	        $code .= $seed[mt_rand(0, 61)];//substr($seed, mt_rand(0, 61), 1);
	    }
	    return $code;
	}

	public function add() {
		$this->token = User::tokenGen();
		$this->expire = time() + TOKEN_EXP;
		if (!$this->modelChecker()) {
			return false;
		}

		$keys = implode(',', $this->key);
		$values = implode('\',\'', $this->properties);

		$query = 'insert into `'. $this->table .'` ('. $keys .') values (\''. $values .'\')';
		if ($this->query($query)) {
			return User::findOrFail($this->name);
		}
		return false;
	}

	public function auth($pass) {
		if (password_verify($pass, $this->password)) {	// 验证成功
			return true;
		}
		return false;
	}

	public static function findOrFail($value, $token = false) {
		$mo = new Model;
		$query = 'select * from `users` where `name` = \''. $value .'\'';
		if ($token) {
			$query = 'select * from `users` where `token` = \''. $value .'\'';
		}
        $user = $mo->query($query);
        if (count($user) == 0) {	// 没有找到用户
        	return false;
        }
        $found = new User;
        $found->id = $user['id'];
        /*
        $found->name = $user['name'];
        $found->password = $user['password'];
        $found->avatar = $user['avatar'];
        $found->token = $user['token'];
        $found->expire = $user['expire'];*/
        foreach ($found->key as $k) {
        	$found->$k = $user[$k];
        }
        return $found;
	}

	public function update($key) {	// 更新
		if (is_null($this->id) || is_null($this->$key)) {
			return false;
		}
		$query = 'update `'.$this->table.'` set '. $key .' = \''. $this->$key.'\' where `id` = \''. $this->id .'\'';
        return $this->query($query);
	}

	public function updateToken() {
		$this->token = User::tokenGen();
		$this->expire = time() + TOKEN_EXP;
		$this->update('token');
		$this->update('expire');
	}

}

