<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SPPDModel extends CI_Model
{

    public function getAllSPPD($filter = [])
    {
        $this->db->select("un.approval_id_user as id_unapproval , r.*,t.nama_tr as nama_transport, s.nama as nama_pegawai, s.jabatan jabatan_pegawai, s.pangkat_gol as pangkat_gol_pegawai,s.id_bidang as id_bidang_pegawai, s.id_bagian as id_bagian_pegawai, s.nip nip_pegawai ,p.nama as nama_ppk, p.jabatan jabatan_ppk, p.pangkat_gol as pangkat_gol_ppk, p.nip nip_ppk , u.*, d.nama_dasar");
        $this->db->from('sppd as u');
        $this->db->join('tujuan r', 'u.id_spd = r.id_sppd');
        $this->db->join('users p', 'p.id = u.id_ppk', 'LEFT');
        $this->db->join('users s', 's.id = u.id_pegawai', 'LEFT');
        $this->db->join('approval un', 'u.unapprove_oleh = un.id_approval', 'LEFT');
        $this->db->join('transport t', 't.transport = u.transport', 'LEFT');
        $this->db->join('dasar d', 'd.id_dasar = u.id_dasar', 'LEFT');
        if (!empty($filter['id_spd'])) $this->db->where('u.id_spd', $filter['id_spd']);
        if (!empty($filter['my_perjadin'])) $this->db->where('u.id_pegawai', $this->session->userdata()['id']);

        // var_dump($this->session->userdata()['level']);
        if ($this->session->userdata()['level'] == 2) {
            $this->db->where('s.id_bagian', $this->session->userdata()['id_bagian']);
        }
        $res = $this->db->get();
        // print($this->db->last_query());
        // echo json_encode($res->result_array());
        // die();

        return DataStructure::SPPDStyle($res->result_array());
    }

    public function getDasar($id)
    {
        $this->db->select("*");
        $this->db->from('dasar_tambahan as u');
        $this->db->where('u.id_sppd', $id);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_dasar_tambahan');
    }

    public function getPengikut($id)
    {
        $this->db->select("u.*, s.nama as nama_pengikut, jabatan jabatan_pengikut, pangkat_gol pangkat_gol_pengikut, nip nip_pengikut");
        $this->db->from('pengikut as u');
        $this->db->join('users as s', 'u.id_pegawai = s.id');
        $this->db->where('u.id_sppd', $id);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_pengikut');
    }


    public function addSPPD($data)
    {

        $ses = $this->session->userdata();
        $data['id_satuan'] = $ses['id_satuan'];
        $data['id_bidang'] = $ses['id_bidang'];
        $data['id_bagian'] = $ses['id_bagian'];
        $this->db->insert('sppd', DataStructure::slice($data, [
            'ppk', 'dasar', 'maksud', 'id_pegawai', 'transport', 'lama_dinas',
            'id_satuan', 'id_bagian', 'id_bidang', 'id_dasar'

        ], FALSE));

        $id_sppd = $this->db->insert_id();
        $i = 0;
        foreach ($data['tempat_tujuan'] as $p) {
            if (!empty($data['tempat_tujuan'][$i]) or !empty($data['tempat_kembali'][$i]) or !empty($data['date_berangkat'][$i]) or !empty($data['date_kembali'][$i])) {
                $d_tujuan = array(
                    'id_sppd' => $id_sppd,
                    'tempat_tujuan' => $data['tempat_tujuan'][$i],
                    'tempat_kembali' => $data['tempat_kembali'][$i],
                    'date_berangkat' => $data['date_berangkat'][$i],
                    'date_kembali' => $data['date_kembali'][$i],
                    'ke' => $i + 1,
                );
                $this->db->insert('tujuan', $d_tujuan);
            }
            $i++;
        }

        if (!empty($data['pengikut']))
            foreach ($data['pengikut'] as $p) {
                $d_pengikut = array(
                    'id_sppd' => $id_sppd,
                    'id_pegawai' => $p,
                );
                $this->db->insert('pengikut', $d_pengikut);
            }

        if (!empty($data['dasar_tambahan']))
            foreach ($data['dasar_tambahan'] as $p) {
                $d_pengikut = array(
                    'id_sppd' => $id_sppd,
                    'dasar_tambahan' => $p,
                );
                $this->db->insert('dasar_tambahan', $d_pengikut);
            }

        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return $id_sppd;
    }


    public function editSPPD($data)
    {

        $ses = $this->session->userdata();
        $data['id_satuan'] = $ses['id_satuan'];
        $data['id_bidang'] = $ses['id_bidang'];
        $data['id_bagian'] = $ses['id_bagian'];
        $this->db->set(DataStructure::slice($data, [
            'ppk', 'dasar', 'maksud', 'id_pegawai', 'transport', 'lama_dinas',
            'id_satuan', 'id_bagian', 'id_bidang', 'id_dasar'

        ], FALSE));

        $this->db->where('id_spd', $data['id_spd']);
        $this->db->update('sppd',);

        $id_sppd = $data['id_spd'];
        $i = 0;
        foreach ($data['tempat_tujuan'] as $p) {
            $d_tujuan = array(
                'id_sppd' => $id_sppd,
                'tempat_tujuan' => $data['tempat_tujuan'][$i],
                'tempat_kembali' => $data['tempat_kembali'][$i],
                'date_berangkat' => $data['date_berangkat'][$i],
                'date_kembali' => $data['date_kembali'][$i],
                'ke' => $i + 1,
            );

            if (!empty($data['tempat_tujuan'][$i]) and !empty($data['tempat_kembali'][$i]) and !empty($data['date_berangkat'][$i]) and !empty($data['date_kembali'][$i]) and empty($data['id_tujuan'][$i])) {
                $this->db->insert('tujuan', $d_tujuan);
            } else
            if (!empty($data['tempat_tujuan'][$i]) and !empty($data['tempat_kembali'][$i]) and !empty($data['date_berangkat'][$i]) and !empty($data['date_kembali'][$i]) and !empty($data['id_tujuan'][$i])) {
                $this->db->set($d_tujuan);
                $this->db->where('id_tujuan', $data['id_tujuan'][$i]);
                $this->db->update('tujuan');
            } else if (!empty($data['id_tujuan'][$i])) {
                $this->db->where('id_tujuan', $data['id_tujuan'][$i]);
                $this->db->delete('tujuan');
            }
            $i++;
        }
        $this->db->where('id_sppd', $id_sppd);
        $this->db->delete('pengikut');
        if (!empty($data['pengikut']))
            foreach ($data['pengikut'] as $p) {
                $d_pengikut = array(
                    'id_sppd' => $id_sppd,
                    'id_pegawai' => $p,
                );
                $this->db->insert('pengikut', $d_pengikut);
            }
        $j = 0;
        if (!empty($data['dasar_tambahan']))
            foreach ($data['dasar_tambahan'] as $p) {
                if (empty($data['id_dasar_tambahan'][$j]) and !empty($data['dasar_tambahan'][$j])) {
                    $d_pengikut = array(
                        'id_sppd' => $id_sppd,
                        'dasar_tambahan' => $p,
                    );
                    $this->db->insert('dasar_tambahan', $d_pengikut);
                } else  if (!empty($data['id_dasar_tambahan'][$j]) and !empty($data['dasar_tambahan'][$j])) {
                    $d_pengikut = array(
                        'dasar_tambahan' => $p,
                    );
                    $this->db->set('dasar_tambahan', $data['dasar_tambahan'][$j]);
                    $this->db->where('id_dasar_tambahan', $data['id_dasar_tambahan'][$j]);
                    $this->db->update('dasar_tambahan');
                    // echo  !empty($data['dasar_tambahan'][$j]);
                    // echo  $data['dasar_tambahan'][$j];
                    // die();
                } else if (!empty($data['id_dasar_tambahan'][$j]) and empty($data['dasar_tambahan'][$j])) {
                    $this->db->where('id_dasar_tambahan', $data['id_dasar_tambahan'][$j]);
                    $this->db->delete('dasar_tambahan');
                }
                $j++;
            }

        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return $id_sppd;
    }

    public function approv($data)
    {

        $ses = $this->session->userdata();
        $data_approv = array(
            'approval_title' => $ses['jabatan'],
            'approval_name' => $ses['nama'],
            'approval_nip' => $ses['nip'],
            'approval_pangkat' => $ses['pangkat_gol'],
            'approval_id_user' => $ses['id'],
            'approval_signature	' => $ses['signature'],
            'id_spd	' => $data['id_spd'],
            'aksi	' => 'approv',
        );
        $this->db->set($data_approv);
        $this->db->insert('approval');
        $id = $this->db->insert_id();
        if ($ses['level'] == 2) {
            $this->db->set('approve_kasi', $id);
            $this->db->set('status', '1');
        }

        $this->db->where('id_spd', $data['id_spd']);
        $this->db->update('sppd',);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");
    }


    public function unapprov($data)
    {

        $ses = $this->session->userdata();
        $data_approv = array(
            'approval_title' => $ses['jabatan'],
            'approval_name' => $ses['nama'],
            'approval_nip' => $ses['nip'],
            'approval_pangkat' => $ses['pangkat_gol'],
            'approval_id_user' => $ses['id'],
            'approval_signature	' => $ses['signature'],
            'id_spd	' => $data['id_spd'],
            'aksi	' => 'unapprov',
        );
        $this->db->set($data_approv);
        $this->db->insert('approval');
        $id = $this->db->insert_id();
        if ($ses['level'] == 2) {
            $this->db->set('unapprove_oleh', $id);
            $this->db->set('status', '1');
        }

        $this->db->where('id_spd', $data['id_spd']);
        $this->db->update('sppd',);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");
    }


    public function undo($data)
    {

        $ses = $this->session->userdata();
        $data_approv = array(
            'approval_title' => $ses['jabatan'],
            'approval_name' => $ses['nama'],
            'approval_nip' => $ses['nip'],
            'approval_pangkat' => $ses['pangkat_gol'],
            'approval_id_user' => $ses['id'],
            'approval_signature	' => $ses['signature'],
            'id_spd	' => $data['id_spd'],
            'aksi	' => 'cancel',
        );
        $this->db->set($data_approv);
        $this->db->insert('approval');
        $id = $this->db->insert_id();
        if ($ses['level'] == 2) {
            $this->db->set('approve_kasi', NULL);
            $this->db->set('unapprove_oleh', NULL);
            $this->db->set('status', '0');
        }

        $this->db->where('id_spd', $data['id_spd']);
        $this->db->update('sppd',);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");
    }

    public function deleteDasarTambahan($data)
    {
        $this->db->where('id_dasar_tambahan', $data['id_dasar_tambahan']);
        $this->db->delete('dasar_tambahan');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus Dasar Tambahan", "Tambahan");
    }
}
