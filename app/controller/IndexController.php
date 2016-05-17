<?php

class IndexController extends Controller {

	public function index() {
		$this->pushName('Neo');
		return $this->view('welcome');
	}

}

