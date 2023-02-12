<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kepegawaian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'AbsenModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }


    public function getAllAbsensi()
    {
        try {
            $filter = $this->input->get();
            if (empty($filter['tahun']))
                $filter['tahun'] = date('Y');
            if (empty($filter['bulan']))
                $filter['bulan'] = date('m');
            // $filter['id_pegawai'] = $id_user = $this->session->userdata('id');
            $data = $this->AbsenModel->getAllAbsensiM2($filter);
            // echo json_encode($data);
            // die();
            return $data;
            // echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function absensi()
    {
        try {
            $filter = $this->input->get();
            if (empty($filter['tahun']))
                $filter['tahun'] = date('Y');
            if (empty($filter['bulan']))
                $filter['bulan'] = date('m');

            $data = array(
                'page' => 'rekap/absensi',
                'title' => 'Absensi Saya',
                'filter' => $filter,
                'dataAbsen' => $this->AbsenModel->getAllAbsensiM2($filter)
            );

            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
