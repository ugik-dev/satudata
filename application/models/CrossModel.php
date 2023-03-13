<?php
/*

*/
class CrossModel extends CI_Model
{
    public function getBeritaPuskesmas($filter = [])
    {
        $DB2 = $this->load->database('puskesmas', TRUE);
        $DB2->select('pkm,tulisan_id,tulisan_judul,tulisan_tanggal,tulisan_slug,tulisan_jenis');
        $DB2->from('v_tbl_tulisan');
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
}
