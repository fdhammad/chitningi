<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}


    public function send_mail($email = "", $name = "", $amount="", $descr="")
	{
		$email_data['subject'] = "Payment Successfull";
		$email_data['from'] = get_settings('system_email');
		$email_data['to'] = $email;
		$email_data['name'] = $name;
        $email_data['amount'] = $amount;
        $email_data['descr'] = $descr;
		$email_data['message'] = 'just make a payment for ';
		$email_template = $this->load->view('email/template', $email_data, TRUE);
		$this->send_smtp_mail($email_template, $email_data['subject'], $email_data['to'], $email_data['from']);
	}


    public function send_smtp_mail($msg = NULL, $sub = NULL, $to = NULL, $from = NULL, $email_type = NULL, $verification_code = null)
	{
		//Load email library
		$this->load->library('email');

		if ($from == NULL)
			$from		=	$this->db->get_where('settings', array('key' => 'system_email'))->row()->value;

		//SMTP & mail configuration
		$config = array(
			'protocol'  => get_settings('protocol'),
			'smtp_host' => get_settings('smtp_host'),
			'smtp_port' => get_settings('smtp_port'),
			'smtp_user' => get_settings('smtp_user'),
			'smtp_pass' => get_settings('smtp_pass'),
			'smtp_crypto' => get_settings('smtp_crypto'), //can be 'ssl' or 'tls' for example
			'mailtype'  => 'html',
			'newline'   => "\r\n",
			'charset'   => 'utf-8',
			'smtp_timeout' => '10', //in seconds
		);
		$this->email->set_header('MIME-Version', 1.0);
		$this->email->set_header('Content-type', 'text/html');
		$this->email->set_header('charset', 'UTF-8');

		$this->email->initialize($config);

		$this->email->to($to);
		$this->email->from($from, get_settings('system_name'));
		$this->email->subject($sub);
		$this->email->message($msg);

		//Send email
		$this->email->send();
		// echo $this->email->print_debugger();
		// die();
	}
}