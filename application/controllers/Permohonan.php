<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Permohonan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'SKPModel', 'PermohonanModel', 'SPPDModel', 'SuratIzinModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }
    public function action($action, $id)
    {
        try {
            $this->SecurityModel->multiRole('SPT / SPPD', ['Entri SPT', 'Entri SPT SPPD', 'Entri Lembur']);
            $data = $this->SPPDModel->getAllSPPD(array('id_spt' => $id))[$id];

            $cur_user = $this->session->userdata();
            $logs['id_spt'] = $id;
            $logs['id_user'] = $cur_user['id'];
            if ($data['user_input'] == $cur_user['id']) {
                if ($data['status'] == 0) {
                    if ($action == 'ajukan') {
                        $logs['deskripsi'] =  'Mengajukan Permohonan';
                        $logs['label'] = 'success';
                        $this->SPPDModel->draft_to_diajukan($data);
                        $this->SPPDModel->addLogs($logs);
                        echo json_encode(array('error' => false, 'data' => $data));
                        return;
                    }
                }
            }

            if ($action == 'approv') {
                $logs['deskripsi'] =  'Menyetujui';
                $logs['label'] = 'success';
                $this->SPPDModel->approv($data);
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


            // if ($cur_user['level'] == 2 && $data['id_bagian_pegawai'] == $cur_user['id_bagian']) {
            //     if ($data['status'] == 1) {
            //         if ($action == 'approv') {
            //             $this->SPPDModel->approv($data);
            //         }
            //         if ($action == 'unapprov') {
            //             $this->SPPDModel->unapprov($data);
            //         }
            //     } else if ($data['status'] == 2 && $data['id_unapproval'] == $cur_user['id']) {
            //         if ($action == 'undo') {
            //             $this->SPPDModel->undo($data);
            //         }
            //     } else
            //         throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
            // } else {
            //     throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
            // }
            $data = $this->SPPDModel->getAllSPPD(array('id_spt' => $id))[$id];
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function getAll()
    {
        try {
            $filter = $this->input->get();
            $data_penilai1 = $this->session->userdata();
            $filter['id_penilai'] = $data_penilai1['id'];

            $plh = $this->SPPDModel->getAllSPPD(['status' => 99, 'plh' => 'Y', 'dari' => date('Y-m-d'), 'sampai' => date('Y-m-d')], false, true);
            if (!empty($plh)) {
                $this->load->model('UserModel');
                $filter['plh_search'] = $plh[array_key_first($plh)];
                $data_penilai2 = $filter['plh_search']['user'] = $this->UserModel->getAllUser(['id_user' => $filter['plh_search']['id_pegawai']])[$filter['plh_search']['id_pegawai']];
            }

            if (!empty($filter['chk-surat-izin']) or !empty($filter['chk-surat-cuti'])) {
                $filter['search_approval']['data_penilai'] = $data_penilai1;
                $filter['id_penilai'] = $data_penilai1['id'];
                $si1 = $this->SuratIzinModel->getAll($filter);
                $si2 = [];
                if (!empty($data_penilai2)) {
                    $filter['search_approval']['data_penilai'] = $data_penilai2;
                    $filter['id_penilai'] = $data_penilai2['id'];
                    $si2 = $this->SuratIzinModel->getAll($filter);
                }
                $data['surat_izin'] = array_merge($si1, $si2);
            } else
                $data['surat_izin'] = [];

            if (in_array($data_penilai1['level'], [1, 2, 3, 4, 5, 7, 8, 6])) {
                // $data['laporan_spt'] = $this->SPPDModel->getLaporan($filter, true);
                if (!empty($filter['chk-spt']) or !empty($filter['chk-sppd']) or !empty($filter['chk-lembur'])) {
                    $spt2 = [];
                    if (!empty($data_penilai2)) {
                        $filter['search_approval']['data_penilai'] = $data_penilai2;
                        $filter['id_penilai'] = $data_penilai2['id'];
                        $spt2 = $this->SPPDModel->getAllSPPD($filter, false, true);
                        // echo json_encode($spt2);
                        // die();
                        // echo json_encode($spt2);
                        // die();
                    }
                    $filter['search_approval']['data_penilai'] = $data_penilai1;
                    $filter['id_penilai'] = $data_penilai1['id'];
                    $spt1 = $this->SPPDModel->getAllSPPD($filter, true);

                    $data['spt'] = $spt1 + $spt2;
                } else $data['spt'] = [];
            } else {
                $data['spt'] = [];
                $data['laporan_spt'] = [];
            }

            // $data['skp'] = $this->PermohonanModel->getAll($filter); //skp
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function index()
    {
        try {
            // $this->SecurityModel->userOnlyGuard();
            $plh = [];
            $plh = $this->SPPDModel->getAllSPPD(['status' => 99, 'plh' => 'Y', 'dari' => date('Y-m-d'), 'sampai' => date('Y-m-d')], false, true);
            // echo json_encode($plh);
            // die();
            if (!empty($plh)) {
                $this->load->model('UserModel');
                $plh = $plh[array_key_first($plh)];
                $plh['user'] = $this->UserModel->getAllUser(['id_user' => $plh['id_pegawai']])[$plh['id_pegawai']];
            }
            // echo json_encode($plh);
            // die();
            $data = array(
                'page' => 'my/permohonan',
                'title' => 'SPPD',
                'dataContent' => ['plh' => $plh]

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

    public function approv_data()
    {
        try {
            $data = $this->input->get();
            if ($data['jenis'] == 'spt') {
                $data_spt = $this->SPPDModel->getAllSPPD(['id_spt' => $data['id']])[$data['id']];
                $this->SPPDModel->approv($data_spt);
                $data_spt = $this->SPPDModel->getAllSPPD(['id_spt' => $data['id']])[$data['id']];
                echo json_encode(array('error' => false, 'data' => $data_spt));
            }
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function approv_skp($filter, $data, $users, $penilai)
    {
        try {
            $id = $this->input->get('id');
            $filter['id_skp'] = $id;
            $filter['id_penilai'] = $this->session->userdata()['id'];

            $data = $this->PermohonanModel->getAll($filter)[$id];
            $users = $this->GeneralModel->getAllUser(array('id' => $data['id_user']))[$data['id_user']];
            $penilai = $this->GeneralModel->getAllUser(array('id' => $data['id_penilai']))[$data['id_penilai']];

            if ($data['id_penilai'] != $this->session->userdata()['id'])
                throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
            else {
                if ($data['status'] == 2)
                    throw new UserException('Kamu telah approv data ini', UNAUTHORIZED_CODE);
                else
              if ($data['status'] == 3)
                    throw new UserException('Kamu telah menolak approv data ini', UNAUTHORIZED_CODE);
                $key = md5($data['status'] . time());
                $this->addQRCode($key, 10);
                // $data['key'] = $key;
                // die();
                $data['status'] = 2;
                $res = array(
                    'id_skp' => $id,
                    'key' => $key,
                    'penilai_nama' => $penilai['nama'],
                    'penilai_nip' => $penilai['nip'],
                    'penilai_jabatan' => $penilai['jabatan'],
                    'penilai_pangkat_gol' => $penilai['pangkat_gol'],
                    'penilai_signature' => $penilai['signature'],
                    'penilai_satuan' => $penilai['nama_satuan'],
                    'pengaju_nama' => $users['nama'],
                    'pengaju_nip' => $users['nip'],
                    'pengaju_jabatan' => $users['jabatan'],
                    'pengaju_pangkat_gol' => $users['pangkat_gol'],
                    'pengaju_signature' => $users['signature'],
                    'pengaju_satuan' => $users['nama_satuan'],
                );
                $this->SKPModel->approv($res);
            }
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    // }


    public function aksi_skp()
    {
        try {
            $data_sess = $this->session->userdata();
            $data = $this->input->get();
            if ($data['jenis'] == 'spt') {
                $this->load->model('SPPDModel');
                $data_spt = $this->SPPDModel->getAllSPPD(['id_spt' => $data['id']])[$data['id']];
                if ($data_spt['id_ppk'] == $data_sess['id']) {
                    if ($data_spt['status'] == 11 || $data_spt['unapprove_oleh'] == $data_sess['id']) {
                        $this->SPPDModel->unapprov(['id_spt' => $data['id'], 'status' => 10, 'approve_sekdin' => 'NULL']);
                    }
                }
                if ($data_sess['level'] == 2) {
                    if ($data_spt['status'] == 12 || $data_spt['unapprove_oleh'] == $data_sess['id']) {
                        // die();
                        $this->SPPDModel->unapprov(['id_spt' => $data['id'], 'status' => 11, 'approve_sekdin' => 'NULL']);
                    }
                } else   if ($data_sess['level'] == 1) {
                    if ($data_spt['status'] == 99 || $data_spt['unapprove_oleh'] == $data_sess['id']) {
                        // die();
                        $this->SPPDModel->unapprov(['id_spt' => $data['id'], 'status' => 12, 'approve_kadin' => 'NULL', 'no_spt' => NULL, 'no_sppd' => NULL, 'unapprove_oleh' => NULL]);
                    }
                }

                $data_spt = $this->SPPDModel->getAllSPPD(['id_spt' => $data['id']])[$data['id']];
                echo json_encode(['error' => false, 'data' => $data_spt]);
            } else {
                $id = $this->input->get('id');
                $aksi = $this->input->get('aksi');
                $filter['id_skp'] = $id;
                $filter['id_penilai'] = $this->session->userdata()['id'];

                $data = $this->PermohonanModel->getAll($filter)[$id];
                if ($data['id_penilai'] != $this->session->userdata()['id'])
                    throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
                else {
                    if ($aksi == 3) {
                        if ($data['status'] == 2)
                            throw new UserException('Kamu telah approv data ini', UNAUTHORIZED_CODE);
                        else if ($data['status'] == 3)
                            throw new UserException('Kamu telah menolak approv data ini', UNAUTHORIZED_CODE);
                        $this->SKPModel->edit_approv($data, 3);
                        $data['status'] = $aksi;
                    }
                    if ($aksi == 1) {
                        // if ($data['status'] == 2)
                        //     throw new UserException('Kamu telah approv data ini', UNAUTHORIZED_CODE);
                        // else if ($data['status'] == 3)
                        //     throw new UserException('Kamu telah menolak approv data ini', UNAUTHORIZED_CODE);
                        $this->SKPModel->edit_approv($data, 1);
                        $this->SKPModel->delete_approv($data);
                        $data['status'] = $aksi;
                    }
                }
                echo json_encode(array('error' => false, 'data' => $data));
            }
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
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
