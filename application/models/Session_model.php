<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Session_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		//$this->current_session = $this->setting_model->getCurrentSession();
	}

	public function get($id = null)
	{
		$this->db->select()->from('sessions');
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

	public function remove($id)
	{
		$this->db->trans_begin();
		$this->db->where('id', $id);
		$this->db->delete('sessions'); //class record delete.

		$this->db->where('session_id', $id);
		$this->db->delete('session_semesters'); //class_sections record delete.

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return TRUE;
	}
	public function add($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('sessions', $data);
		} else {
			$this->db->insert('sessions', $data);
		}

		return true;
	}
	public function get_by_id($id)
	{
		$this->db->select();
		$this->db->from('sessions');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('sessions');
	}
}
