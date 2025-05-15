<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Applicant_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	public function get_all_applicant($applicant_id = 0)
	{
		if ($applicant_id > 0) {
			$this->db->where('id', $applicant_id);
		}
		return $this->db->get('applicants');
	}
	function getReference($maxlength = 5)
	{
		$date = date('ymd');
		$chary = array(
			"0",
			"1",
			"2",
			"3",
			"4",
			"5",
			"6",
			"7",
			"8",
			"9"
		);
		$return_str = "";
		for ($x = 0; $x <= $maxlength; $x++) {
			$return_str .= $chary[rand(0, count($chary) - 1)];
		}
		$result = $date . $return_str;
		return $result;
	}

	function lastRecord()
	{
		$last_row = $this->db->select('*')->order_by('id', "desc")->limit(1)->get('applicants')->row();
		return $last_row;
	}

	public function getAll($id)
	{
		$this->db->select('applicants.*,local_g.name as `local_g`,applicant_acad.sitting as `sitting`,applicants.id,applicant_olevel.title,applicant_olevel.title2,applicant_olevel.subject,applicant_olevel.subject2,applicant_olevel.subject3,applicant_olevel.subject4,applicant_olevel.subject5,applicant_olevel.subject6,applicant_olevel.subject7,applicant_olevel.subject8,applicant_olevel.subject9,applicant_olevel.grade,applicant_olevel.grade2,applicant_olevel.grade3,applicant_olevel.grade4,applicant_olevel.grade5,applicant_olevel.grade6,applicant_olevel.grade7,applicant_olevel.grade8,applicant_olevel.grade9,applicant_olevel.subject11,applicant_olevel.subject22,applicant_olevel.subject33,applicant_olevel.subject44,applicant_olevel.subject55,applicant_olevel.subject66,applicant_olevel.subject77,applicant_olevel.subject88,applicant_olevel.subject99,applicant_olevel.grade11,applicant_olevel.grade22,applicant_olevel.grade33,applicant_olevel.grade44,applicant_olevel.grade55,applicant_olevel.grade66,applicant_olevel.grade77,applicant_olevel.grade88,applicant_olevel.grade99,applicant_olevel.exam_no,applicant_olevel.exam_year,applicant_olevel.exam_no2,applicant_olevel.exam_year2,applicant_acad.primary_school,applicant_acad.primary_cert,applicant_acad.primary_school_year,applicant_acad.secondary_school,applicant_acad.secondary_school_year,applicant_acad.secondary_cert,states.name as `state`,local_g.name as `local_government`,applicants.state_id,applicants.local_government_id as `local_government_id`,applicants.amount_detail,applicants.amount,applicants.admission_date,applicants.application_no,applicants.firstname,  applicants.lastname,applicants.image,applicants.phone, applicants.email ,applicants.is_active ,applicants.created_at ,applicants.updated_at,applicants.status as `status`');
		$this->db->from('applicants');
		$this->db->join('applicant_acad', 'applicant_acad.applicant_id = applicants.id', 'left');
		$this->db->join('states', 'states.id = applicants.state_id', 'left');
		//$this->db->join('applicant_courses', 'applicant_choice.course_id = applicant_courses.id', 'left');
		$this->db->join('applicant_choice', 'applicant_choice.applicant_id = applicants.id', 'left');
		$this->db->join('applicant_olevel', 'applicant_olevel.applicant_id = applicants.id', 'left');
		$this->db->join('local_g', 'applicants.local_government_id = local_g.id', 'left');
		$this->db->join('programs', 'programs.id = applicants.program_id', 'left');
		$this->db->where('applicants.id', $id);
		return $this->db->get();
	}

	public function getDetails($id)
	{
		$this->db->select('applicants.*,local_g.name as `local_g`,applicant_acad.sitting as `sitting`,applicants.id,applicant_olevel.title,applicant_olevel.title2,applicant_olevel.subject,applicant_olevel.subject2,applicant_olevel.subject3,applicant_olevel.subject4,applicant_olevel.subject5,applicant_olevel.subject6,applicant_olevel.subject7,applicant_olevel.subject8,applicant_olevel.subject9,applicant_olevel.grade,applicant_olevel.grade2,applicant_olevel.grade3,applicant_olevel.grade4,applicant_olevel.grade5,applicant_olevel.grade6,applicant_olevel.grade7,applicant_olevel.grade8,applicant_olevel.grade9,applicant_olevel.subject11,applicant_olevel.subject22,applicant_olevel.subject33,applicant_olevel.subject44,applicant_olevel.subject55,applicant_olevel.subject66,applicant_olevel.subject77,applicant_olevel.subject88,applicant_olevel.subject99,applicant_olevel.grade11,applicant_olevel.grade22,applicant_olevel.grade33,applicant_olevel.grade44,applicant_olevel.grade55,applicant_olevel.grade66,applicant_olevel.grade77,applicant_olevel.grade88,applicant_olevel.grade99,applicant_olevel.exam_no,applicant_olevel.exam_year,applicant_olevel.exam_no2,applicant_olevel.exam_year2,applicant_acad.primary_school,applicant_acad.primary_cert,applicant_acad.primary_school_year,applicant_acad.secondary_school,applicant_acad.secondary_school_year,applicant_acad.secondary_cert,states.name as `state`,local_g.name as `local_government`,applicants.state_id,applicants.local_government_id as `local_government_id`,applicants.amount_detail,applicants.amount,applicants.admission_date,applicants.application_no,applicants.firstname,  applicants.lastname,applicants.image,applicants.phone, applicants.email ,applicants.is_active ,applicants.created_at ,applicants.updated_at,applicants.status');
		$this->db->from('applicants');
		$this->db->join('applicant_acad', 'applicant_acad.applicant_id = applicants.id', 'left');
		$this->db->join('states', 'states.id = applicants.state_id', 'left');
		//$this->db->join('applicant_courses', 'applicant_choice.course_id = applicant_courses.id', 'left');
		$this->db->join('applicant_choice', 'applicant_choice.applicant_id = applicants.id', 'left');
		$this->db->join('applicant_olevel', 'applicant_olevel.applicant_id = applicants.id', 'left');
		$this->db->join('local_g', 'applicants.local_government_id = local_g.id', 'left');
		$this->db->join('programs', 'programs.id = applicants.program_id', 'left');
		$this->db->where('applicants.id', $id);
		return $this->db->get();
	}
	function get_choice($id)
	{
		$this->db->select('courses.name as `course`');
		$this->db->from('applicant_choice');
		$this->db->join('courses', 'courses.id = applicant_choice.course_id', 'left');
		$this->db->where('applicant_choice.applicant_id', $id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get1choice($id)
	{
		$this->db->select('applicant_choice.school_id,applicant_choice.department_id,applicant_choice.course_id,schools.school as `school`,departments.name as `department`,courses.name as `choice_course`,');
		$this->db->from('applicant_choice');
		$this->db->join('courses', 'courses.id = applicant_choice.course_id');
		$this->db->join('departments', 'departments.id = applicant_choice.department_id', 'left');
		$this->db->join('schools', 'applicant_choice.school_id = schools.id', 'left');
		$this->db->where('applicant_choice.applicant_id', $id);
		$this->db->where('applicant_choice.choice', '1st');
		$query = $this->db->get();
		//$this->db->order_by('name', 'ASC');
		return $query->row_array();
	}
	public function get2choice($id)
	{
		$this->db->select('applicant_choice.school_id,applicant_choice.department_id,applicant_choice.course_id,schools.school as `school`,departments.name as `department`,courses.name as `choice_course`,');
		$this->db->from('applicant_choice');
		$this->db->join('courses', 'courses.id = applicant_choice.course_id');
		$this->db->join('departments', 'departments.id = applicant_choice.department_id', 'left');
		$this->db->join('schools', 'applicant_choice.school_id = schools.id', 'left');
		$this->db->where('applicant_choice.applicant_id', $id);
		$this->db->where('applicant_choice.choice', '2nd');
		$query = $this->db->get();
		//$this->db->order_by('name', 'ASC');
		return $query->row_array();
	}
	function get_1choice($id)
	{
		$this->db->select('applicant_choice.*,applicant_choice.course_id as `course_id`,courses.name as `course`');
		$this->db->from('applicant_choice');
		$this->db->join('courses', 'courses.id = applicant_choice.course_id', 'left');
		$this->db->where('applicant_choice.applicant_id', $id);
		$this->db->where('applicant_choice.choice', '1st');
		$query = $this->db->get();
		return $query->row();
	}
	function get_2choice($id)
	{
		$this->db->select('applicant_choice.course_id as `course_id`,courses.name as `course`');
		$this->db->from('applicant_choice');
		$this->db->join('courses', 'courses.id = applicant_choice.course_id', 'left');
		$this->db->where('applicant_choice.applicant_id', $id);
		$this->db->where('applicant_choice.choice', '2nd');
		$query = $this->db->get();
		return $query->row();
	}


	public function getNeco($id)
	{
		$this->db->select()->from('applicant_olevel');
		$this->db->where('applicant_id', $id);
		$query = $this->db->get();

		return $query->result_array();
	}
	public function getWaec($id)
	{
		$this->db->select()->from('applicant_olevel');
		$this->db->where('applicant_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getapplicantacad($id)
	{
		$this->db->select()->from('applicant_acad');
		$this->db->where('applicant_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function add_payment($data)
	{
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
		$this->db->insert('applicant_deposits', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function getReceiptDetails($receipt = null)
	{
		$this->db->select('applicant_deposits.*,applicants.*,applicant_deposits.status as `status`, applicant_deposits.amount as `amount`');
		$this->db->from('applicant_deposits');
		$this->db->join('applicants', 'applicant_deposits.applicant_id = applicants.id', 'left');
		$this->db->where('applicant_deposits.receipt', $receipt);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function add_user($is_instructor = false, $is_admin = false)
	{
		$emailValidity = $this->check_duplication('on_create', $this->input->post('email'));
		$phoneValidity = $this->check_phone_duplication('on_create', $this->input->post('phone'));
		if ($emailValidity == false) {
			$response = array(
				'status' => false,
				'notification' => ' Email already exist'
			);
			//$this->session->set_flashdata('error_message', get_phrase('email_duplication'));
		} elseif ($phoneValidity == false) {
			$response = array(
				'status' => false,
				'notification' => ' Phone Number already exist'
			);
		} else {
			//  $data['unique_identifier'] = 0;
			$data['firstname'] = html_escape($this->input->post('firstname'));
			$data['lastname'] = html_escape($this->input->post('lastname'));
			$data['phone'] = html_escape($this->input->post('phone'));
			$data['email'] = html_escape($this->input->post('email'));
			$data['password'] = sha1(html_escape($this->input->post('password')));
			$data['open_p'] = html_escape($this->input->post('password'));
			$program = html_escape($this->input->post('program_id'));
			$data['program_id'] = $program;
			//$data['role_id'] = 3;
			//$data['date_added'] = strtotime(date("d-m-Y H:i:s"));
			//$data['wishlist'] = json_encode(array());
			$data['status'] = 'not submitted';
			//$data['image'] = md5(rand(10000, 10000000));
			$this->db->insert('applicants', $data);
			$user_id = $this->db->insert_id();
			//   $this->user_model->update_unique_identifier($user_id);
			$appl_data['user_id'] = $user_id;
			$appl_data['program_id'] = $program;
			$send = $this->db->insert('applications', $appl_data);
			//$this->upload_user_image($data['image']);
			//$this->session->set_flashdata('flash_message', get_phrase('user_added_successfully'));

			if ($user_id) {
				$this->set_login_userdata($user_id);
				$response = array(
					'status' => true,
					'notification' => 'User Added successfully'
				);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Unknown Error, Please try Again.'
				);
			}
		}
		return json_encode($response);
	}

	public function add_name($is_instructor = false, $is_admin = false)
	{
		$emailValidity = $this->check_duplication('on_create', $this->input->post('email'));
		$phoneValidity = $this->check_phone_duplication('on_create', $this->input->post('phone'));
		if ($emailValidity == false) {
			$response = array(
				'status' => false,
				'notification' => ' Email already exist'
			);
			//$this->session->set_flashdata('error_message', get_phrase('email_duplication'));
		} elseif ($phoneValidity == false) {
			$response = array(
				'status' => false,
				'notification' => ' Phone Number already exist'
			);
		} else {
			//  $data['unique_identifier'] = 0;
			$id = html_escape($this->input->post('applicant_id'));
			$data['id'] = $id;
			$data['firstname'] = html_escape($this->input->post('firstname'));
			$data['lastname'] = html_escape($this->input->post('lastname'));
			$data['phone'] = html_escape($this->input->post('phone'));
			$data['email'] = html_escape($this->input->post('email'));
			$data['password'] = sha1(html_escape($this->input->post('password')));
			$data['status'] = 'not submitted';
			//$data['image'] = md5(rand(10000, 10000000));
			$this->db->where('id', $id);
			$this->db->update('applicants', $data);
			//   $this->user_model->update_unique_identifier($user_id);
			$appl_data['user_id'] = $id;
			$send = $this->db->insert('applications', $appl_data);
			//$this->upload_user_image($data['image']);
			//$this->session->set_flashdata('flash_message', get_phrase('user_added_successfully'));

			if ($send) {
				$response = array(
					'status' => true,
					'notification' => 'User Added successfully'
				);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Unknown Error, Please try Again.'
				);
			}
		}
		return json_encode($response);
	}
	public function check_duplication($action = "", $email = "", $user_id = "")
	{
		$duplicate_email_check = $this->db->get_where('applicants', array('email' => $email));

		if ($action == 'on_create') {
			if ($duplicate_email_check->num_rows() > 0) {
				//if ($duplicate_email_check->row()->status == 1) {
				return false;
				//} else {
				//	return 'unverified_user';
				//}
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

	public function check_phone_duplication($action = "", $phone = "", $user_id = "")
	{
		$duplicate_phone_check = $this->db->get_where('applicants', array('phone' => $phone));

		if ($action == 'on_create') {
			if ($duplicate_phone_check->num_rows() > 0) {
				//if ($duplicate_phone_check->row()->status == 1) {
				return false;
				//} else {
				//	return 'unverified_user';
				//	}
			} else {
				return true;
			}
		} elseif ($action == 'on_update') {
			if ($duplicate_phone_check->num_rows() > 0) {
				if ($duplicate_phone_check->row()->id == $user_id) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}
	}



	/*START LOGIN LOGOUT AND DEVICE ALLOW SECTION*/
	// For device login tracker
	public function new_device_login_tracker($user_id = "", $is_verified = '')
	{
		$pre_sessions = array();
		$updated_session_arr = array();
		$current_session_id = session_id();
		$this->db->where('id', $user_id);
		$sessions = $this->db->get('users');

		if ($sessions->row('role_id') == 1) {
			return;
		}

		$pre_sessions = json_decode($sessions->row('sessions'));

		if (is_array($pre_sessions)) {
			// if($is_verified == true && !in_array($current_session_id, $pre_sessions)){
			//     foreach($pre_sessions as $key => $pre_session){
			//         if($key == 0){
			//             $this->db->where('id', $pre_session);
			//             $this->db->delete('ci_sessions');
			//         }else{
			//             array_push($updated_session_arr, $pre_session);
			//         }
			//     }
			//     array_push($updated_session_arr, $current_session_id);
			// }else{
			//     if(!in_array($current_session_id, $pre_sessions)){
			//         if(count($pre_sessions) >= get_settings('allowed_device_number_of_loging')){
			//             $this->email_model->new_device_login_alert($user_id);
			//             redirect(site_url('login/new_login_confirmation'), 'refresh');
			//         }else{
			//             $updated_session_arr = $pre_sessions;
			//             array_push($updated_session_arr, $current_session_id);
			//         }
			//     }
			// }

			if (!in_array($current_session_id, $pre_sessions)) {
				$allowed_device = get_settings('allowed_device_number_of_loging');
				$previous_tatal_device = count($pre_sessions);

				if ($previous_tatal_device >= $allowed_device) {
					$removeable_device = $previous_tatal_device - $allowed_device;
				} else {
					$removeable_device = -1;
				}

				foreach ($pre_sessions as $key => $pre_session) {
					if ($removeable_device >= 0 && $key <= $removeable_device) {
						$this->db->where('id', $pre_session);
						$this->db->delete('ci_sessions');
					} else {
						array_push($updated_session_arr, $pre_session);
					}
				}
				array_push($updated_session_arr, $current_session_id);
			}
		} else {
			$updated_session_arr = [$current_session_id];
		}

		if (count($updated_session_arr) > 0) {
			$data['sessions'] = json_encode($updated_session_arr);
			$this->db->where('id', $user_id);
			$this->db->update('users', $data);
		}
	}

	function validate_login($username, $password)
	{
		$sha_password = sha1($password);
		$this->db->select('*');
		$this->db->from('applicants');
		$this->db->group_start();
		$this->db->where('application_no', $username)->or_where('phone', $username);
		$this->db->group_end();
		$this->db->where('password', $sha_password);
		return $this->db->get();
	}
	function set_login_userdata($user_id = "")
	{
		// Checking login credential for admin
		$query = $this->db->get_where('applicants', array('id' => $user_id));

		if ($query->num_rows() > 0) {
			$row = $query->row();
			//604800s == 7 days
			$this->session->set_userdata('custom_session_limit', (time() + 604800));
			$this->session->set_userdata('user_id', $row->id);
			$this->session->set_userdata('role_id', '3');
			$this->session->set_userdata('role', 'applicant'); //get_user_role('user_role', $row->id)
			$this->session->set_userdata('name', $row->firstname . ' ' . $row->lastname);
			//$this->session->set_userdata('is_instructor', $row->is_instructor);
			$this->session->set_flashdata('flash_message', get_phrase('welcome') . ' ' . $row->firstname . ' ' . $row->lastname);
			$this->session->set_userdata('applicant_login', '1');
			//redirect(site_url('applicant/dashboard'), 'refresh');
		} else {
			$this->session->set_flashdata('error_message', get_phrase('invalid_login_credentials'));
			redirect(site_url('admission/login'), 'refresh');
		}
	}

	function check_session_data($user_type = "")
	{
		if (!$this->session->userdata('cart_items')) {
			$this->session->set_userdata('cart_items', array());
		}

		if (!$this->session->userdata('language')) {
			$this->session->set_userdata('language', get_settings('language'));
		}

		if ($user_type == 'admin') {
			if ($this->session->userdata('custom_session_limit') >= time()) {
				$this->session->set_userdata('custom_session_limit', (time() + 604800));
			} else {
				$this->session_destroy();
				redirect(site_url('login'), 'refresh');
			}

			if ($this->session->userdata('admin_login') != true) {
				redirect(site_url('login'), 'refresh');
			}
		} elseif ($user_type == 'user') {
			if ($this->session->userdata('custom_session_limit') >= time()) {
				$this->session->set_userdata('custom_session_limit', (time() + 604800));
			} else {
				$this->session_destroy();
				redirect(site_url('login'), 'refresh');
			}

			if ($this->session->userdata('user_login') != true) {
				redirect(site_url('login'), 'refresh');
			}
		} elseif ($user_type == 'applicant') {
			if ($this->session->userdata('custom_session_limit') >= time()) {
				$this->session->set_userdata('custom_session_limit', (time() + 604800));
			} else {
				$this->session_destroy();
				redirect(site_url('login'), 'refresh');
			}

			if ($this->session->userdata('applicant_login') != true) {
				redirect(site_url('login'), 'refresh');
			}
		} elseif ($user_type == 'login') {
			if ($this->session->userdata('admin_login')) {
				redirect(site_url('admin'), 'refresh');
			} elseif ($this->session->userdata('user_login')) {
				redirect(site_url('home/my_courses'), 'refresh');
			}
		}
	}

	public function session_destroy()
	{
		$logged_in_user_id = $this->session->userdata('user_id');
		if ($logged_in_user_id > 0 && $this->session->userdata('applicant_login') == 1) {
			$pre_sessions = array();
			$updated_session_arr = array();
			$current_session_id = session_id();

			$this->db->where('id', $logged_in_user_id);
			$sessions = $this->db->get('applicants')->row('sessions');
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
				$this->db->update('applicants', $data);
			}
		}

		//$this->session->unset_userdata('admin_login');
		$this->session->unset_userdata('user_login');
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


	// APPLICANT PAYMENT 
	public function getPaymentDeposits($applicant_id)
	{
		$this->db->select('applicant_deposits.id as `id`,applicant_deposits.created_at,applicant_deposits.txn,applicant_deposits.receipt, applicant_deposits.amount as `amount`,applicant_deposits.status as `status`');
		$this->db->from('applicant_deposits');
		$this->db->join('applicants', 'applicant_deposits.applicant_id = applicants.id', 'left');
		$this->db->where('applicant_deposits.applicant_id', $applicant_id);

		//$this->db->where('applicant_deposits.session_id', $this->current_session);
		//$this->db->where('applicant_deposits.id', $id);
		$this->db->order_by('id', 'desc');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function getPaidDeposit($applicant_id)
	{
		$this->db->select('applicant_deposits.id as `id`,applicant_deposits.created_at,applicant_deposits.txn,applicant_deposits.receipt, applicant_deposits.amount as `amount`,applicant_deposits.status as `status`');
		$this->db->from('applicant_deposits');
		$this->db->join('applicants', 'applicant_deposits.applicant_id = applicants.id', 'left');
		$this->db->where('applicant_deposits.applicant_id', $applicant_id);
		$this->db->where('applicant_deposits.status', 'paid');
	}

	public function CheckPayment($id)
	{
		$this->db->select('token')->from('applicants');
		$this->db->where('id', $id);
		//$this->db->where('class_id',  $class_id);
		$this->db->where('session_id', $this->current_session);
		// $this->db->where('semester_id',  $this->current_semester);
		$query = $this->db->get();

		return $query->row_array();
	}
	public function getTotalApplicantBySession()
	{
		$query = "SELECT count(*) as `total_applicant` FROM `applicant_session` INNER JOIN applicants on applicants.id=applicant_session.applicant_id where applicant_session.applicant_id=" . $this->db->escape($this->current_session);
		$query = $this->db->query($query);
		return $query->row();
	}
	public function CheckToken($id)
	{
		$this->db->where('id', $id);
		$this->db->where('token_status', 'taken');
		$query = $this->db->get('applicants');
		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	public function valid_token($str)
	{
		$token = $this->input->post('token');

		if ($token != "") {

			if ($this->check_token_exists($token)) {
				$this->form_validation->set_message('check_exists', 'Token already used by another applicant');
				return FALSE;
			} else {
				return TRUE;
			}
		}
		return TRUE;
	}
	function check_token_exists($token)
	{
		$this->db->where('token', $token);
		$this->db->where('token_status', 'taken');
		$query = $this->db->get('applicants');
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function token_exists($token)
	{
		$this->db->where('token', $token);
		$this->db->where('token_status', NULL);
		$query = $this->db->get('applicants');
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	function reg_no_exists($token)
	{
		$this->db->where('token', $token);
		$this->db->where('token_status', NULL);
		$query = $this->db->get('applicants');
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function get_token_details($token)
	{
		$this->db->select('id');
		$this->db->from('applicants');
		$this->db->where('token', $token);
		$query = $this->db->get();
		return $query->row()->id;
	}
	public function get_user_image_url($user_id)
	{
		$user_profile_image = $this->db->get_where('applicants', array('id' => $user_id))->row('image');
		if (file_exists($user_profile_image))
			return base_url() . $user_profile_image;
		else
			return base_url() . 'uploads/applicant_image/placeholder.png';
	}
	public function add($data)
	{

		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('applicants', $data);
		} else {
			$this->db->insert('applicants', $data);
			return $this->db->insert_id();
		}
	}

	public function add_choice($data)
	{
		$this->db->where('applicant_id', $data['applicant_id']);
		$this->db->where('choice', $data['choice']);
		$q = $this->db->get('applicant_choice');
		if ($q->num_rows() > 0) {
			$rec = $q->row_array();
			$this->db->where('id', $rec['id']);
			$this->db->update('applicant_choice', $data);
		} else {
			$this->db->insert('applicant_choice', $data);
			return $this->db->insert_id();
		}
	}
	public function add_acad($data)
	{

		$this->db->where('applicant_id', $data['applicant_id']);
		$q = $this->db->get('applicant_acad');
		if ($q->num_rows() > 0) {
			$rec = $q->row_array();
			$this->db->where('id', $rec['id']);
			$this->db->update('applicant_acad', $data);
		} else {
			$this->db->insert('applicant_acad', $data);
			return $this->db->insert_id();
		}
	}
	public function addolevel($data)
	{
		$this->db->where('applicant_id', $data['applicant_id']);
		$q = $this->db->get('applicant_olevel');
		if ($q->num_rows() > 0) {
			$rec = $q->row_array();
			$this->db->where('id', $rec['id']);
			$this->db->update('applicant_olevel', $data);
		} else {
			$this->db->insert('applicant_olevel', $data);
			return $this->db->insert_id();
		}
	}

	function addFormDetails()
	{
		$applicant_id = $this->input->post('applicant_id');
		//$applicant = $this->student_model->aget($applicant_id);
		$primary_school = $this->input->post('primary_school');
		$primary_school_year = $this->input->post('primary_school_year');
		$primary_cert = $this->input->post('primary_cert');
		$secondary_school = $this->input->post('secondary_school');
		$secondary_school_year = $this->input->post('secondary_school_year');
		$secondary_cert = $this->input->post('secondary_cert');
		$school1 = $this->input->post('school_id');
		$choice_course1 = $this->input->post('course_id');
		$school2 = $this->input->post('school_id2');
		$department1 = $this->input->post('department_id');
		$department2 = $this->input->post('department_id2');
		$choice_course2 = $this->input->post('course_id2');
		$sitting = $this->input->post('sitting');
		//$school_attended = $this->input->post('school_attended');
		$data = array(
			'id' => $applicant_id,
			//'admission_date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('admission_date'))),
			'firstname' => $this->input->post('firstname'),
			'lastname' => $this->input->post('lastname'),
			'middlename' => $this->input->post('middlename'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'state_id' => $this->input->post('state_id'),
			'local_government_id' => $this->input->post('local_government_id'),
			'religion' => $this->input->post('religion'),
			'dob' => $this->input->post('dob'),
			'tob' => $this->input->post('tob'),
			//'age' =>  $this->input->post('age'),
			'marital_status' => $this->input->post('marital_status'),
			'current_address' => $this->input->post('current_address'),
			'permanent_address' => $this->input->post('permanent_address'),
			'mother_name' => $this->input->post('mother_name'),
			'guardian_name' => $this->input->post('guardian_name'),
			'guardian_relation' => $this->input->post('guardian_relation'),
			'guardian_phone' => $this->input->post('guardian_phone'),
			'guardian_address' => $this->input->post('guardian_address'),
			'guardian_occupation' => $this->input->post('guardian_occupation'),
			'guardian_email' => $this->input->post('guardian_email'),
			'gender' => $this->input->post('gender'),
			'status' => 'saved'
		);
		$data = $this->security->xss_clean($data);
		$this->add($data);

		$data_new = array(
			'applicant_id' => $applicant_id,
			'primary_school' => $primary_school,
			'secondary_school' => $secondary_school,
			'primary_cert' => $primary_cert,
			'primary_school_year' => $primary_school_year,
			'secondary_school_year' => $secondary_school_year,
			'secondary_cert' => $secondary_cert,
			'sitting' => $sitting,
			//'jamb_year' => $this->input->post('jamb_year'),
			'is_submitted' => ('yes'),
			'submission_date' => date('d-m-Y')
		);
		$data_new = $this->security->xss_clean($data_new);
		$this->add_acad($data_new);
		$olevel = array(
			'applicant_id' => $applicant_id,
			'title' => $this->input->post('title'),
			'exam_no' => $this->input->post('exam_no'),
			'exam_year' => $this->input->post('exam_year'),
			'subject' => $this->input->post('subject'),
			'grade' => $this->input->post('grade'),
			'subject2' => $this->input->post('subject2'),
			'grade2' => $this->input->post('grade2'),
			'subject3' => $this->input->post('subject3'),
			'grade3' => $this->input->post('grade3'),
			'subject4' => $this->input->post('subject4'),
			'grade4' => $this->input->post('grade4'),
			'subject5' => $this->input->post('subject5'),
			'grade5' => $this->input->post('grade5'),
			'subject6' => $this->input->post('subject6'),
			'grade6' => $this->input->post('grade6'),
			'subject7' => $this->input->post('subject7'),
			'grade7' => $this->input->post('grade7'),
			'subject8' => $this->input->post('subject8'),
			'grade8' => $this->input->post('grade8'),
			'subject9' => $this->input->post('subject9'),
			'grade9' => $this->input->post('grade9'),
		);
		$olevel = $this->security->xss_clean($olevel);

		$this->addolevel($olevel);
		if ($sitting != 1) {
			$olevel1 = array(
				'applicant_id' => $applicant_id,
				'title2' => $this->input->post('title2'),
				'exam_no2' => $this->input->post('exam_no2'),
				'exam_year2' => $this->input->post('exam_year2'),
				'subject11' => $this->input->post('subject11'),
				'grade11' => $this->input->post('grade11'),
				'subject22' => $this->input->post('subject22'),
				'grade22' => $this->input->post('grade22'),
				'subject33' => $this->input->post('subject33'),
				'grade33' => $this->input->post('grade33'),
				'subject44' => $this->input->post('subject44'),
				'grade44' => $this->input->post('grade44'),
				'subject55' => $this->input->post('subject55'),
				'grade55' => $this->input->post('grade55'),
				'subject66' => $this->input->post('subject66'),
				'grade66' => $this->input->post('grade66'),
				'subject77' => $this->input->post('subject77'),
				'grade77' => $this->input->post('grade77'),
				'subject88' => $this->input->post('subject88'),
				'grade88' => $this->input->post('grade88'),
				'subject99' => $this->input->post('subject99'),
				'grade99' => $this->input->post('grade99')
			);
			$olevel1 = $this->security->xss_clean($olevel1);
			$this->addolevel($olevel1);
		}
		$data_choice = array(
			'applicant_id' => $applicant_id,
			'school_id' => $school1,
			'department_id' => $department1,
			'course_id' => $choice_course1,
			'choice' => '1st'
		);
		$data_choice = $this->security->xss_clean($data_choice);
		$this->add_choice($data_choice);
		$data_choice2 = array(
			'applicant_id' => $applicant_id,
			'school_id' => $school2,
			'department_id' => $department2,
			'course_id' => $choice_course2,
			'choice' => '2nd'
		);
		$data_choice2 = $this->security->xss_clean($data_choice2);
		$this->add_choice($data_choice2);
		if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
			$config['upload_path'] = './uploads/applicant_image/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('file')) {
				echo $this->upload->display_errors();
			} else {
				$data = $this->upload->data();
				$config['image_library'] = 'gd2';
				$config['source_image'] = "./uploads/applicant_image/" . $data["file_name"];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = FALSE;
				$config['quality'] = '90%';
				$config['width'] = 150;
				$config['height'] = 200;
				$config['new_image'] = "./uploads/applicant_image/" . $data["file_name"];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$image_data = array(
					'id' => $applicant_id,
					'image' => 'uploads/applicant_image/' . $data["file_name"]
				);
				$this->add($image_data);
			}
		}
		$response = array(
			'status' => true,
			'notification' => 'Success'
		);

		return $response;
	}

	function searchByDepartmentCourse($department_id = null, $course_id = null)
	{
		$this->db->select('applicants.*,local_g.name as `local_g`,states.name as `state`,applicants.state_id,applicants.local_government_id as `local_government_id`,courses.name as `course`,courses.code as `code`');
		$this->db->from('applicants');
		$this->db->join('states', 'states.id = applicants.state_id', 'left');
		//$this->db->join('applicant_courses', 'applicant_choice.applicant_id = applicant_courses.id', 'left');
		$this->db->join('applicant_choice', 'applicant_choice.applicant_id = applicants.id', 'left');
		$this->db->join('courses', 'courses.id = applicant_choice.course_id', 'left');
		$this->db->join('local_g', 'applicants.local_government_id = local_g.id', 'left');
		if ($department_id != null) {
			$this->db->where('applicant_choice.department_id', $department_id);
		}
		if ($course_id != null) {
			$this->db->where('applicant_choice.course_id', $course_id);
		}
		$this->db->where('applicant_choice.choice', '1st');
		//$this->db->where('applicant_choice.course_id', $course_id);
		return $this->db->get();
	}

	function searchAll()
	{
		$this->db->select('applicants.*,local_g.name as `local_g`,states.name as `state`,applicants.state_id,applicants.local_government_id as `local_government_id`,courses.name as `course`,courses.code as `code`,applicants.created_at');
		$this->db->from('applicants');
		$this->db->join('states', 'states.id = applicants.state_id', 'left');
		//$this->db->join('applicant_courses', 'applicant_choice.applicant_id = applicant_courses.id', 'left');
		$this->db->join('applicant_choice', 'applicant_choice.applicant_id = applicants.id', 'left');
		$this->db->join('courses', 'courses.id = applicant_choice.course_id', 'left');
		$this->db->join('local_g', 'applicants.local_government_id = local_g.id', 'left');

		$this->db->where('applicant_choice.choice', '1st');
		//$this->db->where('applicant_choice.course_id', $course_id);
		return $this->db->get();
	}

	function update($action, $id, $table)
	{
		$this->db->where('id', $id);
		$this->db->update($table, $action);
		return;
	}

	//-- delete function
	function delete($id, $table)
	{
		$this->db->delete($table, array('id' => $id));
		return;
	}

	public function get_Department()
	{
		$this->db->select('*');
		$query = $this->db->get('departments');
		$return = array();
		foreach ($query->result() as $value) {
			$return[$value->id] = $value;
			$return[$value->id]->list = $this->getStudentSortedByClass($value->id);
		}
		return $return;
	}
	public function getStudentSortedByClass($department_id)
	{
		$this->db->select('applicants.*,local_g.name as `local_g`,states.name as `state`,applicants.state_id,applicants.local_government_id as `local_government_id`,courses.name as `course`,courses.code as `code`');
		$this->db->from('applicants');
		$this->db->join('states', 'states.id = applicants.state_id', 'left');
		//$this->db->join('applicant_courses', 'applicant_choice.applicant_id = applicant_courses.id', 'left');
		$this->db->join('applicant_choice', 'applicant_choice.applicant_id = applicants.id', 'left');
		$this->db->join('courses', 'courses.id = applicant_choice.course_id', 'left');
		$this->db->join('local_g', 'applicants.local_government_id = local_g.id', 'left');
		if ($department_id != null) {
			$this->db->where('applicant_choice.department_id', $department_id);
		}
		/* if ($course_id != null) {
			$this->db->where('applicant_choice.course_id', $course_id);
		} */
		$this->db->where('applicant_choice.choice', '1st');
		$this->db->where("LEFT(applicants.application_no, 13) = 'CHTNG/ADM/24/'");
		$this->db->where('applicants.status', 'submitted');
		//$this->db->where('applicant_choice.course_id', $course_id);
		//return $this->db->get();
		$query = $this->db->get();
		return $query->result();
	}


	public function get_department_student_count()
	{
		$query = $this->db->select('departments.name as department, COUNT(*) as total_students')
			->join('applicant_choice', 'applicant_choice.applicant_id = applicants.id', 'left')
			->join('departments', 'departments.id = applicant_choice.department_id', 'left')
			->where('applicant_choice.choice', '1st')
			->where("LEFT(applicants.application_no, 13) = 'CHTNG/ADM/24/'")
			->where('applicants.status', 'submitted')
			->from('applicants')
			->group_by('applicant_choice.department_id')
			->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	public function get_total_student_count()
	{
		$query = $this->db->select()

			->where("LEFT(applicants.application_no, 13) = 'CHTNG/ADM/24/'")
			->where('applicants.status', 'submitted')
			->from('applicants')
			->get();

		return $query->num_rows();
	}
}
