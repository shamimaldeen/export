<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_methods extends MY_Controller {

	protected $title 		= 'Payment Methods';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}
/*---------------------------------------------------------------------------------------------------------
| Function to list payment methods
|----------------------------------------------------------------------------------------------------------*/	
	public function index()
	{
		$data = array();
		$data['title'] 				= $this->title;
		$data['payment_methods']	= $this->common_model->db_select('ci_payment_methods');
		$data['pagecontent'] 		= 'payment_methods/payment_methods';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to create new payment method
|----------------------------------------------------------------------------------------------------------*/	
	function create()
	{
		$data = array();
		if($this->input->post('createpayment_methodbtn'))
		{
			$this->form_validation->set_rules('payment_method_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$payment_method_details = array('payment_method_name'		=> $this->input->post('payment_method_name'));
				$this->common_model->dbinsert('ci_payment_methods', $payment_method_details);
				$this->session->set_flashdata('success', 'Payment Method has been added successfully !!');
				redirect('payment_methods/create');
			}
		}
		$data['title'] 				= $this->title;
		$data['pagecontent'] 		= 'payment_methods/create_payment_method';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to edit payment method
|----------------------------------------------------------------------------------------------------------*/	
	function edit($payment_method_id = 0)
	{
		$data = array();
		if($this->input->post('editpayment_methodbtn'))
		{
			$payment_method_id = $this->input->post('payment_method_id');
			$this->form_validation->set_rules('payment_method_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$payment_method_details = array('payment_method_name'		=> $this->input->post('payment_method_name'));
				$this->common_model->update_records('ci_payment_methods', 'payment_method_id', $payment_method_id, $payment_method_details);
				$this->session->set_flashdata('success', 'Payment Method has been updated successfully !!');
				redirect('payment_methods/edit/'.$payment_method_id);
			}
		}
		$data['title'] 				= $this->title;
		$data['payment_method']		= $this->common_model->select_record('ci_payment_methods', 'payment_method_id', $payment_method_id);
		$data['pagecontent'] 		= 'payment_methods/edit_payment_method';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete payment method
|----------------------------------------------------------------------------------------------------------*/
	public function delete($payment_method_id = 0)
	{
		$this->common_model->deleterecord('ci_payment_methods', 'payment_method_id', $payment_method_id);
		$this->session->set_flashdata('success', 'Payment Method has been deleted successfully !!');
		redirect('payment_methods');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */