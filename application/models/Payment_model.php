<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Payment_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		//$this->current_class = $this->setting_model->getCurrentclass();
		$this->current_semester = current_semester();
		$this->current_session = current_session();
	}
	public function additems($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('payment_items', $data);
		} else {
			$this->db->insert('payment_items', $data);
			return $this->db->insert_id();
		}
	}

	public function deleteBatch($ids, $department_id, $course_id, $class_id, $semester_id, $payment_type, $indigene)
	{
		$this->db->where('department_id', $department_id);
		$this->db->where('course_id', $course_id);
		$this->db->where('class_id', $class_id);
		$this->db->where('semester_id', $semester_id);
		$this->db->where('payment_type', $payment_type);
		$this->db->where('indigene', $indigene);
		//$this->db->where('session_id', $this->current_session);
		$this->db->where_not_in('id', $ids);
		$this->db->delete('payment_items');
	}


	public function getDetailByItems($payment_type = null, $department_id = null, $course_id = null, $class_id = null, $semester_id = null, $indigene = null)
	{
		$this->db->select()->from('payment_items');
		$this->db->where('payment_type', $payment_type);

		if ($department_id != null) {
			$this->db->where('department_id', $department_id);
		}
		if ($course_id != null) {
			$this->db->where('course_id', $course_id);
		}
		if ($class_id != null) {
			$this->db->where('class_id', $class_id);
		}
		if ($semester_id != null) {
			$this->db->where('semester_id', $semester_id);
		}
		if ($indigene != null) {
			$this->db->where('indigene', $indigene);
		}
		//$this->db->where('teacher_subjects.session_id', $this->current_session);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getPreWeedingAmount()
	{
		$this->db->select_sum('amount')->from('payment_items');
		//$this->db->where('course_id', $course_id);
		$this->db->where('payment_type', 'pre_weeding');
		$query = $this->db->get();

		return $query->row();
	}

	public function getPostWeedingAmount($course_id)
	{
		$this->db->select_sum('amount')->from('payment_items');
		$this->db->where('course_id', $course_id);
		$this->db->where('payment_type', 'post_weeding');
		$query = $this->db->get();

		return $query->row();
	}
	public function getAdmissionAmount()
	{
		$this->db->select_sum('amount')->from('payment_items');
		$this->db->where('payment_type', 'admission_fee');
		$query = $this->db->get();

		return $query->row();
	}

	public function getSemesterAmount($course_id, $indigene, $class_id)
	{
		$this->db->select_sum('amount');
		$this->db->where('course_id', $course_id);
		$this->db->where('class_id', $class_id);
		$this->db->where('indigene', $indigene);
		$this->db->where('payment_type', 'semester');
		$this->db->where('semester_id', $this->current_semester);
		$this->db->from('payment_items');
		$query = $this->db->get();

		return $query->row();
	}
	public function getPreviousSemesterAmount($course_id, $indigene, $class_id)
	{
		$this->db->select_sum('amount');
		$this->db->where('course_id', $course_id);
		$this->db->where('class_id', 1);
		$this->db->where('indigene', $indigene);
		$this->db->where('payment_type', 'semester');
		$this->db->where('semester_id', $this->current_semester);
		$this->db->from('payment_items');
		$query = $this->db->get();

		return $query->row();
	}

	function checkPrePayment($student_id)
	{
		$this->db->select()->from('payment_deposits');
		$this->db->where('student_id', $student_id);
		$this->db->where('status', 'paid');
		$this->db->where('type', 'pre_weeding');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	function checkPostPayment($student_id)
	{
		$this->db->select()->from('payment_deposits');
		$this->db->where('student_id', $student_id);
		$this->db->where('status', 'paid');
		$this->db->where('type', 'post_weeding');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	function checkAdmissionPayment($student_id)
	{
		$this->db->select()->from('payment_deposits');
		$this->db->where('student_id', $student_id);
		$this->db->where('status', 'paid');
		$this->db->where('type', 'admission_fee');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	function checkSemesterPayment($student_id)
	{
		$this->db->select()->from('payment_deposits');
		$this->db->where('student_id', $student_id);
		$this->db->where('status', 'paid');
		$this->db->where('type', 'semester');
		$this->db->where('session_id', $this->current_session);
		$this->db->where('semester_id', $this->current_semester);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	function checkPreviousSemesterPayment($student_id)
	{
		$this->db->select()->from('payment_deposits');
		$this->db->where('student_id', $student_id);
		$this->db->where('status', 'paid');
		$this->db->where('type', 'semester');
		$this->db->where('session_id', $this->current_session - 1);
		$this->db->where('semester_id', $this->current_semester);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}


	public function add_payment($data)
	{
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
		$this->db->insert('payment_deposits', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function getPaymentDeposits($student_id)
	{
		$this->db->select('payment_deposits.id as `id`,payment_deposits.created_at,payment_deposits.txn,payment_deposits.receipt, payment_deposits.amount as `amount`,payment_deposits.status as `status`,payment_deposits.descr as `descr`');
		$this->db->from('payment_deposits');
		$this->db->join('students', 'payment_deposits.student_id = students.id', 'left');
		$this->db->where('payment_deposits.student_id', $student_id);

		$this->db->where('payment_deposits.session_id', $this->current_session);
		//$this->db->where('payment_deposits.id', $id);
		$this->db->order_by('id', 'desc');

		$query = $this->db->get();

		return $query->result_array();
	}
	public function getStudentFees($id = null)
	{
		$this->db->select('payment_deposits.*, semesters.semester, sessions.session,classes.class')->from('payment_deposits');
		$this->db->join('student_session', 'student_session.id = payment_deposits.student_id');
		$this->db->join('students', 'students.id = payment_deposits.student_id');
		$this->db->join('classes', 'payment_deposits.class_id = classes.id');
		$this->db->join('sessions', 'sessions.id = payment_deposits.session_id');
		$this->db->join('semesters', 'semesters.id = payment_deposits.semester_id');
		$this->db->where('payment_deposits.student_id', $id);
		$this->db->where('payment_deposits.session_id', $this->current_session);
		$this->db->where('payment_deposits.semester_id', $this->current_semester);
		$this->db->order_by('payment_deposits.date');
		$query = $this->db->get();
		return $query->result();
	}

	public function gettotal($class_id, $course_id, $student_type)
	{

		$this->db->select_sum('amount');
		$this->db->where('course_id', $course_id);
		$this->db->where('indigene', $student_type);
		$this->db->where('class_id', $class_id);
		$this->db->where('payment_type', 'semester');
		$this->db->where('semester_id', $this->current_semester);
		$this->db->from('payment_items');
		$query = $this->db->get();

		return $query->row();
	}

	public function getSum($student_id, $class_id)
	{
		$this->db->select_sum('amount')->from('payment_deposits');
		$this->db->where('payment_deposits.student_id', $student_id);
		//$this->db->where('payment_deposits.class_id', $class_id);
		$this->db->where('payment_deposits.session_id', $this->current_session);
		$this->db->where('payment_deposits.semester_id', $this->current_semester);

		$query = $this->db->get();

		return $query->row();
	}
	function get_by_ref($rrr)
	{
		$this->db->select('*')->from('payment_deposits');
		$this->db->where('receipt', $rrr);
		//$this->db->where('status', 'paid');
		//$this->db->where('type', 'admission_fee');
		$query = $this->db->get();
		return $query->row_array();
	}
	public function getPaidDeposit($student_id)
	{
		$this->db->select('payment_deposits.id as `id`,payment_deposits.created_at,payment_deposits.txn,payment_deposits.receipt, payment_deposits.amount as `amount`,payment_deposits.status as `status`,payment_deposits.descr as `descr`');
		$this->db->from('payment_deposits');
		$this->db->join('students', 'payment_deposits.student_id = students.id', 'left');
		$this->db->where('payment_deposits.student_id', $student_id);
		$this->db->where('payment_deposits.session_id', $this->current_session);

		$this->db->where('payment_deposits.status', 'paid');
	}

	public function getPreWeedingReceiptDetails($receipt = null)
	{
		$this->db->select('payment_deposits.*,payment_deposits.student_id as `student_id`, payment_deposits.amount as `amount`,students.*,courses.name as `course`');
		$this->db->from('payment_deposits');
		$this->db->join('students', 'payment_deposits.student_id = students.id', 'left');
		$this->db->join('courses', 'students.course_id = courses.id', 'left');
		$this->db->where('payment_deposits.receipt', $receipt);
		$query = $this->db->get();
		return $query->row_array();
	}
	public function all_search($receipt)
	{
		$this->db->where('receipt', $receipt);
		//$this->db->where('student_id', $data['student_id']);
		$O = $this->db->get('applicant_deposits');
		$p = $this->db->get('payment_deposits');
		//$pre = $this->db->get('payment_deposits');
		if ($p->num_rows() > 0) {
			$rec = $p->row_array();
			//if ($rec['descr'] == 'nce') {
			$this->db->select('payment_deposits.*,classes.class as `class`, semesters.semester as `semester`, sessions.session as `session`,courses.name as `course`,courses.code as `code`,students.reg_no as `reg_no` ,students.firstname as `firstname`,students.middlename, students.lastname,students.image,    students.phone, students.email');
			$this->db->from('payment_deposits');
			$this->db->join('students', 'students.id = payment_deposits.student_id');
			$this->db->join('courses', 'courses.id = students.course_id', 'left');
			$this->db->join('classes', 'payment_deposits.class_id = classes.id', 'left');
			$this->db->join('semesters', 'payment_deposits.semester_id = semesters.id', 'left');
			$this->db->join('sessions', 'payment_deposits.session_id = sessions.id');

			$this->db->where('payment_deposits.session_id', $this->current_session);
			//$this->db->where('payment_deposits.semester_id', $this->current_semester);
			$this->db->group_start();
			$this->db->like('payment_deposits.receipt', $receipt);
			$this->db->or_like('payment_deposits.txn', $receipt);
			$this->db->group_end();
			$query = $this->db->get();
			return $query->row();
			//}
		} else {
			$this->db->select('applicant_deposits.*,sessions.session as `session`, states.name as `state`,applicants.application_no as `application_no` ,applicants.firstname as `firstname`,applicants.middlename, applicants.lastname,applicants.image');
			$this->db->from('applicant_deposits');
			$this->db->join('applicants', 'applicants.id = applicant_deposits.applicant_id');
			//$this->db->join('courses', 'courses.id = applicants.course_id', 'left');
			//$this->db->join('classes', 'applicant_deposits.class_id = classes.id', 'left');
			$this->db->join('states', 'applicants.state_id = states.id', 'left');
			//$this->db->join('semesters', 'applicant_deposits.semester_id = semesters.id', 'left');
			$this->db->join('sessions', 'applicant_deposits.session_id = sessions.id');
			$this->db->where('applicant_deposits.receipt', $receipt);
			$query = $this->db->get();
			return $query->row();
		}
	}

	function max_id($code)
	{
		$this->db->from('payment_deposits');
		$this->db->join('students', 'payment_deposits.student_id = students.id');
		$this->db->where('students.course_id', $code);
		$this->db->where('payment_deposits.descr', 'registration');
		$this->db->where('payment_deposits.status', 'paid');
		$this->db->where('payment_deposits.session_id', $this->current_session);
		$count = $this->db->get();
		return $count->num_rows();
	}

	public function getApplicationAllDeposits()
	{
		$this->db->select('applicant_deposits.date,applicant_deposits.status,applicant_deposits.txn,applicant_deposits.receipt,applicant_deposits.amount,applicant_deposits.applicant_id,applicants.firstname as `firstname`,applicants.middlename, applicants.lastname');
		$this->db->from('applicant_deposits');
		$this->db->join('applicants', 'applicant_deposits.applicant_id = applicants.id');
		//$this->db->where('applicant_deposits.descr', 'registration');
		$this->db->where('applicant_deposits.session_id', $this->current_session);
		//$this->db->where('applicant_deposits.semester_id', $this->current_semester);
		$this->db->order_by('applicant_deposits.id', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getStudentAllDeposits()
	{
		$this->db->select('payment_deposits.date,payment_deposits.status,payment_deposits.txn,payment_deposits.receipt,payment_deposits.amount,payment_deposits.student_id,students.reg_no,students.firstname as `firstname`,students.middlename, students.lastname');
		$this->db->from('payment_deposits');
		$this->db->join('students', 'payment_deposits.student_id = students.id');
		//$this->db->where('payment_deposits.descr', 'registration');
		$this->db->where('payment_deposits.session_id', $this->current_session);
		//$this->db->where('payment_deposits.semester_id', $this->current_semester);
		$this->db->order_by('payment_deposits.id', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getAllTransactions()
	{
		$this->db->select('id,receipt,status,amount');
		$this->db->from('payment_deposits');
		//$this->db->where('type', 'admission_fee');
		$this->db->where('status', 'pending');
		$this->db->where('session_id', $this->current_session);
		$this->db->limit('1000');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}


	public function getItems($course_id, $student_type, $class_id = null)
	{
		$this->db->select('payment_items.*');
		$this->db->from('payment_items');
		$this->db->where('course_id', $course_id);
		if ($class_id != null || $class_id != 0) {
			$this->db->where('class_id', $class_id);
		}
		$this->db->where('payment_type', 'semester');
		$this->db->where('indigene', $student_type);
		$this->db->where('semester_id', $this->current_semester);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function getItemSum($course_id, $student_type, $class_id = null)
	{
		$this->db->select_sum('amount')->from('payment_items');
		$this->db->where('course_id', $course_id);
		if ($class_id != null || $class_id != 0) {
			$this->db->where('class_id', $class_id);
		}
		$this->db->where('payment_type', 'semester');
		$this->db->where('indigene', $student_type);
		$this->db->where('semester_id', $this->current_semester);

		$query = $this->db->get();

		return $query->row();
	}
	public function getTotalItemTaxable($course_id, $student_type, $class_id = null)
	{
		$this->db->select_sum('amount')->from('payment_items');
		$this->db->where('course_id', $course_id);
		$this->db->where('type', 'taxable');
		if ($class_id != null || $class_id != 0) {
			$this->db->where('class_id', $class_id);
		}
		$this->db->where('payment_type', 'semester');
		$this->db->where('indigene', $student_type);
		$this->db->where('semester_id', $this->current_semester);

		$query = $this->db->get();

		return $query->row();
	}
	public function getTotalItemNonTaxable($course_id, $student_type, $class_id = null)
	{
		$this->db->select_sum('amount')->from('payment_items');
		$this->db->where('course_id', $course_id);
		$this->db->where('type', 'non-taxable');
		if ($class_id != null || $class_id != 0) {
			$this->db->where('class_id', $class_id);
		}
		$this->db->where('payment_type', 'semester');
		$this->db->where('indigene', $student_type);
		$this->db->where('semester_id', $this->current_semester);

		$query = $this->db->get();

		return $query->row();
	}

	public function getSearchPayment($receipt = null)
	{

		$this->db->select('payment_deposits.*,classes.class as `class`, semesters.semester as `semester`, sessions.session as `session`, states.name as `state`,courses.name as `course`,courses.code as `code`,students.reg_no as `reg_no` ,students.firstname as `firstname`,students.middlename, students.lastname,students.image,    students.mobileno, students.email');
		$this->db->from('payment_deposits');
		$this->db->join('students', 'students.id = payment_deposits.student_id');
		$this->db->join('courses', 'courses.id = students.course_id', 'left');
		$this->db->join('classes', 'payment_deposits.class_id = classes.id', 'left');
		$this->db->join('states', 'students.state_id = states.id', 'left');
		$this->db->join('semesters', 'payment_deposits.semester_id = semesters.id', 'left');
		$this->db->join('sessions', 'payment_deposits.session_id = sessions.id');
		// $this->db->where('payment_deposits.student_id', $student_id);
		//$this->db->where('payment_deposits.class_id', $class_id);

		$this->db->where('payment_deposits.session_id', $this->current_session);
		//$this->db->where('payment_deposits.semester_id', $this->current_semester);
		$this->db->group_start();
		$this->db->like('payment_deposits.receipt', $receipt);
		$this->db->or_like('payment_deposits.txn', $receipt);
		$this->db->group_end();

		$query = $this->db->get();

		return $query->row();
	}
}
