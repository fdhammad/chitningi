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
		$totalActive = $this->student_model->getTotalActive();
		$totalMale = $this->student_model->getTotalMale();
		$totalFemale = $this->student_model->getTotalFemale();
		$totalRegistered = $this->student_model->getRegistered();
		$page_data['INDIGENE'] = $this->student_model->getTotalIndigene();
		$page_data['NONINDIGENE'] = $this->student_model->getTotalNonIndigene();
		$page_data['male'] = $totalMale;
		$page_data['female'] = $totalFemale;
		$page_data['registered'] = $totalRegistered;
		$page_data['unregistered'] = $totalActive - $totalRegistered;
		$page_data['level1'] = $this->student_model->get100L();
		$page_data['level2'] = $this->student_model->get200L();
		$page_data['level3'] = $this->student_model->get300L();
		$page_data['CHEW'] = $this->db->get_where('students', array('school_id' => 1))->num_rows();
		$page_data['EHT'] = $this->db->get_where('students', array('school_id' => 2))->num_rows();
		$page_data['HPE'] = $this->db->get_where('students', array('school_id' => 3))->num_rows();
		$page_data['MLS'] = $this->db->get_where('students', array('school_id' => 4))->num_rows();
		$page_data['EDC'] = $this->db->get_where('students', array('school_id' => 5))->num_rows();
		$page_data['PHT'] = $this->db->get_where('students', array('school_id' => 6))->num_rows();
		$page_data['HIM'] = $this->db->get_where('students', array('school_id' => 7))->num_rows();
		$page_data['DHT'] = $this->db->get_where('students', array('school_id' => 8))->num_rows();
		$page_data['CPT'] = $this->db->get_where('students', array('school_id' => 9))->num_rows();
		$page_data['NUD'] = $this->db->get_where('students', array('school_id' => 10))->num_rows();
		$page_data['PSR'] = $this->db->get_where('students', array('school_id' => 11))->num_rows();

		$this->load->view('admin/index', $page_data);
	}
}
