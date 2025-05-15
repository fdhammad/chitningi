<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Course_reg_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->current_session = current_session();
		$this->current_semester = current_semester();
	}

	public function getRegistered($student_id, $course_id, $class_id)
	{
		return $this->db->select('course_reg.id as `id`,course_reg.course_id,course_reg.subject_id as `subject_id`,subjects.name as `subject`,subjects.status as `status`,subjects.unit as `unit`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`')
			->from('course_reg')
			->join('students', 'students.id = course_reg.student_id', 'left')
			->join('subjects', 'subjects.id = course_reg.subject_id', 'left')
			->join('classes', 'classes.id = course_reg.class_id', 'left')
			->join('semesters', 'semesters.id = course_reg.semester_id', 'left')
			->join('sessions', 'sessions.id = course_reg.session_id', 'left')
			//->where('course_reg.course_id', $course_id)
			//->where('course_reg.class_id', $class_id)
			->where('course_reg.student_id', $student_id)

			->where('course_reg.semester_id', $this->current_semester)
			->where('course_reg.session_id', $this->current_session)
			->order_by('subjects.code', 'asc')
			->get()
			->result();
	}
	public function get_Reg($student_id, $semester_id, $session_id)
	{
		return $this->db->select('course_reg.id as `id`,course_reg.course_id,course_reg.subject_id as `subject_id`,subjects.name as `subject`,subjects.status as `status`,subjects.unit as `unit`,subjects.code as `code`,semesters.semester as `semester`')
			->from('course_reg')
			->join('students', 'students.id = course_reg.student_id', 'right')
			->join('subjects', 'subjects.id = course_reg.subject_id')
			//->join('classes', 'classes.id = course_reg.class_id')
			->join('semesters', 'semesters.id = course_reg.semester_id')
			->join('sessions', 'sessions.id = course_reg.session_id')
			//->where('course_reg.course_id', $course_id)
			//->where('course_reg.class_id', $class_id)
			->where('course_reg.student_id', $student_id)
			->where('course_reg.semester_id', $semester_id)
			->where('course_reg.session_id', $session_id)
			->order_by('subjects.code', 'asc')
			->get()
			->result();
	}

	public function getSum($class_id, $course_id)
	{


		$this->db->select_sum('subjects.unit');
		$this->db->from('registrable_courses');
		$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id', 'left');
		$this->db->where('registrable_courses.course_id', $course_id);
		$this->db->where('registrable_courses.class_id', $class_id);
		$this->db->where('registrable_courses.semester_id', $this->current_semester);
		$query = $this->db->get();
		return $query->row();
	}
	public function getSumReg($student_id, $class_id, $course_id)
	{


		$this->db->select_sum('subjects.unit');
		$this->db->from('course_reg');
		$this->db->join('subjects', 'subjects.id = course_reg.subject_id', 'left');
		//$this->db->where('course_reg.course_id', $course_id);
		$this->db->where('course_reg.student_id', $student_id);
		//$this->db->where('course_reg.class_id', $class_id);
		$this->db->where('course_reg.semester_id', $this->current_semester);
		$this->db->where('course_reg.session_id', $this->current_session);
		$query = $this->db->get();
		return $query->row()->unit;
	}

	public function get_reg_id($student_id, $course_id, $class_id)
	{
		$this->db->select('course_reg.id as `id`,course_reg.subject_id as `subject_id');
		$this->db->join('subjects', 'subjects.id = course_reg.subject_id');
		//$this->db->where('course_reg.course_id', $course_id);
		//$this->db->where('course_reg.class_id', $class_id);
		$this->db->where('course_reg.student_id', $student_id);
		//$this->db->where('course_reg.semester_id', $this->current_semester);
		$this->db->where('course_reg.session_id', $this->current_session);
		$this->db->order_by('subjects.code', 'asc');
		$query = $this->db->get('course_reg');
		$array = array();

		foreach ($query->result() as $key => $row) {
			$array[] = $row->subject_id; // add each user id to the array
		}

		return $array;
	}
	public function addStatus($data)
	{
		$this->db->where('session_id', $data['session_id']);
		//$this->db->where('class_id', $data['class_id']);
		$this->db->where('semester_id', $data['semester_id']);
		$this->db->where('student_id', $data['student_id']);
		$q = $this->db->get('regcourses');
		if ($q->num_rows() > 0) {
			$rec = $q->row_array();
			$this->db->where('id', $rec['id']);
			$this->db->update('regcourses', $data);
			return true;
		} else {
			$this->db->insert('regcourses', $data);
			return $this->db->insert_id();
			return false;
		}
	}

	public function reg($subject_array)
	{
		$this->db->trans_begin();
		$course_array = array();
		if (is_array($subject_array)) :
			foreach ($subject_array as $vec_value) :
				$data_array = array(
					'student_id' => $this->input->post('student_id'),
					'session_id' => $this->input->post('session_id'),
					'reg_no' => $this->input->post('reg_no'),
					//'school_id' => $this->input->post('school_id'),
					'class_id' => 	$this->input->post('class_id'),
					'semester_id' => $this->input->post('semester_id'),
					'course_id' => $this->input->post('course_id'),
					'subject_id' => $vec_value->subject_id,
				);
				$course_array[] = $data_array;
			endforeach;
			$this->db->insert_batch('course_reg', $course_array);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return FALSE;
			} else {
				$this->db->trans_commit();
				return TRUE;
			}
		else :
			$this->db->trans_rollback();
			return FALSE;
		endif;
	}

	function delete_reg($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('course_reg');
	}
}
