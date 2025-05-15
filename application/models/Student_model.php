<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		/*cache control*/
		//$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		//$this->output->set_header('Pragma: no-cache');
		$this->current_session = current_session();
		$this->current_semester = current_semester();
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

	public function get($id = null)
	{
		$this->db->select('students.department_id as `department_id`,students.state_id as `state_id`, students.local_government_id as `local_government_id`,students.course_id as `course_id`,students.school_id AS `school_id`,schools.school as `school`,schools.code as `sch_code`,departments.name as `depart`,courses.name as `course`,courses.code as `code`,courses.year as `year`,student_session.id as `student_session_id`,students.marital_status,students.disability,students.tob,students.form_no,states.name as `state`,local_g.name as `local_g`,student_session.class_id AS `class_id`,classes.class,students.id,students.reg_no ,students.admission_date,students.firstname,  students.lastname,students.middlename,students.image,students.sign,students.phone as `phone`, students.email  , students.religion,   students.dob ,students.current_address,
            students.permanent_address,students.mother_name,students.guardian_name ,students.measurement_date, students.guardian_relation,students.guardian_phone,students.guardian_address,students.is_active ,students.created_at ,students.updated_at,students.guardian_occupation,students.gender,students.guardian_is,students.guardian_email,students.student_type as `student_type`,student_session.role as `role`,students.open_p')->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id', 'left');
		$this->db->join('classes', 'student_session.class_id = classes.id', 'left');
		$this->db->join('departments', 'departments.id = students.department_id', 'left');
		$this->db->join('schools', 'students.school_id = schools.id', 'left');
		$this->db->join('courses', 'courses.id = students.course_id', 'left');
		//$this->db->join('hostel_rooms', 'student_session.hostel_room_id = hostel_rooms.id', 'left');
		//$this->db->join('hostel', 'hostel_rooms.hostel_id = hostel.id', 'left');
		$this->db->join('states', 'students.state_id = states.id', 'left');
		$this->db->join('local_g', 'students.local_government_id = local_g.id', 'left');
		$this->db->where('student_session.session_id', $this->current_session);
		//$this->db->where('students.program_id', 2);

		if ($id != null) {
			$this->db->where('students.id', $id);
		} else {
			$this->db->where('students.is_active', 'yes');
			$this->db->order_by('students.id', 'desc');
		}
		$query = $this->db->get();
		if ($id != null) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}
	}
	public function get_all_student($student_id = 0)
	{
		if ($student_id > 0) {
			$this->db->where('id', $student_id);
		}
		return $this->db->get('students');
	}

	public function get_user_image_url($user_id)
	{
		$user_profile_image = $this->db->get_where('students', array('id' => $user_id))->row('image');
		if (file_exists($user_profile_image))
			return base_url() . $user_profile_image;
		else
			return base_url() . 'uploads/user_image/placeholder.png';
	}

	function getPassword($id)
	{
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('user_id', $id);
		$this->db->where('role', 'student');
		$query = $this->db->get();
		return $query->row();
	}

	public function searchByDepartmentCourseClass($department_id = null, $course_id = null, $class_id = null)
	{
		$this->db->select('states.name AS `state`,local_g.name AS `local_g`,students.id,classes.class,departments.name as `depart`,courses.code as `code`,students.reg_no,students.form_no,students.firstname,students.lastname,students.middlename,students.gender,students.state_id,students.image')->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->join('classes', 'student_session.class_id = classes.id', 'left');
		$this->db->join('departments', 'students.department_id = departments.id');
		$this->db->join('states', 'students.state_id = states.id', 'left');
		$this->db->join('local_g', 'students.local_government_id = local_g.id', 'left');
		$this->db->join('courses', 'courses.id = students.course_id');
		$this->db->where('student_session.session_id', $this->current_session);
		//$this->db->where('student_session.role', 'student');
		//$this->db->where('students.program_id', 2);
		if ($department_id != null) {
			$this->db->where('students.department_id', $department_id);
		}
		if ($course_id != null) {
			$this->db->where('students.course_id', $course_id);
		}
		if ($class_id != null) {
			$this->db->where('student_session.class_id', $class_id);
		}
		//$this->db->order_by('students.id');
		$this->db->order_by('students.reg_no', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}
	public function searchRegStudentByDepartmentCourseClass($department_id = null, $course_id = null, $class_id = null)
	{
		$this->db->select('payment_deposits.status,payment_deposits.type,states.name AS `state`,local_g.name AS `local_g`,students.id,classes.class,departments.name as `depart`,courses.code as `code`,students.reg_no,students.form_no,students.firstname,students.lastname,students.middlename,students.gender,students.state_id,students.image')->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->join('payment_deposits', 'payment_deposits.student_id = students.id');
		$this->db->join('classes', 'student_session.class_id = classes.id', 'left');
		$this->db->join('departments', 'students.department_id = departments.id', 'left');
		$this->db->join('states', 'students.state_id = states.id', 'left');
		$this->db->join('local_g', 'students.local_government_id = local_g.id', 'left');
		$this->db->join('courses', 'courses.id = students.course_id');
		$this->db->where('student_session.session_id', $this->current_session);
		if ($class_id == 0) {
			$this->db->where('payment_deposits.type', 'pre_weeding');
		} else {
			$this->db->where('payment_deposits.type', 'semester');
		}

		$this->db->where('payment_deposits.status', 'paid');
		//$this->db->where('students.program_id', 2);
		if ($department_id != null) {
			$this->db->where('students.department_id', $department_id);
		}
		if ($course_id != null) {
			$this->db->where('students.course_id', $course_id);
		}
		if ($class_id != null) {
			$this->db->where('student_session.class_id', $class_id);
		}
		//$this->db->order_by('students.id');
		$this->db->order_by('students.reg_no', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}
	public function searchAdmStudent($department_id = null, $course_id = null)
	{
		$this->db->select('states.name AS `state`,local_g.name AS `local_g`,students.id,classes.class,courses.code as `code`,students.reg_no,students.form_no,students.firstname,students.lastname,students.middlename,students.gender,students.state_id,students.image')->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->join('classes', 'student_session.class_id = classes.id', 'left');
		$this->db->join('states', 'students.state_id = states.id', 'left');
		$this->db->join('local_g', 'students.local_government_id = local_g.id', 'left');
		$this->db->join('courses', 'courses.id = students.course_id');
		$this->db->where('student_session.session_id', $this->current_session);
		//$this->db->where('payment_deposits.type', 'admission_fee');
		//$this->db->where('payment_deposits.status', 'paid');
		//$this->db->where('students.program_id', 2);
		if ($department_id != null) {
			$this->db->where('students.department_id', $department_id);
		}
		if ($course_id != null) {
			$this->db->where('students.course_id', $course_id);
		}

		$this->db->where('student_session.class_id', 0);

		//$this->db->order_by('students.id');
		$this->db->order_by('students.reg_no', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}
	public function getStudentList($course_id = null, $class_id = null)
	{
		$this->db->select('students.id,students.reg_no,students.firstname,students.lastname,students.middlename,students.gender,students.state_id,students.image,students.state')->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->join('classes', 'student_session.class_id = classes.id', 'left');
		$this->db->where('student_session.session_id', $this->current_session);
		//$this->db->where('student_session.role', 'student');
		//$this->db->where('students.program_id', 2);
		if ($course_id != null) {
			$this->db->where('students.course_id', $course_id);
		}
		if ($class_id != null) {
			$this->db->where('student_session.class_id', $class_id);
		}
		//$this->db->order_by('students.id');
		$this->db->order_by('students.reg_no', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}
	public function getRegStudentList($course_id = null, $class_id = null)
	{
		$this->db->select('payment_deposits.status,payment_deposits.type,students.id,students.reg_no,students.firstname,students.lastname,students.middlename,students.gender,students.state_id,students.image,students.state')->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->join('payment_deposits', 'payment_deposits.student_id = students.id');
		$this->db->join('classes', 'student_session.class_id = classes.id', 'left');
		$this->db->where('student_session.session_id', $this->current_session);
		$this->db->where('payment_deposits.type', 'semester');
		$this->db->where('payment_deposits.status', 'paid');
		//$this->db->where('student_session.role', 'student');
		//$this->db->where('students.program_id', 2);
		if ($course_id != null) {
			$this->db->where('students.course_id', $course_id);
		}
		if ($class_id != null) {
			$this->db->where('student_session.class_id', $class_id);
		}
		//$this->db->order_by('students.id');
		$this->db->order_by('students.reg_no', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}
	public function searchFullText($searchterm)
	{
		//$userdata = $this->customlib->getUserData();
		//$admin_id = $userdata['role_id'];
		//$school_id = $userdata['school_id'];
		$this->db->select('states.name AS `state`,local_g.name AS `local_g`,students.id,classes.class,departments.name as `depart`,courses.code as `code`,students.reg_no,students.form_no,students.firstname,students.lastname,students.middlename,students.gender,students.state_id,students.image')->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->join('classes', 'student_session.class_id = classes.id', 'left');
		$this->db->join('departments', 'students.department_id = departments.id');
		$this->db->join('states', 'students.state_id = states.id', 'left');
		$this->db->join('local_g', 'students.local_government_id = local_g.id', 'left');
		$this->db->join('courses', 'courses.id = students.course_id');
		$this->db->where('student_session.session_id', $this->current_session);
		/* if ($admin_id == 2 || $admin_id == 9) {
			$this->db->where('students.school_id', $school_id);
		} */
		$this->db->where('students.is_active', 'yes');
		$this->db->group_start();
		$this->db->like('students.firstname', $searchterm);
		$this->db->or_like('students.lastname', $searchterm);
		$this->db->or_like('students.middlename', $searchterm);
		$this->db->or_like('classes.class', $searchterm);
		$this->db->or_like('courses.name', $searchterm);
		$this->db->or_like('courses.code', $searchterm);
		$this->db->or_like('departments.name', $searchterm);
		$this->db->or_like('states.name', $searchterm);
		$this->db->or_like('local_g.name', $searchterm);
		//$this->db->or_like('schools.school', $searchterm);
		$this->db->or_like('students.gender', $searchterm);
		$this->db->or_like('students.reg_no', $searchterm);
		$this->db->group_end();
		$this->db->order_by('students.reg_no', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function reg_student_searchFullText($searchterm)
	{
		//$userdata = $this->customlib->getUserData();
		//$admin_id = $userdata['role_id'];
		//$school_id = $userdata['school_id'];
		$this->db->select('payment_deposits.status,payment_deposits.type,payment_deposits.amount,states.name AS `state`,local_g.name AS `local_g`,students.id,classes.class,departments.name as `depart`,courses.code as `code`,students.reg_no,students.form_no,students.firstname,students.lastname,students.middlename,students.gender,students.state_id,students.image')->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->join('payment_deposits', 'payment_deposits.student_id = students.id');
		$this->db->join('classes', 'student_session.class_id = classes.id', 'left');
		$this->db->join('departments', 'students.department_id = departments.id');
		$this->db->join('states', 'students.state_id = states.id', 'left');
		$this->db->join('local_g', 'students.local_government_id = local_g.id', 'left');
		$this->db->join('courses', 'courses.id = students.course_id');
		$this->db->where('student_session.session_id', $this->current_session);
		$this->db->where('payment_deposits.type', 'semester');
		$this->db->where('payment_deposits.status', 'paid');
		/* if ($admin_id == 2 || $admin_id == 9) {
			$this->db->where('students.school_id', $school_id);
		} */
		$this->db->where('students.is_active', 'yes');
		$this->db->group_start();
		$this->db->like('students.firstname', $searchterm);
		$this->db->or_like('students.lastname', $searchterm);
		$this->db->or_like('students.middlename', $searchterm);
		$this->db->or_like('classes.class', $searchterm);
		$this->db->or_like('courses.name', $searchterm);
		$this->db->or_like('courses.code', $searchterm);
		$this->db->or_like('departments.name', $searchterm);
		$this->db->or_like('states.name', $searchterm);
		$this->db->or_like('local_g.name', $searchterm);
		//$this->db->or_like('schools.school', $searchterm);
		$this->db->or_like('students.gender', $searchterm);
		$this->db->or_like('students.reg_no', $searchterm);
		$this->db->group_end();
		$this->db->order_by('students.reg_no', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}


	public function adm_student_searchFullText($searchterm)
	{
		//$userdata = $this->customlib->getUserData();
		//$admin_id = $userdata['role_id'];
		//$school_id = $userdata['school_id'];
		$this->db->select('states.name AS `state`,local_g.name AS `local_g`,students.id,classes.class,courses.code as `code`,students.reg_no,students.form_no,students.firstname,students.lastname,students.middlename,students.gender,students.state_id,students.image')->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->join('classes', 'student_session.class_id = classes.id', 'left');
		$this->db->join('states', 'students.state_id = states.id', 'left');
		$this->db->join('local_g', 'students.local_government_id = local_g.id', 'left');
		$this->db->join('courses', 'courses.id = students.course_id');
		$this->db->where('student_session.session_id', $this->current_session);
		$this->db->where('student_session.class_id', 0);
		/* if ($admin_id == 2 || $admin_id == 9) {
			$this->db->where('students.school_id', $school_id);
		} */

		$this->db->group_start();
		$this->db->like('students.firstname', $searchterm);
		$this->db->or_like('students.lastname', $searchterm);
		$this->db->or_like('students.middlename', $searchterm);
		$this->db->or_like('courses.name', $searchterm);
		$this->db->or_like('courses.code', $searchterm);
		$this->db->or_like('states.name', $searchterm);
		$this->db->or_like('local_g.name', $searchterm);
		//$this->db->or_like('schools.school', $searchterm);
		$this->db->or_like('students.gender', $searchterm);
		$this->db->or_like('students.reg_no', $searchterm);
		$this->db->or_like('students.form_no', $searchterm);
		$this->db->group_end();
		$this->db->order_by('students.reg_no', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	function add_details()
	{
		$regnoValidity = $this->check_duplication('on_create', $this->input->post('reg_no'));
		if ($regnoValidity == false) {
			$response = array(
				'status' => false,
				'notification' => ' Registration Number already exist'
			);
			//$this->session->set_flashdata('error_message', get_phrase('email_duplication'));
		} else {
			$department_id = 	html_escape($this->input->post('department_id'));
			$course_id = 		html_escape($this->input->post('course_id'));
			$class_id = 		html_escape($this->input->post('class_id'));
			$state_id = 		html_escape($this->input->post('state_id'));
			if ($state_id == 5) {
				$indigene = 'Indigene';
			} else {
				$indigene = 'Non-Indigene';
			};
			$school = $this->db->get_where('
			    courses', array(
				'id' => $course_id
			))->row();
			$data = array(
				//'name' => html_escape($this->input->post('name')),
				'reg_no' => 		html_escape($this->input->post('reg_no')),
				//'form_no' => $this->input->post('form_no'),
				'school_id' => $school->school_id,
				'course_id' =>				$course_id,
				'department_id' => 			$department_id,
				'admission_date' => 		date('d/m/Y'),
				'firstname' => 				html_escape($this->input->post('firstname')),
				'lastname' => 				html_escape($this->input->post('lastname')),
				'middlename' => 			html_escape($this->input->post('middlename')),
				'phone' => 				html_escape($this->input->post('phone')),
				'email' => 					html_escape($this->input->post('email')),
				'state_id' =>  				$state_id,
				'local_government_id' => 	html_escape($this->input->post('local_government_id')),
				'student_type' => $indigene,
				'disability' => 'no',
				'open_p' => 'password',
				'religion' => 				html_escape($this->input->post('religion')),
				'dob' => 					html_escape($this->input->post('dob')),
				'tob' => 					html_escape($this->input->post('tob')),
				'current_address' => 		html_escape($this->input->post('current_address')),
				//'image' => '',
				'marital_status' => 		html_escape($this->input->post('marital_status')),
				'gender' => 				html_escape($this->input->post('gender')),
				//'blood_group' => $this->input->post('blood_group'),
				'is_active' => 				'yes',
				'measurement_date' => 		date('d/m/Y')
			);
			$insert_id = $this->addForStaff($data);
			if (!empty($insert_id)) {
				if ($class == 0) {
					$data_new = array(
						'student_id' => $insert_id,
						'class_id' => $class_id,
						'session_id' => current_session(),
						'role' => 'pre',
					);
				} else {
					$data_new = array(
						'student_id' => $insert_id,
						'class_id' => $class_id,
						'session_id' => current_session(),
						'role' => 'student',
					);
				}
				$this->add_student_session($data_new);
				$user_password = sha1("password");
				// $sibling_id = $this->input->post('sibling_id');
				$data_student_login = array(
					'firstname' => 				html_escape($this->input->post('firstname')),
					'lastname' => 				html_escape($this->input->post('lastname')),
					'username' => $this->input->post('reg_no'),
					'password' => $user_password,
					'user_id' => $insert_id,
					'role_id' => '4',
					'role' => 'student',
					'phone' => 				html_escape($this->input->post('phone')),
					'email' => 				html_escape($this->input->post('email')),
					'date_added' => date('d/m/Y'),
					'status' => '1'
				);
				$this->add_user($data_student_login);


				if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
					$id = $insert_id;

					$config['upload_path'] = './uploads/student_image/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('file')) {
						echo $this->upload->display_errors();
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
							'id' => $id,
							'image'          => 'uploads/student_image/' . $data["file_name"]
						);
						$this->add($image_data);
					}
				}
				$response = array(
					'status' => true,
					'notification' => 'Success'
				);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Error'
				);
			}
		}
		return $response;
	}



	function update_details()
	{
		$id = 	html_escape($this->input->post('student_id'));
		$regnoValidity = $this->check_duplication('on_update', $this->input->post('reg_no'), $id);
		if ($regnoValidity == false) {
			$response = array(
				'status' => false,
				'notification' => ' Registration Number already exist'
			);
			//$this->session->set_flashdata('error_message', get_phrase('email_duplication'));
		} else {

			$department_id = 	html_escape($this->input->post('department_id'));
			$course_id = 		html_escape($this->input->post('course_id'));
			$class_id = 		html_escape($this->input->post('class_id'));
			$state_id = 		html_escape($this->input->post('state_id'));
			if ($state_id == 5) {
				$indigene = 'Indigene';
			} else {
				$indigene = 'Non-Indigene';
			};
			if ($class_id == 0) {
				$student_role = 'pre';
				$student_role_id = '5';
			} else {
				$student_role = 'student';
				$student_role_id = '4';
			}
			$school = $this->db->get_where('
			    courses', array(
				'id' => $course_id
			))->row();
			$data = array(
				'id' => $id,
				'reg_no' => 		html_escape($this->input->post('reg_no')),
				//'form_no' => $this->input->post('form_no'),
				'school_id' => $school->school_id,
				'course_id' =>				$course_id,
				'department_id' => 			$department_id,
				'admission_date' => 		date('d/m/Y'),
				'firstname' => 				html_escape($this->input->post('firstname')),
				'lastname' => 				html_escape($this->input->post('lastname')),
				'middlename' => 			html_escape($this->input->post('middlename')),
				'phone' => 				html_escape($this->input->post('phone')),
				//'open_p' => 'password',
				'email' => 					html_escape($this->input->post('email')),
				'state_id' =>  				$state_id,
				'local_government_id' => 	html_escape($this->input->post('local_government_id')),
				'student_type' => $indigene,
				'disability' => 'no',
				'religion' => 				html_escape($this->input->post('religion')),
				'dob' => 					html_escape($this->input->post('dob')),
				'tob' => 					html_escape($this->input->post('tob')),
				'current_address' => 		html_escape($this->input->post('current_address')),
				//'image' => '',
				'marital_status' => 		html_escape($this->input->post('marital_status')),
				'gender' => 				html_escape($this->input->post('gender')),
				//'blood_group' => $this->input->post('blood_group'),
				'is_active' => 				'yes',
				'measurement_date' => 		date('d/m/Y')
			);
			$added = $this->addForStaff($data);
			if ($added) {
				$data_new = array(
					'student_id' => $id,
					'class_id' => $class_id,
					'session_id' => current_session(),
					'role' => $student_role,
				);
				$this->add_student_session($data_new);
				//$user_password = sha1("password");
				// $sibling_id = $this->input->post('sibling_id');
				$data_student_login = array(
					'user_id' => $id,
					'firstname' => 				html_escape($this->input->post('firstname')),
					'lastname' => 				html_escape($this->input->post('lastname')),
					'username' => 				html_escape($this->input->post('reg_no')),
					//'password' => $user_password,
					'role_id' => $student_role_id,
					'role' => $student_role,

					'phone' => 				html_escape($this->input->post('phone')),
					'email' => 				html_escape($this->input->post('email')),
					'date_added' => date('d/m/Y'),
					'status' => '1'
				);
				$this->update_user($data_student_login);


				if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

					$config['upload_path'] = './uploads/student_image/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('file')) {
						echo $this->upload->display_errors();
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
							'id' => $id,
							'image'          => 'uploads/student_image/' . $data["file_name"]
						);
						$this->add($image_data);
					}
				}
				$response = array(
					'status' => true,
					'notification' => 'Success'
				);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Error'
				);
			}
		}
		return $response;
	}

	function student_profile_update()
	{
		$id = $this->session->userdata('user_id');
		$regnoValidity = $this->check_phones_duplication('on_update', $this->input->post('phone'), $id);
		if ($regnoValidity == false) {
			$response = array(
				'status' => false,
				'notification' => ' Phone Number already exist'
			);
			//$this->session->set_flashdata('error_message', get_phrase('email_duplication'));
		} else {
			$state_id = 		html_escape($this->input->post('state_id'));
			$data = array(
				'id' => $id,
				'firstname' => 				html_escape($this->input->post('firstname')),
				'lastname' => 				html_escape($this->input->post('lastname')),
				'middlename' => 			html_escape($this->input->post('middlename')),
				'phone' => 					html_escape($this->input->post('phone')),
				'email' => 					html_escape($this->input->post('email')),
				'state_id' =>  				$state_id,
				'local_government_id' => 	html_escape($this->input->post('local_government_id')),
				'religion' => 				html_escape($this->input->post('religion')),
				'dob' => 					html_escape($this->input->post('dob')),
				'tob' => 					html_escape($this->input->post('tob')),
				'current_address' => 		html_escape($this->input->post('current_address')),
				//'image' => '',
				'marital_status' => 		html_escape($this->input->post('marital_status')),
				'gender' => 				html_escape($this->input->post('gender')),
				//'blood_group' => $this->input->post('blood_group'),
				'permanent_address' 		=> $this->input->post('permanent_address'),
				'mother_name' 				=> $this->input->post('mother_name'),
				'guardian_name' 			=> $this->input->post('guardian_name'),
				'guardian_relation' 		=> $this->input->post('guardian_relation'),
				'guardian_phone' 			=> $this->input->post('guardian_phone'),
				'guardian_address' 			=> $this->input->post('guardian_address'),
				'guardian_occupation' 		=> $this->input->post('guardian_occupation'),
				'guardian_email' 			=> $this->input->post('guardian_email')

			);
			$data = $this->security->xss_clean($data);
			$updated = $this->add($data);
			if ($updated) {

				if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

					$config['upload_path'] = './uploads/student_image/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('file')) {
						echo $this->upload->display_errors();
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
							'id' => $id,
							'image'          => 'uploads/student_image/' . $data["file_name"]
						);
						$this->add($image_data);
					}
				}
				$response = array(
					'status' => true,
					'notification' => 'Success!!!, Profile Updated Successfully.'
				);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Error'
				);
			}
		}
		return $response;
	}

	public function excel_create()
	{


		$fields = array(
			'reg_no',
			'firstname',
			'lastname',
			'middlename',
			'state'
		);
		$data["fields"] = $fields;
		$department_id = 	html_escape($this->input->post('department_id'));
		$course_id = 		html_escape($this->input->post('course_id'));
		$class_id = 		html_escape($this->input->post('class_id'));
		//$state_id = 		html_escape($this->input->post('state_id'));

		$school = $this->db->get_where('
			    courses', array(
			'id' => $course_id
		))->row();
		if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			if ($ext == 'csv') {
				$file = $_FILES['file']['tmp_name'];
				$this->load->library('CSVReader');
				//$this->load->library('CSVReader');
				$this->load->library('encoding_lib');
				$result = $this->csvreader->parse_file($file);
				if (!empty($result)) {
					$rowcount = 0;
					$duplication_counter = 0;
					for ($i = 1; $i <= count($result); $i++) {

						$user_data[$i] = array();
						$n = 0;
						//$state_id = $user_data[$i]["state"];
						foreach ($result[$i] as $key => $value) {

							$user_data[$i][$fields[$n]] = $this->encoding_lib->toUTF8($result[$i][$key]);
							//$user_data[$i]['roles'] = $role;
							$user_data[$i]['school_id'] = 				$school->school_id;
							$user_data[$i]['course_id'] =				$course_id;
							$user_data[$i]['department_id'] = 			$department_id;
							$user_data[$i]['admission_date'] = 			date('d/m/Y');
							//$user_data[$i]['password'] = sha1($phone);
							//$user_data[$i]['status'] = '1';
							//$user_data[$i]['is_active'] = '1';
							$user_data[$i]['is_active'] = 'yes';



							$n++;
						}
						$state = $user_data[$i]["state"];

						if ($state == 'Bauchi' || $state == 'BAUCHI' || $state == 'bauchi' || $state == 'Bau' || $state == 'BAU' || $state == 'bau') {
							$indigene = 'Indigene';
						} else {
							$indigene = 'Non-Indigene';
						};

						//$phone = "0" . $user_data[$i]["phone"];
						$adm_no = $user_data[$i]["reg_no"];
						$reg_no = $user_data[$i]["reg_no"];
						if ($class_id == 0) {
							$role = 'pre';
							$role_id = '5';
						} else {
							$role = 'student';
							$role_id = '4';
						}

						$name = $user_data[$i]["firstname"] . " " . $user_data[$i]["lastname"];
						//$user_data[$i]['student_type'] = $indigene;
						if ($this->form_validation->is_unique($adm_no, 'students.reg_no')) {

							if (!empty($adm_no)) {

								if ($this->check_regno_exists($adm_no, 0, $class_id)) {

									$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Record already exists.</div>');
									$response = array(
										'status' => false,
										'notification' => 'Record already exists.',
										'message' => 'Record already exists.'
									);
									$insert_id = "";
								} else {

									$insert_id =  $this->addForStaff($user_data[$i]);
									//$this->customlib->send_sms($name, $user_data['phone']);
								}
							} else {
								$insert_id =  $this->addForStaff($user_data[$i]);
							}
						} else {
							$insert_id = "";
						}

						//$phone = "0" . $user_data[$i]["phone"];
						//$sms_phone = "234" . $user_data[$i]["phone"];



						//	if ($role == "TRAINEE") {
						//$duplication_status = $this->check_bulk_phone_duplication('on_create', html_escape($phone));
						//} else {
						//	$duplication_status = $this->check_bulk_duplication('on_create', html_escape($user_data[$i]["email"]));
						//	}
						//if ($duplication_status) {
						//$user_id = $this->addForStaff($user_data[$i]);
						//$user_id = $this->db->insert_id();
						//$user_data[$i]['role_id'] = $role_id;
						//$user_data[$i]['role'] = $role;
						//
						if (!empty($insert_id)) {
							$user_password = sha1('password');
							$data = array(
								'id' => $insert_id,
								'student_type' => $indigene,
								'open_p' => 'password'
							);
							$this->add($data);
							$data_new = array(
								'student_id' => $insert_id,
								'class_id' => $class_id,
								'session_id' => current_session(),
								'role' => $role
								// 'semester_id' => $semester
							);
							$this->add_student_session($data_new);

							// $sibling_id = $this->input->post('sibling_id');
							$data_student_login = array(
								'user_id' => $insert_id,
								'firstname' => 				$user_data[$i]["firstname"],
								'lastname' => 				$user_data[$i]["lastname"] . " " . $user_data[$i]["middlename"],
								'username' => $reg_no,
								'password' => $user_password,
								'role_id' => $role_id,
								'role' => $role,
								//'phone' => 				$user_data[$i]["phone"],
								'date_added' => date('d/m/Y'),
								'status' => '1'
							);
							$this->db->insert('users', $data_student_login);
							$data['csvData'] = $result;
							$rowcount++;
							$response = array(
								'status' => true,
								'notification' => 'Total ' . $rowcount . ' records imported successfully. ',
								"message" => 'Total ' . count($result) . " records found in CSV file. Total " . $rowcount . ' records imported successfully.'
							);
						} else {
							$response = array(
								'status' => false,
								'notification' => 'Records already exists..',
								"message" => 'Records already exists..'
							);
						}


						/* 
						if ($duplication_counter > 0) {
							$response = array(
								'status' => false,
								'notification' => 'Some of the users already exist. Total ' . $rowcount . ' records imported successfully. ',
								'message' => 'Some of the users already exist. Total ' . $rowcount . ' records imported successfully. '
							);


							//$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Total ' . count($result) . " records found in CSV file. Total " . $rowcount . ' records imported successfully.</div>');
						} else {
							//$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Records already exists.." data-type="danger"></div>');
							//$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Records already exists.</div>');
							$response = array(
								'status' => true,
								'notification' => ' Total ' . count($result) . " records found in CSV file. Total " . $rowcount . ' records imported successfully.',
								'message' => ' Total ' . count($result) . " records found in CSV file. Total " . $rowcount . ' records imported successfully.'
							);
						} */
					}
				} else {
					$response = array(
						'status' => false,
						'notification' => 'No Data was Found'
					);
				}
				return json_encode($response);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Please upload CSV file only.'
				);
			}
		}
	}

	// Check user duplication
	public function check_duplication($action = "", $reg_no = "", $user_id = "")
	{
		$duplicate_reg_no_check = $this->db->get_where('students', array('reg_no' => $reg_no));
		if ($action == 'on_create') {
			if ($duplicate_reg_no_check->num_rows() > 0) {
				return false;
			} else {
				return true;
			}
		} elseif ($action == 'on_update') {
			if ($duplicate_reg_no_check->num_rows() > 0) {
				if ($duplicate_reg_no_check->row()->id == $user_id) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}
	}
	function check_regno_exists($reg_no, $student_id, $class)
	{

		if ($student_id != 0) {
			$data = array('students.id != ' => $student_id, 'student_session.class_id' => $class, 'students.ceg_no' => $reg_no);
			$query = $this->db->where($data)->join("student_session", "students.id = student_session.student_id")->get('students');
			if ($query->num_rows() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	// Check user duplication
	public function check_phones_duplication($action = "", $phone = "", $user_id = "")
	{
		$duplicate_phone_check = $this->db->get_where('students', array('phone' => $phone));
		if ($action == 'on_create') {
			if ($duplicate_phone_check->num_rows() > 0) {
				return false;
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
	// Check user duplication
	public function check_bulk_duplication($action = "", $email = "", $user_id = "")
	{
		$duplicate_email_check = $this->db->get_where('users', array('email' => $email));

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
	public function add($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('students', $data);
		} else {
			$this->db->insert('students', $data);
		}
		return true;
	}

	public function add_user($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('users', $data);
		} else {
			$this->db->insert('users', $data);
		}
		return true;
	}
	public function update_user($data)
	{
		$this->db->where('user_id', $data['user_id']);
		$this->db->where('role_id', '4');
		$q = $this->db->get('users');
		if ($q->num_rows() > 0) {
			$rec = $q->row_array();
			$this->db->where('id', $rec['id']);
			$this->db->update('users', $data);
		} else {

			return FALSE;
		}
	}

	public function addForStaff($data)
	{
		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(false); # See Note 01. If you wish can remove as well
		//=======================Code Start===========================
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('students', $data);
			$message = UPDATE_RECORD_CONSTANT . " On  Student id " . $data['id'];
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
			$this->db->insert('students', $data);
			$insert_id = $this->db->insert_id();
			$message = INSERT_RECORD_CONSTANT . " On Student id " . $insert_id;
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
	public function add_student_session($data)
	{
		$this->db->where('session_id', $data['session_id']);
		$this->db->where('student_id', $data['student_id']);
		$q = $this->db->get('student_session');
		if ($q->num_rows() > 0) {
			$rec = $q->row_array();
			$this->db->where('id', $rec['id']);
			$this->db->update('student_session', $data);
		} else {
			$this->db->insert('student_session', $data);
			return $this->db->insert_id();
		}
	}

	function set_login_userdata($user_id = "")
	{
		// Checking login credential for admin
		$query = $this->db->get_where('users', array('user_id' => $user_id));

		if ($query->num_rows() > 0) {
			$row = $query->row();
			//604800s == 7 days
			$this->session->set_userdata('custom_session_limit', (time() + 604800));
			$this->session->set_userdata('user_id', $row->user_id);
			$this->session->set_userdata('role_id', $row->role_id);
			$this->session->set_userdata('role', $row->role); //get_user_role('user_role', $row->id)
			$this->session->set_userdata('name', $row->firstname . ' ' . $row->lastname);
			//$this->session->set_userdata('is_instructor', $row->is_instructor);
			$this->session->set_flashdata('flash_message', get_phrase('welcome') . ' ' . $row->firstname . ' ' . $row->lastname);
			$this->session->set_userdata('student_login', '1');
			//redirect(site_url('applicant/dashboard'), 'refresh');
		} else {
			$this->session->set_flashdata('error_message', get_phrase('invalid_login_credentials'));
			redirect(site_url('login/index'), 'refresh');
		}
	}

	function validate_login($username, $password)
	{
		$sha_password = sha1($password);
		$this->db->select('*');
		$this->db->from('users');
		//$this->db->group_start();
		$this->db->where('username', $username); //->or_where('phone', $username);
		//$this->db->group_end();
		$this->db->where('password', $sha_password);
		return $this->db->get();
	}

	public function session_destroy()
	{
		$logged_in_user_id = $this->session->userdata('user_id');
		if ($logged_in_user_id > 0 && $this->session->userdata('student_login') == 1) {
			$pre_sessions = array();
			$updated_session_arr = array();
			$current_session_id = session_id();

			$this->db->where('id', $logged_in_user_id);
			$sessions = $this->db->get('students')->row('sessions');
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
				$this->db->update('students', $data);
			}
		}

		//$this->session->unset_userdata('admin_login');
		$this->session->unset_userdata('student_login');
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
	function getTotalActive()
	{
		$this->db->select()->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->where('students.state_id !=', NULL);
		$this->db->where('student_session.session_id', $this->current_session);
		//$this->db->where('students.gender', 'Male');
		$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();

		return $query->num_rows();
	}
	function getTotalMale()
	{
		$this->db->select()->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->where('students.gender', 'M');
		//$this->db->where('students.state_id !=', NULL);
		$this->db->where('student_session.session_id', $this->current_session);
		//$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();

		return $query->num_rows();
	}
	function getTotalFemale()
	{
		$this->db->select()->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->where('students.gender', 'F');
		//$this->db->where('students.state_id !=', NULL);
		$this->db->where('student_session.session_id', $this->current_session);
		//$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();

		return $query->num_rows();
	}
	function getTotalIndigene()
	{
		$this->db->select()->from('students');
		$this->db->where('students.state_id', 5);
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->where('student_session.session_id', $this->current_session);
		$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();

		return $query->num_rows();
	}
	function getTotalNonIndigene()
	{
		$this->db->select()->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id');
		$this->db->where('students.state_id !=', 5);
		$this->db->where('student_session.session_id', $this->current_session);
		$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();

		return $query->num_rows();
	}
	function getRegistered()
	{
		$this->db->select()->from('students');
		$this->db->join('payment_deposits', 'payment_deposits.student_id = students.id', 'left');
		//$this->db->where('payment_deposits.class_id', 1);
		$this->db->where('payment_deposits.status', 'paid');
		$this->db->where('payment_deposits.type !=', 'admission_fee');
		//$this->db->where('payment_deposits.semester_id', $this->current_semester);
		$this->db->where('payment_deposits.session_id', $this->current_session);
		$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();
		return $query->num_rows();
	}
	function getWeeding()
	{
		$this->db->select()->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id', 'left');
		$this->db->where('student_session.class_id', 0);
		$this->db->where('student_session.session_id', $this->current_session);
		$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get100L()
	{
		$this->db->select()->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id', 'left');
		$this->db->where('student_session.class_id', 1);
		$this->db->where('student_session.session_id', $this->current_session);
		$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get200L()
	{
		$this->db->select()->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id', 'left');
		$this->db->where('student_session.class_id', 2);
		$this->db->where('student_session.session_id', $this->current_session);
		$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();
		return $query->num_rows();
	}
	function get300L()
	{
		$this->db->select()->from('students');
		$this->db->join('student_session', 'student_session.student_id = students.id', 'left');
		$this->db->where('student_session.class_id', 3);
		$this->db->where('student_session.session_id', $this->current_session);
		$this->db->where('students.is_active', 'yes');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function passreset($id)
	{

		$password = "password";
		$encryp_password = sha1($password);
		$student_data = array('open_p' => $password);
		$userdata = array('password' => $encryp_password);
		$this->db->where("id", $id)->update("students", $student_data);
		$query = $this->db->where("user_id", $id)->update("users", $userdata);
		return true;
	}

	public function insert_student($data)
	{
		if ($this->student_exists($data['reg_no'])) {
			return array('status' => 'exists', 'data' => $data);
		} else {
			//$this->db->insert('students', $data);
			$insert_id = $this->addForStaff($data);
			return array('status' => 'inserted', 'insert_id' => $insert_id, 'data' => $data);
		}
	}

	public function student_exists($reg_no)
	{
		$this->db->where('reg_no', $reg_no);
		$query = $this->db->get('students');
		return $query->num_rows() > 0;
	}

	public function get_last_registration_numbers($department_formats)
	{
		$last_reg_nos = [];

		foreach ($department_formats as $course_id => $base_format) {
			$this->db->select('reg_no')
				->from('students')
				->like('reg_no', $base_format)
				->order_by('reg_no', 'DESC')
				->limit(1);
			$query = $this->db->get();
			$result = $query->row_array();

			// Store last registration number or null if no match found
			$last_reg_nos[$course_id] = $result['reg_no'] ?? null;
		}

		return $last_reg_nos;
	}

	public function process_csv_file()
	{


		$fields = array(
			'reg_no',
			'course'
		);
		$data["fields"] = $fields;



		if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			if ($ext == 'csv') {
				$file = $_FILES['file']['tmp_name'];
				$this->load->library('CSVReader');
				$this->load->library('encoding_lib');
				$result = $this->csvreader->parse_file($file);

				if (!empty($result)) {
					$rowcount = 0;
					foreach ($result as $i => $row) {
						$user_data = array();

						// Retrieve the course code from the CSV file (column C)
						$course_code = $row[1]; // Assuming column C is index 2

						// Query the database to get the course_id based on course_code
						$this->db->select('id');
						$this->db->from('courses');
						$this->db->where('code', $course_code);
						$query = $this->db->get();
						$course = $query->row();

						if ($course) {
							$course_id = $course->course_id;
						} else {
							continue; // Skip this row if course_code is not found
						}

						// Check if reg_no exists in students table
						$reg_no = $row[0]; // Assuming reg_no is in column 0
						$this->db->select('id, course_id');
						$this->db->from('students');
						$this->db->where('reg_no', $reg_no);
						$student_query = $this->db->get();
						$student = $student_query->row();

						if ($student) {
							// Map department IDs to their formats
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

							//$course_id = $student->course_id;
							$base_format = isset($department_formats[$course_id]) ? $department_formats[$course_id] : "BMG/UNKNOWN/24/24/";

							// Retrieve the last reg_no for this department
							$this->db->select('reg_no');
							$this->db->from('students');
							$this->db->like('reg_no', $base_format, 'after');
							$this->db->order_by('reg_no', 'DESC');
							$this->db->limit(1);
							$query = $this->db->get();
							$last_reg_no = $query->row_array()['reg_no'] ?? null;

							// Increment the reg_no
							if ($last_reg_no) {
								$last_number = (int)substr($last_reg_no, strrpos($last_reg_no, '/') + 1);
								$new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
							} else {
								$new_number = '001';
							}

							$new_reg_no = $base_format . $new_number;
							$update_form_no = array(
								'form_no' => $student['reg_no']
							);

							$this->db->where('id', $student->id);
							$this->db->update('students', $update_form_no);
							// Update the student's reg_no in students and users table
							$data_update = ['reg_no' => $new_reg_no];
							$this->db->where('id', $student->id);
							$this->db->update('students', $data_update);
							$payment_data = [

								'student_id' => $student->id,
								'date' => date('d-m-Y'),
								'class_id' => 0,
								'session_id' => current_session(),
								'receipt' => 'uploaded',
								'descr' => 'Admission Access Fee',
								'type' => 'admission_fee',
								'txn' => $this->ref,
								'amount' => 2000,
								'status' => 'paid'
							];
							$this->db->insert('payment_deposits', $payment_data);

							$username_update = ['username' => $new_reg_no];
							$this->db->where('user_id', $student->id);
							$this->db->update('users', $username_update);

							$rowcount++;
						}
					}
					$response = array(
						'status' => true,
						'notification' => 'Total ' . $rowcount . ' records processed successfully.'
					);
				} else {
					$response = array(
						'status' => false,
						'notification' => 'No Data was Found'
					);
				}
				return json_encode($response);
			} else {
				$response = array(
					'status' => false,
					'notification' => 'Please upload CSV file only.'
				);
			}
		}
	}

	// Process XLS data
	public function process_xls_file($data)
	{
		$response = ['status' => true, 'message' => 'Records processed successfully.'];

		foreach ($data as $row) {
			// Skip the header row if it exists
			if ($row[0] === 'reg_no') {
				continue;
			}
			$reg_no = $row[0];
			$firstname = $row[1];
			$lastname = $row[2];
			$middlename = $row[3];

			$course_code = $row[4];
			// Fetch course_id based on course_code in row[2]
			$course = $this->db->get_where('courses', ['code' => $row[4]])->row();
			if ($course) {
				$course_id = $course ? $course->id : null;

				// Check if reg_no in row[0] exists in the students table
				$student = $this->db->get_where('students', ['reg_no' => $row[0]])->row();
				if ($student) {
					$id = $student->id;
					//$course_id = $student->course_id;
					// Generate new reg_no based on last number for department
					$new_reg_no = $this->generate_new_reg_no($course_id);
					// Update the student's reg_no
					$this->db->where('id', $id);
					$this->db->update('students', ['form_no' => $reg_no]);

					// Update the student's reg_no
					$this->db->where('id', $id);
					$this->db->update('students', ['reg_no' => $new_reg_no, 'course_id' => $course_id]);

					// Update the student's username in the users table
					$this->db->where('user_id', $id);
					$this->db->update('users', ['username' => $new_reg_no]);
					$payment_data = [

						'student_id' => $id,
						'date' => date('d-m-Y'),
						'class_id' => 0,
						'session_id' => current_session(),
						'receipt' => 'uploaded',
						'descr' => 'Admission Access Fee',
						'type' => 'admission_fee',
						'txn' => 'uploaded',
						'amount' => 2000,
						'status' => 'paid'
					];
					$this->db->insert('payment_deposits', $payment_data);
					// Add the processed record to the array, including the student's name
					$processed_data[] = [
						'original_reg_no' => $row[0],
						'new_reg_no' => $new_reg_no,
						'name' => $student->firstname . ' ' . $student->lastname . ' ' . $student->middlename,  // Fetching student's name
						'course_code' => $row[4],
						'course_id' => $course_id,
					];
				} else {
					$student_form = $this->db->get_where('students', ['form_no' => $row[0]])->row();
					if ($student_form) {
					} else {

						$school = $this->db->get_where('
						courses', array(
							'id' => $course_id
						))->row();
						// Student does not exist, add new student record
						$new_reg_no = $this->generate_new_reg_no($course_id);

						$new_student_data = [
							'reg_no' => $new_reg_no,
							'form_no' => $reg_no,
							'firstname' => $firstname,
							'middlename' => $middlename,
							'lastname' => $lastname,
							'course_id' => $course_id,
							'state_id' => 5,
							'is_active' => 'yes',
							'admission_date' => date('d/m/Y'),
							'school_id' => $school->school_id,
							'department_id' => $school->department_id,
						];
						$insert_id =  $this->addForStaff($new_student_data);
						if (!empty($insert_id)) {
							$user_password = sha1('password');
							$data = array(
								'id' => $insert_id,
								'student_type' => 'Indigene',
								'open_p' => 'password'
							);
							$this->add($data);
							$data_new = array(
								'student_id' => $insert_id,
								'class_id' => 0,
								'session_id' => current_session(),
								'role' => 'pre'
								// 'semester_id' => $semester
							);
							$this->add_student_session($data_new);

							// $sibling_id = $this->input->post('sibling_id');
							$data_student_login = array(
								'user_id' => $insert_id,
								'firstname' => $firstname,
								'lastname' => $lastname . " " . $middlename,
								'username' => $new_reg_no,
								'password' => $user_password,
								'role_id' => 5,
								'role' => 'pre',
								//'phone' => 				$user_data[$i]["phone"],
								'date_added' => date('d/m/Y'),
								'status' => '1'
							);
							$this->db->insert('users', $data_student_login);
						}
						$payment_data = [

							'student_id' => $insert_id,
							'date' => date('d-m-Y'),
							'class_id' => 0,
							'session_id' => current_session(),
							'receipt' => 'uploaded',
							'descr' => 'Admission Access Fee',
							'type' => 'admission_fee',
							'txn' => 'uploaded',
							'amount' => 2000,
							'status' => 'paid'
						];
						$this->db->insert('payment_deposits', $payment_data);
						// Add the new student record to the processed data
						$processed_data[] = [
							'original_reg_no' => $reg_no,
							'new_reg_no' => $new_reg_no,
							'name' => "$firstname $lastname",
							'course_code' => $course_code,
							'course_id' => $course_id,
						];
					}
				}
			}
		}
		return $processed_data;
	}

	// Process XLS data
	public function process_xls_file_for_change($data)
	{
		$response = ['status' => true, 'message' => 'Records processed successfully.'];

		foreach ($data as $row) {
			// Skip the header row if it exists
			if ($row[0] === 'reg_no') {
				continue;
			}
			$reg_no = $row[0];
			$firstname = $row[1];
			$lastname = $row[2];
			$middlename = $row[3];

			$course_code = $row[4];
			// Fetch course_id based on course_code in row[2]
			$course = $this->db->get_where('courses', ['code' => $row[4]])->row();
			// if ($course) {
			//	$course_id = $course ? $course->id : null;

			// Check if reg_no in row[0] exists in the students table
			$matric_no_check = $this->db->get_where('applicants', ['application_no' => $row[0]])->row();
			//$form_no_check = $this->db->get_where('students', ['form_no' => $row[0]])->row();

			//if ($matric_no_check || $form_no_check) {
			//if ($matric_no_check){
			$student = $matric_no_check;
			$id = $student->id;
			//$course_id = $student->course_id;
			// Generate new reg_no based on last number for department
			//$new_reg_no = $this->generate_new_reg_no($course_id);
			// Update the student's reg_no
			//$this->db->where('id', $id);
			//$this->db->update('students', ['form_no' => $reg_no]);

			// Update the student's reg_no
			//$this->db->where('id', $id);
			//$this->db->update('students', ['reg_no' => $new_reg_no,'course_id'=>$course_id]);

			// Update the student's username in the users table
			//$this->db->where('user_id', $id);
			//$this->db->update('users', ['username' => $new_reg_no]);
			/* $payment_data = [
	
							'student_id' => $id,
							'date' => date('d-m-Y'),
							'class_id' => 0,
							'session_id' => current_session(),
							'receipt' => 'uploaded',
							'descr' => 'Admission Access Fee',
							'type' => 'admission_fee',
							'txn' => 'uploaded',
							'amount'=>2000,
							'status' => 'paid'
						]; */
			//$this->db->insert('payment_deposits', $payment_data);
			// Add the processed record to the array, including the student's name
			$processed_data[] = [
				'original_reg_no' => $row[0],
				//'new_reg_no' => $new_reg_no,
				'name' => $student->firstname . ' ' . $student->lastname . ' ' . $student->middlename,  // Fetching student's name
				'course_code' => $student->phone,
				'course_id' => $student->phone,
			];
			/* }else{
						$student=$form_no_check;
						$id = $student->id;
						//$course_id = $student->course_id;
						// Generate new reg_no based on last number for department
						$new_reg_no = $this->generate_new_reg_no($course_id);
					
						// Update the student's reg_no
						$this->db->where('id', $id);
						$this->db->update('students', ['reg_no' => $new_reg_no,'course_id'=>$course_id]);
	
						// Update the student's username in the users table
						$this->db->where('user_id', $id);
						$this->db->update('users', ['username' => $new_reg_no]);
						
						 // Add the processed record to the array, including the student's name
						$processed_data[] = [
							'original_reg_no' => $row[0],
							'new_reg_no' => $new_reg_no,
							'name' => $student->firstname.' '.$student->lastname.' '.$student->middlename,  // Fetching student's name
							'course_code' => $row[4],
							'course_id' => $course_id,
						];
					}; */
			//}

		}
		// }
		return $processed_data;
	}

	function upload_xls_level_change($data)
	{
		$response = ['status' => true, 'message' => 'Records processed successfully.'];

		foreach ($data as $row) {
			// Skip the header row if it exists
			if ($row[0] === 'reg_no') {
				continue;
			}
			$reg_no = $row[0];
			$firstname = $row[1];
			$lastname = $row[2];
			$middlename = $row[3];

			$course_code = $row[4];
			// Fetch course_id based on course_code in row[2]
			$course = $this->db->get_where('courses', ['code' => $row[4]])->row();
			// if ($course) {
			$course_id = $course ? $course->id : null;

			// Check if reg_no in row[0] exists in the students table
			$matric_no_check = $this->db->get_where('students', ['reg_no' => $row[0]])->row();
			$form_no_check = $this->db->get_where('students', ['form_no' => $row[0]])->row();

			if ($matric_no_check || $form_no_check) {
				//if ($matric_no_check){
				$student = $matric_no_check;
				$id = $student->id;
				//$course_id = $student->course_id;
				// Generate new reg_no based on last number for department
				//$new_reg_no = $this->generate_new_reg_no($course_id);
				// Update the student's reg_no
				$this->db->where('id', $id);
				$this->db->update('students', ['course_id' => $course_id]);

				// Update the student's reg_no
				$this->db->where('student_id', $id);
				$this->db->update('student_session', ['class_id' => 1, 'role' => 'student']);

				// Update the student's username in the users table
				$this->db->where('user_id', $id);
				$this->db->update('users', ['role_id' => '4', 'role' => 'student']);
				/* $payment_data = [
	
							'student_id' => $id,
							'date' => date('d-m-Y'),
							'class_id' => 0,
							'session_id' => current_session(),
							'receipt' => 'uploaded',
							'descr' => 'Admission Access Fee',
							'type' => 'admission_fee',
							'txn' => 'uploaded',
							'amount'=>2000,
							'status' => 'paid'
						]; */
				//$this->db->insert('payment_deposits', $payment_data);
				// Add the processed record to the array, including the student's name
				$processed_data[] = [
					'original_reg_no' => $row[0],
					//'new_reg_no' => $new_reg_no,
					'name' => $student->firstname . ' ' . $student->lastname . ' ' . $student->middlename,  // Fetching student's name
					'course_code' => $student->phone,
					'course_id' => $student->phone,
				];
				/* }else{
						$student=$form_no_check;
						$id = $student->id;
						//$course_id = $student->course_id;
						// Generate new reg_no based on last number for department
						$new_reg_no = $this->generate_new_reg_no($course_id);
					
						// Update the student's reg_no
						$this->db->where('id', $id);
						$this->db->update('students', ['reg_no' => $new_reg_no,'course_id'=>$course_id]);
	
						// Update the student's username in the users table
						$this->db->where('user_id', $id);
						$this->db->update('users', ['username' => $new_reg_no]);
						
						 // Add the processed record to the array, including the student's name
						$processed_data[] = [
							'original_reg_no' => $row[0],
							'new_reg_no' => $new_reg_no,
							'name' => $student->firstname.' '.$student->lastname.' '.$student->middlename,  // Fetching student's name
							'course_code' => $row[4],
							'course_id' => $course_id,
						];
					}; */
			}

			// }
		}
		return $processed_data;
	}


	// Generate a new reg_no based on the course_id
	private function generate_new_reg_no($course_id)
	{
		// Map department IDs to the corresponding formats
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

		// Get the base format for the department
		$base_format = isset($department_formats[$course_id]) ? $department_formats[$course_id] : "BMG/UNKNOWN/24/24/";

		// Find the last registered number for this department
		$this->db->select('reg_no');
		$this->db->from('students');
		$this->db->like('reg_no', $base_format);
		$this->db->order_by('reg_no', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		$last_reg_no = $query->row_array()['reg_no'];

		// Increment the last number
		$last_number = $last_reg_no ? (int)substr($last_reg_no, strrpos($last_reg_no, '/') + 1) : 0;
		$new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);

		return $base_format . $new_number;
	}
	public function get_by_matric($reg_no)
	{
		return $this->db->get_where('students', ['reg_no' => $reg_no])->row_array();
	}
}
