<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

	protected $title = 'Users';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('users_model');
		$this->load->model('common_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display users
|----------------------------------------------------------------------------------------------------------*/
	public function index()
	{
		$data = array();
		$data['title'] 			= 	$this->title;
		$data['users'] 			=	$this->users_model->get_users();
		$data['pagecontent'] 	= 	'users/users';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to create users
|----------------------------------------------------------------------------------------------------------*/
	public function createuser()
	{ 
		$data = array();
		if($this->input->post('createuserbtn'))
		{
			$this->form_validation->set_rules('firstname', 'first name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lastname', 'last name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_email_exists|xss_clean');
			$this->form_validation->set_rules('phone', 'phone number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('username', 'username', 'trim|required|callback_username_exists|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('confirmpassword', 'confirm password', 'trim|required|matches[password]|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$user_details = array('first_name'			=> $this->input->post('firstname'),
									  'last_name'			=> $this->input->post('lastname'),
									  'user_email'			=> $this->input->post('email'),
									  'user_phone'			=> $this->input->post('phone'),
									  'username'			=> $this->input->post('username'),
									  'password'			=> sha1($this->input->post('password')),
									  'user_date_created'	=> date('Y-m-d', time()),
									 );
				$this->common_model->dbinsert('ci_users', $user_details);
				$this->session->set_flashdata('success', 'User account has been created successfully !!');
				redirect('users/createuser');
			}
		}
		$data['title'] 			= 	$this->title;
		$data['pagecontent'] 	= 	'users/newuser';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to edit users
|----------------------------------------------------------------------------------------------------------*/
	public function edituser($user_id = 0)
	{ 
		$data = array();
		if($this->input->post('edituserbtn'))
		{
			$user_id = $this->input->post('user_id');
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
					$this->session->set_flashdata('success', 'User account has been updated successfully !!');
					redirect('users/users');
				}
			}
		}
		$data['title'] 			= 	$this->title;
		$data['userdata']		= 	$this->common_model->select_record('ci_users', 'user_id', $user_id);
		$data['pagecontent'] 	= 	'users/edituser';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to check if username exists
|----------------------------------------------------------------------------------------------------------*/
	function username_exists($username = '')
	{
		$username_exists = $this->users_model->username_exists($username);
		
		if($username_exists)
		{
			$this->form_validation->set_message('username_exists', 'Username already exists, please choose another username.');
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
| Function to delete user
|----------------------------------------------------------------------------------------------------------*/
	public function delete($user_id = 0)
	{
		$data = array();
		$this->users_model->delete_user($user_id);
		$this->session->set_flashdata('success', 'User has been deleted successfully !!');
		redirect('users');
	}
}