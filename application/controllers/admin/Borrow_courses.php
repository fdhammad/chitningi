<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Borrow_courses extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library('session');
		/*cache control*/
		//$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		//$this->output->set_header('Pragma: no-cache');
		$this->user_model->check_session_data('admin');
	}


	function index()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('subjects');

		$page_data['page_name'] = "borrow";
		$subject_result = $this->subject_model->get();
		$page_data['subjectlist'] = $subject_result;
		$course_result = $this->course_model->get();
		$page_data['courselist'] = $course_result;
		$semester_result = $this->semester_model->get();
		$page_data['semesterlist'] = $semester_result;
		$class_result = $this->class_model->get();
		$page_data['classlist'] = $class_result;
		$page_data['page_title'] = site_phrase('borrow_courses');
		$this->load->view('admin/index', $page_data);
	}

	function course_ajax()
	{
		$semester = $this->input->post('semester_id');
		$course = $this->input->post('course_id');
		$class = $this->input->post('class_id');
		$this->data['semester_id'] = $semester;
		$this->data['course_id'] = $course;
		$this->data['class_id'] = $class;
		$this->data['subject']  = $this->subject_model->getSubjectForSug($class, $semester);
		$this->data['result'] = $this->subject_model->getSubjectByCourseClass($course, $class, $semester);
		$this->data['registrable_courses'] = $this->borrow_model->get($course, $class, $semester);
		$this->data['reg'] = $this->borrow_model->get_sug_id($course, $class, $semester);
		$ret['departmental'] = $this->load->view('admin/borrow_courses/departmental', $this->data, true);
		$ret['course'] = $this->load->view('admin/borrow_courses/all_courses', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}

	function suggest()
	{
		$subject_id = $this->input->post('subject_id');
		$check = $this->borrow_model->checkSuggestExist($subject_id);
		if ($check != TRUE) {
			$array = array(
				'subject_id' => $subject_id,
				'class_id' => $this->input->post('class_id'),
				'course_id' => $this->input->post('course_id'),
				'semester_id' =>  $this->input->post('semester_id'),
			);
			$inserted = $this->db->insert('registrable_courses', $array);
			if ($inserted) {
				$this->course_ajax();
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Data not Added'
				);
				echo json_encode($response);
			}
		} else {
			$response = array(
				'status' => false,
				'notification' => 'Course Already Exist'
			);
			echo json_encode($response);
		}
	}

	public function store()
	{

		$subjectid = $this->input->post('data');
		$subject_array = json_decode($subjectid);

		foreach ($subject_array as $key => $value) {
			$sub_arr = $value->subject_id;
		}
		$array = array(
			//'subject_id' => $sub_arr,
			'class_id' => $this->input->post('class_id'),
			'course_id' => $this->input->post('course_id'),
			'semester_id' =>  $this->input->post('semester_id'),
		);
		$save = $this->borrow_model->sug($subject_array, $array);
		//$this->db->insert_batch('course_reg', $array);
		if ($save) {
			/* $response = array(
				'status' => true,
				'notification' => 'Course(s) Borrowed Successfully'

			); */
			$this->course_ajax();
		} else {
			$response = array(
				'status' => false,
				'notification' => 'Unknown Error'
			);
		}

		echo json_encode($response);
	}

	function delete()
	{
		$id = $this->input->post('id'); // get the post data
		$delete = $this->borrow_model->sug_drop($id);
		if ($delete) {
			//echo true;
			$this->course_ajax();
			//$this->session->set_flashdata('msg', '<div student="alert alert-success text-left">Course Added Successfully</div>');
		} else {
			echo false;
		}
	}
}
