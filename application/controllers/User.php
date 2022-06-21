<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'SPPDModel', 'GeneralModel', 'AktifitasModel', 'UserModel'));
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


    public function my_profil()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $data_profile = $this->GeneralModel->getAllUser(array('id' => $this->session->userdata('id')))[$this->session->userdata('id')];
            // echo json_encode($data_profile);
            // die();
            $data = array(
                'page' => 'my/profil',
                'title' => 'My Profile',
                'data_profile' => $data_profile

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

    public function update_my_profil()
    {
        $data =  $this->input->post();
        // echo json_encode($data);
        // die();
        // if (!empty($_FILES['filefoto'])) {
        // }
        if (!empty($data['fl_signatureFilename'])) {
            $s =  FileIO::upload2('fl_signature', 'signature', '', 'jpg|png');
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
        // var_dump($data);
        // if (!empty($_FILES['signature'])) {
        //     echo 'ada signature';
        //     die();
        //     if ($this->upload->do_upload('signature')) {
        //         $gbr = $this->upload->data();
        //         //Compress Image
        //         $config['image_library'] = 'gd2';
        //         $config['source_image'] = './upload/img/news/' . $gbr['file_name'];
        //         $config['create_thumb'] = FALSE;
        //         $config['maintain_ratio'] = FALSE;
        //         $config['quality'] = '60%';
        //         // $config['width']= 710;
        //         // $config['height']= 420;
        //         $config['new_image'] = './upload/img/news/' . $gbr['file_name'];
        //         $this->load->library('image_lib', $config);
        //         $this->image_lib->resize();

        //         $gambar = $gbr['file_name'];
        //         $jdl = $this->input->post('judul');
        //         $berita = $this->input->post('berita');

        //         // $this->NewsModel->simpan_berita($jdl, $berita, $gambar);
        //         // redirect('AdminController/news_post');
        //     } else {
        //         // redirect('AdminController/news_post');
        //     }
        // }
    }
}
