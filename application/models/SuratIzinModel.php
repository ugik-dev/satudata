<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuratIzinModel extends CI_Model
{

    public function getAll($filter = [])
    {
        $ses = $this->session->userdata();
        // echo json_encode($filter);
        // die();

        $this->db->select("si.*, r.nama_izin,s.verif_cuti, r.jen_izin,ro.level level_pegawai, p.nama as nama_pegawai, pg.nama as nama_pengganti");
        $this->db->from('surat_izin as si');
        $this->db->join('ref_jen_izin r', 'si.jenis_izin = r.id_ref_jen_izin');
        $this->db->join('users p', 'p.id = si.id_pegawai', 'LEFT');
        $this->db->join('satuan s', 'si.id_satuan = s.id_satuan', 'LEFT');
        $this->db->join('roles ro', 'ro.id_role = p.id_role', 'LEFT');
        $this->db->join('users pg', 'pg.id = si.id_pengganti', 'LEFT');
        if (!empty($filter['search_approval']['data_penilai'])) {
            $penilai =  $filter['search_approval']['data_penilai'];
            if ($penilai['level'] == 6)
                $this->db->where("si.id_pengganti =  {$penilai['id']} OR (s.verif_cuti = {$penilai['id']}  && si.status_izin in (10, 11,15) )");
            if ($penilai['level'] == 5)
                $this->db->where("si.id_seksi =  {$penilai['id_seksi']}");
            if ($penilai['level'] == 4 || $penilai['level'] == 3)
                if ($penilai['id_bagian'] == 2)
                    $this->db->where("((si.id_bagian =  {$penilai['id_bagian']} and si.status_izin in (2,3,4,5,6)) OR status_izin = 11)");
                else
                    $this->db->where("si.id_bagian =  {$penilai['id_bagian']} and si.status_izin in (2,3,4,5,6)");
            if ($penilai['level'] == 2)
                $this->db->where("si.status_izin in (3,10,15,6,99)");
            if ($penilai['level'] == 1)
                $this->db->where("si.status_izin in (15,6,99)");
            if ($penilai['level'] == 8) {
                // $this->db->where("(d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                $this->db->where('si.status_izin = 50');
                $this->db->where('si.id_satuan', $penilai['id']);
                // die();
                if (!empty($filter['status_permohonan'])) {
                    if ($filter['status_permohonan'] == 'menunggu') {
                        $this->db->where('u.status', 50);
                    } else if ($filter['status_permohonan'] == 'approv') {
                        $this->db->where('u.status > 51');
                        $this->db->where('u.status <> 98');
                    }
                }
            } else
            if ($penilai['level'] == 7) {
                // $this->db->where("(d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                $this->db->where('si.status_izin = 51');
                $this->db->where('si.id_satuan', $penilai['id']);
                // die();
                if (!empty($filter['status_permohonan'])) {
                    if ($filter['status_permohonan'] == 'menunggu') {
                        $this->db->where('u.status', 51);
                    } else if ($filter['status_permohonan'] == 'approv') {
                        $this->db->where('u.status > 51');
                        $this->db->where('u.status <> 98');
                    }
                }
            }
            // $this->db->or_where("si.id_pengganti =  {$penilai['id']} ");
            if (!empty($filter['chk-surat-izin']) or !empty($filter['chk-surat-cuti']) or !empty($filter['chk-lembur'])) {
                $jen = [];
                if (!empty($filter['chk-surat-izin']))
                    $jen[] = 1;
                if (!empty($filter['chk-surat-cuti']))
                    $jen[] = 2;
                // if (!empty($filter['chk-lembur']))
                //     $jen[] = 3;
                $this->db->where_in('r.jen_izin', $jen);
            }
        }

        if (!empty($filter['id_pegawai'])) $this->db->where('si.id_pegawai', $filter['id_pegawai']);
        if (!empty($filter['id_pengganti'])) $this->db->where('si.id_pengganti', $filter['id_pengganti']);
        if (!empty($filter['id_surat_izin'])) $this->db->where('si.id_surat_izin', $filter['id_surat_izin']);
        // if (!empty($filter['my_surat_izin'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();

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
        // echo json_encode($this->session->userdata());
        // die();
        if (!empty($filter['id_surat_izin'])) $this->db->where('u.id_surat_izin', $filter['id_surat_izin']);
        if (!empty($filter['my_surat_izin'])) $this->db->where('u.id_user', $this->session->userdata()['id']);
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



    public function approv($data, $sign = [])
    {
        // $this->db->insert('surat_izin_approv', $data);
        $this->db->set('status_izin', $data['status_izin']);
        if (!empty($sign['kadin'])) $this->db->set('sign_kadin', $sign['kadin']);
        if (!empty($sign['atasan'])) $this->db->set('sign_atasan', $sign['atasan']);
        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin');
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Surat Izin", "Surat Izin");
    }
    public function addLogs($data)
    {
        $this->db->insert('surat_izin_logs', $data);
        // $this->db->set('status_izin', $data['status_izin']);
        // $this->db->where('id_surat_izin', $data['id_surat_izin']);
        // $this->db->update('surat_izin');
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Logs", "Surat Izin");
    }

    function sign($user, $title)
    {
        $sign = array(
            'sign_title' => $title,
            'sign_name' => $user['nama'],
            'sign_nip' => $user['nip'],
            'sign_pangkat' => $user['pangkat_gol'],
            'sign_id_user' => $user['id'],
            'sign_signature	' => $user['signature'],
            'aksi	' => 'approv',
        );
        $this->db->insert('sign', $sign);
        $sign_id =  $this->db->insert_id();

        return $sign_id;
    }
    public function approve_pelimpahan($data, $sign)
    {
        $this->db->set('status_izin', $data['status_izin']);
        $this->db->set('sign_pelimpahan', $sign);
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
            'c_sisa_n', 'c_sisa_n1', 'c_sisa_n2', 'c_n', 'c_n1', 'c_n2', 'lampiran',
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

    public function approv_verif($data)
    {

        $id_user = $this->session->userdata()['id'];
        if ($data['verif'] == 1) {
            $data['verif'] = $id_user;
            $data['unapprove'] = NULL;

            $data['status_izin'] = 11;
        } else {
            unset($data['verif']);
            $data['verif'] = NULL;
            $data['unapprove'] = $id_user;
            $data['status_izin'] = 10;
        }
        // echo json_encode($data);
        // die();
        $this->db->set(DataStructure::slice($data, [
            'periode_start', 'periode_end', 'status_izin', 'lama_izin', 'c_n', 'c_n1', 'c_n2', 'c_sisa_n', 'c_sisa_n1', 'c_sisa_n2', 'verif', 'cttn_verif', 'unapprove'
        ], FALSE));

        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin',);


        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return  $data['id_surat_izin'];
    }
}
