<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Aktifitas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'AktifitasModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();
        $this->db->db_debug = TRUE;
    }

    public function getAllAktifitas()
    {
        try {
            // $this->SecurityModel->userOnlyGuard();
            $filter = $this->input->POST();
            $filter['my_aktifitas'] = true;
            $data = $this->AktifitasModel->getAllAktifitas($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function index()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Daftar Pengajuan');
            $filter = $this->input->get();
            if (empty($filter['tahun']))
                $filter['tahun'] = date('Y');
            if (empty($filter['bulan']))
                $filter['bulan'] = date('m');
            $data = array(
                'page' => 'my/aktifitas',
                'title' => 'SPPD',
                'dataContent' => $filter

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function add()
    {
        try {
            $res_data['form_url'] = 'aktifitas/add_process';

            $data = array(
                'page' => 'my/aktifitas_form',
                'title' => 'Form Aktifitas',
                'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function edit($id)
    {
        try {
            $res_data['form_url'] = 'aktifitas/edit_process';
            $filter['my_aktifitas'] = true;
            $filter['id_aktifitas'] = $id;
            $res_data['return_data'] = $this->AktifitasModel->getAllAktifitasDetail($filter)[$id];

            $data = array(
                'page' => 'my/aktifitas_form',
                'title' => 'Form Aktifitas',
                'dataContent' => $res_data

            );
            // echo json_encode($data);
            // die();
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function add_process()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->post();
            $id =  $this->AktifitasModel->add($data);
            echo json_encode(array('error' => false, 'data' => $id));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function edit_process()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->post();
            $id =  $this->AktifitasModel->edit($data);
            echo json_encode(array('error' => false, 'data' => $id));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function print()
    {
        try {
            $bulan = array(
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember'
            );
            // $filter['id_skp'] = $id;
            $filter = $this->input->get();
            $filter['id_user'] = $this->session->userdata('id');
            $data =
                $this->AktifitasModel->printLaporanAktifitasHarian($filter);
            // $users = $this->GeneralModel->getAllUser(array('id' => $data['id_user']));
            // $penilai = $this->GeneralModel->getAllUser(array('id' => $data['id_penilai']));
            // echo json_encode($data);
            // die();
            // require('assets/fpdf/fpdf.php');
            // $pdf = new FPDF('p', 'mm', 'Legal');
            require('assets/fpdf/mc_table.php');

            $pdf = new PDF_MC_Table();

            $pdf->SetMargins(8, 8, 10, 10, 'C');
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 13);
            // 
            // $this->head_pembayaran($pdf, $dataContent);

            // $pdf->SetTextColor(107, 104, 104);
            $pdf->Cell(195, 6, 'LAPORAN AKTIFITAS HARIAN PEGAWAI', 0, 1, 'C');
            // $pdf->Cell(190, 6, 'SASARAN KERJA PEGAWAI', 0, 1, 'C');
            $pdf->Cell(190, 5, '', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            // $pdf->Cell(95, 5, 'PEMERINTAH DAERAH KABUPATEN BANGKA', 0, 0, 'L');
            // $pdf->Cell(95, 5, 'Periode     ', 0, 1, 'R');
            // $pdf->SetFont('Arial', 'B');
            // $pdf->Cell(95, 5, 'DINAS KESEHATAN', 0, 1, 'L');
            // $pdf->SetFont('Arial', '');

            // $pdf->Cell(95, 5, $this->tgl_indo($data['periode_start']) . ' s.d ' . $this->tgl_indo($data['periode_start']), 0, 1, 'R');
            $pdf->SetFont('Arial', 'B');
            $pdf->SetFillColor(230, 230, 230);
            // $pdf->Cell(116, 5, 'PEGAWAI YANG DINLAI', 1, 0, 'C', 1);
            // $pdf->Cell(77, 5, 'PEJABAT PENILAI     ', 1, 1, 'C', 1);

            $pdf->Cell(35, 5, 'Nama', 0, 0, 'L');
            $pdf->Cell(3, 5, ':', 0, 0, 'C');
            $pdf->Cell(50, 5, $data['nama'], 0, 1, 'L');

            $pdf->Cell(35, 5, 'NIP', 0, 0, 'L');
            $pdf->Cell(3, 5, ':', 0, 0, 'C');
            $pdf->Cell(50, 5, !empty($data['nip']) ? $data['nip'] : '-', 0, 1, 'L');
            $pdf->Cell(35, 5, 'Jabatan', 0, 0, 'L');
            $pdf->Cell(3, 5, ':', 0, 0, 'C');
            $pdf->Cell(50, 5, $data['jabatan'], 0, 1, 'L');
            $pdf->Cell(35, 5, 'Perangkat Daerah', 0, 0, 'L',);
            $pdf->Cell(3, 5, ':', 0, 0, 'C');
            $pdf->Cell(50, 5, 'DINAS KESEHATAN', 0, 1, 'L');

            $pdf->Cell(35, 5, 'Bulan - Tahun', 0, 0, 'L');
            $pdf->Cell(3, 5, ':', 0, 0, 'C');
            $pdf->Cell(50, 5, $bulan[$filter['bulan']] . ' - ' . $filter['tahun'], 0, 1, 'L');
            $pdf->Cell(50, 5, '', 0, 1, 'L');

            $pdf->Cell(7, 14, 'NO', 1, 0, 'C', 1);
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $pdf->Cell(30, 14, 'TANGGAL', 1, 0, 'C', 1);
            $pdf->Cell(40, 14, 'RENCANA KERJA', 1, 0, 'C', 1);
            $pdf->Cell(40, 14, 'KEGIATAN/AKTIVITAS', 1, 0, 'C', 1);

            $pdf->Cell(41, 7, "JENIS KEGIATAN", 1, 0, 'C', 1);
            $pdf->Cell(37, 7, 'HASIL OUTPUT', 1, 1, 'C', 1);
            $pdf->SetY($current_y + 7);
            $pdf->SetX(125);
            $pdf->Cell(13, 7, 'KU', 1, 0, 'C', 1);
            $pdf->Cell(13, 7, 'KT', 1, 0, 'C', 1);
            $pdf->Cell(15, 7, 'Non SKP', 1, 0, 'C', 1);
            $pdf->Cell(15, 7, 'Vol', 1, 0, 'C', 1);
            $pdf->Cell(22, 7, 'Satuan', 1, 1, 'C', 1);
            $pdf->SetFont('Arial', '', 8.5);

            // $pdf->Cell(10, 12, 'Min', 1, 0, 'C', 1);
            // $pdf->MultiCell(11, 4, 'Max/ Single Rate', 1, 'C', 1);
            // $pdf->SetFont('Arial', 'B', 9.5);

            // $pdf->SetY($current_y + 6);
            // $pdf->SetX($current_x);
            // $pdf->MultiCell(60, 4, "RENCANA KINERJA", 0, 'C', 0);
            // $pdf->SetY($current_y + 6);
            // $pdf->SetX($current_x + 60);
            // $pdf->MultiCell(30, 4, "RENCANA\nKINERJA", 0, 'C', 0);
            // $pdf->SetY($current_y + 6);
            // $pdf->SetX($current_x + 157);
            // $pdf->MultiCell(31, 4, "KETER\nANGAN", 0, 'C', 0);
            // $pdf->SetY($current_y + 19);
            // $pdf->SetX($current_x - 10);
            // $pdf->Cell(10, 5, "(1)", 1, 0, 'C', 1);
            // $pdf->Cell(60, 5, "(2)", 1, 0, 'C', 1);
            // $pdf->Cell(30, 5, "(3)", 1, 0, 'C', 1);
            // $pdf->Cell(16, 5, "(4)", 1, 0, 'C', 1);
            // $pdf->Cell(35, 5, "(5)", 1, 0, 'C', 1);
            // $pdf->Cell(21, 5, "(6)", 1, 0, 'C', 1);
            // $pdf->Cell(21, 5, "(7)", 1, 1, 'C', 1);
            // $pdf->Cell(193, 5, "  A. KINERJA UTAMA", 1, 1, 'L', 1);

            // $pdf->SetFont('Arial', '', 9.5);

            $i = 1;
            foreach ($data['data'] as $a) {
                $pdf->RowAktifitasHarian($i, $a);
                $i++;
                // $pdf->Cell(193, 5, "1", 1, 1, 'L', 1);
            }

            // $pdf->SetFont('Arial', 'B', 9.5);
            // $pdf->SetFillColor(71, 71, 71);
            // $pdf->Cell(193, 5, "", 1, 1, 'L', 1);

            // $pdf->SetFillColor(230, 230, 230);
            // $pdf->Cell(193, 5, "  B. KINERJA TAMBAHAN", 1, 1, 'L', 1);
            $filename = 'SKP_';
            // $dataContent['id'] . '.pdf';

            $pdf->Output('', $filename, false);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
