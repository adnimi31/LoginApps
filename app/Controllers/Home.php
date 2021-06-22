<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Login Sistem by AM'
		];
		return view('login', $data);
	}
}
