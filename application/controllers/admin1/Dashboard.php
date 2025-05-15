<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
		$page_data['page_name'] = "dashboard";
		$page_data['page_title'] = site_phrase('dashboard');
		$totalActive= $this->student_model->getTotalActive();
		$totalMale= $this->student_model->getTotalMale();
		$totalFemale= $this->student_model->getTotalFemale();
		$totalRegistered = $this->student_model->getRegistered();
		$page_data['INDIGENE'] = $this->student_model->getTotalIndigene();
		$page_data['NONINDIGENE'] = $this->student_model->getTotalNonIndigene();
		$page_data['male'] = $totalMale;
		$page_data['female'] = $totalFemale;
		$page_data['registered'] = $totalRegistered; 
		$page_data['unregistered'] = $totalActive-$totalRegistered; 
		$page_data['level1'] = $this->student_model->get100L();
		$page_data['level2'] = $this->student_model->get200L();
		$page_data['level3'] = $this->student_model->get300L();
		$this->load->view('admin/index', $page_data);
	}
}
