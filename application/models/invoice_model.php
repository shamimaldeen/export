<?php
 class Invoice_model extends CI_Model 
{

	function get_invoices($status = 'all')
	{
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		if($status != 'all')
		{
		$this->db->where('ci_invoices.invoice_status', $status);
		}
		$this->db->order_by('invoice_id', 'DESC');
		$invoices = $this->db->get()->result_array();
		$invoice_amount = 0;
		foreach($invoices as $invoice_count=>$invoice)
		{
			$invoice_totals = $this->get_invoice_total_amount($invoice['invoice_id']);
			$invoices[$invoice_count]['invoice_amount'] = $invoice_totals['item_total'] + $invoice_totals['tax_total'] - $invoice['invoice_discount'];
			$invoices[$invoice_count]['total_paid'] = $invoice_totals['amount_paid'];
		}
		return $invoices;
	}
	function invoice_stats()
	{
		$stats = array();
		//Get unpaid amount
		$stats['unpaid_amount'] = $this->get_total_unpaid_amount();
		$stats['overdue_amount'] = $this->get_total_overdue_amount();
		//Get all invoices
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$stats['all_invoices'] = $this->db->count_all_results();
		//Get all Paid invoices
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('invoice_status', 'paid');
		$stats['paid_invoices'] = $this->db->count_all_results();
		//Get all unpaid invoices
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('invoice_status', 'unpaid');
		$stats['unpaid_invoices'] = $this->db->count_all_results();
		//Get all cancelled invoices
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('invoice_status', 'cancelled');
		$stats['cancelled_invoices'] = $this->db->count_all_results();
		return $stats;
	}
	function recent_invoices()
	{
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$this->db->limit(5);
		$this->db->order_by('ci_invoices.invoice_id', 'DESC');
		$invoices = $this->db->get()->result_array();
		foreach($invoices as $invoice_count=>$invoice)
		{
			$invoice_totals = $this->get_invoice_total_amount($invoice['invoice_id']);
			$invoices[$invoice_count]['invoice_amount'] = $invoice_totals['item_total'] + $invoice_totals['tax_total']-$invoice['invoice_discount'];
			$invoices[$invoice_count]['total_paid'] = $this->get_invoice_paid_amount($invoice['invoice_id']);
		}
		return $invoices;
	}

	function validate_invoice_num($invoice_number, $invoice_id = 0){

			if($invoice_id != 0){
				$this->db->where('invoice_number', $invoice_number);
				$this->db->from('ci_invoices');
				$records = $this->db->get();
				if($records->num_rows() == 1){
					$row = $records->row();
					if($row->invoice_id == $invoice_id)
					{
						return true;
					}
					else{
						return false;
					}
				}
				elseif($records->num_rows() == 0){
					return true;
				}
			}
			else{
				$this->db->where('invoice_number', $invoice_number);
				$this->db->from('ci_invoices');
				$records = $this->db->get();
				if($records->num_rows() == 0){
					return true;
				}
				else{
					return false;
				}
			}
	}
	
