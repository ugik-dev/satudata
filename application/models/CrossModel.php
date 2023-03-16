<?php
/*

*/
class CrossModel extends CI_Model
{
    public function getBeritaPuskesmas($filter = [])
    {
        $DB2 = $this->load->database('puskesmas', TRUE);
        $DB2->select('pkm,tulisan_id,tulisan_judul,tulisan_tanggal,tulisan_slug,tulisan_jenis,tulisan_gambar');
        $DB2->from('v_tbl_tulisan');
        if (!empty($filter['limit']))
            $DB2->limit($filter['limit']);
        else
            $DB2->limit('50');
        $DB2->where('tulisan_tanggal is not null');
        $DB2->where('tulisan_tanggal <> "0000-00-00"');
        if (!empty($filter['dari'])) $DB2->where('tulisan_tanggal >="' . $filter['dari'] . '"');
        if (!empty($filter['sampai'])) $DB2->where('tulisan_tanggal <="' . $filter['sampai'] . '"');
        if (!empty($filter['pkm'])) $DB2->where('pkm = "' . $filter['pkm'] . '"');
        $DB2->order_by('tulisan_tanggal', 'DESC');
        $res = $DB2->get()->result_array();
        return $res;
    }

    public function getStatistic($filter = [])
    {

        $filter['bulan'] = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        ini_set('display_errors', 0);
        $DB2 = $this->load->database('puskesmas', TRUE);
        ExceptionHandler::handleDBError($DB2->error(), "Server Error", "Puskesmas");

        $DB2->select("nama_db,label_pkm");
        $DB2->from("ref_pkm");
        $pkm = $DB2->get();
        // $pkm =  $DB2->get()->result_array();
        ExceptionHandler::handleDBError($DB2->error(), "Server Error", "");
        $pkm = $pkm->result_array();

        $DB2->select('pkm,count(tulisan_id) jml,MONTH(tulisan_tanggal) AS bulan,YEAR(tulisan_tanggal) AS tahun');
        $DB2->from('v_tbl_tulisan');
        if (!empty($filter['tahun'])) $DB2->where('YEAR(tulisan_tanggal)', $filter['tahun']);
        if (!empty($filter['month'])) $DB2->where('MONTH(tulisan_tanggal)', $filter['month']);
        if (!empty($filter['bulan'])) $DB2->where_in('MONTH(tulisan_tanggal)', $filter['bulan']);
        // $DB2->where('  pkm = "bakam"');
        $DB2->order_by('pkm', 'DESC');
        $DB2->group_by('pkm, bulan');
        $res = $DB2->get()->result_array();
        // echo json_encode($res);
        // die();
        // tahunan
        $DB2->select('pkm,count(tulisan_id) jml,YEAR(tulisan_tanggal) AS tahun');
        $DB2->from('v_tbl_tulisan');
        if (!empty($filter['tahun'])) $DB2->where('YEAR(tulisan_tanggal)', $filter['tahun']);
        $DB2->order_by('pkm', 'DESC');
        $DB2->group_by('pkm, tahun');
        $res_t = $DB2->get()->result_array();

        $newData = [];
        $newPkmTahunan = [];
        foreach ($pkm as $p) {
            $newPkmTahunan[$p['nama_db']] = '0';
            $newData[$p['nama_db']] = ['name' => $p['label_pkm'], 'data' => []];
        }
        $bulan_terbesar = 1;
        foreach ($res as $r) {
            if ((int)$r['bulan'] > $bulan_terbesar) $bulan_terbesar = (int) $r['bulan'];
        }

        foreach ($res as $r) {
            $newData[$r['pkm']]['data'][(int)$r['bulan'] - 1] = $r['jml'];
        }

        foreach ($newData as $key => $d) {
            for ($i = 1; $i <= $bulan_terbesar; $i++) {
                if (empty($newData[$key]['data'][$i - 1])) {
                    $newData[$key]['data'][$i - 1] = (string)'0';
                }
            }
            // $b = array_values($newData[$key]['data']);
            // // $newData[$key]['data'] = DataStructure::associativeToArray($newData[$key]['data']);
            // if ($key == 'bakam') {
            //     // echo json_encode($newData[$key]['data']);
            //     echo json_encode($b);
            //     die();
            // }
        }

        $newBulan = [];
        for ($i = 1; $i <= $bulan_terbesar; $i++) {
            $newBulan[] = $i;
        }

        foreach ($res_t as $r2) {
            $newPkmTahunan[$r2['pkm']] = $r2['jml'];
        }



        $data_tahunan = ['nama_pkm' => [], 'data_pkm' => []];
        foreach ($newPkmTahunan as $key => $d2) {
            $data_tahunan['nama_pkm'][] = $newData[$key]['name'];
            $data_tahunan['data_pkm'][] = $d2;
        }

        $newData2 = DataStructure::associativeToArray($newData);
        // $data_tahunan = ['nama_pkm' => $nama]

        // return $res;
        // echo json_encode($newData2);
        // die();
        ExceptionHandler::handleDBError($DB2->error(), "Server Error", "");

        return ['data' => $newData2, 'bulan' => $newBulan, 'data_tahunan' => $data_tahunan];
    }
}
