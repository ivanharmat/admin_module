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
 * admin_model.php
 *
 * @author      Ivan Harmat (ivanharmat@gmail.com)
 * @package     Admin module
 * @version     1.0
 * @category    Model
 * @link        http://ivanharmat.com
 *
 ****************************************************************/

/*****************************************************************
 * Description:
 * 
 * Model for admin functionalities
 ****************************************************************/
class Admin_model extends CI_model
{
	function __construct()
    {
        parent::__construct();
    }

	/**
	* method load_common_data
	* loads data used throughout the module
	* @return array
	*/
	public function load_common_data()
	{
		$data = array();
		$admin_id = $this->session->userdata('admin_id');
		$admin_user = $this->db->select(array('admin_first_name'))
						   ->get_where('admin_users', array('admin_user_id' => $admin_id))
						   ->row_array();
		$data['first_name'] = $admin_user['admin_first_name'];
		return $data;
	}

	/**
	* method admin_logged_in_login_form
	* check if the admin user is logged in, 
	* redirects back to dashboard page, if user tries to access login page
	* @return void
	*/
	public function admin_logged_in_login_form()
	{
		if($this->session->userdata('admin_logged_in') === TRUE)
		{
			redirect(base_url().'admin/dashboard');
		}
	}

	/**
	* method admin_logged_in
	* checks if user is logged in,
	* redirects non logged in user to login page,
	* flashes error session 
	* @return void
	*/
	public function admin_logged_in()
	{
		if($this->session->userdata('admin_logged_in') == FALSE)
		{
			$this->session->set_flashdata('flashdata', '<p class="alert alert-danger"><i class="fa fa-warning"></i> You must login to view that page</p>');
			redirect(base_url().'admin');
		}
	}

	/**
	* method authenticate
	* compares form values with db and returns array of values
	* inserts IP, place to db, blocks user after 3 failed tries
	* authenticates admin if successful login
	* @param array post
	* @return array
	*/
	public function authenticate($post)	
	{
		$data = array();
		$ip_address = $this->input->ip_address();
		
		// Admin Exists?
		$data['errors'] = '';
		$data['hide_form'] = false;

		$admin = $this->db->get_where('admin_users', array('admin_email' => $post['email']))->row_array();
		if(isset($admin['admin_user_id']))
		{
			// Count failed logins
			$failed_logins_data = array(
				'admin_id' => $admin['admin_user_id'],
				'ip_address' => $ip_address,
				'timestamp >' => time() - (30 * 60)
			);
			$failed_admin_logins = $this->db->get_where('failed_admin_logins', $failed_logins_data)->num_rows();

			if($failed_admin_logins >= 3)
			{
				$data['success'] = false;
				$data['errors'] .= '<p class="alert alert-danger"><i class="fa fa-warning"></i> 3 or more failed attempts. Account disabled for 30 minutes</p>';
				$data['hide_form'] = true;
			}
			else
			{
				$authenticate_admin = $this->authenticate_admin($post, $admin);
				if($authenticate_admin)
				{
					$data['success'] = true;
					$data['redirect'] = '/admin/dashboard';	
					// Insert new admin location
					$location = $this->get_ip_address_info($ip_address);
					$this->new_admin_ip_location($ip_address, $admin['admin_user_id'], $location);
				}
				else
				{
					$data['success'] = false;
					$data['errors'] .= '<p class="alert alert-danger"><i class="fa fa-warning"></i> Wrong email or password</p>';
					if($failed_admin_logins == 2)
					{
						$data['hide_form'] = true;
						$data['errors'] .= '<p class="alert alert-danger"><i class="fa fa-warning"></i> 3 failed login attempts. Account disabled for 30 minutes</p>';
					}
					if($failed_admin_logins == 1)
					{
						$data['errors'] .= '<p class="alert alert-warning"><i class="fa fa-warning"></i> You have one more try to login</p>';
					}
					// Insert failed admin login
					$this->failed_admin_login($ip_address, $admin['admin_user_id']);
				}
			}
			
		}
		else
		{
			$data['success'] = false;
			$data['errors'] .= '<p class="alert alert-danger"><i class="fa fa-warning"></i> Wrong email or password</p>';
		}

		return $data;
	}

	/**
	* method authenticate_admin
	* method to authenticate admin after admin is found
	* @param array post
	* @param array admin
	* @return boolean
	*/
	private function authenticate_admin($post, $admin)
	{
		if(md5($post['password']) == $this->encrypt->decode($admin['admin_password']))
		{
			$session = array(
				'admin_id' => $admin['admin_user_id'],
				'admin_logged_in' => true
			);
			$this->session->set_userdata($session);
			// Delete previous failed logins from this ip address
			$this->db->where('admin_id', $admin['admin_user_id'])
					 ->where('ip_address', $ip_address = $this->input->ip_address())
					 ->delete('failed_admin_logins');

			$this->session->set_flashdata('flashdata', '<p class="alert alert-success"><i class="fa fa-check"></i> Welcome '.$admin['admin_first_name'].'!</p>');
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	* method failed_admin_login
	* creates new record in admin_ips table
	* @param str ip_address
	* @param int admin_id
	* @return void
	*/
	private function failed_admin_login($ip_address, $admin_id)
	{
		$insert_data = array(
			'admin_id' => $admin_id,
			'timestamp' => time(),
			'ip_address' => $ip_address
		);
		$this->db->insert('failed_admin_logins', $insert_data);
	}

	/**
	* method new_admin_ip_location
	* creates new record in failed admin logins table, admin log
	* @param str ip_address
	* @param int admin_id
	* @param array location
	* @return void
	*/
	private function new_admin_ip_location($ip_address, $admin_id, $location)
	{
		$insert_data = array(
			'user_id' => $admin_id,
			'ip_address' => $ip_address,
			'login_timestamp' => time()
		);
		if(isset($location['cityName']))
		{
			$insert_data['place'] = $location['cityName'].', '.$location['regionName'];
		}
		$this->db->insert('admin_ips', $insert_data);
	}

	/**
	* method get_ip_address_info
	* returns place info based on user IP address
	* @param str ip_address
	* @return array
	*/
	private function get_ip_address_info($ip_address)
	{
		require_once(APPPATH.'third_party/ip2location.php');
		$api_key = '8d7b37a94dda13ed4d10a2e5fb237be6d6ed6fd697f5c0075e7373182b3f11b7';
		
		//Load the class
		$ipLite = new ip2location_lite;
		$ipLite->setKey($api_key);
		 
		//Get errors and locations
		$locations = $ipLite->getCity($ip_address);
		$errors = $ipLite->getError();
		
		if(!$errors)
		{
			return $locations;
		}
		else
		{
			return array();
		}
	}




}