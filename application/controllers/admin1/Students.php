<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Students extends CI_Controller
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
		check_permission('students');

		$page_data['page_name'] = "students/create";
		/* $school_result = $this->school_model->get();
		$page_data['schoollist'] = $school_result; */
		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}

	function search()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}

		// CHECK ACCESS PERMISSION
		check_permission('students');
		$page_data['page_name'] = "students/search";
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$department_result = $this->department_model->get();
		$page_data['departmentlist'] = $department_result;
		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}
	public function search_ajax()
	{
		//$staff_id = $this->customlib->getStaffID();
		//$this->data['staff_id'] = $staff_id;
		//$this->data['admin_id'] = $admin_id;
		//$userdata = $this->customlib->getUserData();
		//$admin_id = $userdata['role_id'];
		//$this->data['admin_id'] = $admin_id;
		/* 	if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		} */

		$department = $this->input->post('department_id');
		$course = $this->input->post('course_id');
		$class = $this->input->post('class_id');
		$search_text = $this->input->post('search_text');
		$this->data['searchby'] = "filter";
		$this->data['department_id'] = $department;
		$this->data['course_id'] = $course;
		$this->data['class_id'] = $class;
		$this->data['result'] = $this->student_model->searchByDepartmentCourseClass($department, $course, $class);
		$ret['render'] = $this->load->view('admin/students/search_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}
	function create()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('students');

		$page_data['page_name'] = "students/create";
		$department_result = $this->department_model->get();
		$page_data['departmentlist'] = $department_result;
		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}

	function view($id)
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('students');

		$page_data['page_name'] = "students/show";

		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$student = $this->student_model->get($id);
		$page_data['student'] = $student;
		$page_data['page_title'] = site_phrase('students');
		$this->load->view('admin/index',  $page_data);
	}

	function edit($id)
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('students');

		$page_data['page_name'] = "students/edit";

		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$department_result = $this->department_model->get();
		$page_data['departmentlist'] = $department_result;
		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$student = $this->student_model->get($id);
		$page_data['student'] = $student;
		$page_data['page_title'] = site_phrase('edit_student_profile');
		$this->load->view('admin/index',  $page_data);
	}

	function add()
	{
		$response = $this->student_model->add_details();
		echo json_encode($response);
	}

	function update()
	{
		$response = $this->student_model->update_details();
		echo json_encode($response);
	}

	function getByLocal()
	{
		$state_id = $this->input->get('state_id');
		$data = $this->crud_model->getStateByLocal($state_id);
		echo json_encode($data);
	}
}
