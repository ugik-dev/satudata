<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'AbsenModel'));
        // $this->load->helper(array('DataStructure'));
        // $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }



    public function index()
    {
        try {
            // $this->SecurityModel->userOnlyGuard();

            $data = array(
                'page' => 'my/cuti',
                'title' => 'Cuti Saya',
                // 'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function record()
    {
        try {
            // $res_data['form_url'] = 'absen/record';
            $res_data['location'] = $this->AbsenModel->getLocation();
            $data = array(
                'page' => 'my/absen_record',
                'title' => 'Record Absen',
                'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
