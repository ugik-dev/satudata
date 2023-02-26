<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Search extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'UserModel', 'GeneralModel'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }



    public function satuan_kerja()
    {
        try {
            // $this->SecurityModel->multiRole('Master', 'Satuan / Unit');
            $filter = $this->input->get();
            $data  = $this->GeneralModel->getAllSatuan2($filter);
            echo json_encode($data);
            // echo json_encode(array('data ' => $data, 'pagination' => array('more' => true)));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function seksi()
    {
        try {
            $filter = $this->input->get();
            $data = $this->GeneralModel->getAllSeksi2($filter);
            array_unshift($data, array('id' => 'NULL', 'text' => '--'));
            echo json_encode($data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function bagian()
    {
        try {
            $filter = $this->input->get();
            $data = $this->GeneralModel->getAllBagian2($filter);
            array_unshift($data, array('id' => 'NULL', 'text' => '--'));
            echo json_encode($data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function role()
    {
        try {
            $filter = $this->input->get();
            $data = $this->GeneralModel->getAllRole2($filter);
            array_unshift($data, array('id' => 'NULL', 'text' => '--'));

            echo json_encode($data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function ppk()
    {
        try {
            $filter = $this->input->get();
            $data = $this->GeneralModel->getAllPPK2($filter);
            echo json_encode($data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function dasar()
    {
        try {
            $filter = $this->input->get();
            $data = $this->GeneralModel->getAllDasar2($filter);
            echo json_encode($data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function skp()
    {
        try {
            $filter = $this->input->get();

            $def[0] = ['id' => 'non_skp', 'text' => 'NON SKP'];
            // $def[1] = ['id' => 'tt', 'text' => 'TUGAS TAMBAHAN'];
            $def2 = $this->GeneralModel->getAllMySKP($filter, 'KU');
            $def3 = $this->GeneralModel->getAllMySKP($filter, 'KT');
            $data[0] = ['text' => 'NON SKP', 'children' => $def];
            $data[1] = ['text' => 'SKP - Kegiatan Utama', 'children' => $def2];
            $data[2] = ['text' => 'SKP - Kegiatan Tambahan', 'children' => $def3];
            // $data = array_merge($def, $def2);
            echo json_encode($data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function skp_atasan()
    {
        try {
            $filter = $this->input->get();
            $def[0] = ['id' => 'null', 'text' => '-'];
            $def2 = $this->GeneralModel->getRencanaKinerjaAtasan($filter);
            $data = array_merge($def, $def2);
            echo json_encode($data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function pegawai()
    {
        try {
            $filter = $this->input->get();
            $data = $this->GeneralModel->getAllPegawai2($filter);
            echo json_encode($data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function transport()
    {
        try {
            $filter = $this->input->get();
            $data = $this->GeneralModel->getAllTransport($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
