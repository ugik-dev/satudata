<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'AbsenModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }


    public function getAllAbsensi()
    {
        try {
            $filter = $this->input->get();
            if (empty($filter['tahun']))
                $filter['tahun'] = date('Y');
            if (empty($filter['bulan']))
                $filter['bulan'] = date('m');
            $filter['id_pegawai'] = $id_user = $this->session->userdata('id');
            $data = $this->AbsenModel->getAllAbsensi($filter);
            // echo json_encode($data);
            // die();
            echo json_encode(['error' => false, 'data' => !empty($data[$id_user]['child']) ? $data[$id_user]['child'] : []]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function index()
    {
        try {
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

            $current_time = date('H:i');
            // $current_time = '18:30';
            $pagi1 = "6:00";
            $pagi2 = "12:00";
            $sore1 = "16:00";
            $sore2 = "20:00";
            $current_time = DateTime::createFromFormat('H:i', $current_time);
            $pagi1 = DateTime::createFromFormat('H:i', $pagi1);
            $pagi2 = DateTime::createFromFormat('H:i', $pagi2);
            $sore1 = DateTime::createFromFormat('H:i', $sore1);
            $sore2 = DateTime::createFromFormat('H:i', $sore2);
            // $date3 = DateTime::createFromFormat('h:i a', $sunset);

            if ($pagi1 <= $current_time && $current_time  <= $pagi2) {
                $data_absen['jenis'] = 'p';
            } else if ($sore1 <= $current_time && $current_time  <= $sore2) {
                $data_absen['jenis'] = 's';
            } else {
                throw new UserException('Tidak diizinkan absen diwaktu ini!!', UNAUTHORIZED_CODE);
            }
            $data_absen['st_absen'] = 'h';
            // if (!empty($_FILES['captureimage']['name'])) {
            //     $s =  FileIO::uploadGd2('captureimage', 'bukti_absensi', '', 'jpg|png|jpeg');
            //     if (!empty($s['filename']))
            //         $data_absen['file_foto'] = $s['filename'];
            //     else {
            //         throw new UserException('Gagal Upload, terjadi kesalahahn!!', UNAUTHORIZED_CODE);
            //     }
            // } else {
            //     throw new UserException('Foto harus diupload !!', UNAUTHORIZED_CODE);
            // }

            $this->AbsenModel->record($data_absen);
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function record()
    {
        try {
            $this->load->library('user_agent');
            $mobile = $this->agent->is_mobile();
            if (!$mobile) {
                $data = array(
                    'page' => 'error_page2',
                    'title' => 'Error',
                    'redirect' => 'absensi',
                    'message' => 'Maaf halaman ini hanya dapat diaksess melalui Hand Phone',
                );
                $this->load->view('error_page2', $data);
                return;
            } else {
                // echo 'galse';
            }
            // die();
            $res_data['location'] = $this->AbsenModel->getLocation([
                'id_satuan' => $this->session->userdata()['id_satuan']
            ]);
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
