<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Customlib
{

	var $CI;

	function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('session');
		$this->CI->load->library('user_agent');
	}

	function getReference($maxlength = 5)
	{
		$date = date('ymd');
		$chary = array(
			"0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
		);
		$return_str = "";
		for ($x = 0; $x <= $maxlength; $x++) {
			$return_str .= $chary[rand(0, count($chary) - 1)];
		}
		$result = $date . $return_str;
		return $result;
	}

	function getStaffID()
	{
		$role = $this->CI->session->userdata('role');
		if ($role == 'admin') {
			$id = $this->CI->session->userdata('user_id');
			return $id;
		}
	}
	function getCSRF()
	{
		$csrf_input = "<input type='hidden' ";
		$csrf_input .= "name='" . $this->CI->security->get_csrf_token_name() . "'";
		$csrf_input .= " value='" . $this->CI->security->get_csrf_hash() . "'/>";

		return $csrf_input;
	}

	function getToken($maxlength = 11)
	{
		$chary = array(
			"0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
		);
		$return_str = "";
		for ($x = 0; $x <= $maxlength; $x++) {
			$return_str .= $chary[rand(0, count($chary) - 1)];
		}
		$result = $return_str;
		return $result;
	}

	function getSubject()
	{
		$subject = array();
		$subject['Accounting'] = 'Accounting';
		$subject['Animal Husbandry'] = 'Animal Husbandry';
		$subject['Arabic'] = 'arabic';
		$subject['Agric Sci'] = 'Agric Sci';
		$subject['Basic Electricity'] = 'Basic Electricity';
		$subject['Basic science'] = 'Basic science';
		$subject['Basic Technology'] = 'Basic technology';
		$subject['Biology'] = 'Biology';
		//$subject['Blocklaying/Bricklaying Concreting'] = 'Blocklaying/Bricklaying Concreting';
		//$subject['Book Keeping'] = 'Book Keeping';
		//$subject['Building/Engineering Drawing'] = 'Building/Engineering Drawing';
		$subject['Business Management'] = 'Business Management';
		//$subject['Carpentry and Joinery'] = 'Carpentry and Joinery';
		//$subject['Catering Craft Practice'] = 'Catering Craft Practice';
		$subject['Chemistry'] = 'Chemistry';
		$subject['Civic Education'] = 'Civic Education';
		$subject['Computer Science'] = 'Computer Science';
		$subject['Commerce'] = 'Commerce';
		$subject['CRS'] = 'CRS';
		$subject['Data Processing'] = 'Data Processing';
		$subject['Economics'] = 'Economics';
		//$subject['Electrical Installation & Maintenance Work'] = 'Electrical Installation & Maintenance Work';
		//$subject['Electronics or Basic Electronics'] = 'Electronics or Basic Electronics';
		//$subject['English Language'] = 'english_language';
		$subject['Financial Accounting'] = 'Financial Accounting';
		$subject['Fine and Applied Arts'] = 'Fine and Applied Arts';
		$subject['Fisheries'] = 'Fisheries';
		$subject['Food and Nutrition'] = 'Food and Nutrition';
		//$subject['Furniture making'] = 'Furniture making';
		$subject['Further Maths'] = 'Further Maths';
		//$subject['General Wood Work'] = 'General Wood Work';
		$subject['Geography'] = 'geography';
		$subject['Government'] = 'Government';
		$subject['Hausa Language'] = 'Hausa language';
		$subject['Health Science'] = 'Health Science';
		$subject['History'] = 'History';
		$subject['Information and Communication Technology'] = 'Information and Communication Technology';
		$subject['Igbo'] = 'Igbo';
		$subject['IRS'] = 'IRS';
		//$subject['Introduction to Building Construction'] = 'Introduction to Building Construction';
		$subject['Literature'] = 'Literature';
		//$subject['Mathematics'] = 'mathematics';
		$subject['Marketing'] = 'Marketing';
		//$subject['MetalWork'] = 'MetalWork';
		$subject['Office Practice'] = 'Office Practice';
		$subject['Physical Education'] = 'Physical Education';
		$subject['Physics'] = 'Physics';
		//$subject['Plumbing and Pipe Fitting'] = 'Plumbing and Pipe Fitting';
		//$subject['Technical Drawing'] = 'Technical Drawing';
		//$subject['Welding and Fabrication Engineering'] = 'Welding and Fabrication Engineering';
		//$subject['WoodWork'] = 'WoodWork';
		$subject['Yoruba'] = 'Yoruba';
		return $subject;
	}

	function getMaritalStatus()
	{
		$maritalStatus = array();
		$maritalStatus['single'] = 'Single';
		$maritalStatus['married'] = 'Married';
		$maritalStatus['divorced'] = 'Divorced';
		return $maritalStatus;
	}

	function getCredit()
	{
		$credit = array();
		$credit['A1'] = 'A1';
		$credit['B2'] = 'B2';
		$credit['B3'] = 'B3';
		$credit['C4'] = 'C4';
		$credit['C5'] = 'C5';
		$credit['C6'] = 'C6';
		$credit['D7'] = 'D7';
		$credit['E8'] = 'E8';
		$credit['F9'] = 'F9';
		return $credit;
	}

	function getOlevel()
	{
		$olevel = array();
		$olevel['WAEC'] = 'WAEC';
		$olevel['NECO'] = 'NECO';
		$olevel['NABTEB'] = 'NABTEB';
		/*	$olevel['NBIAS'] = 'NBIAS';
		$olevel['GRADE II'] = 'GRADE II';*/
		return $olevel;
	}

	function getSitting()
	{
		$sitting = array();
		$sitting['1'] = 'Once';
		$sitting['2'] = 'Twice';
		return $sitting;
	}
	function getReligion()
	{
		$religion = array();

		$religion['muslim'] = 'Muslim';
		$religion['christianity'] = 'Christianity';
		$religion['others'] = 'Others';
		return $religion;
	}
	function getGender()
	{
		$g = array();

		$g['M'] = 'Male';
		$g['F'] = 'Female';
		//$religion['others'] = 'Others';
		return $g;
	}
	function getTax()
	{
		$indigene = array();
		$indigene['taxable'] = 'Taxable';
		$indigene['non-taxable'] = 'Non-Taxable';
		return $indigene;
	}
	function getIndigene()
	{
		$indigene = array();
		$indigene['Indigene'] = 'Indigene';
		$indigene['Non-Indigene'] = 'Non-Indigene';
		return $indigene;
	}
	function getPaymentType()
	{
		$payment = array();
		$payment['application'] = 	'Application Fee';
		$payment['pre_weeding'] = 	'Pre-Weeding';
		$payment['admission_fee'] = 'Admission Fee';
		$payment['post_weeding'] = 'Post-Weeding';
		$payment['semester'] = 	'Semester Reg';
		return $payment;
	}

	function send_sms($name, $recipient, $amount, $descr, $content, $rrr)
	{
		//$name= 'Farouq';
		//$recipient="2348066880055";
		$email = "fdhammad@gmail.com";
		$password = "@#Fdhammad1995";
		$message = "Dear " . $name . "\n Your Payment of ₦" . number_format($amount) . " for " . $descr . " with the RRR: " . $rrr . " was success. Kindly proceed with your " . $content . " \nThank you";
		$sender_name = "CHTNINGI";
		$recipients = $recipient;
		$forcednd = "1";

		$data = array("email" => $email, "password" => $password, "message" => $message, "sender_name" => $sender_name, "recipients" => $recipients, "forcednd" => $forcednd);
		$data_string = json_encode($data);
		$ch = curl_init('https://api.80kobosms.com/v2/app/sms');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization : Bearer {llJzkjFHKibD5AhtEehDeRs4Xrkd4S6mCbelv3kzkCJkWgEP9Sgp1uMaqntB}', 'Accept: application/json', 'Content-Type: application/json', 'Content-Length: ' . strlen($data_string)));
		$result = curl_exec($ch);
		$res_array = json_decode($result);
	}
}
