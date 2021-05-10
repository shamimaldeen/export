<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_templates extends MY_Controller {

	protected $title 		= 'Email Templates';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('template_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display email templates
|----------------------------------------------------------------------------------------------------------*/	
	public function index()
	{
		$data = array();
		$data['title'] 				= $this->title;
		$data['email_templates']	= $this->common_model->db_select('ci_email_templates');
		$data['pagecontent'] 		= 'email_templates/email_templates';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to create email templates
|----------------------------------------------------------------------------------------------------------*/
	function create()
	{
		$data = array();
		if($this->input->post('createtemplatebtn'))
		{
		$this->form_validation->set_rules('template_title', 'title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('template_body', 'body content', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run())
		{
			$template_details = array('template_title'	=> $this->input->post('template_title'),
								    'email_body'		=> $this->input->post('template_body'),
								 );
			$this->common_model->dbinsert('ci_email_templates', $template_details);
			$this->session->set_flashdata('success', 'Template has been saved successfully !!');
			redirect('email_templates/create');
		}
		}
		$data['title'] 				= $this->title;
		$data['pagecontent'] 		= 'email_templates/new_template';
		$this->load->view('common/holder', $data);
	}
	function edit($template_id = 0)
	{
		$data = array();
		if($this->input->post('edittemplatebtn'))
		{
		$template_id = $this->input->post('template_id');
		$this->form_validation->set_rules('template_title', 'title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('template_body', 'body content', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run())
		{
			$template_details = array('template_title'	=> $this->input->post('template_title'),
								    'email_body'		=> $this->input->post('template_body'),
								 );
			$this->common_model->update_records('ci_email_templates', 'template_id', $template_id, $template_details);
			$this->session->set_flashdata('success', 'Template has been saved successfully !!');
			redirect('email_templates/edit/'.$template_id);
		}
		}
		$data['title'] 				= $this->title;
		$data['email_template']		= $this->common_model->select_record('ci_email_templates', 'template_id', $template_id);
		$data['pagecontent'] 		= 'email_templates/edit_template';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to get email template
|----------------------------------------------------------------------------------------------------------*/
	function get_template()
	{
		$data 						= array();
		$template_id 				= $this->input->post('template_id');
		$data['template']			= $this->template_model->get_template($template_id);
		echo json_encode($data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete email template
|----------------------------------------------------------------------------------------------------------*/
	function delete($template_id = 0)
	{
		$this->template_model->delete_template($template_id);
		$this->session->set_flashdata('success', 'Email template has been deleted successfully !!');
		redirect('email_templates');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */