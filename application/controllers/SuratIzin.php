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
                $filter['jen_izin'] = [1, 3];
            } else {
                $filter['jen_izin'] = [2, 3];
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

    public function riwayat_approval($id)
    {
        try {

            // $this->SecurityModel->useronlyguard()
            $data = $this->SuratIzinModel->RiwayatApproval($id);
            echo json_encode(['error' => false, 'data' => $data]);
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
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function edit($id)
    {
        try {
            $res_data['form_url'] = 'surat_izin/edit_process';
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
    public function delete()
    {
        try {
            $id = $this->input->get('id_surat_izin');
            $data = $this->SuratIzinModel->getAll(array('id_surat_izin' => $id, 'id_pegawai' => $this->session->userdata('id')));


            if (empty($data[$id])) {
                throw new UserException('Data tidak ditemukan!');
            } else {
                $data = $data[$id];
                if ($data['status_izin'] == 99) {
                    throw new UserException('Data sudah di approve tidak dapat dihapus!');
                } else
                    $this->SuratIzinModel->delete($data);
            }
            // $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            // $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);
            // $cur_user = $this->session->userdata();
            // $logs['id_si'] = $id;
            // $logs['id_user'] = $cur_user['id'];
            echo json_encode(array('error' => false, 'data' => $data));
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
                if ($action == 'approv' && $data['id_pengganti'] == $cur_user['id']) {
                    $logs['deskripsi'] =  'Menyetujui pelimpahan wewenang.';
                    $logs['label'] = 'success';
                    $this->SuratIzinModel->addLogs($logs);
                    $sign =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                    $pegawai =  $this->GeneralModel->getAllUser(['id' => $data['id_pegawai']])[$data['id_pegawai']];
                    // if ($data['jen_satker'] == 1) {
                    if ($cur_user['jen_satker'] == 1) {
                        if ($pegawai['level'] == 6 && $pegawai['id_satuan'] == 1) {
                            if (!empty($pegawai['id_seksi'])) {
                                $data['status_izin'] = 1;
                            } else {
                                if ($data['id_bagian'] == 2 && $data['jen_izin'] == 1) {
                                    $data['status_izin'] = 10;
                                } else {
                                    $data['status_izin'] = 2;
                                }
                            }
                        } else if ($pegawai['level'] == 5) {
                            if (!empty($pegawai['id_seksi'])) {
                                $data['status_izin'] = 2;
                            }
                        } else if ($pegawai['level'] == 4 || $pegawai['level'] == 3) {
                            $data['status_izin'] = 10;
                        } else if ($pegawai['level'] == 2) {
                            $data['status_izin'] = 10;
                        } else if ($pegawai['level'] == 1) {
                            $data['status_izin'] = 10;
                        }
                    } else {
                        $data['status_izin'] = 50;
                    }

                    $this->SuratIzinModel->approve_pelimpahan($data, $sign);
                    // $this->SPPDModel->addLogs($logs);
                    echo json_encode(array('error' => false, 'data' => $data));
                    return;
                }
            }

            // if ($cur_user['level'] == 5 && $data['status_izin'] == 1) {
            //     // approve kasi
            // }
            if ($action == 'approv') {
                if ($cur_user['level'] == 5 && $data['status_izin'] == 1 && ($cur_user['id_seksi'] = $data['id_seksi'])) {
                    $logs['deskripsi'] =  'Menyetujui';
                    $logs['label'] = 'success';
                    $data['status_izin'] = 2;
                    $this->SuratIzinModel->approv($data);
                    $this->SuratIzinModel->addLogs($logs);
                } else if (($cur_user['level'] == 3 || $cur_user['level'] == 4) && $data['status_izin'] == 2 && ($cur_user['id_bagian'] = $data['id_bagian'])) {
                    $logs['deskripsi'] =  'Menyetujui';
                    $logs['label'] = 'success';
                    if ($data['id_bagian'] == 2 && in_array($data['jen_izin'], [2, 3])) {
                        $data['status_izin'] = 14;
                    } else {
                        if (in_array($data['jen_izin'], [2, 3])) {
                            $data['status_izin'] = 11;
                        } else {
                            $data['status_izin'] = 10;
                        }
                    }

                    if ($data['level_pegawai'] == 6) {
                        $sign['atasan'] =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                        $this->SuratIzinModel->approv($data, $sign);
                    } else
                        $this->SuratIzinModel->approv($data);
                    $this->SuratIzinModel->addLogs($logs);
                } else if ($cur_user['level'] == 2 && $data['status_izin'] == 14) {
                    $logs['deskripsi'] =  'Menyetujui';
                    $logs['label'] = 'success';
                    // if ($data['jen_izin'] == 1)
                    //     $data['status_izin'] = 10;
                    // else
                    $data['status_izin'] = 15;

                    if ($data['level_pegawai'] != 6) {
                        $sign['atasan'] =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                        $this->SuratIzinModel->approv($data, $sign);
                    } else
                        $this->SuratIzinModel->approv($data);
                    $this->SuratIzinModel->addLogs($logs);
                } else if ($cur_user['level'] == 1 && $data['status_izin'] == 15) {
                    $logs['deskripsi'] =  'Menyetuji Kepala Dinas';
                    $logs['label'] = 'success';
                    $data['status_izin'] = 99;
                    $sign['kadin'] =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                    $data['no_spc'] = $this->SuratIzinModel->cek_nomor($data)['spc'];
                    // echo json_encode($data);
                    // die();
                    $this->SuratIzinModel->approv($data, $sign,);
                    $this->SuratIzinModel->addLogs($logs);
                } else if ($cur_user['level'] == 3 && $cur_user['id_bagian'] == 2 && $data['status_izin'] == 11) {
                    $logs['deskripsi'] =  'Menyetujui Kasubag Kepegawaian';
                    $logs['label'] = 'success';
                    $data['status_izin'] = 14;
                    $this->SuratIzinModel->approv($data);
                    $this->SuratIzinModel->addLogs($logs);
                } else if ($cur_user['level'] == 8 && $cur_user['id_satuan'] == $data['id_satuan'] && $data['status_izin'] == 50) {
                    $logs['deskripsi'] =  'Menyetujui Kasubag Puskesmas';
                    $logs['label'] = 'success';
                    $data['status_izin'] = 51;
                    $this->SuratIzinModel->approv($data);
                    $this->SuratIzinModel->addLogs($logs);
                } else if ($cur_user['level'] == 7 && $cur_user['id_satuan'] == $data['id_satuan'] && $data['status_izin'] == 51) {
                    $logs['deskripsi'] =  'Menyetujui Kepala Puskesmas Puskesmas';
                    $logs['label'] = 'success';
                    if ($data['jen_izin'] == 1) {
                        $data['status_izin'] = 10;
                    } else {
                        $sign['kadin'] =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                        $data['no_spc'] = $this->SuratIzinModel->cek_nomor($data)['spc'];
                        $data['status_izin'] = 99;
                    }
                    $sign['atasan'] =  $this->SuratIzinModel->sign($cur_user, $cur_user['jabatan']);
                    $this->SuratIzinModel->approv($data, $sign);
                    $this->SuratIzinModel->addLogs($logs);
                }
            } else   if ($action == 'unapprov') {
                $logs['deskripsi'] =  'Menolak';
                $logs['label'] = 'danger';
                if ($cur_user['level'] == 5 && $data['status_izin'] == 1 && ($cur_user['id_seksi'] = $data['id_seksi'])) {
                    $this->SuratIzinModel->addLogs($logs);
                    $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                } else if (($cur_user['level'] == 3 || $cur_user['level'] == 4) && $data['status_izin'] == 2 && ($cur_user['id_bagian'] = $data['id_bagian'])) {
                    $this->SuratIzinModel->addLogs($logs);
                    $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                } else if ($cur_user['level'] == 2 && $data['status_izin'] == 14) {
                    $this->SuratIzinModel->addLogs($logs);
                    $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                } else if ($cur_user['level'] == 1 && $data['status_izin'] == 15) {
                    $this->SuratIzinModel->addLogs($logs);
                    $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                } else if ($cur_user['level'] == 3 && $cur_user['id_bagian'] == 2 && $data['status_izin'] == 11) {
                    $this->SuratIzinModel->addLogs($logs);
                    $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                } else if ($cur_user['level'] == 8 && $cur_user['id_satuan'] == $data['id_satuan'] && $data['status_izin'] == 50) {
                    $this->SuratIzinModel->addLogs($logs);
                    $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                } else if ($cur_user['level'] == 7 && $cur_user['id_satuan'] == $data['id_satuan'] && $data['status_izin'] == 51) {
                    $this->SuratIzinModel->addLogs($logs);
                    $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                }
            } else   if ($action == 'undo') {
                $logs['deskripsi'] =  'Membatalkan Aksi';
                $logs['label'] = 'warning';
                $this->SuratIzinModel->undo($data, $cur_user['id']);

                // if ($cur_user['level'] == 5 && $data['status_izin'] == 1 && ($cur_user['id_seksi'] = $data['id_seksi'])) {
                //     $this->SuratIzinModel->addLogs($logs);
                //     $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                // } else if (($cur_user['level'] == 3 || $cur_user['level'] == 4) && $data['status_izin'] == 2 && ($cur_user['id_bagian'] = $data['id_bagian'])) {
                //     $this->SuratIzinModel->addLogs($logs);
                //     $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                // } else if ($cur_user['level'] == 2 && $data['status_izin'] == 14) {
                //     $this->SuratIzinModel->addLogs($logs);
                //     $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                // } else if ($cur_user['level'] == 1 && $data['status_izin'] == 15) {
                //     $this->SuratIzinModel->addLogs($logs);
                //     $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                // } else if ($cur_user['level'] == 3 && $cur_user['id_bagian'] == 2 && $data['status_izin'] == 11) {
                //     $this->SuratIzinModel->addLogs($logs);
                //     $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                // } else if ($cur_user['level'] == 8 && $cur_user['id_satuan'] == $data['id_satuan'] && $data['status_izin'] == 50) {
                //     $this->SuratIzinModel->addLogs($logs);
                //     $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                // } else if ($cur_user['level'] == 7 && $cur_user['id_satuan'] == $data['id_satuan'] && $data['status_izin'] == 51) {
                //     $this->SuratIzinModel->addLogs($logs);
                //     $this->SuratIzinModel->unapprov($data, $cur_user['id']);
                // }
            }
            $data = $this->SuratIzinModel->getAll(array('id_surat_izin' => $id))[$id];
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
            $cur_user = $this->session->userdata();
            $total_c = (int) $data_post['c_sisa_n'] + (int)$data_post['c_sisa_n1'] + (int) $data_post['c_sisa_n2'];
            $logs['id_si'] = $id;
            $logs['id_user'] = $cur_user['id'];
            if ($data['jenis_izin'] == 11)
                if ($total_c < $data['lama_izin']) {
                    throw new UserException('Sisa cuti tidak cukup!!!!', UNAUTHORIZED_CODE);
                } else {
                    if ($data_post['c_sisa_n2'] >= $data['lama_izin']) {
                        $data_post['c_n2'] = $data['lama_izin'];
                        $data_post['c_n1'] = '0';
                        $data_post['c_n'] = '0';
                    } else if (($data_post['c_sisa_n2'] + $data_post['c_sisa_n1']) >= $data['lama_izin']) {
                        $data_post['c_n2'] = $data_post['c_sisa_n2'];
                        $data_post['c_n1'] = $data['lama_izin'] - $data_post['c_sisa_n2'];
                        $data_post['c_n'] = '0';
                    } else {
                        $data_post['c_n2'] = $data_post['c_sisa_n2'];
                        $data_post['c_n1'] = $data_post['c_sisa_n1'];
                        $data_post['c_n'] =  $data['lama_izin'] - $data_post['c_sisa_n2'] - $data_post['c_sisa_n1'];
                    }
                }

            if ($data['verif_cuti'] == $cur_user['id'] && in_array($data['status_izin'], [10, 11])) {
                if ($data_post['verif'] == 1) {
                    $data_post['verif'] = $cur_user['id'];
                    $data_post['unapprove'] = NULL;
                    $data_post['status_izin'] = 11;
                } else {
                    unset($data['verif']);
                    $data_post['verif'] = NULL;
                    $data_post['unapprove'] = $cur_user['id'];
                    $data_post['status_izin'] = 10;
                }

                $this->SuratIzinModel->approv_verif($data_post);
            } else if ($cur_user['level'] == 8 && $cur_user['id_satuan'] == $data['id_satuan'] && ($data['status_izin'] == 50 ||  $data['status_izin'] == 51)) {
                $data_post['verif_sub'] = $data_post['verif'];
                $data_post['cttn_verif_sub'] = $data_post['cttn_verif'];
                unset($data['verif']);
                unset($data['cttn_verif']);
                if ($data_post['verif_sub'] == 1) {
                    $logs['deskripsi'] =  'Menyetujui & Verifikasi Kasubag';
                    $logs['label'] = 'success';
                    $data_post['verif_sub'] = $cur_user['id'];
                    $data_post['unapprove'] = NULL;
                    $data_post['status_izin'] = 51;
                } else {
                    $logs['deskripsi'] =  'Ditolak Kasubag';
                    $logs['label'] = 'success';
                    $data_post['verif_sub'] = NULL;
                    $data_post['unapprove'] = $cur_user['id'];
                    $data_post['status_izin'] = 50;
                }
                $this->SuratIzinModel->approv_verif($data_post);
                $this->SuratIzinModel->addLogs($logs);
            }
            $data = $this->SuratIzinModel->getAll(array('id_surat_izin' => $id))[$id];
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

    public function action_edit()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $instansi = $this->GeneralModel->getAllSatuan(['id_satuan' => 1])[1];

            if ($instansi['verif_cuti'] == $this->session->userdata('id') || $this->session->userdata['id_role'] == 1) {
            } else {
                throw new UserException('Kamu tidak berhak melakukan aksi ini!!', UNAUTHORIZED_CODE);
            }

            $data = $this->input->post();
            if (!empty($_FILES['file_lampiran']['name'])) {
                $s =  FileIO::uploadGd2('file_lampiran', 'lampiran_izin', '');
                if (!empty($s['filename']))
                    $data['lampiran'] = $s['filename'];
                else {
                    throw new UserException('Gagal Upload, terjadi kesalahahn!!', UNAUTHORIZED_CODE);
                }
            } else {
            }
            $id =  $this->SuratIzinModel->edit_adm($data);
            $data = $this->SuratIzinModel->getAll(['id_surat_izin' => $data['id_surat_izin']])[$data['id_surat_izin']];
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function delete_adm()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $instansi = $this->GeneralModel->getAllSatuan(['id_satuan' => 1])[1];

            if ($instansi['verif_cuti'] == $this->session->userdata('id') || $this->session->userdata['id_role'] == 1) {
            } else {
                throw new UserException('Kamu tidak berhak melakukan aksi ini!!', UNAUTHORIZED_CODE);
            }

            $data = $this->input->post();

            $this->SuratIzinModel->delete_adm($data);
            // $data = $this->SuratIzinModel->getAll(['id_surat_izin' => $data['id_surat_izin']])[$data['id_surat_izin']];
            echo json_encode(array('error' => false, 'data' => $data['id_surat_izin']));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function add_process()
    {
        try {
            // $this->SecurityModel->multiRole('SPPD', 'Entri SPPD');
            $data = $this->input->post();
            $ses = $this->session->userdata();
            $data['id_pegawai'] = $ses['id'];
            if ($ses['jenis_pegawai'] == 2 && $data['kategori'] == 1) {
                $sisa =  $this->SuratIzinModel->cekSisaPegawai($ses['id']);
                if ($sisa['x'] >= 6) {
                    throw new UserException('Sisa izin sudah habis!!', UNAUTHORIZED_CODE);
                }
            }
            // echo json_encode($sisa);
            // die();
            // if (empty($data['id_pengganti'])) {
            //     // jika tidak ada pengganti maka
            //     if ($ses['jen_satker'] == 1) {
            //         if (!empty($ses['id_seksi'])) {
            //             $data['id_seksi'] = $ses['id_seksi'];
            //         }
            //         if ($ses['level'] == 6 && $ses['id_satuan'] == 1) {
            //             if (!empty($ses['id_seksi'])) {
            //                 $data['status_izin'] = 1;
            //             } else {
            //                 $data['status_izin'] = 2;
            //             }
            //         } else if ($ses['level'] == 5) {
            //             if (!empty($ses['id_seksi'])) {
            //                 $data['status_izin'] = 2;
            //             }
            //         } else if ($ses['level'] == 4 || $ses['level'] == 3) {
            //             $data['status_izin'] = 5;
            //         } else if ($ses['level'] == 2) {
            //             $data['status_izin'] = 6;
            //         } else if ($ses['level'] == 1) {
            //             $data['status_izin'] = 10;
            //         }
            //     } else {
            //         $data['status_izin'] = 50;
            //     }
            // } else {
            $data['status_izin'] = 0;
            $this->load->model('SPPDModel');
            $this->SPPDModel->CekJadwal($data, $data['periode_start'], $data['periode_end'], '', true);

            // echo json_encode($data);
            // die();
            // if ($data['date_berangkat'][0] < date('Y-m-d')) {
            //     throw new UserException('Tanggal Keberangkatan Terlambat!');
            // }
            if (!empty($ses['id_seksi']))
                $data['id_seksi'] = $ses['id_seksi'];
            if (!empty($ses['id_bagian']))
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

            if ($data['jenis_izin'] == 11) {
                $last_cuti =  $this->SuratIzinModel->CekLastTahunan($ses['id']);
                if (!empty($last_cuti[0])) {
                    // if($last_cuti)
                    $year = explode('-', $last_cuti[0]['periode_start'])[0];
                    $cur_year = explode('-', $data['periode_start'])[0];

                    if ($year == $cur_year) {
                        $data['c_sisa_n'] = $last_cuti[0]['c_sisa_n'] - $last_cuti[0]['c_n'];
                        $data['c_sisa_n1'] = $last_cuti[0]['c_sisa_n1'] - $last_cuti[0]['c_n1'];
                        $data['c_sisa_n2'] = $last_cuti[0]['c_sisa_n2'] - $last_cuti[0]['c_n2'];
                    } else 
                    if ($year + 1 == $cur_year) {
                        $data['c_sisa_n'] = 12;
                        $data['c_sisa_n1'] = $last_cuti[0]['c_sisa_n'] - $last_cuti[0]['c_n'];
                        $data['c_sisa_n2'] = $last_cuti[0]['c_sisa_n1'] - $last_cuti[0]['c_n1'];
                        if ($data['c_sisa_n1'] > 6) {
                            $data['c_sisa_n1'] = 6;
                        }
                        if ($data['c_sisa_n2'] > 6) {
                            $data['c_sisa_n2'] = 6;
                        }
                    } else
                    if ($year + 2 == $cur_year) {
                        $data['c_sisa_n'] = 12;
                        $data['c_sisa_n1'] = 6;
                        $data['c_sisa_n2'] = $last_cuti[0]['c_sisa_n'] - $last_cuti[0]['c_n'];
                        if ($data['c_sisa_n2'] > 6) {
                            $data['c_sisa_n2'] = 6;
                        }
                    } else {
                        $data['c_sisa_n'] = 12;
                        $data['c_sisa_n1'] = 6;
                        $data['c_sisa_n2'] = 6;
                    }

                    $total_c = (int) $data['c_sisa_n'] + (int)$data['c_sisa_n1'] + (int) $data['c_sisa_n2'];

                    if ($total_c < $data['lama_izin']) {
                        throw new UserException('Sisa cuti tidak cukup!!!!', UNAUTHORIZED_CODE);
                    } else {
                        if ($data['c_sisa_n2'] >= $data['lama_izin']) {
                            $data['c_n2'] = $data['lama_izin'];
                            $data['c_n1'] = '0';
                            $data['c_n'] = '0';
                        } else if (($data['c_sisa_n2'] + $data['c_sisa_n1']) >= $data['lama_izin']) {
                            $data['c_n2'] = $data['c_sisa_n2'];
                            $data['c_n1'] = $data['lama_izin'] - $data['c_sisa_n2'];
                            $data['c_n'] = '0';
                        } else {
                            $data['c_n2'] = $data['c_sisa_n2'];
                            $data['c_n1'] = $data['c_sisa_n1'];
                            $data['c_n'] =  $data['lama_izin'] - $data['c_sisa_n2'] - $data['c_sisa_n1'];
                        }
                    }
                }
                // echo json_encode(array('error' => true, 'data' => $data));
            }
            // die();
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
        $data = $this->SuratIzinModel->getAll(['id_surat_izin' => $id, 'detail' => true])[$id];

        if ($tipe == 1)
            $this->print_spw($data);
        if ($tipe == 2)
            $this->print_spc($data);
        if ($tipe == 3)
            $this->print_form($data);
        // if ($tipe == 4)
        //     $this->print_pencairan($data);
    }


    function kop($pdf, $data, $dinkes = false)
    {
        if ($data['jen_satker'] == 1 || $dinkes) {
            // echo json_encode($data);
            $pdf->Image(('./assets/img/kab_bangka.png'), 20, 5, 20, 27);
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
            $pdf->Image(('./assets/img/kab_bangka.png'), 10, 5, 20, 27);
            $pdf->Image(('./assets/img/logo_puskesmas.png'), 180, 5, 27, 27);
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
        } else
        if ($data['jen_satker'] == 3) {
            // echo json_encode($data);
            if ($data['id_satuan'] == 17) {
                $pdf->Image(('./assets/img/kab_bangka.png'), 20, 5, 20, 27);
                $pdf->Image(('./assets/img/logo_eko.png'), 180, 0, 27, 35);
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
                $pdf->Image(('./assets/img/kab_bangka.png'), 20, 5, 20, 27);
                $pdf->Image(('./assets/img/logo_sr2.jpg'), 174, 5, 27, 27);
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
                $pdf->Image(('./assets/img/kab_bangka.png'), 20, 5, 20, 27);
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
        }
    }

    function print_spw($data)
    {
        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('P', 'mm', array(215.9, 355.6));

        $pdf->SetTitle('SPW ' . $data['id_surat_izin']);
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
        // $pdf->Cell(195, 5, 'Nomor : ' . $data['no_surat_izin'], 0, 1, 'C', 0);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(25, 5, ' ', 0, 1, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(25, 5, 'Yang bertanda tangan dibawah ini:', 0,  1, 'L', 0);

        $pdf->Cell(5, 5, '', 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Nama', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['nama_pegawai'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'NIP', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['nip_pegawai'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Pangkat/Gol', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['pangkat_gol_pegawai'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Jabatan', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->MultiCell(145, 5, $data['jabatan_pegawai'], 0,  'L', 0);
        $pdf->Cell(5, 4, '', 0, 1, 'L', 0);
        if ($data['periode_start'] == $data['periode_end']) {
            $tanggal_ct = tanggal_indonesia($data['periode_start']);
        } else {
            $tanggal_ct = tanggal_indonesia($data['periode_start']) . ' sampai dengan ' . tanggal_indonesia($data['periode_end']);
        }
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->MultiCell(177, 5, 'Selama menjalankan ' . $data['nama_izin'] . ' tanggal ' . $tanggal_ct . ' dengan ini memberikan pelimpahan wewenang untuk membantu tugas saya selama saya menjalankan ' . $data['nama_izin'] . ' tersebut kepada :', 0, 'J');

        $pdf->Cell(15, 5, '', 0, 1, 'L', 0);
        $pdf->Cell(15, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Nama', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['nama_pengganti'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'NIP', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['nip_pengganti'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Pangkat/Gol', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['pangkat_gol_pengganti'], 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(30, 5, 'Jabatan', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->MultiCell(145, 5, $data['jabatan_pengganti'], 0,  'L', 0);
        $pdf->Cell(5, 4, '', 0, 1, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->MultiCell(177, 5, 'Demikian surat pelimpahan wewenang ini untuk dapat digunakan dengan penuh tanggung jawab sesuai ketentuan yang berlaku.', 0, 'J');

        $pdf->Cell(3, 5, "", 0, 1, 'L', 0);
        $cur_x = $pdf->getX();
        $cur_y = $pdf->GetY();

        $pdf->CheckPageBreak(65);
        $pdf->Cell(15, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(80, 5, 'Yang diberi Pelimpahan', 0, 0, 'C', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(80, 5, 'Yang memberi Pelimpahan', 0, 0, 'C', 0);
        $pdf->Cell(10, 30, '', 0, 1, 'C', 0);

        if ($data['status_izin'] == '99' && !empty($data['sign_pelimpahan'])) {
            $sign_pelimpahan =  $this->GeneralModel->getSign(['id' => $data['sign_pelimpahan']])[0];
        }
        if ($data['status_izin'] == '99' && !empty($data['sign_atasan'])) {
            $sign_atasan =  $this->GeneralModel->getSign(['id' => $data['sign_atasan']])[0];
        }
        $pdf->Cell(15, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(80, 5, !empty($sign_pelimpahan['sign_name']) ? '( ' . $sign_pelimpahan['sign_name'] . ' )' : '( ' . $data['nama_pengganti'] . ' )', 0, 0, 'C', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(80, 5, '( ' . $data['nama_pegawai'] . ' )', 0, 1, 'C', 0);
        $pdf->Cell(15, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(80, 5, 'NIP. ' . (!empty($sign_pelimpahan['sign_nip']) ? $sign_pelimpahan['sign_nip'] : ' - '), 0, 0, 'C', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(80, 5, 'NIP. ' . (!empty($data['nip_pegawai']) ? $data['nip_pegawai'] : ' - '), 0, 0, 'C', 0);
        $pdf->Cell(10, 15, '', 0, 1, 'C', 0);
        $pdf->Cell(15, 5, '', 0, 0, 'C', 0);

        if (!empty(!empty($sign_pelimpahan['sign_signature'])))
            $pdf->Image(('./uploads/signature/' . $sign_pelimpahan['sign_signature']), 40, $pdf->getY() - 45, 0, 25);
        if (!empty(!empty($data['signature_pegawai'])))
            $pdf->Image(('./uploads/signature/' . $data['signature_pegawai']), 130, $pdf->getY() - 45, 0, 25);

        $pdf->Cell(169, 5, 'Mengetahui,', 0, 1, 'C', 0);
        $pdf->Cell(15, 5, '', 0, 0, 'C', 0);
        if ($sign_atasan) {
            $pdf->Cell(169, 5, $sign_atasan['sign_title'], 0, 1, 'C', 0);
            $pdf->Cell(10, 30, '', 0, 1, 'C', 0);
            $pdf->Cell(15, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(169, 5, $sign_atasan['sign_name'], 0, 1, 'C', 0);
            $pdf->Cell(15, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(169, 5, 'NIP. ' . $sign_atasan['sign_nip'], 0, 1, 'C', 0);
            if (!empty(!empty($sign_atasan['sign_signature'])))
                $pdf->Image(('./uploads/signature/' . $sign_atasan['sign_signature']), 85, $pdf->getY() - 39, 0, 31);
        }
        $filename = 'SPW ' . $data['id_surat_izin'];

        $pdf->Output('', $filename, false);
    }

    function print_spc($data)
    {
        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('P', 'mm', array(215.9, 355.6));

        $pdf->SetTitle('SPC ' . $data['id_surat_izin']);
        $pdf->SetMargins(10, 5, 15, 10, 'C');
        $pdf->AddPage();
        if ($data['jen_izin'] == 1)
            $data_satuan =  $this->GeneralModel->getSatuan(['id_satuan' => 1])[0];
        else
            $data_satuan =  $this->GeneralModel->getSatuan(['id_satuan' => $data['id_satuan']])[0];

        $this->kop($pdf, $data_satuan);

        $pdf->SetFont('Arial', '', 9.5);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(190, 7, ' ', 0, 1, 'L', 0);
        $pdf->SetLineWidth(0.4);
        $pdf->Line(70, $pdf->GetY() + 4.5, 144, $pdf->GetY() + 4.5);
        $pdf->SetLineWidth(0.2);
        $pdf->Cell(195, 5, 'SURAT PEMBERIAN ' . strtoupper($data['nama_izin']), 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(195, 5, 'Nomor : ' . $data['no_spc'], 0, 1, 'C', 0);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(25, 5, ' ', 0, 1, 'L', 0);
        $pdf->Cell(5, 5, ' ', 0, 0, 'L', 0);
        $pdf->Cell(5, 5, '1.', 0, 0, 'L', 0);
        $pdf->Cell(25, 5, 'Diberikan ' . $data['nama_izin'] . ' untuk tahun ' . explode('-', $data['periode_start'])[0] . ' Pegawai Negeri Sipil :', 0,  1, 'L', 0);

        $pdf->Cell(5, 5, '', 0, 1, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(35, 5, 'Nama', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['nama_pegawai'], 0, 1, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(35, 5, 'NIP', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['nip_pegawai'], 0, 1, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(35, 5, 'Pangkat/Gol', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $data['pangkat_gol_pegawai'], 0, 1, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(35, 5, 'Jabatan', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->MultiCell(145, 5, $data['jabatan_pegawai'], 0,  'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(35, 5, 'Satuan Organisasi', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        if ($data_satuan['jen_satker'] == 1) {
            $pdf->MultiCell(145, 5, $data_satuan['nama_satuan'], 0,  'L', 0);
        } else {
            $pdf->MultiCell(145, 5, $data_satuan['nama_satuan'] . ' Dinas Kesehatan Kabupaten Bangka', 0,  'L', 0);
        }

        $pdf->Cell(5, 4, '', 0, 1, 'L', 0);

        if ($data['periode_start'] == $data['periode_end']) {
            $tanggal_ct = 'pada tanggal ' . tanggal_indonesia($data['periode_start']);
        } else {
            $tanggal_ct = 'mulai tanggal ' . tanggal_indonesia($data['periode_start']) . ' sampai dengan ' . tanggal_indonesia($data['periode_end']);
        }

        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->MultiCell(177, 5, 'Selama ' . $data['lama_izin'] . ' hari kerja ' . $tanggal_ct . ' dengan ketentuan sebagai berikut : ', 0, 'J');

        $pdf->Cell(15, 5, '', 0, 1, 'L', 0);
        $pdf->Cell(15, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(5, 5, 'a. ', 0, 0, 'L', 0);
        $pdf->MultiCell(169, 5, 'Sebelum menjalankan ' . $data['nama_izin'] . ', wajib menyerahkan pekerjaannya kepada atasan langsung.', 0, 'J');
        $pdf->Cell(15, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(5, 5, 'b. ', 0, 0, 'L', 0);
        $pdf->MultiCell(169, 5, 'Setelah menjalankan ' . $data['nama_izin'] . ' wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.', 0, 'J');

        $pdf->Cell(15, 5, '', 0, 1, 'L', 0);
        $pdf->Cell(5, 5, '', 0, 0, 'L', 0);
        $pdf->Cell(5, 5, '2.', 0, 0, 'L', 0);
        $pdf->MultiCell(169, 5, 'Demikian surat pemberian ' . $data['nama_izin'] . ' ini dibuat untuk dapat dipergunakan sebagaimana mestinya.', 0, 'J');

        $pdf->Cell(3, 5, "", 0, 1, 'L', 0);
        $cur_x = $pdf->getX();
        $cur_y = $pdf->GetY();

        $pdf->CheckPageBreak(65);
        if ($data['status_izin'] == '99' && !empty($data['sign_kadin'])) {
            $sign_atasan =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
        }
        $pdf->Cell(15, 10, '', 0, 1, 'C', 0);

        $pdf->Cell(15, 5, '', 0, 0, 'C', 0);
        if ($data['status_izin'] == '99' && !empty($data['sign_kadin'])) {
            $pdf->Cell(105, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Ditetapkan di', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, $data_satuan['satuan_tempat'], 0, 1, 'L', 0);

            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Pada Tanggal', 0, 0, 'L', 0);
            $pdf->Cell(4, 5, ':', 0, 0, 'C', 0);
            $pdf->Cell(40, 5, tanggal_indonesia(date('Y-m-d')), 0, 1, 'L', 0);
            $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(60, 5, $sign_kadin['sign_title'], 0, 'L', 0);

            $pdf->Cell(120, 25, '', 0, 1, 'C', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->SetFont('Arial', 'B', 9.5);
            $pdf->MultiCell(70, 5,  $sign_kadin['sign_name'], 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(70, 5,  $sign_kadin['sign_pangkat'], 0, 'L', 0);
            $pdf->Cell(120, 5, '', 0, 0, 'C', 0);
            $pdf->MultiCell(70, 5,  'NIP. ' . $sign_kadin['sign_nip'], 0, 'L', 0);
            $pdf->Image(('./uploads/signature/' . $sign_kadin['sign_signature']), 140, $pdf->getY() - 40, 0, 30);
        }
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(10, 15, '', 0, 1, 'L', 0);
        $pdf->Cell(10, 5, '', 0, 0, 'L', 0);
        $pdf->MultiCell(120, 5,  "Tembusan Yth : \n1. Inspektur Inspektorat Kabupaten Bangka\n2. Kepala BKPSDMD Kabupaten Bangka\n3. Kepala BPPKAD Kabupaten Bangka", 0, 'L', 0);
        $filename = 'SPC ' . $data['id_surat_izin'];

        $pdf->Output('', $filename, false);
    }

    public function print_form($data)
    {
        // try {
        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('P', 'mm', array(215.9, 355.6));

        $pdf->SetTitle('SPC ' . $data['id_surat_izin']);
        $pdf->SetMargins(10, 5, 15, 10, 'C');
        // $pdf->AddPage();
        $data_satuan =  $this->GeneralModel->getSatuan(['id_satuan' => $data['id_satuan']])[0];

        // $this->kop($pdf, $data_satuan);

        $pdf->SetFont('Arial', '', 9.5);

        $pdf->SetTitle('Permohonan Cuti ' . $data['nama_pegawai'] . ' ' . $data['nip_pegawai'] . ' ' . $data['periode_start'] . ' s.d. ' . $data['periode_end']);
        $pdf->SetMargins(15, 3, 15, 10, 'C');
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(190, 6, 'FORMULIR PERMINTAAN DAN PEMBERIAN CUTI', 0, 1, 'C');
        // $pdf->Cell(190, 3, 'Nomor:       /     /               /2022', 0, 1, 'C');
        $pdf->Cell(190, 2, '', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 9.5);

        $pdf->Cell(190, 5, 'Tanggal : ' . tanggal_indonesia($data['tanggal_pengajuan']), 0, 1, 'R');
        $pdf->SetFont('Arial', 'B');
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(190, 5, ' I. DATA PEGAWAI', 1, 1, 'L', 0);
        $row_1 = 30;
        $row_2 = 20;
        $row_3 = 20;
        $row_4 = 35;
        $row_a1 = 70;
        $row_a2 =  46;
        $row_a3 = 35;
        $row_a4 =  42;
        $pdf->SetFont('Arial', '', 9.5);

        $pdf->row_cuti_head('Nama', $data['nama_pegawai'], 'NIP', format_nip($data['nip_pegawai']));
        $datetime1 = date_create($data['tmt_kerja']);
        $datetime2 = date_create($data['tanggal_pengajuan']);

        // Calculates the difference between DateTime objects
        $interval = date_diff($datetime1, $datetime2);
        $pdf->row_cuti_head('Jabatan', $data['jabatan_pegawai'], 'Masa Kerja', $interval->format('%y Tahun %m Bulan'));
        $pdf->row_cuti_head('Unit Kerja', $data_satuan['jen_satker'] == 1 ? 'Dinas Kesehatan Kabupaten Bangka' : ucwords(strtolower($data_satuan['nama_satuan'])) . ' - Dinas Kesehatan Kabupaten Bangka');
        $pdf->Cell(50, 5, '', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 9.5);
        $pdf->Cell(190, 5, ' II. JENIS CUTI YANG DIAMBIL', 1, 1, 'L', 0);
        $pdf->SetFont('Arial', '', 9.5);
        $pdf->Cell(80, 5, ' 1. Cuti Tahunan', 1, 0, 'L');
        $p1x = $pdf->getX();
        $p1y = $pdf->getY();
        $pdf->Cell(15, 5, '', 1, 0, 'L');
        $pdf->Cell(80, 5, ' 2. Cuti Besar', 1, 0, 'L');
        $p2x = $pdf->getX();
        $p2y = $pdf->getY();
        $pdf->Cell(15, 5, '', 1, 1, 'L');

        $pdf->Cell(80, 5, ' 3. Cuti Sakit ', 1, 0, 'L');
        $p3x = $pdf->getX();
        $p3y = $pdf->getY();
        $pdf->Cell(15, 5, '', 1, 0, 'L');
        $pdf->Cell(80, 5, ' 4. Cuti Melahirkan', 1, 0, 'L');
        $p4x = $pdf->getX();
        $p4y = $pdf->getY();
        $pdf->Cell(15, 5, '', 1, 1, 'L');
        $pdf->Cell(80, 5, ' 5. Cuti Karena Alasan Penting', 1, 0, 'L');
        $p5x = $pdf->getX();
        $p5y = $pdf->getY();
        $pdf->Cell(15, 5, '', 1, 0, 'L');
        $pdf->Cell(80, 5, '  ', 1, 0, 'L');
        $p6x = $pdf->getX();
        $p6y = $pdf->getY();
        $pdf->Cell(15, 5, '', 1, 1, 'L');

        $centang = ('./assets/img/centang.png');
        // $data['jenis_izin'] = 15;
        if ($data['jenis_izin'] == 11)
            $pdf->Image($centang, $p1x + 5, $p1y + 0, 4);
        else if ($data['jenis_izin'] == 15)
            $pdf->Image($centang, $p2x + 5, $p2y + 0, 4);
        else if ($data['jenis_izin'] == 12)
            $pdf->Image($centang, $p3x + 5, $p3y + 0, 4);
        else if ($data['jenis_izin'] == 13)
            $pdf->Image($centang, $p4x + 5, $p4y + 0, 4);
        else if ($data['jenis_izin'] == 14)
            $pdf->Image($centang, $p5x + 5, $p5y + 0, 4);
        // else if ($data['jenis_izin'] == 15)
        //     $pdf->Image($centang, $p6x + 5, $p6y + 0, 4);

        // $pdf->SetXY($c1x, $c1y);
        $pdf->Cell(15, 5, '', 0, 1, 'L');

        // $pdf->Cell(1, 5, '', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(190, 7, ' III. ALASAN CUTI', 1, 1, 'L', 0);
        $pdf->SetFont('Arial', '');
        $pdf->MultiCell(190, 7, $data['alasan'], 1, 'C', 0);
        $pdf->Cell(15, 5, '', 0, 1, 'L');
        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(190, 7, ' IV. LAMANYA CUTI', 1, 1, 'L', 0);
        $pdf->SetFont('Arial', '');
        $pdf->Cell(28, 7, 'Selama', 1, 0, 'L');
        $pdf->Cell(40, 7, $data['lama_izin'] . '  hari', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Mulai Tanggal', 1, 0, 'L');
        $pdf->Cell(40, 7, tanggal_indonesia($data['periode_start']), 1, 0, 'C');
        $pdf->Cell(12, 7, 's/d', 1, 0, 'C');
        $pdf->Cell(40, 7, tanggal_indonesia($data['periode_end']), 1, 1, 'C');
        $pdf->Cell(15, 5, '', 0, 1, 'L');

        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(190, 7, ' V. CATATAN CUTI ***', 1, 1, 'L', 0);
        $pdf->SetFont('Arial', '');

        $pdf->Cell(7, 7, '1.', 1, 0, 'C');
        $pdf->Cell(88, 7, 'Cuti Tahunan', 1, 0, 'L');
        $pdf->Cell(7, 7, '2.', 1, 0, 'C');
        $pdf->Cell(51, 7, 'Cuti Besar', 1, 0, 'L');
        $pdf->Cell(37, 7, '', 1, 1, 'L');

        $pdf->Cell(7, 7, '', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Tahun', 1, 0, 'C');
        $pdf->Cell(15, 7, 'Sisa', 1, 0, 'C');
        $pdf->Cell(53, 7, 'Keterangan', 1, 0, 'C');
        $pdf->Cell(7, 7, '3.', 1, 0, 'C');
        $pdf->Cell(51, 7, 'Cuti Sakit', 1, 0, 'L');
        $pdf->Cell(37, 7, '', 1, 1, 'L');
        $this_year = date('Y');

        $pdf->Cell(7, 7, '', 1, 0, 'C');
        $pdf->Cell(20, 7, explode('-', $data['periode_start'])[0], 1, 0, 'C');
        $pdf->Cell(15, 7, $data['c_sisa_n'], 1, 0, 'C');
        $pdf->Cell(53, 7, $data['c_n'], 1, 0, 'C');
        $pdf->Cell(7, 7, '4.', 1, 0, 'C');
        $pdf->Cell(51, 7, 'Cuti Melahirkan', 1, 0, 'L');
        $pdf->Cell(37, 7, '', 1, 1, 'L');
        $pdf->Cell(7, 7, '', 1, 0, 'C');
        $pdf->Cell(20, 7, explode('-', $data['periode_start'])[0] - 1, 1, 0, 'C');
        $pdf->Cell(15, 7, $data['c_sisa_n1'], 1, 0, 'C');
        $pdf->Cell(53, 7, $data['c_n1'], 1, 0, 'C');
        $pdf->Cell(7, 7, '5.', 1, 0, 'C');
        $pdf->Cell(51, 7, 'Cuti Karena Alasan Penting', 1, 0, 'L');
        $pdf->Cell(37, 7, '', 1, 1, 'L');

        $pdf->Cell(7, 7, '', 1, 0, 'C');
        $pdf->Cell(20, 7, explode('-', $data['periode_start'])[0] - 2, 1, 0, 'C');
        $pdf->Cell(15, 7, $data['c_sisa_n2'], 1, 0, 'C');
        $pdf->Cell(53, 7, $data['c_n2'], 1, 0, 'C');
        $pdf->Cell(7, 7, '6.', 1, 0, 'C');
        $pdf->Cell(51, 7, 'Cuti di Luar Tanggungan Negara', 1, 0, 'L');
        $pdf->Cell(37, 7, '', 1, 1, 'L');

        $pdf->Cell(15, 5, '', 0, 1, 'L');
        // $pdf->Cell(15, 5, '', 0, 1, 'L');
        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(190, 7, ' V. ALAMAT SELAMA MENJALANKAN CUTI', 1, 1, 'L', 0);
        $pdf->SetFont('Arial', '');
        $c1x = $pdf->getX();
        $c1y = $pdf->getY();

        $pdf->CELL(120, 44, '', 1, 0, 'L');
        $pdf->CELL(20, 7, 'Telpon', 1, 0, 'C');
        $pdf->CELL(50, 7, $data['no_hp'], 1, 1, 'C');
        $pdf->SetXY($c1x + 120, $c1y + 7);
        $pdf->Cell(70, 37, "", 1, 1);
        $pdf->SetXY($c1x, $c1y + 7);
        $pdf->Cell(120, 7);
        $pdf->Cell(70, 7, 'Hormat saya,', 0, 1, 'C');



        $pdf->Cell(120, 20, '', 0, 1);
        $pdf->Cell(120, 5);
        $pdf->Cell(70, 5, $data['nama_pegawai'], 0, 1, 'C');

        $pdf->Cell(120, 5);
        $pdf->Cell(70, 5, format_nip($data['nip_pegawai']), 0, 1, 'C');
        if (!empty($data['signature_pegawai']))
            $pdf->Image(('./uploads/signature/' . $data['signature_pegawai']), 149, $pdf->getY() - 30, 40);
        $c2x = $pdf->getX();
        $c2y = $pdf->getY();
        $pdf->SetXY($c1x + 6, $c1y + 6);
        $pdf->MultiCell(110, 7, $data['alamat_izin'], 0, 'L', 0);
        $pdf->SetXY($c2x, $c2y);

        $pdf->Cell(15, 5, '', 0, 1, 'L');
        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(190, 7, ' VI. PERTIMBANGAN ATASAN LANGSUNG **', 1, 1, 'L', 0);
        $pdf->SetFont('Arial', '');
        $c1x = $pdf->getX();
        $c1y = $pdf->getY();

        if ($data['status_izin'] == '99' && !empty($data['sign_atasan'])) {
            $sign_atasan =  $this->GeneralModel->getSign(['id' => $data['sign_atasan']])[0];
        }

        $pdf->CELL(120, 44, '', 1, 0, 'L');
        $pdf->SetXY($c1x + 120, $c1y);
        $pdf->Cell(70, 44, "", 1, 1);
        $pdf->SetXY($c1x, $c1y);
        $pdf->Cell(120, 6);
        if ($data['id_satuan'] == 1) {
            $pdf->MultiCell(70, 5, $sign_atasan['sign_title'], 0, 'C');
            $pdf->Cell(120, 2);
            $pdf->Cell(70, 2, 'Dinas Kesehatan Kabupaten Bangka', 0, 1, 'C');
        } else {
            $pdf->MultiCell(70, 5, $sign_atasan['sign_title'], 0, 'C');
        }
        $pdf->SetXY($c1x, $c1y + 9);
        $pdf->Cell(120, 27, '', 0, 1);
        $pdf->Cell(120, 5);
        $pdf->Cell(70, 5,  $sign_atasan['sign_name'], 0, 1, 'C');
        $pdf->Cell(120, 2);
        $pdf->Cell(70, 2, 'NIP. ' .  format_nip($sign_atasan['sign_nip']), 0, 1, 'C');
        $pdf->Image(('./uploads/signature/' . $sign_atasan['sign_signature']), 149, $pdf->getY() - 35, 40);


        $pdf->SetXY($c1x, $c1y);
        $pdf->Cell(25, 11, "", 1, 0, 'L');
        $pdf->Cell(29, 11, "", 1, 0, 'L');
        $pdf->Cell(34, 11, "", 1, 0, 'L');
        $pdf->Cell(32, 11, "", 1, 1, 'L');
        $pdf->Cell(30, 7, "Catatan : ", 0, 1, 'L');
        $pdf->SetXY($c1x, $c1y + 2);

        $pdf->Cell(2, 7, "", 0, 0, 'L');
        $pdf->Cell(7, 7, "", 1, 0, 'L');
        $pdf->Cell(16, 7, "Disetujui", 0, 0, 'L');
        $pdf->Cell(2, 7, "", 0, 0, 'L');
        $pdf->Cell(7, 7, "", 1, 0, 'L');
        $pdf->Cell(19, 7, "Perubahan", 0, 0, 'L');
        $pdf->Cell(3, 7, "", 0, 0, 'L');
        $pdf->Cell(7, 7, "", 1, 0, 'L');
        $pdf->Cell(24, 7, "Ditangguhkan", 0, 0, 'L');
        $pdf->Cell(3, 7, "", 0, 0, 'L');
        $pdf->Cell(7, 7, "", 1, 0, 'L');
        $pdf->Cell(20, 7, "Tidak disetujui", 0, 0, 'L');
        $pdf->SetXY($c1x + 6, $c1y + 20);
        $pdf->MultiCell(114, 6, '', 0, 'L', 0);

        // if ($data['level'] != 3)
        if ($data['status_izin'] == '99')
            $pdf->Image($centang, $c1x + 3, $c1y + 3, 5);


        $pdf->SetXY($c1x + 190, $c1y + 43);

        $pdf->Cell(15, 5, '', 0, 1, 'L');
        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(190, 7, ' VII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **', 1, 1, 'L', 0);
        $pdf->SetFont('Arial', '');
        $c1x = $pdf->getX();
        $c1y = $pdf->getY();

        $pdf->CELL(120, 44, '', 1, 0, 'L');
        $pdf->SetXY($c1x + 120, $c1y);
        $pdf->Cell(70, 44, "", 1, 1);
        $pdf->SetXY($c1x, $c1y);
        $pdf->Cell(120, 6);
        if ($data['status_izin'] == '99')
            $pdf->Image($centang, $c1x + 3, $c1y + 3, 5);
        if ($data['status_izin'] == '99' && !empty($data['sign_kadin'])) {
            $sign_kadin =  $this->GeneralModel->getSign(['id' => $data['sign_kadin']])[0];
            $pdf->Cell(70, 6, "Kepala Dinas Kesehatan", 0, 1, 'C');
            $pdf->Cell(120, 2);
            $pdf->Cell(70, 2, 'Kabupaten Bangka', 0, 1, 'C');
            $pdf->Cell(120, 23, '', 0, 1);
            $pdf->Cell(120, 5);
            $pdf->Cell(70, 5, $sign_kadin['sign_name'], 0, 1, 'C');
            $pdf->Cell(120, 3);
            $pdf->Cell(70, 3, $sign_kadin['sign_pangkat'], 0, 1, 'C');
            $pdf->Cell(120, 5);
            $pdf->Cell(70, 5, "NIP. " . format_nip($sign_kadin['sign_nip']), 0, 1, 'C');
            $pdf->Image(('./uploads/signature/' . $sign_kadin['sign_signature']), 149, $pdf->getY() - 40, 40);
        }
        $pdf->SetXY($c1x, $c1y);

        $pdf->Cell(25, 11, "", 1, 0, 'L');
        $pdf->Cell(29, 11, "", 1, 0, 'L');
        $pdf->Cell(34, 11, "", 1, 0, 'L');
        $pdf->Cell(32, 11, "", 1, 1, 'L');
        $pdf->Cell(30, 7, "Catatan : ", 0, 1, 'L');
        $pdf->SetXY($c1x, $c1y + 2);

        $pdf->Cell(2, 7, "", 0, 0, 'L');
        $pdf->Cell(7, 7, "", 1, 0, 'L');
        $pdf->Cell(16, 7, "Disetujui", 0, 0, 'L');
        $pdf->Cell(2, 7, "", 0, 0, 'L');
        $pdf->Cell(7, 7, "", 1, 0, 'L');
        $pdf->Cell(19, 7, "Perubahan", 0, 0, 'L');
        $pdf->Cell(3, 7, "", 0, 0, 'L');
        $pdf->Cell(7, 7, "", 1, 0, 'L');
        $pdf->Cell(24, 7, "Ditangguhkan", 0, 0, 'L');
        $pdf->Cell(3, 7, "", 0, 0, 'L');
        $pdf->Cell(7, 7, "", 1, 0, 'L');
        $pdf->Cell(20, 7, "Tidak disetujui", 0, 0, 'L');
        $pdf->SetXY($c1x + 6, $c1y + 20);
        // $pdf->MultiCell(114, 6, '________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________', 0, 'L', 0);
        // $pdf->SetFont('Arial', '', 8);
        // $pdf->MultiCell(170, 3, '
        // Catatan :
        // * Coret yang tidak perlu
        // ** Pilih salah satu dengan memberi tanda centang ( )
        // *** diisi oleh pejabat yang menangani bidang kepegawaian sebelum PNS mengajukan cuti
        // **** diberi tanda centang dan alasannya
        // N = Cuti tahun berjalan
        // N-1 = Sisa cuti 1 tahun sebelumnya
        // N-2 = Sisa cuti 2 tahun sebelumnya', 0, 'L', 0);


        $filename = 'Form Permohonan Cuti ' . $data['id_surat_izin'];

        $pdf->Output('', $filename, false);
        // } catch (Exception $e) {
        //     ExceptionHandler::handle($e);
        // }
    }
}
