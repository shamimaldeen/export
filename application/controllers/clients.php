<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends MY_Controller {

	protected $title 		= 'Clients';
	protected $activemenu 	= 'clients';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('clients_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display clients
|----------------------------------------------------------------------------------------------------------*/
	public function index()
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['clients']		= $this->common_model->db_select('ci_clients');
		$data['pagecontent'] 	= 'clients/clients';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete clients
|----------------------------------------------------------------------------------------------------------*/
	public function delete($client_id = 0)
	{
		$data = array();
		$this->clients_model->delete_client($client_id);
		$this->session->set_flashdata('success', 'Client has been deleted successfully !!');
		redirect('clients');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to create new client
|----------------------------------------------------------------------------------------------------------*/
	function createclient()
	{
		$data = array();
		if($this->input->post('createclientbtn'))
		{
			$this->form_validation->set_rules('client_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_address', 'address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_postalcode', 'address', 'trim|xss_clean');
			$this->form_validation->set_rules('client_email', 'email', 'trim|required|valid_email|callback_email_exists|xss_clean');
			$this->form_validation->set_rules('client_city', 'city', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_country', 'country', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_telephone', 'telephone', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_fax', 'fax', 'trim|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$client_details = array('client_name'		=> $this->input->post('client_name'),
									  'client_address'		=> $this->input->post('client_address'),
									  'postal_code'			=> $this->input->post('client_postalcode'),
									  'client_city'			=> $this->input->post('client_city'),
									  'client_country'		=> $this->input->post('client_country'),
									  'client_phone'		=> $this->input->post('client_telephone'),
									  'client_fax'			=> $this->input->post('client_fax'),
									  'client_email'		=> $this->input->post('client_email'),
									  'client_date_created'	=> date('Y-m-d', time()),
									 );
				$this->common_model->dbinsert('ci_clients', $client_details);
				$this->session->set_flashdata('success', 'Client has been added successfully !!');
				redirect('clients/createclient');
			}
		}
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['pagecontent'] 	= 'clients/newclient';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to edit client
|----------------------------------------------------------------------------------------------------------*/
	function editclient($client_id = 0)
	{
		$data = array();
		if($this->input->post('editclientbtn'))
		{
			$client_id = $this->input->post('client_id');
			$this->form_validation->set_rules('client_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_address', 'address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_postalcode', 'address', 'trim|xss_clean');
			$this->form_validation->set_rules('client_email', 'email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('client_city', 'city', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_country', 'country', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_telephone', 'telephone', 'trim|required|xss_clean');
			$this->form_validation->set_rules('client_fax', 'fax', 'trim|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				if(!$this->email_exists($this->input->post('client_email'), $client_id))
				{
					$data['email_exists_error'] = 'Email already exists, please choose another email address.';
				}
				else
				{
				$client_details = array('client_name'		=> $this->input->post('client_name'),
									  'client_address'		=> $this->input->post('client_address'),
									  'postal_code'		=> $this->input->post('client_postalcode'),
									  'client_city'			=> $this->input->post('client_city'),
									  'client_country'		=> $this->input->post('client_country'),
									  'client_phone'		=> $this->input->post('client_telephone'),
									  'client_fax'			=> $this->input->post('client_fax'),
									  'client_email'		=> $this->input->post('client_email'),
									 );
				$this->common_model->update_records('ci_clients', 'client_id', $client_id, $client_details);
				$this->session->set_flashdata('success', 'Client has been updated successfully !!');
				redirect('clients');
				}
			}
		}
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['client'] 		= $this->common_model->select_record('ci_clients', 'client_id', $client_id);
		$data['pagecontent'] 	= 'clients/editclient';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to check if email exists
|----------------------------------------------------------------------------------------------------------*/
	function email_exists($email = '', $client_id = '')
	{
		$email_exists = $this->clients_model->email_exists($email, $client_id);
		
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
}