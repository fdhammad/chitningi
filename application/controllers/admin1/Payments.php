<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payments extends CI_Controller
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

public function get_custom_id($prefix, $student_id)
	{
		//$max_id = '';
		//$this->db->select_max('id');
		$id = $student_id;
		$student = $this->student_model->get($id);
		$max_id = $this->payment_model->max_id($student['course_id']);

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
	function manage_amounts()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('payments');
		$page_data['page_name'] = "payments/manage_amount";
		$page_data['page_title'] = site_phrase('payment_items');
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		$department = $this->department_model->get();
		$page_data['departmentlist'] = $department;
		$class = $this->class_model->get();
		$page_data['classlist'] = $class;
		$semester = $this->semester_model->get();
		$page_data['semesters'] = $semester;
		$tax = $this->customlib->getTax();
		$page_data['tax'] = $tax;
		$indigene = $this->customlib->getIndigene();
		$page_data['indigene'] = $indigene;
		$payment_type = $this->customlib->getPaymentType();
		$page_data['payment_type'] = $payment_type;
		$this->load->view('admin/index',  $page_data);
		if ($this->input->server('REQUEST_METHOD') == "POST") {
			$loop = $this->input->post('i');
			$array = array();
			foreach ($loop as $key => $value) {
				$s = array();
				// $s['session_id'] = $this->setting_model->getCurrentSession();
				$payment_type = $this->input->post('payment_type');
				$department_id = $this->input->post('department_id');
				$course_id = $this->input->post('course_id');
				$class_id = $this->input->post('class_id');
				$semester_id = $this->input->post('semester_id');
				$indigene = $this->input->post('indigene');

				//$dt = $this->suggestion_model->getDetailbyClassSemester($class_id, $semester_id);
				$s['payment_type'] = $payment_type;
				$s['department_id'] = $department_id;
				$s['course_id'] = $course_id;
				$s['class_id'] = $class_id;
				$s['semester_id'] = $semester_id;
				$s['indigene'] = $indigene;
				//$s['class_semester_id'] = $dt['id'];
				$s['name'] = $this->input->post('name_' . $value);
				$s['amount'] = $this->input->post('amount_' . $value);
				$s['type'] = $this->input->post('type_' . $value);
				$row_id = $this->input->post('row_id_' . $value);
				if ($row_id == 0) {
					$insert_id = $this->payment_model->additems($s);
					$array[] = $insert_id;
				} else {
					$s['id'] = $row_id;
					$array[] = $row_id;
					$this->payment_model->additems($s);
				}
			}

			$ids = $array;
			//$class_semester_id = $dt['id'];
			$this->payment_model->deleteBatch($ids, $department_id, $course_id, $class_id, $semester_id, $payment_type, $indigene);
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="Record updated successfully." data-type="success"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Record updated successfully</div>');
			redirect('admin/payments/manage_amounts');
		}
	}

	public function getPaymentItems()
	{
		$payment_type = $this->input->post('payment_type');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('payment_type', 'Payment Category', 'trim|required|xss_clean');
		if ($payment_type == 'application') {
		} elseif ($payment_type == 'pre_weeding' || $payment_type == 'post_weeding') {
			$this->form_validation->set_rules('department_id', 'Department', 'trim|required|xss_clean');
			$this->form_validation->set_rules('course_id', 'Course', 'trim|required|xss_clean');
		} elseif ($payment_type == 'semester') {
			$this->form_validation->set_rules('department_id', 'Department', 'trim|required|xss_clean');
			$this->form_validation->set_rules('course_id', 'Course', 'trim|required|xss_clean');
			$this->form_validation->set_rules('class_id', 'Level', 'trim|required|xss_clean');
			$this->form_validation->set_rules('semester_id', 'Semester', 'trim|required|xss_clean');
			$this->form_validation->set_rules('indigene', 'Indigene Typr', 'trim|required|xss_clean');
		}

		if ($this->form_validation->run()) {

			$department_id = $this->input->post('department_id');
			$course_id = $this->input->post('course_id');
			$class_id = $this->input->post('class_id');
			$semester_id = $this->input->post('semester_id');
			$indigene = $this->input->post('indigene');
			//$dt = $this->suggestion_model->getDetailbyClassSemester($class_id, $semester_id);
			$data = $this->payment_model->getDetailByItems($payment_type, $department_id, $course_id, $class_id, $semester_id, $indigene);
			echo json_encode(array('st' => 0, 'msg' => $data));
		} else {
			$data = array(
				'payment_type' => form_error('payment_type'),
				'department_id' => form_error('department_id'),
				'course_id' => form_error('course_id'),
				'class_id' => form_error('class_id'),
				'semester_id' => form_error('semester_id'),
				'indigene' => form_error('indigene'),
			);
			echo json_encode(array('st' => 1, 'msg' => $data));
		}
	}
	
	function application_trans()
	{
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('payments');
		$page_data['page_name'] = "payments/application_trans";
		$page_data['page_title'] = site_phrase('application_transactions');
		//$feeList = $this->payment_model->getAllDeposits();
		//$ref = $feeList->txn;
		//$data['feeList'] = $feeList;
		$this->load->view('admin/index',  $page_data);
		//$this->load->view('layout/footer', $data);
	}
	function application_trans_ajax()
	{
		//$this->data['title'] = 'Check RRR';
		$feeList = $this->payment_model->getApplicationAllDeposits();
		//$ref = $feeList->txn;
		$this->data['feeList'] = $feeList;
		$ret['render'] = $this->load->view('admin/payments/application_trans_ajax', $this->data, true);
		$ret['status'] = true;
		echo json_encode($ret);
		exit;
	}
	function check_application_status($id)
	{
		
		$paymentid = $this->input->post('RRR');
		//$ref = $feeList['txn'];
		$RRR =  $paymentid;
		$mert =  "5751670525";
		$api_key = "513780";
		$mode = "Live";
		$hash_string = $RRR . $api_key . $mert;
		$hash = hash('sha512', $hash_string);
		if ($mode == 'Test') {
			$query_url = 'https://remitademo.net/remita/ecomm';
		} else if ($mode == 'Live') {
			$query_url = 'https://login.remita.net/remita/ecomm';
		}
		$url     = $query_url . '/' . $mert  . '/' . $RRR . '/' . $hash . '/' . 'status.reg';
		$result = file_get_contents($url);
		$response = json_decode($result, true);
		/* var_dump($response); */
		$amount = trim($response['amount'], " ");
		$message = trim($response['message'], " ");
		$RRR = trim($response['RRR'], " ");
		$status = trim($response['status'], " ");
		$date = date('y');
		$random = 'CHTNG/ADM/' . $date . '/';
		$str_lenght = 4;
		$id_int = substr("0000{$id}", -$str_lenght);
		$application_no = $random . $id_int;
		$no = $application_no;
		$token = $this->customlib->getToken();
		$no = $application_no;
		if ($status == "01" || $status == "00") {
			$data1 = array(
				'date' => date('d-m-Y'),
				'amount' => $amount,
				'status' => "paid"
			);
			$this->db->where('receipt', $RRR);
			$this->db->update('applicant_deposits', $data1);
			$da1 = array(
				'token' => $token,
				'token_status' => 'taken',
				'application_no' => $no
			);
			$this->db->where('id', $id);
			$this->db->update('applicants', $da1);
			$applicant = $this->applicant_model->getAll($id)->row_array();
			$name=$applicant['firstname']." ".$applicant['lastname']." ".$applicant['middlename'] ;
			$this->email_model->send_mail('info@diidol.com.ng',$name,$amount,'Application Form');
			$this->customlib->send_sms($name,$applicant['phone'],$amount,'Application Form',$RRR);
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="Payment is ' . $message . ', Thank You." data-type="success"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Payment is ' . $message . ', Thank You</div>');
			redirect('admin/payments/application_trans');
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Payment is ' . $message . ', Thank You." data-type="warning"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Payment is ' . $message . ', Thank You</div>');
			redirect('admin/payments/application_trans');
		}
	}

	function search()
	{
		
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('staff/login'), 'refresh');
		}
		// CHECK ACCESS PERMISSION
		check_permission('payments');
		$page_data['page_name'] = "payments/search";
		$page_data['page_title'] = site_phrase('search_payments');
		$this->form_validation->set_rules('receipt', 'Receipt No', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
		} else {
			$string = $this->input->post('receipt');
			$receipt = str_replace('-', '', $string);
			$feeList = $this->payment_model->all_search($receipt);
			$page_data['feeList'] = $feeList;
			//echo $receipt;
		}
		$this->load->view('admin/index',  $page_data);
	}
	function check_status($student_id)
	{
		$data['title'] = 'Edit studentfees';
		$student = $this->student_model->get($student_id);
		$paymentid = $this->input->post('RRR');
		$feeList = $this->payment_model->getSearchPayment($paymentid);
		//$ref = $feeList['txn'];
		$data['feeList'] = $feeList;
		$RRR =  $paymentid;
		$mert =  "5751670525";
		$api_key = "513780";
		$mode = "Live";
		$hash_string = $RRR . $api_key . $mert;
		$hash = hash('sha512', $hash_string);
		if ($mode == 'Test') {
			$query_url = 'https://remitademo.net/remita/ecomm';
		} else if ($mode == 'Live') {
			$query_url = 'https://login.remita.net/remita/ecomm';
		}
		$url     = $query_url . '/' . $mert  . '/' . $RRR . '/' . $hash . '/' . 'status.reg';
		$result = file_get_contents($url);
		$response = json_decode($result, true);
		/* var_dump($response); */
		$amount = trim($response['amount'], " ");
		$message = trim($response['message'], " ");
		$RRR = trim($response['RRR'], " ");
		$status = trim($response['status'], " ");
		$prefix = $student['code'] . "/21/";

		$custom = $this->get_custom_id($prefix, $student_id);
		$reg_no = $custom;

		if ($status == "01") {
			if (substr($student['reg_no'], 0, 8) == $prefix) {
				$data1 = array(
					'amount' => $amount,
					'status' => "paid"
				);
				$this->db->where('receipt', $RRR);
				$this->db->update('payment_deposits', $data1);
			} else {
				$update_reg_no = array(
					'id' => $student_id,
					'reg_no' => $reg_no
				);
				$this->student_model->add($update_reg_no);
				$data1 = array(
					'amount' => $amount,
					'status' => "paid"
				);
				$this->db->where('receipt', $RRR);
				$this->db->update('payment_deposits', $data1);
			};
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="Payment is ' . $message . ', Thank You." data-type="success"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Payment is ' . $message . ', Thank You</div>');
			redirect('admin/payments/check_rrr');
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Payment is ' . $message . ', Thank You." data-type="warning"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Payment is ' . $message . ', Thank You</div>');
			redirect('admin/payments/check_rrr');
		}
	}
	function check_status2($student_id)
	{
		
		$data['title'] = 'Edit studentfees';
		$student = $this->student_model->get($student_id);
		$paymentid = $this->input->post('RRR');
		$feeList = $this->payment_model->getSearchPayment($paymentid);
		//$ref = $feeList['txn'];
		$data['feeList'] = $feeList;
		$RRR =  $paymentid;
		$mert =  "5751670525";
		$api_key = "513780";
		$mode = "Live";
		$hash_string = $RRR . $api_key . $mert;
		$hash = hash('sha512', $hash_string);
		if ($mode == 'Test') {
			$query_url = 'https://remitademo.net/remita/ecomm';
		} else if ($mode == 'Live') {
			$query_url = 'https://login.remita.net/remita/ecomm';
		}
		$url     = $query_url . '/' . $mert  . '/' . $RRR . '/' . $hash . '/' . 'status.reg';
		$result = file_get_contents($url);
		$response = json_decode($result, true);
		/* var_dump($response); */
		$amount = trim($response['amount'], " ");
		$message = trim($response['message'], " ");
		$RRR = trim($response['RRR'], " ");
		$status = trim($response['status'], " ");
		$prefix = $student['code'] . "/21/";

		$custom = $this->get_custom_id($prefix, $student_id);
		$reg_no = $custom;

		if ($status == "01") {
			if (substr($student['reg_no'], 0, 8) == $prefix) {
				$data1 = array(
					'amount' => $amount,
					'status' => "paid"
				);
				$this->db->where('receipt', $RRR);
				$this->db->update('payment_deposits', $data1);
			} else {
				$update_reg_no = array(
					'id' => $student_id,
					'reg_no' => $reg_no
				);
				$this->student_model->add($update_reg_no);
				$data1 = array(
					'amount' => $amount,
					'status' => "paid"
				);
				$this->db->where('receipt', $RRR);
				$this->db->update('payment_deposits', $data1);
			};
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="Payment is ' . $message . ', Thank You." data-type="success"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Payment is ' . $message . ', Thank You</div>');
			redirect('admin/payments/search');
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Payment is ' . $message . ', Thank You." data-type="warning"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Payment is ' . $message . ', Thank You</div>');
			redirect('admin/payments/search');
		}
	}
}
