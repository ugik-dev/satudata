<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SPPDModel extends CI_Model
{
    public function getLogs($filter = [])
    {
        $this->db->select('l.*, u.nama');
        $this->db->from('spt_logs as l');
        $this->db->join('users as u', 'u.id = l.id_user');
        $this->db->order_by('time_logs', 'ASC');
        if (!empty($filter['id_spt'])) $this->db->where('l.id_spt', $filter['id_spt']);
        // if (!empty($filter['id_foto'])) $this->db->where('id_foto', $filter['id_foto']);
        return $this->db->get()->result_array();
    }
    public function getFoto($filter = [])
    {
        $this->db->select('f.*, u.nama nama_pegawai');
        $this->db->from('spt_foto as f');
        $this->db->join('users as u', 'f.id_pegawai = u.id', 'LEFT');
        if (!empty($filter['is_image'])) $this->db->where('is_image', $filter['is_image']);
        if (!empty($filter['id_spt'])) $this->db->where('id_spt', $filter['id_spt']);
        if (!empty($filter['id_foto'])) $this->db->where('id_foto', $filter['id_foto']);
        return DataStructure::keyValue($this->db->get()->result_array(), 'id_foto');;
    }
    public function getLaporan($filter = [], $sort = false)
    {
        if ($sort)
            $this->db->select('
            s.no_sppd, no_spt,u.nama as nama_bendahara,
            sl.id_laporan, sl.id_spt, lap_approve_seksi, lap_approve_kabid,lap_approve_sekdin,lap_approve_kadin,lap_approve_bendahara,id_bendahara,lap_unapprove,lap_status,timestamp_lap
            ');
        else
            $this->db->select('sl.*, u.nama as nama_bendahara');
        $this->db->from('spt_laporan sl');
        $this->db->join('spt s', 's.id_spt = sl.id_spt');
        $this->db->join('users u', 'sl.id_bendahara = u.id', 'LEFT');
        if (!empty($filter['id_spt'])) $this->db->where('sl.id_spt', $filter['id_spt']);
        if (!empty($filter['id_laporan'])) $this->db->where('sl.id_laporan', $filter['id_laporan']);
        return DataStructure::keyValue($this->db->get()->result_array(), 'id_spt');
    }  // die();

    public function getAllSPTM2($filter = [], $sort = false)
    {
        $ses = $this->session->userdata();

        $this->db->select('rjs.nama_ref_jen_spt');
        $this->db->select('sa.nama_satuan,
                            p2.nama as nama_input
                            ');
        if (!$sort) {
            $this->db->select('
            d.id_ppk2, d.id_pptk');
            $this->db->select("un.approval_id_user as id_unapproval ,
            t.nama_tr as nama_transport,
            sa.jen_satker, 
            u.*");
        } else {
            $this->db->select('sa.jen_satker, u.id_spt, u.tgl_pengajuan,u.status, u.no_spt, u.no_sppd, u.unapprove_oleh, u.id_satuan, u.id_bagian, u.id_seksi');
        }
        $this->db->from('spt as u');
        $this->db->join('satuan sa', 'sa.id_satuan = u.id_satuan');
        $this->db->join('dasar d', 'd.id_dasar = u.id_dasar', 'LEFT');
        $this->db->join('users p2', 'p2.id = u.user_input', 'LEFT');
        if (!$sort) {
            $this->db->join('users p', 'p.id = d.id_ppk2', 'LEFT');
            $this->db->join('users ptk', 'ptk.id = d.id_pptk', 'LEFT');
            $this->db->join('approval un', 'u.unapprove_oleh = un.id_approval', 'LEFT');
            $this->db->join('transport t', 't.transport = u.transport', 'LEFT');
        }
        $this->db->join('ref_jen_spt rjs', 'u.jenis = rjs.id_ref_jen_spt', 'LEFT');
        $this->db->join('tujuan tj', 'tj.id_spt = u.id_spt', 'LEFT');
        $this->db->join('pengikut pk', 'pk.id_spt = u.id_spt', 'LEFT');
        $this->db->group_by('id_spt');


        $res = $this->db->get()->result_array();
        $res_id = [];
        // echo json_encode($sort);
        // die();

        foreach ($res as $rid) {
            array_push($res_id, $rid['id_spt']);
        }
        if (!empty($res_id)) {
            // if (!$sort) {
            //     $this->db->select('p.*, u.nama, u.nip, u.jabatan,u.pangkat_gol, tanggal_lahir, r.level');
            // } else {
            //     $this->db->select('p.id_spt, u.nama, r.level');
            // }

            $this->db->from('pengikut p ');
            $this->db->where_in('id_spt', $res_id);
            $pengikut = DataStructure::groupingByParent($this->db->get()->result_array(), 'id_spt');
            if (!$sort) {
                $this->db->select('*');
            } else {
                $this->db->select('id_spt,date_berangkat,date_kembali,tempat_tujuan');
            }
            $this->db->from('tujuan');
            $this->db->order_by('ke', 'ASC');
            $this->db->where_in('id_spt', $res_id);
            $tujuan = DataStructure::groupingByParent($this->db->get()->result_array(), 'id_spt');
        } else {
            $tujuan = [];
            $pengikut = [];
        }
        return DataStructure::SPPDStyle2($res, $tujuan, $pengikut);
    }

    private function search($filter, $ses, $penilai)
    {
        if (!empty($filter['dari']) && !empty($filter['sampai'])) $this->db->where(' (
            (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" ) OR
            (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" )
        )
        ');
        if (!empty($filter['id_spt'])) $this->db->where('u.id_spt', $filter['id_spt']);
        // $this->db->where('u.id_spt', 24);
        if (!empty($filter['id_satuan'])) $this->db->where('u.id_satuan', $filter['id_satuan']);
        if (!empty($filter['id_bagian'])) $this->db->where('u.id_bagian', $filter['id_bagian']);
        if (!empty($filter['id_seksi'])) $this->db->where('u.id_seksi', $filter['id_seksi']);
        if (!empty($filter['my_perjadin'])) $this->db->where('( u.id_pegawai =' .  $ses['id'] . ' OR pk.id_pegawai = ' .  $ses['id'] . ' )');
        if (!empty($filter['search_approval']['data_penilai'])) {
            $penilai =  $filter['search_approval']['data_penilai'];
            if ($penilai['jen_satker'] == 1) {

                if ($penilai['level'] == 1) {
                    $this->db->where("(u.status in (12,99,98) OR unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("(u.status = 12 AND u.unapprove_oleh IS NULL) OR (d.id_ppk2 = {$penilai['id']} AND  u.status = 6)");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where("(u.status > 11 AND d.id_ppk2 = {$penilai['id']}) OR approve_kadin = {$penilai['id']}");

                            // } else if ($filter['status_permohonan'] == 'ditolak') {
                            //     $this->db->where('u.status = 98');
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            $this->db->where('u.status = 99');
                        }
                    }
                } else if ($penilai['level'] == 2) {
                    $this->db->where("(u.status in (6,11,12,99) OR unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    // $this->db->where('u.status > 3');

                    // $this->db->where('s.id_bagian', $penilai['id_bagian']);
                    // die();
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("(u.status = 11 and u.unapprove_oleh IS NULL) OR (d.id_ppk2 = {$penilai['id']} AND  u.status = 6)");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where("(u.status > 11 AND d.id_ppk2 = {$penilai['id']}) OR approve_sekdin = {$penilai['id']}");
                            // } else if ($filter['status_permohonan'] == 'ditolak') {
                            //     $this->db->where('u.status = 98');
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            $this->db->where('u.status = 99');
                        }
                    }
                } else if ($penilai['level'] == 3 or $penilai['level'] == 4) {
                    $this->db->where("(u.id_bagian = {$penilai['id_bagian']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    $this->db->where('u.status > 1');
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("((u.status = 2 AND u.id_bagian = {$penilai['id_bagian']} ) OR ( d.id_ppk2 = {$penilai['id']} AND u.status = 6) OR ( d.id_pptk = {$penilai['id']} AND u.status = 5)) and u.unapprove_oleh IS NULL");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where('u.status > 2');
                            // $this->db->where('u.status <> 98');
                        } else if ($filter['status_permohonan'] == 'ditolak') {
                            // $this->db->where('u.unapprove_oleh IS NOT NULL');
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            // $this->db->where('u.unapprove_oleh is not null');
                            $this->db->where('u.status = 99');
                        }
                    }
                } else if ($penilai['level'] == 5) {
                    $this->db->where("((u.id_seksi = {$penilai['id_seksi']} AND u.id_bagian = {$penilai['id_bagian']} ) OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    $this->db->where('u.status >= 1');
                    // echo json_encode($penilai);
                    // die();
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("((u.status = 1 AND u.id_seksi = {$penilai['id_seksi']}) OR ( d.id_pptk = {$penilai['id']} AND u.status = 5)) and u.unapprove_oleh IS NULL");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where('u.status > 1');
                            // $this->db->where('u.status <> 98');
                        } else if ($filter['status_permohonan'] == 'ditolak') {
                            // $this->db->where('u.unapprove_oleh IS NOT NULL');
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            // $this->db->where('u.unapprove_oleh is not null');
                            $this->db->where('u.status = 99');
                        }
                    }
                } else {
                    $this->db->where("(unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                }
            }

            if ($filter['status_permohonan'] == 'ditolak') {
                $this->db->where('u.unapprove_oleh is not null');
            } else
            if ($filter['status_permohonan'] == 'selesai') {
                $this->db->where('u.status = 99');
            }

            if ($penilai['jen_satker'] != 1) {
                // echo $penilai['level'];
                if ($penilai['level'] == 8) {
                    // die();
                    $this->db->where("(u.status >= 50 OR unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("(u.status = 50 OR (d.id_pptk = {$penilai['id']} AND u.status = 51))");
                        } else if ($filter['status_permohonan'] == 'approv') {
                            $this->db->where('u.status in [51,52,59,60]');
                            // $this->db->where('u.status <> 98');
                        }
                    }
                } else
                if ($penilai['level'] == 7) {
                    $this->db->where("(u.status >= 59 OR unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("(u.status = 59 OR (d.id_ppk2 = {$penilai['id']} AND u.status = 52))");
                        } else if ($filter['status_permohonan'] == 'approv') {
                            $this->db->where('u.status > 51');
                            $this->db->where('u.status <> 98');
                        }
                    }
                } else {
                    $this->db->where("(unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                }
            }

            if (!empty($filter['chk-spt']) or !empty($filter['chk-sppd']) or !empty($filter['chk-lembur'])) {
                $jen = [];
                if (!empty($filter['chk-spt']))
                    $jen[] = 1;
                if (!empty($filter['chk-sppd']))
                    $jen[] = 2;
                if (!empty($filter['chk-lembur']))
                    $jen[] = 3;
                $this->db->where_in('u.jenis', $jen);
            }
        }
        if (!empty($filter['status_rekap'])) {
            if ($filter['status_rekap'] == 'selesai') {
                $this->db->where('u.status', 99);
            } else if ($filter['status_rekap'] == 'ditolak') {
                $this->db->where('u.unapprove_oleh is not null');
            } else if ($filter['status_rekap'] == 'menunggu') {
                $this->db->where('u.unapprove_oleh is null AND u.status <> 99');
            }
        }

        if (empty($filter['qrcode'])) {
            if ($this->session->userdata('jen_satker') != 1)
                $this->db->where('u.id_satuan', $ses['id_satuan']);
        } else {
            $this->db->where('u.qrcode', $filter['qrcode']);
        }
    }
    public function getMyPerjadin($filter = [], $sort = false)
    {
        // echo json_encode($filter);
        // die();
        $this->db->db_debug = true;
        $ses = $this->session->userdata();
        $this->db->select('l.id_laporan ,u.id_spt, u.tgl_pengajuan,u.status, u.no_spt, u.no_sppd, u.maksud, u.unapprove_oleh, u.id_satuan, u.id_bagian, u.id_seksi, u.status');

        $this->db->from('spt as u');
        $this->db->join('spt_laporan l', 'l.id_spt = u.id_spt', 'LEFT');
        $this->db->join('tujuan tj', 'tj.id_spt = u.id_spt', 'LEFT');
        $this->db->group_by('id_spt');
        $this->db->where('u.id_pegawai =' .  $ses['id'] . '  ');
        if (!empty($filter['status_rekap'])) {
            if ($filter['status_rekap'] == 'semua') {
            } else if ($filter['status_rekap'] == 'ditolak') {
                $this->db->where('unapprove_oleh is not null');
            } else if ($filter['status_rekap'] == 'menunggu') {
                $this->db->where('unapprove_oleh is null AND status <> 99');
            } else if ($filter['status_rekap'] == 'selesai') {
                $this->db->where('status = 99');
            }
        }
        if (!empty($filter['status_lpd'])) {
            if ($filter['status_lpd'] == 'semua') {
            } else if ($filter['status_lpd'] == 'belum') {
                $this->db->where('l.id_laporan is  null');
            } else if ($filter['status_lpd'] == 'sudah') {
                $this->db->where('l.id_laporan is not null');
            }
        }
        if (!empty($filter['dari']) && !empty($filter['sampai'])) $this->db->where(' (
            (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" ) OR
            (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" )
        )
        ');
        $res1 = $this->db->get()->result_array();

        $this->db->select('l.id_laporan ,u.id_spt, u.tgl_pengajuan,u.status, u.no_spt, u.no_sppd, u.maksud, u.unapprove_oleh, u.id_satuan, u.id_bagian, u.id_seksi, u.status');

        $this->db->from('spt as u');
        $this->db->join('spt_laporan l', 'l.id_spt = u.id_spt', 'LEFT');
        $this->db->join('pengikut pk', 'pk.id_spt = u.id_spt', 'LEFT');
        $this->db->join('tujuan tj', 'tj.id_spt = u.id_spt', 'LEFT');
        $this->db->group_by('id_spt');
        $this->db->where(' pk.id_pegawai = ' .  $ses['id'] . ' ');
        if (!empty($filter['dari']) && !empty($filter['sampai'])) $this->db->where(' (
            (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" ) OR
            (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" )
        )
        ');
        if (!empty($filter['status_rekap'])) {
            if ($filter['status_rekap'] == 'semua') {
            } else if ($filter['status_rekap'] == 'ditolak') {
                $this->db->where('unapprove_oleh is not null');
            } else if ($filter['status_rekap'] == 'menunggu') {
                $this->db->where('unapprove_oleh is null AND status <> 99');
            } else if ($filter['status_rekap'] == 'selesai') {
                $this->db->where('status = 99');
            }
        }
        if (!empty($filter['status_lpd'])) {
            if ($filter['status_lpd'] == 'semua') {
            } else if ($filter['status_lpd'] == 'belum') {
                $this->db->where('l.id_laporan is  null');
            } else if ($filter['status_lpd'] == 'sudah') {
                $this->db->where('l.id_laporan is not null');
            }
        }
        $res2 = $this->db->get()->result_array();
        $res = array_merge($res1, $res2);
        $res_id = [];
        // die();

        foreach ($res as $rid) {
            array_push($res_id, $rid['id_spt']);
        }
        if (!empty($res_id)) {
            if (!$sort) {
                $this->db->select('*');
            } else {
                $this->db->select('id_spt,date_berangkat,date_kembali,tempat_tujuan');
            }
            $this->db->from('tujuan');
            $this->db->order_by('ke', 'ASC');
            $this->db->where_in('id_spt', $res_id);
            $tujuan = DataStructure::groupingByParent($this->db->get()->result_array(), 'id_spt');
            // echo $this->db->last_query();
            // die();
        } else {
            $tujuan = [];
        }

        return DataStructure::SPPDStyle2($res, $tujuan, null);
    }


    public function getAllSPPD($filter = [], $sort = false, $cross = false)
    {
        // die();
        $ses = $this->session->userdata();

        $this->db->select('rjs.nama_ref_jen_spt');
        $this->db->select('l.id_laporan,
                            sa.nama_satuan,
                            p2.nama as nama_input,
                            d.id_ppk2, d.id_pptk,
                            sa.jen_satker
                            ');
        if (!$sort) {
            $this->db->select('
            s.id_seksi as id_seksi_pegawai,
            s.id_bagian as id_bagian_pegawai,   
            ');

            $this->db->select(' 
            p.nama as nama_ppk,
            p.jabatan jabatan_ppk, 
            p.pangkat_gol as pangkat_gol_ppk, 
            p.nip nip_ppk');

            $this->db->select('  
            ptk.nama as nama_pptk, 
            ptk.jabatan jabatan_pptk, 
            ptk.pangkat_gol as pangkat_gol_pptk, 
            ptk.nip nip_pptk');
            $this->db->select('
            d.kode_rekening,
            d.nama_dasar
            ');
            $this->db->select("un.approval_id_user as id_unapproval ,
            t.nama_tr as nama_transport,
            u.*");
        } else {
            $this->db->select('u.pel_nama, u.id_spt,u.maksud, u.tgl_pengajuan,u.status, u.no_spt, u.no_sppd, u.unapprove_oleh, u.id_satuan, u.id_bagian, u.id_seksi');
        }
        $this->db->from('spt as u');
        $this->db->join('satuan sa', 'sa.id_satuan = u.id_satuan');
        $this->db->join('dasar d', 'd.id_dasar = u.id_dasar', 'LEFT');
        $this->db->join('spt_laporan l', 'l.id_spt = u.id_spt', 'LEFT');
        $this->db->join('users p2', 'p2.id = u.user_input', 'LEFT');
        if (!$sort) {
            $this->db->join('users s', 's.id = u.id_pegawai', 'LEFT');
            $this->db->join('users p', 'p.id = d.id_ppk2', 'LEFT');
            $this->db->join('users ptk', 'ptk.id = d.id_pptk', 'LEFT');
            $this->db->join('approval un', 'u.unapprove_oleh = un.id_approval', 'LEFT');
            $this->db->join('transport t', 't.transport = u.transport', 'LEFT');
            $this->db->join('roles ro', 's.id_role = ro.id_role', 'LEFT');
        }
        $this->db->join('ref_jen_spt rjs', 'u.jenis = rjs.id_ref_jen_spt', 'LEFT');
        $this->db->join('tujuan tj', 'tj.id_spt = u.id_spt', 'LEFT');
        $this->db->join('pengikut pk', 'pk.id_spt = u.id_spt', 'LEFT');
        $this->db->group_by('id_spt');

        // if (!empty($filter['dari']) && !empty($filter['sampai'])) $this->db->where(' (
        //     (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" ) OR
        //     (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" )
        // )
        // ');

        if (!empty($filter['dari']) && !empty($filter['sampai'])) {
            $start = $filter['dari'];
            $end = $filter['sampai'];
            $this->db->where("(
                tj.date_berangkat BETWEEN '$start' AND '$end' OR 
                tj.date_kembali BETWEEN '$start' AND '$end' OR
            '$start' BETWEEN  tj.date_berangkat  AND  tj.date_kembali OR
            '$end' BETWEEN  tj.date_berangkat  AND  tj.date_kembali  
            )");
        }

        if (!empty($filter['id_spt'])) $this->db->where('u.id_spt', $filter['id_spt']);
        // $this->db->where('u.id_spt', 24);
        if (!empty($filter['id_satuan'])) $this->db->where('u.id_satuan', $filter['id_satuan']);
        if (!empty($filter['plh'])) {
            $this->db->where('u.plh', 'Y');
            $this->db->where('u.status', '99');
            $this->db->where('u.plh_id', $ses['id']);
        }
        if (!empty($filter['id_bagian'])) $this->db->where('u.id_bagian', $filter['id_bagian']);
        if (!empty($filter['id_seksi'])) $this->db->where('u.id_seksi', $filter['id_seksi']);
        if (!empty($filter['my_perjadin'])) $this->db->where('( u.id_pegawai =' .  $ses['id'] . ' OR pk.id_pegawai = ' .  $ses['id'] . ' )');
        if (!empty($filter['search_approval']['data_penilai'])) {
            $penilai =  $filter['search_approval']['data_penilai'];
            // echo json_encode($penilai);
            // die();
            if ($penilai['jen_satker'] == 1) {
                if ($penilai['level'] == 1) {
                    $this->db->where("(u.status in (12,99,98) OR unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("(u.status = 12 AND u.unapprove_oleh IS NULL) OR (d.id_ppk2 = {$penilai['id']} AND  u.status = 6)");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where("(u.status > 11 AND d.id_ppk2 = {$penilai['id']}) OR approve_kadin = {$penilai['id']}");

                            // } else if ($filter['status_permohonan'] == 'ditolak') {
                            //     $this->db->where('u.status = 98');
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            $this->db->where('u.status = 99');
                        }
                    }
                } else if ($penilai['level'] == 2) {
                    $this->db->where("(u.status in (6,11,12,99) OR unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    // $this->db->where('u.status > 3');

                    // $this->db->where('s.id_bagian', $penilai['id_bagian']);
                    // die();
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("u.unapprove_oleh IS NULL AND (u.status = 11 OR (d.id_ppk2 = {$penilai['id']} AND  u.status = 6))");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where("((u.status > 11 AND d.id_ppk2 = {$penilai['id']}) OR approve_sekdin = {$penilai['id']})");
                            // } else if ($filter['status_permohonan'] == 'ditolak') {
                            //     $this->db->where('u.status = 98');
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            $this->db->where('u.status = 99');
                        } else if ($filter['status_permohonan'] == 'ditolak') {
                            $this->db->where('u.unapprove_oleh', $penilai['id']);
                        }
                    }
                } else if ($penilai['level'] == 3 or $penilai['level'] == 4) {
                    $this->db->where("(u.id_bagian = {$penilai['id_bagian']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    $this->db->where('u.status > 1');
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("((u.status = 2 AND u.id_bagian = {$penilai['id_bagian']} ) OR ( d.id_ppk2 = {$penilai['id']} AND u.status = 6) OR ( d.id_pptk = {$penilai['id']} AND u.status = 5)) and u.unapprove_oleh IS NULL");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where('u.status > 2');
                            // $this->db->where('u.status <> 98');
                        } else if ($filter['status_permohonan'] == 'ditolak') {
                            // $this->db->where('u.unapprove_oleh IS NOT NULL');
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            // $this->db->where('u.unapprove_oleh is not null');
                            $this->db->where('u.status = 99');
                        }
                    }
                } else if ($penilai['level'] == 5) {
                    $this->db->where("((u.id_seksi = {$penilai['id_seksi']} AND u.id_bagian = {$penilai['id_bagian']} ) OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    $this->db->where('u.status >= 1');
                    // echo json_encode($penilai);
                    // die();
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("((u.status = 1 AND u.id_seksi = {$penilai['id_seksi']}) OR ( d.id_pptk = {$penilai['id']} AND u.status = 5)) and u.unapprove_oleh IS NULL");
                        } else if ($filter['status_permohonan'] == 'my-approv') {
                            $this->db->where('u.status > 1');
                            // $this->db->where('u.status <> 98');
                        } else if ($filter['status_permohonan'] == 'ditolak') {
                            // $this->db->where('u.unapprove_oleh IS NOT NULL');
                        } else if ($filter['status_permohonan'] == 'selesai') {
                            // $this->db->where('u.unapprove_oleh is not null');
                            $this->db->where('u.status = 99');
                        }
                    }
                } else {
                    $this->db->where("(unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                }
            }

            if ($filter['status_permohonan'] == 'ditolak') {
                $this->db->where('u.unapprove_oleh is not null');
            } else
            if ($filter['status_permohonan'] == 'selesai') {
                $this->db->where('u.status = 99');
            }

            if ($penilai['jen_satker'] != 1) {
                // echo $penilai['level'];
                if ($penilai['level'] == 8) {
                    // die();
                    $this->db->where("(u.status >= 50 OR unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("(u.status = 50 OR (d.id_pptk = {$penilai['id']} AND u.status = 51))");
                        } else if ($filter['status_permohonan'] == 'approv') {
                            $this->db->where('u.status in [51,52,59,60]');
                            // $this->db->where('u.status <> 98');
                        }
                    }
                } else
                if ($penilai['level'] == 7) {
                    $this->db->where("(u.status >= 59 OR unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                    if (!empty($filter['status_permohonan'])) {
                        if ($filter['status_permohonan'] == 'menunggu-saya') {
                            $this->db->where("(u.status = 59 OR (d.id_ppk2 = {$penilai['id']} AND u.status = 52))");
                        } else if ($filter['status_permohonan'] == 'approv') {
                            $this->db->where('u.status > 51');
                            $this->db->where('u.status <> 98');
                        }
                    }
                } else {
                    $this->db->where("(unapprove_oleh = {$penilai['id']} OR d.id_ppk2 = {$penilai['id']} OR d.id_pptk = {$penilai['id']})");
                }
            }

            if (!empty($filter['chk-spt']) or !empty($filter['chk-sppd']) or !empty($filter['chk-lembur'])) {
                $jen = [];
                if (!empty($filter['chk-spt']))
                    $jen[] = 1;
                if (!empty($filter['chk-sppd']))
                    $jen[] = 2;
                if (!empty($filter['chk-lembur']))
                    $jen[] = 3;
                $this->db->where_in('u.jenis', $jen);
            }
        }
        if (!empty($filter['status_rekap'])) {
            if ($filter['status_rekap'] == 'selesai') {
                $this->db->where('u.status', 99);
            } else if ($filter['status_rekap'] == 'ditolak') {
                $this->db->where('u.unapprove_oleh is not null');
            } else if ($filter['status_rekap'] == 'menunggu') {
                $this->db->where('u.unapprove_oleh is null AND u.status <> 99');
            }
        }
        if (!empty($filter['status_lpd'])) {
            if ($filter['status_lpd'] == 'semua') {
            } else if ($filter['status_lpd'] == 'belum') {
                $this->db->where('l.id_laporan is  null');
            } else if ($filter['status_lpd'] == 'sudah') {
                $this->db->where('l.id_laporan is not null');
            }
        }
        if (empty($filter['qrcode'])) {
            if ($this->session->userdata('jen_satker') != 1) {
                // if (in_array($this->session->userdata('level'), ['7', '8'])) {
                //     // $this->db->where('u.id_satuan', $ses['id_satuan']);
                // } else
                if (!$cross)
                    $this->db->where('u.id_satuan', $ses['id_satuan']);
            }
        } else {
            $this->db->where('u.qrcode', $filter['qrcode']);
        }

        $res = $this->db->get()->result_array();
        $res_id = [];
        // echo $this->db->last_query();
        // // echo json_encode($sort);
        // die();

        foreach ($res as $rid) {
            array_push($res_id, $rid['id_spt']);
        }
        if (!empty($res_id)) {
            $this->db->from('pengikut p ');
            $this->db->where_in('id_spt', $res_id);
            $pengikut = DataStructure::groupingByParent($this->db->get()->result_array(), 'id_spt');
            if (!$sort) {
                $this->db->select('*');
            } else {
                $this->db->select('id_spt,date_berangkat,date_kembali,tempat_tujuan');
            }
            $this->db->from('tujuan');
            $this->db->order_by('ke', 'ASC');
            $this->db->where_in('id_spt', $res_id);
            $tujuan = DataStructure::groupingByParent($this->db->get()->result_array(), 'id_spt');
        } else {
            $tujuan = [];
            $pengikut = [];
        }
        return DataStructure::SPPDStyle2($res, $tujuan, $pengikut);
    }

    public function getAllSPPD2($filter = [], $sort = false)
    {
        $ses = $this->session->userdata();

        $this->db->select('rjs.nama_ref_jen_spt, sa.nama_satuan');

        if (!$sort) {
            // $this->db->select('p2.nama as nama_input');
            // $this->db->select('s.jabatan jabatan_pegawai, 
            // s.pangkat_gol as pangkat_gol_pegawai,
            // s.id_seksi as id_seksi_pegawai,
            // s.id_bagian as id_bagian_pegawai, 
            // s.nip nip_pegawai');

            // $this->db->select(' 
            // p.nama as nama_ppk,
            // p.jabatan jabatan_ppk, 
            // p.pangkat_gol as pangkat_gol_ppk, 
            // p.nip nip_ppk');

            // $this->db->select('  
            // ptk.nama as nama_pptk, 
            // ptk.jabatan jabatan_pptk, 
            // ptk.pangkat_gol as pangkat_gol_pptk, 
            // ptk.nip nip_pptk');
            $this->db->select('
            d.id_ppk2, d.id_pptk,
            d.kode_rekening,
            d.nama_dasar
            ');
            // $this->db->select("un.approval_id_user as id_unapproval ,
            // t.nama_tr as nama_transport,
            // sa.jen_satker, 
            // u.*");
        } else {
            $this->db->select('u.id_spt, u.tgl_pengajuan,u.status, u.no_spt, u.no_sppd, u.unapprove_oleh, u.id_satuan, u.id_bagian, u.id_seksi');
        }
        $this->db->from('spt as u');
        $this->db->join('satuan sa', 'sa.id_satuan = u.id_satuan');
        $this->db->join('dasar d', 'd.id_dasar = u.id_dasar', 'LEFT');
        if (!$sort) {
            $this->db->join('users p', 'p.id = d.id_ppk2', 'LEFT');
            $this->db->join('users ptk', 'ptk.id = d.id_pptk', 'LEFT');
            $this->db->join('users p2', 'p2.id = u.user_input', 'LEFT');
            $this->db->join('approval un', 'u.unapprove_oleh = un.id_approval', 'LEFT');
            $this->db->join('transport t', 't.transport = u.transport', 'LEFT');
        }
        $this->db->join('ref_jen_spt rjs', 'u.jenis = rjs.id_ref_jen_spt', 'LEFT');
        $this->db->group_by('id_spt');
        if (!empty($filter['id_spt'])) $this->db->where('u.id_spt', $filter['id_spt']);
        if (!empty($filter['id_satuan'])) $this->db->where('u.id_satuan', $filter['id_satuan']);
        if (!empty($filter['id_bagian'])) $this->db->where('u.id_bagian', $filter['id_bagian']);
        if (!empty($filter['id_seksi'])) $this->db->where('u.id_seksi', $filter['id_seksi']);
        return DataStructure::keyValue($this->db->get()->result_array(), 'id_spt');
    }

    public function CekJadwal($data = [], $start, $end, $ex_id = '', $all = false)
    {
        $data['pengikut'][] = $data['id_pegawai'];
        // echo json_encode($data['pengikut']);
        // echo $end;
        // die();
        $this->db->select('us.nama, r.tempat_tujuan, no_sppd ,no_spt,r.date_berangkat,date_kembali');
        $this->db->from('spt as u');
        $this->db->join('users us', 'u.id_pegawai = us.id');
        $this->db->join('tujuan r', 'u.id_spt = r.id_spt');
        $this->db->where_in('id_pegawai', $data['pengikut']);
        if (!$all) $this->db->where('u.jenis', '2');
        if (!empty($ex_id)) $this->db->where('u.id_spt <>', $ex_id);
        $this->db->where('u.unapprove_oleh is null');
        // $this->db->where("(r.date_kembali >='$start' AND r.date_berangkat <= '$end')");
        $this->db->where("(
            r.date_berangkat BETWEEN '$start' AND '$end' OR 
            r.date_kembali BETWEEN '$start' AND '$end' OR
            '$start' BETWEEN  r.date_berangkat  AND  r.date_kembali OR
            '$end' BETWEEN  r.date_berangkat  AND  r.date_kembali  
            )");

        $res1 = $this->db->get()->result_array();
        if (!empty($res1))
            throw new UserException("{$res1[0]['nama']} Sudah dijadwalkan berangkat ke {$res1[0]['tempat_tujuan']} pada tanggal {$res1[0]['date_berangkat']} s.d. {$res1[0]['date_kembali']} dengan NO SPT {$res1[0]['no_spt']} ", UNAUTHORIZED_CODE);

        // pengikut
        $data['pengikut'][] = $data['id_pegawai'];
        $this->db->select('us.nama, r.tempat_tujuan, no_sppd, no_spt ,r.date_berangkat,date_kembali');
        $this->db->from('spt as u');
        $this->db->join('pengikut p', 'p.id_spt = u.id_spt');
        $this->db->join('users us', 'p.id_pegawai = us.id');
        $this->db->join('tujuan r', 'u.id_spt = r.id_spt');
        $this->db->where_in('p.id_pegawai', $data['pengikut']);
        $this->db->where('u.unapprove_oleh is null');
        if (!empty($ex_id)) $this->db->where('u.id_spt <> ', $ex_id);
        if (!$all) $this->db->where('u.jenis', '2');
        // $this->db->where("(r.date_kembali >='$start' AND r.date_berangkat <= '$end')");
        $this->db->where("(
            r.date_berangkat BETWEEN '$start' AND '$end' OR 
            r.date_kembali BETWEEN '$start' AND '$end' OR
            '$start' BETWEEN  r.date_berangkat  AND  r.date_kembali OR
            '$end' BETWEEN  r.date_berangkat  AND  r.date_kembali  
             )");

        $res1 = $this->db->get()->result_array();
        if (!empty($res1))
            throw new UserException("{$res1[0]['nama']} Sudah dijadwalkan berangkat ke {$res1[0]['tempat_tujuan']} pada tanggal {$res1[0]['date_berangkat']} s.d. {$res1[0]['date_kembali']} dengan NO SPT {$res1[0]['no_spt']} ", UNAUTHORIZED_CODE);

        // echo json_encode($res1);
        // echo $this->db->last_query();
        // die();

        // return DataStructure::SPPDStyle($res->result_array());
    }

    public function getDasarSppd($filter)
    {
        $this->db->select("*");
        $this->db->from('dasar as u');
        if (!empty($filter['id_dasar'])) $this->db->where('id_dasar', $filter['id_dasar']);
        // $this->db->where('u.id_spt', $id);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_dasar');
    }
    public function getDasar($id)
    {
        $this->db->select("*");
        $this->db->from('dasar_tambahan as u');
        //    if(!empty('id_dasar')) $this->db->from('dasar_tambahan as u');
        $this->db->where('u.id_spt', $id);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_dasar_tambahan');
    }

    public function getPengikut($id)
    {
        $this->db->select("u.*");
        $this->db->from('pengikut as u');
        $this->db->where('u.id_spt', $id);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_pengikut');
    }


    public function addSPPD($data)
    {

        // date_default_timezone_set('Asia/Jakarta');
        // die();
        $ses = $this->session->userdata();
        $data['id_satuan'] = $ses['id_satuan'];
        $data['id_seksi'] = $ses['id_seksi'];
        $data['id_bagian'] = $ses['id_bagian'];
        $data['user_input'] = $ses['id'];
        // echo json_encode($data);
        // die();
        $this->db->select("r.level, s.id id_pegawai, s.nama as p_nama, jabatan p_jabatan, pangkat_gol p_pangkat_gol, nip p_nip, signature p_sign, tempat_lahir p_tmpt_lahir, tanggal_lahir p_tgl_lahir");
        $this->db->from('users as s');
        $this->db->join('roles as r', 'r.id_role = s.id_role', 'LEFT');
        $this->db->where('s.id', $data['id_pegawai']);
        $pelaksana = $this->db->get()->result_array()[0];
        $data['pel_nama'] = $pelaksana['p_nama'];
        $data['pel_jabatan'] = $pelaksana['p_jabatan'];
        $data['pel_nip'] = $pelaksana['p_nip'];
        $data['pel_pangkat_gol'] = $pelaksana['p_pangkat_gol'];
        $data['pel_sign'] = $pelaksana['p_sign'];
        $data['pel_tgl_lahir'] = $pelaksana['p_tgl_lahir'];
        $data['pel_tmpt_lahir'] = $pelaksana['p_tmpt_lahir'];
        if (!empty($pelaksana['level'])) $data['pel_level'] = $pelaksana['level'];
        else $data['pel_level'] = 0;
        // echo json_encode($pelaksana);
        // die();

        $this->db->insert('spt', DataStructure::slice($data, [
            'ppk', 'dasar', 'maksud', 'id_pegawai', 'transport', 'lama_dinas', 'jenis', 'luardaerah',
            'id_satuan', 'id_bagian', 'id_seksi', 'id_dasar', 'user_input', 'id_ppk', 'status', 'berangkat_dari',
            'pel_nama', 'pel_nip', 'pel_jabatan', 'pel_pangkat_gol', 'pel_sign', 'pel_tmpt_lahir', 'pel_tgl_lahir', 'pel_level', 'plh', 'plh_id'
        ], FALSE));
        ExceptionHandler::handleDBError($this->db->error(), "Tambah SPT", "SPT");
        $id_spt = $this->db->insert_id();
        $i = 0;
        foreach ($data['tempat_tujuan'] as $p) {
            if (!empty($data['tempat_tujuan'][$i]) or !empty($data['tempat_kembali'][$i]) or !empty($data['date_berangkat'][$i]) or !empty($data['date_kembali'][$i])) {
                $d_tujuan = array(
                    'id_spt' => $id_spt,
                    'tempat_tujuan' => $data['tempat_tujuan'][$i],
                    'tempat_kembali' => !empty($data['tempat_kembali'][$i]) ? $data['tempat_kembali'][$i] : '',
                    'date_berangkat' => $data['date_berangkat'][$i],
                    'date_kembali' => !empty($data['date_kembali'][$i]) ? $data['date_kembali'][$i] : '',
                    'dari' => !empty($data['dari'][$i]) ? $data['dari'][$i] : '',
                    'sampai' => !empty($data['sampai'][$i]) ? $data['sampai'][$i] : '',
                    'ke' => $i + 1,
                );
                $this->db->insert('tujuan', $d_tujuan);
            }
            $i++;
        }


        if (!empty($data['pengikut'])) {
            $this->db->select("s.id id_pegawai, s.nama as p_nama, jabatan p_jabatan, pangkat_gol p_pangkat_gol, nip p_nip, signature p_sign, tempat_lahir p_tmpt_lahir, tanggal_lahir p_tgl_lahir");
            $this->db->from('users as s');
            $this->db->join('roles as r', 'r.id_role = s.id_role', 'LEFT');
            $this->db->where_in('s.id', $data['pengikut']);
            $this->db->order_by('r.level', 'asc');

            $d_pengikut = $this->db->get()->result_array();
            foreach ($d_pengikut as $cur_p) {
                $cur_p['id_spt'] =  $id_spt;
                $this->db->insert('pengikut', $cur_p);
            }
        }

        if (!empty($data['dasar_tambahan']))
            foreach ($data['dasar_tambahan'] as $p) {
                $d_pengikut = array(
                    'id_spt' => $id_spt,
                    'dasar_tambahan' => $p,
                );
                $this->db->insert('dasar_tambahan', $d_pengikut);
            }

        ExceptionHandler::handleDBError($this->db->error(), "Tambah SPT", "SPT");
        return $id_spt;
    }
    public function addLogs($data)
    {
        $this->db->insert('spt_logs', $data);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");
    }


    public function editSPPD($data)
    {

        $ses = $this->session->userdata();
        if ($ses['id_role'] != '1') {
            $data['id_satuan'] = $ses['id_satuan'];
            $data['id_seksi'] = $ses['id_seksi'];
            $data['id_bagian'] = $ses['id_bagian'];
            $data['user_input'] = $ses['id'];
        }
        $this->db->select("r.level, s.id id_pegawai, s.nama as p_nama, jabatan p_jabatan, pangkat_gol p_pangkat_gol, nip p_nip, signature p_sign, tempat_lahir p_tmpt_lahir, tanggal_lahir p_tgl_lahir");
        $this->db->from('users as s');
        $this->db->join('roles as r', 'r.id_role = s.id_role');
        $this->db->where('s.id', $data['id_pegawai']);
        $pelaksana = $this->db->get()->result_array()[0];
        $data['pel_nama'] = $pelaksana['p_nama'];
        $data['pel_jabatan'] = $pelaksana['p_jabatan'];
        $data['pel_nip'] = $pelaksana['p_nip'];
        $data['pel_pangkat_gol'] = $pelaksana['p_pangkat_gol'];
        $data['pel_sign'] = $pelaksana['p_sign'];
        $data['pel_tgl_lahir'] = $pelaksana['p_tgl_lahir'];
        $data['pel_tmpt_lahir'] = $pelaksana['p_tmpt_lahir'];
        $data['pel_level'] = $pelaksana['level'];

        $this->db->set(DataStructure::slice($data, [
            'ppk', 'dasar', 'maksud', 'id_pegawai', 'transport', 'lama_dinas', 'luardaerah',
            'id_satuan', 'id_bagian', 'id_seksi', 'id_dasar', 'user_input', 'id_ppk', 'berangkat_dari', 'status',
            'pel_nama', 'pel_nip', 'pel_jabatan', 'pel_pangkat_gol', 'pel_sign', 'pel_tmpt_lahir', 'pel_tgl_lahir', 'pel_level'
        ], FALSE));

        $this->db->where('id_spt', $data['id_spt']);
        $this->db->update('spt',);

        $id_spt = $data['id_spt'];
        $i = 0;
        foreach ($data['tempat_tujuan'] as $p) {
            $d_tujuan = array(
                'id_spt' => $id_spt,
                'tempat_tujuan' => $data['tempat_tujuan'][$i],
                'tempat_kembali' => !empty($data['tempat_kembali'][$i]) ? $data['tempat_kembali'][$i] : '',
                'date_berangkat' => $data['date_berangkat'][$i],
                'date_kembali' => !empty($data['date_kembali'][$i]) ? $data['date_kembali'][$i] : '',
                'dari' => !empty($data['dari'][$i]) ? $data['dari'][$i] : '',
                'sampai' => !empty($data['sampai'][$i]) ? $data['sampai'][$i] : '',
                'ke' => $i + 1,
            );

            if (!empty($data['tempat_tujuan'][$i]) and  !empty($data['date_berangkat'][$i]) and empty($data['id_tujuan'][$i])) {
                $this->db->insert('tujuan', $d_tujuan);
            } else
            if (!empty($data['tempat_tujuan'][$i]) and  !empty($data['date_berangkat'][$i]) and !empty($data['id_tujuan'][$i])) {
                $this->db->set($d_tujuan);
                $this->db->where('id_tujuan', $data['id_tujuan'][$i]);
                $this->db->update('tujuan');
            } else if (!empty($data['id_tujuan'][$i])) {
                $this->db->where('id_tujuan', $data['id_tujuan'][$i]);
                $this->db->delete('tujuan');
            }
            $i++;
        }

        $this->db->where('id_spt', $id_spt);
        $this->db->delete('pengikut');

        if (!empty($data['pengikut'])) {
            $this->db->select("s.id id_pegawai, s.nama as p_nama, jabatan p_jabatan, pangkat_gol p_pangkat_gol, nip p_nip, signature p_sign, tempat_lahir p_tmpt_lahir, tanggal_lahir p_tgl_lahir");
            $this->db->from('users as s');
            $this->db->join('roles as r', 'r.id_role = s.id_role');
            $this->db->where_in('s.id', $data['pengikut']);
            $this->db->order_by('r.level', 'asc');

            $d_pengikut = $this->db->get()->result_array();
            foreach ($d_pengikut as $cur_p) {
                $cur_p['id_spt'] =  $id_spt;
                $this->db->insert('pengikut', $cur_p);
            }
        }
        $j = 0;
        if (!empty($data['dasar_tambahan']))
            foreach ($data['dasar_tambahan'] as $p) {
                if (empty($data['id_dasar_tambahan'][$j]) and !empty($data['dasar_tambahan'][$j])) {
                    $d_pengikut = array(
                        'id_spt' => $id_spt,
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

        return $id_spt;
    }
    public function edit_adm($data)
    {

        $this->db->set(DataStructure::slice($data, [
            'tgl_pengajuan', 'no_spt', 'no_sppt',
        ], FALSE));

        $this->db->where('id_spt', $data['id_spt']);
        $this->db->update('spt',);

        $id_spt = $data['id_spt'];
        // $i = 0;
        // foreach ($data['tempat_tujuan'] as $p) {
        //     $d_tujuan = array(
        //         'id_spt' => $id_spt,
        //         'tempat_tujuan' => $data['tempat_tujuan'][$i],
        //         'tempat_kembali' => $data['tempat_kembali'][$i],
        //         'date_berangkat' => $data['date_berangkat'][$i],
        //         'date_kembali' => $data['date_kembali'][$i],
        //         'ke' => $i + 1,
        //     );

        //     if (!empty($data['tempat_tujuan'][$i]) and !empty($data['tempat_kembali'][$i]) and !empty($data['date_berangkat'][$i]) and !empty($data['date_kembali'][$i]) and empty($data['id_tujuan'][$i])) {
        //         $this->db->insert('tujuan', $d_tujuan);
        //     } else
        //     if (!empty($data['tempat_tujuan'][$i]) and !empty($data['tempat_kembali'][$i]) and !empty($data['date_berangkat'][$i]) and !empty($data['date_kembali'][$i]) and !empty($data['id_tujuan'][$i])) {
        //         $this->db->set($d_tujuan);
        //         $this->db->where('id_tujuan', $data['id_tujuan'][$i]);
        //         $this->db->update('tujuan');
        //     } else if (!empty($data['id_tujuan'][$i])) {
        //         $this->db->where('id_tujuan', $data['id_tujuan'][$i]);
        //         $this->db->delete('tujuan');
        //     }
        //     $i++;
        // }
        // $this->db->where('id_spt', $id_spt);
        // $this->db->delete('pengikut');
        // if (!empty($data['pengikut']))
        //     foreach ($data['pengikut'] as $p) {
        //         $d_pengikut = array(
        //             'id_spt' => $id_spt,
        //             'id_pegawai' => $p,
        //         );
        //         $this->db->insert('pengikut', $d_pengikut);
        //     }
        // $j = 0;
        // if (!empty($data['dasar_tambahan']))
        //     foreach ($data['dasar_tambahan'] as $p) {
        //         if (empty($data['id_dasar_tambahan'][$j]) and !empty($data['dasar_tambahan'][$j])) {
        //             $d_pengikut = array(
        //                 'id_spt' => $id_spt,
        //                 'dasar_tambahan' => $p,
        //             );
        //             $this->db->insert('dasar_tambahan', $d_pengikut);
        //         } else  if (!empty($data['id_dasar_tambahan'][$j]) and !empty($data['dasar_tambahan'][$j])) {
        //             $d_pengikut = array(
        //                 'dasar_tambahan' => $p,
        //             );
        //             $this->db->set('dasar_tambahan', $data['dasar_tambahan'][$j]);
        //             $this->db->where('id_dasar_tambahan', $data['id_dasar_tambahan'][$j]);
        //             $this->db->update('dasar_tambahan');
        //             // echo  !empty($data['dasar_tambahan'][$j]);
        //             // echo  $data['dasar_tambahan'][$j];
        //             // die();
        //         } else if (!empty($data['id_dasar_tambahan'][$j]) and empty($data['dasar_tambahan'][$j])) {
        //             $this->db->where('id_dasar_tambahan', $data['id_dasar_tambahan'][$j]);
        //             $this->db->delete('dasar_tambahan');
        //         }
        //         $j++;
        //     }

        // ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");

        return $id_spt;
    }

    public function draft_to_diajukan($data)
    {
        if (!empty($data['id_seksi']))
            $this->db->set('status', '1');
        else
            $this->db->set('status', '2');
        $this->db->set('tgl_pengajuan', date('Y-m-d h:i:s'));
        $this->db->where('id_spt', $data['id_spt']);
        $this->db->update('spt',);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");
    }

    function cek_nomor($data, $sppd = false, $spt_lv7 = false)
    {
        $this->db->where('id_satuan', $data['id_satuan']);
        $dataSatuan = $this->db->get('satuan')->result_array()[0];
        $satuan = $dataSatuan['kode_surat'];
        $s3b = $s3a = $satuan . '/' . substr($data['tgl_pengajuan'], 0, 4);

        if ($spt_lv7) {
            $satuan = 'DINKES';
            $s3b = $satuan . '/' . substr($data['tgl_pengajuan'], 0, 4);
        }
        // echo json_encode($satuan);
        // die();
        $this->db->select('no_spt , SUBSTRING_INDEX(SUBSTRING_INDEX(no_spt,"/",2),"/",-1) as x, SUBSTRING_INDEX(no_spt,"/",1),SUBSTRING_INDEX(no_spt,"/",-2)');
        $this->db->from('spt');
        // $this->db->where('no_spt <> ""');
        $this->db->where('SUBSTRING_INDEX(no_spt,"/",-2)', $s3b);
        $this->db->where('SUBSTRING_INDEX(no_spt,"/",1)', '800');
        $this->db->order_by('CAST(x AS UNSIGNED INTEGER)', 'DESC');
        $this->db->limit(1);
        $res = $this->db->get()->result_array();
        // echo json_encode($res);
        // die();
        if (!empty($res)) {
            $num['spt'] = '800/' . ($res[0]['x'] + 1) . '/' . $s3b;
        } else {
            if ($dataSatuan['id_satuan'] == 11) {
                $num['spt'] = '800/1099/' . $s3b;
            } else
                $num['spt'] = '800/1/' . $s3b;
        }

        if ($data['jenis'] == 2) {
            $this->db->select('no_sppd , SUBSTRING_INDEX(SUBSTRING_INDEX(no_sppd,"/",2),"/",-1) as x, SUBSTRING_INDEX(no_sppd,"/",1)');
            $this->db->from('spt');
            $this->db->where('no_sppd <> ""');
            $this->db->where('SUBSTRING_INDEX(no_sppd,"/",-2)', $s3a);
            $this->db->where('SUBSTRING_INDEX(no_sppd,"/",1)', '934');
            $this->db->order_by('CAST(x AS UNSIGNED INTEGER)', 'DESC');
            $this->db->limit(1);
            $res = $this->db->get()->result_array();
            if (!empty($res)) {
                $num['sppd'] = '934/' . ($res[0]['x'] + 1) . '/' . $s3a;
            } else {
                if ($dataSatuan['id_satuan'] == 11) {
                    $num['sppd'] = '934/1015/' . $s3b;
                } else
                    $num['sppd'] = '934/1/' . $s3a;
            }
        }
        return $num;
    }

    function sign($id, $field, $user, $title, $status = '', $plh = null)
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
        if (!empty($plh)) {
            $sign['sign_plh'] = $plh['nama_role'];
        }
        $this->db->insert('sign', $sign);
        ExceptionHandler::handleDBError($this->db->error(), "Approv Gagal", "Approv");
        $sign_id =  $this->db->insert_id();

        $this->db->set($field, $sign_id);
        if (!empty($status))
            $this->db->set('status', $id);
        $this->db->where('id_spt', $id);
        $this->db->update('spt');
        ExceptionHandler::handleDBError($this->db->error(), "Approv Gagal", "Approv");

        // echo json_encode($sign);
        // die();
        return $sign_id;
    }
    public function approv($data_spt, $plh)
    {
        // echo json_encode($data_spt);
        // die();
        $ses = $this->session->userdata();
        $continue = false;
        $ap_pptk = false;
        $ap_ppk = false;
        // if ($data_spt['id_pptk'] == $ses['id'] && empty($data_spt['sign_pptk'])) {
        if ($data_spt['id_pptk'] == $ses['id']) {
            $data_spt['sign_pptk'] = $this->sign($data_spt['id_spt'], 'sign_pptk', $ses, 'Pejabat Pelaksana Teknis Kegiatan');
            $continue = true;
            $ap_pptk = true;
        }
        // if ($data_spt['id_ppk2'] == $ses['id'] && empty($data_spt['sign_ppk'])) {
        if ($data_spt['id_ppk2'] == $ses['id'] && empty($data_spt['sign_ppk'])) {
            $data_spt['sign_ppk'] =  $this->sign($data_spt['id_spt'], 'sign_ppk', $ses, 'Pejabat Pembuat Komitmen');
            $continue = true;
            $ap_ppk = true;
            if ($ses['level'] == 2) {
                $this->db->set('approve_sekdin', $ses['id']);
                $this->db->set('status', '12');
            }
        }

        if (($data_spt['status'] == '2' && ($ses['level'] == 3 || $ses['level'] == 4))) {
            if ($data_spt['id_bagian'] == $ses['id_bagian']) {
                if ($data_spt['jenis'] == '1') {
                    $this->db->set('status', '11');
                } else {
                    if (!empty($data_spt['sign_pptk']) && !empty($data_spt['sign_ppk']))
                        $this->db->set('status', '11');
                    else if (empty($data_spt['sign_pptk']))
                        $this->db->set('status', '5');
                    else if (empty($data_spt['sign_ppk']))
                        $this->db->set('status', '6');
                }
                $this->db->set('approve_kabid', $ses['id']);
            } else {
                throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
            }
        }
        // kasi
        else if ($data_spt['status'] == '1' && $ses['level'] == 5) {
            if ($data_spt['id_seksi'] == $ses['id_seksi'] && $data_spt['id_bagian'] == $ses['id_bagian']) {
                $this->db->set('approve_kasi', $ses['id']);
                if ($data_spt['jenis'] == '1') {
                    $this->db->set('status', '2');
                } else {
                    if ($ap_pptk) {
                        $this->db->set('status', '2');
                    } else {
                        $this->db->set('status', '5');
                    }
                }
            } else {
                throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
            }
        } else if ($data_spt['status'] == '11' && $ses['level'] == 2) {
            $this->db->set('approve_sekdin', $ses['id']);
            $this->db->set('status', '12');
        } else if ($data_spt['status'] == '12' && $ses['level'] == 1) {
            if ($data_spt['pel_level'] == 7) {
                $nomor = $this->cek_nomor($data_spt, true, true);
                $id_sign_kadin =  $this->sign($data_spt['id_spt'], 'sign_kadin2', $ses, $ses['jabatan']);
                if (!empty($nomor['spt'])) {
                    $this->db->set('no_spt', $nomor['spt']);
                }
                if (!empty($nomor['sppd'])) {
                    $this->db->set('no_sppd', $nomor['sppd']);
                }
                $this->db->set('sign_kadin2', $id_sign_kadin);
                $this->db->set('approve_kadin', $ses['id']);
                $this->db->set('status', '99');
            } else {
                $nomor = $this->cek_nomor($data_spt);
                $id_sign_kadin =  $this->sign($data_spt['id_spt'], 'sign_kadin', $ses, $ses['jabatan']);
                if (!empty($nomor['spt'])) {
                    $this->db->set('no_spt', $nomor['spt']);
                }
                if (!empty($nomor['sppd'])) {
                    $this->db->set('no_sppd', $nomor['sppd']);
                }
                $this->db->set('sign_kadin', $id_sign_kadin);
                $this->db->set('approve_kadin', $ses['id']);
                $this->db->set('status', '99');
            }
        } else if ($data_spt['status'] == '50' && $ses['level'] == 8) {
            $this->db->set('approve_kasi', $ses['id']);
            if ($data_spt['jenis'] == '1') {
                $this->db->set('status', '59');
            } else {
                if ($ap_pptk) {
                    $this->db->set('status', '52');
                } else
                    $this->db->set('status', '51');
            }
        } else if ($data_spt['status'] == '59' && $ses['level'] == 7) {
            $id_sign_kadin =  $this->sign($data_spt['id_spt'], 'sign_kadin', $ses, $ses['jabatan']);
            $this->db->set('sign_kadin', $id_sign_kadin);
            $this->db->set('approve_kabid', $ses['id']);
            // if ($data_spt['luardaerah'] == 2 && $data_spt['pel_level'] == 7) {
            if ($data_spt['luardaerah'] == 2) {
                $this->db->set('status', '11');
            } else {
                $nomor = $this->cek_nomor($data_spt);
                if (!empty($nomor['spt'])) {
                    $this->db->set('no_spt', $nomor['spt']);
                }
                if (!empty($nomor['sppd'])) {
                    $this->db->set('no_sppd', $nomor['sppd']);
                }
                $this->db->set('status', '99');
            }
        } else if ($ap_ppk && ($data_spt['jen_satker'] == 2 || $data_spt['jen_satker'] == 3 || $data_spt['jen_satker'] == 4)) {
            // echo "jere";
            if ($ses['level'] == 7) {
                $id_sign_kadin =  $this->sign($data_spt['id_spt'], 'sign_kadin', $ses, $ses['jabatan']);

                // if ($data_spt['pel_level'] == 7 && $data_spt['luardaerah'] == 2) {
                if ($data_spt['luardaerah'] == 2) {
                    $this->db->set('status', '11');
                } else {
                    $nomor = $this->cek_nomor($data_spt);
                    // $id_sign_kadin =  $this->sign($data_spt['id_spt'], 'sign_kadin', $ses, $ses['jabatan']);
                    if (!empty($nomor['spt'])) {
                        $this->db->set('no_spt', $nomor['spt']);
                    }
                    if (!empty($nomor['sppd'])) {
                        $this->db->set('no_sppd', $nomor['sppd']);
                    }
                    $this->db->set('status', '99');
                }
                $this->db->set('sign_kadin', $id_sign_kadin);
                $this->db->set('approve_kabid', $ses['id']);
            } else {
                $this->db->set('status', 59);
            }
        } else if ($ap_pptk && ($data_spt['jen_satker'] == 2 || $data_spt['jen_satker'] == 3 || $data_spt['jen_satker'] == 4)) {
            $this->db->set('status', 52);
        } else if ($ap_pptk && $data_spt['jen_satker'] == 1) {
            if (empty($data_spt['approve_kabid']))
                $this->db->set('status', 2);
            else {
                $this->db->set('status', 6);
            }
        } else if ($ap_ppk && $data_spt['jen_satker'] == 1) {
            // die();
            if ($ses['level'] == 2) {
                $this->db->set('approve_sekdin', $ses['id']);
                $this->db->set('status', '12');
            } else {
                $this->db->set('status', 11);
            }
        } else if ($continue) {
            $this->db->set('id_spt', $data_spt['id_spt']);
        } else if (!empty($plh)) {
            if ($data_spt['status'] == '12' && $plh['level'] == 1) {
                if ($data_spt['pel_level'] == 7) {
                    $nomor = $this->cek_nomor($data_spt, true, true);
                    $id_sign_kadin =  $this->sign($data_spt['id_spt'], 'sign_kadin2', $ses, $ses['jabatan'], '', $plh);
                    if (!empty($nomor['spt'])) {
                        $this->db->set('no_spt', $nomor['spt']);
                    }
                    if (!empty($nomor['sppd'])) {
                        $this->db->set('no_sppd', $nomor['sppd']);
                    }
                    $this->db->set('sign_kadin2', $id_sign_kadin);
                    $this->db->set('approve_kadin', $ses['id']);
                    $this->db->set('status', '99');
                } else {
                    $nomor = $this->cek_nomor($data_spt);
                    $id_sign_kadin =  $this->sign($data_spt['id_spt'], 'sign_kadin', $ses, $ses['jabatan'], '', $plh);
                    if (!empty($nomor['spt'])) {
                        $this->db->set('no_spt', $nomor['spt']);
                    }
                    if (!empty($nomor['sppd'])) {
                        $this->db->set('no_sppd', $nomor['sppd']);
                    }
                    $this->db->set('sign_kadin', $id_sign_kadin);
                    $this->db->set('approve_kadin', $ses['id']);
                    $this->db->set('status', '99');
                }
            }
        } else {
            throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
        }
        // die();
        $this->db->where('id_spt', $data_spt['id_spt']);
        $this->db->update('spt',);
        // echo $this->db->last_query();
        // die();
        ExceptionHandler::handleDBError($this->db->error(), "Approv Gagal", "Approv");
    }


    public function unapprov($data)
    {
        $ses = $this->session->userdata();
        // if ($ses['level'] == 2) {
        $this->db->set('unapprove_oleh', $ses['id']);
        // } else 
        // if ($ses['level'] == 1) {
        //     $this->db->set('unnapprove_oleh', $ses['id']);
        //     $this->db->set('status', 98);
        // }

        $this->db->where('id_spt', $data['id_spt']);
        $this->db->update('spt');
        ExceptionHandler::handleDBError($this->db->error(), "Batalkan Aksi", "Batal");
    }

    public function addQRCode($data)
    {
        $this->db->set('qrcode', $data['qrcode']);
        $this->db->where('id_spt', $data['id_spt']);
        $this->db->update('spt');
    }

    public function undo($data)
    {
        $ses = $this->session->userdata();
        $id = $this->db->insert_id();
        if (($data['status'] == '11')  && ($ses['level'] == 3 || $ses['level'] == 4) && ($data['approve_kabid'] == $ses['id'])) {
            // echo "true";
            $this->db->set('approve_kabid', NULL);
            $this->db->set('unapprove_oleh', NULL);   // if ($data_spt['id_bagian'] == $ses['id_bagian']) {
            $this->db->set('status', '2');
        } else
        if (($data['status'] == '12') && ($data['id_ppk2'] == $ses['id']) && ($data['approve_sekdin'] == $ses['id'])) {
            $this->db->set('approve_sekdin', NULL);
            $this->db->set('sign_ppk', NULL);
            $this->db->set('unapprove_oleh', NULL);   // if ($data_spt['id_bagian'] == $ses['id_bagian']) {
            $this->db->set('status', '6');
        } else
        if (($data['status'] == '11') && ($data['id_ppk'] == $ses['id'])) {
            // echo "true";
            $this->db->set('sign_ppk', NULL);
            $this->db->set('unapprove_oleh', NULL);   // if ($data_spt['id_bagian'] == $ses['id_bagian']) {
            $this->db->set('status', '10');
        } else
        if (($data['status'] == '12') && ($data['approve_sekdin'] == $ses['id'])) {
            // echo "true";
            $this->db->set('approve_sekdin', NULL);
            $this->db->set('unapprove_oleh', NULL);   // if ($data_spt['id_bagian'] == $ses['id_bagian']) {

            // if ($data['pel_level'] == 7) {
            if ($data['id_ppk'] == $ses['id']) {
                $this->db->set('sign_ppk', NULL);
                $this->db->set('status', '10');
            } else {
                $this->db->set('status', '11');
            }
            // } else {
            //     $this->db->set('status', '10');
            // }
        }
        if (($data['status'] == '99') && ($data['approve_kadin'] == $ses['id'])) {
            // echo "true";
            if ($data['pel_level'] == 7) {
                $this->db->set('sign_kadin2', NULL);
            } else {
                $this->db->set('sign_kadin', NULL);
            }
            $this->db->set('approve_kadin', NULL);
            $this->db->set('no_spt', NULL);
            $this->db->set('no_sppd', NULL);
            $this->db->set('unapprove_oleh', NULL);
            $this->db->set('status', '12');

            // $this->db->set('approve_kadin', NULL);
            // $this->db->set('sign_kadin', NULL);
            // $this->db->set('no_spt', NULL);
            // $this->db->set('no_sppd', NULL);
            // $this->db->set('unapprove_oleh', NULL);
            // $this->db->set('status', '12');
        } else if ((($data['status'] == '11' && $data['approve_kabid'] == $ses['id']) or ($data['pel_level'] != 7 && $data['status'] == 99)) && $data['jen_satker'] != 1) {
            // echo "true";
            // if ($data['pel_level'] == 7) {
            //     $this->db->set('sign_kadin2', NULL);
            // } else {
            //     $this->db->set('sign_kadin', NULL);
            // }
            $this->db->set('approve_kabid', NULL);
            $this->db->set('no_spt', NULL);
            $this->db->set('no_sppd', NULL);
            $this->db->set('unapprove_oleh', NULL);
            $this->db->set('status', '59');

            // $this->db->set('approve_kadin', NULL);
            // $this->db->set('sign_kadin', NULL);
            // $this->db->set('no_spt', NULL);
            // $this->db->set('no_sppd', NULL);
            // $this->db->set('unapprove_oleh', NULL);
            // $this->db->set('status', '12');
        } else if (($data['status'] == '51')  && $ses['level'] == 8 && ($data['approve_kasi'] == $ses['id'])) {
            // echo "true";
            $this->db->set('approve_kasi', NULL);
            $this->db->set('unapprove_oleh', NULL);   // if ($data_spt['id_bagian'] == $ses['id_bagian']) {
            $this->db->set('status', '50');
        }

        if ($data['unapprove_oleh'] == $ses['id']) {
            $this->db->set('unapprove_oleh', NULL);
        }
        $this->db->where('id_spt', $data['id_spt']);
        $this->db->update('spt',);
        ExceptionHandler::handleDBError($this->db->error(), "Tambah User", "User");
    }

    public function deleteDasarTambahan($data)
    {
        $this->db->where('id_dasar_tambahan', $data['id_dasar_tambahan']);
        $this->db->delete('dasar_tambahan');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus Dasar Tambahan", "Tambahan");
    }
    public function delete($data)
    {
        $this->db->where('id_spt', $data['id_spt']);
        $this->db->delete('spt');

        $this->db->where('id_spt', $data['id_spt']);
        $this->db->delete('pengikut');

        $this->db->where('id_spt', $data['id_spt']);
        $this->db->delete('tujuan');

        $this->db->where('id_spt', $data['id_spt']);
        $this->db->delete('spt_laporan');

        $this->db->where('id_spt', $data['id_spt']);
        $this->db->delete('spt_foto');
        ExceptionHandler::handleDBError($this->db->error(), "Hapus SPT", "SPT");
    }

    public function addFoto($data)
    {
        if (empty($data['id_foto'])) {
            $this->db->insert('spt_foto', $data);
            $data['id_foto'] = $this->db->insert_id();
        } else {
            $this->db->where('id_foto', $data['id_foto']);
            $this->db->where('id_spt', $data['id_spt']);
            $this->db->update('spt_foto', $data);
        }

        ExceptionHandler::handleDBError($this->db->error(), "Simpan Foto", "Simpan Foto");

        return $data['id_foto'];
    }

    public function deleteFoto($data)
    {

        $this->db->where('id_foto', $data['id_foto']);
        $this->db->where('id_spt', $data['id_spt']);
        $this->db->delete('spt_foto', $data);

        ExceptionHandler::handleDBError($this->db->error(), "Delete Foto", "Foto");

        return $data['id_foto'];
    }

    public function addLaporan($data)
    {
        if (!empty($this->session->userdata()['id_seksi']))
            $data['lap_status'] = 1;
        else
            $data['lap_status'] = 2;
        // $this->db->set('status', '2');
        if (!empty($data['id_laporan'])) {
            $this->db->where('id_laporan', $data['id_laporan']);
            $this->db->update('spt_laporan', DataStructure::slice($data, [
                'text_laporan', 'id_bendahara', 'id_spt', 'honorarium', 'lap_status'
            ], FALSE));
        } else {
            $this->db->insert('spt_laporan', DataStructure::slice($data, [
                'text_laporan', 'id_bendahara', 'id_spt', 'honorarium', 'lap_status'
            ], FALSE));
        }

        ExceptionHandler::handleDBError($this->db->error(), "Tambah Laporan", "Laporan");

        if (!empty($data['nominal']))
            foreach ($data['nominal'] as $key => $p) {

                $this->db->set('honorarium', $p);
                $this->db->where('id_pengikut', $key);
                $this->db->update('pengikut');
            }

        ExceptionHandler::handleDBError($this->db->error(), "Tambah Laporan", "Laporan");
    }
}
