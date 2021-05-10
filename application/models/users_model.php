<?php
 class Users_model extends CI_Model 
{
	function selectuser($username, $password)
    {
		$this->db->select('*');
		$this->db->from('ci_users');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
        $query = $this->db->get();
        return $query;
    }
	function select_email($username)
	{
		$this->db->select('*');
		$this->db->from('ci_users');
		$this->db->where('username', $username);
		$user_data = $this->db->get();
		return $user_data;
	}
	function resetpassword($username = '', $password_details = array())
	{
		$this->db->where('username', $username);
		$this->db->update('ci_users', $password_details);
	}
/*---------------------------------------------------------------------------------------------------------
| Function to display users
|----------------------------------------------------------------------------------------------------------*/
	function get_users()
	{
		$logged_user 	=	$this->session->userdata('user_id');
		$this->db->select('*');
		$this->db->from('ci_users');
		$this->db->where ('user_id != ', $logged_user);
		$users = $this->db->get();
		return $users;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to check if username exists
|----------------------------------------------------------------------------------------------------------*/
	function username_exists($username = '')
	{
		$this->db->select('username');
		$this->db->where('username', $username);
		$this->db->from('ci_users');
		$query = $this->db->get();
		if($query->num_rows() > 0) 
		return true;
		else
		return false;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to check if email exists
|----------------------------------------------------------------------------------------------------------*/
	function email_exists($email = '', $userid = '')
	{
		$this->db->select('user_email');
		if($userid != '')
		{
		$this->db->where('user_id != ', $userid);
		}
		$this->db->where('user_email', $email);
		$this->db->from('ci_users');
		$query = $this->db->get();
		if($query->num_rows() > 0) 
		return true;
		else
		return false;
	}
/*---------------------------------------------------------------------------------------------------------
| Function to delete user
|----------------------------------------------------------------------------------------------------------*/
	function delete_user($user_id = 0)
	{
		//delete user
		$this->db->where('user_id', $user_id);
		$this->db->delete('ci_users');
	}
}
