<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Sppd extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'SPPDModel', 'GeneralModel'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }

    public function getAllSPPD()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Daftar Pengajuan');
            $filter = $this->input->get();
            // $filter['nature'] = 'Assets';
            $data = $this->SPPDModel->getAllSPPD($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getDasar($id)
    {
        try {
            $data = $this->SPPDModel->getDasar($id);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getPengikut($id)
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Daftar Pengajuan');
            $filter = $this->input->get();
            $data = $this->SPPDModel->getPengikut($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function getDetailSPPD($id)
    {
        // $res = $this->SPPDModel->getAllSPPD(array('id_spd' => $id))[$id];
        // $res['pengikut'] = $this->SPPDModel->getPengikut($id);
        // $res['dasar_tambahan'] = $this->SPPDModel->getDasar($id);
    }
    public function edit($id)
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $res_data['return_data'] = $this->SPPDModel->getAllSPPD(array('id_spd' => $id))[$id];
            $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);

            $res_data['form_url'] = 'sppd/edit_process';
            $data = array(
                'page' => 'sppd/form',
                'title' => 'Form SPPD SPPD',
                'dataContent' => $res_data
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function detail($id)
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $res_data['return_data'] = $this->SPPDModel->getAllSPPD(array('id_spd' => $id))[$id];
            $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);
            // echo json_encode($res_data);
            // die();
            $data = array(
                'page' => 'sppd/detail',
                'title' => 'Form SPPD SPPD',
                'dataContent' => $res_data
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function action($action, $id)
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $dataContent['return_data'] = $this->SPPDModel->getAllSPPD(array('id_spd' => $id))[$id];
            // $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            // $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);
            // echo json_encode($res_data);
            // die();

            $cur_user = $this->session->userdata();
            // echo $dataContent['return_data']['id_bagian'];
            // var_dump($cur_user);
            if ($cur_user['level'] == 2 && $dataContent['return_data']['id_bagian_pegawai'] == $cur_user['id_bagian']) {
                if ($dataContent['return_data']['status'] == 0) {
                    if ($action == 'approv') {
                        $this->SPPDModel->approv($dataContent['return_data']);
                    }
                    if ($action == 'unapprov') {
                        $this->SPPDModel->unapprov($dataContent['return_data']);
                    }
                } else if ($dataContent['return_data']['status'] == 1 && $dataContent['return_data']['id_unapproval'] == $cur_user['id']) {
                    if ($action == 'undo') {
                        $this->SPPDModel->undo($dataContent['return_data']);
                    }
                } else
                    throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
                // echo ' <a class="btn btn-warning" id="batal_aksi" ><i class="fa fa-undo"></i><strong>Batalkan Tindakan </strong></a>';
            } else {
                throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
            }
            echo json_encode(array('error' => false));
            // $data = array(
            //     'page' => 'sppd/detail',
            //     'title' => 'Form SPPD SPPD',
            //     'dataContent' => $res_data
            // );
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }



    public function create()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');

            $res_data['form_url'] = 'sppd/create_process';

            $data = array(
                'page' => 'sppd/form',
                'title' => 'Form SPPD SPPD',
                'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function daftar_pengajuan()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Daftar Pengajuan');

            $data = array(
                'page' => 'sppd/daftar',
                'title' => 'SPPD',
                // 'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function create_process()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->post();
            $id =  $this->SPPDModel->addSPPD($data);
            echo json_encode(array('error' => false, 'data' => $id));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function edit_process()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->post();
            $id =  $this->SPPDModel->editSPPD($data);
            echo json_encode(array('error' => false, 'data' => $id));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function delete_dasar_tambahan()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->get();
            $this->SPPDModel->deleteDasarTambahan($data);
            echo json_encode(array('error' => false, 'data' => $data));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
