<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library('session');
		/*cache control*/
		//$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		//$this->output->set_header('Pragma: no-cache');

		$this->user_model->check_session_data('student');
		$this->ref = $this->student_model->getReference();
		//$this->ref = $this->customlib->getReference();
		$this->current_semester = current_semester();
		$this->current_session = current_session();
		$this->current_semester_name = current_semester_name();
		$this->current_session_name = current_session_name();
		$this->paymentSwitch = $this->switch_model->getPayment();
		$this->paymentMethod = $this->switch_model->getPaymentMethod();
		$this->CoureRegSwitch = $this->switch_model->getCourseReg();
	}

	public function reportPDF($stylesheet = NULL, $data = NULL, $viewpath = NULL, $title = null, $subtitle = null, $mode = 'view', $pagesize = 'a4', $pagetype = 'portrait')
	{

		$this->data['panel_title'] = $title;
		$html = $this->load->view($viewpath, $this->data, true);

		$this->load->library('mhtml2pdf');

		$this->mhtml2pdf->folder('uploads/report/');
		$this->mhtml2pdf->filename($subtitle);
		$this->mhtml2pdf->paper($pagesize, $pagetype);
		$this->mhtml2pdf->html($html);

		if (!empty($stylesheet)) {
			$stylesheet = file_get_contents(base_url('assets/reports/' . $stylesheet));
			return $this->mhtml2pdf->create($this->data['panel_title'], $stylesheet, $mode);
		} else {
			return $this->mhtml2pdf->create($this->data['panel_title'], $mode);
		}
	}

	function dashboard()
	{
		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$id = $this->session->userdata('user_id');
		$page_data['page_title'] = get_phrase('dashboard');
		$student = $this->student_model->get($id);
		if ($student['current_address'] != '') {
			if ($student['role'] == 'pre') {
				$check_admission_payment = $this->payment_model->checkAdmissionPayment($student['id']);

				if ($check_admission_payment != true) {
					$page_data['page_name'] = 'admission_dashboard';
					$amount = $this->payment_model->getAdmissionAmount()->amount;
					$page_data['check_admission_payment'] = $check_admission_payment;
				} elseif ($check_admission_payment == true) {
					$page_data['page_name'] = 'pre_dashboard';
					$amount = $this->payment_model->getPreWeedingAmount()->amount;
					$check_pre_payment = $this->payment_model->checkPrePayment($student['id']);
					$page_data['check_pre_payment'] = $check_pre_payment;
					$page_data['check_admission_payment'] = $check_admission_payment;
				}
			/* } elseif ($student['role'] == 'student' && $student['class_id'] == '1' && $student['course_id'] != '17') {
				$check_admission_payment = $this->payment_model->checkAdmissionPayment($student['id']);

				if ($check_admission_payment != true) {
					$page_data['page_name'] = 'admission_dashboard';
					$amount = $this->payment_model->getAdmissionAmount()->amount;
					$page_data['check_admission_payment'] = $check_admission_payment;
				} elseif ($check_admission_payment == true) {
					$page_data['page_name'] = 'student_dashboard';
					$check_payment = $this->payment_model->checkSemesterPayment($student['id']);
					$amount = $this->payment_model->getSemesterAmount($student['course_id'], $student['student_type'], $student['class_id'])->amount;
					$page_data['check_semester_payment'] = $check_payment;
					$page_data['check_admission_payment'] = $check_admission_payment;
				}
			} elseif ($student['role'] == 'student' && $student['course_id'] == '18') {
				$check_admission_payment = $this->payment_model->checkAdmissionPayment($student['id']);

				if ($check_admission_payment != true) {
					$page_data['page_name'] = 'admission_dashboard';
					$amount = $this->payment_model->getAdmissionAmount()->amount;
					$page_data['check_admission_payment'] = $check_admission_payment;
				} elseif ($check_admission_payment == true) {
					$page_data['page_name'] = 'student_dashboard';
					$check_payment = $this->payment_model->checkSemesterPayment($student['id']);
					$amount = $this->payment_model->getSemesterAmount($student['course_id'], $student['student_type'], $student['class_id'])->amount;
					$page_data['check_semester_payment'] = $check_payment;
					$page_data['check_admission_payment'] = $check_admission_payment;
				}
			} elseif ($student['role'] == 'student' && $student['course_id'] == '20') {
				$check_admission_payment = $this->payment_model->checkAdmissionPayment($student['id']);

				if ($check_admission_payment != true) {
					$page_data['page_name'] = 'admission_dashboard';
					$amount = $this->payment_model->getAdmissionAmount()->amount;
					$page_data['check_admission_payment'] = $check_admission_payment;
				} elseif ($check_admission_payment == true) {
					$page_data['page_name'] = 'student_dashboard';
					$check_payment = $this->payment_model->checkSemesterPayment($student['id']);
					$amount = $this->payment_model->getSemesterAmount($student['course_id'], $student['student_type'], $student['class_id'])->amount;
					$page_data['check_semester_payment'] = $check_payment;
					$page_data['check_admission_payment'] = $check_admission_payment;
				}
			}elseif($student['course_id'] == '17'){
				$page_data['page_name'] = 'student_dashboard';
				$check_admission_payment = $this->payment_model->checkAdmissionPayment($student['id']);
				$page_data['check_admission_payment'] == true;

				$check_payment = $this->payment_model->checkSemesterPayment($student['id']);
				$page_data['check_semester_payment'] = $check_payment;
				$amount = $this->payment_model->getSemesterAmount($student['course_id'], $student['student_type'], $student['class_id'])->amount;

			} elseif ($student['role'] == 'student' && $student['class_id'] >= '2') {
				$page_data['page_name'] = 'student_dashboard';

				$check_previous_payment = $this->payment_model->checkPreviousSemesterPayment($student['id']);
				if ($check_previous_payment != true) {
					$amount = $this->payment_model->getPreviousSemesterAmount($student['course_id'], $student['student_type'], $student['class_id'])->amount;
					$page_data['check_previous_semester_payment'] = $check_previous_payment;
					$page_data['check_semester_payment'] = $check_previous_payment;
				} else {
					$check_payment = $this->payment_model->checkSemesterPayment($student['id']);
					$amount = $this->payment_model->getSemesterAmount($student['course_id'], $student['student_type'], $student['class_id'])->amount;
					$page_data['check_previous_semester_payment'] = $check_previous_payment;
					$page_data['check_semester_payment'] = $check_payment;
				}
			 */
			} else {
				$page_data['page_name'] = 'student_dashboard';
				$check_admission_payment = $this->payment_model->checkAdmissionPayment($student['id']);
				$page_data['check_admission_payment'] = $check_admission_payment;

				$check_payment = $this->payment_model->checkSemesterPayment($student['id']);
				$page_data['check_semester_payment'] = $check_payment;
				$amount = $this->payment_model->getSemesterAmount($student['course_id'], $student['student_type'], $student['class_id'])->amount;
			}
			$page_data['amount'] = $amount;
			$page_data['student'] = $student;
			$this->load->view('student/index.php', $page_data);
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Update your profile" data-type="warning"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">Update your profile</div>');

			redirect('student/profile');
		}
		//echo 'This is student Dashboard';
	}
	function print_form()
	{
		$id = $this->input->post('id');
		/* $sess_id = $this->input->post('sess_id');
		$sm_id = $this->input->post('sm_id');
		$course_id = $this->input->post('cours_id'); */
		$screener = $this->screening_model->get($id);
		$data['sch_setting'] = $this->setting_model->get();
		$data['certificate'] = $this->certificate_model->getcertificatebyid(3);
		$data['screener'] = $screener;
		$form = $this->load->view('student/admission', $data, true);
		echo $form;
	}
	function admission_pdf()
	{
		$id = $this->session->userdata('user_id');

		$student = $this->student_model->get($id);

		$this->data['student'] = $student;
		$this->form_PDF('admissionreport.css', $this->data, 'student/admission');
	}
	function profile()
	{
		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['page_name'] = 'profile';
		$id = $this->session->userdata('user_id');
		$page_data['page_title'] = get_phrase('student_profile');
		$student = $this->student_model->get($id);
		$page_data['student'] = $student;
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;

		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$this->load->view('student/index.php', $page_data);
	}

	function update()
	{
		$response = $this->student_model->student_profile_update();
		echo json_encode($response);
	}
	function modalchangepass()
	{
		$data['title'] = 'Change Password';
		$student_id = $this->session->userdata('user_id');
		$student = $this->student_model->get($student_id);
		$data['student'] = $student;
		$student_data = array(
			'id' => $student_id,
			'open_p' => $this->input->post('new_pass')
		);
		$this->student_model->add($student_data);
		$newdata = array(
			'user_id' => $student_id,
			'password' => sha1($this->input->post('new_pass'))
		);
		$query2 = $this->user_model->updateStudent($newdata);
		if ($query2) {

			redirect('student/dashboard');
		} else {

			redirect('student/dashboard');
		}
	}

	public function ajax_upload()
	{

		if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

			$id = $this->session->userdata('user_id');

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
				$config['quality'] = '80%';
				$config['width'] = 150;
				$config['height'] = 200;
				$config['new_image'] = "./uploads/student_image/" . $data["file_name"];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$image_data = array(
					'id' => $id,
					'image'          => 'uploads/student_image/' . $data["file_name"]
				);
				$this->student_model->add($image_data);
			}
		}

		redirect('student/dashboard');
	}


	function getByLocal()
	{
		$state_id = $this->input->get('state_id');
		$data = $this->crud_model->getStateByLocal($state_id);
		echo json_encode($data);
	}

	function pre_payment()
	{
		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$id = $this->session->userdata('user_id');
		$check_payment = $this->payment_model->checkPrePayment($id);
		$check_admission_payment = $this->payment_model->checkAdmissionPayment($id);
		if ($check_payment == true) {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="You have already paid for Pre Weeding Registration fee" data-type="warning"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">You have already paid for Pre Weeding Registration fee</div>');

			redirect(site_url('student/dashboard'));
		}
		if ($check_admission_payment == true) {
			$page_data['page_name'] = 'pre_payment';
			$page_data['page_title'] = get_phrase('payment');

			$student = $this->student_model->get($id);
			$page_data['student'] = $student;
			$amount = $this->payment_model->getPreWeedingAmount();
			$page_data['amount'] = $amount->amount;
			$this->load->view('student/index.php', $page_data);
		} else {
			redirect(site_url('student/admission_payment'));
		}
	}

	function post_payment()
	{
		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$id = $this->session->userdata('user_id');
		$check_payment = $this->payment_model->checkPostPayment($id);

		if ($check_payment == true) {
			//$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="You have already paid for Pre Weeding Registration fee" data-type="warning"></div>');
			//$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">You have already paid for Pre Weeding Registration fee</div>');
			redirect(site_url('student/payment'));
		}
		$page_data['page_name'] = 'post_payment';
		$page_data['page_title'] = get_phrase('payment');
		$student = $this->student_model->get($id);
		$page_data['student'] = $student;
		$amount = $this->payment_model->getPostWeedingAmount($student['course_id']);
		$page_data['amount'] = $amount->amount;
		$this->load->view('student/index.php', $page_data);
	}
	function admission_payment()
	{
		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$id = $this->session->userdata('user_id');
		$check_payment = $this->payment_model->checkAdmissionPayment($id);

		if ($check_payment == true) {
			//$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="You have already paid for Pre Weeding Registration fee" data-type="warning"></div>');
			//$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">You have already paid for Pre Weeding Registration fee</div>');
			redirect(site_url('student/payment'));
		}
		$page_data['page_name'] = 'admission_payment';
		$page_data['page_title'] = get_phrase('payment');
		$student = $this->student_model->get($id);
		$page_data['student'] = $student;
		$amount = $this->payment_model->getAdmissionAmount();
		$page_data['amount'] = $amount->amount;
		$this->load->view('student/index.php', $page_data);
	}
	function payment()
	{
		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$id = $this->session->userdata('user_id');
		$check_payment = $this->payment_model->checkSemesterPayment($id);
		//$check_previous_payment = $this->payment_model->checkPreviousSemesterPayment($id);
		$check_admission_payment = $this->payment_model->checkAdmissionPayment($id);
		$student = $this->student_model->get($id);
		$page_data['student'] = $student;
		if ($this->paymentSwitch->is_active != 0) {
			if ($check_payment == true) {
				$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="You have already paid for this semester" data-type="warning"></div>');
				$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">You have already paid for this semester</div>');

				redirect(site_url('student/dashboard'));
			}
			if ($check_admission_payment == true) {
			//	if ($student['class_id'] >= 2) {
			//		if ($check_previous_payment == true) {
			//			$amount = $this->payment_model->getSemesterAmount($student['course_id'], $student['student_type'], $student['class_id']);
			//		} else {
			//			$amount = $this->payment_model->getPreviousSemesterAmount($student['course_id'], $student['student_type'], $student['class_id']);
			//		}
			//	} else {
					$amount = $this->payment_model->getSemesterAmount($student['course_id'], $student['student_type'], $student['class_id']);
			//	}

				$page_data['page_name'] = 'payment';
				$page_data['page_title'] = get_phrase('payment');


				$page_data['amount'] = $amount->amount;
				$this->load->view('student/index.php', $page_data);
			} else {
				redirect(site_url('student/admission_payment'));
			}
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Registration Closed" data-type="error"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Registration Closed </div>');
			//var_dump($json_response);
			redirect('student/dashboard/');
		}
	}
	public function init_pre_pay()
	{
		//$this->load->library('curl');
		$id = $this->session->userdata('user_id');
		$student_id = $id;
		$amount = $this->input->post('amount') - 2000;
		$method = $this->input->post('method');
		$ref = $this->ref;
		$student = $this->student_model->get($id);
		$remita_service_id = '8782852323';
		$url = 'https://bauchi.revenue.ng/api/v1/cig/coe_azare/119?token=02NDY77EHFHRH2HHD8FBNBDGFSWCVBDJFBHF21213HFHRH2HHD8FBNBDGFSWCVBDJ&userId=470';
		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
   				"first_name": "' . $student['firstname'] . '",
   				"last_name": "' . $student['lastname'] . '",
   				"email": "' . $student['email'] . '",
   				"phone": "' . $student['phone'] . '",
   				"matric_no": "' . $student['form_no'] . '",
   				"channel": "' . $method . '",
   				"callback_url": "' . base_url('student/payment/payment_response/' . $ref) . '",
   				"remita_service_id": "' . $remita_service_id . '",
   				"client_ref": "' . $ref . '",
   				"type_of_split": "dynamic",
   				"item_code_total": "100119-1510",
   				"services": [
        			{
        			    "item_code": "100119-1495",
        			    "amount": 0,
        			    "type": "taxable",
        			    "percentage_split": 1
        			},
       				{
       				    "item_code": "100119-1496",
       				    "amount": "' . $amount . '",
       				    "type": "non_taxable",
       				    "percentage_split": 0
       				},
        			{
        			    "item_code": "100119-1497",
        			    "amount": 1000,
        			    "type": "service_charge",
        			    "percentage_split": 0
        			}
    			]
			}',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json'
				),
			)
		);
		//curl_setopt($curl, CURLOPT_PORT, 8000);
		$response = curl_exec($curl);
		curl_close($curl);
		$resp = json_decode($response, true);
		if ($method == 'card') {
			$status = $resp['status'];
			$statusCode = $resp['statusCode'];
			$message = $resp['message'];
			$amount = $resp['data']['amount'];
			$invoice_no = $resp['data']['invoice_no'];
			$matric_no = $resp['data']['matric_no'];
			$client_ref = $resp['data']['client_ref'];
			$rrr = $resp['data']['rrr'];
			$descr = 'Pre-Weeding Registration';
			$data['client_ref'] = $client_ref;
			$data['invoice_no'] = $invoice_no;
			$data['matric_no'] = $matric_no;
			$data['status'] = $status;
			$data['message'] = $message;
			$data['amount'] = $amount;
			$data['rrr'] = $rrr;
			$data['descr'] = 'Pre-Weeding Registration';
			$data['student'] = $student;
			if ($statusCode == '00') {
				$authorization_url = $resp['data']['authorization_url'];
				$data['authorization_url'] = $authorization_url;
				//$rrr = substr($authorization_url, 54);
				//$data['rrr'] = $rrr;
				$details = array(
					'student_id' => $student_id,
					'date' => date('d-m-Y'),
					//'class_id' => $student['class_id'],
					//'semester_id' => $this->current_semester,
					'session_id' => current_session(),
					//$this->current_session,
					'receipt' => $rrr,
					'method' => $method,
					'descr' => $descr,
					'type' => 'pre_weeding',
					'txn' => $invoice_no,
					'status' => 'pending'
				);
				$inserted_id = $this->payment_model->add_payment($details);

				$this->load->view('student/layout/header', $data);
				//$this->load->view('layout/nce/sidebar', $data);
				$this->load->view('student/checkout', $data);
				$this->load->view('student/layout/footer', $data);
				//echo "<pre>";
				//print_r($data);
				//echo "</pre>";
			} else {
				//var_dump($resp);
				//$this->warning();
				$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Error Generating RRR." data-type="warning"></div>');
				$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">' . $status . ', Generating Invoice Number. If the Error persist, Please contact the ICT Unit for support .</div>');
				redirect('student/pre_payment/');
			}
		} elseif ($method == 'bank') {

			$status = $resp['status'];
			$statusCode = $resp['statusCode'];
			$amount = $resp['data']['total'];
			$invoice_no = $resp['data']['invoice_number'];
			$rrr = $resp['data']['rrr'];
			//$message = $resp['message'];
			$client_ref = $resp['data']['client_ref'];
			$data['client_ref'] = $client_ref;
			$data['invoice_no'] = $invoice_no;
			//$data['matric_no'] = $matric_no;
			$descr = 'Pre-Weeding Registration';
			$data['status'] = $status;
			$data['rrr'] = $rrr;
			$data['amount'] = $amount;
			$data['descr'] = 'Pre-Weeding Registration';
			$data['student'] = $student;
			//$rrr = $resp['data']['rrr'];
			//$data['rrr'] = $rrr;
			if ($status == 'success') {
				$details = array(
					'student_id' => $student_id,
					'date' => date('d-m-Y'),
					//'semester_id' => $this->current_semester,
					'session_id' => current_session(),
					'receipt' => $rrr,
					'txn' => $invoice_no,
					'method' => $method,
					'descr' => $descr,
					'type' => 'pre_weeding',
					'status' => 'pending'
				);
				$inserted_id = $this->payment_model->add_payment($details);

				//$inserted_id = $this->studentPayment_model->amountDeposit($details);
				$this->load->view('student/layout/header', $data);
				$this->load->view('student/checkout_bank', $data);
				$this->load->view('student/layout/footer', $data);
				//$this->load->view('layout/nce/header', $data);
				//$this->load->view('layout/nce/sidebar', $data);
				//$this->load->view('nce/checkout_bank', $data);
				//$this->load->view('layout/nce/footer', $data);
				/* echo "<pre>";
				print_r($data);
				echo "</pre>"; */
			} else {

				//$this->warning();
				$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Error Generating RRR." data-type="warning"></div>');
				$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">' . $status . ', Generating Invoice Number. If the Error persist, Please contact the ICT Unit for support .</div>');
				redirect('student/pre_payment/');
			}
		}
	}

	function init_pre_pay_direct()
	{
		$id = $this->session->userdata('user_id');
		$student_id = $id;
		$student = $this->student_model->get($student_id);
		$amount = $this->payment_model->getPreWeedingAmount();

		//$late_payment = $this->student_model->CheckLatePayment($student['id'], $student['class_id']);
		//if ($this->PaymentSwitch->is_active != 0) {
		$data['title'] = "Make Payment with Remita";
		$GATEWAYRRRPAYMENTURL = "https://login.remita.net/remita/ecomm/finalize.reg";
		$GATEWAYURL = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
		//$GATEWAYRRRPAYMENTURL = "https://remitademo.net/remita/ecomm/finalize.reg";
		//$GATEWAYURL = "https://remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
		$totalAmount = $amount->amount;
		$splitAmount = $totalAmount - 2000;
		$merchantId = "5751670525"; //"5222939053";
		$serviceTypeID = "5341382715"; //$this->service_id();
		//$merchantId = "2547916"; //  Demo MerchantId
		//$serviceTypeID = '4430731'; // Demo Service Type ID
		$timesammp = DATE("dmyHis");
		$api =  "513780"; //"182507";
		//$api = "1946"; // Demo Api 
		$ref = $this->ref;
		$orderID = $timesammp;
		$payerName = $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'];
		$payerEmail = $student['email'];
		$payerPhone = $student['phone'];
		$description = 'Weeding Registration';
		$responseurl = base_url('student/remita_response_direct/' . $ref);
		$hash_string = $merchantId . $serviceTypeID . $orderID . $totalAmount . $api;
		$hash = hash('sha512', $hash_string);
		$itemtimestamp = $timesammp;
		//The JSON data.
		//MINE 2379587078
		//ZENITH 057

		//NINGI 1012130796
		//033
		$content = '{"serviceTypeId":"' . $serviceTypeID . '"' . "," . '
                "amount":"' . $totalAmount . '"' . "," . '
                "hash":"' . $hash . '"' . "," . '
                "orderId":"' . $orderID . '"' . "," . '
                "payerName":"' . $payerName . '"' . "," . '
                "payerEmail":"' . $payerEmail . '"' . "," . '
                "payerPhone":"' . $payerPhone . '"' . "," . '
					"lineItems":[
       							{
       							  "lineItemsId":"itemid1",
       							  "beneficiaryName":"College of Health Technology. Ningi",
       							  "beneficiaryAccount":"2379587078", 
       							  "bankCode":"057",
       							  "beneficiaryAmount":"' . $splitAmount . '",
       							  "deductFeeFrom":"1"
								},
       							{
       							  "lineItemsId":"itemid1",
       							  "beneficiaryName":"Diidol Consults",
       							  "beneficiaryAccount":"0015935069",
       							  "bankCode":"215",
       							  "beneficiaryAmount":"2000",
       							  "deductFeeFrom":"0"
								}
								
								
	   						],



                "customFields":[
					{
                       "name":"Description",
                       "value":"' . $description . '",
                       "type":"ALL"
                    },
                    {
                       "name":"Reg Number",
                       "value":"' . $student['reg_no'] . '",
                       "type":"ALL"
					},
					{
                       "name":"Course",
                       "value":"' . $student['course'] . '",
                       "type":"ALL"
                    },
					
                    {
                       "name":"Invoice Number",
                       "value":"' . $this->ref . '",
                       "type":"ALL"
                    }]
                
                
                }';
		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $GATEWAYURL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $content,
				CURLOPT_HTTPHEADER => array(
					"Authorization: remitaConsumerKey=$merchantId,remitaConsumerToken=$hash",
					"Content-Type: application/json",
					"cache-control: no-cache"
				),
			)
		);

		$json_response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		$jsonData = substr($json_response, 7, -1);
		$response = json_decode($jsonData, true);
		//var_dump($response);
		$statuscode = $response['statuscode'];
		$statusMsg = $response['status'];
		if ($statuscode == '025') {
			$rrr = trim($response['RRR']);
			$new_hash_string = $merchantId . $rrr . $api;
			$new_hash = hash('sha512', $new_hash_string);
			$data = array(

				'student_id' => $student_id,
				'date' => date('d-m-Y'),
				'class_id' => $student['class_id'],
				//'semester_id' => $this->current_semester,
				'session_id' => current_session(),
				'receipt' => $rrr,
				'descr' => $description,
				'type' => 'pre_weeding',
				'txn' => $ref,
				'status' => 'pending'
			);
			$inserted_id = $this->payment_model->add_payment($data);
			$data['rrr'] = $rrr;
			$data['ref'] = $ref;
			$data['amount'] = $totalAmount;
			$data['statuscode'] = $statuscode;
			$data['statusMsg'] = $statusMsg;
			$data['merchantId'] = $merchantId;
			$data['responseurl'] = $responseurl;
			$data['hash'] = $new_hash;
			$data['descr'] = $description;
			$data['GATEWAYRRRPAYMENTURL'] = $GATEWAYRRRPAYMENTURL;
			$data['student'] = $student;

			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="' . $statusMsg . '" data-type="success"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-capitalize">' . $statusMsg . '.</div>');

			$this->load->view('student/layout/header', $data);
			$this->load->view('student/checkout_direct', $data);
			$this->load->view('student/layout/footer', $data);
		} else {
			//echo "Error Generating RRR - " . $statusMsg . " (Make Sure you input a valid E-mail and valid Phone Number on your profile )";
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="' . $statusMsg . '" data-type="error"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Error Generating RRR </div>');

			redirect('student/pre_payment');
		}
		//}
	}
	function init_post_pay_direct()
	{
		$id = $this->session->userdata('user_id');
		$student_id = $id;
		$student = $this->student_model->get($student_id);
		$amount = $this->payment_model->getPostWeedingAmount($student['course_id']);

		//$late_payment = $this->student_model->CheckLatePayment($student['id'], $student['class_id']);
		//if ($this->PaymentSwitch->is_active != 0) {
		$data['title'] = "Make Payment with Remita";
		$GATEWAYRRRPAYMENTURL = "https://login.remita.net/remita/ecomm/finalize.reg";
		$GATEWAYURL = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
		//$GATEWAYRRRPAYMENTURL = "https://remitademo.net/remita/ecomm/finalize.reg";
		//$GATEWAYURL = "https://remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
		$totalAmount = $amount->amount;
		$merchantId = "5751670525"; //"5222939053";
		$serviceTypeID = "5341382715"; //$this->service_id();
		//$merchantId = "2547916"; //  Demo MerchantId
		//$serviceTypeID = '4430731'; // Demo Service Type ID
		$timesammp = DATE("dmyHis");
		$api =  "513780"; //"182507";
		//$api = "1946"; // Demo Api 
		$ref = $this->ref;
		$orderID = $timesammp;
		$payerName = $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'];
		$payerEmail = $student['email'];
		$payerPhone = $student['phone'];
		$description = 'Post-Weeding Registration';
		$responseurl = base_url('student/remita_response_direct/' . $ref);
		$hash_string = $merchantId . $serviceTypeID . $orderID . $totalAmount . $api;
		$hash = hash('sha512', $hash_string);
		$itemtimestamp = $timesammp;
		//The JSON data.
		$content = '{"serviceTypeId":"' . $serviceTypeID . '"' . "," . '
                "amount":"' . $totalAmount . '"' . "," . '
                "hash":"' . $hash . '"' . "," . '
                "orderId":"' . $orderID . '"' . "," . '
                "payerName":"' . $payerName . '"' . "," . '
                "payerEmail":"' . $payerEmail . '"' . "," . '
                "payerPhone":"' . $payerPhone . '"' . "," . '
                "customFields":[
					{
                       "name":"Description",
                       "value":"' . $description . '",
                       "type":"ALL"
                    },
                    {
                       "name":"Reg Number",
                       "value":"' . $student['reg_no'] . '",
                       "type":"ALL"
					},
					{
                       "name":"Course",
                       "value":"' . $student['course'] . '",
                       "type":"ALL"
                    },
					
                    {
                       "name":"Invoice Number",
                       "value":"' . $this->ref . '",
                       "type":"ALL"
                    }]
                
                
                }';
		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $GATEWAYURL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $content,
				CURLOPT_HTTPHEADER => array(
					"Authorization: remitaConsumerKey=$merchantId,remitaConsumerToken=$hash",
					"Content-Type: application/json",
					"cache-control: no-cache"
				),
			)
		);

		$json_response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		$jsonData = substr($json_response, 7, -1);
		$response = json_decode($jsonData, true);
		//var_dump($response);
		$statuscode = $response['statuscode'];
		$statusMsg = $response['status'];
		if ($statuscode == '025') {
			$rrr = trim($response['RRR']);
			$new_hash_string = $merchantId . $rrr . $api;
			$new_hash = hash('sha512', $new_hash_string);
			$data = array(

				'student_id' => $student_id,
				'date' => date('d-m-Y'),
				'class_id' => $student['class_id'],
				//'semester_id' => $this->current_semester,
				'session_id' => current_session(),
				'receipt' => $rrr,
				'descr' => $description,
				'type' => 'post_weeding',
				'txn' => $ref,
				'status' => 'pending'
			);
			$inserted_id = $this->payment_model->add_payment($data);
			$data['rrr'] = $rrr;
			$data['ref'] = $ref;
			$data['amount'] = $totalAmount;
			$data['statuscode'] = $statuscode;
			$data['statusMsg'] = $statusMsg;
			$data['merchantId'] = $merchantId;
			$data['responseurl'] = $responseurl;
			$data['hash'] = $new_hash;
			$data['descr'] = $description;
			$data['GATEWAYRRRPAYMENTURL'] = $GATEWAYRRRPAYMENTURL;
			$data['student'] = $student;

			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="' . $statusMsg . '" data-type="success"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-capitalize">' . $statusMsg . '.</div>');

			$this->load->view('student/layout/header', $data);
			$this->load->view('student/checkout_direct', $data);
			$this->load->view('student/layout/footer', $data);
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="' . $statusMsg . '" data-type="error"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Error Generating RRR </div>');

			redirect('student/post_payment');

			//echo "Error Generating RRR - " . $statusMsg . " (Make Sure you input a valid E-mail and valid Phone Number on your profile )";
		}
		//}
	}
	function init_admission_pay_direct()
	{
		$id = $this->session->userdata('user_id');
		$student_id = $id;
		$student = $this->student_model->get($student_id);
		$amount = $this->payment_model->getAdmissionAmount();

		if ($this->paymentSwitch->is_active != 0) {
			$data['title'] = "Make Payment with Remita";
			$GATEWAYRRRPAYMENTURL = "https://login.remita.net/remita/ecomm/finalize.reg";
			$GATEWAYURL = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
			//$GATEWAYRRRPAYMENTURL = "https://remitademo.net/remita/ecomm/finalize.reg";
			//$GATEWAYURL = "https://remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
			$totalAmount = $amount->amount;
			$merchantId = "5751670525"; //"5222939053";
			$serviceTypeID = "5341382715"; //$this->service_id();
			//$merchantId = "2547916"; //  Demo MerchantId
			//$serviceTypeID = '4430731'; // Demo Service Type ID
			$timesammp = DATE("dmyHis");
			$api =  "513780"; //"182507";
			//$api = "1946"; // Demo Api 
			$ref = $this->ref;
			$orderID = $timesammp;
			$payerName = $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'];
			$payerEmail = $student['email'];
			$payerPhone = $student['phone'];
			$description = 'Admission Access Fee';
			$responseurl = base_url('student/remita_response_direct/' . $ref);
			$hash_string = $merchantId . $serviceTypeID . $orderID . $totalAmount . $api;
			$hash = hash('sha512', $hash_string);
			$itemtimestamp = $timesammp;
			//The JSON data.
			$content = '{"serviceTypeId":"' . $serviceTypeID . '"' . "," . '
                "amount":"' . $totalAmount . '"' . "," . '
                "hash":"' . $hash . '"' . "," . '
                "orderId":"' . $orderID . '"' . "," . '
                "payerName":"' . $payerName . '"' . "," . '
                "payerEmail":"' . $payerEmail . '"' . "," . '
                "payerPhone":"' . $payerPhone . '"' . "," . '
                "customFields":[
					{
                       "name":"Description",
                       "value":"' . $description . '",
                       "type":"ALL"
                    },
                    {
                       "name":"Reg Number",
                       "value":"' . $student['reg_no'] . '",
                       "type":"ALL"
					},
					{
                       "name":"Course",
                       "value":"' . $student['course'] . '",
                       "type":"ALL"
                    },
					
                    {
                       "name":"Invoice Number",
                       "value":"' . $this->ref . '",
                       "type":"ALL"
                    }]
                
                
                }';
			$curl = curl_init();
			curl_setopt_array(
				$curl,
				array(
					CURLOPT_URL => $GATEWAYURL,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $content,
					CURLOPT_HTTPHEADER => array(
						"Authorization: remitaConsumerKey=$merchantId,remitaConsumerToken=$hash",
						"Content-Type: application/json",
						"cache-control: no-cache"
					),
				)
			);

			$json_response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			$jsonData = substr($json_response, 7, -1);
			$response = json_decode($jsonData, true);
			//var_dump($response);
			$statuscode = $response['statuscode'];
			$statusMsg = $response['status'];
			if ($statuscode == '025') {
				$rrr = trim($response['RRR']);
				$new_hash_string = $merchantId . $rrr . $api;
				$new_hash = hash('sha512', $new_hash_string);
				$data = array(

					'student_id' => $student_id,
					'date' => date('d-m-Y'),
					'class_id' => $student['class_id'],
					//'semester_id' => $this->current_semester,
					'session_id' => current_session(),
					'receipt' => $rrr,
					'descr' => $description,
					'type' => 'admission_fee',
					'txn' => $ref,
					'status' => 'pending'
				);
				$inserted_id = $this->payment_model->add_payment($data);
				$data['rrr'] = $rrr;
				$data['ref'] = $ref;
				$data['amount'] = $totalAmount;
				$data['statuscode'] = $statuscode;
				$data['statusMsg'] = $statusMsg;
				$data['merchantId'] = $merchantId;
				$data['responseurl'] = $responseurl;
				$data['hash'] = $new_hash;
				$data['descr'] = $description;
				$data['GATEWAYRRRPAYMENTURL'] = $GATEWAYRRRPAYMENTURL;
				$data['student'] = $student;

				$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="' . $statusMsg . '" data-type="success"></div>');
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-capitalize">' . $statusMsg . '.</div>');

				$this->load->view('student/layout/header', $data);
				$this->load->view('student/checkout_direct', $data);
				$this->load->view('student/layout/footer', $data);
			} else {
				$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="' . $statusMsg . '" data-type="error"></div>');
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Error Generating RRR </div>');
				//var_dump($json_response);
				redirect('student/admission_payment');

				//echo "Error Generating RRR - " . $statusMsg . " (Make Sure you input a valid E-mail and valid Phone Number on your profile )";
			}
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Registration Closed" data-type="error"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Registration Closed </div>');
			//var_dump($json_response);
			redirect('student/dashboard/');
		}
	}
	function taxable()
	{
		$student_id = $this->session->userdata('user_id');
		$student = $this->student_model->get($student_id);
		$payment =
			$this->payment_model->getTotalItemTaxable($student['course_id'], $student['student_type'], $student['class_id']);

		$amount = $payment->amount;
		return $amount;
	}
	function non_taxable()
	{
		$student_id = $this->session->userdata('user_id');
		$student = $this->student_model->get($student_id);
		$payment =
			$this->payment_model->getTotalItemNonTaxable($student['course_id'], $student['student_type'], $student['class_id']);

		$amount = $payment->amount;
		return $amount;
	}

	function totalAmount()
	{
		$student_id = $this->session->userdata('user_id');
		$student = $this->student_model->get($student_id);
		$payment =
			$this->payment_model->getItemSum($student['course_id'], $student['student_type'], $student['class_id']);

		$amount = $payment->amount;
		return $amount;
	}
	function init_pay()
	{
		//$id = $this->session->userdata('user_id');
		if ($this->paymentMethod->is_active != 1) {

			//$this->init_pay_moneta();
		} else {
			$id = $this->session->userdata('user_id');
			$student_id = $id;
			$student = $this->student_model->get($student_id);
			//$check_previous_payment = $this->payment_model->checkPreviousSemesterPayment($id);
		//	if ($student['class_id'] >= 2) {
		//		if ($check_previous_payment == true) {
					$this->init_pay_direct();
		//		} else {
		//			$this->init_pay_previous_direct();
		//		}
		//	} else {
		//		$this->init_pay_direct();
		//	}
		}
	}
	function init_pay_moneta()
	{
		$id = $this->session->userdata('user_id');
		$student_id = $id;
		$method = "card";
		//$this->input->post('method');
		if ($method != '') {
			$amount = $this->input->post('amount');
			$taxable = $this->taxable() - 2000;
			$non_taxable = $this->non_taxable();
			$ref = $this->ref;
			$student = $this->student_model->get($id);
			$remita_service_id = '5341382715';
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://bauchi.revenue.ng/api/v1/flexi/71?token=469UI345GNTF95DFJC82BS0995BNF898FHFBHF21213HFHRH2HHD8FBNBDGFSWCVBDJ&userId=54',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
   				"first_name": "' . $student['firstname'] . '",
   				"last_name": "' . $student['lastname'] . '",
   				"email": "' . $student['email'] . '",
   				"phone": "' . $student['phone'] . '",
   				"matric_no": "' . $student['reg_no'] . '",
    			"address": "Ningi Bauchi",
    			"client_ref": "' . $ref . '",
    			"semester": 1,
    			"study_type": "National Diploma", 
   				"channel": "' . $method . '",
    			"callback_url": "' . base_url('student/pay_response/' . $ref) . '",
    			"remita_service_id": "' . $remita_service_id . '",
    			"item_code_total": "10071-1223",
    			"services": [
        					{
        					    "item_code": "10071-1226",
        					    "amount": "' . $taxable . '",
        					    "type": "taxable"
        					},
        					{
        					    "item_code": "10071-1224",
        					     "amount": "' . $non_taxable . '",
        					    "type": "non_taxable"
        					},
        					{
        					    "item_code": "10071-1225",
        					    "amount": "2000",
        					    "type": "service_charge"
        					}
    					]
				}',
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json'
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$resp = json_decode($response, true);
			if ($method == 'card') {
				$status = $resp['status'];
				$statusCode = $resp['statusCode'];
				$message = $resp['message'];
				$amount = $resp['data']['amount'];
				$invoice_no = $resp['data']['invoice_no'];
				$matric_no = $resp['data']['matric_no'];
				$client_ref = $resp['data']['client_ref'];
				$rrr = $resp['data']['rrr'];
				$descr = 'Semester Registration';
				$data['client_ref'] = $client_ref;
				$data['invoice_no'] = $invoice_no;
				$data['matric_no'] = $matric_no;
				$data['status'] = $status;
				$data['message'] = $message;
				$data['amount'] = $amount;
				$data['rrr'] = $rrr;
				$data['descr'] = 'Semester Registration';
				$data['student'] = $student;
				if ($statusCode == '00') {
					$authorization_url = $resp['data']['authorization_url'];
					$data['authorization_url'] = $authorization_url;
					//$rrr = substr($authorization_url, 54);
					//$data['rrr'] = $rrr;
					$details = array(
						'student_id' => $student_id,
						'date' => date('d-m-Y'),
						'class_id' => $student['class_id'],
						'semester_id' => $this->current_semester,
						'session_id' => current_session(),
						//$this->current_session,
						'receipt' => $rrr,
						'method' => $method,
						'descr' => $descr,
						'type' => 'semester',
						'txn' => $invoice_no,
						'status' => 'pending'
					);
					$inserted_id = $this->payment_model->add_payment($details);

					$this->load->view('student/layout/header', $data);
					//$this->load->view('layout/nce/sidebar', $data);
					$this->load->view('student/checkout', $data);
					$this->load->view('student/layout/footer', $data);
				} else {
					//var_dump($resp);
					//$this->warning();
					$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Error Generating RRR." data-type="warning"></div>');
					$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">' . $status . ', Generating Invoice Number. If the Error persist, Please contact the ICT Unit for support .</div>');
					redirect('student/payment/');
				}
				/* echo "<pre>";
				print_r($resp);
				echo "</pre>"; */
			} elseif ($method == 'bank') {

				$status = $resp['status'];
				$statusCode = $resp['statusCode'];
				$amount = $resp['data']['total'];
				$invoice_no = $resp['data']['invoice_number'];
				$rrr = $resp['data']['rrr'];
				//$message = $resp['message'];
				$client_ref = $resp['data']['client_ref'];
				$data['client_ref'] = $client_ref;
				$data['invoice_no'] = $invoice_no;
				//$data['matric_no'] = $matric_no;
				$descr = 'Semester Registrationn';
				$data['status'] = $status;
				$data['rrr'] = $rrr;
				$data['amount'] = $amount;
				$data['descr'] = 'Semester Registration';
				$data['student'] = $student;
				//$rrr = $resp['data']['rrr'];
				//$data['rrr'] = $rrr;
				if ($status == 'success') {
					$details = array(
						'student_id' => $student_id,
						'date' => date('d-m-Y'),
						'semester_id' => $this->current_semester,
						'session_id' => $this->current_session,
						'class_id' => $student['class_id'],
						'receipt' => $rrr,
						'txn' => $invoice_no,
						'method' => $method,
						'descr' => $descr,
						'type' => 'semester',
						'status' => 'pending'
					);
					$inserted_id = $this->payment_model->add_payment($details);
					$this->load->view('student/layout/header', $data);
					$this->load->view('student/checkout_bank', $data);
					$this->load->view('student/layout/footer', $data);
				} else {

					//$this->warning();
					$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Error Generating RRR." data-type="warning"></div>');
					$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">' . $status . ', Generating Invoice Number. If the Error persist, Please contact the ICT Unit for support .</div>');
					redirect('student/payment/');
				}
				/* echo "<pre>";
				print_r($resp);
				echo "</pre>"; */
			}
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Payment method most be selected" data-type="warning"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">Payment method most be selected</div>');
			redirect('student/payment/');
		}
	}

	function init_pay_direct()
	{
		$id = $this->session->userdata('user_id');
		$student_id = $id;
		$student = $this->student_model->get($student_id);
		$amount = $this->payment_model->getSemesterAmount($student['course_id'], $student['student_type'], $student['class_id']);

		if ($this->paymentSwitch->is_active != 0) {
			$data['title'] = "Make Payment with Remita";
			$GATEWAYRRRPAYMENTURL = "https://login.remita.net/remita/ecomm/finalize.reg";
			$GATEWAYURL = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
			//$GATEWAYRRRPAYMENTURL = "https://remitademo.net/remita/ecomm/finalize.reg";
			//$GATEWAYURL = "https://remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
			$totalAmount = $amount->amount;
			$splitAmount = $totalAmount - 2000;
			$merchantId = "5751670525"; //"5222939053";
			$serviceTypeID = "5341382715"; //$this->service_id();
			//$merchantId = "2547916"; //  Demo MerchantId
			//$serviceTypeID = '4430731'; // Demo Service Type ID
			$timesammp = DATE("dmyHis");
			$api =  "513780"; //"182507";
			//$api = "1946"; // Demo Api 
			$ref = $this->ref;
			$orderID = $timesammp;
			$payerName = $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'];
			$payerEmail = $student['email'];
			$payerPhone = $student['phone'];
			$description = 'Semester Registration';
			$responseurl = base_url('student/remita_response_direct/' . $ref);
			$hash_string = $merchantId . $serviceTypeID . $orderID . $totalAmount . $api;
			$hash = hash('sha512', $hash_string);
			$itemtimestamp = $timesammp;
			//The JSON data.
			//MINE 2379587078
			//ZENITH 057

			//NINGI 1012130796
			//033
			$content = '{"serviceTypeId":"' . $serviceTypeID . '"' . "," . '
                "amount":"' . $totalAmount . '"' . "," . '
                "hash":"' . $hash . '"' . "," . '
                "orderId":"' . $orderID . '"' . "," . '
                "payerName":"' . $payerName . '"' . "," . '
                "payerEmail":"' . $payerEmail . '"' . "," . '
                "payerPhone":"' . $payerPhone . '"' . "," . '
					"lineItems":[
       							{
       							  "lineItemsId":"itemid1",
       							  "beneficiaryName":"College of Health Technology. Ningi",
       							  "beneficiaryAccount":"1012130796", 
       							  "bankCode":"033",
       							  "beneficiaryAmount":"' . $splitAmount . '",
       							  "deductFeeFrom":"1"
								},
       							{
       							  "lineItemsId":"itemid1",
       							  "beneficiaryName":"Diidol Consults",
       							  "beneficiaryAccount":"0015935069",
       							  "bankCode":"215",
       							  "beneficiaryAmount":"2000",
       							  "deductFeeFrom":"0"
								}
								
								
	   						],



                "customFields":[
					{
                       "name":"Description",
                       "value":"' . $description . '",
                       "type":"ALL"
                    },
                    {
                       "name":"Reg Number",
                       "value":"' . $student['reg_no'] . '",
                       "type":"ALL"
					},
					{
                       "name":"Course",
                       "value":"' . $student['course'] . '",
                       "type":"ALL"
                    },
					
                    {
                       "name":"Invoice Number",
                       "value":"' . $this->ref . '",
                       "type":"ALL"
                    }]
                
                
                }';
			$curl = curl_init();
			curl_setopt_array(
				$curl,
				array(
					CURLOPT_URL => $GATEWAYURL,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $content,
					CURLOPT_HTTPHEADER => array(
						"Authorization: remitaConsumerKey=$merchantId,remitaConsumerToken=$hash",
						"Content-Type: application/json",
						"cache-control: no-cache"
					),
				)
			);

			$json_response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			$jsonData = substr($json_response, 7, -1);
			$response = json_decode($jsonData, true);
			//var_dump($response);
			$statuscode = $response['statuscode'];
			$statusMsg = $response['status'];
			if ($statuscode == '025') {
				$rrr = trim($response['RRR']);
				$new_hash_string = $merchantId . $rrr . $api;
				$new_hash = hash('sha512', $new_hash_string);
				$data = array(

					'student_id' => $student_id,
					'date' => date('d-m-Y'),
					'class_id' => $student['class_id'],
					'semester_id' => $this->current_semester,
					'session_id' => current_session(),
					'receipt' => $rrr,
					'descr' => $description,
					'type' => 'semester',
					'txn' => $ref,
					'status' => 'pending'
				);
				$inserted_id = $this->payment_model->add_payment($data);
				$data['rrr'] = $rrr;
				$data['ref'] = $ref;
				$data['amount'] = $totalAmount;
				$data['statuscode'] = $statuscode;
				$data['statusMsg'] = $statusMsg;
				$data['merchantId'] = $merchantId;
				$data['responseurl'] = $responseurl;
				$data['hash'] = $new_hash;
				$data['descr'] = $description;
				$data['GATEWAYRRRPAYMENTURL'] = $GATEWAYRRRPAYMENTURL;
				$data['student'] = $student;

				$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="' . $statusMsg . '" data-type="success"></div>');
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-capitalize">' . $statusMsg . '.</div>');

				$this->load->view('student/layout/header', $data);
				$this->load->view('student/checkout_direct', $data);
				$this->load->view('student/layout/footer', $data);
			} else {
				$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="' . $statusMsg . '" data-type="error"></div>');
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Error Generating RRR </div>');
				//var_dump($json_response);
				redirect('student/payment');

				//echo "Error Generating RRR - " . $statusMsg . " (Make Sure you input a valid E-mail and valid Phone Number on your profile )";
			}
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Registration Closed" data-type="error"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Registration Closed </div>');
			//var_dump($json_response);
			redirect('student/dashboard/');
		}
	}
	function init_pay_previous_direct()
	{
		$id = $this->session->userdata('user_id');
		$student_id = $id;
		$student = $this->student_model->get($student_id);
		$amount = $this->payment_model->getPreviousSemesterAmount($student['course_id'], $student['student_type'], $student['class_id']);

		if ($this->paymentSwitch->is_active != 0) {
			$data['title'] = "Make Payment with Remita";
			$GATEWAYRRRPAYMENTURL = "https://login.remita.net/remita/ecomm/finalize.reg";
			$GATEWAYURL = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
			//$GATEWAYRRRPAYMENTURL = "https://remitademo.net/remita/ecomm/finalize.reg";
			//$GATEWAYURL = "https://remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
			$totalAmount = $amount->amount;
			$splitAmount = $totalAmount - 2000;
			$merchantId = "5751670525"; //"5222939053";
			$serviceTypeID = "5341382715"; //$this->service_id();
			//$merchantId = "2547916"; //  Demo MerchantId
			//$serviceTypeID = '4430731'; // Demo Service Type ID
			$timesammp = DATE("dmyHis");
			$api =  "513780"; //"182507";
			//$api = "1946"; // Demo Api 
			$ref = $this->ref;
			$orderID = $timesammp;
			$payerName = $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'];
			$payerEmail = $student['email'];
			$payerPhone = $student['phone'];
			$description = 'Semester Registration';
			$responseurl = base_url('student/remita_response_direct/' . $ref);
			$hash_string = $merchantId . $serviceTypeID . $orderID . $totalAmount . $api;
			$hash = hash('sha512', $hash_string);
			$itemtimestamp = $timesammp;
			//The JSON data.
			//MINE 2379587078
			//ZENITH 057

			//NINGI 1012130796
			//033
			$content = '{"serviceTypeId":"' . $serviceTypeID . '"' . "," . '
                "amount":"' . $totalAmount . '"' . "," . '
                "hash":"' . $hash . '"' . "," . '
                "orderId":"' . $orderID . '"' . "," . '
                "payerName":"' . $payerName . '"' . "," . '
                "payerEmail":"' . $payerEmail . '"' . "," . '
                "payerPhone":"' . $payerPhone . '"' . "," . '
					"lineItems":[
       							{
       							  "lineItemsId":"itemid1",
       							  "beneficiaryName":"College of Health Technology. Ningi",
       							  "beneficiaryAccount":"1012130796", 
       							  "bankCode":"033",
       							  "beneficiaryAmount":"' . $splitAmount . '",
       							  "deductFeeFrom":"1"
								},
       							{
       							  "lineItemsId":"itemid1",
       							  "beneficiaryName":"Diidol Consults",
       							  "beneficiaryAccount":"0015935069",
       							  "bankCode":"215",
       							  "beneficiaryAmount":"2000",
       							  "deductFeeFrom":"0"
								}
								
								
	   						],



                "customFields":[
					{
                       "name":"Description",
                       "value":"' . $description . '",
                       "type":"ALL"
                    },
                    {
                       "name":"Reg Number",
                       "value":"' . $student['reg_no'] . '",
                       "type":"ALL"
					},
					{
                       "name":"Course",
                       "value":"' . $student['course'] . '",
                       "type":"ALL"
                    },
					
                    {
                       "name":"Invoice Number",
                       "value":"' . $this->ref . '",
                       "type":"ALL"
                    }]
                
                
                }';
			$curl = curl_init();
			curl_setopt_array(
				$curl,
				array(
					CURLOPT_URL => $GATEWAYURL,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $content,
					CURLOPT_HTTPHEADER => array(
						"Authorization: remitaConsumerKey=$merchantId,remitaConsumerToken=$hash",
						"Content-Type: application/json",
						"cache-control: no-cache"
					),
				)
			);

			$json_response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			$jsonData = substr($json_response, 7, -1);
			$response = json_decode($jsonData, true);
			//var_dump($response);
			$statuscode = $response['statuscode'];
			$statusMsg = $response['status'];
			if ($statuscode == '025') {
				$rrr = trim($response['RRR']);
				$new_hash_string = $merchantId . $rrr . $api;
				$new_hash = hash('sha512', $new_hash_string);
				$data = array(

					'student_id' => $student_id,
					'date' => date('d-m-Y'),
					'class_id' => $student['class_id'] - 1,
					'semester_id' => $this->current_semester,
					'session_id' => current_session() - 1,
					'receipt' => $rrr,
					'descr' => $description,
					'type' => 'semester',
					'txn' => $ref,
					'status' => 'pending'
				);
				$inserted_id = $this->payment_model->add_payment($data);
				$data['rrr'] = $rrr;
				$data['ref'] = $ref;
				$data['amount'] = $totalAmount;
				$data['statuscode'] = $statuscode;
				$data['statusMsg'] = $statusMsg;
				$data['merchantId'] = $merchantId;
				$data['responseurl'] = $responseurl;
				$data['hash'] = $new_hash;
				$data['descr'] = $description;
				$data['GATEWAYRRRPAYMENTURL'] = $GATEWAYRRRPAYMENTURL;
				$data['student'] = $student;

				$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="' . $statusMsg . '" data-type="success"></div>');
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-capitalize">' . $statusMsg . '.</div>');

				$this->load->view('student/layout/header', $data);
				$this->load->view('student/checkout_direct', $data);
				$this->load->view('student/layout/footer', $data);
			} else {
				$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="' . $statusMsg . '" data-type="error"></div>');
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Error Generating RRR </div>');
				//var_dump($json_response);
				redirect('student/payment');

				//echo "Error Generating RRR - " . $statusMsg . " (Make Sure you input a valid E-mail and valid Phone Number on your profile )";
			}
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="Registration Closed" data-type="error"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Registration Closed </div>');
			//var_dump($json_response);
			redirect('student/dashboard/');
		}
	}

	public function remita_response_direct($ref)
	{

		//https://remitademo.net/remita/ecomm/merchantId/RRR/hash/status.reg
		//'https://login.remita.net/remita/ecomm/
		$id = $this->session->userdata('user_id');
		$student = $this->student_model->get($id);
		$rrr = $_GET['RRR'];
		$RRRdata = $this->payment_model->get_by_ref($rrr);

		$merchantId = "5751670525"; //"5222939053";
		$api =  "513780"; //"182507";
		//$merchantId = "9212393091";
		//$api = "ZMJYQMTA";
		//$api = "1946"; // Demo Api 
		//$merchantId = "2547916"; //  Demo MerchantId
		//$serviceTypeID = '4430731'; // Demo Service Type ID
		$concatString = $rrr . $api . $merchantId;
		$hash = hash('sha512', $concatString);
		$url = 'https://login.remita.net/remita/ecomm/' . $merchantId . '/' . $rrr . '/' . $hash . '/' . 'status.reg';
		//  Initiate curl
		$curl = curl_init();

		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
			)
		);
		$result = curl_exec($curl);
		// Closing
		curl_close($curl);
		$response = json_decode($result, true);
		//var_dump($response);
		$amount = trim($response['amount'], " ");
		$message = trim($response['message'], " ");
		$RRR = trim($response['RRR'], " ");
		$status = trim($response['status'], " ");

		if ($message == "Approved" || $status == "00" || $status == "01") {

			$student = $this->student_model->get($id);
			$course_id = $student['course_id'];
			
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

			// Determine the base format for the department
			$base_format = isset($department_formats[$course_id]) ? $department_formats[$course_id] : "BMG/UNKNOWN/24/24/";

			// Retrieve the last metric number for the specific department from the database
			$this->db->select('reg_no');
			$this->db->from('students');
			$this->db->like('reg_no', $base_format);
			$this->db->order_by('reg_no', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get();
			$last_reg_no = $query->row_array()['reg_no'];

			// Increment the metric number
			if ($last_reg_no) {
				$last_number = (int)substr($last_reg_no, strrpos($last_reg_no, '/') + 1);
				$new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
			} else {
				// If no metric number exists, start with '001'
				$new_number = '001';
			}

			$new_reg_no = $base_format . $new_number;

			// Update payment status and metric number in the database
			$data1 = array(
				'amount' => $amount,
				'status' => "paid",

			);
			$this->db->where('receipt', $RRR);
			$this->db->update('payment_deposits', $data1);
			//if ($RRRdata['type'] == 'pre_weeding') {
				$update_form_no = array(
					'form_no' => $student['reg_no']
				);

				$this->db->where('id', $id);
				$this->db->update('students', $update_form_no);
				$update_reg = array(
					'reg_no' => $new_reg_no
				);

				$this->db->where('id', $id);
				$this->db->update('students', $update_reg);
				$update_username = array(
					'username' => $new_reg_no
				);

				$this->db->where('user_id', $id);
				$this->db->update('users', $update_username);
			//}
			$student = $this->student_model->get($this->session->userdata('user_id'));
			$name = $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'];
			$this->email_model->send_mail('info@diidol.com.ng', $name, $amount, 'Semester Registration');
			$this->customlib->send_sms($name, $student['phone'], $amount, 'Semester Registration', 'Registration', $RRR);

			header("Location: " . base_url() . 'student/success/' . $RRR);
		} else {
			$data['ref'] = $ref;
			$data['status'] = $status;
			$data['RRR'] = $RRR;
			$data['message'] = $message;
			$data['amount'] = $amount;
			$data['student'] = $student;
			//$this->error();
			$this->load->view('student/layout/header', $data);
			$this->load->view('student/payment_fail', $data);
			$this->load->view('student/layout/footer', $data);
		}
	}

	function pay_response()
	{

		//https://remitademo.net/remita/ecomm/merchantId/RRR/hash/status.reg
		//$id = htmlentities(escapeString($this->uri->segment(4)));
		$student = $this->student_model->get($this->session->userdata('user_id'));
		//$paid = $this->studentPayment_model->getSum($student_id, $student['class_id']);
		//$amount = $this->amount() - $paid->amount;
		$id = $this->session->userdata('user_id');
		$reference = $_GET['reference'];
		$date = date('y');

		$url = 'https://bauchi.revenue.ng/api/v1/cig-requery/71/' . $reference . '/';
		//$url     = 'https://staging.revenue.ng/api/v1/cig-requery/119/' . $reference . '/';


		//  Initiate curl
		$curl = curl_init();


		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
			)
		);
		$result = curl_exec($curl);
		// Closing
		curl_close($curl);
		$response = json_decode($result, true);
		//$invoice_no = $response['inv_no'];
		$status = $response['data']['status'];
		$trans_ref = $response['data']['rrr'];
		$amount = $response['data']['amount'];
		$data['status'] = $status;
		if (
			$status == "PAID" || $status == "paid" || $status == "Paid"
		) {

			$data1 = array(
				'date' => date('d-m-Y'),
				'amount' => $amount,
				'status' => "paid"
			);
			$this->db->where('receipt', $trans_ref);
			$this->db->update('payment_deposits', $data1);
			$student = $this->student_model->get($this->session->userdata('user_id'));

			$name = $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'];
			$this->email_model->send_mail('info@diidol.com.ng', $name, $amount, 'Semester Registration');
			$this->customlib->send_sms($name, $student['phone'], $amount, 'Semester Registration', 'Registration', $trans_ref);

			header("Location: " . base_url() . 'student/payment_success/' . $trans_ref);
		} else {
			//	$this->error();
			$data['ref'] = $reference;
			$data['RRR'] = $trans_ref;
			$data['message'] = 'Transaction Cancelled';
			$data['amount'] = $amount;
			$data['student'] = $student;
			$this->load->view('student/layout/header', $data);
			$this->load->view('student/checkout_bank', $data);
			$this->load->view('student/layout/footer', $data);
		}
	}

	function payment_transaction()
	{
		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['page_name'] = 'payment_transaction';
		$page_data['page_title'] = get_phrase('payment_transaction');
		$id = $this->session->userdata('user_id');
		//$token = $this->student_model->CheckToken($id);
		//$page_data['token'] = $token;
		$page_data['deposit'] = $this->payment_model->getPaymentDeposits($this->session->userdata('user_id'));
		$page_data['student'] = $this->student_model->get($this->session->userdata('user_id'));
		$this->load->view('student/index.php', $page_data);
	}


	function receipt($RRR)
	{
		$this->data['rrr'] = $RRR;
		$this->data['payment'] = $this->payment_model->getPreWeedingReceiptDetails($RRR);
		//$this->data['itemlist']  = $this->payment_model->getItems($student['course_id'], $student['class_id'],);
		$this->reportPDF('receipt.css', $this->data, 'student/receipt', 'RECEIPT', $RRR);
	}

	function check($ref)
	{
		$id = $this->session->userdata('user_id');

		$RRR = $this->input->post('RRR');
		$RRRdata = $this->payment_model->get_by_ref($RRR);

		$merchant_id = "5751670525";
		$api_key = "513780";
		$mode = "Live";
		$hash_string = $RRR . $api_key . $merchant_id;
		$hash = hash('sha512', $hash_string);

		$query_url = ($mode == 'Test') ? 'https://remitademo.net/remita/ecomm' : 'https://login.remita.net/remita/ecomm';
		$url = $query_url . '/' . $merchant_id . '/' . $RRR . '/' . $hash . '/' . 'status.reg';

		$result = file_get_contents($url);
		if ($result === false) {
			// Handle the error here
			show_error('Error retrieving payment status');
			return;
		}

		$response = json_decode($result, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			// Handle JSON decode error
			show_error('Error decoding payment status response');
			return;
		}

		$amount = trim($response['amount']);
		$message = trim($response['message']);
		$RRR = trim($response['RRR']);
		$status = trim($response['status']);

		if ($status == "01" || $status == "00") {
			$student = $this->student_model->get($id);
			$course_id = $student['course_id'];
			$current_year = date('y');

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

			// Determine the base format for the department
			$base_format = isset($department_formats[$course_id]) ? $department_formats[$course_id] : "BMG/UNKNOWN/24/24/";

			// Retrieve the last metric number for the specific department from the database
			$this->db->select('reg_no');
			$this->db->from('students');
			$this->db->like('reg_no', $base_format);
			$this->db->order_by('reg_no', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get();
			$last_reg_no = $query->row_array()['reg_no'];

			// Increment the metric number
			if ($last_reg_no) {
				$last_number = (int)substr($last_reg_no, strrpos($last_reg_no, '/') + 1);
				$new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
			} else {
				// If no metric number exists, start with '001'
				$new_number = '001';
			}

			$new_reg_no = $base_format . $new_number;

			// Update payment status and metric number in the database
			$data1 = array(
				'amount' => $amount,
				'status' => "paid",

			);
			$this->db->where('receipt', $RRR);
			$this->db->update('payment_deposits', $data1);
			if ($RRRdata['type'] == 'pre_weeding') {
				$update_form_no = array(
					'form_no' => $student['reg_no']
				);

				$this->db->where('id', $id);
				$this->db->update('students', $update_form_no);
				$update_reg = array(
					'reg_no' => $new_reg_no
				);

				$this->db->where('id', $id);
				$this->db->update('students', $update_reg);
				$update_username = array(
					'username' => $new_reg_no
				);

				$this->db->where('user_id', $id);
				$this->db->update('users', $update_username);
			}

			$student = $this->student_model->get($this->session->userdata('user_id'));

			$name = $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'];
			$this->email_model->send_mail('info@diidol.com.ng', $name, $amount, 'Semester Registration');
			$this->customlib->send_sms($name, $student['phone'], $amount, 'Semester Registration', 'Registration', $RRR);

			$data['ref'] = $ref;
			$data['status'] = $status;
			$data['RRR'] = $RRR;
			$data['message'] = $message;
			$data['amount'] = $amount;
			$data['student'] = $student;
			//$this->successp();
			$this->load->view('student/layout/header', $data);
			$this->load->view('student/payment_response', $data);
			$this->load->view('student/layout/footer', $data);
		} else {
			$student = $this->student_model->get($this->session->userdata('user_id'));

			$data['ref'] = $ref;
			$data['status'] = $status;
			$data['RRR'] = $RRR;
			$data['message'] = $message;
			$data['amount'] = $amount;
			$data['student'] = $student;
			//$this->error();
			$this->load->view('student/layout/header', $data);
			$this->load->view('student/payment_response', $data);
			$this->load->view('student/layout/footer', $data);
		}
	}

	function success($RRR)
	{
		$id = $this->session->userdata('user_id');
		$student_id = $id;
		$student = $this->student_model->get($student_id);
		$deposit = $this->payment_model->getPreWeedingReceiptDetails($RRR);;

		//$deposit['receipt'] = $receipt;
		$data['descr'] = $deposit['descr'];
		$data['status'] = $deposit['status'];
		$data['RRR'] = $RRR;
		$data['invoice_no'] = $deposit['txn'];
		$data['amount'] = $deposit['amount'];
		$data['student'] = $student;
		$data['page_name'] = 'payment_success';
		//$this->successp();
		$this->session->set_flashdata('msg', '<div class="alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row w-100 p-5 mb-10">
													<span class="svg-icon svg-icon-2hx svg-icon-success me-4 mb-5 mb-sm-0">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor" />
															<path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor" />
														</svg>
													</span>
													<div class="d-flex flex-column pe-0 pe-sm-10">
														<h4 class="fw-semibold">Success</h4>
														<span>Payment Approved..</span>
													
														</div>
													<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
														<span class="svg-icon svg-icon-1 svg-icon-success">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
																<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
															</svg>
														</span>
														</button>
												</div>');
		$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="Payment Approved" data-type="success"></div>');
		$this->session->set_flashdata('success');

		$this->load->view('student/layout/header', $data);
		$this->load->view('student/payment_success', $data);
		$this->load->view('student/layout/footer', $data);
		$this->load->view('layout/scripts', $data);
	}

	function course_reg()
	{

		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$id = $this->session->userdata('user_id');
		//$check_post_payment = $this->payment_model->checkPostPayment($id);
		$check_semester_payment = $this->payment_model->checkSemesterPayment($id);
		if ($check_semester_payment != true) {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="SORRY, You have not make your payment for the Semester, you must pay before you can Register Courses, Thank You" data-type="warning"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">SORRY, You have not make your payment for the Semester, you must pay before you can Register Courses, Thank You</div>');

			redirect(site_url('student/payment'));
		}
		$page_data['page_name'] = 'course_reg';
		$page_data['page_title'] = get_phrase('course_registration');
		$student = $this->student_model->get($id);
		$page_data['student'] = $student;
		/* $course_re = $this->borrow_model->getCourseForReg($student['course_id'], $student['class_id']);
		$page_data['course_re'] = $course_re;
		$registered = $this->course_reg_model->getRegistered($student['id'], $student['course_id'], $student['class_id']);
		$page_data['unit'] = $this->course_reg_model->getSum($student['class_id'], $student['course_id']);
		$page_data['count'] = $this->course_reg_model->getSumReg($student['id'], $student['class_id'], $student['course_id']);
		$page_data['co'] = $this->borrow_model->fetch_co($student['course_id']);
		$page_data['registered'] = $registered; */
		$reg = $this->course_reg_model->get_reg_id($student['id'], $student['course_id'], $student['class_id']);
		$page_data['reg'] = $reg;
		$this->load->view('student/index.php', $page_data);
	}
	public function store_course_reg()
	{
		$subjectid = $this->input->post('data');
		$subject_array = json_decode($subjectid);

		//$registered = $this->suggestion_model->getRegistered($student['id'], $student['course_id'], $student['class_id']);

		$submit = $this->course_reg_model->reg($subject_array);
		if ($submit) {
			$this->reg_ajax();
		} else {
			$response = array(
				'status' => false,
				'data' => $subject_array,
				'notification' => 'Error'
			);
		}
		echo json_encode($response);
		//$this->db->insert_batch('course_reg', $array);

	}

	function reg_ajax()
	{
		$id = $this->session->userdata('user_id');
		$student = $this->student_model->get($id);
		$course_re = $this->borrow_model->getCourseForReg($student['course_id'], $student['class_id']);
		$this->data['course_re'] = $course_re;
		$this->data['unit'] = $this->course_reg_model->getSum($student['class_id'], $student['course_id']);
		$this->data['co'] = $this->borrow_model->fetch_co($student['course_id']);
		$this->data['registered'] = $this->course_reg_model->getRegistered($student['id'], $student['course_id'], $student['class_id']);
		$this->data['count'] = $this->course_reg_model->getSumReg($student['id'], $student['class_id'], $student['course_id']);
		$reg = $this->course_reg_model->get_reg_id($student['id'], $student['course_id'], $student['class_id']);
		$this->data['reg'] = $reg;
		$this->data['student'] = $student;
		$ret['render'] = $this->load->view('student/reg_table', $this->data, true);
		$ret['status'] = true;
		$ret['notification'] = 'Success';
		echo json_encode($ret);
		exit;
	}

	function register()
	{
		$id = $this->session->userdata('user_id');
		$student = $this->student_model->get($id);
		$data = array(
			//'id' => $id,
			'student_id' => $id,
			'session_id' => $this->current_session,
			'semester_id' => $this->current_semester,
			'school_id' => $student['school_id'],
			'course_id' => $student['course_id'],
			'class_id' => $student['class_id'],
			'status' => 'Registered',
			'registered_at' => date('d/m/Y')
		);
		$reg = $this->course_reg_model->addStatus($data);
		if ($reg) {
			$result['status'] = true;
			$result['notification'] = 'Success';
		} else {
			$result['status'] = false;
			$result['notification'] = 'Unknown error';

			# code...
		}
		echo json_encode($result);
		exit;

		//redirect('student/semester_form');
	}

	function delete_multiple_reg()
	{
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
			for ($count = 0; $count < count($id); $count++) {
				$this->course_reg_model->delete_reg($id[$count]);
			}

			$this->reg_ajax();
			/* $response = array(
			'status' => true,
			//'data' => $course_array,
			'notification' => 'Success'
			); */
		} else {
			$response = array(
				'status' => false,
				'notification' => 'Unknown Error'
			);
		}
		echo json_encode($response);
	}
	function semester_form()
	{
		$id = $this->session->userdata('user_id');
		$student = $this->student_model->get($id);
		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['page_name'] = 'semester_forms';
		$page_data['page_title'] = get_phrase('semester_forms');
		$student = $this->student_model->get($id);
		$page_data['current_session_id'] = $this->current_session;
		$page_data['current_semester_id'] = $this->current_semester;
		$page_data['semesterlist'] = $this->semester_model->get();
		$page_data['sessionlist'] = $this->session_model->get();
		$page_data['semester_id'] = $this->current_semester;
		$page_data['session_id'] = $this->current_session;
		$page_data['current_semester_name'] = $this->current_semester_name;
		$page_data['current_session_name'] = $this->current_session_name;
		$page_data['student'] = $student;
		$this->load->view('student/index.php', $page_data);
	}

	function semester_form_ajax()
	{
		$student_id = $this->session->userdata('user_id');
		$session_id = $this->input->post('session_id');
		$semester_id = $this->input->post('semester_id');
		$student = $this->student_model->get($student_id);
		$resultlist = $this->course_reg_model->get_Reg($student_id, $semester_id, $session_id);
		$this->data['session_id'] = $session_id;
		$this->data['semester_id'] = $semester_id;
		$this->data['total'] = $this->course_reg_model->getSumReg($student_id, $semester_id, $session_id);
		$this->data['resultlist'] = $resultlist;
		$this->data['student'] = $student;
		$ret['render'] = $this->load->view('student/semester_form_body', $this->data, true);
		$ret['status'] = true;
		$ret['notification'] = 'Success';
		echo json_encode($ret);
		exit;
	}

	function semester_form_pdf()
	{
		$id = $this->session->userdata('user_id');
		$sm_id = htmlentities($this->uri->segment(3));
		$sess_id = htmlentities($this->uri->segment(4));
		$student = $this->student_model->get($id);
		$this->data['registered'] = $this->course_reg_model->get_Reg($id, $sm_id, $sess_id);
		//$data['co'] = $this->student_model->fetch_co($course_id);
		$this->data['total'] = $this->course_reg_model->getSumReg($id, $sm_id, $sess_id);
		$this->data['semester'] = $this->semester_model->get($sm_id);
		$this->data['session'] = $this->session_model->get($sess_id);
		$this->data['student'] = $student;
		$this->form_PDF('courseform.css', $this->data, 'student/course_form');
	}
	public function form_PDF($stylesheet = NULL, $data = NULL, $viewpath = NULL, $mode = 'view', $pagesize = 'a4', $pagetype = 'portrait')
	{
		$id = $this->session->userdata('user_id');
		$student = $this->student_model->get($id);
		$this->data['panel_title'] = 'Student Semester Form';
		$html = $this->load->view($viewpath, $this->data, true);

		$this->load->library('mhtml2pdf');

		$this->mhtml2pdf->folder('uploads/report/');
		$this->mhtml2pdf->filename($student['reg_no']);
		$this->mhtml2pdf->paper($pagesize, $pagetype);
		$this->mhtml2pdf->html($html);

		if (!empty($stylesheet)) {
			$stylesheet = file_get_contents(base_url('assets/reports/' . $stylesheet));
			return $this->mhtml2pdf->create($this->data['panel_title'], $stylesheet, $mode);
		} else {
			return $this->mhtml2pdf->create($this->data['panel_title'], $mode);
		}
	}

	function result()
	{
		$id = $this->session->userdata('user_id');
		$student = $this->student_model->get($id);
		if ($this->session->userdata('student_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['page_name'] = 'semester_results';
		$page_data['page_title'] = get_phrase('semester_results');
		$student = $this->student_model->get($id);
		$page_data['current_session_id'] = $this->current_session;
		$page_data['current_semester_id'] = $this->current_semester;
		$page_data['semesterlist'] = $this->semester_model->get();
		$page_data['sessionlist'] = $this->session_model->get();
		$page_data['semester_id'] = $this->current_semester;
		$page_data['session_id'] = $this->current_session;
		$page_data['current_semester_name'] = $this->current_semester_name;
		$page_data['current_session_name'] = $this->current_session_name;
		$page_data['student'] = $student;
		$this->load->view('student/index.php', $page_data);
	}

	function semester_result_ajax()
	{
		$student_id = $this->session->userdata('user_id');
		$session_id = $this->input->post('session_id');
		$semester_id = $this->input->post('semester_id');
		$student = $this->student_model->get($student_id);
		$resultlist = $this->course_reg_model->get_Reg($student_id, $semester_id, $session_id);
		$this->data['session_id'] = $session_id;
		$this->data['semester_id'] = $semester_id;
		$this->data['total'] = $this->course_reg_model->getSumReg($student_id, $semester_id, $session_id);
		$this->data['marks'] = $this->exam_model->get_semester_result($student_id, $semester_id, $session_id);
		$this->data['co'] = $this->exam_model->get_co($student_id);
		$this->data['resultlist'] = $resultlist;
		$this->data['student'] = $student;
		$ret['render'] = $this->load->view('student/semester_results_body', $this->data, true);
		$ret['status'] = true;
		$ret['notification'] = 'Success';
		echo json_encode($ret);
		exit;
	}

	function check_payment($ref)
	{
		$id = $this->session->userdata('user_id');
		$RRR = $this->input->post('RRR');
		$RRRdata = $this->payment_model->get_by_ref($RRR);

		$merchant_id = "5751670525";
		$api_key = "513780";
		$mode = "Live";
		$hash_string = $RRR . $api_key . $merchant_id;
		$hash = hash('sha512', $hash_string);

		$query_url = ($mode == 'Test') ? 'https://remitademo.net/remita/ecomm' : 'https://login.remita.net/remita/ecomm';
		$url = $query_url . '/' . $merchant_id . '/' . $RRR . '/' . $hash . '/' . 'status.reg';

		$result = file_get_contents($url);
		if ($result === false) {
			// Handle the error here
			show_error('Error retrieving payment status');
			return;
		}

		$response = json_decode($result, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			// Handle JSON decode error
			show_error('Error decoding payment status response');
			return;
		}

		$amount = trim($response['amount']);
		$message = trim($response['message']);
		$RRR = trim($response['RRR']);
		$status = trim($response['status']);

		if ($status == "01" || $status == "00") {
			$student = $this->student_model->get($id);
			$course_id = $student['course_id'];
			$current_year = date('y');

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

			// Determine the base format for the department
			$base_format = isset($department_formats[$course_id]) ? $department_formats[$course_id] : "BMG/UNKNOWN/24/24/";

			// Retrieve the last metric number for the specific department from the database
			$this->db->select('reg_no');
			$this->db->from('students');
			$this->db->like('reg_no', $base_format);
			$this->db->order_by('reg_no', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get();
			$last_reg_no = $query->row_array()['reg_no'];

			// Increment the metric number
			if ($last_reg_no) {
				$last_number = (int)substr($last_reg_no, strrpos($last_reg_no, '/') + 1);
				$new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
			} else {
				// If no metric number exists, start with '001'
				$new_number = '001';
			}

			$new_reg_no = $base_format . $new_number;

			// Update payment status and metric number in the database
			$data1 = array(
				'amount' => $amount,
				'status' => "paid",

			);
			$this->db->where('receipt', $RRR);
			$this->db->update('payment_deposits', $data1);
			if ($RRRdata['type'] == 'pre_weeding') {
				$update_form_no = array(
					'form_no' => $student['reg_no']
				);

				$this->db->where('id', $id);
				$this->db->update('students', $update_form_no);
				$update_reg = array(
					'reg_no' => $new_reg_no
				);

				$this->db->where('id', $id);
				$this->db->update('students', $update_reg);
				$update_username = array(
					'username' => $new_reg_no
				);

				$this->db->where('user_id', $id);
				$this->db->update('users', $update_username);
			}

			$name = $student['firstname'] . " " . $student['lastname'] . " " . $student['middlename'];

			$this->email_model->send_mail('info@diidol.com.ng', $name, $amount, 'Semester Registration');
			$this->customlib->send_sms($name, $student['phone'], $amount, 'Semester Registration', 'Registration', $RRR);

			$data['ref'] = $ref;
			$data['status'] = $status;
			$data['RRR'] = $RRR;
			$data['message'] = $message;
			$data['amount'] = $amount;
			$data['student'] = $student;
			$data['reg_no'] = $new_reg_no;

			$this->load->view('student/layout/header', $data);
			$this->load->view('student/payment_response', $data);
			$this->load->view('student/layout/footer', $data);
		} else {
			// Handle payment not successful scenario
			show_error('Payment was not successful. Please try again.');
		}
	}




	/* 	5178 6810 0000 0002
expiry date
05/30
CVV
000
OTP
123456 */
}
