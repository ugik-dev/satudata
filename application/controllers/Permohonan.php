<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Permohonan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'SKPModel', 'PermohonanModel', 'SPPDModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }

    public function getAll()
    {
        try {
            // $this->SecurityModel->userOnlyGuard();
            $filter = $this->input->get();
            $filter['id_penilai'] = $this->session->userdata()['id'];
            $data_penilai = $this->session->userdata();
            // if($data_penilai['id_seksi'] != '')
            // $filter['search_approval']
            $filter['search_approval']['data_penilai'] = $data_penilai;
            $data['spt'] = $this->SPPDModel->getAllSPPD($filter);

            // echo json_encode($data);
            // echo json_encode($data_penilai);
            // die();
            $data['skp'] = $this->PermohonanModel->getAll($filter); //skp
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
                'page' => 'my/permohonan',
                'title' => 'SPPD',
                // 'dataContent' => $res_data

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
