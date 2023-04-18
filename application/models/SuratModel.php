<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuratModel extends CI_Model
{

    public function getAll($filter = [])
    {
        $ses = $this->session->userdata();

        $this->db->select("si.*, s.nama_satuan,  p.nama as nama_pegawai, cs.nama current_dispo_nama ");
        $this->db->from('surat_masuk as si');
        $this->db->join('surat_masuk_dispos sm', 'sm.id_surat_masuk = si.id_surat_masuk', 'LEFT');
        $this->db->join('users p', 'p.id = si.user_input', 'LEFT');
        $this->db->join('users cs', 'cs.id = si.current_dispo', 'LEFT');
        $this->db->join('satuan s', 'si.id_satuan = s.id_satuan', 'LEFT');
        $this->db->join('roles ro', 'ro.id_role = p.id_role', 'LEFT');
        if (!empty($filter['id_pegawai'])) $this->db->where('si.user_input', $filter['id_pegawai']);
        if (!empty($filter['id_pengganti'])) $this->db->where('si.id_pengganti', $filter['id_pengganti']);
        if (!empty($filter['id_surat_masuk'])) $this->db->where('si.id_surat_masuk', $filter['id_surat_masuk']);
        if (!empty($filter['disposisi'])) {
            $ses_data = $this->session->userdata();
            if ($ses_data['level'] == 1) {
            }
        }

        $res = $this->db->get();

        return  DataStructure::keyValue($res->result_array(), 'id_surat_masuk');
    }
    function cek_nomor($data)
    {
        // die();
        $s1 = 0;
        if ($data['jen_izin'] == 2) {
            $this->db->where('id_satuan', $data['id_satuan']);
            $satuan = $this->db->get('satuan')->result_array()[0]['kode_surat'];
            $s3 = $satuan . '/' . substr($data['tanggal_pengajuan'], 0, 4);
            $s1 =  858;

            if ($data['id_satuan'] == 120) {
                $s3 = 'Dinkes/' . substr($data['tanggal_pengajuan'], 0, 4);
            }
        } else {
            $s3 = 'Dinkes/' . substr($data['tanggal_pengajuan'], 0, 4);
            if ($data['jenis_izin'] == 11) {
                $s1 =  851;
            } else  if ($data['jenis_izin'] == 12) {
                $s1 =  853;
            } else  if ($data['jenis_izin'] == 13) {
                $s1 =  854;
            } else  if ($data['jenis_izin'] == 14) {
                $s1 =  857;
            } else  if ($data['jenis_izin'] == 15) {
                $s1 =  852;
            }
        }
        $no_arr = [851, 853, 854, 857, 852, 858];
        // echo json_encode($data);
        // die();
        // $this->db->where('id_satuan', $data['id_satuan']);
        // $satuan = $this->db->get('satuan')->result_array()[0]['kode_surat'];
        // $s3 = 'Dinkes/' . substr($data['tanggal_pengajuan'], 0, 4);

        $this->db->select('no_spc , SUBSTRING_INDEX(SUBSTRING_INDEX(no_spc,"/",2),"/",-1) as x, SUBSTRING_INDEX(no_spc,"/",1),SUBSTRING_INDEX(no_spc,"/",-2)');
        $this->db->from('surat_masuk');
        // $this->db->where('no_spt <> ""');
        $this->db->where('SUBSTRING_INDEX(no_spc,"/",-2)', $s3);

        // if ($data['jen_izin'] == 2) {
        //     if($data['id_satuan'])
        //     $this->db->where('SUBSTRING_INDEX(no_spc,"/",1)', $s1);
        // } else {
        $this->db->where_in('SUBSTRING_INDEX(no_spc,"/",1)', $no_arr);
        // }
        $this->db->order_by('CAST( x AS UNSIGNED INTEGER)', 'DESC');
        $this->db->limit(1);
        $res = $this->db->get();
        // echo $this->db->last_query();
        // die();
        $res = $res->result_array();
        // echo json_encode($res);
        // die();
        if (!empty($res)) {
            $num['spc'] = $s1 . '/' . ($res[0]['x'] + 1) . '/' . $s3;
        } else {
            $num['spc'] = $s1 . '/' . '1/' . $s3;
        }
        return $num;
        // echo json_encode($num);
        // die();
        // echo $num;
    }

    public function addLogs($data)
    {
        $this->db->insert('surat_masuk_logs', $data);
        // $this->db->set('status_izin', $data['status_izin']);
        // $this->db->where('id_surat_masuk', $data['id_surat_masuk']);
        // $this->db->update('surat_masuk');
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Logs", "Surat Izin");
    }

    function sign($user, $title)
    {
        if (empty($user['signature']))
            throw new UserException('Kamu belum upload tanda tangan!');
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

    public function delete($data)
    {
        // $this->db->set('status', $st);
        // echo $data['id_surat_masuk'];
        $this->db->where('id_surat_masuk', $data['id_surat_masuk']);
        $this->db->where('id_pegawai', $data['id_pegawai']);
        $this->db->where('status_izin <> 99');
        $this->db->delete('surat_masuk');
    }

    public function delete_adm($data)
    {
        $this->db->where('id_surat_masuk', $data['id_surat_masuk']);
        $this->db->delete('surat_masuk');
    }

    public function add_masuk($data)
    {
        $this->db->trans_begin();

        $data['tanggal_entry'] = date('Y-m-d');
        $this->db->insert('surat_masuk', DataStructure::slice($data, [
            'tanggal_entry', 'user_input', 'id_satuan', 'id_bagian', 'id_seksi', 'tanggal_surat',
            'nomor_surat', 'dari', 'kepada', 'file_surat', 'current_dispo'
        ], FALSE));

        if ($this->db->error()['code']) {
            $error = $this->db->error();
        }
        $id = $this->db->insert_id();

        if (!empty($data['current_dispo'])) {
            $data['notif'] = [
                'id_pegawai' => $data['current_dispo'],
                'message' => 'Terdapat Surat Masuk ditujukan kepada anda.',
                'url' => 'Surat/detail_surat_masuk/' . $id,
                'notif_time' => date('Y-m-d H:i:s')
            ];
        }
        $this->db->insert('notif', DataStructure::slice($data['notif'], [
            'id_pegawai', 'message', 'url', 'notif_time'
        ], FALSE));

        if ($this->db->error()['code']) {
            $error = $this->db->error();
        }

        $data['tanggal_dispo'] = date('Y-m-d');
        $dataDispo = [
            'id_pegawai_after' => $data['current_dispo'],
            'id_pegawai_before' => $this->session->userdata('id'),
            'id_surat_masuk' =>  $id,
            'notif_time' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('surat_masuk_dispos', DataStructure::slice($data, [
            'id_surat_masuk', 'id_pegawai_before', 'id_pegawai_after',
            'catatan_dispo'
        ], FALSE));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            ExceptionHandler::handleDBError($error, "Disposisi", "Surat Masuk");
        } else {
            $this->db->trans_commit();
            return $id;
        }
        // return
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

        $this->db->where('id_surat_masuk', $data['id_surat_masuk']);
        $this->db->update('surat_masuk',);


        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return  $data['id_surat_masuk'];
    }

    public function edit_adm($data)
    {

        $this->db->set(DataStructure::slice($data, [
            'id_pegawai', 'id_pengganti', 'jenis_izin', 'alasan', 'tanggal_pengajuan', 'periode_start', 'periode_end', 'lama_izin', 'status_izin', 'alamat_izin',
            'c_sisa_n', 'c_sisa_n1', 'c_sisa_n2', 'c_n', 'c_n1', 'c_n2', 'lampiran',
            'id_seksi', 'id_bagian', 'id_satuan', 'atasan_1',  'atasan_2',  'atasan_3',  'atasan_4', 'no_spc'
        ], FALSE));

        $this->db->where('id_surat_masuk', $data['id_surat_masuk']);
        $this->db->update('surat_masuk',);


        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return  $data['id_surat_masuk'];
    }

    public function action_disposisi($data)
    {

        $this->db->trans_begin();

        $this->db->set('current_dispo', $data['id_pegawai_after']);
        $this->db->where('id_surat_masuk', $data['id_surat_masuk']);
        $this->db->update('surat_masuk');

        if ($this->db->error()['code']) {
            $error = $this->db->error();
        }

        $data['tanggal_dispo'] = date('Y-m-d');
        $this->db->insert('surat_masuk_dispos', DataStructure::slice($data, [
            'id_surat_masuk', 'id_pegawai_before', 'id_pegawai_after',
            'catatan_dispo'
        ], FALSE));

        if ($this->db->error()['code']) {
            $error = $this->db->error();
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            ExceptionHandler::handleDBError($error, "Disposisi", "Surat Masuk");
        } else {
            $this->db->trans_commit();
            return $data['id_surat_masuk'];
        }
    }
}
