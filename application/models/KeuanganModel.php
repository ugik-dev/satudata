<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KeuanganModel extends CI_Model
{

    public function action_anggaran($data)
    {
        $data['id_satuan'] = $this->session->userdata('id_satuan');
        if (!empty($data['id_anggaran'])) {
            $this->db->where('id_anggaran', $data['id_anggaran']);
            $this->db->update('kode_anggaran', DataStructure::slice($data, [
                'id_satuan', 'id_ppk', 'jen_ppk', 'id_pptk', 'user_input', 'input_date', 'target_anggaran', 'nama_anggaran', 'kode_rekening', 'pembebanan_anggaran', 'id_bagian', 'anggaran_status'
            ], FALSE));
            ExceptionHandler::handleDBError($this->db->error(), "Tambah Kode Anggaran", "Kode Anggaran");
            return $data['id_anggaran'];
        } else {
            $this->db->insert('kode_anggaran', DataStructure::slice($data, [
                'id_satuan', 'id_ppk', 'jen_ppk', 'id_pptk', 'user_input', 'input_date', 'target_anggaran', 'nama_anggaran', 'kode_rekening', 'pembebanan_anggaran', 'id_bagian', 'anggaran_status'
            ], FALSE));
            ExceptionHandler::handleDBError($this->db->error(), "Edit Kode Anggaran", "Kode Anggaran");
            return $this->db->insert_id();
        }
    }
}
