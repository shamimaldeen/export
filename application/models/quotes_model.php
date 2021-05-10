<?php
 class Quotes_model extends CI_Model 
{
	function list_quotes($status = '')
	{
		$this->db->select('ci_quotes.*, ci_clients.client_name');
		$this->db->from('ci_quotes');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_quotes.client_id');
		if($status != '')
		{
		$this->db->where('ci_quotes.quote_status', $status);
		}
		$quotes = $this->db->get()->result_array();
		foreach ($quotes as $count=>$quote)
		{
			$this->db->select('ci_quotes_items.*');
			$this->db->from('ci_quotes_items');
			$this->db->where('quote_id', $quote['quote_id']);
			$item_details = $this->db->get()->result_array();
			
			$item_totals = 0;
			foreach($item_details as $key=>$item)
			{
				$item_cost = ($item['item_price'] * $item['item_quantity']) - $item['item_discount'];
				if($item['Item_tax_rate_id'] != 0)
				{
					$tax_rate = $this->common_model->get_tax($item['Item_tax_rate_id']);
					$item_cost += $item_cost * $tax_rate;
				}
				$item_totals += $item_cost;
			}
			$quotes[$count]['quote_amount'] = $item_totals-$quote['quote_discount'];
		}
		return $quotes;
	}
	
	function statuses()
    {
        return array(
            '0' => array(
                'label' => 'draft',
                'class' => 'label-default',
                'href'  => 'quotes/1'
            ),
            '1' => array(
                'label' => 'sent',
                'class' => 'label-primary',
                'href'  => 'quotes/2'
            ),
            '2' => array(
                'label' => 'viewed',
                'class' => 'label-info',
                'href'  => 'quotes/3'
            ),
            '3' => array(
                'label' => 'approved',
                'class' => 'label-success',
                'href'  => 'quotes/4'
            ),
            '4' => array(
                'label' => 'rejected',
                'class' => 'label-warning',
                'href'  => 'quotes/5'
            ),
            '5' => array(
                'label' => 'canceled',
                'class' => 'label-danger',
                'href'  => 'quotes/6'
            )
        );
    }
	function get_quote_details($quote_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_quotes');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_quotes.client_id');
		$this->db->where('ci_quotes.quote_id', $quote_id);
		$quote_data = $this->db->get()->row();
		$quote_data->totals =  $this->get_quote_total_amount($quote_id);
		return $quote_data;
	}
	
	function get_quote_items($quote_id = 0)
	{
		$this->db->select('*');
		$this->db->from('ci_quotes_items');
		$this->db->where('ci_quotes_items.quote_id', $quote_id);
		$items = $this->db->get()->result_array();
		foreach($items as $item_count=>$item)
		{
			$items[$item_count]['item_total'] = ($item['item_price'] * $item['item_quantity']) - $item['item_discount'];
			if($item['Item_tax_rate_id'] != 0)
			{
				$tax_rate = $this->common_model->get_tax($item['Item_tax_rate_id']);
				$items[$item_count]['item_tax'] = $tax_rate * $items[$item_count]['item_total'];
			}
			else
			{
				$items[$item_count]['item_tax'] = 0;
			}
		}
		return $items;
	}
	
	function delete_quote($quote_id)
	{
		//delete items
		$this->db->where('quote_id', $quote_id);
		$this->db->delete('ci_quotes_items');
		//delete invoices
		$this->db->where('quote_id', $quote_id);
		$this->db->delete('ci_quotes');
	}
	function previewquote($quote_id = 0)
	{
		$quote_data = array();
		$this->db->select('*');
		$this->db->where('ci_quotes.quote_id', $quote_id);
		$this->db->from('ci_quotes');
		$this->db->join('ci_clients', 'ci_clients.client_id = ci_quotes.client_id');
		$quote_data['quote_details'] = $this->db->get()->row();
		//Get invoice items
		$this->db->select('*');
		$this->db->where('ci_quotes_items.quote_id', $quote_id);
		$this->db->from('ci_quotes_items');
		$this->db->join('ci_tax_rates', 'ci_tax_rates.tax_rate_id = ci_quotes_items.item_tax_rate_id', 'left');
		$quote_data['quote_items'] = $this->db->get()->result_array();

		$quote_data['quote_totals'] = $this->get_quote_total_amount($quote_id);

		//return details
		return $quote_data;
	}
	function get_quote_total_amount($quote_id = 0)
	{
		$quote_totals = array();
		$this->db->select('*');
		$this->db->from('ci_quotes_items');
		$this->db->where('quote_id', $quote_id);
		$quote_items = $this->db->get();
		$item_total = 0;
		$tax_total = 0;
		$items_total_discount = 0;
		foreach($quote_items->result_array() as $item_count=>$item)
		{
			$item_amount = ($item['item_quantity'] * $item['item_price']) - $item['item_discount'];
			if($item['Item_tax_rate_id'] != 0)
			{
				$tax = $this->common_model->get_tax($item['Item_tax_rate_id']);
				$tax_total += $item_amount * $tax;
			}
			$item_total = $item_total + $item_amount;
			$items_total_discount += $item['item_discount'];
		}

		$quote_discount = $this->db->select('quote_discount')->where('quote_id', $quote_id)->get('ci_quotes')->row();

		$quote_totals['item_total'] = $item_total;
		$quote_totals['tax_total']  = $tax_total;
		$quote_totals['sub_total']  = $item_total - $quote_discount->quote_discount;
		$quote_totals['amount_due']  =  $quote_totals['sub_total'] + $tax_total;
		return $quote_totals;
	}

	function convertQuote($quote_id){
		$quote = $this->get_quote_details($quote_id);
		$items = $this->get_quote_items($quote_id);

		$invoice = array('user_id' 				=> $this->session->userdata('user_id'),
						 'client_id' 			=> $quote->client_id,
						 'invoice_number' 		=> $this->common_model->get_last_id('ci_invoices', 'invoice_id') + 1,
						 'invoice_terms' 		=> $quote->customer_notes,
						 'invoice_discount'		=> $quote->quote_discount,
						 'invoice_due_date' 	=> date('Y-m-d'),
						 'invoice_date_created' => date('Y-m-d')
						 );

		$invoice_id = $this->common_model->saverecord('ci_invoices', $invoice);

		foreach ($items as $item) {
			$invoice_item = array( 'invoice_id'			=> $invoice_id,
									'item_name'			=> $item['item_name'],
									'item_quantity'		=> $item['item_quantity'],
									'item_description'	=> $item['item_description'],
									'item_taxrate_id'	=> $item['Item_tax_rate_id'],
									'item_order'		=> $item['item_order'],
									'item_price'		=> $item['item_price'],
									'item_discount'		=> $item['item_discount'],
				);
			$this->common_model->saverecord ('ci_invoice_items', $invoice_item);
		}

		$this->delete_quote($quote_id);

		return $invoice_id;
	}
}