	function overdue_invoices()
	{
		$today = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$this->db->where('ci_invoices.invoice_due_date < ', $today);
		$this->db->where('ci_invoices.invoice_status', 'unpaid');
		$this->db->order_by('ci_invoices.invoice_id', 'DESC');
		$invoices = $this->db->get()->result_array();
		foreach($invoices as $invoice_count=>$invoice)
		{
			$invoice_totals = $this->get_invoice_total_amount($invoice['invoice_id']);
			$invoices[$invoice_count]['invoice_amount'] = $invoice_totals['item_total'] + $invoice_totals['tax_total']-$invoice['invoice_discount'];
			$invoices[$invoice_count]['total_paid'] = $this->get_invoice_paid_amount($invoice['invoice_id']);
		}
		return $invoices;
	}
	function get_invoice_details($invoice_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$this->db->where('ci_invoices.invoice_id', $invoice_id);
		return $this->db->get()->row();
	}
	function get_invoice_data($invoice_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$this->db->where('ci_invoices.invoice_id', $invoice_id);
		$invoice_details = $this->db->get()->row();
		
		$invoice_totals 	= $this->get_invoice_total_amount($invoice_id);
		$invoice_paid_amt 	= $this->get_invoice_paid_amount($invoice_id);
		
		$invoice_details->invoice_totals =  $invoice_totals;
		$invoice_details->invoice_total_amount = $invoice_totals['item_total'] + $invoice_totals['tax_total']-$invoice_details->invoice_discount;
		$invoice_details->invoice_total_paid = $invoice_paid_amt;
		$invoice_details->invoice_balance = ($invoice_totals['item_total'] + $invoice_totals['tax_total']-$invoice_details->invoice_discount) - $invoice_paid_amt;
		return $invoice_details;
	}
	function get_invoice_items($invoice_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_invoice_items');
		$this->db->where('ci_invoice_items.invoice_id', $invoice_id);
		$items = $this->db->get()->result_array();
		foreach($items as $item_count=>$item)
		{
			$items[$item_count]['item_total'] = $item['item_price'] * $item['item_quantity'] - $item['item_discount'];
			if($item['item_taxrate_id'] != 0)
			{
				$tax_rate = $this->common_model->get_tax($item['item_taxrate_id']);
				$items[$item_count]['item_tax'] = $tax_rate * $items[$item_count]['item_total'];
			}
			else
			{
				$items[$item_count]['item_tax'] = 0;
			}
		}
		return $items;
	}
	function get_invoice_payments($invoice_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_payments');
		$this->db->join('ci_payment_methods', 'ci_payment_methods.payment_method_id = ci_payments.payment_method_id', 'LEFT');
		$this->db->where('ci_payments.invoice_id', $invoice_id);
		$invoice_payments = $this->db->get();
		return $invoice_payments;
	}
	function delete_invoice($invoice_id = 0)
	{
		//delete items
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('ci_invoice_items');
		//delete payments
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('ci_payments');
		//delete invoices
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('ci_invoices');
	}
	function previewinvoice($invoice_id = 0)
	{
		$invoice_data = array();
		$this->db->select('*');
		$this->db->where('ci_invoices.invoice_id', $invoice_id);
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		$invoice_data['invoice_details'] = $this->db->get()->row();
		//Get invoice items
		$this->db->select('*');
		$this->db->where('ci_invoice_items.invoice_id', $invoice_id);
		$this->db->from('ci_invoice_items');
		$this->db->join('ci_tax_rates', 'ci_tax_rates.tax_rate_id = ci_invoice_items.item_taxrate_id', 'left');
		$invoice_data['invoice_items'] = $this->db->get()->result_array();

		$total_payments_received = $this->get_invoice_paid_amount($invoice_id);
		
		$invoice_data['invoice_totals'] = $this->get_invoice_total_amount($invoice_id);
		//return details
		return $invoice_data;
	}
	function addpayment($invoice_id = 0, $payment_details = array())
	{
		$this->db->insert('ci_payments', $payment_details);
		$invoice_total 	= $this->get_invoice_total_amount($invoice_id);
		if($invoice_total['amount_due'] <= 0 )
		{
			$details = array('invoice_status'=>'PAID');
			$this->db->where('invoice_id', $invoice_id)
					 ->update('ci_invoices', $details);
		}
	}
	function get_invoice_paid_amount($invoice_id = 0)
	{
		$total_paid = 0;
		//get invoice paid amount
		$this->db->select('*');
		$this->db->from('ci_payments');
		$this->db->where('invoice_id', $invoice_id);
		$invoice_payments = $this->db->get();
		$total_paid = 0;
		foreach($invoice_payments->result_array() as $payment_counter=>$payment)
		{
			$total_paid = $total_paid + $payment['payment_amount'];
		}
		return $total_paid;
	}
	function get_invoice_total_amount($invoice_id = 0)
	{
		$invoice_totals = array();
		$this->db->select('*');
		$this->db->from('ci_invoice_items');
		$this->db->where('ci_invoice_items.invoice_id', $invoice_id);
		$invoice_items = $this->db->get();
		$item_total = 0;
		$tax_total = 0;
		$items_total_discount = 0;
		foreach($invoice_items->result_array() as $item_count=>$item)
		{
			$item_amount = ($item['item_quantity'] * $item['item_price']) - $item['item_discount'];
			if($item['item_taxrate_id'] != 0)
			{
				$tax_rate = $this->common_model->get_tax($item['item_taxrate_id']);
				$tax_total += $item_amount * $tax_rate;
			}
			$item_total = $item_total + $item_amount;
			$items_total_discount += $item['item_discount'];
		}

		$invoice = $this->db->select('invoice_discount')->where('invoice_id', $invoice_id)->get('ci_invoices')->row();

		$amount_paid = $this->get_invoice_paid_amount($invoice_id);
		$invoice_totals['item_total'] 			= $item_total;
		$invoice_totals['tax_total']  			= $tax_total;
		$invoice_totals['sub_total'] 			= $item_total + $tax_total;
		$invoice_totals['items_total_discount'] = $items_total_discount;
		$invoice_totals['amount_paid'] 			= $amount_paid;
		$invoice_totals['amount_due'] 			= $item_total + $tax_total - $amount_paid - $invoice->invoice_discount;

		return $invoice_totals;
	}

	function get_total_unpaid_amount()
	{
		$invoices = $this->db->select('*')
				 		->from('ci_invoices')
				 		->get()
				 		->result_array();

		$total_amount = 0;		 

		foreach ($invoices as $invoice) {
			$totals = $this->get_invoice_total_amount($invoice['invoice_id']);
			if($totals['amount_due'] > 0){
				$total_amount += $totals['amount_due'];
			}
		}
		
		return $total_amount ;
	}

	function get_total_overdue_amount()
	{
		$today = date('Y-m-d');
		$this->db->select('*')
				->from('ci_invoices')
				->where('invoice_due_date < ', $today);
		$overdue_invoices = $this->db->get();
		$total_overdue = 0;
		if($overdue_invoices->num_rows() > 0)
		{
		foreach ($overdue_invoices->result_array() as $invoice)
		{
			$totals = $this->get_invoice_total_amount($invoice['invoice_id']);
			if($totals['amount_due'] > 0){
				$total_overdue += $totals['amount_due'];
			}
		}
		}
		return $total_overdue;
	}
		
}
 