<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_session_details() 
{
	$CI =& get_instance();
	$data = (object)$CI->session->all_userdata();
	return $data;
}
function is_logged_in()
{
	$CI =& get_instance();
	$is_logged_in = $CI->session->userdata('user_id');
	if(!isset($is_logged_in) || $is_logged_in != true)
	{
		redirect (base_url());   
	}       
}


function get_siteconfig($key = '')
{
	$CI =& get_instance();
	$setting = $CI->common_model->get_siteconfig($key);
	return $setting;
}
// check installer 
function check_installer(){
	$CI = & get_instance();
	$CI->load->database();
	$CI->load->dbutil();
	if ($CI->db->database == "") {
		redirect('install');

	} else {
		if (!$CI->dbutil->database_exists($CI->db->database))
		{
			redirect('install/index.php?e=db');

		}else if (is_dir('install')) {
			redirect('install/index.php?e=folder');
		}
	}
}

//selected country would be retrieved from a database or as post data
function  country_dropdown($name, $id, $class, $selected_country,$top_countries=array(), $all, $selection=NULL, $show_all=TRUE ){
	// You may want to pull this from an array within the helper
	$countries = config_item('country_list');

	$html = "<select name='{$name}' id='{$id}' class='{$class}'>";
	$selected = NULL;
	if(in_array($selection,$top_countries)){
		$top_selection = $selection;
		$all_selection = NULL;
	}else{
		$top_selection = NULL;
		$all_selection = $selection;
	}
	if(!empty($selected_country)&&$selected_country!='all'&&$selected_country!='select'){
		$html .= "<optgroup label='Selected Country'>";
		if($selected_country === $top_selection){
			$selected = "SELECTED";
		}
		$html .= "<option value='{$selected_country}'{$selected}>{$countries[$selected_country]}</option>";
		$selected = NULL;
		$html .= "</optgroup>";
	}else if($selected_country=='all'){
		$html .= "<optgroup label='Selected Country'>";
		if($selected_country === $top_selection){
			$selected = "SELECTED";
		}
		$html .= "<option value='all'>All</option>";
		$selected = NULL;
		$html .= "</optgroup>";
	}else if($selected_country=='select'){
		$html .= "<optgroup label='Selected Country'>";
		if($selected_country === $top_selection){
			$selected = "SELECTED";
		}
		$html .= "<option value='select'>Select</option>";
		$selected = NULL;
		$html .= "</optgroup>";
	}
	if(!empty($all)&&$all=='all'&&$selected_country!='all'){
		$html .= "<option value='all'>All</option>";
		$selected = NULL;
	}
	if(!empty($all)&&$all=='select'&&$selected_country!='select'){
		$html .= "<option value='select'>Select</option>";
		$selected = NULL;
	}
	
	if(!empty($top_countries)){
		$html .= "<optgroup label='Top Countries'>";
		foreach($top_countries as $value){
			if(array_key_exists($value, $countries)){
				if($value === $top_selection){
					$selected = "SELECTED";
				}
			$html .= "<option value='{$value}'{$selected}>{$countries[$value]}</option>";
			$selected = NULL;
			}
		}
		$html .= "</optgroup>";
	}

	if($show_all){
		$html .= "<optgroup label='All Countries'>";
		foreach($countries as $key => $country){
			if($key === $all_selection){
				$selected = "SELECTED";
			}
			$html .= "<option value='{$key}'{$selected}>{$country}</option>";
			$selected = NULL;
		}
		$html .= "</optgroup>";
	}
	
	$html .= "</select>";
	return $html;
    }
function limit_text($string, $limit) 
{
	if (strlen($string) >= $limit)
	return substr($string, 0, $limit-1)." ..."; // This is a test...
	else
	return $string;
}
function get_tax_select($tax_id)
{
	$CI =& get_instance();
	$tax_rates = $CI->common_model->get_select_option('ci_tax_rates', 'tax_rate_id', 'tax_rate_name', $tax_id);
	return $tax_rates;
}

function array_multi_subsort($array, $subkey)
{
    $b = array(); $c = array();

    foreach ($array as $k => $v)
    {
        $b[$k] = strtolower($v[$subkey]);
    }

    asort($b);
    foreach ($b as $key => $val)
    {
        $c[] = $array[$key];
    }

    return $c;
}

function format_amount($amount = 0, $symbol=true, $symbol_placement='before'){
	if($symbol){
		$CI =& get_instance();
		$currency = $CI->common_model->get_siteconfig('currency');
	}
	$formatted_amt = number_format($amount, 2);

	if($symbol_placement=='after'){
		$formatted_amt = (isset($currency)) ? $formatted_amt.$currency : $formatted_amt;
	}
	else{
		$formatted_amt = (isset($currency)) ? $currency.$formatted_amt : $formatted_amt;
	}
	return $formatted_amt;
}

function invoice_status($status = 'UNPAID'){
	if($status == 'UNPAID')
		$class = 'invoice_status_unpaid';
	 elseif ($status == 'PAID') 
	 	$class = 'invoice_status_paid';
	 elseif ($status == 'CANCELLED') 
	 	$class = 'invoice_status_cancelled';
	 else
	 	$class = 'invoice_status_unpaid';

	$html = '<div class=" '. $class .' pull-right"> '. $status .' </div>';
	return $html;
}
function status_label($status = 'UNPAID'){
	if($status == 'UNPAID')
		$class = 'warning';
	 elseif ($status == 'PAID') 
	 	$class = 'success';
	 elseif ($status == 'CANCELLED') 
	 	$class = 'danger';
	 else
	 	$class = 'warning';

	$html = '<span class="label label-'. $class .' ">'.$status.'</span>';
	return $html;
}

function send_email($subject  = '', $to = '',  $body = '', $attachment = ''){
	$CI =& get_instance();

	$company = get_siteconfig('name');
	$email 	 = get_siteconfig('email');

	if(empty($email) || $email  == ''){
		return false;
	}
	elseif(empty($company) || $company == ''){
		return false;
	}
	else{
		$from_email = $email ;
		$from_name = $company;

		$CI->load->library("email");
		$CI->email->set_mailtype('text');
		$CI->email->set_newline("\r\n");
		$CI->email->from($from_email, $from_name);
		$CI->email->to($to);
		$CI->email->subject($subject);
		$CI->email->message($body);
		
		if($attachment != '')
		$CI->email->attach($attachment);

		if($CI->email->send()){
			return true;
		}

	}
}

function date_format_select($selected = ''){
	$formats = array('d/m/Y' => date('d/m/Y'),
					 'm/d/Y' => date('m/d/Y'),
					 'Y/m/d' => date('Y/m/d'),
					 'F j, Y' => date('F j, Y'),
					 'm.d.y' => date('m.d.Y'),
					 'd-m-Y' => date('d-m-Y'),
					 'D M j Y' => date('D M j Y'),
			
	);
	$select = form_dropdown('date_format', $formats, $selected,  'class="form-control selectpicker" data-live-search="true" id="date_format"');
	return $select;
}

function format_date($date = ''){
	$date_config = get_siteconfig('date_format'); 
	$date_format = ($date_config != '' ) ? $date_config : 'd-m-Y' ;
	$formated_date = date($date_format, strtotime($date));
	return $formated_date;
}
 
