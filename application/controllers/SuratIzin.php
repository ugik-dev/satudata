<?php
defined('BASEPATH') or exit('No direct script access allowed');
class SuratIzin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'SuratIzinModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }

    public function getAll()
    {
        try {
            $filter = $this->input->get();
            $data =  $this->SuratIzinModel->getAll($filter);
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function index()
    {
        try {
            $data = array(
                'page' => 'my/surat_izin',
                'title' => 'Cuti Saya',
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function add()
    {
        try {
            $res_data['form_url'] = 'surat-izin/add_process';
            if ($this->session->userdata()['jenis_pegawai'] == 1) {
                $filter['jen_izin'] = 1;
            } else {
                $filter['jen_izin'] = 2;
            }
            $res_data['jenis_izin'] = $this->GeneralModel->getJenisIzin($filter);
            $data = array(
                'page' => 'my/surat_izin_form',
                'title' => 'Form Cuti',
                'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function ajukan_approv()
    {
        try {
            $res_data['form_url'] = 'skp/edit_process';
            $filter['my_skp'] = true;
            $filter['id_skp'] = $this->input->get('id');
            $res_data = $this->SKPModel->getAll($filter)[$filter['id_skp']];
            if (!empty($res_data));
            if ($res_data['status'] == 0 && $res_data['id_user'] == $this->session->userdata('id')) {
                // echo 'ajikan ';
                $this->SKPModel->ajukan_approv($res_data['id_skp']);
                $res_data['status'] = 1;
                echo json_encode(array('error' => false, 'data' => $res_data));
            } else
                echo json_encode(array('error' => true, 'message' => 'Terjadi Kesalahan!!'));
            // $data = array(
            //     'page' => 'my/skp_form',
            //     'title' => 'Form SKP',
            //     'dataContent' => $res_data

            // );
            // $this->load->view('page', $data);
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
            if ($res_data['return_data']['status'] == 2) {
                // echo 'has approv';
                $this->load->view('error_page2', array('message' => 'Data Sudah di approv'));
                return;
                // die();
            }
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
    public function action($action, $id)
    {
        try {
            $data = $this->SuratIzinModel->getAll(array('id_surat_izin' => $id))[$id];
            // $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            // $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);
            $cur_user = $this->session->userdata();
            $logs['id_si'] = $id;
            $logs['id_user'] = $cur_user['id'];

            if ($data['status_izin'] == 0) {
                // echo $cur_user['id'] . '<br>';
                // echo  $data['id_pengganti'];
                if ($action == 'approv' && $data['id_pengganti'] == $cur_user['id']) {
                    $logs['deskripsi'] =  'Menyetujui pelimpahan wewenang.';
                    $logs['label'] = 'success';
                    $this->SuratIzinModel->addLogs($logs);
                    $sign =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                    $pegawai =  $this->GeneralModel->getAllUser(['id' => $data['id_pegawai']])[$data['id_pegawai']];

                    if ($pegawai['level'] == 6) {
                        if (!empty($pegawai['id_seksi'])) {
                            $data['status_izin'] = 1;
                        } else {
                            $data['status_izin'] = 2;
                        }
                    } else if ($pegawai['level'] == 5) {
                        if (!empty($pegawai['id_seksi'])) {
                            $data['status_izin'] = 2;
                        }
                    } else if ($pegawai['level'] == 4 || $pegawai['level'] == 3) {
                        $data['status_izin'] = 5;
                    } else if ($pegawai['level'] == 2) {
                        $data['status_izin'] = 6;
                    } else if ($pegawai['level'] == 1) {
                        $data['status_izin'] = 10;
                    }
                    if ($cur_user['jen_satker'] == 2) {
                        $data['status_izin'] = 50;
                    }
                    // echo json_encode($data);
                    // die();
                    $this->SuratIzinModel->approve_pelimpahan($data, $sign);
                    // $this->SPPDModel->addLogs($logs);
                    echo json_encode(array('error' => false, 'data' => $data));
                    return;
                }
            }
            // echo json_encode($data);
            // die();
            if ($cur_user['level'] == 5 && $data['status_izin'] == 1) {
                // approve kasi
            }


            if (($cur_user['level'] == 3 || $cur_user['level'] == 4) && $data['status_izin'] == 2 && ($cur_user['id_bagian'] = $data['id_bagian'])) {
                $logs['deskripsi'] =  'Menyetujui';
                $logs['label'] = 'success';
                $data['status_izin'] = 3;
                if ($data['level_pegawai'] == 6) {
                    $sign['atasan'] =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                    $this->SuratIzinModel->approv($data, $sign);
                } else
                    $this->SuratIzinModel->approv($data);
                $this->SuratIzinModel->addLogs($logs);
            } else if ($cur_user['level'] == 2 && $data['status_izin'] == 3) {
                $logs['deskripsi'] =  'Menyetujui';
                $logs['label'] = 'success';
                if ($data['jen_izin'] == 1)
                    $data['status_izin'] = 10;
                else
                    $data['status_izin'] = 15;

                if ($data['level_pegawai'] != 6) {
                    $sign['atasan'] =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                    $this->SuratIzinModel->approv($data, $sign);
                } else
                    $this->SuratIzinModel->approv($data);
                $this->SuratIzinModel->addLogs($logs);
            } else if ($cur_user['level'] == 1 && $data['status_izin'] == 15) {
                $logs['deskripsi'] =  'Menyetujui';
                $logs['label'] = 'success';
                $data['status_izin'] = 99;
                $sign['kadin'] =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                $this->SuratIzinModel->approv($data, $sign);
                $this->SuratIzinModel->addLogs($logs);
            } else if ($cur_user['level'] == 3 && $cur_user['id_bagian'] == 2 && $data['status_izin'] == 11) {
                $logs['deskripsi'] =  'Menyetujui';
                $logs['label'] = 'success';
                $data['status_izin'] = 15;
                $this->SuratIzinModel->approv($data);
                $this->SuratIzinModel->addLogs($logs);
            }

            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function action_verif()
    {
        try {
            $data_post = $this->input->post();
            $id = $data_post['id_surat_izin'];
            $data = $this->SuratIzinModel->getAll(array('id_surat_izin' => $id))[$id];
            // $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            // $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);
            $cur_user = $this->session->userdata();
            // $logs['id_si'] = $id;
            // $logs['id_user'] = $cur_user['id'];
            if ($data['verif_cuti'] == $cur_user['id'] && $data['status_izin'] == 10) {
                // echo "as";
                // die();
                $this->SuratIzinModel->approv_verif($data_post);
            }
            echo json_encode(array('error' => false, 'data' => $data));
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



    public function add_process()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->post();
            $ses = $this->session->userdata();
            $data['id_pegawai'] = $ses['id'];
            if (empty($data['id_pengganti'])) {
                // jika tidak ada pengganti maka
                if (!empty($ses['id_seksi'])) {
                    $data['id_seksi'] = $ses['id_seksi'];
                }
                if ($ses['level'] == 6) {
                    if (!empty($ses['id_seksi'])) {
                        $data['status_izin'] = 1;
                    } else {
                        $data['status_izin'] = 2;
                    }
                } else if ($ses['level'] == 5) {
                    if (!empty($ses['id_seksi'])) {
                        $data['status_izin'] = 2;
                    }
                } else if ($ses['level'] == 4 || $ses['level'] == 3) {
                    $data['status_izin'] = 5;
                } else if ($ses['level'] == 2) {
                    $data['status_izin'] = 6;
                } else if ($ses['level'] == 1) {
                    $data['status_izin'] = 10;
                }
            } else {
                $data['status_izin'] = 0;
            }
            if (!empty($ses['id_seksi']))
                $data['id_seksi'] = $ses['id_seksi'];
            $data['id_bagian'] = $ses['id_bagian'];
            $data['id_satuan'] = $ses['id_satuan'];
            if (!empty($_FILES['file_lampiran']['name'])) {
                $s =  FileIO::uploadGd2('file_lampiran', 'lampiran_izin', '');
                if (!empty($s['filename']))
                    $data['lampiran'] = $s['filename'];
                else {
                    throw new UserException('Gagal Upload, terjadi kesalahahn!!', UNAUTHORIZED_CODE);
                }
            } else {
                // throw new UserException('Foto harus diupload !!', UNAUTHORIZED_CODE);
            }

            $id =  $this->SuratIzinModel->add($data);

            $data = $this->SuratIzinModel->getAll(['id_surat_izin' => $id]);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function edit_process()
    {
        try {
            $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->post();
            $data['status'] = 0;
            $id =  $this->SKPModel->edit($data);
            echo json_encode(array('error' => false, 'data' => $id));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function print($id, $tipe)
    {
        $filter = $this->input->get();
        $data = $this->SuratIzinModel->getAll(['id_surat_izin' => $id])[$id];

        if ($tipe == 1)
            $this->print_spw($data);
        // if ($tipe == 2)
        //     $this->print_sppd($data);
        // if ($tipe == 3)
        //     $this->print_lpd($data);
        // if ($tipe == 4)
        //     $this->print_pencairan($data);
    }
    function kop($pdf, $data)
    {
        if ($data['jen_satker'] == 1) {
            // echo json_encode($data);
            $pdf->Image(base_url('assets/img/kab_bangka.png'), 20, 5, 20, 27);
            $pdf->SetFont('Arial', '', 13);
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Cell(15, 6, '', 0, 0, 'C');
            $pdf->Cell(185, 7, 'PEMERINTAH KABUPATEN BANGKA', 0, 1, 'C');
            $pdf->Cell(15, 6, '', 0, 0, 'C');
            $pdf->SetFont('Arial', 'B', 20);
            $pdf->Cell(185, 7, 'DINAS KESEHATAN', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(15, 4, '', 0, 0, 'C');
            $pdf->Cell(185, 4, 'JL. AHMAD YANI. JALUR DUA (II) SUNGAILIAT', 0, 1, 'C');
            $pdf->Cell(15, 4, '', 0, 0, 'C');
            $pdf->Cell(185, 4, 'Kode Pos 33215 Telp (0717) 91952 Fax (0717) 91952', 0, 1, 'C');
            $pdf->Cell(15, 4, '', 0, 0, 'C');
            $pdf->Cell(185, 4, 'Email : dinkesbangka@gmail.com. Website : www.dinkes.bangka.go.id', 0, 1, 'C');
            $pdf->Line($pdf->GetX(), $pdf->GetY() + 3, $pdf->GetX() + 195, $pdf->GetY() + 3);
            $pdf->SetLineWidth(0.4);
            $pdf->Line($pdf->GetX(), $pdf->GetY() + 3.6, $pdf->GetX() + 195, $pdf->GetY() + 3.6);
            $pdf->SetLineWidth(0.2);
        } else
        if ($data['jen_satker'] == 2) {
            // echo json_encode($data);
            $pdf->Image(base_url('assets/img/kab_bangka.png'), 20, 5, 20, 27);
            $pdf->SetFont('Arial', '', 13);
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Cell(15, 6, '', 0, 0, 'C');
            $pdf->Cell(185, 6, 'PEMERINTAH KABUPATEN BANGKA', 0, 1, 'C');
            $pdf->Cell(15, 6, '', 0, 0, 'C');
            $pdf->Cell(185, 6, 'DINAS KESEHATAN', 0, 1, 'C');
            $pdf->Cell(15, 6, '', 0, 0, 'C');
            $pdf->SetFont('Arial', 'B', 20);
            $pdf->Cell(185, 7, $data['nama_satuan'], 0, 1, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(15, 4, '', 0, 0, 'C');
            $pdf->Cell(185, 4, 'Jalan : ' . $data['alamat_lengkap'], 0, 1, 'C');
            $pdf->Cell(15, 4, '', 0, 0, 'C');
            $pdf->Cell(185, 4, (!empty($data['kode_pos']) ? 'Kode Pos : ' . $data['kode_pos'] . ' ' : '') . (!empty($data['no_tlp']) ? 'Telp. ' . $data['no_tlp'] : ''), 0, 1, 'C');
            $pdf->Cell(15, 4, '', 0, 0, 'C');
            $pdf->Cell(185, 4, (!empty($data['email']) ? ' Email : ' . $data['email'] : '') . (!empty($data['website']) ? ' Website : ' . $data['website'] : ''), 0, 1, 'C');
            $pdf->Line($pdf->GetX(), $pdf->GetY() + 3, $pdf->GetX() + 195, $pdf->GetY() + 3);
            $pdf->SetLineWidth(0.4);
            $pdf->Line($pdf->GetX(), $pdf->GetY() + 3.6, $pdf->GetX() + 195, $pdf->GetY() + 3.6);
            $pdf->SetLineWidth(0.2);
        }
    }

    function print_spw($data)
    {
        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('P', 'mm', array(215.9, 355.6));

        $pdf->SetTitle('SPT ' . $data['id_surat_izin']);
        $pdf->SetMargins(10, 5, 15, 10, 'C');
        $pdf->AddPage();
        $data_satuan =  $this->GeneralModel->getSatuan(['id_satuan' => $data['id_satuan']])[0];

        $this->kop($pdf, $data_satuan);

        $pdf->SetFont('Arial', '', 9.5);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(190, 7, ' ', 0, 1, 'L', 0);
        $pdf->SetLineWidth(0.4);
        $pdf->Line(70, $pdf->GetY() + 4.5, 144, $pdf->GetY() + 4.5);
        $pdf->SetLineWidth(0.2);
        $pdf->Cell(195, 5, 'SURAT PELIMPAHAN WEWENANG', 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(195, 5, 'Nomor : ' . $data['no_surat_izin'], 0, 1, 'C', 0);


        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(25, 5, ' ', 0, 1, 'L', 0);
        $pdf->Cell(25, 5, 'Yang bertanda tangan dibawah ini:', 0,  1, 'L', 0);
        // $pdf->Cell(5, 5, '1. ', 0, 0, 'L', 0);
        // $pdf->MultiCell(165, 5, !empty($data['nama_dasar']) ? $data['nama_dasar'] : $data['dasar'], 0, 'J');
        // $pdf->Cell(25, 5, ' ', 0, 1, 'L', 0);
        // $pdf->SetFont('Arial', 'B', 11);
        // $pdf->Cell(195, 5, 'MEMERINTAHKAN :', 0, 1, 'C', 0);
        // $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(5, 5, '', 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '1.', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Nama', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['nama_pegawai'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'NIP', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['nip_pegawai'], 0, 1, 'L', 0);
        // $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        // $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        // $pdf->Cell(30, 5, 'Pangkat/Gol', 0, 0, 'L', 0);
        // $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        // $pdf->Cell(160, 5, $data['pangkat_gol_pegawai'], 0, 1, 'L', 0);
        // $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        // $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        // $pdf->Cell(30, 5, 'Jabatan', 0, 0, 'L', 0);
        // $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        // $pdf->MultiCell(145, 5, $data['jabatan_pegawai'], 1,  'L', 0);
        // $i = 2;
        // foreach ($data['pengikut'] as $pengikut) {
        //     $pdf->Cell(5, 2, '', 0, 1, 'L', 0);
        //     $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        //     $pdf->Cell(10, 5, $i . '.', 0, 0, 'L', 0);
        //     $pdf->Cell(30, 5, 'Nama', 0, 0, 'L', 0);
        //     $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        //     $pdf->Cell(160, 5, $pengikut['nama'], 0, 1, 'L', 0);
        //     $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        //     $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        //     $pdf->Cell(30, 5, 'NIP', 0, 0, 'L', 0);
        //     $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        //     $pdf->Cell(160, 5, $pengikut['nip'], 0, 1, 'L', 0);
        //     $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        //     $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        //     $pdf->Cell(30, 5, 'Pangkat/Gol', 0, 0, 'L', 0);
        //     $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        //     $pdf->Cell(160, 5, $pengikut['pangkat_gol'], 0, 1, 'L', 0);
        //     $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        //     $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        //     $pdf->Cell(30, 5, 'Jabatan', 0, 0, 'L', 0);
        //     $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        //     $pdf->MultiCell(145, 5, $pengikut['jabatan'],  1, 'L', 0);
        //     $i++;
        // }

        // $tujuan_text = '';
        // $count_t = count($data['tujuan']);
        // $i = 1;
        // $d1 = '';
        // $d2 = '';
        // if ($data['jenis'] == 3) {
        //     $t = '';
        //     foreach ($data['tujuan'] as $tujuan) {
        //         if ($i == 1) {
        //             $tujuan_text .= $tujuan['tempat_tujuan'] . ' pada tanggal ' . tanggal_indonesia($tujuan['date_berangkat']) . ' ' . 'pukul ' . substr($tujuan['dari'], 0, 5) . ' s.d. ' . substr($tujuan['sampai'], 0, 5);
        //         } else if ($count_t == $i) {
        //             $tujuan_text .= ' dan ' . ($t != $tujuan['tempat_tujuan'] ? 'di ' . $tujuan['tempat_tujuan'] . ' ' : '') . 'tanggal ' . tanggal_indonesia($tujuan['date_berangkat']) . ' pukul ' . substr($tujuan['dari'], 0, 5) . ' s.d. ' . substr($tujuan['sampai'], 0, 5);
        //         } else {
        //             $tujuan_text .= ', ' . ($t != $tujuan['tempat_tujuan'] ? 'di ' . $tujuan['tempat_tujuan'] . ' ' : '') . 'tanggal ' . tanggal_indonesia($tujuan['date_berangkat']) . ' pukul ' . substr($tujuan['dari'], 0, 5) . ' s.d. ' . substr($tujuan['sampai'], 0, 5);
        //             // $tujuan_text .= ', di ' . $tujuan['tempat_tujuan'] . ' pada tanggal ' . tanggal_indonesia($tujuan['date_berangkat']) . ' pukul ' . substr($tujuan['dari'], 0, 5) . ' s.d. ' . substr($tujuan['sampai'], 0, 5);
        //         }
        //         $t = $tujuan['tempat_tujuan'];
        //         $i++;
        //     }
        //     // if ($d1 != $d2) {
        //     //     $tujuan_text .= ' pada tanggal ' . tanggal_indonesia($d1) . ' sampai ' . tanggal_indonesia($d2);
        //     // } else {
        //     //     $tujuan_text .= ' pada tanggal ' . tanggal_indonesia($d1);
        //     // }
        // } else {
        //     foreach ($data['tujuan'] as $tujuan) {
        //         if ($i == 1) {
        //             $d1 = $tujuan['date_berangkat'];
        //             $tujuan_text .= $tujuan['tempat_tujuan'];
        //         } else if ($count_t == $i) {
        //             $tujuan_text .= ' dan ' . $tujuan['tempat_tujuan'];
        //         } else {
        //             $tujuan_text .= ', ' . $tujuan['tempat_tujuan'];
        //         }
        //         if (!empty($tujuan['date_kembali']))
        //             $d2 = $tujuan['date_kembali'];
        //         $i++;
        //     }
        //     if ($d1 != $d2) {
        //         $tujuan_text .= ' pada tanggal ' . tanggal_indonesia($d1) . ' sampai ' . tanggal_indonesia($d2);
        //     } else {
        //         $tujuan_text .= ' pada tanggal ' . tanggal_indonesia($d1);
        //     }
        // }

        // $pdf->Cell(5, 4, '', 0, 1, 'L', 0);
        // $pdf->MultiCell(194, 5, 'Dalam Rangka ' . $data['maksud'] . ' di ' . $tujuan_text . '.', 0, 'J');
        // $pdf->Cell(5, 4, '', 0, 1, 'L', 0);
        // $pdf->MultiCell(194, 5, 'Surat tugas ini dibuat untuk dilaksanakan dan setelah selesai, pelaksanaan tugas segera menyampaikan laporan kepada atasan langsungnya. Kepada instansi terkait, kami mohon bantuan demi kelancaran pelaksanaan tugas dimaksud.', 0, 'J');

        // $pdf->SetFont('Arial', 'B', 11);
        // $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(3, 5, "", 0, 1, 'L', 0);
        $cur_x = $pdf->getX();
        $cur_y = $pdf->GetY();

        $pdf->CheckPageBreak(65);

        if ($data['status_izin'] == '99' && !empty($data['sign_kadin'])) {
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Ditetapkan di', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, $data_satuan['satuan_tempat'], 0, 1, 'L', 0);

            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Pada Tanggal', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, tanggal_indonesia(date('Y-m-d')), 0, 1, 'L', 0);
            $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(45, 5,  ucwords(strtolower($sign_kadin['sign_title'])), 0, 'L', 0);

            $pdf->Cell(120, 25, '', 0, 1, 'C', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(70, 5,  ucwords(strtolower($sign_kadin['sign_name'])), 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(70, 5,  $sign_kadin['sign_pangkat'], 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(70, 5,  'NIP. ' . $sign_kadin['sign_nip'], 0, 'L', 0);
            $pdf->Image(base_url('uploads/signature/' . $sign_kadin['sign_signature']), 140, $pdf->getY() - 40, 40);
        } else {
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Ditetapkan di', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, '', 0, 1, 'L', 0);

            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Pada Tanggal', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, '', 0, 1, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 1, 'C', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(45, 5,  'ttd', 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(45, 5,  '', 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(45, 5,  '', 0, 'L', 0);
        }
        $pdf->Cell(130, 5, '', 0, 0, 'C', 0);
        $filename = 'SPT ' . $data['id_surat_izin'];

        $pdf->Output('', $filename, false);
    }
}
