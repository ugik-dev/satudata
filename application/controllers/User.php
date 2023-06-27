<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'SPPDModel', 'GeneralModel', 'AktifitasModel', 'UserModel'));
        $this->db->db_debug = false;
    }

    public function getAllSPPD()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $filter = $this->input->get();
            $filter['my_perjadin'] = true;
            $data = $this->SPPDModel->getMyPerjadin($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllAktifitas()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
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
            $this->SecurityModel->userOnlyGuard();

            $data = array(
                'page' => 'my/perjadin',
                'title' => 'SPPD',
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function notification($id)
    {
        try {
            $data = $this->UserModel->getNotif(['id_notif' => $id, 'id_pegawai' => $this->session->userdata('id')])[$id];
            if (!empty($data)) {

                if ($data['status'] == 'U') {
                    $this->UserModel->readNotif($id);
                }
                redirect(base_url($data['url']));
            } else
                redirect(base_url('dashboard'));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function my_profil()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $data_profile = $this->GeneralModel->getAllUser(array('id' => $this->session->userdata('id')))[$this->session->userdata('id')];
            $ref  = $this->GeneralModel->getAllRefSaker();
            // echo json_encode($ref);
            // die();
            $data = array(
                'page' => 'my/profil',
                'title' => 'My Profile',
                'data_profile' => $data_profile,
                'ref_satker' => $ref

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
            $res_data['return_data'] = $this->SPPDModel->getAllSPPD(array('id_spt' => $id))[$id];
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

    public function deleteMySKP()
    {
        try {
            $this->SecurityModel->userOnlyGuard(true);
            $this->load->model('SKPModel');
            $data['id_skp'] = $this->input->get()['id_skp'];
            $data['my_skp'] = true;
            $cek = $this->SKPModel->getAll($data);
            if (!empty($cek[$data['id_skp']])) {
                if ($cek[$data['id_skp']]['status'] == 2) {
                    throw new UserException('Data sudah di aprrov tidak dapat dihapus!!', UNAUTHORIZED_CODE);
                } else {
                    $this->SKPModel->deleteMySKP($data);
                }
            } else
                throw new UserException('Kamu tidak memiliki hak ini!!', UNAUTHORIZED_CODE);

            echo json_encode(array('error' => false, 'data' => $cek));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function update_my_profil()
    {
        try {
            $data =  $this->input->post();
            // echo json_encode($data);
            // die();
            // if (!empty($_FILES['filefoto'])) {
            // }
            if (!empty($data['fl_signatureFilename'])) {
                $s =  FileIO::upload2('fl_signature', 'signature', '', 'png');
                if (!empty($s['filename']))
                    $data['signature'] = $s['filename'];
            }

            if (!empty($data['fl_foto_diriFilename'])) {
                $t = FileIO::upload2('fl_foto_diri', 'foto_profil', '', 'jpeg|jpg|png');
                if (!empty($t['filename']))
                    $data['photo'] = $t['filename'];
            }
            $data['id'] = $this->session->userdata()['id'];
            $this->UserModel->editUser($data);
            $user = $this->UserModel->getAllUser(['id_user' => $data['id']])[$data['id']];
            $this->session->set_userdata($user);

            // echo json_encode($user);
            echo json_encode(array('error' => false));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
