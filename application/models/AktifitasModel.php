<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AktifitasModel extends CI_Model
{

    public function getAllAktifitas($filter = [])
    {
        $this->db->select("u.*, count(r.id_aktifitas) as aktifitas");
        $this->db->from('aktifitas as u');
        $this->db->join('aktifitas_child r', 'u.id_aktifitas = r.id_aktifitas');
        $this->db->join('users p', 'p.id = u.id_user');
        $this->db->group_by('id_aktifitas');

        if (!empty($filter['tahun']))
            $this->db->where('YEAR(u.date)', $filter['tahun']);
        if (!empty($filter['bulan']))
            $this->db->where('MONTH(u.date)', $filter['bulan']);
        if (!empty($filter['id_aktifitas'])) $this->db->where('u.id_aktifitas', $filter['id_aktifitas']);
        if (!empty($filter['my_aktifitas'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        // 
        return  DataStructure::keyValue($res->result_array(), 'id_aktifitas');

        // return DataStructure::AktifitasStyle($res->result_array());
    }


    public function getAllAktifitasDetail($filter = [])
    {
        $this->db->select("u.*,r.*,p.*,sc.jenis_keg, sc.kegiatan as kegiatan_skp");
        $this->db->from('aktifitas as u');
        $this->db->join('aktifitas_child r', 'u.id_aktifitas = r.id_aktifitas');
        $this->db->join('skp_child sc', 'r.id_skp_child = sc.id_skp_child', 'LEFT');
        $this->db->join('users p', 'p.id = u.id_user');

        if (!empty($filter['tahun']))
            $this->db->where('YEAR(u.date)', $filter['tahun']);
        if (!empty($filter['bulan']))
            $this->db->where('MONTH(u.date)', $filter['bulan']);
        if (!empty($filter['id_aktifitas'])) $this->db->where('u.id_aktifitas', $filter['id_aktifitas']);
        if (!empty($filter['my_aktifitas'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        // 
        return DataStructure::AktifitasStyle($res->result_array());
    }

    public function printLaporanAktifitasHarian($filter = [])
    {
        $this->db->select("u.*,r.*,p.*,sc.jenis_keg, sc.kegiatan as kegiatan_skp");
        $this->db->from('aktifitas as u');
        $this->db->join('aktifitas_child r', 'u.id_aktifitas = r.id_aktifitas');
        $this->db->join('skp_child sc', 'r.id_skp_child = sc.id_skp_child', 'LEFT');
        $this->db->join('users p', 'p.id = u.id_user');
        $this->db->order_by('u.date');
        if (!empty($filter['tahun']))
            $this->db->where('YEAR(u.date)', $filter['tahun']);
        if (!empty($filter['bulan']))
            $this->db->where('MONTH(u.date)', $filter['bulan']);

        if (!empty($filter['id_aktifitas'])) $this->db->where('u.id_aktifitas', $filter['id_aktifitas']);
        if (!empty($filter['id_user']))
            $this->db->where('u.id_user', $filter['id_user']);
        $res = $this->db->get();
        return DataStructure::printLaporanHarian($res->result_array());
    }

    public function edit($data)
    {

        $id_user = $this->session->userdata()['id'];
        $res_data['date'] = $data['date'];
        $res_data['id_user'] = $id_user;
        $this->db->where('id_aktifitas', $data['id_aktifitas']);
        $this->db->update('aktifitas', DataStructure::slice($res_data, [
            'date', 'id_user'
        ], FALSE));

        // $id_aktifitas = $this->db->insert_id();
        $i = 0;

        foreach ($data['jn_skp'] as $p) {
            if (!empty($data['jn_skp'][$i]) or !empty($data['satuan'][$i]) or !empty($data['vol'][$i])) {
                $d_tujuan = array(
                    'id_aktifitas' => $data['id_aktifitas'],
                    'kegiatan_aktifitas' => $data['kegiatan_aktifitas'][$i],
                    // 'jenis' => $data['jenis'][$i],
                    'vol' => $data['vol'][$i],
                    'satuan' => $data['satuan'][$i],
                );
                if ($data['jn_skp'][$i] != 'non_skp' && !empty($data['jn_skp'][$i])) {
                    $d_tujuan['id_skp_child'] = $data['jn_skp'][$i];
                } else
                    $d_tujuan['id_skp_child'] = NULL;

                if (!empty($data['id_aktifitas_child'][$i])) {

                    $this->db->where('id_aktifitas_child', $data['id_aktifitas_child'][$i]);
                    $this->db->update('aktifitas_child', $d_tujuan);
                } else
                    $this->db->insert('aktifitas_child', $d_tujuan);
            }
            if (!empty($data['id_aktifitas_child'][$i]) && empty($data['kegiatan_aktifitas'][$i]) && empty($data['satuan'][$i]) && empty($data['vol'][$i])) {
                $this->db->where('id_aktifitas_child', $data['id_aktifitas_child'][$i]);
                $this->db->delete('aktifitas_child');
            }
            $i++;
        }
    }

    public function add($data)
    {

        $id_user = $this->session->userdata()['id'];
        $res_data['date'] = $data['date'];
        $res_data['id_user'] = $id_user;
        $this->db->insert('aktifitas', DataStructure::slice($res_data, [
            'date', 'id_user'
        ], FALSE));

        $id_aktifitas = $this->db->insert_id();
        $i = 0;

        foreach ($data['jn_skp'] as $p) {
            if (!empty($data['jn_skp'][$i]) or !empty($data['satuan'][$i]) or !empty($data['vol'][$i])) {
                $d_tujuan = array(
                    'id_aktifitas' => $id_aktifitas,
                    'kegiatan_aktifitas' => $data['kegiatan_aktifitas'][$i],
                    // 'jenis' => $data['jenis'][$i],
                    'vol' => $data['vol'][$i],
                    'satuan' => $data['satuan'][$i],
                );
                if ($data['jn_skp'][$i] != 'non_skp' && !empty($data['jn_skp'][$i])) {

                    $d_tujuan['id_skp_child'] = $data['jn_skp'][$i];
                    // echo 'ss';
                    // die();
                } else
                    $d_tujuan['id_skp_child'] = NULL;
                $this->db->insert('aktifitas_child', $d_tujuan);
            }
            $i++;
        }
    }
}
