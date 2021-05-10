<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotes extends MY_Controller {

	protected $title = 'Quotes';
	protected $activemenu 	= 'quotes';
	
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('quotes_model');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to list all quotes
|----------------------------------------------------------------------------------------------------------*/
	function index()
	{
		$status = 0;
		$data = array();
		$data['title'] 		 = $this->title;
		$data['activemenu']	 = $this->activemenu;
		$data['quotes']		 = $this->quotes_model->list_quotes();
		$data['statuses']	 = $this->quotes_model->statuses();
		$data['selected_status'] = $status;
		$data['pagecontent'] = 'quotes/quotes';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to filter quotes
|----------------------------------------------------------------------------------------------------------*/
	function ajax_filter_quotes()
	{
		$data = array();
		$quote_status 		= $this->input->post('status');
		$data['quotes']		= $this->quotes_model->list_quotes($quote_status);
		$data['status']		= $quote_status;
		$data['statuses']	 = $this->quotes_model->statuses();		
		$quote_results 		= $this->load->view('quotes/filtered_quotes', $data, true);
		echo $quote_results;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to create new quote
|----------------------------------------------------------------------------------------------------------*/
	function newquote()
	{
		$data = array();
		$data['title'] 		 = $this->title;
		$data['activemenu']	 = $this->activemenu;
		$data['clients'] 	 = $this->common_model->get_select_option('ci_clients', 'client_id', 'client_name');
		$data['taxrates'] 	 = $this->common_model->get_select_option('ci_tax_rates', 'tax_rate_id', 'tax_rate_name', 1);
		$data['statuses']	 = $this->quotes_model->statuses();
		$data['pagecontent'] = 'quotes/newquote';
		$this->load->view('common/holder', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to calculate quote totals
|----------------------------------------------------------------------------------------------------------*/
	function ajax_calculate_totals()
	{
		$items = json_decode($this->input->post('items'));
		$items_total_cost = 0;
		$quote_total_tax = 0;
		$items_total_discount = 0;
		$quote_discount_amount = $this->input->post('quote_discount_amount');
		foreach ($items as $item) 
		{
			if($item->item_quantity != '' && $item->item_price != '')
			{
				$item_total 	=	($item->item_quantity * $item->item_price)-$item->item_discount;
				$items_total_cost = $items_total_cost + $item_total;
				if($item->tax_rate_id != '')
				{
				$tax_percent = $this->common_model->get_tax($item->tax_rate_id);
				$quote_total_tax += $tax_percent * $item_total;
				}
				$items_total_discount += $item->item_discount;  
			}
		}
		$amount_due = $items_total_cost-$quote_discount_amount+$quote_total_tax;
		$response = array(
                'success'           => 1,
                'items_total_cost'  => number_format($items_total_cost, 2),
				'quote_total_tax'	=> number_format($quote_total_tax, 2),
				'quote_sub_total'   => number_format($items_total_cost-$quote_discount_amount, 2),
				'items_total_discount' => number_format($items_total_discount, 2),
				'quote_discount_amount' => number_format($quote_discount_amount, 2),
				'quote_amount_due' => ($amount_due >= 0) ? number_format($amount_due, 2) :  number_format(0, 2)
				
            );
		echo json_encode($response);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to save quotes
|----------------------------------------------------------------------------------------------------------*/
	function ajax_save_quote()
	{
		$items = json_decode($this->input->post('items'));
		$quote_number = $this->input->post('quote_number');
		$quote_items = 0;
		foreach ($items as $item) 
		{
			if($item->item_quantity != '' && $item->item_price != '')
			{
				$quote_items++;
			}
		}
		if($quote_items > 0)
		{
			if($quote_number == ''){
			$quote_details = array('user_id' 			=> $this->session->userdata('user_id'),
								   'client_id' 			=> $this->input->post('quote_client'),
								   'customer_notes' 	=> $this->input->post('quote_terms'),
								   'quote_subject'		=> $this->input->post('quote_subject'),
								    'quote_status' 		=> $this->input->post('quote_status'),
								   'quote_discount'		=> $this->input->post('quote_discount_amount'),
								   'date_created' 		=> date('Y-m-d', strtotime($this->input->post('quote_date'))),
								   'valid_until' 		=> date('Y-m-d', strtotime($this->input->post('quote_valid_until_date'))),
									);
			$quote_id = $this->common_model->saverecord('ci_quotes', $quote_details);
			}
			else
			{
				$quote_details = array('client_id' 				=> $this->input->post('quote_client'),
										 'customer_notes' 		=> $this->input->post('quote_terms'),
										 'quote_subject'		=> $this->input->post('quote_subject'),
										 'quote_status' 		=> $this->input->post('quote_status'),
										 'quote_discount'		=> $this->input->post('quote_discount_amount'),
										 'date_created' 		=> date('Y-m-d', strtotime($this->input->post('quote_date'))),
										 'valid_until' 			=> date('Y-m-d', strtotime($this->input->post('quote_valid_until_date'))),
									);
				$quote_id = $this->input->post('quote_number');
				$this->common_model->update_records('ci_quotes', 'quote_id', $quote_id, $quote_details);
			}
			foreach ($items as $item) 
			{
				if($item->item_quantity != '' && $item->item_price != '')
				{
					$item_id = $item->item_id;
					$item_details = array ('quote_id'			=> $quote_id,
										   'item_name'			=> $item->item_name,
										   'item_quantity'		=> $item->item_quantity,
										   'item_description'	=> $item->item_description,
										   'Item_tax_rate_id'	=> $item->tax_rate_id,
										   'item_order'			=> $item->item_order,
										   'item_price'			=> $item->item_price,
										   'item_discount'		=> $item->item_discount,
										  );
					if($item_id != '')
					{
						$this->common_model->update_records('ci_quotes_items', 'item_id', $item_id, $item_details);
						$this->session->set_flashdata('success', 'The quote has been edited successfully !!');
					}
					else
					{
						$this->common_model->saverecord ('ci_quotes_items', $item_details);
						$this->session->set_flashdata('success', 'The quote has been created successfully !!');
					}
				}
			}
			
			$response = array(
                'success'           => 1,
            );
		}
		else
		{
			$response = array(
                'success'           => 0,
                'error'  			=> 'Please enter atleast one item',
            );
		}
		echo json_encode($response);	
	}

/*---------------------------------------------------------------------------------------------------------
| Function to edit quote
|----------------------------------------------------------------------------------------------------------*/
	function edit($quote_id = 0)
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['quote_details']	= $this->quotes_model->get_quote_details($quote_id);
		$data['quote_items']	= $this->quotes_model->get_quote_items($quote_id);
		$data['clients'] 		= $this->common_model->get_select_option('ci_clients', 'client_id', 'client_name', $data['quote_details']->client_id);
		$data['taxrates'] 		= $this->common_model->get_select_option('ci_tax_rates', 'tax_rate_id', 'tax_rate_name', 1);
		$data['statuses']	 = $this->quotes_model->statuses();
		$data['pagecontent'] 	= 'quotes/editquote';
		$this->load->view('common/holder', $data);
	}
	
/*---------------------------------------------------------------------------------------------------------
| Function to display products to be added in quote 
|----------------------------------------------------------------------------------------------------------*/	
	function items_from_products()
	{
		$data = array();
		$data['products'] = $this->common_model->db_select('ci_products');
		$this->load->view('quotes/products_modal', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete quotes 
|----------------------------------------------------------------------------------------------------------*/		
	function delete_quote($quote_id = 0)
	{
		$this->quotes_model->delete_quote($quote_id);
		$this->session->set_flashdata('success', 'The quote has been deleted successfully !!');
		redirect('quotes');
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete quote item
|----------------------------------------------------------------------------------------------------------*/
	function delete_item($quote_id=0, $item_id=0)
	{
		$this->common_model->deleterecord('ci_quotes_items', 'item_id', $item_id);
		$this->session->set_flashdata('success', 'The item has been deleted successfully !!');
		redirect('quotes/edit/'.$quote_id);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to preview a quote
|----------------------------------------------------------------------------------------------------------*/	
	function previewquote($quote_id = 0)
	{
		$data 						= array();
		$data['title'] 				= $this->title;
		$data['quote_details']		= $this->quotes_model->previewquote($quote_id);
		$this->load->view('quotes/previewquote', $data);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to preview a quote in pdf format
|----------------------------------------------------------------------------------------------------------*/	
	function viewpdf($quote_id)
	{
		$data 		  = array();
		$data['title'] 	 = $this->title;
		
		$quote_details = $this->quotes_model->previewquote($quote_id);
		$this->load->helper('pdf');
		$pdf_quote = generate_pdf_quote($quote_details, true, NULL);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to convert quote to invoice
|----------------------------------------------------------------------------------------------------------*/	
	function convert_quote($quote_id = 0){
		$invoice_id = $this->quotes_model->convertQuote($quote_id);
		$this->session->set_flashdata('success', 'The invoice has been generated successfully, you can now edit it !!');
		redirect('invoices/edit/'.$invoice_id);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to send quote to client
|----------------------------------------------------------------------------------------------------------*/	
	function emailclient($quote_id = 0)
	{
		$data 						= array();
		$data['title'] 				= $this->title;
		$data['quote_details']		= $this->quotes_model->get_quote_details($quote_id);
		$data['email_templates'] 	= $this->common_model->get_select_option('ci_email_templates', 'template_id', 'template_title');
		$this->load->view('quotes/emailclient', $data);
	}
	function ajax_send_email()
	{
		$this->form_validation->set_rules('client_name', 'client name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email_subject', 'email subject', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email_template', 'email template', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email_body', 'email body', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run())
		{
			$this->load->helper('template');
			$quote_id 	= $this->input->post('quote_id');
			$email_subject 	= $this->input->post('email_subject');
			$email_body 	= $this->input->post('email_body');
			
			$quote_data = $this->quotes_model->get_quote_details($quote_id);
			$message_body = parse_template($quote_data, $email_body);
			$quote_details = $this->quotes_model->previewquote($quote_id);
			$this->load->helper('pdf');
			$pdf_quote = generate_pdf_quote($quote_details, false, NULL);

			$to = $quote_data->client_email;

			if(send_email($email_subject, $to,  $message_body, $pdf_quote)){
				$this->session->set_flashdata('success', 'The quote has been emailed successfully !!');
				$response = array(
					'success'           => 1,
				);
			}
			else{
				$response = array(
					'success'           => 0,
					'errormsg'          => 'Please set the company name and the company email in system settings first !!',
				);
			}
		}
		else
		{
			$this->load->helper('json_error');
				$response = array(
					'success'           => 0,
					'validation_errors' => json_errors()
				);
			
		}
		echo json_encode($response);
	}
	
}