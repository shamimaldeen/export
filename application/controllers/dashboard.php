<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	protected $title 		= 'Dashboard';
	protected $activemenu 	= 'dashboard';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_model');
		is_logged_in();
	}
	public function index()
	{
		$data = array();
		$data['title'] 			= $this->title;
		$data['activemenu'] 	= $this->activemenu;
		$data['invoice_stats']	= $this->invoice_model->invoice_stats();
		$data['recent_invoices']= $this->invoice_model->recent_invoices();
		$data['pagecontent'] 	= 'dashboard/dashboard';
		$this->load->view('common/holder', $data);
	}
}