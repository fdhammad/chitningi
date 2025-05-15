<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tokens extends CI_Controller
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
		$this->current_semester = current_semester();
		$this->current_session = current_session();
	}


	function index()
	{
		
			if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('tokens');
		$page_data['page_name'] = "tokens";
			$page_data['page_title'] = site_phrase('generate_application_token');
			if ($this->input->server('REQUEST_METHOD') == "POST") {
				if ($this->input->post('generate') == "generate") {
					$this->form_validation->set_rules('number', 'Amount', 'trim|required|xss_clean');
					if ($this->form_validation->run() == FALSE) {
					} else {
						//$userdata = $this->customlib->getUserData();
						$amount = $this->input->post('number');
						$to_tokens = array(
							'no_of_tokens' => $amount,
							'staff_id' => $id = $this->session->userdata('user_id'),
							'session_id' => $this->current_session
						);
						$token_id = $this->token_model->add($to_tokens);
						
						
						//$lastid = $this->applicant_model->lastRecord()->id ;
						$prefix= "CHTNG/ADM/".date('y')."/";
						
						for ($i = 0; $i < $amount; $i++) {
							$numbers = $this->customlib->getToken();
							
							$data = array(
								'token' => $numbers,
								'token_status'=>'taken',
								'token_id' => $token_id,
								
							);
							$this->db->insert('applicants', $data);
							$last_id = $this->db->insert_id();
							$app_no = $this->get_custom_id($prefix, $last_id);
							$random= $this->randomchar();

							$password = sha1($random);
							$open_p= $random;
							$add_no =  array(
								'application_no'=>$app_no,
								'open_p' =>$open_p,
								'password' => $password
							);
							$this->db->where('id', $last_id);
							$this->db->update('applicants', $add_no);

						}
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Success</div>');
						redirect('admin/tokens');
					}
				} // end if file exists

			}

			//$setting_result = $this->setting_model->get();
			//$data['settinglist'] = $setting_result;
			$list = $this->token_model->get();
			$page_data['list'] = $list;
			$this->load->view('admin/index', $page_data);
		}

		function randomchar(){
			$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
						$randomString = '';
						for ($i = 0; $i < 6; $i++) {
						    $index = rand(0, strlen($characters) - 1);
						    $randomString .= $characters[$index];
						}
						return $randomString;
		}

		function print()
		{
			//$userdata = $this->customlib->getUserData();
			$id = $this->input->post('id');
			$tokens = $this->token_model->getTokens($id);
			$data['tokens'] = $tokens;
			$form = $this->load->view('admin/print_tokens', $data, true);
			echo $form;
		}
		public function drop($file)
		{
			unlink('./backup/database_backup/' . $file);
			redirect('admin/backup');
		}

public function get_custom_id($prefix,$id)
	{
		//$max_id = '';
		//$this->db->select_max('id');
		
		
		$max_id = $id;

		if ($max_id > 0) {
			$max_id = $max_id + 1;
		} else {
			$max_id = 1;
		}

		if (!$max_id) {
			$max_id = '0000' . $max_id;
		} elseif ($max_id > 0 && $max_id < 10) {
			$max_id = '000' . $max_id;
		} elseif ($max_id >= 10 && $max_id < 100) {
			$max_id = '00' . $max_id;
		} elseif ($max_id >= 100 && $max_id < 1000) {
			$max_id = '0' . $max_id;
		} else {
			$max_id = $max_id;
		}
		return $prefix . $max_id;
	}

}