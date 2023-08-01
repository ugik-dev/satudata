<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rekap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'SKPModel', 'PermohonanModel', 'SPPDModel', 'SuratIzinModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }

    public function getAll()
    {
        try {
            $filter = $this->input->get();
            $filter['search_approval']['data_penilai'] = $data_penilai = $this->session->userdata();
            $filter['id_penilai'] = $data_penilai['id'];
            $data = $this->SPPDModel->getAllSPPD($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllSPT()
    {
        try {
            $filter = $this->input->get();
            $filter['detail'] = true;
            $this->load->model('SPTModel');
            $data = $this->SPTModel->getAllSPPD($filter, true);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllCuti()
    {
        try {
            $filter = $this->input->get();
            $filter['detail'] = true;
            $data = $this->SuratIzinModel->getAll($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function spt()
    {
        try {
            $this->SecurityModel->multiRole('Rekap', 'Rekap SPT', true);
            $dataContent['instansi'] = $this->GeneralModel->getAllSatuan();

            if ($this->session->userdata['id_role'] == 1) {
                $dataContent['edit_spt'] = true;
            } else {
                $dataContent['edit_spt'] = false;
            }
            $data = array(
                'page' => 'rekap/spt',
                'title' => 'Rekap SPT & SPPD',
                'dataContent' => $dataContent
            );

            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function cuti_izin()
    {
        try {
            $this->SecurityModel->multiRole('Rekap', 'Rekap Cuti & Izin', true);
            $dataContent['instansi'] = $this->GeneralModel->getAllSatuan();

            if ($dataContent['instansi'][1]['verif_cuti'] == $this->session->userdata('id') || $this->session->userdata['id_role'] == 1) {
                $dataContent['edit_cuti'] = true;
            } else {
                $dataContent['edit_cuti'] = false;
            }
            // echo $edit_cuti;
            // die();

            $dataContent['jenis_izin'] = $this->GeneralModel->getJenisIzin();
            $data = array(
                'page' => 'rekap/cuti',
                'title' => 'Rekap Cuti & Izin',
                'dataContent' => $dataContent
            );

            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function tgl_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return intval($pecahkan[2]) . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }
}
