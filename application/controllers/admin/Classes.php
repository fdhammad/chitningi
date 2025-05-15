<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Classes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library('session');
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

		$this->user_model->check_session_data('admin');
	}


	function index()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('classes');

		$page_data['page_name'] = "classes";
		$class_result = $this->class_model->get();

		$page_data['classlist'] = $class_result;

		$page_data['page_title'] = site_phrase('levels');
		$this->load->view('admin/index', $page_data);
	}

	function add()
	{
		$data = array('class' => html_escape($this->input->post('class')),);
		$result = $this->class_model->add($data);
		if ($result) {
			$response = array(
				'status' => true,
				'notification' => 'Success'
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => 'Error'
			);
		}
		echo json_encode($response);
	}
	function get_by_id()
	{
		$id = $this->input->post('id');

		$data = $this->class_model->get_by_id($id);

		$arr = array('success' => false, 'data' => '');
		if ($data) {
			$arr = array('success' => true, 'data' => $data);
		}
		echo json_encode($arr);
	}


	public function update()
	{
		//$userdata = $this->customlib->getUserData();
		$modal_id = $this->input->post('modal_id');
		$modal_class = $this->input->post('modal_class');
		$data = array(
			'id' => $modal_id,
			'class' => $modal_class,
		);

		$status = false;

		//$id = $this->input->post('id');

		if ($modal_class) {
			$update = $this->class_model->add($data);
			$status = true;
		}
		$data = $this->class_model->get_by_id($modal_id);
		echo json_encode(array("status" => $status, 'data' => $data));
	}

	function delete($id)
	{
		//$id = $this->input->post('id'); // get the post data
		$delete = $this->class_model->delete($id);
		if ($delete) {
			echo true;
			//$this->class->set_flashdata('msg', '<div student="alert alert-success text-left">Course Added Successfully</div>');
		} else {
			echo false;
		}
	}
}
