<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuratIzinModel extends CI_Model
{

    public function CekJadwal($data = [], $start, $end, $ex_id = '')
    {
        $data['pengikut'][] = $data['id_pegawai'];
        $this->db->select('u.*, us.nama, r.nama_izin');
        $this->db->from('surat_izin as u');
        $this->db->join('users as us', 'u.id_pegawai = us.id');
        $this->db->join('ref_jen_izin as r', 'u.jenis_izin = r.id_ref_jen_izin');
        $this->db->where_in('id_pegawai', $data['pengikut']);
        // $this->db->where('u.unapprove is null');
        // $this->db->where("(u.periode_start >='$start' AND u.periode_end <= '$end')");

        $this->db->where("(
        periode_start BETWEEN '$start' AND '$end' OR 
        periode_end BETWEEN '$start' AND '$end' OR
        '$start' BETWEEN periode_start AND periode_end OR
        '$end' BETWEEN periode_start AND periode_end 
        )");

        $res1 = $this->db->get()->result_array();

        // echo $this->db->last_query();
        if (!empty($res1))
            throw new UserException("{$res1[0]['nama']} Sedang {$res1[0]['nama_izin']} pada tanggal {$res1[0]['periode_start']} s.d. {$res1[0]['periode_end']} dengan NO Surat {$res1[0]['no_spc']} ", UNAUTHORIZED_CODE);
        // echo json_encode(['error' => true, 'message' => '', 'data' => $res1]);
        // die();
    }

    public function CekLastTahunan($id)
    {
        $this->db->from('surat_izin as si');
        $this->db->where('id_pegawai', $id);
        $this->db->where('jenis_izin', 11);
        $this->db->where('status_izin', 99);
        $this->db->order_by('id_surat_izin', "DESC");
        $this->db->limit(1);

        $res = $this->db->get()->result_array();
        return $res;
    }

    public function cekSisaPegawai($id)
    {
        $this->db->select('sum(lama_izin) AS x');
        $this->db->from('surat_izin as si');
        $this->db->where('id_pegawai', $id);
        // $this->db->where('kategori', 1);
        $this->db->where('YEAR(periode_start)', date('Y'));
        // $this->db->where('status_izin <> 99');
        $this->db->where('unapprove is null');
        // $this->db->where('jenis_izin <> 1');
        $this->db->order_by('id_pegawai', "DESC");
        $this->db->limit(1);

        $res = $this->db->get()->result_array()[0];
        return $res;
    }

    public function RiwayatApproval($id)
    {
        $this->db->select('si.* , u.nama');
        $this->db->from('surat_izin_logs as si');
        $this->db->join('users u ', 'si.id_user = u.id');
        $this->db->where('id_si', $id);
        // $this->db->where('status_izin', 99);
        $this->db->order_by('time_logs', "DESC");
        // $this->db->limit(1);

        $res = $this->db->get()->result_array();
        return $res;
    }

    public function getAll($filter = [])
    {
        $ses = $this->session->userdata();
        // echo json_encode($filter);
        // die();
        $this->db->select("si.*, s.nama_satuan,pu.nama unapprove_nama, r.nama_izin,s.verif_cuti,s.jen_satker, r.jen_izin,ro.level level_pegawai, p.nama as nama_pegawai, pg.nama as nama_pengganti");
        if (!empty($filter['detail'])) {
            $this->db->select('
            p.nip nip_pegawai,
            p.pangkat_gol pangkat_gol_pegawai,
            p.jabatan jabatan_pegawai,
            p.signature signature_pegawai,
            p.tmt_kerja,
            p.no_hp,
            pg.nip nip_pengganti,
            pg.pangkat_gol pangkat_gol_pengganti,
            pg.jabatan jabatan_pengganti');
        }
        $this->db->from('surat_izin as si');
        $this->db->join('ref_jen_izin r', 'si.jenis_izin = r.id_ref_jen_izin');
        $this->db->join('users p', 'p.id = si.id_pegawai', 'LEFT');
        $this->db->join('satuan s', 'si.id_satuan = s.id_satuan', 'LEFT');
        $this->db->join('roles ro', 'ro.id_role = p.id_role', 'LEFT');
        $this->db->join('users pg', 'pg.id = si.id_pengganti', 'LEFT');
        $this->db->join('users pu', 'pu.id = si.unapprove', 'LEFT');
        if (!empty($filter['search_approval']['data_penilai'])) {
            $penilai =  $filter['search_approval']['data_penilai'];
            if ($penilai['level'] == 6) {
                $this->db->where("si.id_pengganti =  {$penilai['id']} OR (s.verif_cuti = {$penilai['id']}  && si.status_izin in (10, 11,15) )");
            }
            if ($penilai['level'] == 5) {
                $this->db->where("si.id_pengganti =  {$penilai['id']} OR si.id_seksi = {$penilai['id_seksi']}");
            }
            // die();
            if ($penilai['level'] == 4 || $penilai['level'] == 3) {
                if ($penilai['id_bagian'] == 2) {
                    $this->db->where("(si.status_izin in (11,14,15,6,99) OR (si.id_bagian = 2 and si.status_izin in (2,10)))");
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("(si.status_izin = 11 OR (si.id_bagian = 2 and si.status_izin = 2) and si.unapprove IS NULL)");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where("(si.status_izin in (14,15,6,99) OR (si.id_bagian = 2 and si.status_izin > 2))");
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            $this->db->where('si.status_izin = 99');
                        } else if ($filter['status_permohonan'] == 'ditolak') {
                            $this->db->where('si.unapprove', $penilai['id_bagian']);
                        }
                    }
                } else {
                    $this->db->where("si.id_bagian =  {$penilai['id_bagian']} and si.status_izin in (2,10,11,14,15,6,99)");
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("(si.status_izin = 2 and si.unapprove IS NULL)");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where("si.status_izin > 2 ");
                            // } else if ($filter['status_permohonan'] == 'ditolak') {
                            //     $this->db->where('u.status = 98');
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            $this->db->where('si.status_izin = 99');
                        } else if ($filter['status_permohonan'] == 'ditolak') {
                            $this->db->where('si.unapprove', $penilai['id_bagian']);
                        }
                    }
                }
            }
            if ($penilai['level'] == 2) {

                $this->db->where("si.status_izin in (11,14,15,6,99) ");
                if (!empty($filter['status_permohonan'])) {
                    if ($filter['status_permohonan'] == 'menunggu-saya') {
                        $this->db->where("(si.status_izin = 14 and si.unapprove IS NULL)");
                    } else if ($filter['status_permohonan'] == 'my-approv') {
                        $this->db->where("si.status_izin > 14 ");
                        // } else if ($filter['status_permohonan'] == 'ditolak') {
                        //     $this->db->where('u.status = 98');
                    } else if ($filter['status_permohonan'] == 'selesai') {
                        $this->db->where('si.status_izin = 99');
                    } else if ($filter['status_permohonan'] == 'ditolak') {
                        $this->db->where('si.unapprove', $penilai['id_bagian']);
                    }
                }
            }
            if ($penilai['level'] == 1) {

                $this->db->where("si.status_izin in (15,6,99)");
                if (!empty($filter['status_permohonan'])) {
                    if ($filter['status_permohonan'] == 'menunggu-saya') {
                        $this->db->where("(si.status_izin = 15 and si.unapprove IS NULL)");
                    } else if ($filter['status_permohonan'] == 'my-approv') {
                        $this->db->where("si.status_izin = 99 ");
                        // } else if ($filter['status_permohonan'] == 'ditolak') {
                        //     $this->db->where('u.status = 98');
                    } else if ($filter['status_permohonan'] == 'selesai') {
                        $this->db->where('si.status_izin = 99');
                    } else if ($filter['status_permohonan'] == 'ditolak') {
                        $this->db->where('si.unapprove', $penilai['id_bagian']);
                    }
                }
            }

            if ($penilai['level'] == 8) {
                $this->db->where("si.id_pengganti =  {$penilai['id']} OR si.status_izin in ( 50, 51,10,11,14,15,99)");
                $this->db->where('si.id_satuan', $penilai['id_satuan']);
                // die();
                if (!empty($filter['status_permohonan'])) {
                    if ($filter['status_permohonan'] == 'menunggu-saya') {
                        $this->db->where("si.status_izin = 50 OR (si.id_pengganti =  {$penilai['id']} AND si.status_izin = 0)");
                    } else if ($filter['status_permohonan'] == 'approv') {
                        $this->db->where("si.status_izin in ( 51, 10,11,14,15,99) OR (si.id_pengganti =  {$penilai['id']} AND si.status_izin = 0)");
                        $this->db->where('si.status_izin <> 98');
                    }
                }
            } else if ($penilai['level'] == 7) {
                // $this->db->where("(d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                $this->db->where("si.id_pengganti =  {$penilai['id']} OR si.status_izin in (51, 52, 10, 11,14,15,99)");
                $this->db->where('si.id_satuan', $penilai['id_satuan']);
                // die();
                if (!empty($filter['status_permohonan'])) {
                    if ($filter['status_permohonan'] == 'menunggu-saya') {
                        $this->db->where("si.status_izin = 51 OR (si.id_pengganti =  {$penilai['id']} AND si.status_izin = 0)");
                    } else if ($filter['status_permohonan'] == 'approv') {
                        $this->db->where("si.status_izin in ( 10, 11,14,15,99) OR (si.id_pengganti =  {$penilai['id']} AND si.status_izin > 0)");
                        $this->db->where('si.status_izin <> 98');
                    }
                }
            }
            // $this->db->or_where("si.id_pengganti =  {$penilai['id']} ");
            if (!empty($filter['chk-surat-izin']) or !empty($filter['chk-surat-cuti']) or !empty($filter['chk-lembur'])) {
                $jen = [];
                if (!empty($filter['chk-surat-izin'])) {
                    $jen[] = 2;
                    $jen[] = 3;
                }
                if (!empty($filter['chk-surat-cuti']))
                    $jen[] = 1;
                // if (!empty($filter['chk-lembur']))
                //     $jen[] = 3;
                $this->db->where_in('r.jen_izin', $jen);
            }
        }
        if (!empty($filter['dari']) && !empty($filter['sampai'])) {
            $start = $filter['dari'];
            $end = $filter['sampai'];
            $this->db->where("(
                si.periode_start BETWEEN '$start' AND '$end' OR 
                si.periode_end BETWEEN '$start' AND '$end' OR
            '$start' BETWEEN  si.periode_start  AND  si.periode_end OR
            '$end' BETWEEN  si.periode_start  AND  si.periode_end  
            )");
        }
        if (!empty($filter['id_satuan'])) $this->db->where('si.id_satuan', $filter['id_satuan']);
        if (!empty($filter['jen_izin'])) $this->db->where('r.jen_izin', $filter['jen_izin']);
        if (!empty($filter['jenis_izin'])) $this->db->where('si.jenis_izin', $filter['jenis_izin']);
        if (!empty($filter['status_rekap'])) {
            if ($filter['status_rekap'] == 'selesai') {
                $this->db->where('si.status_izin', 99);
            } else if ($filter['status_rekap'] == 'ditolak') {
                $this->db->where('si.unapprove is not null');
            }
        }
        if (!empty($filter['id_pegawai'])) $this->db->where('si.id_pegawai', $filter['id_pegawai']);
        if (!empty($filter['id_pengganti'])) $this->db->where('si.id_pengganti', $filter['id_pengganti']);
        if (!empty($filter['id_surat_izin'])) $this->db->where('si.id_surat_izin', $filter['id_surat_izin']);
        $res = $this->db->get();

        return  DataStructure::keyValue($res->result_array(), 'id_surat_izin');
    }
    function cek_nomor($data)
    {
        // die();
        $s1 = 0;
        if ($data['jen_izin'] == 2 || $data['jen_izin'] == 3) {
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
        $this->db->from('surat_izin');
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
        if (!empty($data['no_spc'])) $this->db->set('no_spc', $data['no_spc']);
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

    public function delete($data)
    {
        // $this->db->set('status', $st);
        // echo $data['id_surat_izin'];
        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->where('id_pegawai', $data['id_pegawai']);
        $this->db->where('status_izin <> 99');
        $this->db->delete('surat_izin');
    }

    public function delete_adm($data)
    {
        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->delete('surat_izin');
    }

    public function unapprov($data, $usr)
    {
        $this->db->set('unapprove', $usr);
        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin',);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Surat Izin", "Surat Izin");
    }

    public function undo($data, $usr)
    {
        if ($data['unapprove'] == $usr) {
            $this->db->set('unapprove', null);
        }
        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin',);
        ExceptionHandler::handleDBError($this->db->error(), "Undo Surat Izin", "Surat Izin");
    }

    public function add($data)
    {
        $data['tanggal_pengajuan'] = date('Y-m-d');
        $this->db->insert('surat_izin', DataStructure::slice($data, [
            'id_pegawai', 'id_pengganti', 'jenis_izin', 'alasan', 'tanggal_pengajuan', 'periode_start', 'periode_end', 'lama_izin', 'status_izin', 'alamat_izin',
            'c_sisa_n', 'c_sisa_n1', 'c_sisa_n2', 'c_n', 'c_n1', 'c_n2', 'lampiran', 'kategori',
            'id_seksi', 'id_bagian', 'id_satuan', 'atasan_1',  'atasan_2',  'atasan_3',  'atasan_4',
        ], FALSE));
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
            'date', 'id_user', 'id_penilai', 'periode_start', 'periode_end', 'tgl_pengajuan', 'status', 'kategori'
        ], FALSE));

        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin',);


        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return  $data['id_surat_izin'];
    }

    public function edit_adm($data)
    {

        $this->db->set(DataStructure::slice($data, [
            'id_pegawai', 'id_pengganti', 'jenis_izin', 'alasan', 'tanggal_pengajuan', 'periode_start', 'periode_end', 'lama_izin', 'status_izin', 'alamat_izin',
            'c_sisa_n', 'c_sisa_n1', 'c_sisa_n2', 'c_n', 'c_n1', 'c_n2', 'lampiran', 'kategori',
            'id_seksi', 'id_bagian', 'id_satuan', 'atasan_1',  'atasan_2',  'atasan_3',  'atasan_4', 'no_spc'
        ], FALSE));

        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin',);


        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return  $data['id_surat_izin'];
    }

    public function approv_verif($data)
    {


        // echo json_encode($data);
        // die();
        $this->db->set(DataStructure::slice($data, [
            'periode_start', 'periode_end', 'status_izin', 'lama_izin', 'c_n', 'c_n1', 'c_n2', 'c_sisa_n', 'c_sisa_n1', 'c_sisa_n2', 'verif', 'cttn_verif', 'verif_sub', 'cttn_verif_sub', 'unapprove'
        ], FALSE));

        $this->db->where('id_surat_izin', $data['id_surat_izin']);
        $this->db->update('surat_izin',);


        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return  $data['id_surat_izin'];
    }
}
