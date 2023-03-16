<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SatuanModel extends CI_Model
{

    public function action_satuan($data)
    {
        // $data['id_satuan'] = $this->session->userdata('id_satuan');
        if (!empty($data['id_satuan'])) {
            $this->db->where('id_satuan', $data['id_satuan']);
            $this->db->update('satuan', DataStructure::slice($data, [
                'jen_satker', 'nama_satuan', 'nama_satuan2', 'nama_dinas', 'alamat', 'alamat_lengkap', 'kode_pos', 'email', 'no_tlp', 'website', 'kode_surat', 'ktrngn', 'satuan_tempat', 'bendahara', 'bendahara_pem', 'bendahara_pem_blud', 'verif_cuti'
            ], FALSE));
            ExceptionHandler::handleDBError($this->db->error(), "Tambah Dasar", "Dasar");
            return $data['id_satuan'];
        } else {
            $this->db->insert('satuan', DataStructure::slice($data, [
                'jen_satker', 'nama_satuan', 'nama_satuan2', 'nama_dinas', 'alamat', 'alamat_lengkap', 'kode_pos', 'email', 'no_tlp', 'website', 'kode_surat', 'ktrngn', 'satuan_tempat', 'bendahara', 'bendahara_pem', 'verif_cuti', 'bendahara_pem_blud',
            ], FALSE));
            ExceptionHandler::handleDBError($this->db->error(), "Edit Dasar", "Dasar");
            return $this->db->insert_id();
        }
    }
}
