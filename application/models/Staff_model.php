<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		/*cache control*/
		//$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		//$this->output->set_header('Pragma: no-cache');
	}

	public function log($message = null, $record_id = null, $action = null)
	{
		$user_id = $this->session->userdata('user_id');

		//$admin = $this->db->get_where('staff', array('id' => $user_id))->row('email');
		$user_name = $this->session->userdata('name');

		$ip = $this->input->ip_address();

		if ($this->agent->is_browser()) {
			$agent = $this->agent->browser() . ' ' . $this->agent->version();
		} elseif ($this->agent->is_robot()) {
			$agent = $this->agent->robot();
		} elseif ($this->agent->is_mobile()) {

			$agent = $this->agent->mobile();
		} else {
			$agent = 'Unidentified User Agent';
		}

		$platform = $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)

		$insert = array(
			'message' => $message,
			'user_id' => $user_id,
			'user_name' => $user_name,
			'record_id' => $record_id,
			'ip_address' => $ip,
			'platform' => $platform,
			'agent' => $agent,
			'action' => $action,
			'time' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('logs', $insert);
	}

	public function addStaff($data)
	{
		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(false); # See Note 01. If you wish can remove as well
		//=======================Code Start===========================
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('staff', $data);
			$message = UPDATE_RECORD_CONSTANT . " On  staff id " . $data['id'];
			$action = "Update";
			$record_id = $data['id'];
			$this->log($message, $record_id, $action);
			$this->db->trans_complete(); # Completing transaction
			/* Optional */

			if ($this->db->trans_status() === false) {
				# Something went wrong.
				$this->db->trans_rollback();
				return false;
			} else {
				return true;
			}
		} else {
			$this->db->insert('staff', $data);
			$insert_id = $this->db->insert_id();
			$message = INSERT_RECORD_CONSTANT . " On staff id " . $insert_id;
			$action = "Insert";
			$record_id = $insert_id;
			$this->log($message, $record_id, $action);
			//echo $this->db->last_query();die;
			//======================Code End==============================

			$this->db->trans_complete(); # Completing transaction
			/* Optional */

			if ($this->db->trans_status() === false) {
				# Something went wrong.
				$this->db->trans_rollback();
				return false;
			} else {
				//return $return_value;
			}
			return $insert_id;
		}
	}
	public function add($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('staff', $data);
		} else {
			$this->db->insert('staff', $data);
		}
		return true;
	}


	public function get_admin_details()
	{
		return $this->db->get_where('staff', array('role_id' => 1));
	}

	public function get_admin($admin_id = 0)
	{
		if ($admin_id > 0) {
			$this->db->where('id', $admin_id);
		}
		//$this->db->where('role_id', 2);
		return $this->db->get('staff');
	}

	public function get_all_user($user_id = 0)
	{
		if ($user_id > 0) {
			$this->db->where('id', $user_id);
		}
		return $this->db->get('staff');
	}

	function set_login_userdata($user_id = "")
	{
		// Checking login credential for admin
		$query = $this->db->get_where('staff', array('id' => $user_id));

		if ($query->num_rows() > 0) {
			$row = $query->row();
			//604800s == 7 days
			$this->session->set_userdata('custom_session_limit', (time() + 604800));
			$this->session->set_userdata('user_id', $row->id);
			$this->session->set_userdata('role_id', $row->role_id);
			$this->session->set_userdata('role', get_admin_role('user_role', $row->id));
			$this->session->set_userdata('name', $row->firstname . ' ' . $row->lastname);
			//$this->session->set_userdata('is_instructor', $row->is_instructor);
			$this->session->set_flashdata('flash_message', get_phrase('welcome') . ' ' . $row->firstname . ' ' . $row->lastname);
			$this->session->set_userdata('admin_login', '1');
		} else {
			$this->session->set_flashdata('error_message', get_phrase('invalid_login_credentials'));
			//redirect(site_url('home/login'), 'refresh');
		}
	}


	public function get_admin_image_url($user_id)
	{
		$user_profile_image = $this->db->get_where('staff', array('id' => $user_id))->row('image');
		if (file_exists($user_profile_image))
			return base_url() . $user_profile_image;
		else
			return base_url() . 'uploads/admin_image/placeholder.png';
	}

	function addNewStaff()
	{
		$emailValidity = $this->check_duplication('on_create', $this->input->post('email'));
		if ($emailValidity == false) {
			$response = array(
				'status' => false,
				'notification' => ' Email Address already exist'
			);
			//$this->session->set_flashdata('error_message', get_phrase('email_duplication'));
		} else {
			$department_id = 	html_escape($this->input->post('department_id'));
			$school_id = 		html_escape($this->input->post('school_id'));
			$state_id = 		html_escape($this->input->post('state_id'));
			$password = 		html_escape($this->input->post('password'));
			//$role = $this->input->post("role");
			$employee_id = $this->input->post("employee_id");
			$note = $this->input->post("note");
			$data = array(
				//'id' => $id,
				//'role' => 		html_escape($this->input->post('role')),
				'employee_id' => $employee_id,
				'school_id' =>				$school_id,
				'department_id' => 			$department_id,
				'date_of_joining' => 		date('d/m/Y'),
				'firstname' => 				html_escape($this->input->post('firstname')),
				'lastname' => 				html_escape($this->input->post('lastname')),
				'contact_no' => 			html_escape($this->input->post('contact_no')),
				'email' => 					html_escape($this->input->post('email')),
				'state_id' =>  				$state_id,
				'local_government_id' => 	html_escape($this->input->post('local_government_id')),
				//'religion' => 				html_escape($this->input->post('religion')),
				//'tob' => 					html_escape($this->input->post('tob')),
				'note' => $note,
				'permanent_address' => 		html_escape($this->input->post('permanent_address')),
				//'image' => '',
				'marital_status' => 		html_escape($this->input->post('marital_status')),
				'gender' => 				html_escape($this->input->post('gender')),
				'is_active' => 				'1',
				'role_id' => 				'1',
				'password' =>				sha1($password),
				'status' => '1'

			);
			$insert_id = $this->addStaff($data);
			if ($insert_id) {
				if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

					$config['upload_path'] = './uploads/student_image/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('file')) {
						//echo $this->upload->display_errors();
						$response = array(
							'status' => false,
							'notification' =>  $this->upload->display_errors()
						);
					} else {
						$data = $this->upload->data();
						$config['image_library'] = 'gd2';
						$config['source_image'] = "./uploads/student_image/" . $data["file_name"];
						$config['create_thumb'] = FALSE;
						$config['maintain_ratio'] = FALSE;
						$config['quality'] = '90%';
						$config['width'] = 150;
						$config['height'] = 200;
						$config['new_image'] = "./uploads/student_image/" . $data["file_name"];
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();
						$image_data = array(
							'id' => $insert_id,
							'image'          => 'uploads/student_image/' . $data["file_name"]
						);
						$this->add($image_data);
					}
				}
				// IF THIS IS A USER THEN INSERT BLANK VALUE IN PERMISSION TABLE AS WELL
				$is_admin = true;
				if ($is_admin) {
					$permission_data['admin_id'] = $insert_id;
					$permission_data['permissions'] = json_encode(array());
					$this->db->insert('permissions', $permission_data);
				}
				$response = array(
					'status' => true,
					'notification' => 'Profile created successfully'
				);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Unknwon Error'
				);
			}
		}
		return $response;
	}

	function update()
	{
		$id = 	html_escape($this->input->post('id'));
		$emailValidity = $this->check_duplication('on_update', $this->input->post('email'), $id);
		if ($emailValidity == false) {
			$response = array(
				'status' => false,
				'notification' => ' Email Address already exist'
			);
			//$this->session->set_flashdata('error_message', get_phrase('email_duplication'));
		} else {

			$department_id = 	html_escape($this->input->post('department_id'));
			$school_id = 		html_escape($this->input->post('school_id'));
			$state_id = 		html_escape($this->input->post('state_id'));
			//$role = $this->input->post("role");
			$employee_id = $this->input->post("employee_id");
			$note = $this->input->post("note");
			$data = array(
				'id' => $id,
				//'role' => 		html_escape($this->input->post('role')),
				'employee_id' => $employee_id,
				'school_id' =>				$school_id,
				'department_id' => 			$department_id,
				'date_of_joining' => 		date('d/m/Y'),
				'firstname' => 				html_escape($this->input->post('firstname')),
				'lastname' => 				html_escape($this->input->post('lastname')),
				'contact_no' => 			html_escape($this->input->post('contact_no')),
				'email' => 					html_escape($this->input->post('email')),
				'state_id' =>  				$state_id,
				'local_government_id' => 	html_escape($this->input->post('local_government_id')),
				//'religion' => 				html_escape($this->input->post('religion')),
				//'tob' => 					html_escape($this->input->post('tob')),
				'note' => $note,
				'permanent_address' => 		html_escape($this->input->post('permanent_address')),
				//'image' => '',
				'marital_status' => 		html_escape($this->input->post('marital_status')),
				'gender' => 				html_escape($this->input->post('gender')),
				'is_active' => 				'1',
				'status' => '1'

			);
			$update = $this->addStaff($data);
			if ($update) {
				if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

					$config['upload_path'] = './uploads/staff_image/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('file')) {
						//echo $this->upload->display_errors();
						$response = array(
							'status' => false,
							'notification' =>  $this->upload->display_errors()
						);
					} else {
						$data = $this->upload->data();
						$config['image_library'] = 'gd2';
						$config['source_image'] = "./uploads/staff_image/" . $data["file_name"];
						$config['create_thumb'] = FALSE;
						$config['maintain_ratio'] = FALSE;
						$config['quality'] = '90%';
						$config['width'] = 150;
						$config['height'] = 200;
						$config['new_image'] = "./uploads/staff_image/" . $data["file_name"];
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();
						$image_data = array(
							'id' => $id,
							'image'          => 'uploads/staff_image/' . $data["file_name"]
						);
						$this->add($image_data);
					}
				}
				$response = array(
					'status' => true,
					'notification' => 'Profile updated successfully'
				);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Unknwon Error'
				);
			}
		}
		return $response;
	}

	// Check user duplication
	public function check_duplication($action = "", $email = "", $user_id = "")
	{
		$duplicate_email_check = $this->db->get_where('staff', array('email' => $email));
		if ($action == 'on_create') {
			if ($duplicate_email_check->num_rows() > 0) {
				return false;
			} else {
				return true;
			}
		} elseif ($action == 'on_update') {
			if ($duplicate_email_check->num_rows() > 0) {
				if ($duplicate_email_check->row()->id == $user_id) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}
	}

	public function session_destroy()
	{
		$logged_in_user_id = $this->session->userdata('user_id');
		if ($logged_in_user_id > 0 && $this->session->userdata('admin_login') == 1) {
			$pre_sessions = array();
			$updated_session_arr = array();
			$current_session_id = session_id();

			$this->db->where('id', $logged_in_user_id);
			$sessions = $this->db->get('staff')->row('sessions');
			$pre_sessions = json_decode($sessions);
			if (is_array($pre_sessions)) {
				foreach ($pre_sessions as $key => $pre_session) {
					if ($pre_session != $current_session_id) {
						array_push($updated_session_arr, $pre_session);
					} else {
						$this->db->where('id', $pre_session);
						$this->db->delete('ci_sessions');
					}
				}
				$data['sessions'] = json_encode($updated_session_arr);
				$this->db->where('id', $logged_in_user_id);
				$this->db->update('staff', $data);
			}
		}

		$this->session->unset_userdata('admin_login');
		//$this->session->unset_userdata('user_login');
		$this->session->unset_userdata('custom_session_limit');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('role_id');
		$this->session->unset_userdata('role');
		$this->session->unset_userdata('name');
		/* $this->session->unset_userdata('is_instructor');
		$this->session->unset_userdata('url_history');
		$this->session->unset_userdata('app_url');
		$this->session->unset_userdata('total_price_of_checking_out');
		$this->session->unset_userdata('register_email');
		$this->session->unset_userdata('applied_coupon');
		$this->session->unset_userdata('new_device_code_expiration_time');
		$this->session->unset_userdata('new_device_user_email');
		$this->session->unset_userdata('new_device_user_id');
		$this->session->unset_userdata('new_device_verification_code'); */
	}

	public function saveNewPass($data)
	{
		$this->db->where('id', $data['id']);
		$query = $this->db->update('staff', $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
}
