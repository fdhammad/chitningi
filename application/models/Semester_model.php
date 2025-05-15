<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Semester_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		//$this->current_semester = $this->setting_model->getCurrentSemester();
	}


	public function get($id = null)
	{
		$this->db->select()->from('semesters');
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
	}
	public function add($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('semesters', $data);
		} else {
			$this->db->insert('semesters', $data);
		}
		return true;
	}
	public function get_by_id($id)
	{
		$this->db->select();
		$this->db->from('semesters');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getName($id)
	{
		$this->db->select('semester')->from('semesters');
		$this->db->order_by('id');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('semesters');
	}
}
