<?php
/*

*/
defined('BASEPATH') or exit('No direct script access allowed');
class General extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('GeneralModel'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }
    public function deteksi_atasan()
    {
        try {
            // $filter = $this->input->get();
            // // $filter['nature'] = 'Assets';
            $data = $this->GeneralModel->deteksi_atasan(array('id_user' => 1));

            // echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function getAllKehadian()
    {
        try {
            $filter = $this->input->get();
            $filter['date'] = date('Y-m-d');
            $this->load->model(array('AbsenModel'));
            // $data = $this->AbsenModel->getAllAbsensiM2($filter);
            // echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function getAllRole()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->GeneralModel->getAllRole($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllUser()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $filter['ex_kader'] = false;
            $data = $this->GeneralModel->getAllUser($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function getAllKader()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $filter['ex_kader'] = true;
            $data = $this->GeneralModel->getAllUser($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllSatuan()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->GeneralModel->getAllSatuan($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function getAllDasar()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->GeneralModel->getAllDasar($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function getAllKodeAnggaran()
    {
        try {
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->GeneralModel->getAllKodeAnggaran($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllMutasi()
    {
        try {
            $filter = $this->input->get();
            $data = $this->GeneralModel->getAllMutasi($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
