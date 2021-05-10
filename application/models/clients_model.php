<?php
 class Clients_model extends CI_Model 
{
	
/*---------------------------------------------------------------------------------------------------------
| Function to check if email exists
|----------------------------------------------------------------------------------------------------------*/
	function email_exists($email = '', $client_id = '')
	{
		$this->db->select('client_email');
		if($client_id != '')
		{
		$this->db->where('client_id != ', $client_id);
		}
		$this->db->where('client_email', $email);
		$this->db->from('ci_clients');
		$query = $this->db->get();
		if($query->num_rows() > 0) 
		return true;
		else
		return false;
	}
	function delete_client($client_id = 0)
	{
		//delete invoices
		$this->db->select('invoice_id');
		$this->db->where('client_id', $client_id);
		$invoices = $this->db->get('ci_invoices');
		foreach($invoices->result_array() as $count=>$invoice){
		//delete items
		$this->db->where('invoice_id', $invoice['invoice_id']);
		$this->db->delete('ci_invoice_items');
		//delete payments
		$this->db->where('invoice_id', $invoice['invoice_id']);
		$this->db->delete('ci_payments');
		}
		//delete invoices
		$this->db->where('client_id', $client_id);
		$this->db->delete('ci_invoices');
		//delete client
		$this->db->where('client_id', $client_id);
		$this->db->delete('ci_clients');
	}
}
