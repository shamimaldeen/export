<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MY_Controller {

	protected $title = 'Account';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('users_model');
	}
	public function index()
	{
		$data = array();
		$data['title'] = $this->title;
		$data['pagecontent'] = 'dashboard/dashboard';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to edit profile
|----------------------------------------------------------------------------------------------------------*/
	public function myprofile()
	{ 
		$data = array();
		$user_id = $this->session->userdata('user_id');
		if($this->input->post('updateprofilebtn'))
		{
			$this->form_validation->set_rules('firstname', 'first name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lastname', 'last name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('phone', 'phone number', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				if(!$this->email_exists($this->input->post('email'), $user_id))
				{
					$data['email_exists_error'] = 'Email already exists, please choose another email address.';
				}
				else
				{
					$user_details = array('first_name'			=> $this->input->post('firstname'),
										  'last_name'			=> $this->input->post('lastname'),
										  'user_email'			=> $this->input->post('email'),
										  'user_phone'			=> $this->input->post('phone'),
										 );
					$this->common_model->update_records('ci_users', 'user_id', $user_id, $user_details);
					$this->session->set_flashdata('profile_update_success', 'Your profile has been updated successfully !!');
					redirect('account/myprofile');
				}
			}
		}
		$data['title'] 			= 	$this->title;
		$data['userdata']		= 	$this->common_model->select_record('ci_users', 'user_id', $user_id);
		$data['pagecontent'] 	= 	'users/myaccount';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to change password
|----------------------------------------------------------------------------------------------------------*/
	function changepassword()
	{
		$data = array();
		$user_id = $this->session->userdata('user_id');
		if($this->input->post('changepasswordbtn'))
		{
			$this->form_validation->set_rules('currentpassword', 'current password', 'trim|required|callback_current_password|xss_clean');
			$this->form_validation->set_rules('new_password', 'new password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|matches[new_password]|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$password_details = array('password' =>	sha1($this->input->post('new_password')));
				$this->common_model->update_records('ci_users', 'user_id', $user_id, $password_details);
				$this->session->set_flashdata('change_password_success', 'Your password have been changed successfully !!');
				redirect('account/myprofile');
			}
		}
		$data['title'] 			= 	$this->title;
		$data['userdata']		= 	$this->common_model->select_record('ci_users', 'user_id', $user_id);
		$data['pagecontent'] 	= 'users/myaccount';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to check if current password is ok
|----------------------------------------------------------------------------------------------------------*/
	function current_password($password)
	{
		$userid = $this->session->userdata('user_id');
		$logged_user = $this->common_model->select_record('ci_users', 'user_id', $userid);
		if($logged_user->password != sha1($password))
		{
			$this->form_validation->set_message('current_password', 'Wrong current password entered');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
/*---------------------------------------------------------------------------------------------------------
| Function to check if email exists
|----------------------------------------------------------------------------------------------------------*/
	function email_exists($email = '', $user_id = '')
	{
		$email_exists = $this->users_model->email_exists($email, $user_id);
		
		if($email_exists)
		{
			$this->form_validation->set_message('email_exists', 'Email already exists, please choose another email address.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
/*---------------------------------------------------------------------------------------------------------
| Function to logout users
|----------------------------------------------------------------------------------------------------------*/
	function logout()
	{
		$array_items = array('username' => '','user_id'=>'', 'is_loggedin'=>'');
		$this->session->unset_userdata($array_items);
		$this->session->sess_destroy();	
		redirect('login');	
	}
}