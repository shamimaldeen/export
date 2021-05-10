<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function parse_template($object, $body)
{
    if (preg_match_all('/\[(.*?)\]/', $body, $template_vars))
    {
        $replace ='';
        foreach ($template_vars[1] as $var)
        {
            switch ($var)
            {
                case 'invoice_id':
                    if(isset($object->invoice_id)){
                    $replace = $object->invoice_id;
                    }
                    break;
                case 'invoice_number':
                    if(isset($object->invoice_number)){
                    $replace = $object->invoice_number;
                    }
                    
                    break;
                case 'invoice_total':
                    if(isset($object->invoice_total_amount)){
                    $replace = $object->invoice_total_amount;
                    }
                   
                    break;
                case 'invoice_date_created':
                    if(isset($object->invoice_date_created)){
                    $replace = $object->invoice_date_created;
                    }
                    break;
                case 'invoice_due_date':
                    if(isset($object->invoice_due_date)){
                    $replace = $object->invoice_due_date;
                    }
                    break;
                case 'invoice_amount':
                     if(isset($object->invoice_amount)){
                   $replace = $object->invoice_amount;
                    }
                    break;
                case 'invoice_total_paid':
                    if(isset($object->invoice_total_paid)){
                   $replace = $object->invoice_total_paid;
                    }
                    break;
                case 'invoice_balance':
                    if(isset($object->invoice_balance)){
                   $replace = $object->invoice_balance;
                    }
                    break;
                case 'invoice_terms':
                    if(isset($object->invoice_terms)){
                   $replace = $object->invoice_terms;
                    }
                    break;
                case 'invoice_status':
                     if(isset($object->invoice_status)){
                   $replace = $object->invoice_status;
                    }
                    break;
                case 'invoice_payment_method':
                    if(isset($object->invoice_payment_method)){
                    $replace = $object->invoice_payment_method;
                    }
                    break;
                case 'client_name':
                     if(isset($object->client_name)){
                    $replace = $object->client_name;
                    }
                    break;
                case 'client_address':
                    if(isset($object->client_address)){
                    $replace = $object->client_address;
                    }
                break;
                case 'client_city':
                    if(isset($object->client_city)){
                    $replace = $object->client_city;
                    }
                    
                break;
                case 'client_state':
                    if(isset($object->client_state)){
                    $replace = $object->client_state;
                    }
                break;
                case 'client_country':
                    if(isset($object->client_country)){
                    $replace = $object->client_country;
                    }
                break;
                
                    case 'quote_date':
                    if(isset($object->date_created)){
                    $replace = $object->date_created;
                    }
                break;
                    case 'quote_number':
                    if(isset($object->quote_id)){
                    $replace = $object->quote_id;
                    }
                break;
                    case 'date_valid':
                    if(isset($object->valid_until)){
                    $replace = $object->valid_until;
                    }
                break;
                case 'quote_subject':
                    if(isset($object->quote_subject)){
                    $replace = $object->quote_subject;
                    }
                break;
                default:
                    $replace = '';
            }

            $body = str_replace('[' . $var . ']', $replace, $body);
        }
    }
    return $body;
}
?>