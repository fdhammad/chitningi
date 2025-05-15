<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Borrow_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->current_session = current_session();
		$this->current_semester = current_semester();
	}

	public function get($course_id,$class_id = null, $semester_id )
	{
		$this->db->select('registrable_courses.id as id,registrable_courses.course_id,registrable_courses.subject_id as `subject_id`,subjects.name as `subject`,subjects.status as `status`,subjects.unit as `unit`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`');
		$this->db->from('registrable_courses');
		$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id', 'left');
		$this->db->join('classes', 'classes.id = registrable_courses.class_id', 'left');
		$this->db->join('semesters', 'semesters.id = registrable_courses.semester_id', 'left');
		if ($class_id != null) {
			$this->db->where('registrable_courses.class_id', $class_id);
		}
		$this->db->where('registrable_courses.course_id', $course_id);
		$this->db->where('registrable_courses.semester_id', $semester_id);
		$this->db->order_by('subjects.code', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_sug_id($course_id,$class_id = null, $semester_id )
	{
		$this->db->select('registrable_courses.id as `id`,registrable_courses.subject_id as `subject_id');
		//$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
		$this->db->where('registrable_courses.course_id', $course_id);
		if ($class_id != null) {
			$this->db->where('registrable_courses.class_id', $class_id);
		}
		$this->db->where('registrable_courses.semester_id', $semester_id);
		$query = $this->db->get('registrable_courses');
		$array = array();
		foreach ($query->result() as $key => $row) {
			$array[] = $row->subject_id; // add each user id to the array
		}
		return $array;
	}

	public function checkSuggestExist($subject_id)
	{
		$course_id = $this->input->post('course_id');
		$class_id = $this->input->post('class_id');
		$semester_id = $this->input->post('semester_id');
		//$student = $this->student_model->get($student_id);
		$this->db->where('subject_id', $subject_id);
		$this->db->where('course_id', $course_id);
		$this->db->where('semester_id', $semester_id);
		$query = $this->db->get('registrable_courses');
		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	public function sug($subject_id)
	{
		$this->db->trans_begin();
		$sections_array = array();
		foreach ($subject_id as $vec_key => $vec_value) {

			$vehicle_array = array(
				'class_id' => $this->input->post('class_id'),
				'semester_id' => $this->input->post('semester_id'),
				'course_id' => $this->input->post('course_id'),
				'subject_id' => $vec_value->subject_id,
			);

			$sections_array[] = $vehicle_array;
		}
		$this->db->insert_batch('registrable_courses', $sections_array);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}
	public function reg($subject_id)
	{
		$this->db->trans_begin();
		$course_array = array();
		if (is_array($subject_id)) :
			foreach ($subject_id as $vec_value) :
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
	public function sug_drop($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('registrable_courses');
		return TRUE;
	}

	public function remove($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->delete('registrable_courses');
		return $result;
	}

	public function deleteBatch($ids, $class_semester_id)
	{

		$this->db->where('class_semester_id', $class_semester_id);
		$this->db->where_not_in('id', $ids);
		$this->db->delete('registrable_courses');
	}
	public function getDetailbyClassSemester($class_id, $semester_id)
	{
		$this->db->select('class_semesters.*,classes.class,semesters.semester')->from('class_semesters');
		$this->db->where('class_id', $class_id);
		$this->db->where('semester_id', $semester_id);
		$this->db->join('classes', 'classes.id = class_semesters.class_id');
		$this->db->where('class_semesters.class_id', $class_id);
		$this->db->join('semesters', 'semesters.id = class_semesters.semester_id');
		$this->db->where('class_semesters.semester_id', $semester_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function add($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('registrable_courses', $data);
		} else {
			$this->db->insert('registrable_courses', $data);
			return $this->db->insert_id();
		}
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
		} else {
			$this->db->insert('regcourses', $data);
			return $this->db->insert_id();
		}
	}
	public function UpdateStatus($student_id, $class_id, $course_id)
	{
		$this->db->set('status', 'Approved');
		$this->db->where('student_id', $student_id);
		$this->db->where('class_id', $class_id);
		$this->db->where('course_id', $course_id);
		$this->db->where('semester_id', $this->current_semester);
		$this->db->where('session_id', $this->current_session);
		$this->db->update('regcourses');
	}
	public function addReg($data)

	{
		$this->db->insert('course_reg', $data);
		return $query = $this->db->insert_id();
	}
	public function add2($data, $sections)
	{
		$this->db->trans_begin();
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('registrable_courses', $data);
			$id = $data['id'];
		} else {
			$this->db->insert('registrable_courses', $data);
			$id = $this->db->insert_id();
		}


		$sections_array = array();
		foreach ($sections as $vec_key => $vec_value) {

			$vehicle_array = array(
				'class_id' => $this->input->post('class_id'),
				'semester_id' => $this->input->post('semester_id'),
				'course_id' => $this->input->post('course_id'),
				'subject_id' => $vec_value,
			);

			$sections_array[] = $vehicle_array;
		}
		$this->db->insert_batch('registrable_courses', $sections_array);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	public function getDetailByclassAndSemester($class_semester_id)
	{
		$this->db->select()->from('registrable_courses');
		$this->db->where('class_semester_id', $class_semester_id);
		$query = $this->db->get();

		return $query->result_array();
	}
	public function getDetailByLecture($department_id, $class_semester_id)
	{
		$this->db->select()->from('teacher_subjects');
		$this->db->where('class_semester_id', $class_semester_id);
		$this->db->where('department_id', $department_id);
		//$this->db->where('teacher_subjects.session_id', $this->current_session);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getCount($class_id, $course_id)
	{
		$this->db->select('sum(subjects.unit) as unit')->from('registrable_courses');
		$this->db->join('courses', 'courses.id = registrable_courses.course_id', 'left');
		$this->db->join('classes', 'classes.id = registrable_courses.class_id', 'left');
		$this->db->join('semesters', 'semesters.id = registrable_courses.semester_id', 'left');
		$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id', 'left');
		$this->db->where('registrable_courses.class_id', $class_id);
		$this->db->where('registrable_courses.course_id', $course_id);
		$this->db->where('registrable_courses.semester_id', $this->current_semester);
		$query = $this->db->query();

		return $query->row()->unit;
	}
	public function getCounts($class_id, $course_id)
	{
		$sql = "SELECT sum(subjects.unit) as unit FROM `registrable_courses` LEFT JOIN `subjects` ON subjects.id = registrable_courses.subject_id WHERE registrable_courses.class_id= $class_id AND registrable_courses.semester_id=$this->current_session AND registrable_courses.course_id= $course_id   ";
		$result = $this->db->query($sql);
		return $result->row()->unit;
	}

	public function getSum($school_id, $class_id, $course_id)
	{


		$this->db->select_sum('subjects.unit');
		$this->db->from('registrable_courses');
		$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id', 'left');
		$this->db->where('registrable_courses.course_id', $course_id);
		$this->db->where('registrable_courses.class_id', $class_id);
		if ($school_id != 4) {
			$this->db->where('registrable_courses.semester_id', $this->current_semester);
		}
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

	function fetch_co($course)
	{
		$this->db->select('subjects.id as `id`,subjects.name as `name`, subjects.code as `code`')->from('registrable_courses');
		$this->db->join('courses', 'courses.id = registrable_courses.course_id', 'left');
		$this->db->join('semesters', 'semesters.id = registrable_courses.semester_id', 'left');
		$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id', 'left');
		$this->db->where('registrable_courses.course_id', $course);
		$this->db->where('registrable_courses.semester_id', $this->current_semester);
		$this->db->order_by('subjects.code', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function getStatus($student_id, $class_id, $course_id)
	{
		$this->db->select('*');
		$this->db->from('regcourses');
		// $this->db->join('subjects', 'subjects.id = course_reg.subject_id');
		//$this->db->where('regcourses.course_id', $course_id);
		$this->db->where('regcourses.student_id', $student_id);
		//$this->db->where('regcourses.class_id', $class_id);
		$this->db->where('regcourses.semester_id', $this->current_semester);
		$this->db->where('regcourses.session_id', $this->current_session);
		$query = $this->db->get();
		return $query->row()->status;
	}

	public function getDetailByclassSemesterAndncecourse($class_id, $semester_id, $course_id)
	{
		$this->db->select()->from('registrable_courses');
		$this->db->where('registrable_courses.class_id', $class_id);
		$this->db->where('registrable_courses.semester_id', $semester_id);
		$this->db->where('registrable_courses.course_id', $course_id);
		$query = $this->db->get();

		return $query->result_array();
	}
	public function getByID($id = null)
	{
		$this->db->select('registrable_courses.id,courses.code as `code`,classes.class as `class`,semesters.semester as `semester`,subjects.name as `subject`,subjects.code as `sub_code`')->from('registrable_courses');
		$this->db->join('courses', 'courses.id = registrable_courses.course_id', 'left');
		$this->db->join('classes', 'classes.id = registrable_courses.class_id', 'left');
		$this->db->join('semesters', 'semesters.id = registrable_courses.semester_id', 'left');
		$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id', 'left');

		if ($id != null) {
			$this->db->where('registrable_courses.id', $id);
		} else {
			$this->db->order_by('registrable_courses.id', 'DESC');
		}

		$query = $this->db->get();
		if ($id != null) {
			$vehicle_routes = $query->result_array();

			$array = array();
			if (!empty($vehicle_routes)) {
				foreach ($vehicle_routes as $vehicle_key => $vehicle_value) {
					$vec_route = new stdClass();
					$vec_route->id = $vehicle_value['id'];


					$vec_route->route_id = $vehicle_value['code'];
					$vec_route->vehicles = $this->getVechileByRoute($vehicle_value['id']);
					$array[] = $vec_route;
				}
			}
			return $array;
		} else {
			$vehicle_routes = $query->result_array();
			$array = array();
			if (!empty($vehicle_routes)) {
				foreach ($vehicle_routes as $vehicle_key => $vehicle_value) {

					$vec_route = new stdClass();
					$vec_route->id = $vehicle_value['id'];
					$vec_route->course = $vehicle_value['code'];
					$vec_route->class = $vehicle_value['class'];
					$vec_route->semester = $vehicle_value['semester'];
					$vec_route->subject = $vehicle_value['sub_code'];


					$vec_route->vehicles = $this->getVechileByRoute($vehicle_value['id']);
					$array[] = $vec_route;
				}
			}
			return $array;
		}
	}
	public function getVechileByRoute($route_id)
	{
		$this->db->select('registrable_courses.id as c_comb_id,registrable_courses.course_id,registrable_courses.subject_id,subjects.*,subjects.name as `subject`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`')->from('registrable_courses');
		$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id');
		$this->db->join('classes', 'classes.id = registrable_courses.class_id');
		$this->db->join('semesters', 'semesters.id = registrable_courses.semester_id');


		$this->db->where('registrable_courses.course_id', $route_id);
		$this->db->order_by('registrable_courses.id', 'asc');
		$query = $this->db->get();
		return $vehicle_routes = $query->result();
	}
	public function getCourseForReg($course_id, $class_id = null)
	{
		$this->db->select('registrable_courses.id as c_comb_id,registrable_courses.course_id,registrable_courses.subject_id as `subject_id`,subjects.*,subjects.name as `subject`,subjects.status as `status`,subjects.unit as `unit`,subjects.code as `code`,classes.class as `class`,semesters.semester as `semester`');
		$this->db->from('registrable_courses');
		$this->db->join('subjects', 'subjects.id = registrable_courses.subject_id', 'left');
		$this->db->join('classes', 'classes.id = registrable_courses.class_id', 'left');
		$this->db->join('semesters', 'semesters.id = registrable_courses.semester_id', 'left');
		$this->db->where('registrable_courses.course_id', $course_id);
		if ($class_id != null) {
			$this->db->where('registrable_courses.class_id', $class_id);
		}
		$this->db->where('registrable_courses.semester_id', $this->current_semester);
		$this->db->order_by('subjects.code', 'asc');
		$query = $this->db->get();
		return $query->result();
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
	public function checkStudentCourseExist($data)
	{
		$student_id = $this->input->post('student_id');
		//$student = $this->student_model->get($student_id);
		$this->db->where('subject_id', $data);
		$this->db->where('student_id', $student_id);
		$this->db->where('course_reg.session_id', $this->current_session);
		$query = $this->db->get('course_reg');
		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	public function drop($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('course_reg');
	}

	/* public function reg($subject_id)
	{
		$this->db->trans_begin();


		$sections_array = array();
		foreach ($subject_id as $vec_key => $vec_value) {

			$vehicle_array = array(
				'student_id' => $this->input->post('student_id'),
				'session_id' => $this->input->post('session_id'),
				'reg_no' => $this->input->post('reg_no'),
				'school_id' => $this->input->post('school_id'),
				'class_id' => $this->input->post('class_id'),
				'semester_id' => $this->input->post('semester_id'),
				'course_id' => $this->input->post('course_id'),
				'subject_id' => $vec_value->subject_id,
			);

			$sections_array[] = $vehicle_array;
		}
		$this->db->insert_batch('course_reg', $sections_array);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	} */
}
