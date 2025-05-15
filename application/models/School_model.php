<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class School_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id = null)
	{

		$this->db->select()->from('schools');
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

		// echo $this->db->last_query();
		// exit();
	}

	public function add($data)
	{
		if (isset($data['id'])) {
			$this->db->where('id', $data['id']);
			$this->db->update('schools', $data);
		} else {
			$this->db->insert('schools', $data);
		}
		return true;
	}

	/* function update()
	{
	} */

	public function get_by_id($id)
	{
		$this->db->select();
		$this->db->from('schools');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('schools');
	}
	/* function delete($id)
	{
		$this->db->query("delete from schools where id='" . $id . "'");
	} */
}
