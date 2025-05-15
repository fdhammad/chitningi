<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Certificate_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->current_session = current_session();
    }

    public function getcertificatebyid($certificate)
    {
        $this->db->select('*');
        $this->db->from('certificates');
        $this->db->where('id', $certificate);
        $query = $this->db->get();
        return $query->result();
    }
}
