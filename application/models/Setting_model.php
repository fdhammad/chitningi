<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	function update_settings()
	{
		$data['value'] = html_escape($this->input->post('system_name'));
		$this->db->where('key', 'system_name');
		$this->db->update('settings', $data);
		$data['value'] = html_escape($this->input->post('system_title'));
		$this->db->where('key', 'system_title');
		$this->db->update('settings', $data);

		$data['value'] = html_escape($this->input->post('system_email'));
		$this->db->where('key', 'system_email');
		$this->db->update('settings', $data);

		$data['value'] = html_escape($this->input->post('address'));
		$this->db->where('key', 'address');
		$this->db->update('settings', $data);

		$data['value'] = html_escape($this->input->post('adm_session'));
		$this->db->where('key', 'admission_session');
		$this->db->update('settings', $data);

		$data['value'] = html_escape($this->input->post('session'));
		$this->db->where('key', 'session');
		$this->db->update('settings', $data);

		$data['value'] = html_escape($this->input->post('semester'));
		$this->db->where('key', 'semester');
		$this->db->update('settings', $data);

		$data['value'] = html_escape($this->input->post('phone'));
		$this->db->where('key', 'phone');
		$this->db->update('settings', $data);

		$data['value'] = html_escape($this->input->post('footer_text'));
		$this->db->where('key', 'footer_text');
		$this->db->update('settings', $data);

		$data['value'] = html_escape($this->input->post('footer_link'));
		$this->db->where('key', 'footer_link');
		$this->db->update('settings', $data);

		/* $data['value'] = html_escape($this->input->post('website_keywords'));
		$this->db->where('key', 'website_keywords');
		$this->db->update('settings', $data);
 */
		$data['value'] = html_escape($this->input->post('website_description'));
		$this->db->where('key', 'website_description');
		$this->db->update('settings', $data);

		/* $data['value'] = html_escape($this->input->post('student_email_verification'));
		$this->db->where('key', 'student_email_verification');
		$this->db->update('settings', $data);

		$data['value'] = html_escape($this->input->post('course_accessibility'));
		$this->db->where('key', 'course_accessibility');
		$this->db->update('settings', $data); */
		return true;
	}
}
