<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Applicant extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library('session');
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

		$this->user_model->check_session_data('applicant');
		$this->ref = $this->applicant_model->getReference();
	}
	function update_name()
	{
		$response = $this->applicant_model->add_name();
		/* if ($response->status == true) {
		} */
		echo json_encode($response);
	}
	function dashboard()
	{
		if ($this->session->userdata('applicant_login') != true) {
			redirect(site_url('admission/login'), 'refresh');
		}
		$page_data['page_name'] = 'dashboard';
		$id = $this->session->userdata('user_id');
		$page_data['page_title'] = get_phrase('dashboard');
		$page_data['applicant'] = $this->applicant_model->getAll($id)->row_array();
		$token = $this->applicant_model->CheckToken($id);
		$page_data['token'] = $token;
		$this->load->view('applicant/index.php', $page_data);
		//echo 'This is Applicant Dashboard';
	}

	public function getAppAmount()
	{
		$id = $this->input->get('id');
		$result = $this->db->get_where('programs', array('id' => $id))->row_array();
		echo json_encode($result);

		//$data = $this->student_model->getStateByLocal($state_id);

	}

	function payment()
	{
		if ($this->session->userdata('applicant_login') != true) {
			redirect(site_url('admission/login'), 'refresh');
		}
		$page_data['page_name'] = 'payment';
		$page_data['page_title'] = get_phrase('payment');
		$id = $this->session->userdata('user_id');
		$token = $this->applicant_model->CheckToken($id);
		$page_data['token'] = $token;
		$page_data['applicant'] = $this->applicant_model->getAll($this->session->userdata('user_id'))->row_array();
		$this->load->view('applicant/index.php', $page_data);
	}

