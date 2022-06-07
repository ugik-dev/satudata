<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'SPPDModel', 'GeneralModel', 'AktifitasModel'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }

    public function getAllSPPD()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Daftar Pengajuan');
            $filter = $this->input->get();
            $filter['my_perjadin'] = true;
            $data = $this->SPPDModel->getAllSPPD($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllAktifitas()
    {
        try {
            // $this->SecurityModel->userOnlyGuard();
            $filter = $this->input->get();
            $filter['my_aktifitas'] = true;
            $data = $this->AktifitasModel->getAllSPPD($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function perjadin()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Daftar Pengajuan');

            $data = array(
                'page' => 'my/perjadin',
                'title' => 'SPPD',
                // 'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function detail_perjadin($id)
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $res_data['return_data'] = $this->SPPDModel->getAllSPPD(array('id_spd' => $id))[$id];
            $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);

            $data = array(
                'page' => 'my/perjadin_detail',
                'title' => 'Form SPPD SPPD',
                'dataContent' => $res_data
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
