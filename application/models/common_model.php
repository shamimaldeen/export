<?php
 class Common_model extends CI_Model 
{
	function dbinsert ($tablename, $details)
    {
		if($this->db->insert ($tablename, $details))
		{
			return true;
		}
		else
		{
			return false;
		}
    }
	function get_tax($tax_id = 0)
	{
		$this->db->select('tax_rate_percent');
		$this->db->from('ci_tax_rates');
		$this->db->where('tax_rate_id', $tax_id);
		$tax_record = $this->db->get()->row();
		if(!empty($tax_record)){
			$rate = $tax_record->tax_rate_percent  / 100; 
		}
		else{
			$rate = 0;  
		}
		return $rate;
	}
	function saverecord($tablename, $details)
	{
		$this->db->insert ($tablename, $details);
		return $this->db->insert_id();
	}
	function db_select ($tablename)
    {
    	$query = $this->db->query("SELECT * FROM $tablename"); 
    	return $query;
    }
	function update_records($table, $field, $fieldvalue, $data)
    {
         $this->db->where( $field, $fieldvalue);
         $this->db->update($table, $data);
        return TRUE;

    }
	function select_record($tablename, $idname, $idvalue)
	{
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where($idname, $idvalue);
		$results = $this->db->get();
		return $results->row();
	}
	function deleterecord($tablename, $idname, $idvalue)
	{
		$this->db->where($idname, $idvalue);
		$this->db->delete($tablename);
	}
	function get_select_option($table,$id,$name,$selected=0){
		$query = $this->db->get($table);
		$select = '<option value="">SELECT</option>';
		if($query->num_rows()>0){
			foreach($query->result_array() as $row){
			$selected_option = ($selected==$row[$id]) ? ' selected="selected" ':' ';
				$select.='<option value="'.$row[$id].'" '. $selected_option.'>'.trim(strtoupper($row[$name])).'</option>';
			}
		}
		return $select;
	}
	function get_last_id($table_name = '', $field_name)
	{
		$this->db->select_max($field_name);
		$this->db->from($table_name);
		$results = $this->db->get()->row();
		if($results->$field_name == '')
		{
			$last_id = 0;
		}
		else
		{
			$last_id = $results->$field_name;
		}
		return $last_id;
	}
	function get_siteconfig($key)
	{
		$this->db->select($key);
		$this->db->from('ci_config');
		$setting = $this->db->get();
		if( $setting->num_rows() > 0){
			$config = $setting->row();
			$value = $config->$key;
		}
		else{
			$value = '';
		}
		return $value;
	}

}
