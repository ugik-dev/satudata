<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Spt extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'SPPDModel', 'GeneralModel'));
        $this->db->db_debug = FALSE;
    }

    public function getFoto()
    {
        try {
            $filter = $this->input->get();
            $filter['is_image'] = 'Y';

            $data['image'] = $this->SPPDModel->getFoto($filter);
            $filter['is_image'] = 'N';
            $data['file'] = $this->SPPDModel->getFoto($filter);
            // $new_data = ['image' => [], 'file' => []];
            // foreach ($data as $d) {
            //     if ($d['is_image'] == 'Y')
            //         $new_data['image'][] = $d;
            // }
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
        }
    }
    public function getAllSPPD()
    {
        try {
            $this->SecurityModel->multiRole('SPT / SPPD', 'Daftar Pengajuan');
            $filter = $this->input->get();

            if (!empty($filter['sort'])) {
                $sort = true;
            } else {
                $sort = false;
            }
            // echo json_encode($filter);
            // die();
            $filter['id_bagian'] = $this->session->userdata('id_bagian');
            $filter['id_seksi'] = $this->session->userdata('id_seksi');
            // }

            $data = $this->SPPDModel->getAllSPPD($filter, $sort);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getDasar($id)
    {
        try {
            $data = $this->SPPDModel->getDasar($id);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getPengikut($id)
    {
        try {
            $filter = $this->input->get();
            $data = $this->SPPDModel->getPengikut($filter);
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function getDetailSPPD($id)
    {
        // $res = $this->SPPDModel->getAllSPPD(array('id_spt' => $id))[$id];
        // $res['pengikut'] = $this->SPPDModel->getPengikut($id);
        // $res['dasar_tambahan'] = $this->SPPDModel->getDasar($id);
    }
    public function edit($id)
    {
        try {
            $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);
            $res_data['return_data'] = $this->SPPDModel->getAllSPPD(array('id_spt' => $id))[$id];
            $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);

            $res_data['form_url'] = 'spt/edit_process';
            $data = array(
                'title' => 'Form SPT SPT',
                'dataContent' => $res_data
            );
            // echo json_encode($this->session->userdata());
            // die();
            if (!empty($res_data['return_data']['sign_kadin'])) {
                if ($this->session->userdata()['id_role'] != 1) {
                    $data['page'] = 'error_page2';
                    $data['message'] = 'Maaf, SPT ini sudah di approve tahap akhir, tidak dapat dirubah  lagi..';
                    $data['redirect'] = 'spt/detail/' . $res_data['return_data']['id_spt'];
                } else if ($res_data['return_data']['jenis'] == 1) {
                    $data['page'] = 'spt/form_spt';
                } else if ($res_data['return_data']['jenis'] == 2) {
                    $data['page'] = 'spt/form_spt_sppd';
                } else if ($res_data['return_data']['jenis'] == 3) {
                    $data['page'] = 'spt/form_lembur';
                }
            } else if ($res_data['return_data']['jenis'] == 1) {
                $data['page'] = 'spt/form_spt';
            } else if ($res_data['return_data']['jenis'] == 2) {
                $data['page'] = 'spt/form_spt_sppd';
            } else if ($res_data['return_data']['jenis'] == 3) {
                $data['page'] = 'spt/form_lembur';
            }
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function laporan($id)
    {
        try {
            $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);
            $res_data['return_data'] = $this->SPPDModel->getAllSPPD(array('id_spt' => $id), false, true)[$id];
            $laporan = $this->SPPDModel->getLaporan(array('id_spt' => $id));
            if (!empty($laporan))
                $res_data['laporan'] = $laporan[$id];
            // echo json_encode($res_data['return_data']);
            // die();
            $res_data['form_url'] = 'spt/laporan_process';
            $data = array(
                'page' => 'spt/form_laporan',
                'title' => 'Form Laporan SPT',
                'dataContent' => $res_data
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function laporan_process()
    {
        try {
            // $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);

            $data = $this->input->Post();
            $data_res = $this->SPPDModel->getAllSPPD(array('id_spt' => $data['id_spt']), false, true)[$data['id_spt']];

            $team = [];
            $team[] = $data_res['user_input'];
            $team[] = $data_res['id_pegawai'];
            if ($this->session->userdata('id_role') == '1') {
                $team[]  = $this->session->userdata('id');
            }
            foreach ($data_res['pengikut'] as $d) {
                $team[]  = $d['id_pegawai'];
            }
            if (in_array($this->session->userdata('id'), $team)) {
                $this->SPPDModel->addLaporan($data);
                if ($this->session->userdata('id_role') == '1') {
                    $logs['id_spt'] = $data['id_spt'];
                    $logs['id_user'] = $this->session->userdata('id');
                    $logs['deskripsi'] =  'Entri Laporan';
                    $logs['label'] = 'success';
                    $this->SPPDModel->addLogs($logs);
                }
                echo json_encode(['error' => false, 'data' => $data]);
            } else {
                throw new UserException('Kamu tidak berhak melakukan aksi ini!!', UNAUTHORIZED_CODE);
            }
            // echo json_encode($data);
            // die();
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function detail($id)
    {
        try {
            $this->SecurityModel->userOnlyGuard(true);
            // $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);
            $res_data['return_data'] = $this->SPPDModel->getAllSPPD(array('id_spt' => $id), false, true)[$id];
            $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);
            $res_data['return_data']['logs'] = $this->SPPDModel->getLogs(array('id_spt' => $id));
            $laporan = $this->SPPDModel->getLaporan(array('id_spt' => $id));
            if (!empty($laporan))
                $res_data['laporan'] = $laporan[$id];
            $data = array(
                'page' => 'spt/detail',
                'title' => 'Form SPT',
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
            $data = $this->SPPDModel->getAllSPPD(array('id_spt' => $id), false, true)[$id];
            $cur_user = $this->session->userdata();
            $plh = [];
            $plh = $this->SPPDModel->getAllSPPD(['status' => 99, 'plh' => 'Y', 'dari' => date('Y-m-d'), 'sampai' => date('Y-m-d')], false, true);
            if (!empty($plh)) {
                $this->load->model('UserModel');
                $plh = $plh[array_key_first($plh)];
                $plh = $this->UserModel->getAllUser(['id_user' => $plh['id_pegawai']])[$plh['id_pegawai']];
            }

            // echo json_encode($plh);
            // die();
            $logs['id_spt'] = $id;
            $logs['id_user'] = $cur_user['id'];

            if ($action == 'approv') {
                $logs['deskripsi'] =  'Menyetujui';
                $logs['label'] = 'success';
                $this->SPPDModel->approv($data, $plh);
                $this->SPPDModel->addLogs($logs);
            }
            if ($action == 'unapprov') {
                $logs['deskripsi'] =  'Menolak';
                $logs['label'] = 'danger';
                $this->SPPDModel->unapprov($data);
                $this->SPPDModel->addLogs($logs);
            }
            if ($action == 'undo') {
                $logs['deskripsi'] = 'Membatalkan Aksi';
                $logs['label'] = 'warning';
                $this->SPPDModel->undo($data);
                $this->SPPDModel->addLogs($logs);
            }



            $data = $this->SPPDModel->getAllSPPD(array('id_spt' => $id), false, true)[$id];
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function create($jenis = 'spt')
    {
        try {
            $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);

            $res_data['form_url'] = 'spt/create_process';

            $data = array(
                'page' => 'spt/form_' . $jenis,
                'title' => 'Form SPT SPT',
                'dataContent' => $res_data
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function daftar_pengajuan()
    {
        try {
            $this->SecurityModel->multiRole('SPT / SPPD', 'Daftar Pengajuan');

            $data = array(
                'page' => 'spt/daftar',
                'title' => 'SPT',
                // 'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function action_edit()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            if ($this->session->userdata['id_role'] == 1) {
            } else {
                throw new UserException('Kamu tidak berhak melakukan aksi ini!!', UNAUTHORIZED_CODE);
            }

            $data = $this->input->post();

            $id =  $this->SPPDModel->edit_adm($data);
            $data = $this->SPPDModel->getAllSPPD(['id_spt' => $data['id_spt']])[$data['id_spt']];
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function delete_adm()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');

            if ($this->session->userdata['id_role'] == 1) {
            } else {
                throw new UserException('Kamu tidak berhak melakukan aksi ini!!', UNAUTHORIZED_CODE);
            }

            $data = $this->input->post();

            $this->SPPDModel->delete($data);

            echo json_encode(array('error' => false, 'data' => $data['id_spt']));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function create_process()
    {
        try {

            $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);
            $data = $this->input->post();
            if (empty($data['date_berangkat'][0]) or empty($data['date_berangkat'][0]) or empty($data['tempat_tujuan'][0])) {
                throw new UserException('Tujuan belum lengkap!');
            }
            if (
                $this->session->userdata('id_role') == '1'
                // or $this->session->userdata('id_satuan') == 22 //KENANGA
                // or $this->session->userdata('id_satuan') == 20 //Puding Besar
                // or $this->session->userdata('id_satuan') == 9
                // or $this->session->userdata('id_bagian') == '4' //KESMAS
                // or $this->session->userdata('id_bagian') == '5' //P2PL
                // or $this->session->userdata('id_bagian') == '7' //SDK
            ) {
                // if ($this->session->userdata('id_role') == '1') {
            } else {
                if ($data['date_berangkat'][0] < date('Y-m-d')) {
                    throw new UserException('Tanggal Keberangkatan Terlambat!');
                }
            }
            foreach ($data['id_tujuan'] as $key => $t) {
                if (empty($data['date_kembali'][$key])) {
                    $data['date_kembali'][$key] = $data['date_berangkat'][$key];
                }
                if (empty($hari_pertama) && !empty($data['date_berangkat'][$key])) {
                    $hari_pertama = $data['date_berangkat'][$key];
                }

                if ($data['jenis'] == '3') {
                    $hari_terakhir = $data['date_berangkat'][$key];
                } else {
                    if (!empty($data['date_kembali'][$key])) {
                        $hari_terakhir = $data['date_kembali'][$key];
                    }
                }
            }

            if ($data['jenis'] == '2') {
                $this->SPPDModel->CekJadwal($data, $hari_pertama, $hari_terakhir);
            }
            $this->load->model('SuratIzinModel');
            $this->SuratIzinModel->CekJadwal($data, $hari_pertama, $hari_terakhir);

            if ($this->session->userdata('jen_satker') == 1) {
                if (!empty($this->session->userdata('id_seksi')))
                    $data['status'] = 1;
                else
                    $data['status'] = 2;
            } else
            if ($this->session->userdata('jen_satker') == 2 || $this->session->userdata('jen_satker') == 3 || $this->session->userdata('jen_satker') == 4) {
                $data['status'] = 50;
            }

            $id =  $this->SPPDModel->addSPPD($data);
            echo json_encode(array('error' => false, 'data' => $id));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function edit_process()
    {
        try {
            $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);
            $data = $this->input->post();
            if ($data['jenis'] == '2') {
                if (empty($data['date_berangkat'][0]) or empty($data['date_berangkat'][0]) or empty($data['tempat_tujuan'][0])) {
                    throw new UserException('Tujuan belum lengkap!');
                }
                foreach ($data['id_tujuan'] as $key => $t) {
                    // echo $data['date_berangkat'][$key];
                    if (empty($hari_pertama) && !empty($data['date_berangkat'][$key])) {
                        $hari_pertama = $data['date_berangkat'][$key];
                    }
                    if (!empty($data['date_kembali'][$key])) {
                        $hari_terakhir = $data['date_kembali'][$key];
                    }
                }
                $this->SPPDModel->CekJadwal($data, $hari_pertama, $hari_terakhir, $data['id_spt']);
            }
            if (
                $this->session->userdata('id_role') == '1'
                // or $this->session->userdata('id_satuan') == 22 //KENANGA
                // or $this->session->userdata('id_satuan') == 20 //Puding Besar
                // or $this->session->userdata('id_satuan') == 9
                // or $this->session->userdata('id_bagian') == '4' //KESMAS
                // or $this->session->userdata('id_bagian') == '5' //P2PL
                // or $this->session->userdata('id_bagian') == '7' //SDK
            ) {
                // if ($this->session->userdata('id_role') == '1') {
            } else {
                if ($data['date_berangkat'][0] < date('Y-m-d')) {
                    throw new UserException('Tanggal Keberangkatan Terlambat!');
                }
            }

            if ($this->session->userdata('id_role') != 1) {

                if ($this->session->userdata('jen_satker') == 1) {
                    if (!empty($this->session->userdata('id_seksi')))
                        $data['status'] = 1;
                    else
                        $data['status'] = 2;
                } else if ($this->session->userdata('jen_satker') == 2 || $this->session->userdata('jen_satker') == 3 || $this->session->userdata('jen_satker') == 4) {
                    $data['status'] = 50;
                }
            }

            $id =  $this->SPPDModel->editSPPD($data);
            echo json_encode(array('error' => false, 'data' => $id));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function delete_dasar_tambahan()
    {
        try {
            $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);
            $data = $this->input->get();
            $this->SPPDModel->deleteDasarTambahan($data);
            echo json_encode(array('error' => false, 'data' => $data));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function delete()
    {
        try {
            $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);
            $id = $this->input->get()['id_spt'];
            $data = $this->SPPDModel->getAllSPPD(array('id_spt' => $id));

            if (!empty($data[$id])) {
                if ($data[$id]['user_input'] == $this->session->userdata('id')) {
                    $this->SPPDModel->delete(['id_spt' => $data[$id]['id_spt']]);
                    // echo json_encode($data[$id]);
                } else {
                    throw new UserException('Tidak diperbolehkan untuk dihapus');
                }
            } else {
                throw new UserException('Data tidak ditemukan');
            }
            // $this->SPPDModel->deleteDasarTambahan($data);
            echo json_encode(array('error' => false, 'data' => $id));
            // $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function addFoto()
    {
        try {
            $data =  $this->input->post();
            $dataFoto['id_spt'] = $data['id_spt'];
            $dataSPT = $this->SPPDModel->getAllSPPD(['id_spt' => $data['id_spt']], false, true);
            if (empty($dataSPT))
                throw new UserException('Maaf, SPT tidak ditemukan.');
            else if ($dataSPT[$data['id_spt']]['status'] != '99')
                throw new UserException('Status SPT ini belum disetujui');

            $team = [];
            $team[] = $dataSPT[$data['id_spt']]['user_input'];
            $team[] = $dataSPT[$data['id_spt']]['id_pegawai'];
            if ($this->session->userdata('id_role') == '1') {
                $team[]  = $this->session->userdata('id');
            }
            foreach ($dataSPT[$data['id_spt']]['pengikut'] as $d) {
                $team[]  = $d['id_pegawai'];
            }
            if (in_array($this->session->userdata('id'), $team)) {
            } else {
                throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
            }

            $dataFoto['id_foto'] = $data['id_foto'];
            $dataFoto['deskripsi'] = $data['deskripsi'];
            if (!empty($_FILES['file_foto']['name'])) {
                $s =  FileIO::upload2('file_foto', 'foto_sppd', '', 'jpg|png|jpeg|pdf');
                // echo json_encode($s);
                // die();
                if (!empty($s['filename'])) {
                    $dataFoto['file_foto'] = $s['filename'];
                    if ($s['is_image']) {
                        $dataFoto['is_image'] = 'Y';
                    } else {
                        $dataFoto['is_image'] = 'N';
                    }
                }
                $dataFoto['id_pegawai'] = $this->session->userdata('id');
            }
            $id = $this->SPPDModel->addFoto($dataFoto);
            $data = $this->SPPDModel->getFoto(['id_foto' => $id])[$id];
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function deleteFoto()
    {
        try {
            $data =  $this->input->get();
            $dataFoto['id_spt'] = $data['id_spt'];
            $dataFoto['id_foto'] = $data['id_foto'];
            $dataSPT = $this->SPPDModel->getAllSPPD(['id_spt' => $data['id_spt']], false, true);
            $team = [];
            $team[] = $dataSPT[$data['id_spt']]['user_input'];
            $team[] = $dataSPT[$data['id_spt']]['id_pegawai'];
            if ($this->session->userdata('id_role') == '1') {
                $team[]  = $this->session->userdata('id');
            }
            foreach ($dataSPT[$data['id_spt']]['pengikut'] as $d) {
                $team[]  = $d['id_pegawai'];
            }
            if (in_array($this->session->userdata('id'), $team)) {
            } else {
                throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
            }
            // $dataFoto['id_foto'] = $data['id_foto'];
            // $dataFoto['deskripsi'] = $data['deskripsi'];
            // if (!empty($_FILES['file_foto']['name'])) {
            //     $s =  FileIO::upload2('file_foto', 'foto_sppd', '', 'jpg|png|jpeg');
            //     if (!empty($s['filename'])) {

            //         $dataFoto['file_foto'] = $s['filename'];
            //     }
            // }
            $this->SPPDModel->deleteFoto($dataFoto);
            // $data = $this->SPPDModel->getFoto(['id_foto' => $id])[$id];
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function kop($pdf, $data, $dinkes = false)
    {
        if ($data['jen_satker'] == 1 || $dinkes) {
            // echo json_encode($data);
            $pdf->Image('./assets/img/kab_bangka.jpg', 20, 5, 20, 27);
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
        } else if ($data['jen_satker'] == 2) {
            $pdf->Image('./assets/img/kab_bangka.jpg', 10, 5, 20, 27);
            $pdf->Image('./assets/img/logo_puskesmas.png', 180, 5, 27, 27);
            $pdf->SetFont('Arial', '', 13);
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Cell(20, 6, '', 0, 0, 'C');
            $pdf->Cell(155, 6, 'PEMERINTAH KABUPATEN BANGKA', 0, 1, 'C');
            $pdf->Cell(20, 6, '', 0, 0, 'C');
            $pdf->Cell(155, 6, 'DINAS KESEHATAN', 0, 1, 'C');
            $pdf->Cell(20, 6, '', 0, 0, 'C');
            $pdf->SetFont('Arial', 'B', 20);
            $pdf->Cell(155, 7, $data['nama_satuan'], 0, 1, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(20, 4, '', 0, 0, 'C');
            $pdf->Cell(155, 4,  $data['alamat_lengkap'], 0, 1, 'C');
            $pdf->Cell(20, 4, '', 0, 0, 'C');
            $pdf->Cell(155, 4, (!empty($data['kode_pos']) ? 'Kode Pos : ' . $data['kode_pos'] . ' ' : '') . (!empty($data['no_tlp']) ? 'Telp. ' . $data['no_tlp'] : ''), 0, 1, 'C');
            $pdf->Cell(20, 4, '', 0, 0, 'C');
            $pdf->Cell(155, 4, (!empty($data['email']) ? ' Email : ' . $data['email'] : '') . (!empty($data['website']) ? ' Website : ' . $data['website'] : ''), 0, 1, 'C');
            $pdf->Line($pdf->GetX(), $pdf->GetY() + 3, $pdf->GetX() + 195, $pdf->GetY() + 3);
            $pdf->SetLineWidth(0.4);
            $pdf->Line($pdf->GetX(), $pdf->GetY() + 3.6, $pdf->GetX() + 195, $pdf->GetY() + 3.6);
            $pdf->SetLineWidth(0.2);
        } else if ($data['jen_satker'] == 3) {
            // echo json_encode($data);
            if ($data['id_satuan'] == 17) {
                $pdf->Image('./assets/img/kab_bangka.jpg', 20, 5, 20, 27);
                $pdf->Image('./assets/img/logo_eko.png', 180, 0, 27, 35);
                $pdf->SetFont('Arial', '', 13);
                $pdf->SetFont('Arial', 'B', 15);
                $pdf->Cell(20, 6, '', 0, 0, 'C');
                $pdf->Cell(155, 6, 'PEMERINTAH KABUPATEN BANGKA', 0, 1, 'C');
                $pdf->Cell(20, 6, '', 0, 0, 'C');
                $pdf->Cell(155, 6, 'DINAS KESEHATAN', 0, 1, 'C');
                $pdf->Cell(20, 6, '', 0, 0, 'C');
                $pdf->SetFont('Arial', 'B', 20);
                $pdf->Cell(155, 7, $data['nama_satuan'], 0, 1, 'C');
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(20, 4, '', 0, 0, 'C');
                $pdf->Cell(155, 4,  " Jalan Raya Belinyu Dusun Sp. Cangkum, Desa Riding Panjang Belinyu - Bangka", 0, 1, 'C');
                $pdf->Cell(20, 4, '', 0, 0, 'C');
                $pdf->Cell(155, 4, (!empty($data['kode_pos']) ? 'Kode Pos : ' . $data['kode_pos'] . ' ' : '') . (!empty($data['no_tlp']) ? 'Telp. ' . $data['no_tlp'] : ''), 0, 1, 'C');
                // $pdf->Cell(20, 4, '', 0, 0, 'C');
                // $pdf->Cell(155, 4, (!empty($data['email']) ? ' Email : ' . $data['email'] : '') . (!empty($data['website']) ? ' Website : ' . $data['website'] : ''), 0, 1, 'C');
                $pdf->Line($pdf->GetX(), $pdf->GetY() + 3, $pdf->GetX() + 195, $pdf->GetY() + 3);
                $pdf->SetLineWidth(0.4);
                $pdf->Line($pdf->GetX(), $pdf->GetY() + 3.6, $pdf->GetX() + 195, $pdf->GetY() + 3.6);
                $pdf->SetLineWidth(0.2);
            } else  if ($data['id_satuan'] == 18) {
                $pdf->Image('./assets/img/kab_bangka.jpg', 20, 5, 20, 27);
                $pdf->Image('./assets/img/logo_sr2.jpg', 174, 5, 27, 27);
                $pdf->SetFont('Arial', '', 13);
                $pdf->SetFont('Arial', 'B', 20);
                $pdf->Cell(20, 6, '', 0, 0, 'C');
                $pdf->Cell(155, 6, 'PEMERINTAH KABUPATEN BANGKA', 0, 1, 'C');
                $pdf->Cell(20, 6, '', 0, 0, 'C');
                $pdf->Cell(155, 6, 'DINAS KESEHATAN', 0, 1, 'C');
                $pdf->Cell(20, 6, '', 0, 0, 'C');
                $pdf->SetFont('Arial', 'B', 20);
                $pdf->Cell(155, 7, $data['nama_satuan'], 0, 1, 'C');
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(20, 4, '', 0, 0, 'C');
                $pdf->Cell(155, 4,  $data['alamat_lengkap'], 0, 1, 'C');
                $pdf->Cell(20, 4, '', 0, 0, 'C');
                $pdf->Cell(155, 4, (!empty($data['kode_pos']) ? 'Kode Pos : ' . $data['kode_pos'] . ' ' : '') . (!empty($data['no_tlp']) ? 'Telp. ' . $data['no_tlp'] : ''), 0, 1, 'C');
                $pdf->Cell(20, 4, '', 0, 0, 'C');
                $pdf->Cell(155, 4, (!empty($data['email']) ? ' Email : ' . $data['email'] : '') . (!empty($data['website']) ? ' Website : ' . $data['website'] : ''), 0, 1, 'C');
                $pdf->Line($pdf->GetX(), $pdf->GetY() + 2, $pdf->GetX() + 195, $pdf->GetY() + 2);
                $pdf->SetLineWidth(0.7);
                $pdf->Line($pdf->GetX(), $pdf->GetY() + 2.8, $pdf->GetX() + 195, $pdf->GetY() + 2.8);
                $pdf->SetLineWidth(0.2);
            } else {
                $pdf->Image('./assets/img/kab_bangka.jpg', 20, 5, 20, 27);
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
                $pdf->Cell(185, 4,  $data['alamat_lengkap'], 0, 1, 'C');
                $pdf->Cell(15, 4, '', 0, 0, 'C');
                $pdf->Cell(185, 4, (!empty($data['kode_pos']) ? 'Kode Pos : ' . $data['kode_pos'] . ' ' : '') . (!empty($data['no_tlp']) ? 'Telp. ' . $data['no_tlp'] : ''), 0, 1, 'C');
                $pdf->Cell(15, 4, '', 0, 0, 'C');
                $pdf->Cell(185, 4, (!empty($data['email']) ? ' Email : ' . $data['email'] : '') . (!empty($data['website']) ? ' Website : ' . $data['website'] : ''), 0, 1, 'C');
                $pdf->Line($pdf->GetX(), $pdf->GetY() + 3, $pdf->GetX() + 195, $pdf->GetY() + 3);
                $pdf->SetLineWidth(0.4);
                $pdf->Line($pdf->GetX(), $pdf->GetY() + 3.6, $pdf->GetX() + 195, $pdf->GetY() + 3.6);
                $pdf->SetLineWidth(0.2);
            }
        } else if ($data['jen_satker'] == 4) {
            if ($data['id_satuan'] == 120) {
                $pdf->Image('./assets/img/kab_bangka.jpg', 20, 5, 20, 27);
                $pdf->Image('./assets/img/logo_kalk.jpg', 170, 3, 40, 30);
                $pdf->SetFont('Arial', '', 13);
                $pdf->SetFont('Arial', 'B', 15);
                $pdf->Cell(20, 6, '', 0, 0, 'C');
                $pdf->Cell(155, 6, 'PEMERINTAH KABUPATEN BANGKA', 0, 1, 'C');
                $pdf->Cell(20, 6, '', 0, 0, 'C');
                $pdf->Cell(155, 6, 'DINAS KESEHATAN', 0, 1, 'C');
                $pdf->Cell(20, 6, '', 0, 0, 'C');
                $pdf->SetFont('Arial', 'B', 20);
                $pdf->Cell(155, 7, 'UPTD LABORATORIUM KESEHATAN', 0, 1, 'C');
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(20, 4, '', 0, 0, 'C');
                $pdf->Cell(155, 4,  " Jalan Raya Belinyu Lingkungan Jelutung Kelurahan Sinar Jaya", 0, 1, 'C');
                $pdf->Cell(20, 4, '', 0, 0, 'C');
                $pdf->Cell(155, 4, 'Sungailiat 33212', 0, 1, 'C');
                $pdf->Cell(20, 4, '', 0, 0, 'C');
                $pdf->Cell(155, 4, (!empty($data['email']) ? ' Email : ' . $data['email'] : '') . (!empty($data['website']) ? ' Website : ' . $data['website'] : ''), 0, 1, 'C');
                $pdf->Line($pdf->GetX(), $pdf->GetY() + 3, $pdf->GetX() + 195, $pdf->GetY() + 3);
                $pdf->SetLineWidth(0.4);
                $pdf->Line($pdf->GetX(), $pdf->GetY() + 3.6, $pdf->GetX() + 195, $pdf->GetY() + 3.6);
                $pdf->SetLineWidth(0.2);
            }
        }
    }

    public function print($id, $tipe, $qr = 1, $cap = 1)
    {
        $filter = $this->input->get();
        $data = $this->SPPDModel->getAllSPPD(['id_spt' => $id])[$id];

        if ($tipe == 1)
            $this->print_spt($data, $qr, $cap);
        if ($tipe == 2)
            $this->print_sppd($data, $qr);
        if ($tipe == 3)
            $this->print_lpd($data);
        if ($tipe == 4)
            $this->print_pencairan($data);
    }

    function template_kwitansi($pdf, $dasar, $laporan, $data, $sign_ppk, $sign_pptk, $bendahara, $bendahara_pem, $data_satuan, $pegawai = null)
    {
        $pdf->SetFont('Arial', 'BU', 15);
        $pdf->SetFillColor(230, 230, 230);
        // $pdf->Cell(190, 7, ' ', 0, 1, 'L', 0);
        $pdf->SetLineWidth(0.4);
        $y1 = $pdf->GetY();
        $pdf->Cell(195, 5, 'TANDA BUKTI PEMBAYARAN', 0, 1, 'C', 0);
        $pdf->Cell(10, 4, '', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 7.5);
        $y2 = $pdf->GetY();
        $pdf->Cell(30, 5, 'Pembebanan Atas', 0, 0, 'L');
        $pdf->Cell(3, 5, ':', 0, 0, 'L');
        // $pdf->Cell(100, 5, 'Tujuan Perjalanan Dinas :', 0, 1, 'L');
        $pdf->MultiCell(50, 5, $dasar['pembebanan_anggaran'], 0, 'L');
        $pdf->Cell(10, 1, '', 0, 1, 'L');
        $pdf->Cell(30, 5, 'Mata Anggaran', 0, 0, 'L');
        $pdf->Cell(3, 5, ':', 0, 0, 'L');
        // $pdf->Cell(100, 5, 'Tujuan Perjalanan Dinas :', 0, 1, 'L');
        $pdf->MultiCell(50, 5, $dasar['kode_rekening'], 0, 'L');
        $pdf->Cell(10, 1, '', 0, 1, 'L');

        $pdf->Cell(30, 5, 'Tahun Anggaran', 0, 0, 'L');
        $pdf->Cell(3, 5, ':', 0, 0, 'L');
        // $pdf->Cell(100, 5, 'Tujuan Perjalanan Dinas :', 0, 1, 'L');
        $pdf->MultiCell(50, 5, substr($data['tgl_pengajuan'], 0, 4), 0, 'L');
        $pdf->Cell(10, 1, '', 0, 1, 'L');

        $pdf->Cell(30, 5, 'Diperiksa Oleh', 0, 0, 'L');
        $pdf->Cell(3, 5, ':', 0, 0, 'L');
        // $pdf->Cell(100, 5, 'Tujuan Perjalanan Dinas :', 0, 1, 'L');
        $pdf->MultiCell(50, 5, 'PPK SKPD', 0, 'C');
        $pdf->Cell(10, 15, '', 0, 1, 'L');
        $pdf->Cell(33, 5, '', 0, 0, 'L');
        $pdf->MultiCell(50, 5, "{$bendahara['nama']}\nNIP.  " . format_nip($bendahara['nip']), 0, 'C');

        $y3 = $pdf->GetY();
        $w1 = 85;
        $pdf->SetY($y2);
        $pdf->Cell($w1, 5, '', 0, 0, 'L');
        $pdf->Cell(30, 5, 'Sudah Terima Dari', 0, 0, 'L');
        $pdf->Cell(3, 5, ':', 0, 0, 'L');
        // echo json_encode($data_satuan);
        // die();
        $pdf->MultiCell(83, 5, "Bendahara Pengeluaran Pembantu SKPD \n" . $data_satuan['nama_satuan'], 0, 'L');

        $pdf->Cell(10, 5, '', 0, 1, 'L');
        $pdf->Cell($w1, 5, '', 0, 0, 'L');
        $pdf->Cell(30, 5, 'Tebilang', 0, 0, 'L');
        $pdf->Cell(3, 5, ':', 0, 0, 'L');
        $pdf->MultiCell(83, 5, terbilang(!empty($pegawai) ? $pegawai['honorarium'] : $laporan['honorarium']) . ' Rupiah', 0, 'L');

        $pdf->Cell(10, 5, '', 0, 1, 'L');
        $pdf->Cell($w1, 5, '', 0, 0, 'L');
        $pdf->Cell(30, 5, 'Yaitu Untuk', 0, 0, 'L');
        $pdf->Cell(3, 5, ':', 0, 0, 'L');
        if ($data['jenis'] == 3)
            $pdf->MultiCell(83, 5, "Pembayaran lembur dalam rangka " . $data['maksud'], 0, 'L');
        else if ($data['jenis'] == 2)
            $pdf->MultiCell(83, 5, "Pembayaran perjalanan dinas dalam rangka " . $data['maksud'], 0, 'L');
        $pdf->Cell(10, 10, '', 0, 1, 'L');
        $pdf->SetFont('Arial', 'BI', 14);
        $pdf->Cell($w1, 5, '', 0, 0, 'L');
        $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 70, $pdf->GetY());
        // $pdf->Cell(10, 5, '                                                  ', 0, 1, 'L');
        // $pdf->Cell($w1, 5, '', 0, 0, 'L');
        $pdf->Cell(70, 8, 'RP. ' . number_format(!empty($pegawai) ? $pegawai['honorarium'] : $laporan['honorarium'], 2, ',', '.'), 0, 1, 'C');
        $pdf->Cell($w1, 5, '', 0, 0, 'L');
        $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 70, $pdf->GetY());
        $y4 = $pdf->GetY();
        $pdf->SetFont('Arial', '', 7.5);

        if ($y4 > $y3) $fy = $y4 + 3;
        else $fy = $y3 + 3;
        $pdf->Line($w1 + 5, $y2, $w1 + 5, $fy);

        $pdf->SetY($fy);
        $pdf->Line(3, $fy, 212, $fy);

        $pdf->Cell(50, 4, 'Mengetahui :', 0, 0, 'C');
        $pdf->Cell(55, 4, 'Mengetahui :', 0, 0, 'C');
        $pdf->Cell(50, 4, 'Tanggal,                            ' . substr($data['tgl_pengajuan'], 0, 4), 0, 0, 'C');

        $pdf->Cell(50, 4, '', 0, 1, 'C');
        $y5 = $pdf->GetY();
        $pdf->MultiCell(50, 4, "Kuasa Pengguna Anggaran\nDinas Kesehatan\nKabupaten Bangka", 0, 'C');
        $pdf->SetY($y5);
        $pdf->Cell(50, 4, '', 0, 0, 'C');
        $pdf->MultiCell(55, 4, "Pejabat Pelaksana Teknis Kegiatan\nPPTK", 0, 'C');
        $pdf->SetY($y5);
        $pdf->Cell(105, 4, '', 0, 0, 'C');
        $pdf->MultiCell(50, 4, "Bendahara Pengeluaran Pembantu", 0, 'C');
        $pdf->SetY($y5);
        $pdf->Cell(155, 4, '', 0, 0, 'C');
        $pdf->MultiCell(50, 4, "Tanda Tangan Penerima ", 0, 'C');
        $pdf->SetY($y5 + 30);
        $pdf->MultiCell(50, 4, $sign_ppk['sign_name'], 0, 'C');
        $pdf->MultiCell(50, 4, 'NIP. ' . format_nip($sign_ppk['sign_nip']), 0, 'C');
        $y6 = $pdf->GetY();
        $pdf->SetXY(57, $y5 + 30);
        // echo json_encode($sign_pptk);
        // die();
        $pdf->MultiCell(55, 4, $sign_pptk['sign_name'], 0, 'C');
        $pdf->SetX(57);
        $pdf->MultiCell(55, 4, 'NIP. ' . format_nip($sign_pptk['sign_nip']), 0, 'C');
        if ($y6 < $pdf->GetY())
            $y6 = $pdf->GetY();
        $pdf->SetXY(112, $y5 + 30);
        $pdf->MultiCell(50, 4, $bendahara_pem['nama'], 0, 'C');
        $pdf->SetX(112);
        $pdf->MultiCell(50, 4, 'NIP. ' . format_nip($bendahara_pem['nip']), 0, 'C');
        if ($y6 < $pdf->GetY())
            $y6 = $pdf->GetY();
        $pdf->SetXY(162, $y5 + 30);
        $pdf->MultiCell(50, 4, !empty($pegawai) ? $pegawai['nama'] : $data['pel_nama'], 0, 'C');
        $pdf->SetX(162);
        $pdf->MultiCell(50, 4, 'NIP. ' . format_nip(!empty($pegawai) ? $pegawai['nip'] : $data['nip_pegawai']), 0, 'C');
        if ($y6 < $pdf->GetY())
            $y6 = $pdf->GetY();
        $pdf->Line(57, $fy, 57, $y6);
        $pdf->Line(112, $fy, 112, $y6);
        $pdf->Line(162, $fy, 162, $y6);
        $pdf->cell(1, 20, '', 0, 1);
    }

    function print_pencairan($data)
    {
        $laporan = $this->SPPDModel->getLaporan(array('id_spt' => $data['id_spt']));
        if (!empty($laporan))
            $laporan = $laporan[$data['id_spt']];
        else {
            throw new UserException('Maaf, Laporan tidak ditemukan.');
        }

        $dasar = $this->SPPDModel->getDasarSppd(array('id_dasar' => $data['id_dasar']));
        if (!empty($dasar))
            $dasar = $dasar[$data['id_dasar']];
        else {
            throw new UserException('Maaf, Dasar tidak ditemukan.');
        }
        // echo json_encode($dasar);
        // die();
        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('P', 'mm', array(215.9, 355.6));
        if (!empty($data['no_spt']))
            $filename = 'TANDA BUKTI PEMBAYARAN ' . $data['no_spt'];
        else
            $filename = 'TANDA BUKTI PEMBAYARAN ' . $data['id_spt'];
        $pdf->SetTitle($filename);
        $pdf->SetMargins(7, 5, 7, 5);
        $pdf->AddPage();
        $data_satuan =  $this->GeneralModel->getSatuan(['id_satuan' => $data['id_satuan']])[0];
        $sign_pptk = $this->GeneralModel->getSign(['id' => $data['sign_pptk']])[0];
        $sign_ppk = $this->GeneralModel->getSign(['id' => $data['sign_ppk']])[0];
        // die();

        $bendahara = $this->GeneralModel->getSingnature($data_satuan['bendahara'])[$data_satuan['bendahara']];
        if ($dasar['jen_ppk'] == 1)
            $bendahara_pem = $this->GeneralModel->getSingnature($data_satuan['bendahara_pem'])[$data_satuan['bendahara_pem']];
        else
            $bendahara_pem = $this->GeneralModel->getSingnature($data_satuan['bendahara_pem_blud'])[$data_satuan['bendahara_pem_blud']];
        $this->template_kwitansi($pdf, $dasar,  $laporan, $data, $sign_ppk, $sign_pptk, $bendahara, $bendahara_pem, $data_satuan);
        $pdf->SetDash(4, 2);
        $pdf->Line(3, $pdf->GetY(), 212, $pdf->GetY());
        $pdf->SetDash();
        $pdf->cell(1, 10, '', 0, 1);
        // echo json_encode($data);
        // die();
        // $pdf->Cell(50, 15, '', 1, 0, 'C');
        // $pdf->Cell(50, 5, 'Tanggal,                            ' . substr($data['tgl_pengajuan'], 0, 4), 1, 0, 'C');
        // $pdf->Cell(50, 5, '', 1, 0, 'C');
        $i = 2;
        foreach ($data['pengikut'] as $p) {
            $pdf->cell(1, 10, '', 0, 1);
            $this->template_kwitansi($pdf, $dasar,  $laporan, $data, $sign_ppk, $sign_pptk, $bendahara, $bendahara_pem, $data_satuan, $p);
            if ($i == 1) {
                $pdf->cell(1, 10, '', 0, 1);
                $pdf->SetDash(4, 2);
                $pdf->Line(3, $pdf->GetY(), 212, $pdf->GetY());
                $pdf->SetDash();
                $i = 2;
            } else {
                $pdf->AddPage();
                $i = 1;
            }
            // $i++;
            // if (!empty($sign['signature'])) {
            // }
        }


        $pdf->Output('', $filename, false);
    }
    function print_lpd($data)
    {
        $laporan = $this->SPPDModel->getLaporan(array('id_spt' => $data['id_spt']));
        if (!empty($laporan))
            $laporan = $laporan[$data['id_spt']];
        else {
            throw new UserException('Maaf, Laporan tidak ditemukan.');
        }
        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('P', 'mm', array(215.9, 355.6));

        if (!empty($data['no_spt']))
            $filename = 'LPD ' . $data['no_spt'];
        else
            $filename = 'LPD ' . $data['id_spt'];
        $pdf->SetTitle($filename);
        $pdf->SetMargins(10, 5, 15, 10, 'C');
        $pdf->AddPage();
        $data_satuan =  $this->GeneralModel->getSatuan(['id_satuan' => $data['id_satuan']])[0];

        $this->kop($pdf,  $data_satuan);

        $pdf->SetFont('Arial', '', 9.5);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(190, 7, ' ', 0, 1, 'L', 0);
        $pdf->SetLineWidth(0.4);
        if ($data['jenis'] == 3)
            $pdf->Cell(195, 5, 'LAPORAN LEMBUR', 0, 1, 'C', 0);
        else if ($data['jenis'] == 2)
            $pdf->Cell(195, 5, 'LAPORAN PERJALANAN DINAS', 0, 1, 'C', 0);
        else if ($data['jenis'] == 1)
            $pdf->Cell(195, 5, 'LAPORAN TUGAS', 0, 1, 'C', 0);
        $pdf->Cell(10, 10, '', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10.5);
        $pdf->Cell(10, 5, 'I.', 0, 0, 'L');
        $pdf->Cell(100, 5, 'Tujuan :', 0, 1, 'L');
        $pdf->Cell(10, 5, '', 0, 0, 'L');
        $pdf->MultiCell(185, 5, $data['maksud'], 0, 'L');
        $pdf->Cell(10, 5, '', 0, 1, 'L');

        $pdf->Cell(10, 5, 'II.', 0, 0, 'L');
        $pdf->Cell(100, 5, 'Dasar Pelaksanaan :', 0, 1, 'L');
        $pdf->Cell(10, 5, '', 0, 0, 'L');
        $pdf->Cell(4, 5, 'a.', 0, 0, 'L');
        $pdf->Cell(70, 5, 'Surat Perintah Tugas Nomor ', 0, 0, 'L');
        $pdf->Cell(4, 5, ':', 0, 0, 'L');
        $pdf->Cell(90, 5, $data['no_spt'], 0, 1, 'L');

        if ($data['jenis'] == 2) {
            $pdf->Cell(10, 5, '', 0, 0, 'L');
            $pdf->Cell(4, 5, 'b.', 0, 0, 'L');
            $pdf->Cell(70, 5, 'Surat Perintah Perjalanan Dinas Nomor ', 0, 0, 'L');
            $pdf->Cell(4, 5, ':', 0, 0, 'L');
            $pdf->Cell(90, 5, $data['no_sppd'], 0, 1, 'L');
        }

        $pdf->Cell(10, 5, '', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10.5);
        $pdf->Cell(10, 5, 'III.', 0, 0, 'L');
        $pdf->Cell(100, 5, 'Hasil laporan :', 0, 1, 'L');
        $pdf->Cell(10, 2, '', 0, 1, 'L');
        $pdf->Cell(10, 5, '', 0, 0, 'L');
        $pdf->MultiCell(185, 5, $this->convertHTML($laporan['text_laporan']), 0, 'L');
        $pdf->Cell(70, 5, '', 0, 1, 'L');
        $pdf->Cell(100, 5, '', 0, 0, 'L');
        // echo json_encode($data['tujuan']);
        // die();
        $hari_terakhir = '';
        foreach ($data['tujuan'] as $key => $t) {

            if ($data['jenis'] == '3') {
                $hari_terakhir = $t['date_kembali'];
            } else {
                if (!empty($t['date_kembali'])) {
                    $hari_terakhir = $t['date_kembali'];
                }
            }
        }
        // echo $hari_terakhir;
        // die();
        $pdf->Cell(90, 5, $data_satuan['satuan_tempat'] . ', ' . tanggal_indonesia($hari_terakhir), 0, 1, 'C');
        $pdf->Cell(100, 5, '', 0, 0, 'L');
        $pdf->Cell(90, 5, 'Yang Melaporkan :', 0, 1, 'C');
        $pdf->Cell(100, 3, '', 0, 1, 'L');
        $pdf->Cell(120, 10, $data['pel_nama'], 0, 0, 'R');
        $pdf->Cell(70, 10, '(....................................................)', 0, 1, 'C');
        // $sign = $this->GeneralModel->getSingnature($data['id_pegawai'])[$data['id_pegawai']];
        if (!empty($data['pel_sign']))
            $pdf->Image('./uploads/signature/' . $data['pel_sign'], 141, $pdf->getY() - 14, 30, 20);
        $i = 0;
        foreach ($data['pengikut'] as $p) {
            $pdf->Cell(120, 10, $p['p_nama'], 0, 0, 'R');
            $pdf->Cell(70, 10, '(....................................................)', 0, 1, 'C');
            // $sign = $this->p_->getSingnature($p['id_pegawai'])[$p['id_pegawai']];
            if (!empty($p['p_sign'])) {
                if ($i != 0) {
                    $pdf->Image('./uploads/signature/' . $p['p_sign'], 141, $pdf->getY() - 14, 30, 20);
                    $i = 0;
                } else {
                    $i = 1;
                    $pdf->Image('./uploads/signature/' . $p['p_sign'], 161, $pdf->getY() - 14, 30, 20);
                }
            }
        }

        $foto = $this->SPPDModel->getFoto(['id_spt' => $data['id_spt']]);
        if (!empty($foto)) {
            $pdf->AddPage();
            $this->kop($pdf,  $data_satuan);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->SetFillColor(230, 230, 230);
            $pdf->Cell(190, 7, ' ', 0, 1, 'L', 0);
            $pdf->SetLineWidth(0.4);
            $pdf->Cell(195, 5, 'FOTO PERJALANAN DINAS', 0, 1, 'C', 0);
            $pdf->Cell(10, 10, '', 0, 1, 'L');
            $pdf->SetFont('Arial', '', 10.5);
            $j = 1;
            foreach ($foto as $f) {
                $pdf->CheckPageBreak(50);
                $pdf->Cell(16, 10, $j . '. ', 0, 0, 'L');
                $pdf->Cell(80, 10, ' ', 0, 0, 'L');
                $pdf->Image('./uploads/foto_sppd/' . $f['file_foto'], 20, $pdf->getY(), 80, 50);
                $tmp_y = $pdf->getY() + 52;

                $pdf->MultiCell(100, 10, $f['deskripsi'], 0,  'L');
                if ($tmp_y > $pdf->getY());
                $pdf->SetY($tmp_y);
                $j++;
            }
        }
        $pdf->Output('', $filename, false);
    }
    function convertHTML($string)
    {
        // $string = preg_replace_callback('#<ol>(.*?)</ol>#Us', $this->change_li($string), $string);

        // str
        $i = 1;
        $string = str_replace('&nbsp;', " ", $string);
        $string = preg_replace_callback("#<ol>(.*?)</ol>#Us",  function ($matches) {
            $dom = new DOMDocument();
            $dom->loadHTML($matches[0]);
            // $dom->loadHTML($str);
            $newstring = '';
            $j = 1;
            foreach ($dom->getElementsByTagName('li') as $ul) {
                $newstring .=  $j . '. ' . $ul->nodeValue . "\n";
                $j++;
            }

            return $newstring;
        }, $string);
        $string = str_replace('<li>', "- ", $string);
        $string = str_replace('</li>', "\n", $string);
        $string = str_replace('</p>', "\n\n", $string);
        $string = str_replace('&nbsp;', " ", $string);
        // return $string;
        return strip_tags($string);
    }
    function change_li($m)
    {
        return preg_replace('#<li>#', '<li><tag>', $m[0]);
    }
    function print_sppd($data, $qr = 1)
    {
        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('P', 'mm', array(215.9, 355.6));
        if (!empty($data['no_sppd']))
            $filename = 'SPPD ' . $data['no_sppd'] . '.pdf';
        else
            $filename = 'SPPD ' . $data['id_spt'] . '.pdf';
        $pdf->SetTitle($filename);
        $pdf->SetMargins(10, 5, 15, 10, 'C');
        $pdf->AddPage();
        $data_satuan =  $this->GeneralModel->getSatuan(['id_satuan' => $data['id_satuan']])[0];
        $dasar = $this->SPPDModel->getDasarSppd(array('id_dasar' => $data['id_dasar']));
        if (!empty($dasar))
            $dasar = $dasar[$data['id_dasar']];

        $this->kop($pdf,  $data_satuan);

        $pdf->SetFont('Arial', '', 9.5);

        // $pdf->Cell(190, 5, 'Tanggal : ' . tanggal_indonesia($data['tanggal_pengajuan']), 0, 1, 'R');
        $pdf->SetFillColor(230, 230, 230);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(190, 6, ' ', 0, 1, 'L', 0);
        $pdf->Cell(130, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(20, 5, 'Lembar Ke : ', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(42, 5, '......................................', 0, 1, 'L', 0);
        $pdf->Cell(130, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(20, 5, 'Kode No ', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(42, 5, '......................................', 0, 1, 'L', 0);
        $pdf->Cell(130, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(20, 5, 'Nomor', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(42, 5, $data['no_sppd'], 0, 1, 'L', 0);
        $pdf->Cell(130, 3, '', 0, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(195, 5, 'SURAT PERJALANAN DINAS (SPD)', 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetFont('Arial', '', 11);

        $r1 = 5;
        $r2 = 6;
        $r3 = 70;
        $r4 = 90;
        $tujuan_text = 'b. ';
        $count_t = count($data['tujuan']);
        $i = 1;
        $d1 = '';
        $d2 = 'a. ';
        $cetak_tgl  = '';
        foreach ($data['tujuan'] as $tujuan) {
            if ($i == 1) {
                $cetak_tgl  = $tujuan['date_berangkat'];
                $d1 = $tujuan['date_berangkat'];
                $tujuan_text .= $tujuan['tempat_tujuan'];
            } else if ($count_t == $i) {
                $tujuan_text .= ' dan ' . $tujuan['tempat_tujuan'];
            } else {
                $tujuan_text .= ', ' . $tujuan['tempat_tujuan'];
            }
            if (!empty($tujuan['date_kembali']))
                $d2 = $tujuan['date_kembali'];
            $i++;
        }
        // $sign_kadin = [];
        if ($data['status'] == '99' && !empty($data['sign_kadin'])) {
            $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
        }
        // if ($d1 != $d2) {
        //     $tujuan_text .= ' pada tanggal ' . tanggal_indonesia($d1) . ' sampai ' . tanggal_indonesia($d2);
        // } else {
        //     $tujuan_text .= ' pada tanggal ' . tanggal_indonesia($d1);
        // }

        if ($dasar['jen_ppk'] == 1)
            $pdf->RowSPPD('1.', 'Pejabat Pembuat Komitmen', $data['nama_ppk'] . ' / ' . $data['nip_ppk']);
        else
            $pdf->RowSPPD('1.', 'Pimpinan BLUD', $data['nama_ppk'] . ' / ' . $data['nip_ppk']);
        $pdf->RowSPPD('2.', 'Nama/NIP Pegawai yang melaksanakan perjalanan dinas ', $data['pel_nama'] . ' / ' . $data['pel_nip']);
        $pdf->RowSPPD('3.', 'a. Pangkat dan Golongan', 'a. ' . $data['pel_pangkat_gol']);
        $pdf->RowSPPD('', 'b. Jabatan / Instansi', 'b. ' . $data['pel_jabatan'] . ' / ' . $data_satuan['nama_satuan']);
        $pdf->RowSPPD('', 'c. Tingkat Biaya Perjalanan Dinas', 'c. ');
        $pdf->RowSPPD('4.', 'Maksud Perjalanan Dinas', $data['maksud']);
        $pdf->RowSPPD('5.', 'Alat angkut yang dipergunakan ', $data['nama_transport']);
        $pdf->RowSPPD('6.', 'a. Tempat berangkat', 'a. ' . (empty($data['berangkat_dari']) ? $data_satuan['nama_satuan'] : $data['berangkat_dari']));
        $pdf->RowSPPD('', 'b. Tempat Tujuan', $tujuan_text);
        $pdf->RowSPPD('7.', 'a. Lamanya perjalanan dinas', 'a. ' . $data['lama_dinas'] . ' hari');
        $pdf->RowSPPD('', 'b. Tanggal berangkat', 'b. ' . tanggal_indonesia($d1));
        $pdf->RowSPPD('', 'c. Tanggal harus kembali', 'c. ' . tanggal_indonesia($d2));
        $i = 1;
        $pdf->RowSPPD('8.', 'Pengikut', 'Tanggal Lahir', 'Keterangan');
        if (!empty($data['pengikut']))
            foreach ($data['pengikut'] as $pengikut) {
                $pdf->RowSPPD('', $i . '. ' . $pengikut['p_nama'], tanggal_indonesia($pengikut['p_tgl_lahir']), '-');
                $i++;
            }
        else {
            $pdf->RowSPPD(' ', '-', '-', '-');
        }
        $dasar =  $this->SPPDModel->getDasarSppd(['id_dasar' => $data['id_dasar']])[$data['id_dasar']];
        // echo json_encode($dasar);
        // die();
        $pdf->RowSPPD('9.', 'Pembebanan anggaran ', $dasar['pembebanan_anggaran']);
        if ($data_satuan['jen_satker'] == 1)
            $pdf->RowSPPD('', 'a. SKPD', 'Dinas Kesehatan Kabupaten Bangka');
        else
            $pdf->RowSPPD('', 'a. SKPD', ucwords(strtolower($data_satuan['nama_satuan'])));

        // }
        $pdf->RowSPPD('', 'b. Akun', $dasar['kode_rekening']);
        $pdf->RowSPPD('10.', "Keterangan lain-lain ", '');

        $pdf->SetFont('Arial', 'B', 11);
        // $pdf->Cell(195, 5, 'DAFTAR ABSENSI KEHADIRAN GURU PEGAWAI BULAN ' . strtoupper(bulan_indo(explode('-', $bulan)[1])) . ' ' . explode('-', $bulan)[0], 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(3, 5, "", 0, 1, 'L', 0);
        $cur_x = $pdf->getX();
        $cur_y = $pdf->GetY();

        $pdf->CheckPageBreak(65);
        // echo json_
        if ($data['status'] == '99' && !empty($data['sign_ppk'])) {
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Ditetapkan di', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, $data_satuan['satuan_tempat'], 0, 1, 'L', 0);

            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Pada Tanggal', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, tanggal_indonesia($cetak_tgl), 0, 1, 'L', 0);
            $sign_ppk =  $this->GeneralModel->getSign(['id' => $data['sign_ppk']])[0];
            $pdf->Cell(120, 5, '', 0, 1, 'C', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(75, 5,  $sign_ppk['sign_title'], 0, 'L', 0);

            $pdf->Cell(120, 25, '', 0, 1, 'C', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(75, 5,  $sign_ppk['sign_name'], 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(45, 5,  $sign_ppk['sign_pangkat'], 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(75, 5,  'NIP. ' . $sign_ppk['sign_nip'], 0, 'L', 0);
            if (!empty($sign_ppk['sign_signature'])) $pdf->Image('./uploads/signature/' . $sign_ppk['sign_signature'], 140, $pdf->getY() - 40, 0, 26);

            if ($qr == 2) {
                if (empty($data['qrcode'])) {
                    $key = md5($data['no_spt'] . time());
                    $this->SPPDModel->addQRCode(['qrcode' => $key, 'id_spt' => $data['id_spt']]);
                    $this->addQRCode($key, 20);
                    $pdf->Image('./uploads/qrcode/20' .  $key . '.png', 40, $pdf->getY() - 40.5, 25);
                } else {
                    $pdf->Image('./uploads/qrcode/20' . $data['qrcode'] . '.png', 40, $pdf->getY() - 40.5, 25);
                }
            }
        } else {
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Ditetapkan di', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, '', 0, 1, 'L', 0);

            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Pada Tanggal', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, '', 0, 1, 'L', 0);
            // $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
            $pdf->Cell(120, 5, '', 0, 1, 'C', 0);
            // $pdf->MultiCell(45, 5,  'ttd', 0, 'L', 0);

            // $pdf->Cell(120, 25, '', 0, 1, 'C', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(45, 5,  'ttd', 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(45, 5,  '', 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(45, 5,  '', 0, 'L', 0);
            // $pdf->Image(base_url('uploads/signature/' . $sign_kadin['sign_signature']), 140, $pdf->getY() - 40, 40);
        }
        $pdf->AddPage();
        $pdf->Cell(30, 5, '', 0, 1, 'L', 0);
        $cur_x = $pdf->GetX();
        $cur_y = $pdf->GetY();

        $pdf->Rect($cur_x + 1, $cur_y, 97, 60);
        $pdf->Rect($cur_x + 1 + 97, $cur_y, 97, 60);
        $cur_y = $cur_y + 20;
        for ($i = 1; $i < 5; $i++) {
            $pdf->Rect($cur_x + 1, $cur_y + (40 * $i), 97, 40);
            $pdf->Rect($cur_x + 1 + 97, $cur_y + (40 * $i), 97, 40);
        }
        $cur_y = $cur_y + 200;
        $pdf->Rect($cur_x + 1, $cur_y, 97, 70);
        $pdf->Rect($cur_x + 1 + 97, $cur_y, 97, 70);

        $pdf->SetX($cur_x + 100);
        $pdf->Cell(4, 4, "I", 0, 0, 'L');
        $pdf->Cell(30, 4, "Berangkat dari", 0, 0, 'L');
        $pdf->Cell(3, 4, ":", 0, 0, 'L');
        $pdf->MultiCell(58, 4, $data['berangkat_dari'] . "", 0,  'L');

        $pdf->SetX($cur_x + 104);
        $pdf->Cell(30, 4, "Ke", 0, 0, 'L');
        $pdf->Cell(3, 4, ":", 0, 0, 'L');
        $pdf->MultiCell(58, 4, $data['tujuan'][0]['tempat_tujuan'], 0,  'L');

        $pdf->SetX($cur_x + 104);
        $pdf->Cell(30, 4, "Pada Tanggal", 0, 0, 'L');
        $pdf->Cell(3, 4, ":", 0, 0, 'L');
        $pdf->MultiCell(58, 4, tanggal_indonesia($data['tujuan'][0]['date_berangkat']), 0,  'L');


        // if ($data_satuan['jen_satker'] == 1 or ($data_satuan['jen_satker'] != 1 && $data['luardaerah'] == 2))
        // $pdf->Cell(30, 1, "", 0, 1);
        // $pdf->SetX($cur_x + 108);
        // // if ($data_satuan['jen_satker'] == 1 or ($data_satuan['jen_satker'] != 1 && $data['luardaerah'] == 2))
        // if ($data_satuan['jen_satker'] == 1)
        //     $pdf->MultiCell(80, 4, "Kepala Dinas Kesehatan\nKabupaten Bangka", 0, 'L');
        // else
        //     // if ($data_satuan['jen_satker'] == 2)
        //     $pdf->MultiCell(80, 4, "Kepala\n" . ucwords(strtolower($data_satuan['nama_satuan'])), 0, 'L');
        // $pdf->Cell(30, 19, "", 0, 1);
        // // $pdf->Cell(30, 1, "", 1, 1);
        // // $pdf->SetY(50);

        $pdf->Cell(30, 1, "", 0, 1);
        if ($data_satuan['jen_satker'] == 1 or $data['luardaerah'] == '2') {
            if (!empty($sign_kadin['sign_plh'])) {
                $pdf->SetX($cur_x + 104);
                $pdf->Cell(8, 4, "Plt.", 0, 0);
                // echo json_encode($sign_kadin['sign_title']);
                // die();
                $pdf->MultiCell(80, 4, "Kepala Dinas Kesehatan\nKabupaten Bangka, \n" . $sign_kadin['sign_title'], 0, 'L');
            } else {
                $pdf->SetX($cur_x + 108);
                $pdf->MultiCell(80, 4, "Kepala Dinas Kesehatan\nKabupaten Bangka", 0, 'L');
            }
        } else {
            $pdf->Cell(30, 1, "", 0, 1);
            $pdf->SetX($cur_x + 108);
            $pdf->MultiCell(80, 4, "Kepala\n" . ucwords(strtolower($data_satuan['nama_satuan'])), 0, 'L');
        }

        $pdf->SetXY($cur_x + 108, 62);
        if (!empty($sign_kadin)) {
            $pdf->Cell(80, 4, $sign_kadin['sign_name'], 0, 1);
            $pdf->Cell(108, 4, "", 0);
            $pdf->Cell(80, 4, 'NIP. ' . format_nip($sign_kadin['sign_nip']), 0, 1);
            // $pdf->Cell(108, 5, "", 0);
            // $pdf->Cell(80, 5, 'NIPs.' . $sign_kadin['sign_nip'], 1);
            if (!empty($sign_kadin['sign_signature'])) $pdf->Image('./uploads/signature/' . $sign_kadin['sign_signature'], 120, $pdf->getY() - 35, 0, 25);
        }


        $pdf->SetXY($cur_x + 1, 71);
        // if ($count_t = 1)
        $star_x = $cur_x + 2;
        $star_y = 71;
        $tanggal_akhir = '';
        for ($i = 0; $i < 4; $i++) {
            $pdf->SetXY($star_x, 72 + ($i * 40));
            $pdf->Cell(5, 4, to_romawi($i + 2), 0, 'C');
            $pdf->Cell(24, 4, 'Tiba di', 0);
            $pdf->Cell(3, 4, ':', 0, 0);
            if (!empty($data['tujuan'][$i])) {
                $pdf->MultiCell(64, 4, $data['tujuan'][$i]['tempat_tujuan'], 0, 1);
                $pdf->Cell(7, 4, '', 0, 'C');
                $pdf->Cell(24, 4, 'Pada tanggal', 0, 0);
                $pdf->Cell(3, 4, ':', 0, 0);
                $pdf->Cell(3, 4, tanggal_indonesia($data['tujuan'][$i]['date_berangkat']), 0, 'L');

                $pdf->SetXY($star_x + 98, 72 + ($i * 40));
                $pdf->Cell(24, 4, 'Berangkat dari ', 0, 'L');
                $pdf->Cell(3, 4, ':', 0, 'C');
                $pdf->MultiCell(66, 4, $data['tujuan'][$i]['tempat_tujuan'], 0, 'L');
                $pdf->SetX($star_x + 98);
                $pdf->Cell(24, 4, 'Ke ', 0, 'L');
                $pdf->Cell(3, 4, ':', 0, 'C');
                $pdf->MultiCell(66, 4, $data['tujuan'][$i]['tempat_kembali'], 0, 'L');
                $pdf->SetX($star_x + 98);
                $pdf->Cell(24, 4, 'Pada tanggal', 0, 'L');
                $pdf->Cell(3, 4, ':', 0, 'C');
                $tanggal_akhir = tanggal_indonesia($data['tujuan'][$i]['date_kembali']);
                $pdf->Cell(3, 4, tanggal_indonesia($data['tujuan'][$i]['date_kembali']), 0, 'L', 1);
            } else {
                $pdf->MultiCell(64, 4, '', 0, 'L');
                $pdf->Cell(7, 4, '', 0, 'C');
                $pdf->Cell(24, 4, 'Pada tanggal', 0, 'L');
                $pdf->Cell(3, 4, ':', 0, 1);

                $pdf->SetXY($star_x + 98, 72 + ($i * 40));
                $pdf->Cell(24, 4, 'Berangkat dari ', 0, 'L');
                $pdf->Cell(3, 4, ':', 0, 1, 1);
                $pdf->SetX($star_x + 98);
                $pdf->Cell(24, 4, 'Ke ', 0, 'L');
                $pdf->Cell(3, 4, ':', 0, 1, 1);
                $pdf->SetX($star_x + 98);
                $pdf->Cell(24, 4, 'Pada tanggal', 0, 'L');
                $pdf->Cell(3, 4, ':', 0, 'C');
            }
        }


        //last kolom
        $pdf->SetXY($star_x, 72 + ($i * 40));
        $pdf->Cell(5, 4, to_romawi(6), 0, 'C');
        $pdf->Cell(24, 4, 'Tiba kembali di', 0);
        $pdf->Cell(3, 4, ':', 0, 0);
        $pdf->MultiCell(58, 4, (empty($data['berangkat_dari']) ? $data_satuan['nama_satuan'] : $data['berangkat_dari']) . "", 0,  'L');
        $pdf->Cell(7, 4, '', 0, 0);
        $pdf->Cell(24, 4, ' Pada tanggal', 0);
        $pdf->Cell(3, 4, ':', 0, 0);
        $pdf->Cell(58, 4, $tanggal_akhir, 0,  1);
        $pdf->Cell(10, 3, '', 0, 1);
        // $pdf->Cell(10, 4, '', 0, 0);
        // if ($data_satuan['jen_satker'] == 1)
        //     $pdf->MultiCell(80, 4, "Kepala Dinas Kesehatan\nKabupaten Bangka", 0, 'L');
        // else
        //     // if ($data_satuan['jen_satker'] == 2)
        //     $pdf->MultiCell(80, 4, "Kepala\n" . ucwords(strtolower($data_satuan['nama_satuan'])), 0, 'L');

        // $pdf->Cell(10, 4, '', 0, 0);
        if (!empty($sign_kadin['sign_plh'])) {
            $pdf->Cell(2, 4, '', 0, 0);
            // $pdf->SetX($cur_x + 104);
            $pdf->Cell(8, 4, "Plt.", 0, 0);
            // echo json_encode($sign_kadin['sign_title']);
            // die();
            $pdf->MultiCell(80, 4, "Kepala Dinas Kesehatan\nKabupaten Bangka, \n" . $sign_kadin['sign_title'], 0, 'L');
        } else {
            $pdf->Cell(10, 4, '', 0, 0);
            // $pdf->SetX($cur_x + 108);
            $pdf->MultiCell(80, 4, "Kepala Dinas Kesehatan\nKabupaten Bangka", 0, 'L');
        }

        // if ($data_satuan['jen_satker'] == 1)
        //     $pdf->MultiCell(80, 4, "Kepala Dinas Kesehatan\nKabupaten Bangka", 0, 'L');
        // else
        //     // if ($data_satuan['jen_satker'] == 2)
        //     $pdf->MultiCell(80, 4, "Kepala\n" . ucwords(strtolower($data_satuan['nama_satuan'])), 0, 'L');

        $pdf->Cell(30, 28, "", 0, 1);
        $pdf->Cell(10, 4, '', 0, 0);

        $pdf->SetXY($star_x + 8, 72 + ($i * 40) + 52);

        if (!empty($sign_kadin)) {
            $pdf->Cell(80, 4, $sign_kadin['sign_name'], 0, 1);
            $pdf->Cell(10, 4, '', 0, 0);
            $pdf->Cell(80, 4, $sign_kadin['sign_pangkat'], 0, 1);
            $pdf->Cell(10, 4, "", 0);
            $pdf->Cell(80, 4, 'NIP. ' . format_nip($sign_kadin['sign_nip']), 0, 1);
            // $pdf->Cell(108, 4, "", 0);
            // $pdf->Cell(80, 4, 'NIPs.' . $sign_kadin['sign_nip'], 1);
            if (!empty($sign_kadin['sign_signature'])) $pdf->Image('./uploads/signature/' . $sign_kadin['sign_signature'], 17, $pdf->getY() - 40, 0, 25);
        }

        // ppk

        $pdf->SetXY($star_x + 97, 75 + ($i * 40));
        $pdf->MultiCell(96, 4, "Telah diperiksa, dengan keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya. ");
        $pdf->Cell(99, 4, "", 0, 1);
        $pdf->Cell(106, 4, "",);

        $pdf->MultiCell(80, 4, "Pejabat Pembuat Komitmen", 0, 'L');
        $pdf->Cell(30, 25, "", 0, 1);
        $pdf->Cell(106, 4, '', 0, 0);
        // if (!empty($sign_ppk)) {

        $pdf->Cell(80, 4, !empty($sign_ppk) ? $sign_ppk['sign_name'] : '', 0, 1);
        $pdf->Cell(106, 4, '', 0, 0);
        $pdf->Cell(80, 4,  !empty($sign_ppk) ? $sign_ppk['sign_pangkat'] : '', 0, 1);
        $pdf->Cell(106, 4, "", 0);
        $pdf->Cell(80, 4, 'NIP. ' .  (!empty($sign_ppk) ? format_nip($sign_ppk['sign_nip']) : ''), 0, 1);
        // $pdf->Cell(108, 4, "", 0);
        // $pdf->Cell(80, 4, 'NIPs.' . $sign_kadin['sign_nip'], 1);
        if (!empty($sign_ppk['sign_signature'])) $pdf->Image('./uploads/signature/' . $sign_ppk['sign_signature'], 117, $pdf->getY() - 39, 0, 25);
        // }

        $pdf->Cell(1, 4, '', 0, 0);
        $pdf->Cell(194, 4, 'VII  CATATAN LAIN-LAIN ', 1, 1);
        $pdf->Cell(1, 4, '', 0, 0);
        $pdf->Rect($pdf->GetX(), $pdf->GetY(), 194, 20);
        $pdf->Cell(194, 4, 'VIII PERHATIAN', 0, 1);
        $pdf->Cell(7, 4, '', 0, 0);
        $pdf->MultiCell(187, 4, "Pejabat yang berwenang menerbitkan SPPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba serta Bendaharawan bertanggung jawab berdasarkan peraturan-peraturan Keuangan Negara apabila Negara mendapat rugi akibat kesalahan, kealpaanya.");


        $pdf->Output('', $filename, false);
    }

    function print_spt($data, $qr, $cap)
    {
        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('P', 'mm', array(215.9, 355.6));

        $pdf->SetTitle('SPT ' . $data['id_spt']);
        $pdf->SetMargins(10, 5, 15, 10, 'C');
        $pdf->AddPage();
        $data_satuan =  $this->GeneralModel->getSatuan(['id_satuan' => $data['id_satuan']])[0];
        // echo json_encode($data_satuan);
        // die();
        if ($data['luardaerah'] == 2)
            $this->kop($pdf, $data_satuan, true);
        else
            $this->kop($pdf, $data_satuan);

        $pdf->SetFont('Arial', '', 9.5);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(190, 7, ' ', 0, 1, 'L', 0);
        $pdf->SetLineWidth(0.4);
        $pdf->Line(70, $pdf->GetY() + 4.5, 144, $pdf->GetY() + 4.5);
        $pdf->SetLineWidth(0.2);
        $pdf->Cell(195, 5, 'SURAT PERINTAH TUGAS', 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(195, 5, 'Nomor : ' . $data['no_spt'], 0, 1, 'C', 0);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(25, 5, ' ', 0, 1, 'L', 0);
        $pdf->Cell(25, 5, 'Dasar            :', 0, 0, 'L', 0);
        $pdf->Cell(5, 5, '1. ', 0, 0, 'L', 0);
        $pdf->MultiCell(165, 5, !empty($data['nama_dasar']) ? $data['nama_dasar'] : $data['dasar'], 0, 'J');
        $dasar_tambahan = $this->SPPDModel->getDasar($data['id_spt']);
        $idt = 2;
        foreach ($dasar_tambahan as $dt) {
            // echo json_encode($dt);
            // die();
            $pdf->Cell(1, 3, '', 0, 0, 'L', 1);
            $pdf->Cell(25, 5, '', 0, 0, 'L', 0);
            $pdf->Cell(5, 5, $idt . '. ', 0, 0, 'L', 0);
            $pdf->MultiCell(165, 5, $dt['dasar_tambahan'], 0, 'J');
        }
        $pdf->Cell(25, 5, ' ', 0, 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(195, 5, 'MEMERINTAHKAN :', 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(5, 5, '', 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '1.', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Nama', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['pel_nama'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'NIP', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['pel_nip'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Pangkat/Gol', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['pel_pangkat_gol'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Jabatan', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->MultiCell(145, 5, $data['pel_jabatan'], 0,  'L', 0);
        $i = 2;
        // echo json_encode($data['pengikut'];
        // die();
        foreach ($data['pengikut'] as $pengikut) {
            $pdf->CheckPageBreak(22);

            $pdf->Cell(5, 2, '', 0, 1, 'L', 0);
            $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
            $pdf->Cell(10, 5, $i . '.', 0, 0, 'L', 0);
            $pdf->Cell(30, 5, 'Nama', 0, 0, 'L', 0);
            $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
            $pdf->Cell(160, 5, $pengikut['p_nama'], 0, 1, 'L', 0);
            $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
            $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
            $pdf->Cell(30, 5, 'NIP', 0, 0, 'L', 0);
            $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
            $pdf->Cell(160, 5, $pengikut['p_nip'], 0, 1, 'L', 0);
            $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
            $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
            $pdf->Cell(30, 5, 'Pangkat/Gol', 0, 0, 'L', 0);
            $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
            $pdf->Cell(160, 5, $pengikut['p_pangkat_gol'], 0, 1, 'L', 0);
            $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
            $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
            $pdf->Cell(30, 5, 'Jabatan', 0, 0, 'L', 0);
            $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
            $pdf->MultiCell(145, 5, $pengikut['p_jabatan'],  0, 'L', 0);
            $i++;
        }

        $tujuan_text = '';
        $count_t = count($data['tujuan']);
        $i = 1;
        $d1 = '';
        $d2 = '';
        $cetak_tgl = '';
        if ($data['jenis'] == 3) {
            $t = '';
            foreach ($data['tujuan'] as $tujuan) {
                if ($i == 1) {
                    $cetak_tgl = tanggal_indonesia($tujuan['date_berangkat']);

                    $tujuan_text .= $tujuan['tempat_tujuan'] . ' pada tanggal ' . tanggal_indonesia($tujuan['date_berangkat']);
                } else if ($count_t == $i) {
                    $tujuan_text .= ' dan ' . ($t != $tujuan['tempat_tujuan'] ? 'di ' . $tujuan['tempat_tujuan'] . ' ' : '') . 'tanggal ' . tanggal_indonesia($tujuan['date_berangkat']);
                } else {
                    $tujuan_text .= ', ' . ($t != $tujuan['tempat_tujuan'] ? 'di ' . $tujuan['tempat_tujuan'] . ' ' : '') . 'tanggal ' . tanggal_indonesia($tujuan['date_berangkat']);
                }
                $t = $tujuan['tempat_tujuan'];
                $i++;
            }
        } else {
            foreach ($data['tujuan'] as $tujuan) {
                if ($i == 1) {
                    $cetak_tgl = tanggal_indonesia($tujuan['date_berangkat']);
                    $d1 = $tujuan['date_berangkat'];
                    $tujuan_text .= $tujuan['tempat_tujuan'];
                } else if ($count_t == $i) {
                    $tujuan_text .= ' dan ' . $tujuan['tempat_tujuan'];
                } else {
                    $tujuan_text .= ', ' . $tujuan['tempat_tujuan'];
                }
                if (!empty($tujuan['date_kembali']))
                    $d2 = $tujuan['date_kembali'];
                $i++;
            }
            if ($d1 != $d2) {
                $tujuan_text .= ' pada tanggal ' . tanggal_indonesia($d1) . ' sampai ' . tanggal_indonesia($d2);
            } else {
                $tujuan_text .= ' pada tanggal ' . tanggal_indonesia($d1);
            }
        }

        $pdf->Cell(5, 4, '', 0, 1, 'L', 0);
        if ($data['jenis'] == 3) {
            $pdf->MultiCell(194, 5, 'Untuk melaksanakan lembur ' . $data['maksud'] . ' di ' . $tujuan_text . '.', 0, 'J');
            $pdf->Cell(5, 4, '', 0, 1, 'L', 0);
            $pdf->MultiCell(194, 5, 'Surat tugas ini dibuat untuk dilaksanakan dan setelah selesai, pelaksanaan tugas segera menyampaikan laporan kepada atasan langsungnya.', 0, 'J');
        } else {
            $pdf->MultiCell(194, 5, 'Dalam Rangka ' . $data['maksud'] . ' di ' . $tujuan_text . '.', 0, 'J');
            $pdf->CheckPageBreak(90);
            $pdf->Cell(5, 4, '', 0, 1, 'L', 0);
            $pdf->MultiCell(194, 5, 'Surat tugas ini dibuat untuk dilaksanakan dan setelah selesai, pelaksanaan tugas segera menyampaikan laporan kepada atasan langsungnya. Kepada instansi terkait, kami mohon bantuan demi kelancaran pelaksanaan tugas dimaksud.', 0, 'J');
        }

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(3, 5, "", 0, 1, 'L', 0);
        $cur_x = $pdf->getX();
        $cur_y = $pdf->GetY();
        // $pdf->CheckPageBreak(60);
        if ($data['status'] == '99' && !empty($data['sign_kadin'])) {
            // $pdf->CheckPageBreak(50);

            $pdf->Cell(110, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Ditetapkan di', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            if ($data['pel_level'] == 7) {
                $pdf->Cell(40, 5, 'Sungailiat', 0, 1, 'L', 0);
            } else
                $pdf->Cell(40, 5, $data_satuan['satuan_tempat'], 0, 1, 'L', 0);

            $pdf->Cell(110, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Pada Tanggal', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, tanggal_indonesia($data['tgl_pengajuan']), 0, 1, 'L', 0);
            $pdf->Cell(110, 5, '', 0, 0, 'C', 0);
            if ($data_satuan['jen_satker'] == 1 or ($data_satuan['jen_satker'] != 1  && $data['luardaerah'] == 2)) {
                if (!empty($data['sign_kadin2'])) {
                    $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin2']])[0];
                    if (!empty($sign_kadin['sign_plh'])) {
                        $pdf->Cell(102, 5, '', 0, 0, 'C', 0);
                        $pdf->Cell(8, 5, 'Plt.', 0, 0, 'C', 0);
                        $pdf->MultiCell(50, 5,  "Kepala Dinas Kesehatan\nKabupaten Bangka,\n" . $sign_kadin['sign_title'], 0, 'L', 0);
                    }
                    $pdf->Cell(110, 5, '', 0, 0, 'C', 0);
                    $pdf->MultiCell(45, 5,  "Kepala Dinas Kesehatan\nKabupaten Bangka", 0, 'L', 0);
                } else {
                    $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
                    if (!empty($sign_kadin['sign_plh'])) {
                        $pdf->Cell(102, 5, '', 0, 0, 'C', 0);
                        $pdf->Cell(8, 5, 'Plt.', 0, 0, 'C', 0);
                        $pdf->MultiCell(50, 5,  "Kepala Dinas Kesehatan\nKabupaten Bangka,\n" . $sign_kadin['sign_title'], 0, 'L', 0);
                    } else {
                        $pdf->Cell(110, 5, '', 0, 0, 'C', 0);
                        $pdf->MultiCell(45, 5,  "Kepala Dinas Kesehatan\nKabupaten Bangka", 0, 'L', 0);
                    }
                }
                // else {
                // }
                // $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin2']])[0];
            } else if ($data_satuan['jen_satker'] == 2) {
                $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
                $pdf->MultiCell(80, 5,  "Kepala " . ucwords(strtolower($data_satuan['nama_satuan'])), 0, 'L', 0);
            } else if ($data_satuan['jen_satker'] == 3) {
                $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
                $pdf->MultiCell(80, 5,  "Direktur " . $data_satuan['nama_satuan'], 0, 'L', 0);
            } else if ($data_satuan['jen_satker'] == 4) {
                $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
                $pdf->MultiCell(80, 5,  "Kepala " . $data_satuan['nama_satuan'], 0, 'L', 0);
            }
            $pdf->Cell(110, 25, '', 0, 1, 'C', 0);
            $pdf->Cell(110, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(80, 5,  $sign_kadin['sign_name'], 0, 'L', 0);
            $pdf->Cell(110, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(70, 5,  $sign_kadin['sign_pangkat'], 0, 'L', 0);
            $pdf->Cell(110, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(70, 5,  'NIP. ' . $sign_kadin['sign_nip'], 0, 'L', 0);

            // sementara
            $pdf->Image('./uploads/signature/' . $sign_kadin['sign_signature'], 120, $pdf->getY() - 40, 0, 25);
            if ($qr == 2) {
                if (empty($data['qrcode'])) {
                    $key = md5($data['no_spt'] . time());
                    $this->SPPDModel->addQRCode(['qrcode' => $key, 'id_spt' => $data['id_spt']]);
                    $this->addQRCode($key, 20);
                    $pdf->Image('./uploads/qrcode/20' .  $key . '.png', 40, $pdf->getY() - 40.5, 25);
                } else {
                    $pdf->Image('./uploads/qrcode/20' . $data['qrcode'] . '.png', 40, $pdf->getY() - 40.5, 25);
                }
            }
            if ($cap == 'cap') {
                $pdf->Image('./assets/img/cap-dinkes.png', 120, $pdf->getY() - 48, 0, 40);
            }
            // if ($qr == 1)
            //     $pdf->Image(base_url('uploads/signature/' . $sign_kadin['sign_signature']), 120, $pdf->getY() - 40, 0, 25);
            // else {
            //     if (empty($data['qrcode'])) {
            //         $key = md5($data['no_spt'] . time());
            //         $this->SPPDModel->addQRCode(['qrcode' => $key, 'id_spt' => $data['id_spt']]);
            //         $this->addQRCode($key, 20);
            //         $pdf->Image(base_url('uploads/qrcode/20' .  $key . '.png'), 140, $pdf->getY() - 40.5, 25);
            //     } else {
            //         $pdf->Image(base_url('uploads/qrcode/20' . $data['qrcode'] . '.png'), 140, $pdf->getY() - 40.5, 25);
            //     }
            // }
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
        $filename = 'SPT ' . (!empty($data['no_spt']) ?  $data['no_spt'] : $data['id_spt']) . '.pdf';

        $pdf->Output('', $filename, false);
    }

    private function addQRCode($key, $code)
    {

        $this->load->library('ciqrcode');
        $config['cacheable']    = false; //boolean, the default is true
        $config['cachedir']     = './uploads/qrcode/'; //string, the default is application/cache/
        $config['errorlog']     = './uploads/qrcode/'; //string, the default is application/logs/
        $config['imagedir']     = './uploads/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '50'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = $code . $key . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = base_url() . 'qrcode/' . $code . $key; //data yang akan di jadikan QR CODE
        $params['level'] = 'S'; //H=High
        $params['size'] = 5;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
    }
}
