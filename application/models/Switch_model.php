<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Switch_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id = null)
	{
		$this->db->select()->from('switches');
		if ($id != null) {
			$this->db->where('switches.id', $id);
		} else {
			$this->db->order_by('switches.id');
		}
		$query = $this->db->get();
		if ($id != null) {
			return $query->row_array();
		} else {
			return $query->result();
		}
	}
	function getSwitch()
	{
		$this->db->select()->from('switches');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function add($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('subjects', $data);
			return true;
		} else {
			$this->db->insert('switches', $data);
			return $this->db->insert_id();
		}
	}

	public function changeStatus($data)
	{

		$this->db->where("id", $data["id"])->update("switches", $data);
	}

	public function getswitchByModulename($module_name)
	{

		$sql = "select is_active from switches where short_code='" . $module_name . "'";

		$query = $this->db->query($sql);
		return $query->row_array();
	}
	function getAdmission()
	{
		$this->db->select()->from('switches');
		$this->db->where("id", 1);
		$query = $this->db->get();
		return $query->row();
	}
	function getPayment()
	{
		$this->db->select()->from('switches');
		$this->db->where("id", 3);
		$query = $this->db->get();
		return $query->row();
	}
	function getCourseReg()
	{
		$this->db->select()->from('switches');
		$this->db->where("id", 2);
		$query = $this->db->get();
		return $query->row();
	}
	function getLateReg()
	{
		$this->db->select()->from('switches');
		$this->db->where("id", 4);
		$query = $this->db->get();
		return $query->row();
	}
	function getExamsCard()
	{
		$this->db->select()->from('switches');
		$this->db->where("id", 6);
		$query = $this->db->get();
		return $query->row();
	}
	function getExamsUpload()
	{
		$this->db->select()->from('switches');
		$this->db->where("id", 5);
		$query = $this->db->get();
		return $query->row();
	}
	function getPaymentMethod()
	{
		$this->db->select()->from('switches');
		$this->db->where("id", 7);
		$query = $this->db->get();
		return $query->row();
	}

	/* function update()
	{
	} */
}
