<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
		$this->user_model->check_session_data();
	}



	public function index()
	{
		$this->home();
	}

	public function home()
	{
		$page_data['page_name'] = "home1";
		$page_data['page_title'] = site_phrase('home');
		$this->load->view('index', $page_data);
	}
		function exportweedingfile()
	{
		$this->load->helper('download');
		$filepath = "./uploads/files/PRE-WEEDING.pdf";
		$data = file_get_contents($filepath);
		$name = '2023 PRE-WEEDING LIST.pdf';

		force_download($name, $data);
	}
	public function password(){
	    echo sha1('x1y2db70');
	}

	function test_email(){
		$this->email_model->send_test('fdhammad@gmail.com','Farouq Dabo','6050','Application Form');
	}
	function sms(){
	$this->customlib->send_sms('Farouq','08066880055','6050','Application Form','2303-2133-3221');
	}

	// Display the last registration numbers
    public function display_last_registration_numbers()
    {
        $department_formats = [
            1 => "BMG/CHE/24/24/",
            2 => "BMG/JCH/24/24/",
            4 => "BMG/EHT/21/24/",
            5 => "BMG/HPE/11/24/",
            6 => "BMG/MLT/12/24/",
            7 => "BMG/EDC/04/24/",
            8 => "BMG/PHT/04/24/",
            10 => "BMG/HIM/ND/06/24/",
            11 => "BMG/DHT/11/24/",
            12 => "BMG/CPT/08/24/",
            13 => "BMG/NUD/11/24/",
            14 => "BMG/PSR/04/24/",
            15 => "BMG/BMT/03/24/",
            17 => "BMG/DOP/02/24/"
        ];

        // Retrieve last registration numbers
        $last_reg_nos = $this->student_model->get_last_registration_numbers($department_formats);

        // Pass data to view
        $data['last_reg_nos'] = $last_reg_nos;
        $this->load->view('last_reg_nos', $data);
    }
}