public function init_pay()
	{
		$id = $this->input->post('applicant_id');
		$applicant_id = $id;
		$totalAmount = $this->input->post('inputAmount') - 322.50;
		$method = $this->input->post('method');
		$program = $this->input->post('program');
		$ref = $this->ref;

		$applicant = $this->applicant_model->getAll($id)->row_array();
		$remita_service_id = '10670473699';
		$data['title'] = "Make Payment with Remita";
		$GATEWAYRRRPAYMENTURL = "https://login.remita.net/remita/ecomm/finalize.reg";
		$GATEWAYURL = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
		$merchantId = "5751670525";
		$serviceTypeID = "10670473699";
		$splitAmount = $totalAmount - 1000;
		//$merchantId = "2547916"; //  Demo MerchantId
		//$serviceTypeID = '4430731'; // Demo Service Type ID
		$timesammp = DATE("dmyHis");
		$api = "513780";
		//$api = "1946"; // Demo Api 
		//1221435453
		$ref = $this->ref;
		$orderID = $timesammp;
		$payerName = $applicant['firstname'] . " " . $applicant['lastname'] . " " . $applicant['middlename'];
		$payerEmail = $applicant['email'];
		$payerPhone = $applicant['phone'];
		$description = 'Online Application';
		$responseurl = base_url('applicant/payment_response/' . $ref);
		$hash_string = $merchantId . $serviceTypeID . $orderID . $totalAmount . $api;
		$hash = hash('sha512', $hash_string);
		$itemtimestamp = $timesammp;
		//The JSON data.
		//1012130796 NINGI
		//033

		//0015935069 DIIDOL
		//215

		//2379587078 MINE
		//057
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
       							  "beneficiaryName":"College of Health Tech. Ningi",
       							  "beneficiaryAccount":"2379587078", 
       							  "bankCode":"057",
       							  "beneficiaryAmount":"' . $splitAmount . '",
       							  "deductFeeFrom":"1"
								},
       							{
       							  "lineItemsId":"itemid1",
       							  "beneficiaryName":"Diidol Consult",
       							  "beneficiaryAccount":"0015935069",
       							  "bankCode":"215",
       							  "beneficiaryAmount":"1000",
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

				'applicant_id' => $applicant_id,
				'date' => date('d-m-Y'),
				'session_id' => current_session(),
				'receipt' => $rrr,
				'descr' => $description,
				//'type' => 'pre_weeding',
				'txn' => $ref,
				'status' => 'pending'
			);

			$inserted_id = $this->applicant_model->add_payment($data);
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
			$data['applicant'] = $applicant;

			$this->session->set_flashdata('toast', '<div class="toast" data-title="Success! "data-message="' . $statusMsg . '" data-type="success"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-capitalize">' . $statusMsg . '.</div>');

			$this->load->view('applicant/layout/header', $data);
			$this->load->view('applicant/checkout_direct', $data);
			$this->load->view('applicant/layout/footer', $data);
		} else {
			$this->session->set_flashdata('toast', '<div class="toast" data-title="Error! "data-message="' . $statusMsg . '" data-type="error"></div>');
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-capitalize">Error Generating RRR </div>');

			redirect('applicant/payment');
			//echo "Error Generating RRR - " . $statusMsg . " (Make Sure you input a valid E-mail and valid Phone Number on your profile )";
		}
		//}
	}


	/* 	public function init_pay()
	{
	//$this->load->library('curl');
	$id = $this->input->post('applicant_id');
	$applicant_id = $id;
	$inputAmount = $this->input->post('inputAmount');
	$method = $this->input->post('method');
	$program = $this->input->post('program');
	$ref = $this->ref;
	$applicant = $this->applicant_model->getAll($id)->row_array();
	$remita_service_id = '8782852323';
	$url =  'https://bauchi.revenue.ng/api/v1/cig/coe_azare/119?token=02NDY77EHFHRH2HHD8FBNBDGFSWCVBDJFBHF21213HFHRH2HHD8FBNBDGFSWCVBDJ&userId=470';
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_POSTFIELDS => '{
	"first_name": "' . $applicant['firstname'] . '",
	"last_name": "' . $applicant['lastname'] . '",
	"email": "' . $applicant['email'] . '",
	"phone": "' . $applicant['phone'] . '",
	"matric_no": "applicant_' . $applicant['id'] . '",
	"channel": "' . $method . '",
	"callback_url": "' . base_url('applicant/payment/payment_response/' . $ref) . '",
	"remita_service_id": "' . $remita_service_id . '",
	"client_ref": "' . $ref . '",
	"type_of_split": "dynamic",
	"item_code_total": "100119-1510",
	"services": [
	{
	"item_code": "100119-1495",
	"amount": "' . $inputAmount . '",
	"type": "taxable",
	"percentage_split": 1
	},
	{
	"item_code": "100119-1496",
	"amount": 1000,
	"type": "non_taxable",
	"percentage_split": 0
	},
	{
	"item_code": "100119-1497",
	"amount": 1500,
	"type": "service_charge",
	"percentage_split": 0
	}
	]
	}',
	CURLOPT_HTTPHEADER => array(
	'Accept: application/json',
	'Content-Type: application/json'
	),
	));
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
	$data['client_ref'] = $client_ref;
	$data['invoice_no'] = $invoice_no;
	$data['matric_no'] = $matric_no;
	$data['status'] = $status;
	$data['message'] = $message;
	$data['amount'] = $amount;
	$data['rrr'] = $rrr;
	$data['descr'] = 'Online Application Fee';
	$data['applicant'] = $applicant;
	if ($statusCode == '00') {
	$authorization_url = $resp['data']['authorization_url'];
	$data['authorization_url'] = $authorization_url;
	//$rrr = substr($authorization_url, 54);
	//$data['rrr'] = $rrr;
	$details = array(
	'applicant_id' => $applicant_id,
	'date' => date('d-m-Y'),
	//'class_id' => $applicant['class_id'],
	//'semester_id' => $this->current_semester,
	'session_id' => "", //$this->current_session,
	'receipt' => $rrr,
	'method' => $method,
	'descr' => 'Online Application Fee',
	'txn' => $invoice_no,
	'status' => 'pending'
	);
	$inserted_id = $this->applicant_model->add_payment($details);
	$this->load->view('applicant/layout/header', $data);
	//$this->load->view('layout/nce/sidebar', $data);
	$this->load->view('applicant/checkout', $data);
	$this->load->view('applicant/layout/footer', $data);
	//echo "<pre>";
	//print_r($data);
	//echo "</pre>";
	} else {
	//var_dump($resp);
	//$this->warning();
	//$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">' . $status . ', Generating Invoice Number - (Make sure you have a valid Email). If the Error persist, Please contact the ICT Unit for support .</div>');
	//redirect('applicants/payment/sch_fees');
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
	$data['status'] = $status;
	$data['rrr'] = $rrr;
	$data['amount'] = $amount;
	$data['descr'] = 'Online Application Fee';
	$data['applicant'] = $applicant;
	//$rrr = $resp['data']['rrr'];
	//$data['rrr'] = $rrr;
	if ($status == 'success') {
	$details = array(
	'applicant_id' => $applicant_id,
	'date' => date('d-m-Y'),
	//'class_id' => $applicant['class_id'],
	//'semester_id' => $this->current_semester,
	'session_id' => "",
	'receipt' => $rrr,
	'txn' => $invoice_no,
	'method' => $method,
	'descr' => 'Online Application Fee',
	//	'type' => 'nce',
	'status' => 'pending'
	);
	$inserted_id = $this->applicant_model->add_payment($details);
	//$inserted_id = $this->applicantPayment_model->amountDeposit($details);
	$this->load->view('applicant/layout/header', $data);
	$this->load->view('applicant/checkout_bank', $data);
	$this->load->view('applicant/layout/footer', $data);
	//$this->load->view('layout/nce/header', $data);
	//$this->load->view('layout/nce/sidebar', $data);
	//$this->load->view('nce/checkout_bank', $data);
	//$this->load->view('layout/nce/footer', $data);
	// echo "<pre>";
	//print_r($data);
	//echo "</pre>"; 
	} else {
	//$this->warning();
	//$this->session->set_flashdata('msg', '<div class="alert alert-danger mt-2 text-capitalize">' . $status . ', Generating Invoice Number - (Make sure you have a valid Email). If the Error persist, Please contact the ICT Unit for support .</div>');
	//redirect('applicants/payment/sch_fees');
	}
	//echo "<pre>";
	//	print_r($resp);
	//	echo "</pre>"; 
	}
	//var_dump($resp);
	//echo "IT WORK";
	} */


	/* function pay_response()
	{
	//https://remitademo.net/remita/ecomm/merchantId/RRR/hash/status.reg
	//$id = htmlentities(escapeString($this->uri->segment(4)));
	$applicant = $this->applicant_model->getAll($this->session->userdata('user_id'))->row_array();
	//$paid = $this->studentPayment_model->getSum($student_id, $student['class_id']);
	//$amount = $this->amount() - $paid->amount;
	$id = $this->session->userdata('user_id');
	$reference = $_GET['reference'];
	$date = date('y');
	$random = 'CHTNINGI/' . $date . '/';
	$str_lenght = 4;
	$id_int = substr("0000{$id}", -$str_lenght);
	$application_no = $random . $id_int;
	$no = $application_no;
	//$amount = $_GET['amount'];
	//$matric_no = $_GET['matric_no'];
	$url = 'https://bauchi.revenue.ng/api/v1/cig-requery/119/' . $reference . '/';
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
	$token = $this->customlib->getToken();
	//$prefix = $student['code'] . "/21/";
	//	$custom = $this->get_custom_id($prefix);
	//$reg_no = $custom;
	if (
	$status == "PAID" || $status == "paid" || $status == "Paid"
	) {
	$data1 = array(
	'date' => date('d-m-Y'),
	'amount' => $amount,
	'status' => "paid"
	);
	$this->db->where('receipt', $trans_ref);
	$this->db->update('applicant_deposits', $data1);
	//	};
	//$this->successp();
	$da1 = array(
	'token' => $token,
	'token_status' => 'taken',
	'application_no' => $no
	);
	$this->db->where('id', $id);
	$this->db->update('applicants', $da1);
	header("Location: " . base_url() . 'applicant/payment_success/' . $trans_ref);
	} else {
	//	$this->error();
	$data['ref'] = $reference;
	$data['RRR'] = $trans_ref;
	$data['message'] = 'Transaction Cancelled';
	$data['amount'] = $amount;
	$data['applicant'] = $applicant;
	$this->load->view('applicant/layout/header', $data);
	$this->load->view('applicant/checkout_bank', $data);
	$this->load->view('applicant/layout/footer', $data);
	}
	} */

	public function payment_response($ref)
	{

		//https://remitademo.net/remita/ecomm/merchantId/RRR/hash/status.reg
		//'https://login.remita.net/remita/ecomm/
		$id = $this->session->userdata('user_id');
		$applicant = $this->applicant_model->getAll($this->session->userdata('user_id'))->row_array();

		$rrr = $_GET['RRR'];
		$merchantId = "5751670525";
		$api = "513780";
		//$api = "1946"; // Demo Api 
		//$merchantId = "2547916"; //  Demo MerchantId
		//$serviceTypeID = '4430731'; // Demo Service Type ID
		$date = date('y');
		$random = 'CHTNG/ADM/' . $date . '/';
		$str_lenght = 4;
		$id_int = substr("0000{$id}", -$str_lenght);
		$application_no = $random . $id_int;
		$no = $application_no;
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
		//$prefix = $student['code'] . "/21/";
		//$custom = $this->get_custom_id($prefix);
		//$reg_no = $custom; 		//var_dump($amount);
		if ($message == "Approved" || $status == "00" || $status == "01") {
			/* $update_reg_no = array(
			'id' => $id,
			'reg_no' => $reg_no
			);
			$this->student_model->add($update_reg_no); */
			$data1 = array(
				'date' => date('d-m-Y'),
				'amount' => $amount,
				'status' => "paid"
			);
			//$this->db->where('type', 'nce');
			$this->db->where('receipt', $RRR);
			$this->db->update('applicant_deposits', $data1);

			$token = $this->customlib->getToken();
			//$this->successp();
			$da1 = array(
				'token' => $token,
				'token_status' => 'taken',
				'application_no' => $no
			);
			$this->db->where('id', $id);
			$this->db->update('applicants', $da1);
			$name = $applicant['firstname'] . " " . $applicant['lastname'] . " " . $applicant['middlename'];
			$this->email_model->send_mail('info@diidol.com.ng', $name, $amount, 'Application Form');
			$this->customlib->send_sms($name, $applicant['phone'], $amount, 'Application Form', 'Application', $RRR);
			header("Location: " . base_url() . 'applicant/success/' . $RRR);
			//$this->successp();

			//redirect('prestudents/payment/success','refresh');

			//header("Location: " . base_url() . 'student/success/' . $RRR);
		} else {
			$data['ref'] = $ref;
			$data['status'] = $status;
			$data['RRR'] = $RRR;
			$data['message'] = $message;
			$data['amount'] = $amount;
			$data['applicant'] = $applicant;
			//$this->error();
			$this->load->view('applicant/layout/header', $data);
			$this->load->view('applicant/payment_fail', $data);
			$this->load->view('applicant/layout/footer', $data);
		}
	}

	function payment_transaction()
	{
		if ($this->session->userdata('applicant_login') != true) {
			redirect(site_url('admission/login'), 'refresh');
		}
		$page_data['page_name'] = 'payment_transaction';
		$page_data['page_title'] = get_phrase('payment_transaction');
		$id = $this->session->userdata('user_id');
		$token = $this->applicant_model->CheckToken($id);
		$page_data['token'] = $token;
		$page_data['deposit'] = $this->applicant_model->getPaymentDeposits($this->session->userdata('user_id'));
		$page_data['applicant'] = $this->applicant_model->getAll($this->session->userdata('user_id'))->row_array();
		$this->load->view('applicant/index.php', $page_data);
	}

	function check($ref)
	{
		$id = $this->session->userdata('user_id');
		$RRR = $this->input->post('RRR');
		/* 	$id = $this->session->userdata["student"]["student_id"];
		$student = $this->student_model->get($id); */
		//$api_key = "1946"; //DEMO
		//$mert = "2547916"; //DEMO
		$mert = "5751670525";
		$api_key = "513780";
		$mode = "Live";
		$hash_string = $RRR . $api_key . $mert;
		$hash = hash('sha512', $hash_string);
		if ($mode == 'Test') {
			$query_url = 'https://remitademo.net/remita/ecomm';
		} else if ($mode == 'Live') {
			$query_url = 'https://login.remita.net/remita/ecomm';
		}
		$url = $query_url . '/' . $mert . '/' . $RRR . '/' . $hash . '/' . 'status.reg';
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
		$token = $this->customlib->getToken();
		$no = $application_no;
		if ($status == "01" || $status == "00") {
			$data1 = array(
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

			$applicant = $this->applicant_model->getAll($this->session->userdata('user_id'))->row_array();
			$name = $applicant['firstname'] . " " . $applicant['lastname'] . " " . $applicant['middlename'];
			$this->email_model->send_mail('info@diidol.com.ng', $name, $amount, 'Application Form');
			$this->customlib->send_sms($name, $applicant['phone'], $amount, 'Application Form', 'Application', $RRR);
			$data['ref'] = $ref;
			$data['status'] = $status;
			$data['RRR'] = $RRR;
			$data['message'] = $message;
			$data['amount'] = $amount;
			$data['applicant'] = $applicant;
			//$this->successp();
			$this->load->view('applicant/layout/header', $data);
			$this->load->view('applicant/payment_response', $data);
			$this->load->view('applicant/layout/footer', $data);
		} else {
			$applicant = $this->applicant_model->getAll($this->session->userdata('user_id'))->row_array();

			$data['ref'] = $ref;
			$data['status'] = $status;
			$data['RRR'] = $RRR;
			$data['message'] = $message;
			$data['amount'] = $amount;
			$data['applicant'] = $applicant;
			//$this->error();
			$this->load->view('applicant/layout/header', $data);
			$this->load->view('applicant/payment_response', $data);
			$this->load->view('applicant/layout/footer', $data);
		}
	}

	function success($RRR)
	{
		$id = $this->session->userdata('user_id');
		//$student_id = $id;
		$applicant = $this->applicant_model->getAll($this->session->userdata('user_id'))->row_array();
		$deposit = $this->applicant_model->getReceiptDetails($RRR);

		//$deposit['receipt'] = $receipt;
		$data['descr'] = $deposit['descr'];
		$data['status'] = $deposit['status'];
		$data['RRR'] = $RRR;
		$data['invoice_no'] = $deposit['txn'];
		$data['amount'] = $deposit['amount'];
		$data['applicant'] = $applicant;
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

		$this->load->view('applicant/layout/header', $data);
		$this->load->view('applicant/payment_success', $data);
		$this->load->view('applicant/layout/footer', $data);
		$this->load->view('layout/scripts', $data);
	}
	public function receiptPDF($stylesheet = NULL, $data = NULL, $viewpath = NULL, $title = null, $subtitle = null, $mode = 'view', $pagesize = 'a4', $pagetype = 'portrait')
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


	function receipt($RRR)
	{
		$this->data['rrr'] = $RRR;
		$this->data['payment'] = $this->applicant_model->getReceiptDetails($RRR);
		//$this->data['itemlist']  = $this->payment_model->getItems($student['course_id'], $student['class_id'],);
		$this->receiptPDF('receipt.css', $this->data, 'applicant/receipt', 'APPLICATION_RECEPT', $RRR);
	}
	function adform()
	{
		if ($this->session->userdata('applicant_login') != true) {
			redirect(site_url('admission/login'), 'refresh');
		}

		$id = $this->session->userdata('user_id');
		$token = $this->applicant_model->CheckToken($id);
		$page_data['token'] = $token;
		if ($token == NULL) {
			redirect(site_url('applicant/payment'));
		}
		$page_data['page_name'] = 'adform';
		$page_data['page_title'] = get_phrase('application_form');
		$state = $this->crud_model->getstate();
		$page_data['statelist'] = $state;
		$school = $this->school_model->get();
		$page_data['schoollist'] = $school;
		/* $department = $this->department_model->get();
		$page_data['departmentlist'] = $department; */
		$religionList = $this->customlib->getReligion();
		$page_data['religionList'] = $religionList;
		$maritalStatus = $this->customlib->getMaritalStatus();
		$page_data['maritalStatus'] = $maritalStatus;
		$olevelList = $this->customlib->getOlevel();
		$page_data['olevelList'] = $olevelList;
		$subjectList = $this->customlib->getSubject();
		$page_data['subjectList'] = $subjectList;
		$creditList = $this->customlib->getCredit();
		$page_data['creditList'] = $creditList;
		$sittings = $this->customlib->getSitting();
		$page_data['sittings'] = $sittings;
		$choice1 = $this->applicant_model->get1choice($id);
		$page_data['choice1'] = $choice1;
		$choice2 = $this->applicant_model->get2choice($id);
		$page_data['choice2'] = $choice2;
		$page_data['applicant'] = $this->applicant_model->getAll($this->session->userdata('user_id'))->row_array();
		$this->load->view('applicant/index.php', $page_data);
	}

	function getByLocal()
	{
		$state_id = $this->input->get('state_id');
		$data = $this->crud_model->getStateByLocal($state_id);
		echo json_encode($data);
	}
	function getBySchool()
	{
		$state_id = $this->input->get('school_id');
		$data = $this->crud_model->getDepartmentsBySchool($state_id);
		echo json_encode($data);
	}
	function getByDepartment()
	{
		$department_id = $this->input->get('department_id');
		$data = $this->crud_model->getCoursesByDept($department_id);
		echo json_encode($data);
	}

	function addFormDetails()
	{
		$result = $this->applicant_model->addFormDetails();

		echo json_encode($result);
		exit;
	}

	function upload_img()
	{
		$applicant_id = $this->session->userdata('user_id');
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
				$this->applicant_model->add($image_data);
			}
		}
	}

	function review()
	{
		$applicant_id = $this->session->userdata('user_id');
		$applicant = $this->applicant_model->getAll($applicant_id)->row_array();
		$waec = $this->applicant_model->getWaec($applicant_id);
		$this->data['waecs'] = $waec;
		$neco = $this->applicant_model->getNeco($applicant_id);
		$this->data['neco'] = $neco;
		$choice1 = $this->applicant_model->get1choice($applicant_id);
		$this->data['choice1'] = $choice1;
		$choice2 = $this->applicant_model->get2choice($applicant_id);
		$this->data['choice2'] = $choice2;
		$applicant_acad = $this->applicant_model->getapplicantacad($applicant_id);
		$this->data['applicant_acad'] = $applicant_acad;
		$this->data['applicant'] = $applicant;
		$response['status'] = true;
		$response['notification'] = 'Success! Data Saved';
		$response['render'] = $this->load->view('applicant/review', $this->data, true);
		echo json_encode($response);
		exit;
	}

	function finalize()
	{
		$id = $this->input->post('id');
		$data = array(

			'status' => "submitted"
		);
		$this->db->where('id', $id);
		$this->db->update('applicants', $data);
		return true;
	}

	public function reportPDF($stylesheet = NULL, $data = NULL, $viewpath = NULL, $mode = 'view', $pagesize = 'a4', $pagetype = 'portrait')
	{

		$id = $this->session->userdata('user_id');
		$applicant = $this->applicant_model->getAll($id)->row_array();
		$this->data['panel_title'] = 'Acknowledgement Form';
		$html = $this->load->view($viewpath, $this->data, true);

		$this->load->library('mhtml2pdf');

		$this->mhtml2pdf->folder('uploads/report/');
		$this->mhtml2pdf->filename($applicant['application_no']);
		$this->mhtml2pdf->paper($pagesize, $pagetype);
		$this->mhtml2pdf->html($html);

		if (!empty($stylesheet)) {
			$stylesheet = file_get_contents(base_url('assets/reports/' . $stylesheet));
			return $this->mhtml2pdf->create($this->data['panel_title'], $stylesheet, $mode);
		} else {
			return $this->mhtml2pdf->create($this->data['panel_title'], $mode);
		}
	}

	public function acknown_form_pdf()
	{
		//$id = $this->input->post('id');
		//$this->data['id'] = $id;
		/* $applicant_id = $this->session->userdata('user_id');
		$applicant = $this->applicant_model->getAll('193')->row_array();
		$waec = $this->applicant_model->getWaec($applicant_id);
		$this->data['waecs'] = $waec;
		$neco = $this->applicant_model->getNeco($applicant_id);
		$this->data['neco'] = $neco;
		$choice1 = $this->applicant_model->get1choice($applicant_id);
		$this->data['choice1'] = $choice1;
		$choice2 = $this->applicant_model->get2choice($applicant_id);
		$this->data['choice2'] = $choice2;
		$choice = $this->applicant_model->get_choice($applicant_id);
		$this->data['choice'] = $choice;
		$applicant_acad = $this->applicant_model->getapplicantacad($applicant_id);
		$this->data['applicant_acad'] = $applicant_acad;
		$this->data['applicant'] = $applicant; */
		$this->data['id'] = '193';
		$this->reportPDF('studentsessionreport.css', $this->data, 'applicant/acknowledgement');
	}
}
