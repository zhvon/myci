<?php

/**
* test controller
*/
class Test extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->service('welcome/welcome_service');
		$this->welcome_service->test();
	}
}