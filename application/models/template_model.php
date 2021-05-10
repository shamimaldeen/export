<?php
 class Template_model extends CI_Model 
{
	function get_template($template_id)
	{
		$this->db->select('*');
		$this->db->from('ci_email_templates');
		$this->db->where('template_id', $template_id);
		$template = $this->db->get()->row();
		return $template->email_body;
	}
	function delete_template($template_id = 0){
		//delete email template
		$this->db->where('template_id', $template_id);
		$this->db->delete('ci_email_templates');
	}
		
}
