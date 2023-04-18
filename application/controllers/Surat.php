<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Surat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'SuratModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = FALSE;
    }

    public function getAll()
    {
        try {
            $filter = $this->input->get();

            $data =  $this->SuratModel->getAll($filter);
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function disposisi()
    {
        try {
            $data = array(
                'page' => 'surat/disposisi',
                'title' => 'Disposisi Surat',
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function masuk()
    {
        try {
            $data = array(
                'page' => 'surat/masuk',
                'title' => 'Surat Masuk',
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function add_surat_masuk()
    {
        try {
            $res_data['form_url'] = 'Surat/add_surat_masuk_process';
            $data = array(
                'page' => 'surat/surat_masuk_form',
                'title' => 'Surat Masuk',
                'dataContent' => $res_data

            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    // public function ajukan_approv()
    // {
    //     try {
    //         $res_data['form_url'] = 'skp/edit_process';
    //         $filter['my_skp'] = true;
    //         $filter['id_skp'] = $this->input->get('id');
    //         $res_data = $this->SKPModel->getAll($filter)[$filter['id_skp']];
    //         if (!empty($res_data));
    //         if ($res_data['status'] == 0 && $res_data['id_user'] == $this->session->userdata('id')) {
    //             // echo 'ajikan ';
    //             $this->SKPModel->ajukan_approv($res_data['id_skp']);
    //             $res_data['status'] = 1;
    //             echo json_encode(array('error' => false, 'data' => $res_data));
    //         } else
    //             echo json_encode(array('error' => true, 'message' => 'Terjadi Kesalahan!!'));
    //     } catch (Exception $e) {
    //         ExceptionHandler::handle($e);
    //     }
    // }


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
            $data = $this->SuratModel->getAll(array('id_surat_izin' => $id, 'id_pegawai' => $this->session->userdata('id')));


            if (empty($data[$id])) {
                throw new UserException('Data tidak ditemukan!');
            } else {
                $data = $data[$id];
                if ($data['status_izin'] == 99) {
                    throw new UserException('Data sudah di approve tidak dapat dihapus!');
                } else
                    $this->SuratModel->delete($data);
            }
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function action($action, $id)
    {
        try {
            $data = $this->SuratModel->getAll(array('id_surat_izin' => $id))[$id];
            // $res_data['return_data']['pengikut'] = $this->SPPDModel->getPengikut($id);
            // $res_data['return_data']['dasar_tambahan'] = $this->SPPDModel->getDasar($id);
            $cur_user = $this->session->userdata();
            $logs['id_si'] = $id;
            $logs['id_user'] = $cur_user['id'];

            if ($data['status_izin'] == 0) {
                if ($action == 'approv' && $data['id_pengganti'] == $cur_user['id']) {
                    $logs['deskripsi'] =  'Menyetujui pelimpahan wewenang.';
                    $logs['label'] = 'success';
                    $this->SuratModel->addLogs($logs);
                    $sign =  $this->SuratModel->sign($cur_user, $cur_user['jabatan']);
                    $pegawai =  $this->GeneralModel->getAllUser(['id' => $data['id_pegawai']])[$data['id_pegawai']];
                    // if ($data['jen_satker'] == 1) {
                    if ($cur_user['jen_satker'] == 1) {
                        if ($pegawai['level'] == 6 && $pegawai['id_satuan'] == 1) {
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
                            $data['status_izin'] = 10;
                        } else if ($pegawai['level'] == 2) {
                            $data['status_izin'] = 10;
                        } else if ($pegawai['level'] == 1) {
                            $data['status_izin'] = 10;
                        }
                    } else {
                        $data['status_izin'] = 50;
                    }

                    $this->SuratModel->approve_pelimpahan($data, $sign);
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
                    $this->SuratModel->approv($data);
                    $this->SuratModel->addLogs($logs);
                } else if (($cur_user['level'] == 3 || $cur_user['level'] == 4) && $data['status_izin'] == 2 && ($cur_user['id_bagian'] = $data['id_bagian'])) {
                    $logs['deskripsi'] =  'Menyetujui';
                    $logs['label'] = 'success';
                    $data['status_izin'] = 10;
                    if ($data['level_pegawai'] == 6) {
                        $sign['atasan'] =  $this->SuratModel->sign($cur_user, $cur_user['jabatan']);
                        $this->SuratModel->approv($data, $sign);
                    } else
                        $this->SuratModel->approv($data);
                    $this->SuratModel->addLogs($logs);
                } else if ($cur_user['level'] == 2 && $data['status_izin'] == 14) {
                    $logs['deskripsi'] =  'Menyetujui';
                    $logs['label'] = 'success';
                    // if ($data['jen_izin'] == 1)
                    //     $data['status_izin'] = 10;
                    // else
                    $data['status_izin'] = 15;

                    if ($data['level_pegawai'] != 6) {
                        $sign['atasan'] =  $this->SuratModel->sign($cur_user, $cur_user['jabatan']);
                        $this->SuratModel->approv($data, $sign);
                    } else
                        $this->SuratModel->approv($data);
                    $this->SuratModel->addLogs($logs);
                } else if ($cur_user['level'] == 1 && $data['status_izin'] == 15) {
                    $logs['deskripsi'] =  'Menyetuji Kepala Dinas';
                    $logs['label'] = 'success';
                    $data['status_izin'] = 99;
                    $sign['kadin'] =  $this->SuratModel->sign($cur_user, $cur_user['jabatan']);
                    $data['no_spc'] = $this->SuratModel->cek_nomor($data)['spc'];
                    // echo json_encode($data);
                    // die();
                    $this->SuratModel->approv($data, $sign,);
                    $this->SuratModel->addLogs($logs);
                } else if ($cur_user['level'] == 3 && $cur_user['id_bagian'] == 2 && $data['status_izin'] == 11) {
                    $logs['deskripsi'] =  'Menyetujui Kasubag Kepegawaian';
                    $logs['label'] = 'success';
                    $data['status_izin'] = 14;
                    $this->SuratModel->approv($data);
                    $this->SuratModel->addLogs($logs);
                } else if ($cur_user['level'] == 8 && $cur_user['id_satuan'] == $data['id_satuan'] && $data['status_izin'] == 50) {
                    $logs['deskripsi'] =  'Menyetujui Kasubag Puskesmas';
                    $logs['label'] = 'success';
                    $data['status_izin'] = 51;
                    $this->SuratModel->approv($data);
                    $this->SuratModel->addLogs($logs);
                } else if ($cur_user['level'] == 7 && $cur_user['id_satuan'] == $data['id_satuan'] && $data['status_izin'] == 51) {
                    $logs['deskripsi'] =  'Menyetujui Kepala Puskesmas Puskesmas';
                    $logs['label'] = 'success';
                    if ($data['jen_izin'] == 1) {
                        $data['status_izin'] = 10;
                    } else {
                        $sign['kadin'] =  $this->SuratModel->sign($cur_user, $cur_user['jabatan']);
                        $data['no_spc'] = $this->SuratModel->cek_nomor($data)['spc'];
                        $data['status_izin'] = 99;
                    }
                    $sign['atasan'] =  $this->SuratModel->sign($cur_user, $cur_user['jabatan']);
                    $this->SuratModel->approv($data, $sign);
                    $this->SuratModel->addLogs($logs);
                }
            }

            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function action_disposisi()
    {
        try {
            $data_post = $this->input->post();
            $id = $data_post['id_surat_masuk'];
            $data = $this->SuratModel->getAll(array('id_surat_masuk' => $id))[$id];
            $cur_user = $this->session->userdata();
            // echo json
            if ($cur_user['level'] == 1) {
                $data_post['id_pegawai_before'] = $cur_user['id'];
                $this->SuratModel->action_disposisi($data_post);
            }

            $data = $this->SuratModel->getAll(array('id_surat_izin' => $id))[$id];
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
            $id =  $this->SuratModel->edit_adm($data);
            $data = $this->SuratModel->getAll(['id_surat_izin' => $data['id_surat_izin']])[$data['id_surat_izin']];
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

            $this->SuratModel->delete_adm($data);
            // $data = $this->SuratModel->getAll(['id_surat_izin' => $data['id_surat_izin']])[$data['id_surat_izin']];
            echo json_encode(array('error' => false, 'data' => $data['id_surat_izin']));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function add_surat_masuk_process()
    {
        try {
            $data = $this->input->post();
            $ses = $this->session->userdata();
            $data['user_input'] = $ses['id'];
            if (!empty($ses['id_seksi']))
                $data['id_seksi'] = $ses['id_seksi'];
            if (!empty($ses['id_bagian']))
                $data['id_bagian'] = $ses['id_bagian'];
            $data['id_satuan'] = $ses['id_satuan'];
            if (!empty($_FILES['file_lampiran']['name'])) {
                $s =  FileIO::uploadGd2('file_lampiran', 'surat_masuk', '');
                if (!empty($s['filename']))
                    $data['file_surat'] = $s['filename'];
                else {
                    throw new UserException('Gagal Upload, terjadi kesalahahn!!', UNAUTHORIZED_CODE);
                }
            } else {
                // throw new UserException('Foto harus diupload !!', UNAUTHORIZED_CODE);
            }

            $id =  $this->SuratModel->add_masuk($data);

            // $data = $this->SuratModel->getAll(['id_surat_masuk' => $id]);
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

    public function detail_surat_masuk($id)
    {
        try {
            $res_data = $this->SuratModel->getAll(array('id_surat_masuk' => $id))[$id];
            $data = array(
                'page' => 'surat/detail_masuk',
                'title' => 'Form SPT',
                'dataContent' => $res_data
            );
            // echo json_encode(array('error' => false, 'data' => $data));
            // die();
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
