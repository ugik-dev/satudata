<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DasarModel extends CI_Model
{

    public function action_dasar($data)
    {
        $data['id_satuan'] = $this->session->userdata('id_satuan');
        if (!empty($data['id_dasar'])) {
            $this->db->where('id_dasar', $data['id_dasar']);
            $this->db->update('dasar', DataStructure::slice($data, [
                'id_satuan', 'id_ppk2', 'jen_ppk', 'id_pptk', 'user_dasar', 'input_date', 'nama_dasar', 'kode_rekening', 'pembebanan_anggaran', 'id_bagian', 'dasar_status'
            ], FALSE));
            ExceptionHandler::handleDBError($this->db->error(), "Tambah Dasar", "Dasar");
            return $data['id_dasar'];
        } else {
            $this->db->insert('dasar', DataStructure::slice($data, [
                'id_satuan', 'id_ppk2', 'jen_ppk', 'id_pptk', 'user_dasar', 'input_date', 'nama_dasar', 'kode_rekening', 'pembebanan_anggaran', 'id_bagian', 'dasar_status'
            ], FALSE));
            ExceptionHandler::handleDBError($this->db->error(), "Edit Dasar", "Dasar");
            return $this->db->insert_id();
        }
    }

    public function delete_dasar($data)
    {
        $this->db->where('id_dasar', $data['id_dasar']);
        $this->db->delete('dasar');
    }
}
