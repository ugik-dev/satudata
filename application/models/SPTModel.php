<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SPTModel extends CI_Model
{
    public function getAllSPPD($filter = [], $sort = false)
    {
        $ses = $this->session->userdata();

        $this->db->select('u.id_spt,  u.maksud, u.tgl_pengajuan, u.status, no_spt, no_sppd,unapprove_oleh, u.id_satuan,
        rjs.nama_ref_jen_spt rjs, l.id_laporan, sa.nama_satuan,
        s.nama nama_pelaksana,
        tj.id_tujuan, tj.tempat_tujuan,date_berangkat,date_kembali,
        pk.id_pegawai, pk.p_nama');
        $this->db->select('
            pk.p_nip
        ');
        // }
        $this->db->select('rjs.nama_ref_jen_spt');
        $this->db->from('spt as u');
        $this->db->join('satuan sa', 'sa.id_satuan = u.id_satuan');
        // $this->db->join('dasar d', 'd.id_dasar = u.id_dasar', 'LEFT');
        $this->db->join('users s', 's.id = u.id_pegawai', 'LEFT');
        $this->db->join('spt_laporan l', 'l.id_spt = u.id_spt', 'LEFT');
        // $this->db->join('users p2', 'p2.id = u.user_input', 'LEFT');
        // if (!$sort) {
        //     $this->db->join('users p', 'p.id = d.id_ppk2', 'LEFT');
        //     $this->db->join('users ptk', 'ptk.id = d.id_pptk', 'LEFT');
        //     $this->db->join('approval un', 'u.unapprove_oleh = un.id_approval', 'LEFT');
        //     $this->db->join('transport t', 't.transport = u.transport', 'LEFT');
        // }
        $this->db->join('ref_jen_spt rjs', 'u.jenis = rjs.id_ref_jen_spt', 'LEFT');
        $this->db->join('tujuan tj', 'tj.id_spt = u.id_spt', 'LEFT');
        $this->db->join('pengikut pk', 'pk.id_spt = u.id_spt', 'LEFT');
        // $this->db->group_by('id_spt');

        //Filter
        {
            if (!empty($filter['dari']) && !empty($filter['sampai'])) $this->db->where(' (
                (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" ) OR
                (tj.date_berangkat BETWEEN "' . $filter['dari'] . '" AND "' . $filter['sampai'] . '" )
                ) ');
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
                                $this->db->where("u.unapprove_oleh IS NULL AND (u.status = 11 OR (d.id_ppk2 = {$penilai['id']} AND  u.status = 6))");
                            } else if ($filter['status_permohonan'] == 'my-approv') {
                                $this->db->where("(u.status > 11 AND d.id_ppk2 = {$penilai['id']}) OR approve_sekdin = {$penilai['id']}");
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
                // if ($this->session->userdata('jen_satker') != 1)
                //     $this->db->where('u.id_satuan', $ses['id_satuan']);
            } else {
                $this->db->where('u.qrcode', $filter['qrcode']);
            }
        }
        // $this->db->where('u.id_spt', 14241);
        $res = $this->db->get()->result_array();
        // echo $this->db->last_query();
        // die();
        $res_id = [];
        // $ret = [];

        // echo json_encode($ret);
        return DataStructure::SPTStyle($res, true);
        // echo json_encode($ret, true);
        // die();

        foreach ($res as $rid) {
            array_push($res_id, $rid['id_spt']);
        }
        if (!empty($res_id)) {
            // if (!$sort) {
            $this->db->select('p.*');
            // } else {
            //     $this->db->select('p.id_spt, u.nama, r.level');
            // }

            $this->db->from('pengikut p ');
            $this->db->join('users u', 'u.id = p.id_pegawai');
            // $this->db->join('roles r', 'u.id_role = r.id_role', 'LEFT');
            $this->db->where_in('id_spt', $res_id);
            // $this->db->order_by('level,id_pengikut', 'ASC');
            $pengikut = DataStructure::groupingByParent($this->db->get()->result_array(), 'id_spt');
            // echo json_encode($pengikut);
            // die();
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
}
