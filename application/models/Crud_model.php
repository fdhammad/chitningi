<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (file_exists("application/aws-module/aws-autoloader.php")) {
	//include APPPATH . 'aws-module/aws-autoloader.php';
}
//v5.7
class Crud_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	public function getstate($id = null)
	{

		$this->db->select()->from('states');
		if ($id != null) {
			$this->db->where('id', $id);
		} else {
			$this->db->order_by('id');
		}
		$query = $this->db->get();
		if ($id != null) {
			$statelist = $query->row_array();
		} else {
			$statelist = $query->result_array();
		}

		// echo $this->db->last_query();
		// exit();
		return $statelist;
	}
	public function getStateByLocal($stateid)
	{
		$this->db->select('local_g.id,local_g.state_id,local_g.name');
		$this->db->from('local_g');
		$this->db->join('states', 'states.id = local_g.state_id');
		$this->db->where('local_g.state_id', $stateid);
		$this->db->order_by('local_g.id');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getDepartmentsBySchool($school_id)
	{
		$this->db->select('departments.id,departments.school_id,departments.name');
		$this->db->from('departments');
		$this->db->join('schools', 'schools.id = departments.school_id');
		$this->db->where('departments.school_id', $school_id);
		$this->db->order_by('departments.id');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCoursesByDept($department_id)
	{
		$this->db->select('courses.id,courses.department_id,courses.name,courses.code,courses.year');
		$this->db->from('courses');
		$this->db->join('departments', 'departments.id = courses.department_id');
		$this->db->where('courses.department_id', $department_id);
		$this->db->order_by('courses.id');
		$query = $this->db->get();
		return $query->result_array();
	}
}
