<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to login users
|----------------------------------------------------------------------------------------------------------*/	
	public function index()
	{
		$data = array();
		if($this->input->post('loginbttn'))
		{
			$username = $this->input->post('username');
			$password = sha1($this->input->post('password'));
			$userdata = $this->users_model->selectuser($username, $password);
			if($userdata->num_rows() > 0)
			{
			$row = $userdata->row();
			$user_details = array ('username' 	=> $row->username, 
								   'firstname' 	=> $row->first_name,
								   'lastname' 	=> $row->last_name, 								   
								   'user_id'  	=> $row->user_id,
								   'is_loggedin'=>true
								   );
			$this->session->set_userdata($user_details);
			redirect('dashboard');
			}
			else
			{
			$this->session->set_flashdata('error', 'The username/password combination is not correct, please try again !!');
			redirect('login/login');
			}
		}
		$data['logo']	= $this->common_model->get_siteconfig('logo');
		$this->load->view('login/login', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to reset user passwords
|----------------------------------------------------------------------------------------------------------*/	

	function resetpassword()
	{
		$data = array();
		if(isset($_POST['resetpasswordbttn']))
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$username = $this->input->post('username');
				$userdata = $this->users_model->select_email($username);
				$rows = $userdata->num_rows();
				if($rows == 1)
				{	   
					   $userdetails 	= $userdata->row();
					   $firstname 		= $userdetails->first_name;
					   $email			= $userdetails->user_email;
					   
					   $password_token = $this->create_guid();
					   $password_details = array('password' 	=> sha1($password_token));
					   $this->users_model->resetpassword($username, $password_details);

					   //send the password reset email
					    $to      = $email;
						$subject = 'Password Reset Information';
						$company_name = (get_setting_value('companyname') != '') ? get_setting_value('companyname') : "Classic Invoicer";
						$message  = '<h2>Hello '.ucfirst($firstname).', </h2>';
						$message  .= '<p>As you requested, your password has now been reset. Your new login details are as follows:</p>';
						$message  .= '<p> Password : '.$password_token.'</p>';
						$message  .= '<p>NB : Remember to change this password to a more convinient one.</p>';
						$message  .= '<p>Best Regards.</p>';
						$message  .= '<p>Webmaster</p>';
						$message  .= '<hr/>';
						$message  .= '<p style="font-size:8px; color:#969AB3">Please do not reply to this message; it was sent from an unmonitored email address. This message is a service email related to your use of classic invoice. For general inquiries or to request support with your account, please contact us for Support.</p>';
						
						$config['mailtype'] = 'html';
						$this->load->library("email");
						$this->email->initialize($config);
						$this->email->set_newline("\r\n");
						$this->email->from("noreply@classicinvoicer",$company_name->company_name);
						$this->email->to($to);
						$this->email->subject($subject);
						$this->email->message($message);
					  					
					   if($this->email->send())
					   {
						$this->session->set_flashdata('success', 'Password reset successful, check your inbox for instructions !!');
						redirect('login');
					  }
				}
				else
				{
					$this->session->set_flashdata('error', 'Username does not exist !!');
					redirect('login/resetpassword');
				}
			}
		}
		$this->load->view('login/resetpassword');
	}
	
	public function create_guid()  
    {  
    $pwd = str_shuffle('abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');  
    $guid = urlencode(substr($pwd,0,8));
    return $guid;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */