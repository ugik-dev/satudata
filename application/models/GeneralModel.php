<?php
/*

*/
class GeneralModel extends CI_Model
{
    public function deteksi_atasan($data = [])
    {

        $this->db->select('*');
        $this->db->from('users as u ');
        $this->db->join('roles as r ', 'u.id_role = r.id_role');
        $this->db->where('u.status', 1);
        $this->db->where('level', 2);
        $res = $this->db->get();
        $user = $res->result_array();
        // if (!empty($user)) {
        $sekre = $user[0]['id'];
        // }

        $tmp = [];
        if ($data['level'] == 6) {
            if (!empty($data['id_seksi'])) {
                $this->db->select('*');
                $this->db->from('users as u ');
                $this->db->join('roles as r ', 'u.id_role = r.id_role');
                $this->db->where('level', 5);
                $this->db->where('u.status', 1);
                $res = $this->db->get();
                $user = $res->result_array();

                // $this->db->select('*');
                // $this->db->from('role as x');
                if (!empty($user)) {
                    $tmp['atasan_1'] = $user[0]['id'];
                }
            }
            if (!empty($data['id_bagian'])) {
                $this->db->select('*');
                $this->db->from('users as u ');
                $this->db->join('roles as r ', 'u.id_role = r.id_role');
                $this->db->where_in('level', [4, 3]);
                $this->db->where('u.status', 1);
                $this->db->where('id_bagian', $data['id_bagian']);
                $res = $this->db->get();
                $user = $res->result_array();
                if (!empty($user)) {
                    $tmp['atasan_2'] = $user[0]['id'];
                }
            }
            // echo json_encode($tmp);
            // die();
        }
        if ($data['level'] == 5) {
            if (!empty($data['id_bagian'])) {
                $this->db->select('*');
                $this->db->from('users as u ');
                $this->db->join('roles as r ', 'u.id_role = r.id_role');
                $this->db->where_in('level', [4, 3]);
                $this->db->where('u.status', 1);
                $this->db->where('id_bagian', $data['id_bagian']);
                $res = $this->db->get();
                $user = $res->result_array();
                if (!empty($user)) {
                    $tmp['atasan_2'] = $user[0]['id'];
                }
            }
        }

        if ($data['level'] == 4 || $data['level'] == 3) {
            if (!empty($data['id_bagian'])) {
                $this->db->select('*');
                $this->db->from('users as u ');
                $this->db->join('roles as r ', 'u.id_role = r.id_role');
                $this->db->where('u.status', 1);
                $this->db->where('level', 2);
                $res = $this->db->get();
                $user = $res->result_array();
                if (!empty($user)) {
                    $tmp[] = $user[0]['id'];
                }
            }
        }
        if ($data['level'] == 2) {
            $this->db->select('*');
            $this->db->from('users as u ');
            $this->db->join('roles as r ', 'u.id_role = r.id_role');
            $this->db->where('u.status', 1);
            $this->db->where('level', 1);
            $res = $this->db->get();
            $user = $res->result_array();
            if (!empty($user)) {
                $tmp[] = $user[0]['id'];
            }
        }
        return $tmp;
    }

    public function getSingnature($id)
    {
        $this->db->select('id,signature,nama, nip');
        $this->db->from('users');
        $this->db->where('id', $id);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id');
    }

