<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Subject_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id = null)
	{

		$this->db->select('subjects.*, courses.name as 	`course`, courses.code as `course_code`,classes.class,semesters.semester')->from('subjects');
		$this->db->join('courses', 'courses.id = subjects.course_id', 'left');
		$this->db->join('classes', 'classes.id = subjects.class_id', 'left');
		$this->db->join('semesters', 'semesters.id = subjects.semester_id', 'left');

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
			$this->db->update('subjects', $data);
			return true;
		} else {
			$this->db->insert('subjects', $data);
			return $this->db->insert_id();
		}
	}

	/* function update()
	{
	} */

	public function get_by_id($id)
	{
		$this->db->select('subjects.*, courses.name as 	`course`, courses.code as `course_code`,classes.class,semesters.semester')->from('subjects');
		$this->db->join('courses', 'courses.id = subjects.course_id', 'left');
		$this->db->join('classes', 'classes.id = subjects.class_id', 'left');
		$this->db->join('semesters', 'semesters.id = subjects.semester_id', 'left');

		$this->db->where('subjects.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('subjects');
	}
	/* function delete($id)
	{
		$this->db->query("delete from subjects where id='" . $id . "'");
	} */

	public function getsubjectsBySchool($school_id)
	{
		$this->db->select('subjects.id,subjects.school_id,subjects.name');
		$this->db->from('subjects');
		$this->db->join('schools', 'schools.id = subjects.school_id');
		$this->db->where('subjects.school_id', $school_id);
		$this->db->order_by('subjects.id');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getSubjectByCourseClass($course = null, $class = null, $semester = null)
	{
		$this->db->select('*')->from('subjects');
		$this->db->where('subjects.course_id', $course);
		if ($class != null) {
			$this->db->where('subjects.class_id', $class);
		}
		$this->db->where('subjects.semester_id', $semester);
		$this->db->order_by('code', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function check_subject_duplication($code = "")
	{
		$duplicate_subject_check = $this->db->get_where('subjects', array('code' => $code));
		if ($duplicate_subject_check->num_rows() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function getSubjectForSug($semester_id, $class_id = null)
	{
		$this->db->select('subjects.*')->from('subjects');
		//$this->db->join('classes', 'subjects.class_id = classes.id', 'left');
		//$this->db->join('semesters', 'semesters.id = subjects.semester_id', 'left');
		//$this->db->join('departments', 'departments.id = subjects.department_id', 'left');
		if ($class_id != null) {
			$this->db->where('subjects.class_id', $class_id);
		}
		$this->db->where('subjects.semester_id', $semester_id);
		$this->db->order_by('subjects.code', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_by_code($course_code)
	{
		return $this->db->get_where('subjects', ['code' => $course_code])->row_array();
	}
}
