<?php defined('BASEPATH') OR exit('No direct script access allowed');
/** 
 * Gharbieh.com
 * 
 * Copyright (c) 2013, Gharbieh.com
 * http://ivanharmat.com
 * 
 * Redistributions of files prohibited without permission
 */

/*****************************************************************
 * admin.php
 *
 * @author      Ivan Harmat (ivanharmat@gmail.com)
 * @package     Admin module
 * @version     1.0
 * @category    Controller
 * @link        http://ivanharmat.com
 *
 ****************************************************************/

/*****************************************************************
 * Description:
 * 
 * Controller for admin functionalities
 ****************************************************************/
class Admin extends CI_Controller 
{

	function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }
    
    /**
	* method index
	* loads login page
	* @return void
	*/
	public function index()
	{
		$this->admin_model->admin_logged_in_login_form();
		$data = array(
			'title' => 'Login',
			'content' => 'index',
			'js' => array('admin/index')
		);


		$this->load->view('common/login_template', $data);
	}

	/**
	* method sign_in_ajax
	* sign in request - ajax request
	* @return object
	*/
	public function authenticate()
	{
		if($this->input->is_ajax_request())
		{
			sleep(1);
			$post = $this->input->post(NULL, TRUE); 
			// Sign in admin
			$data = $this->admin_model->authenticate($post);

			echo json_encode($data);
		}
	}

	/**
    * method logout
    * destroy 2 sessions and redirect user back to login form
    * flash successful logout message
    * @return void
    */
    public function logout()
    {
    	$session = array('admin_logged_in' => NULL, 'admin_id' => NULL);
		$this->session->unset_userdata($session);
        $this->session->set_flashdata('flashdata', '<p class="alert alert-info"><i class="fa fa-info"></i> You\'ve been logged out</p>');
		redirect(base_url('admin'));
    }

    /**
	* method dashboard
	* loads dashboard page
	* @return void
	*/
	public function dashboard()
	{
		$this->admin_model->admin_logged_in();

		$data = array(
			'title' => 'Dashboard',
			'content' => 'dashboard',
			'common' => $this->admin_model->load_common_data(),
			'active' => ''
		);

		$this->load->view('common/admin_template', $data);
	}

	/**
	* method pages
	* loads pages page
	* @return void
	*/
	public function pages()
	{
		$this->admin_model->admin_logged_in();

		$data = array(
			'title' => 'Pages',
			'content' => 'pages',
			'common' => $this->admin_model->load_common_data(),
			'active' => 'pages'
		);

		$this->load->view('common/admin_template', $data);
	}

	/**
	* method settings
	* loads settings page
	* @return void
	*/
	public function settings()
	{
		$this->admin_model->admin_logged_in();

		$data = array(
			'title' => 'Settings',
			'content' => 'settings',
			'common' => $this->admin_model->load_common_data(),
			'active' => ''
		);

		$this->load->view('common/admin_template', $data);
	}




}