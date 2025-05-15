<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Token_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function add($data)
	{

		$this->db->insert('tokens', $data);
		return $this->db->insert_id();
	}

	function get()
	{
		$this->db->select('*,tokens.id as id, staff.firstname as name, staff.lastname');
		$this->db->from('tokens');
		$this->db->join('staff', 'staff.id = tokens.staff_id', 'left');
		$query = $this->db->get();
		return $query->result_array();
	}
	function getTokens($id)
	{
		$this->db->select('token,application_no,open_p');
		$this->db->from('applicants');
		$this->db->where('token_id', $id);
		$query = $this->db->get();
		return $query->result();
	}
}
