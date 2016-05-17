<?php

/**
 * 用户控制类
 */

class UserController extends Controller {

	private function validator($name, $password, $avatar = null, $login = false) {
		if (!preg_match('/^[A-Za-z\d]{3,10}$/i', $name)) {	// 用户名验证，查重
			$this->pushErr(['stat' => 'User name validate failed']);
			return false;
		}

		if (!$login && User::findOrFail($name)) {
			$this->pushErr(['stat' => 'User name invalid']);
			return false;
		}

		if (!preg_match('/^[a-z\d]{6,18}$/i', $password)) {	// 密码验证
			$this->pushErr(['stat' => 'Password validate Failed']);
			return false;
		}

		if (!is_null($avatar) && !preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $avatar)) {	// 非法 URL
			$this->pushErr(['stat' => 'Avatar validate Failed']);
			return false;
		}
		return true;
	}

	private function tokenValidator($token) {
		if (!preg_match('/^[A-Za-z\d]{128}$/i', $token)) {	// 用户名验证，查重
			$this->pushErr(['stat' => 'Invalid token']);
			return false;
		}
		return true;
	}

	public function register() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// POST 数据验证
			if (!empty($_POST["name"]) && !empty($_POST["password"]) && !empty($_POST["avatar"])) {
				if (!$this->validator($_POST["name"], $_POST["password"], $_POST["avatar"])) {
					return $this->view('error');
				}

				// 验证通过
				$user = new User;

				// 填充用户数据
				$user->name = $_POST["name"];
				$user->password = password_hash($_POST["password"], PASSWORD_BCRYPT);	// 使用 CRYPT_BLOWFISH 加密用户密码
				$user->avatar = $_POST["avatar"];

				$res = $user->add();

				if ($res) {
					$this->pushRes(['token' => $res->token, 'expire' => $res->expire]);
				} else {
					$this->pushRes(['stat' => 'Register fail']);
				}
				return $this->view('api');
			}
			$this->pushRes(['stat' => 'Register form are not completed']);
			return $this->view('api');
		}
		$this->pushErr("Method not allow");
		return $this->view('error');
	}

	public function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// POST 数据验证
			if (!empty($_POST["name"]) && !empty($_POST["password"])) {
				if (!$this->validator($_POST["name"], $_POST["password"], null, true)) {
					return $this->view('error');
				}
				// 基础验证通过
				$user = User::findOrFail($_POST["name"]);
				$pass = $user->auth($_POST["password"]);	// 验证密码
				if ($pass) {	// 密码确认
					$user->updateToken();
					$this->pushRes(['token' => $user->token, 'expire' => $user->expire]);
				} else {
					$this->pushRes(['stat' => 'User name or password error']);
				}
				return $this->view('api');
			}
			$this->pushRes(['stat' => 'Invalid args']);
			return $this->view('api');
		}
		$this->pushErr("Method not allow");
		return $this->view('error');
	}

	public function info() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// POST 数据验证
			if (!empty($_POST["token"])) {
				if (!$this->tokenValidator($_POST["token"])) {
					return $this->view('error');
				}
				// 基础验证通过
				$user = User::findOrFail($_POST["token"], true);	// 通过 token 查找用户
				if (!$user) {
					$this->pushRes(['stat' => 'Invalid token']);
					return $this->view('api');
				}
				if ($user && $user->expire <= time()) {
					$this->pushRes(['stat' => 'Token expired']);
					return $this->view('api');
				}
				$this->pushRes(['id' => $user->id, 'name' => $user->name, 'avatar' => $user->avatar]);
				return $this->view('api');
			}
			$this->pushRes(['stat' => 'Invalid args']);
			return $this->view('api');
		}
		$this->pushErr("Method not allow");
		return $this->view('error');
	}

}

