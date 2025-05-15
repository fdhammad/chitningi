<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subjects extends CI_Controller
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

		$page_data['page_name'] = "subjects";
		$subject_result = $this->subject_model->get();
		$page_data['subjectlist'] = $subject_result;
		$course_result = $this->course_model->get();
		$page_data['courselist'] = $course_result;
		$semester_result = $this->semester_model->get();
		$page_data['semesterlist'] = $semester_result;
		$class_result = $this->class_model->get();
		$page_data['classlist'] = $class_result;
		$page_data['page_title'] = site_phrase('subjects');
		$this->load->view('admin/index', $page_data);
	}

	function add()
	{

		$course_id = 		html_escape($this->input->post('course_id'));
		$code = 		html_escape($this->input->post('code'));
		$check = $this->subject_model->check_subject_duplication($code);
		if ($check != false) {
			$courseDetails = $this->db->get_where('courses', array('id' => $course_id))->row_array();
			$department_id = $courseDetails['department_id'];
			$school_id = $courseDetails['school_id'];
			$data = array(
				'name' => 			html_escape($this->input->post('name')),
				'code' => 			html_escape($this->input->post('code')),
				'status' => 		html_escape($this->input->post('status')),
				'unit' => 			html_escape($this->input->post('unit')),
				'class_id' => 		html_escape($this->input->post('class_id')),
				'semester_id' => 	html_escape($this->input->post('semester_id')),
				'course_id' => 		html_escape($this->input->post('course_id')),
				'department_id' => 	$department_id,
				'school_id' => 		$school_id,
			);
			$result = $this->subject_model->add($data);
			if ($result) {
				$details = $this->subject_model->get_by_id($result);
				$response = array(
					'status' => true,
					'notification' => 'Success',
					'data' => $details
				);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Error'
				);
			}
		} else {
			$response = array(
				'status' => false,
				'notification' => 'Course Already Exist'
			);
		}

		echo json_encode($response);
	}
	function get_by_id()
	{
		$id = $this->input->post('id');

		$data = $this->subject_model->get_by_id($id);

		$arr = array('success' => false, 'data' => '');
		if ($data) {
			$arr = array('success' => true, 'data' => $data);
		}
		echo json_encode($arr);
	}
	public function update()
	{
		//$userdata = $this->customlib->getUserData();
		$modal_id = html_escape($this->input->post('modal_id'));
		$modal_subject = html_escape($this->input->post('modal_name'));
		
		$data = array(
			'id' => $modal_id,
			'name' => $modal_subject,
			'code' => 			html_escape($this->input->post('modal_code')),
			'status' => 		html_escape($this->input->post('modal_status')),
			'unit' => 			html_escape($this->input->post('modal_unit')),
			'class_id' => 		html_escape($this->input->post('modal_class_id')),
			'semester_id' => 	html_escape($this->input->post('modal_semester_id')),
			'course_id' => 		html_escape($this->input->post('modal_course_id'))
		);

		$status = false;

		//$id = $this->input->post('id');

		if ($modal_subject) {
			$update = $this->subject_model->add($data);
			$status = true;
		}
		$data = $this->subject_model->get_by_id($modal_id);
		echo json_encode(array("status" => $status, 'data' => $data));
	}

	function delete($id)
	{
		//$id = $this->input->post('id'); // get the post data
		$delete = $this->subject_model->delete($id);
		if ($delete) {
			echo true;
			//$this->session->set_flashdata('msg', '<div student="alert alert-success text-left">Course Added Successfully</div>');
		} else {
			echo false;
		}
	}
}
