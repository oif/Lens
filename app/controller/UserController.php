<?php

/**
 * 用户控制类
 * 方法：注册			register
 *      登陆			login
 *      获取用户信息 	info
 */

class UserController extends Controller {

	function __construct()
	{
		# code...
	}

	private function validator($name, $password, $avatar) {
		$temp = new User;
		if (!preg_match('/^[a-z\d]{3,10}$/i', $name) && $temp->findOrFail($name)) {	// 用户名验证，查重
			unset($temp);
			return false;
		}
		unset($temp);	// 释放

		if (!preg_match('/^[a-z\d]{6,18}$/i', $password)) {	// 密码验证
			return false;
		}

		if (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $avatar)) {	// 非法 URL
			return false;
		}

		return true;
	}

	public function register() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// POST 数据验证
			if (!empty($_POST["name"]) &&
				!empty($_POST["password"]) &&
				!empty($_POST["avatar"]) &&
				$this->validator($_POST["name"], $_POST["password"], $_POST["avatar"])) {
				// 验证通过
				$user = new User;
				// 填充用户数据
				$user->name = $_POST["name"];
				$user->password = password_hash($_POST["password"], PASSWORD_BCRYPT);	// 使用 CRYPT_BLOWFISH 加密用户密码
				$user->avatar = $_POST["avatar"];

				$user->add();
			}
		}
	}

	public function loginx() {

	}

	public function info() {

	}

}