    public function getJenisIzin($filter = [])
    {
        $this->db->select('*');
        $this->db->from('ref_jen_izin');
        if (!empty($filter['jen_izin'])) {
            if (is_array($filter['jen_izin']))
                $this->db->where_in('jen_izin', $filter['jen_izin']);
            else
                $this->db->where('jen_izin', $filter['jen_izin']);
        }
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllRole($filter = [])
    {
        $this->db->select('*');
        $this->db->from('roles');
        if (!empty($filter['id_role']))
            $this->db->where('id_role', $filter['id_role']);
        $res = $this->db->get();
        if (!empty($filter['key_id']))        return DataStructure::keyValue($res->result_array(), 'id_role');
        else
            return $res->result_array();
    }

    public function getAllDasar($filter = [])
    {
        $this->db->select('d.*,us.nama as nama_petugas, u1.nama as nama_ppk2, u2.nama as nama_pptk');
        $this->db->from('dasar as d');
        $this->db->join('users as us', 'us.id = d.user_dasar');
        $this->db->join('users as u1', 'id_ppk2 = u1.id', 'LEFT');
        $this->db->join('users as u2', 'id_pptk = u2.id', 'LEFT');
        if (!empty($filter['id_dasar']))
            $this->db->where('id_dasar', $filter['id_dasar']);

        if ($this->session->userdata('id_role') != 1) {
            if (!empty($this->session->userdata('id_bagian'))) $this->db->where('d.id_bagian', $this->session->userdata('id_bagian'));
            $this->db->where('d.id_satuan', $this->session->userdata('id_satuan'));
        }
        $res = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return DataStructure::keyValue($res->result_array(), 'id_dasar');
    }
    public function getAllKodeAnggaran($filter = [])
    {
        $this->db->select('d.*,us.nama as nama_petugas, u1.nama as nama_ppk2, u2.nama as nama_pptk');
        $this->db->from('kode_anggaran as d');
        $this->db->join('users as us', 'us.id = d.user_input');
        $this->db->join('users as u1', 'id_ppk = u1.id', 'LEFT');
        $this->db->join('users as u2', 'id_pptk = u2.id', 'LEFT');
        if (!empty($filter['id_dasar']))
            $this->db->where('id_dasar', $filter['id_dasar']);

        if ($this->session->userdata('id_role') != 1) {
            if (!empty($this->session->userdata('id_bagian'))) $this->db->where('d.id_bagian', $this->session->userdata('id_bagian'));
            $this->db->where('d.id_satuan', $this->session->userdata('id_satuan'));
        }
        $res = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return DataStructure::keyValue($res->result_array(), 'id_anggaran');
    }

    public function getAllMySKP($filter, $jk)
    {
        $this->db->select('sc.id_skp_child as id, sc.kegiatan as text');
        $this->db->from('skp_child as sc');
        $this->db->join('skp as s', 'sc.id_skp = s.id_skp');
        // DataStructure::keyValue($res->result_array(), 'id_role');
        // if (!empty($filter['searchTerm']))
        $this->db->where('s.id_user', $this->session->userdata('id'));
        $this->db->where('sc.jenis_keg', $jk);
        if (!empty($filter['searchTerm'])) $this->db->where('sc.kegiatan like "%' . $filter['searchTerm'] . '%"');

        $this->db->limit('20');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllUser($filter = [])
    {
        $this->db->select("u.*,r.*, nama_bag, nama_seksi, nama_satuan, jabatan, pangkat_gol, s.jen_satker");
        $this->db->from('users as u');
        $this->db->join('roles r', 'u.id_role = r.id_role', 'LEFT');
        $this->db->join('satuan s', 'u.id_satuan = s.id_satuan', 'LEFT');
        $this->db->join('ref_seksi sk', 'u.id_seksi= sk.id_ref_seksi', 'LEFT');
        $this->db->join('bagian bg', 'u.id_bagian = bg.id_bagian', 'LEFT');
        $this->db->where('u.deleted_user', 0);
        if (!empty($filter['id'])) $this->db->where('u.id', $filter['id']);
        if (isset($filter['ex_kader'])) {
            // echo "ad";
            // die();
            if ($filter['ex_kader'])
                $this->db->where('u.id_role = 99');
            else
                $this->db->where('u.id_role <> 99');
        }
        if ($this->session->userdata()['id_role'] != 1) {
            $this->db->where('u.id_satuan', $this->session->userdata()['id_satuan']);
        }
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id');
    }


    public function getAllSatuan($filter = [])
    {
        $this->db->select('u.* , b.nama as nama_bendahara, c.nama as nama_bendahara_pem,e.nama as nama_bendahara_pem_blud, d.nama as nama_verif_cuti');
        $this->db->from('satuan u ');
        $this->db->join('users b', 'u.bendahara = b.id', 'LEFT');
        $this->db->join('users c', 'u.bendahara_pem = c.id', 'LEFT');
        $this->db->join('users d', 'u.verif_cuti = d.id', 'LEFT');
        $this->db->join('users e', 'u.bendahara_pem_blud = e.id', 'LEFT');
        if (!empty($filter['id_satuan'])) $this->db->where('u.id_satuan', $filter['id_satuan']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_satuan');
    }
    public function getSign($filter = [])
    {
        $this->db->select('*');
        $this->db->from('sign u ');
        $this->db->where('id_sign', $filter['id']);
        $res = $this->db->get()->result_array();
        return $res;
        // return DataStructure::keyValue($res->result_array(), 'id_satuan');
    }
    public function getSKPApprov($filter = [])
    {
        $this->db->select('*');
        $this->db->from('skp_approv u ');
        if (!empty($filter['id_skp'])) $this->db->where('id_skp', $filter['id_skp']);
        $res = $this->db->get();
        return $res->result_array();
        // return DataStructure::keyValue($res->result_array(), 'id_satuan');
    }

    public function getAllMutasi($filter = [])
    {
        $this->db->select('u.*, r.nama_role, st.nama_satuan, sk.nama_seksi, bg.nama_bag');
        $this->db->from('mutasi u ');
        $this->db->join('roles r', 'u.id_role = r.id_role', 'LEFT');
        $this->db->join('satuan st', 'u.id_satuan = st.id_satuan', 'LEFT');
        $this->db->join('ref_seksi sk', 'u.id_seksi= sk.id_ref_seksi', 'LEFT');
        $this->db->join('bagian bg', 'u.id_bagian = bg.id_bagian', 'LEFT');
        if (!empty($filter['id_user']))
            $this->db->where('id_user', $filter['id_user']);
        if (!empty($filter['id_mutasi']))
            $this->db->where('id_mutasi', $filter['id_mutasi']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_mutasi');
    }

    public function getAllSatuan2($filter = [])
    {
        $this->db->select('id_satuan as id, nama_satuan as text, jen_satker as jenis');
        $this->db->from('satuan u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama_satuan like "%' . $filter['searchTerm'] . '%"');
        // searchTerm
        $this->db->limit('20');

        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getRencanaKinerjaAtasan($filter = [])
    {
        // echo json_encode($this->session->userdata('level'));
        // die();
        $level = $this->session->userdata('level');
        if ($level == 1)
            return [];
        $this->db->select('sc.id_skp_child as id, CONCAT(u.nama , " | ", sc.kegiatan) as text');
        // $this->db->select('u.*');
        $this->db->from('skp_child sc ');
        $this->db->join('skp s', 'sc.id_skp = s.id_skp');
        $this->db->join('users u', 's.id_user = u.id');
        $this->db->join('roles r', 'r.id_role = u.id_role');
        if ($level == 2 or $level == 4) {
            // $this->db->where('s.status' == '');
            $this->db->where('r.level', 1);
        } else if ($level == 3) {
            $this->db->where('s.status' == '2');
            $this->db->where('r.level', 2);
        } else
        if ($level == 5) {
            $this->db->where('s.status' == '2');
            $this->db->where('r.level', 4);
        }
        if (!empty($filter['searchTerm'])) $this->db->where('sc.kegiatan like "%' . $filter['searchTerm'] . '%"');
        // searchTerm
        $this->db->limit('20');
        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllSeksi2($filter = [])
    {
        $this->db->select('id_ref_seksi as id, nama_seksi as text');
        $this->db->from('ref_seksi u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama_seksi like "%' . $filter['searchTerm'] . '%"');
        if (!empty($filter['bagian'])) $this->db->where('id_bidang', $filter['bagian']);
        // searchTerm
        $this->db->limit('20');

        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllBagian2($filter = [])
    {
        $this->db->select('id_bagian as id, nama_bag as text, jenis_bagian jenis');
        $this->db->from('bagian u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama_bag like "%' . $filter['searchTerm'] . '%"');
        // searchTerm
        $this->db->limit('20');

        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllRefSaker($filter = [])
    {
        $this->db->select('id_bagian as id, nama_bag as text, jenis_bagian jenis');
        $this->db->from('bagian u ');
        $res = $this->db->get();
        $result['bagian'] =  DataStructure::keyValue($res->result_array(), 'id');
        // $res->result_array();

        $this->db->select('id_satuan as id, nama_satuan as text, jen_satker jenis');
        $this->db->from('satuan u ');
        $res = $this->db->get();
        $result['satuan'] =  DataStructure::keyValue($res->result_array(), 'id');

        return $result;
    }

    public function getAllRole2($filter = [])
    {
        $jen_satker = $this->session->userdata('jen_satker');
        $this->db->select('id_role as id, nama_role as text');
        $this->db->from('roles u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama_role like "%' . $filter['searchTerm'] . '%"');
        // searchTerm
        $this->db->limit('20');
        if ($jen_satker != 1) {
            $this->db->where("u.jen_satker = $jen_satker OR u.jen_satker = 0");
        }
        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return $res->result_array();
    }
    public function getSatuan($filter = [])
    {
        // $this->db->select('id_role as id, nama_role as text');
        $this->db->from('satuan u ');
        if (!empty($filter['id_satuan'])) $this->db->where('id_satuan', $filter['id_satuan']);
        // searchTerm
        // $this->db->limit('20');

        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllPPK2($filter = [])
    {
        $this->db->select('id as id, nama as text');
        $this->db->from('users u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama like "%' . $filter['searchTerm'] . '%"');
        $this->db->where('ppk', 1);
        $this->db->limit('20');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllPegawai2($filter = [])
    {
        // if ($this->session->userdata()['id_role'] == 1) {
        $this->db->select('id as id, CONCAT(u.nama, " | " , COALESCE(s.nama_satuan,""), COALESCE(CONCAT(" - " , b.nama_bag),"")) as text');
        // } else if ($this->session->userdata()['id_satuan'] == 1) {
        //     $this->db->select('id as id, CONCAT(u.nama, " | " , b.nama_bag) as text');
        // } else {
        //     $this->db->select('id as id, u.nama as text');
        // }

        $this->db->from('users u ');
        $this->db->join('bagian b', 'u.id_bagian = b.id_bagian', 'LEFT');
        $this->db->join('satuan s', 'u.id_satuan = s.id_satuan', 'LEFT');
        $this->db->where('u.deleted_user', 0);
        if (!empty($filter['searchTerm'])) $this->db->where('CONCAT(u.nama, " " ,s.nama_satuan) like "%' . $filter['searchTerm'] . '%"');
        // if ($this->session->userdata()['id_satuan'] == 1) {
        // } else {
        //     $this->db->where('u.id_satuan', $this->session->userdata()['id_satuan']);
        //     // $this->db->join('satuan s', 'u.id_satuan = s.id_satuan', 'LEFT');
        // }
        // }
        // if (!empty($filter['id_satuan'])) $this->db->where('u.id_satuan', $filter['id_satuan']);
        // $this->db->where('ppk', 1);
        $this->db->limit('20');
        $res = $this->db->get();
        // echo $this->db->last_query();
        // die();
        return $res->result_array();
    }
    public function getAllDasar2($filter = [])
    {
        $this->db->select('id_dasar as id, CONCAT_WS(" | " , nama_dasar , kode_rekening ) as text');

        $this->db->from('dasar u ');
        if ($this->session->userdata()['id_role'] != 1) {
            $this->db->where('u.id_satuan', $this->session->userdata()['id_satuan']);
        }
        if (!empty($filter['searchTerm'])) $this->db->where('(nama_dasar like "%' . $filter['searchTerm'] . '%" OR kode_rekening like "%' . $filter['searchTerm'] . '%")');
        $this->db->limit('20');
        $res = $this->db->get();
        return $res->result_array();
        // 1.02.02
    }

    public function getAllTransport($filter = [])
    {
        $this->db->select('*');
        $this->db->from('transport u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama_dasar like "%' . $filter['searchTerm'] . '%"');
        $this->db->limit('20');
        $res = $this->db->get();
        return $res->result_array();
    }



    function getRomawi($bln)
    {
        switch ($bln) {
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
}
