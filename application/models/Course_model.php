<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Course_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id = null)
	{

		$this->db->select('courses.*, schools.school, schools.code as `sch_code`, departments.name as `department`')->from('courses');
		$this->db->join('schools', 'schools.id = courses.school_id', 'left');
		$this->db->join('departments', 'departments.id = courses.department_id', 'left');

		if ($id != null) {
			$this->db->where('courses.id', $id);
		} else {
			$this->db->order_by('courses.id');
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
			$this->db->update('courses', $data);
		} else {
			$this->db->insert('courses', $data);
		}
		return true;
	}

	/* function update()
	{
	} */

	public function get_by_id($id)
	{
		$this->db->select('courses.*, schools.school, schools.code as `sch_code`, departments.name as `department`');
		$this->db->from('courses');
		$this->db->join('schools', 'schools.id = courses.school_id', 'left');
		$this->db->join('departments', 'departments.id = courses.department_id', 'left');
		$this->db->where('courses.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('courses');
	}
	/* function delete($id)
	{
		$this->db->query("delete from departments where id='" . $id . "'");
	} */
}
