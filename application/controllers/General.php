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

    public function getAllPosition()
    {
        try {
            $filter = $this->input->get();
            $data = $this->GeneralModel->getAllPosition($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
