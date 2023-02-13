<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuratIzinModel extends CI_Model
{

    public function getAll($filter = [])
    {
        $this->db->select("si.*, r.nama_izin, p.nama as nama_pegawai, pg.nama as nama_pengganti");
        $this->db->from('surat_izin as si');
        $this->db->join('ref_jen_izin r', 'si.jenis_izin = r.id_ref_jen_izin');
        $this->db->join('users p', 'p.id = si.id_pegawai');
        $this->db->join('users pg', 'pg.id = si.id_pengganti', 'LEFT');
        // $this->db->join('users pen', 'pen.id = u.id_penilai');
        // $this->db->group_by('id_surat_izin');

        if (!empty($filter['id_pegawai'])) $this->db->where('u.id_pegawai', $filter['id_pegawai']);
        if (!empty($filter['id_pengganti'])) $this->db->where('u.id_pengganti', $filter['id_pengganti']);
        // if (!empty($filter['my_surat_izin'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        // 
        return  DataStructure::keyValue($res->result_array(), 'id_surat_izin');
    }
    public function getJenisSuratIzin($filter = [])
    {
        $this->db->select("*");
        $this->db->from('jenissurat_izin as u');
        // $this->db->join('surat_izin_child r', 'u.id_surat_izin = r.id_surat_izin');
        // $this->db->join('users p', 'p.id = u.id_user');
        // $this->db->join('users pen', 'pen.id = u.id_penilai');
        // $this->db->group_by('id_surat_izin');

        // if (!empty($filter['id_surat_izin'])) $this->db->where('u.id_surat_izin', $filter['id_surat_izin']);
        // if (!empty($filter['my_surat_izin'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        // 
        return  DataStructure::keyValue($res->result_array(), 'id_jenissurat_izin');
    }

    public function getDetail($filter = [])
    {
        // $this->db->select("r.*, p.*, u.*, surat_izin_a.kegiatan as kegiatan_atasan,pen.nama as nama_penilai, ");
        // $this->db->from('surat_izin as u');
        // $this->db->join('surat_izin_child r', 'u.id_surat_izin = r.id_surat_izin');
        // $this->db->join('surat_izin_child surat_izin_a', 'surat_izin_a.id_surat_izin_child = r.id_surat_izin_atasan', 'LEFT');
        // $this->db->join('users p', 'p.id = u.id_user');
        // $this->db->join('users pen', 'pen.id = u.id_penilai');
        // if (!empty($filter['id_surat_izin'])) $this->db->where('u.id_surat_izin', $filter['id_surat_izin']);
        // if (!empty($filter['my_surat_izin'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        // $res = $this->db->get();
        // // echo json_encode($res->result_array());
        // // die();
        // // 
        // return DataStructure::SKPStyle($res->result_array());
    }

    public function ajukan_approv($data)
    {
        // $this->db->insert('surat_izin_approv', $data);
        $this->db->set('status', 1);
        $this->db->where('id_surat_izin', $data);
        $this->db->update('surat_izin');
    }

    public function approv($data)
    {
        $this->db->insert('surat_izin_approv', $data);
        $this->db->set('status', 2);
        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin');
    }

    public function edit_approv($data, $st)
    {
        $this->db->set('status', $st);
        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin');
    }

    public function delete_approv($data)
    {
        // $this->db->set('status', $st);
        // echo $data['id_surat_izin'];
        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->delete('surat_izin_approv');
    }

    public function deleteMySKP($data)
    {
        // $this->db->set('status', $st);
        // echo $data['id_surat_izin'];
        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->delete('surat_izin');

        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->delete('surat_izin_child');

        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->delete('surat_izin_approv');
    }

    public function add($data)
    {
        // $data['data'] = $ses['id_satuan'];
        // $data['id_seksi'] = $ses['id_seksi'];
        $data['tanggal_pengajuan'] = date('Y-m-d');
        $this->db->insert('surat_izin', DataStructure::slice($data, [
            'id_pegawai', 'id_pengganti', 'jenis_izin', 'alasan', 'tanggal_pengajuan', 'periode_start', 'periode_end', 'lama_izin', 'status_izin',
            'c_sisa_n', 'c_sisa_n1', 'c_sisa_n2', 'c_n', 'c_n1', 'c_n2',
            'id_seksi', 'id_bagian', 'id_satuan', 'atasan_1',  'atasan_2',  'atasan_3',  'atasan_4',
        ], FALSE));
        // echo $this->db->last_query();
        // // echo json_encode($data);
        // die();
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Surat Izin", "Surat Izin");
        return $this->db->insert_id();
    }

    public function edit($data)
    {

        $id_user = $this->session->userdata()['id'];
        $res_data['periode_start'] = $data['periode_start'];
        $res_data['periode_end'] = $data['periode_end'];
        $res_data['tgl_pengajuan'] = $data['tgl_pengajuan'];
        $res_data['id_penilai'] = $data['id_penilai'];
        $res_data['id_user'] = $id_user;
        $this->db->set(DataStructure::slice($data, [
            'date', 'id_user', 'id_penilai', 'periode_start', 'periode_end', 'tgl_pengajuan', 'status'
        ], FALSE));

        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin',);


        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return  $data['id_surat_izin'];
    }
}
