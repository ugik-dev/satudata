<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model
{

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
}
