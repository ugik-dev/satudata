<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsenModel extends CI_Model
{

    public function getLocation($filter = [])
    {
        // $this->db->select("u.*,pen.nama as nama_penilai, count(r.id_skp) as skp");
        $this->db->from('absen_location as u');

        // if (!empty($filter['id_skp'])) $this->db->where('u.id_skp', $filter['id_skp']);
        // if (!empty($filter['my_skp'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        // 
        return  DataStructure::keyValue($res->result_array(), 'id_location');
    }



    public function record($data)
    {
        $this->db->insert('absensi', DataStructure::slice($data, [
            'id_pegawai', 'file_foto', 'lokasi', 'longitude', 'latitude'
        ], FALSE));

        return $this->db->insert_id();
    }

    // public function edit($data)
    // {

    //     $id_user = $this->session->userdata()['id'];
    //     $res_data['periode_start'] = $data['periode_start'];
    //     $res_data['periode_end'] = $data['periode_end'];
    //     $res_data['tgl_pengajuan'] = $data['tgl_pengajuan'];
    //     $res_data['id_penilai'] = $data['id_penilai'];
    //     $res_data['id_user'] = $id_user;
    //     $this->db->set(DataStructure::slice($data, [
    //         'date', 'id_user', 'id_penilai', 'periode_start', 'periode_end', 'tgl_pengajuan', 'status'
    //     ], FALSE));

    //     $this->db->where('id_skp', $data['id_skp']);
    //     $this->db->update('skp',);



    //     return $id_spt;
    // }
}
