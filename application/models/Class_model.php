<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Class_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		//$this->current_class = $this->setting_model->getCurrentclass();
	}


	public function get($id = null)
	{
		$this->db->select()->from('classes');
		if ($id != null) {
			$this->db->where('id', $id);
		} else {
			$this->db->order_by('id');
		}
		$query = $this->db->get();
		if ($id != null) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}
	}
	public function add($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('classes', $data);
		} else {
			$this->db->insert('classes', $data);
		}
		return true;
	}
	public function get_by_id($id)
	{
		$this->db->select();
		$this->db->from('classes');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getName($id)
	{
		$this->db->select('class')->from('classes');
		$this->db->order_by('id');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('classes');
	}
}
