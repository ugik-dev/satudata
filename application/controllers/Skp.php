<?php
defined('BASEPATH') or exit('No direct script access allowed');
class SKP extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'SKPModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }

    public function getAllSKP()
    {
        try {
            // $this->SecurityModel->userOnlyGuard();
            $filter = $this->input->get();
            $filter['my_skp'] = true;
            $data = $this->SKPModel->getAll($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function index()
    {
        try {
            // $this->SecurityModel->userOnlyGuard();

            $data = array(
                'page' => 'my/skp',
                'title' => 'SPPD',
                // 'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function add()
    {
        try {
            $res_data['form_url'] = 'skp/add_process';

            $data = array(
                'page' => 'my/skp_form',
                'title' => 'Form SKP',
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
            $res_data['form_url'] = 'skp/edit_process';
            $filter['my_skp'] = true;
            $filter['id_skp'] = $id;
            $res_data['return_data'] = $this->SKPModel->getDetail($filter)[$id];

            $data = array(
                'page' => 'my/skp_form',
                'title' => 'Form SKP',
                'dataContent' => $res_data

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



    function GenerateWord()
    {
        //Get a random word
        $nb = rand(3, 10);
        $w = '';
        for ($i = 1; $i <= $nb; $i++)
            $w .= chr(rand(ord('a'), ord('z')));
        return $w;
    }

    function GenerateSentence()
    {
        //Get a random sentence
        $nb = rand(1, 10);
        $s = '';
        for ($i = 1; $i <= $nb; $i++)
            $s .= $this->GenerateWord() . ' ';
        return substr($s, 0, -1);
    }

    public function print($id)
    {
        try {
            $res_data['form_url'] = 'skp/edit_process';
            // $filter['my_skp'] = true;
            $filter['id_skp'] = $id;
            $data = $this->SKPModel->getDetail($filter)[$id];
            $users = $this->GeneralModel->getAllUser(array('id' => $data['id_user']));
            $penilai = $this->GeneralModel->getAllUser(array('id' => $data['id_penilai']));
            // echo json_encode($data);
            // die();
            // require('assets/fpdf/fpdf.php');
            // $pdf = new FPDF('p', 'mm', 'Legal');
            require('assets/fpdf/mc_table.php');

            $pdf = new PDF_MC_Table();

            $pdf->SetMargins(10, 15, 10, 10, 'C');
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 13);
            // 
            // $this->head_pembayaran($pdf, $dataContent);

            // $pdf->SetTextColor(107, 104, 104);
            $pdf->Cell(190, 6, 'RENCANA', 0, 1, 'C');
            $pdf->Cell(190, 6, 'SASARAN KERJA PEGAWAI', 0, 1, 'C');
            $pdf->Cell(190, 5, '', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 9.5);
            $pdf->Cell(95, 5, 'PEMERINTAH DAERAH KABUPATEN BANGKA', 0, 0, 'L');
            $pdf->Cell(95, 5, 'Periode     ', 0, 1, 'R');
            $pdf->SetFont('Arial', 'B');
            $pdf->Cell(95, 5, 'DINAS KESEHATAN', 0, 0, 'L');
            $pdf->SetFont('Arial', '');

            $pdf->Cell(95, 5, $this->tgl_indo($data['periode_start']) . ' s.d ' . $this->tgl_indo($data['periode_start']), 0, 1, 'R');
            $pdf->SetFont('Arial', 'B');
            $pdf->SetFillColor(230, 230, 230);
            $pdf->Cell(116, 5, 'PEGAWAI YANG DINLAI', 1, 0, 'C', 1);
            $pdf->Cell(77, 5, 'PEJABAT PENILAI     ', 1, 1, 'C', 1);
            $row_1 = 30;
            $row_2 = 20;
            $row_3 = 20;
            $row_4 = 35;
            $row_a1 = 70;
            $row_a2 =  46;
            $row_a3 = 35;
            $row_a4 =  42;

            $pdf->Cell($row_a1, 5, 'Nama', 1, 0, 'L', 1);
            $pdf->Cell($row_a2, 5, '', 1, 0, 'C');
            $pdf->Cell($row_a3, 5, 'Nama Atasan', 1, 0, 'L', 1);
            $pdf->Cell($row_a4, 5, '', 1, 1, 'C');

            $pdf->Cell($row_a1, 5, 'NIP', 1, 0, 'L', 1);
            $pdf->Cell($row_a2, 5, '', 1, 0, 'C');
            $pdf->Cell($row_a3, 5, 'NIP', 1, 0, 'L', 1);
            $pdf->Cell($row_a4, 5, '', 1, 1, 'C');

            $pdf->Cell($row_a1, 5, 'Pangkat/Gol Ruang', 1, 0, 'L', 1);
            $pdf->Cell($row_a2, 5, '', 1, 0, 'C');
            $pdf->Cell($row_a3, 5, 'Pangkat/Gol Ruang', 1, 0, 'L', 1);
            $pdf->Cell($row_a4, 5, '', 1, 1, 'C');

            $pdf->Cell($row_a1, 5, 'Jabatan', 1, 0, 'L', 1);
            $pdf->Cell($row_a2, 5, '', 1, 0, 'C');
            $pdf->Cell($row_a3, 5, 'Jabatan', 1, 0, 'L', 1);
            $pdf->Cell($row_a4, 5, '', 1, 1, 'C');

            $pdf->Cell($row_a1, 5, 'Unit Kerja', 1, 0, 'L', 1);
            $pdf->Cell($row_a2, 5, '', 1, 0, 'C');
            $pdf->Cell($row_a3, 5, 'Unit Kerja', 1, 0, 'L', 1);
            $pdf->Cell($row_a4, 5, '', 1, 1, 'C');
            $pdf->Cell(10, 19, 'NO', 1, 0, 'C', 1);
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $pdf->Cell(60, 19, '', 1, 0, 'C', 1);
            $pdf->Cell(30, 19, '', 1, 0, 'C', 1);
            $pdf->Cell(16, 19, 'ASPEK', 1, 0, 'C', 1);

            $pdf->Cell(35, 19, "IKI", 1, 0, 'C', 1);
            $pdf->Cell(21, 7, 'TARGET', 1, 0, 'C', 1);
            $pdf->Cell(21, 19, '', 1, 1, 'C', 1);
            $pdf->SetY($current_y + 7);
            $pdf->SetX($current_x + 60 + 30 + 35 + 16);
            $pdf->SetFont('Arial', 'B', 8.5);

            $pdf->Cell(10, 12, 'Min', 1, 0, 'C', 1);
            $pdf->MultiCell(11, 4, 'Max/ Single Rate', 1, 'C', 1);
            $pdf->SetFont('Arial', 'B', 9.5);

            $pdf->SetY($current_y + 6);
            $pdf->SetX($current_x);
            $pdf->MultiCell(60, 4, "RENCANA KINERJA ATASAN \n YANG DIINTERVENSI", 0, 'C', 0);
            $pdf->SetY($current_y + 6);
            $pdf->SetX($current_x + 60);
            $pdf->MultiCell(30, 4, "RENCANA\nKINERJA", 0, 'C', 0);
            $pdf->SetY($current_y + 6);
            $pdf->SetX($current_x + 157);
            $pdf->MultiCell(31, 4, "KETER\nANGAN", 0, 'C', 0);
            $pdf->SetY($current_y + 19);
            $pdf->SetX($current_x - 10);
            $pdf->Cell(10, 5, "(1)", 1, 0, 'C', 1);
            $pdf->Cell(60, 5, "(2)", 1, 0, 'C', 1);
            $pdf->Cell(30, 5, "(3)", 1, 0, 'C', 1);
            $pdf->Cell(16, 5, "(4)", 1, 0, 'C', 1);
            $pdf->Cell(35, 5, "(5)", 1, 0, 'C', 1);
            $pdf->Cell(21, 5, "(6)", 1, 0, 'C', 1);
            $pdf->Cell(21, 5, "(7)", 1, 1, 'C', 1);
            $pdf->Cell(193, 5, "  A. KINERJA UTAMA", 1, 1, 'L', 1);

            $pdf->SetFont('Arial', '', 9.5);

            $i = 1;
            foreach ($data['child'] as $a) {
                if ($a['jenis_keg'] == 'KU') {
                    $pdf->row($i, $a);
                    $i++;
                }
            }

            $pdf->SetFont('Arial', 'B', 9.5);
            $pdf->SetFillColor(71, 71, 71);
            $pdf->Cell(193, 5, "", 1, 1, 'L', 1);

            $pdf->SetFillColor(230, 230, 230);
            $pdf->Cell(193, 5, "  B. KINERJA TAMBAHAN", 1, 1, 'L', 1);
            $pdf->SetFont('Arial', '', 9.5);

            $i = 1;
            foreach ($data['child'] as $a) {
                if ($a['jenis_keg'] == 'KT') {
                    $pdf->row($i, $a);
                    $i++;
                }
            }



            $filename = 'SKP_';
            // $dataContent['id'] . '.pdf';

            $pdf->Output('', $filename, false);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function approv($id)
    {
        try {
            $res_data['form_url'] = 'skp/edit_process';
            // $filter['my_skp'] = true;
            $filter['id_skp'] = $id;
            $data = $this->SKPModel->getDetail($filter)[$id];
            $users = $this->GeneralModel->getAllUser(array('id' => $data['id_user']));
            $penilai = $this->GeneralModel->getAllUser(array('id' => $data['id_penilai']));
            echo json_encode($data);
            if ($data['id_penilai'] != $this->session->userdata()['id'])
                throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
            else
                $this->SKPModel->approv($data,);

            // echo $this->session->userdata()['id'];
            // $penilai = $this->GeneralModel->$this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function add_process()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->post();
            $id =  $this->SKPModel->add($data);
            echo json_encode(array('error' => false, 'data' => $id));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function edit_process()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->post();
            $id =  $this->SKPModel->edit($data);
            echo json_encode(array('error' => false, 'data' => $id));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
