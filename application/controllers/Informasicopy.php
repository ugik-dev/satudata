<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Informasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'PengumumanModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }
    public function getAllPengumuman()
    {
        try {
            $filter = $this->input->get();
            $data =  $this->PengumumanModel->getAll();
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function lihat_pengumuman($id)
    {
        try {
            $data =  $this->PengumumanModel->getAll(['id_pengumuman' => $id, 'detail' => true])[$id];
            // echo json_encode(['error' => false, 'data' => $data]);
            $data = array(
                'page' => 'pengumuman/lihat',
                'title' => $data['judul'],
                'dataContent' => $data
            );

            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function pengumuman()
    {
        try {
            $this->SecurityModel->multiRole('Informasi', ['Pengumuman'], true);
            $filter['tahun'] = date('Y');
            $filter['bulan'] = date('m');
            $filter['id_user'] = $this->session->userdata('id');

            $data = array(
                'page' => 'pengumuman/list',
                'title' => 'Pengumuman',
            );

            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function action_pengumuman()
    {
        try {
            // var_dump($_FILES['file_pdf']['name']);
            // die();
            $data = $this->input->post();
            if (!empty($_FILES['file_pdf']['name'])) {
                // echo "s";
                $s =  FileIO::upload2('file_pdf', 'pengumuman_pdf', '', 'pdf');
                if (!empty($s['filename']))
                    $dataPost['pdf'] = $s['filename'];
            }

            if (!empty($_FILES['file_sampul']['name'])) {
                $t = FileIO::uploadGd2('file_sampul', 'pengumuman_sampul', '', 'jpeg|jpg|png');
                if (!empty($t['filename']))
                    $dataPost['sampul'] = $t['filename'];
            }
            if ($data['satuan'] == 'satuan_kerja') {
                $dataPost['untuk_satuan'] = $this->session->userdata('id_satuan');
            }
            $dataPost['id_satuan'] = $this->session->userdata('id_satuan');

            $dataPost['judul'] = $data['judul'];
            $dataPost['pengumuman_isi'] = $data['pengumuman_isi'];
            $dataPost['id_user'] = $this->session->userdata('id');
            $dataPost = $this->PengumumanModel->add($dataPost);
            echo json_encode(['error' => false, 'data' => $dataPost]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function tambah_pengumuman()
    {
        try {
            $this->SecurityModel->multiRole('Informasi', ['Pengumuman'], true);
            $res_data['form_url'] = 'pengumuman/form';

            $data = array(
                'page' => 'pengumuman/form',
                'title' => 'Pengumuman > Tambah',
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
