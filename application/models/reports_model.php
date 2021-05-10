<?php
 class Reports_model extends CI_Model 
{
	function payments_summary($client = 'all', $from_date = '', $to_date = '')
	{
		$this->db->select('*');
		$this->db->from('ci_payments');
		$this->db->join('ci_payment_methods', 'ci_payment_methods.payment_method_id = ci_payments.payment_method_id', 'LEFT');
		$this->db->join('ci_invoices', 'ci_invoices.invoice_id = ci_payments.invoice_id');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		if($client != 'all')
		{
			$this->db->where('ci_invoices.client_id', $client);
		}
		if($from_date != '' && $to_date != '')
		{
		$this->db->where('payment_date >=', date('Y-m-d', strtotime($from_date)));
		$this->db->where('payment_date <=', date('Y-m-d', strtotime($to_date)));
		}
		$this->db->order_by('ci_payments.payment_date', 'desc');
		$payment_results = $this->db->get();
		return $payment_results;
	}
	function client_statement($client_id = 0)
	{
		$statement = array();
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('client_id', $client_id);
		$this->db->order_by('ci_invoices.invoice_date_created', 'ASC');
		$invoices = $this->db->get();
		$counter = 0;
		foreach($invoices->result_array() as $count=>$invoice)
		{
			$this->db->select('*');
			$this->db->from('ci_payments');
			$this->db->where('invoice_id', $invoice['invoice_id']);
			$this->db->join('ci_payment_methods', 'ci_payment_methods.payment_method_id = ci_payments.payment_method_id', 'LEFT');
			$this->db->order_by('ci_payments.payment_date', 'ASC');
			$payments = $this->db->get();
			$status = ($payments->num_rows() > 0 && $invoice['invoice_status'] !='PAID') ? 'PARTIALLY PAID' : $invoice['invoice_status'];

			$invoice_amount = $this->get_invoice_total_amount($invoice['invoice_id']);

			$statement[$counter]['date']		=	$invoice['invoice_date_created'];
			$statement[$counter]['activity']	=	'Invoice Generated (#'.$invoice['invoice_number'].' - '.$status.')';
			$statement[$counter]['amount']		=	$invoice_amount['amount'];
			$statement[$counter]['transaction_type'] = 'invoice';
			
			$counter++;
			
			foreach($payments->result_array() as $payments_count=>$payment)
			{
				$statement[$counter]['date']		=	$payment['payment_date'];
				$statement[$counter]['activity']	=	'Payment Received ('.$payment['payment_method_name'].')';
				$statement[$counter]['amount']		=	$payment['payment_amount'];
				$statement[$counter]['transaction_type'] = 'payment';
				$counter++;
			}
		}
		return array_multi_subsort($statement, 'date');
	}
	function client_stats($client_id = 0){
		$stats = array();
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->where('client_id', $client_id);
		$this->db->order_by('ci_invoices.invoice_date_created', 'DESC');
		$invoices = $this->db->get();
		$counter = 0;
		$total_invoiced = 0; 
		$total_received = 0; 
		foreach($invoices->result_array() as $count=>$invoice)
		{		
			//get invoices totals
			$invoice_amount = $this->get_invoice_total_amount($invoice['invoice_id']);
			$total_received += $invoice_amount['amount_paid'];			
			$total_invoiced += $invoice_amount['amount'];
		}
		$stats['total_invoiced']		=	$total_invoiced;
		$stats['total_received']		=	$total_received;
		$stats['pending_balance']		=	$total_invoiced  - $total_received;
		return $stats;
	}
	function invoices_report($client_id = 0)
	{
		$invoices_report = array();
		$this->db->select('*');
		$this->db->from('ci_invoices');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_invoices.client_id');
		if($client_id != 0)
		{	
			$this->db->where('ci_invoices.client_id', $client_id);
		}
		$this->db->order_by('ci_invoices.invoice_date_created', 'DESC');
		$invoices = $this->db->get();
		$counter = 0;
		foreach($invoices->result_array() as $count=>$invoice)
		{
			$invoice_amount = $this->get_invoice_total_amount($invoice['invoice_id']);
			$status = ($invoice_amount['amount_paid'] > 0 && $invoice_amount['amount_paid'] < $invoice_amount['amount']) ? 'PARTIALLY PAID' : $invoice['invoice_status'];
			
			$invoices_report[$counter]['invoice_number']	=	$invoice['invoice_number'];
			$invoices_report[$counter]['invoice_date']		=	$invoice['invoice_date_created'];
			$invoices_report[$counter]['invoice_client']	=	$invoice['client_name'];
			$invoices_report[$counter]['invoice_amount']	=	$invoice_amount['amount'];
			$invoices_report[$counter]['invoice_status'] 	= 	$status;
			$invoices_report[$counter]['invoice_id'] 		= 	$invoice['invoice_id'];

			$counter++;
		}
		return $invoices_report;
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
				$tax = $this->get_tax($item['item_taxrate_id']);
				if (!empty($tax)) {
					$tax_total = $tax_total + (($item_amount * $tax->tax_rate_percent)/100);
				}
			}
			$item_total = $item_total + $item_amount;
			$items_total_discount += $item['item_discount'];
		}

		$invoice_discount = $this->db->select('invoice_discount')->where('invoice_id', $invoice_id)->get('ci_invoices')->row();

		$amount_paid = $this->get_invoice_paid_amount($invoice_id);
		$invoice_totals['amount'] 		= $item_total + $tax_total - $invoice_discount->invoice_discount;
		$invoice_totals['amount_paid'] 	= $amount_paid;

		return $invoice_totals;
	}
	function get_tax($tax_id = 0)
	{
		$this->db->select('tax_rate_percent');
		$this->db->from('ci_tax_rates');
		$this->db->where('tax_rate_id', $tax_id);
		$tax_record = $this->db->get();
		return $tax_record->row();
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
}
