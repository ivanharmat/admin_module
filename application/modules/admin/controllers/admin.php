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


	public function dashboard()
	{
		$this->admin_model->admin_logged_in();

		$data = array(
			'title' => 'Dashboard',
			'content' => 'dashboard'
		);

		$this->load->view('common/admin_template', $data);
	}

	// public function admin_from_md5()
	// {
	// 	$admins = $this->db->get('admin_users')->result_array();
	// 	foreach($admins as $admin)
	// 	{
	// 		$encrypted_md5 = $this->encrypt->encode($admin['admin_md5']);
	// 		$this->db->where('admin_user_id', $admin['admin_user_id'])->update('admin_users', array('admin_password' => $encrypted_md5));
	// 	}
	// }
	
	// public function user_from_md5()
	// {
	// 	$users = $this->db->get('regular_users')->result_array();
	// 	foreach($users as $user)
	// 	{
	// 		if(!$user['facebook'])
	// 		{
	// 			$encrypted_md5 = $this->encrypt->encode($user['regular_user_md5']);
	// 			$this->db->where('regular_user_id', $user['regular_user_id'])->update('regular_users', array('regular_user_password' => $encrypted_md5));
	// 		}
	// 	}
	// }




}