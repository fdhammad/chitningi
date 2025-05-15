<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
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
		check_permission('settings');

		$page_data['page_name'] = "settings";
		$session_result = $this->session_model->get();
		$semester_result = $this->semester_model->get();
		$page_data['sessionlist'] = $session_result;
		$page_data['semesterlist'] = $semester_result;
		$page_data['page_title'] = site_phrase('settings');
		$this->load->view('admin/index', $page_data);
	}

	function update()
	{
		$result = $this->setting_model->update_settings();
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

	function favicon()
	{
		if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

			$config['upload_path'] = './uploads/system/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('file')) {
				//echo $this->upload->display_errors();
				$response = array(
					'status' => false,
					'notification' => $this->upload->display_errors()
				);
			} else {
				$data = $this->upload->data();
				$config['image_library'] = 'gd2';
				$config['source_image'] = "./uploads/system/" . $data["file_name"];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = FALSE;
				$config['quality'] = '90%';
				$config['width'] = 150;
				$config['height'] = 200;
				$config['new_image'] = "./uploads/system/" . $data["file_name"];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$image_data['value'] = $data["file_name"];
				$this->db->where('key', 'favicon');
				$this->db->update('frontend_settings', $image_data);
				$response = array(
					'status' => true,
					'notification' => 'Success'
				);
			}
		} else {
			$response = array(
				'status' => false,
				'notification' => 'Logo Image is required'
			);
		}
		echo json_encode($response);
	}
}
