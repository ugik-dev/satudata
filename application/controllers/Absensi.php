<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absensi extends CI_Controller
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

            $filter['tahun'] = date('Y');
            $filter['bulan'] = date('m');
            $filter['id_user'] = $this->session->userdata('id');

            $data = array(
                'page' => 'my/absensi',
                'title' => 'Absensi Saya',
            );

            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function absensi_process()
    {
        try {
            $data =  $this->input->post();
            $data_absen['id_pegawai'] = $this->session->userdata('id');
            $data_absen['longitude'] = $data['longitude'];
            $data_absen['latitude'] = $data['latitude'];
            $data_absen['lokasi'] = $data['lokasi'];
            if (!empty($_FILES['captureimage']['name'])) {
                // echo 'ada foto';
                // die();
                $s =  FileIO::uploadGd2('captureimage', 'bukti_absensi', '', 'jpg|png|jpeg');
                if (!empty($s['filename']))
                    $data_absen['file_foto'] = $s['filename'];
                else {
                    throw new UserException('Gagal Upload, terjadi kesalahahn!!', UNAUTHORIZED_CODE);
                }
            } else {
                throw new UserException('Foto harus diupload !!', UNAUTHORIZED_CODE);
            }

            $this->AbsenModel->record($data_absen);
            echo json_encode(['error' => false, 'data' => $data]);
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
