<?php

/**
* 
*/
class Welcome_service extends CI_Service
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function test()
	{
		$this->load->view('welcome_message');
	}
}