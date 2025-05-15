<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends CI_Controller
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
		check_permission('staff');

		$page_data['page_name'] = "staff/search";
		$page_data['resultlist'] = $this->db->get_where('staff', array('is_active' => 1))->result_array();
		$page_data['page_title'] = site_phrase('staff');
		$this->load->view('admin/index', $page_data);
	}

	function create()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('staff');

		$page_data['page_name'] = "staff/create";
		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;
		$genderList = $this->customlib->getGender();
		$page_data['genderList'] = $genderList;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$page_data['page_title'] = site_phrase('add_new_staff');
		$this->load->view('admin/index', $page_data);
	}

	function edit($id)
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('staff');

		$page_data['page_name'] = "staff/edit";
		$page_data['staff'] = $this->db->get_where('staff', array('id' => $id, 'is_active' => 1))->row_array();
		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;
		$genderList = $this->customlib->getGender();
		$page_data['genderList'] = $genderList;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$page_data['page_title'] = site_phrase('staff_profile_update');
		$this->load->view('admin/index', $page_data);
	}

	function add()
	{
		$response = $this->staff_model->addNewStaff();
		echo json_encode($response);
	}

	function update()
	{
		$response = $this->staff_model->update();
		echo json_encode($response);
	}
}
