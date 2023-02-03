<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CutiModel extends CI_Model
{

    public function getAll($filter = [])
    {
        $this->db->select("*");
        $this->db->from('cuti as u');
        // $this->db->join('cuti_child r', 'u.id_cuti = r.id_cuti');
        // $this->db->join('users p', 'p.id = u.id_user');
        // $this->db->join('users pen', 'pen.id = u.id_penilai');
        // $this->db->group_by('id_cuti');

        // if (!empty($filter['id_cuti'])) $this->db->where('u.id_cuti', $filter['id_cuti']);
        // if (!empty($filter['my_cuti'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        // 
        return  DataStructure::keyValue($res->result_array(), 'id_cuti');
    }
    public function getJenisCuti($filter = [])
    {
        $this->db->select("*");
        $this->db->from('jeniscuti as u');
        // $this->db->join('cuti_child r', 'u.id_cuti = r.id_cuti');
        // $this->db->join('users p', 'p.id = u.id_user');
        // $this->db->join('users pen', 'pen.id = u.id_penilai');
        // $this->db->group_by('id_cuti');

        // if (!empty($filter['id_cuti'])) $this->db->where('u.id_cuti', $filter['id_cuti']);
        // if (!empty($filter['my_cuti'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        // 
        return  DataStructure::keyValue($res->result_array(), 'id_jeniscuti');
    }

    public function getDetail($filter = [])
    {
        // $this->db->select("r.*, p.*, u.*, cuti_a.kegiatan as kegiatan_atasan,pen.nama as nama_penilai, ");
        // $this->db->from('cuti as u');
        // $this->db->join('cuti_child r', 'u.id_cuti = r.id_cuti');
        // $this->db->join('cuti_child cuti_a', 'cuti_a.id_cuti_child = r.id_cuti_atasan', 'LEFT');
        // $this->db->join('users p', 'p.id = u.id_user');
        // $this->db->join('users pen', 'pen.id = u.id_penilai');
        // if (!empty($filter['id_cuti'])) $this->db->where('u.id_cuti', $filter['id_cuti']);
        // if (!empty($filter['my_cuti'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        // $res = $this->db->get();
        // // echo json_encode($res->result_array());
        // // die();
        // // 
        // return DataStructure::SKPStyle($res->result_array());
    }

    public function ajukan_approv($data)
    {
        // $this->db->insert('cuti_approv', $data);
        $this->db->set('status', 1);
        $this->db->where('id_cuti', $data);
        $this->db->update('cuti');
    }

    public function approv($data)
    {
        $this->db->insert('cuti_approv', $data);
        $this->db->set('status', 2);
        $this->db->where('id_cuti', $data['id_cuti']);
        $this->db->update('cuti');
    }

    public function edit_approv($data, $st)
    {
        $this->db->set('status', $st);
        $this->db->where('id_cuti', $data['id_cuti']);
        $this->db->update('cuti');
    }

    public function delete_approv($data)
    {
        // $this->db->set('status', $st);
        // echo $data['id_cuti'];
        $this->db->where('id_cuti', $data['id_cuti']);
        $this->db->delete('cuti_approv');
    }

    public function deleteMySKP($data)
    {
        // $this->db->set('status', $st);
        // echo $data['id_cuti'];
        $this->db->where('id_cuti', $data['id_cuti']);
        $this->db->delete('cuti');

        $this->db->where('id_cuti', $data['id_cuti']);
        $this->db->delete('cuti_child');

        $this->db->where('id_cuti', $data['id_cuti']);
        $this->db->delete('cuti_approv');
    }

    public function add($data)
    {
        $id_user = $this->session->userdata()['id'];
        // $data['data'] = $ses['id_satuan'];
        // $data['id_seksi'] = $ses['id_seksi'];
        $res_data['periode_start'] = $data['periode_start'];
        $res_data['periode_end'] = $data['periode_end'];
        $res_data['tgl_pengajuan'] = $data['tgl_pengajuan'];
        $res_data['id_penilai'] = $data['id_penilai'];
        $res_data['id_user'] = $id_user;
        $this->db->insert('cuti', DataStructure::slice($res_data, [
            'date', 'id_user', 'id_penilai', 'periode_start', 'periode_end', 'tgl_pengajuan'
        ], FALSE));

        $id_cuti = $this->db->insert_id();
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

        $this->db->where('id_cuti', $data['id_cuti']);
        $this->db->update('cuti',);


        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return  $data['id_cuti'];
    }
}
