<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Department_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id = null)
	{

		$this->db->select('departments.*, schools.school, schools.code')->from('departments');
		$this->db->join('schools', 'schools.id = departments.school_id', 'left');

		if ($id != null) {
			$this->db->where('id', $id);
		} else {
			$this->db->order_by('id');
		}
		$query = $this->db->get();
		if ($id != null) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}

		// echo $this->db->last_query();
		// exit();
	}

	public function add($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('departments', $data);
		} else {
			$this->db->insert('departments', $data);
		}
		return true;
	}

	/* function update()
	{
	} */

	public function get_by_id($id)
	{
		$this->db->select('departments.*, schools.school, schools.code');
		$this->db->from('departments');
		$this->db->join('schools', 'schools.id = departments.school_id', 'left');
		$this->db->where('departments.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('departments');
	}
	/* function delete($id)
	{
		$this->db->query("delete from departments where id='" . $id . "'");
	} */
}
