<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MY_Controller {

	protected $title 		= 'Products';
	protected $activemenu 	= 'products';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('products_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display products
|----------------------------------------------------------------------------------------------------------*/
	public function index()
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['products']		= $this->common_model->db_select('ci_products');
		$data['pagecontent'] 	= 'products/products';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to create new product
|----------------------------------------------------------------------------------------------------------*/
	function createproduct()
	{
		$data = array();
		if($this->input->post('createproductbtn'))
		{
			$this->form_validation->set_rules('product_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('product_description', 'description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('product_unit_price', 'unit price', 'trim|numeric|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$product_details = array('product_name'		=> $this->input->post('product_name'),
									  'product_description'	=> $this->input->post('product_description'),
									  'product_unitprice'	=> $this->input->post('product_unit_price'),
									 );
				$this->common_model->dbinsert('ci_products', $product_details);
				$this->session->set_flashdata('success', 'Product has been added successfully !!');
				redirect('products/createproduct');
			}
		}
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['pagecontent'] 	= 'products/newproduct';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to edit product
|----------------------------------------------------------------------------------------------------------*/
	function editproduct($product_id = 0)
	{
		$data = array();
		if($this->input->post('editproductbtn'))
		{
			$product_id = $this->input->post('product_id');
			$this->form_validation->set_rules('product_name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('product_description', 'description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('product_unit_price', 'unit price', 'trim|numeric|required|xss_clean');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run())
			{
				$product_details = array('product_name'		=> $this->input->post('product_name'),
									  'product_description'	=> $this->input->post('product_description'),
									  'product_unitprice'	=> $this->input->post('product_unit_price'),
									 );
				$this->common_model->update_records('ci_products', 'product_id', $product_id, $product_details);
				$this->session->set_flashdata('success', 'Product has been updated successfully !!');
				redirect('products');
			}
		}
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['product'] 		= $this->common_model->select_record('ci_products', 'product_id', $product_id);
		$data['pagecontent'] 	= 'products/editproduct';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to process products selected to be added to an invoice
|----------------------------------------------------------------------------------------------------------*/
	function process_products_selections()
	{
		$product_ids = $this->input->post('products_lookup_ids');
		$products = $this->products_model->get_product_selections($product_ids)->result();
		echo json_encode($products);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete a product
|----------------------------------------------------------------------------------------------------------*/
	function delete($product_id = 0)
	{
		$this->products_model->delete_product($product_id);
		$this->session->set_flashdata('success', 'The product has been deleted successfully !!');
		redirect('products');
	}
	
}