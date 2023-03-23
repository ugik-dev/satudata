<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengumumanModel extends CI_Model
{

    public function getAll($filter = [])
    {
        if (!empty($filter['detail'])) {
            if ($filter['detail'] == true)
                $detail = true;
            else
                $detail = false;
        } else {
            $detail = false;
        }

        if ($detail) {
            $this->db->select('p.*, s.nama_satuan,s2.nama_satuan untuk_nama_satuan, u.nama as nama_user');
        } else {
            $this->db->select('id_pengumuman, judul, ,tanggal,sampul, s.nama_satuan,s2.nama_satuan untuk_nama_satuan, nama as nama_user');
        }

        $this->db->from('pengumuman p');
        $this->db->join('satuan s', 'p.id_satuan = s.id_satuan', 'LEFT');
        $this->db->join('satuan s2', 'p.untuk_satuan = s2.id_satuan', 'LEFT');
        $this->db->join('users u', 'p.id_user = u.id', 'LEFT');
        if (!empty($filter['id_pengumuman'])) $this->db->where('p.id_pengumuman', $filter['id_pengumuman']);
        $res = $this->db->get();
        return  DataStructure::keyValue($res->result_array(), 'id_pengumuman');
    }

    public function add($data)
    {
        $data['tanggal'] = date('Y-m-d');
        $this->db->insert('pengumuman', DataStructure::slice($data, [
            'judul', 'sampul', 'pdf', 'id_user', 'id_satuan', 'tanggal', 'pengumuman_isi', 'untuk_satuan'
        ], FALSE));

        ExceptionHandler::handleDBError($this->db->error(), "Tambah Pengumuman", "Pengumuman");
        $id = $this->db->insert_id();
        return $id;
    }
}
