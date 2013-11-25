<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{

	function __construct()
    {
        parent::__construct();
    }
    
	public function index()
	{
		$data = array(
			'title' => 'Login',
			'hello' => 'This is first commit',
			'content' => 'index'
		);
		
		$this->load->view('common/login_template', $data);
	}





}