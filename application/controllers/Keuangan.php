<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Keuangan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'UserModel', 'GeneralModel'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = FALSE;
    }

    public function monitoring()
    {
        try {
            // echo json_encode($this->session->userdata());
            // die();
            $this->SecurityModel->multiRole('Keuangan', 'Monitoring');
            $ref  = $this->GeneralModel->getAllRefSaker();
            $data = array(
                'page' => 'master/users',
                'title' => 'Users & Hak Aksess',
                'ref_satker' => $ref
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function kode_anggaran()
    {
        try {
            $this->SecurityModel->multiRole('Keuangan', 'Kode Anggaran');
            $data = array(
                'page' => 'keuangan/kode_anggaran',
                'title' => 'Kode Anggaran'
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function action_anggaran($action)
    {
        try {
            $this->SecurityModel->multiRole('Keuangan', 'Kode Anggaran');
            $this->load->model(['KeuanganModel']);
            $data = $this->input->post();

            if ($action == 'add') {
                $data['user_input'] = $this->session->userdata('id');
                $data['id_bagian'] = $this->session->userdata('id_bagian');
            } else {
                $tmp = $this->GeneralModel->getAllKodeAnggaran(['id_anggaran' => $data['id_anggaran']])[$data['id_anggaran']];
                if ($tmp['user_input'] != $this->session->userdata('id'))
                    throw new UserException('Kamu tidak berhak melakukan aksi ini!!', UNAUTHORIZED_CODE);
            }
            $id = $this->KeuanganModel->action_anggaran($data);
            $data = $this->GeneralModel->getAllKodeAnggaran(['id_anggaran' => $id])[$id];
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
