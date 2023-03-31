<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model
{


    public function  getLiveChat($filter = [])
    {
        $this->db->select('lc.* , nama , u.photo photo_user');
        $this->db->from('live_chat as lc');
        $this->db->join('users as u', 'lc.id_user = u.id');
        // if (!empty($filter['last_id']))
        if (isset($filter['last_id'])) {
            if ($filter['last_id'] == 0) {
                $this->db->where('id_chat > ', $filter['last_id']);
                $this->db->order_by('id_chat', 'DESC');
                $this->db->limit('5');
                // $this->db->offside('5');
            } else {
                $this->db->where('id_chat > ', $filter['last_id']);
            }
        }
        if (isset($filter['loadmore_id'])) {
            // if ($filter['last_id'] == 0) {
            $this->db->where('id_chat <', $filter['loadmore_id']);
            $this->db->order_by('id_chat', 'desc');
            $this->db->limit('5');
            // $this->db->offside('5');
            // } else {
            //     $this->db->where('id_chat > ', $filter['last_id']);
            // }
        }
        $res = $this->db->get();
        ExceptionHandler::handleDBError($this->db->error(), "Edit Dasar", "Dasar");

        $res = $res->result_array();
        $res =   DataStructure::keyValue($res, 'id_chat');
        return $res;
    }
    public function getInfoSPT($filter = [])
    {

        $this->db->select('count(*) as jml, sat.nama_satuan');
        $this->db->from('spt as s');
        $this->db->join('satuan as sat', 's.id_satuan = sat.id_satuan');
        // $this->db->where('status', 99);
        $this->db->group_by('s.id_satuan');
        $res = $this->db->get();
        ExceptionHandler::handleDBError($this->db->error(), "Edit Dasar", "Dasar");
        $res = $res->result_array();
        $data['nama'] = [];
        $data['jml'] = [];
        foreach ($res as $r) {
            if (!empty($r['jml'])) {
                $data['nama'][] = $r['nama_satuan'];
                $data['jml'][] = $r['jml'];
            }
        }
        return $data;
    }

    public function send_live_chat($data)
    {
        $data['time_chat'] = date('Y-m-d h:i:s');
        $this->db->insert('live_chat', DataStructure::slice($data, [
            'id_user', 'text', 'time_chat'
        ], FALSE));

        ExceptionHandler::handleDBError($this->db->error(), "Live Chat", "Live Chat");
        $id = $this->db->insert_id();
        return $id;
    }
}