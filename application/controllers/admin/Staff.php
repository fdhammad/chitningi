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
	public function permissions()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('staff');

		if (!isset($_GET['permission_assing_to']) || empty($_GET['permission_assing_to'])) {
			$this->session->set_flashdata('error_message', get_phrase('you_have_select_an_admin_first'));
			redirect(site_url('admin/staff'), 'refresh');
		}

		$page_data['permission_assing_to'] = $this->input->get('permission_assing_to');
		$user_details = $this->staff_model->get_all_user($page_data['permission_assing_to']);
		if ($user_details->num_rows() == 0) {
			$this->session->set_flashdata('error_message', get_phrase('invalid_admin'));
			redirect(site_url('admin/staff'), 'refresh');
		} else {
			$user_details = $user_details->row_array();
			if ($user_details['role_id'] != 1) {
				$this->session->set_flashdata('error_message', get_phrase('invalid_admin'));
				redirect(site_url('admin/staff'), 'refresh');
			}
			if (is_root_admin($user_details['id'])) {
				$this->session->set_flashdata('error_message', get_phrase('you_can_not_set_permission_to_the_root_admin'));
				redirect(site_url('admin/staff'), 'refresh');
			}
		}

		$page_data['permission_assign_to'] = $user_details;
		$page_data['page_name'] = 'staff/admin_permission';
		$page_data['page_title'] = get_phrase('assign_permission');
		$this->load->view('admin/index', $page_data);
	}

	// ASSIGN PERMISSION TO ADMIN
	public function assign_permission()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('staff');

		echo $this->user_model->assign_permission();
	}

	function modalchangepass($id)
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}

		$newdata = array(
			'id' => $id,
			'password' => sha1($this->input->post('new_pass'))
		);
		$query2 = $this->staff_model->saveNewPass($newdata);
		if ($query2) {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="Password Updated Successfully, Thank You." data-type="success"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Password updated successfully</div>');
			redirect('admin/staff/edit/' . $id);
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Error." data-type="danger"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Error!</div>');
			redirect('admin/staff/edit/' . $id);
		}
	}
}
