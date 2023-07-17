<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model
{


    public function  getLiveChat($filter = [])
    {
        $this->db->select('lc.* , nama , u.photo photo_user');
        $this->db->from('live_chat as lc');
        $this->db->join('users as u', 'lc.id_user = u.id');
        // if (!empty($filter['last_id']))
        if (isset($filter['last_id'])) {
            if ($filter['last_id'] == 0) {
                $this->db->where('id_chat > ', $filter['last_id']);
                $this->db->order_by('id_chat', 'DESC');
                $this->db->limit('5');
                // $this->db->offside('5');
            } else {
                $this->db->where('id_chat > ', $filter['last_id']);
            }
        }
        if (isset($filter['loadmore_id'])) {
            // if ($filter['last_id'] == 0) {
            $this->db->where('id_chat <', $filter['loadmore_id']);
            $this->db->order_by('id_chat', 'desc');
            $this->db->limit('5');
            // $this->db->offside('5');
            // } else {
            //     $this->db->where('id_chat > ', $filter['last_id']);
            // }
        }
        $res = $this->db->get();
        ExceptionHandler::handleDBError($this->db->error(), "Edit Dasar", "Dasar");

        $res = $res->result_array();
        $res =   DataStructure::keyValue($res, 'id_chat');
        return $res;
    }

    public function updateAktifitasHarian($data)
    {


        // echo json_encode($data);
        // die();

        $push_data = [];
        foreach ($data as $r) {
            // if (!empty($r['total'])) {
            // $data['id_satuan'][] = $r['id_satuan'];
            // $data['nama'][] = $r['sort_name'];
            // $data['total'][] = !empty($r['total']) ? $r['total'] : 0;
            // $data['sudah'][] = !empty($r['lpd']) ? $r['lpd'] : 0;
            // $data['belum'][] =  (!empty($r['total']) ? $r['total'] : 0) - (!empty($r['lpd']) ? $r['lpd'] : 0);
            $pelaksana = $r['nama_pelaksana'];
            $tujuan = '';
            if (!empty($r['pengikut'])) {
                $i = 1;
                foreach ($r['pengikut'] as $p) {
                    $pelaksana .= "\r\n" . $i . '. ' . $p['nama'];
                    $i++;
                }
            }
            if (!empty($r['tujuan'])) {
                $i = 1;
                foreach ($r['tujuan'] as $t) {
                    if ($i == 1)
                        $tujuan .=  $i . '. ' . $t['tempat_tujuan'];
                    else
                        $tujuan .= ",\r\n" . $i . '. ' .  $t['tempat_tujuan'];
                    $i++;
                }
            }

            $push_data[] = [
                'id_spt' => $r['id_spt'],
                'maksud' => $r['maksud'],
                'id_satuan' => $r['id_satuan'],
                'instansi' => $r['nama_satuan'],
                'tujuan' => $tujuan,
                'pelaksana' => $pelaksana,
                'status' => $r['status'],

            ];
            // }
        }
        // echo json_encode($push_data);
        // die();
        $this->db->truncate('res_aktifitas_harian');
        $this->db->insert_batch('res_aktifitas_harian', $push_data);
    }

    public function updateInfoSPTPkm()
    {

        $this->db->select('sa.id_satuan, sort_name, COUNT(id_laporan) lpd,COUNT(s.id_spt) total');
        $this->db->from('`satuan` as sa');
        $this->db->join('spt as s ', 's.id_satuan = sa.id_satuan');
        $this->db->join('spt_laporan as l ', 's.id_spt = l.id_spt', 'LEFT');
        $this->db->where('status', 99);
        $this->db->where('sa.jen_satker', 2);
        $this->db->group_by('sa.id_satuan');
        $this->db->order_by('sa.jen_satker');
        $res = $this->db->get();

        ExceptionHandler::handleDBError($this->db->error(), "Gagal Mendapatkan Info SPT PKM");
        $res = $res->result_array();

        $data['id_satuan'] = [];
        $data['nama'] = [];
        $data['total'] = [];
        $data['belum'] = [];
        $data['sudah'] = [];
        $push_data = [];
        foreach ($res as $r) {
            if (!empty($r['total'])) {
                $data['id_satuan'][] = $r['id_satuan'];
                $data['nama'][] = $r['sort_name'];
                $data['total'][] = !empty($r['total']) ? $r['total'] : 0;
                $data['sudah'][] = !empty($r['lpd']) ? $r['lpd'] : 0;
                $data['belum'][] =  (!empty($r['total']) ? $r['total'] : 0) - (!empty($r['lpd']) ? $r['lpd'] : 0);
                $push_data = [
                    'id_satuan' => $r['id_satuan'],
                    'nama' => $r['sort_name'],
                    'total' => !empty($r['total']) ? $r['total'] : 0,
                    'sudah' =>  !empty($r['lpd']) ? $r['lpd'] : 0,
                    'belum' => (!empty($r['total']) ? $r['total'] : 0) - (!empty($r['lpd']) ? $r['lpd'] : 0),

                ];
                $this->db->replace('res_infospt_x_dinkes', $push_data);
            }
        }
    }
    public function getInfoSPTPkm($filter = [])
    {

        $res = $this->db->get('res_infospt_x_dinkes');
        ExceptionHandler::handleDBError($this->db->error(), "Edit Dasar", "Dasar");

        $res = $res->result_array();

        $data['id_satuan'] = [];
        $data['nama'] = [];
        $data['total'] = [];
        $data['belum'] = [];
        $data['sudah'] = [];
        $last_update = null;
        foreach ($res as $r) {
            if (!empty($r['total'])) {
                $data['id_satuan'][] = $r['id_satuan'];
                $data['nama'][] = $r['nama'];
                $data['total'][] = !empty($r['total']) ? $r['total'] : 0;
                $data['sudah'][] = !empty($r['sudah']) ? $r['sudah'] : 0;
                $data['belum'][] =  !empty($r['belum']) ? $r['belum'] : 0;
                $last_update = $r['update_at'];
            }
        }
        return [
            'update_at' => $last_update,
            'data' => $data
        ];
    }

    public function getInfoSPT($filter = [])
    {

        $this->db->select('count(*) as jml, sat.nama_satuan');
        $this->db->from('spt as s');
        $this->db->join('satuan as sat', 's.id_satuan = sat.id_satuan');
        // $this->db->where('status', 99);
        $this->db->group_by('s.id_satuan');
        $res = $this->db->get();
        ExceptionHandler::handleDBError($this->db->error(), "Edit Dasar", "Dasar");
        $res = $res->result_array();
        $data['nama'] = [];
        $data['jml'] = [];
        foreach ($res as $r) {
            if (!empty($r['jml'])) {
                $data['nama'][] = $r['nama_satuan'];
                $data['jml'][] = $r['jml'];
            }
        }
        return $data;
    }

    public function getAktifitasHarian($filter = [])
    {

        // $this->db->select('count(*) as jml, sat.nama_satuan');
        $this->db->from('res_aktifitas_harian as s');
        // $this->db->join('satuan as sat', 's.id_satuan = sat.id_satuan');
        if (!empty($filter['id_satuan']))
            $this->db->where('id_satuan', $filter['id_satuan']);
        // $this->db->group_by('s.id_satuan');
        $res = $this->db->get();
        ExceptionHandler::handleDBError($this->db->error(), "Edit Dasar", "Dasar");
        $res = $res->result_array();
        return $res;
    }

    public function send_live_chat($data)
    {
        $data['time_chat'] = date('Y-m-d h:i:s');
        $this->db->insert('live_chat', DataStructure::slice($data, [
            'id_user', 'text', 'time_chat'
        ], FALSE));

        ExceptionHandler::handleDBError($this->db->error(), "Live Chat", "Live Chat");
        $id = $this->db->insert_id();
        return $id;
    }
}
