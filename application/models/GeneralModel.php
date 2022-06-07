<?php
/*

*/
class GeneralModel extends CI_Model
{
    public function getAllRole($filter = [])
    {
        $this->db->select('*');
        $this->db->from('roles');
        // DataStructure::keyValue($res->result_array(), 'id_role');
        if (!empty($filter['id_role']))
            $this->db->where('id_role', $filter['id_role']);
        $res = $this->db->get();
        // $res = $res->result_array();
        if (!empty($filter['key_id']))        return DataStructure::keyValue($res->result_array(), 'id_role');
        else
            return $res->result_array();
    }

    public function getAllMySKP($filter = [], $jk)
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
        $this->db->select("u.*,r.*, nama_bag, nama_bidang, nama_satuan, approv_lv_1, approv_lv_2, approv_lv_3, approv_lv_4, ppk, jabatan, pangkat_gol");
        $this->db->from('users as u');
        $this->db->join('roles r', 'u.id_role = r.id_role', 'LEFT');
        $this->db->join('satuan s', 'u.id_satuan = s.id_satuan', 'LEFT');
        $this->db->join('bidang bd', 'u.id_bidang = bd.id_bidang', 'LEFT');
        $this->db->join('bagian bg', 'u.id_bagian = bg.id_bagian', 'LEFT');
        if (!empty($filter['id'])) $this->db->where('u.id', $filter['id']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id');
    }


    public function getAllSatuan($filter = [])
    {
        $this->db->select('*');
        $this->db->from('satuan u ');
        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_satuan');
    }

    public function getAllPosition($filter = [])
    {
        $this->db->select('*');
        $this->db->from('user_position u ');
        $this->db->join('roles r', 'u.id_role = r.id_role');
        $this->db->join('satuan st', 'u.id_satuan = st.id_satuan');
        $this->db->join('bidang bd', 'u.id_bidang = bd.id_bidang', 'LEFT');
        $this->db->join('bagian bg', 'u.id_bagian = bg.id_bagian', 'LEFT');
        if (!empty($filter['id_user']))
            $this->db->where('id_user', $filter['id_user']);
        if (!empty($filter['id_user_position']))
            $this->db->where('id_user_position', $filter['id_user_position']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_user_position');
    }

    public function getAllSatuan2($filter = [])
    {
        $this->db->select('id_satuan as id, nama_satuan as text');
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
        $this->db->select('sc.id_skp_child as id, sc.kegiatan as text');
        // $this->db->select('u.*');
        $this->db->from('skp_child sc ');
        $this->db->join('skp s', 'sc.id_skp = s.id_skp');
        $this->db->join('users u', 's.id_user = u.id');
        $this->db->join('roles r', 'r.id_role = u.id_role');
        if ($level == 2 or $level == 4)
            $this->db->where('r.level', 1);
        if ($level == 3)
            $this->db->where('r.level', 2);
        if ($level == 5)
            $this->db->where('r.level', 4);
        // if (!empty($filter['searchTerm'])) $this->db->where('sc.kegiatan like "%' . $filter['searchTerm'] . '%"');
        // searchTerm
        $this->db->limit('20');
        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllBidang2($filter = [])
    {
        $this->db->select('id_bidang as id, nama_bidang as text');
        $this->db->from('bidang u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama_bidang like "%' . $filter['searchTerm'] . '%"');
        // searchTerm
        $this->db->limit('20');

        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllBagian2($filter = [])
    {
        $this->db->select('id_bagian as id, nama_bag as text');
        $this->db->from('bagian u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama_bag like "%' . $filter['searchTerm'] . '%"');
        // searchTerm
        $this->db->limit('20');

        // $this->db->join('roles r', 'u.id_role = r.id_role');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllRole2($filter = [])
    {
        $this->db->select('id_role as id, nama_role as text');
        $this->db->from('roles u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama_role like "%' . $filter['searchTerm'] . '%"');
        // searchTerm
        $this->db->limit('20');

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
        $this->db->select('id as id, nama as text');
        $this->db->from('users u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama like "%' . $filter['searchTerm'] . '%"');
        // $this->db->where('ppk', 1);
        $this->db->limit('20');
        $res = $this->db->get();
        return $res->result_array();
    }
    public function getAllDasar2($filter = [])
    {
        $this->db->select('id_dasar as id, CONCAT_WS(" | " , nama_dasar , kode_rekening ) as text');
        $this->db->from('dasar u ');
        if (!empty($filter['searchTerm'])) $this->db->where('nama_dasar like "%' . $filter['searchTerm'] . '%"');
        $this->db->limit('20');
        $res = $this->db->get();
        return $res->result_array();
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
