<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax extends MY_Controller {
	protected $title = 'Tax Rates';
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('common_model');
	}
	public function index()
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['pagecontent'] 	= 'tax/tax_rates';
		$data['tax_rates']		= $this->common_model->db_select('ci_tax_rates');
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to create new tax rate
|----------------------------------------------------------------------------------------------------------*/
	function newtax()
	{
		$data = array();
		if($this->input->post('createtaxbtn'))
		{
			$this->form_validation->set_rules('tax_rate_name', 'tax rate name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('tax_rate_percentage', 'tax rate percentage value', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$tax_details = array('tax_rate_name'			=> $this->input->post('tax_rate_name'),
									 'tax_rate_percent'			=> $this->input->post('tax_rate_percentage'),
									 );
				$this->common_model->dbinsert('ci_tax_rates', $tax_details);
				$this->session->set_flashdata('success', 'Tax rate has been created successfully !!');
				redirect('tax/newtax');
			}
		}
		$data['title'] 			= $this->title;
		$data['pagecontent'] 	= 'tax/newtax';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to Edit tax rate
|----------------------------------------------------------------------------------------------------------*/
	function edittax($taxid = 0)
	{
		$data = array();
		if($this->input->post('createtaxbtn'))
		{
			$taxid = $this->input->post('taxid');
			$this->form_validation->set_rules('tax_rate_name', 'tax rate name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('tax_rate_percentage', 'tax rate percentage value', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$tax_details = array('tax_rate_name'			=> $this->input->post('tax_rate_name'),
									 'tax_rate_percent'			=> $this->input->post('tax_rate_percentage'),
									 );
				$this->common_model->update_records('ci_tax_rates', 'tax_rate_id', $taxid, $tax_details);
				$this->session->set_flashdata('success', 'Tax rate has been updated successfully !!');
				redirect('tax/edittax/'.$taxid);
			}
		}
		$data['title'] 			= $this->title;
		$data['taxdetails']		= $this->common_model->select_record('ci_tax_rates', 'tax_rate_id', $taxid);
		$data['pagecontent'] 	= 'tax/edittax';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete a tax rate
|----------------------------------------------------------------------------------------------------------*/
	function delete($tax_rate_id = 0)
	{
		$this->common_model->deleterecord('ci_tax_rates', 'tax_rate_id', $tax_rate_id);
		$this->session->set_flashdata('success', 'Tax rate has been deleted successfully !!');
		redirect('tax');
	}
	
}