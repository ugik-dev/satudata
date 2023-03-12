<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsenModel extends CI_Model
{

    public function getAllAbsensiM2($filter = [], $sort = true)
    {
        if ($this->session->userdata('id_satuan') == 1) {
            // $this->db->select('id_satuan,nama_satuan');
            // $this->db->from('satuan as p');
            $this->db->from('bagian as b', 'p.');
            $this->db->where_in('jenis_bagian', [1, 2, 3, 4]);
            $this->db->order_by('jenis_bagian');
        }

        $satuan = $this->db->get()->result_array();

        foreach ($satuan as $key => $s) {

            $filter['id_bagian'] = $s['id_bagian'];
            $satuan[$key]['pegawai'] =
                $this->getAllAbsensi($filter, $sort);
        };
        // $this->db->result_array();
        // $satuan =   DataStructure::keyValue($this->db->get()->result_array(), 'id_bagian');
        // echo json_encode($satuan);
        // die();
        return $satuan;

        // $this->getAllAbsensi($filter[])
    }
    public function getAllAbsensi($filter = [], $sort = true)
    {
        $this->db->select('p.nama,p.id, p.jabatan, p.nip');
        $this->db->from('users as p');
        if (!empty($filter['id_pegawai'])) $this->db->where('p.id', $filter['id_pegawai']);
        if (!empty($filter['id_bagian'])) $this->db->where('p.id_bagian', $filter['id_bagian']);

        $pegawai = $this->db->get();
        $pegawai =   DataStructure::keyValue($pegawai->result_array(), 'id');
        $ptmp = [];
        foreach ($pegawai as $p) {
            array_push($ptmp, $p['id']);
        }

        $this->db->from('absensi as c');
        if (!empty($filter['tanggal'])) $this->db->where('date(rec_time)', $filter['tanggal']);
        if (!empty($filter['bulan'])) $this->db->where('month(rec_time)', $filter['bulan']);

        // echo json_encode($ptmp);
        // die();
        if (!empty($ptmp))
            $this->db->where_in('id_pegawai', $ptmp);
        else {
            $this->db->where(false);
        }
        $res =  $this->db->get();
        // echo $this->db->last_query();
        // die();
        // if ($filter['id_bagian'] == 7) {
        //     echo json_encode($res->result_array());
        //     die();
        // }
        $res =  DataStructure::absensi_rekap($pegawai, $res->result_array(), $sort);

        return $res;
    }


    public function getLocation($filter = [])
    {
        // $this->db->select("u.*,pen.nama as nama_penilai, count(r.id_skp) as skp");
        $this->db->from('absen_location as u');

        if (!empty($filter['id_satuan'])) $this->db->where('u.id_satuan', $filter['id_satuan']);
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
            'id_pegawai', 'file_foto', 'lokasi', 'longitude', 'latitude', 'st_absen', 'jenis'
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
