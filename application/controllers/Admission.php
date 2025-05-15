<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admission extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->database();
		$this->load->library('session');
		// $this->load->library('stripe');
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

		// CHECK CUSTOM SESSION DATA
		//$this->user_model->check_session_data();
	}

	public function index()
	{
		$this->home();
	}

	public function home()
	{
		$page_data['page_name'] = "admission";
		$page_data['page_title'] = site_phrase('admission');
		$this->load->view('index', $page_data);
	}

	function register()
	{
		$response = $this->applicant_model->add_user();
		/* if ($response->status == true) {
		} */
		echo json_encode($response);
	}

	function login()
	{
		$page_data['page_name'] = "applicant_login";
		$page_data['page_title'] = site_phrase('admission');
		$this->load->view('index', $page_data);
	}

	function check_login()
	{
		$username = htmlspecialchars($this->input->post('username'));
		$password = htmlspecialchars($this->input->post('password'));
		$validate = $this->applicant_model->validate_login($username,$password);
		//$credential = array('phone' => $phone, 'password' => sha1($password));
		//$query = $this->db->get_where('applicants', $credential);

		if ($validate->num_rows() > 0) {
			$row = $validate->row();
			//$this->user_model->new_device_login_tracker($row->id);
			$this->applicant_model->set_login_userdata($row->id);
			if (isset($_SESSION['redirect_to']))
				echo  $_SESSION['redirect_to'];
			else
				//$this->session->set_flashdata('message', 'success');
				echo base_url() . 'applicant/dashboard/';
		} else {
			//$this->session->set_flashdata('error_message', get_phrase('invalid_login_credentials'));
			//redirect(site_url('home/login'), 'refresh');
			echo 0;
		}
	}
	public function logout($from = "")
	{
		//destroy sessions of specific userdata. We've done this for not removing the cart session
		$this->applicant_model->session_destroy();
		redirect(site_url('admission/login'), 'refresh');
	}
}
