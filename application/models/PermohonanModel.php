<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PermohonanModel extends CI_Model
{

    public function getAll($filter = [])
    {
        $this->db->select("u.*,pen.nama as nama_penilai,p.nama as nama_pengaju, count(r.id_skp) as skp");
        $this->db->from('skp as u');
        $this->db->join('skp_child r', 'u.id_skp = r.id_skp');
        $this->db->join('users p', 'p.id = u.id_user');
        $this->db->join('users pen', 'pen.id = u.id_penilai');
        $this->db->group_by('id_skp');
        $this->db->where('u.status <> 0');
        if (!empty($filter['id_skp'])) $this->db->where('u.id_skp', $filter['id_skp']);
        if (!empty($filter['id_penilai'])) $this->db->where('u.id_penilai', $filter['id_penilai']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        // 
        return  DataStructure::keyValue($res->result_array(), 'id_skp');
    }
}
