<?php
 class Settings_model extends CI_Model 
{
    function savesettings($data = array()){
    	$this->db->select('*');
    	$this->db->from('ci_config');
    	$this->db->limit(1);
    	$settings = $this->db->get()->row();
    	if(!empty($settings)){
    		$this->db->update('ci_config', $data); 
    	}
    	else{
    		$this->db->insert('ci_config', $data); 
    	}
    }
}
