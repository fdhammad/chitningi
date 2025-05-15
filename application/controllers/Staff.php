<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends CI_Controller
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
		//$this->user_model->check_session_data('admin');
	}

	public function login()
	{
		//Check custom session data
		//$this->user_model->check_session_data('login');
		$page_data['page_name'] = 'staff_login';
		$page_data['page_title'] = site_phrase('admin_login');
		$this->load->view('index', $page_data);
	}

	/* function get_enc()
	{
		echo sha1('admin');
	} */

	public function check_login()
	{

		$email = htmlspecialchars($this->input->post('email'));
		$password = htmlspecialchars($this->input->post('password'));
		$credential = array('email' => $email, 'password' => sha1($password), 'status' => 1);
		// Checking login credential for admin
		$query = $this->db->get_where('staff', $credential);

		if ($query->num_rows() > 0) {
			$row = $query->row();
			//$this->user_model->new_device_login_tracker($row->id);
			$this->staff_model->set_login_userdata($row->id);
			if (isset($_SESSION['redirect_to']))
				echo  $_SESSION['redirect_to'];
			else
				//$this->session->set_flashdata('message', 'success');
				echo base_url() . 'admin/dashboard/';
		} else {
			echo 0;
			//$this->session->set_flashdata('error_message', get_phrase('invalid_login_credentials'));
			//redirect(site_url('home/login'), 'refresh');
		}
	}

	public function logout($from = "")
	{
		//destroy sessions of specific userdata. We've done this for not removing the cart session
		$this->staff_model->session_destroy();
		redirect(site_url('staff/login'), 'refresh');
	}
}
