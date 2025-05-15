<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->database();
		$this->load->library('session');
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		//Check custom session data
		//$this->user_model->check_session_data();
	}

	public function index()
	{
		//Check custom session data
		$this->user_model->check_session_data('login');
		$page_data['page_name'] = 'login';
		$page_data['page_title'] = site_phrase('student_login');
		$this->load->view('index', $page_data);
	}

	function check_login()
	{
		$username =  htmlspecialchars($this->input->post('username'));
		$password = htmlspecialchars($this->input->post('password'));
		$credential = array('username' => $username, 'password' => sha1($password));
		$query = $this->db->get_where('users', $credential);
		//$query = $this->student_model->validate_login($username, $password);
		if ($query->num_rows() > 0) {
			$row = $query->row();
			//$this->user_model->new_device_login_tracker($row->id);
			$this->student_model->set_login_userdata($row->user_id);
			if (isset($_SESSION['redirect_to']))
				echo  $_SESSION['redirect_to'];
			else
				//$this->session->set_flashdata('message', 'success');
				echo base_url() . 'student/dashboard/';
		} else {
			//$this->session->set_flashdata('error_message', get_phrase('invalid_login_credentials'));
			//redirect(site_url('home/login'), 'refresh');
			echo 0;
		}
	}

	function new_login_confirmation($param1 = "")
	{
		$new_device_code_expiration_time = $this->session->userdata('new_device_code_expiration_time');
		if (!$new_device_code_expiration_time || $new_device_code_expiration_time < (time())) {
			$this->session->set_flashdata('error_message', get_phrase('time_over') . '! ' . site_phrase('please_try_again'));
			redirect(site_url('login'), 'refresh');
		}

		if ($param1 == 'submit') {
			$new_device_verification_code = $this->input->post('new_device_verification_code');
			if ($new_device_verification_code != $this->session->userdata('new_device_verification_code')) {
				$this->session->set_flashdata('error_message', get_phrase('verification_code_is_wrong'));
				redirect(site_url('login/new_login_confirmation'), 'refresh');
			}

			// Checking login credential for admin
			$query = $this->db->get_where('users', array('id' => $this->session->userdata('new_device_user_id')));

			if ($query->num_rows() > 0) {
				$row = $query->row();

				// For device login tracker
				$this->user_model->new_device_login_tracker($row->id, true);
				$this->user_model->set_login_userdata($row->id);
			}
			$this->session->set_flashdata('error_message', get_phrase('something_is_wrong') . '! ' . site_phrase('please_try_again'));
			redirect(site_url('home'), 'refresh');
		}

		if ($param1 == 'resend') {
			$this->email_model->new_device_login_alert();
			return;
		}

		$page_data['page_name'] = 'new_login_confirmation';
		$page_data['page_title'] = site_phrase('new_login_confirmation');
		$this->load->view('frontend/' . get_frontend_settings('theme') . '/index', $page_data);
	}

	public function fb_validate_login($access_token = "", $fb_user_id = "")
	{
		$this->social_login_modal->fb_validate_login($access_token, $fb_user_id);
	}

	public function logout($from = "")
	{
		//destroy sessions of specific userdata. We've done this for not removing the cart session
		$this->student_model->session_destroy();
		redirect(site_url('login'), 'refresh');
	}
}
