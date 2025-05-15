<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Switches extends CI_Controller
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
        check_permission('switches');

        $page_data['page_name'] = "switches";
        $switchlist = $this->switch_model->getSwitch();
        $page_data["switchlist"] = $switchlist;
        $page_data['page_title'] = site_phrase('switches');
        $this->load->view('admin/index', $page_data);
    }

    public function changeStatus()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('staff/login'), 'refresh');
        }
        // CHECK ACCESS PERMISSION
        check_permission('swtiches');

        $id = $this->input->post("id");
        $status = $this->input->post("status");
        if (!empty($id)) {
            $data = array('id' => $id, 'is_active' => $status);
            $result = $this->switch_model->changeStatus($data);
            $response = array('status' => 1, 'toast' => '<div class="toast" data-title="Success! "data-message="Course Added successfully" data-type="success"></div>');
            echo json_encode($response);
        }
    }
}
