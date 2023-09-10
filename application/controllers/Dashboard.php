<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'UserModel', 'GeneralModel', 'DashboardModel'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = false;
    }

    public function getInfoSPT()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $data = $this->DashboardModel->getInfoSPT();
            echo json_encode(['error' => false, 'data' => $data]);
            // $this->load->view('theme/sweet-alert2');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAktifitasHarian()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $this->load->model('SPTModel');
            $filter['dari'] = date('Y-m-d');
            $filter['sampai'] = date('Y-m-d');
            $filter['status_rekap'] = 'selesai';
            if ($this->session->userdata('jen_satker') != 1)
                $filter2['id_satuan'] = $this->session->userdata('id_satuan');
            else
                $filter2 = [];
            $data = $this->DashboardModel->getAktifitasHarian($filter2);
            if (!empty($data[0]['update_at'])) {
                $from       = $data[0]['update_at'];
                $to         = date('Y-m-d H:i:s');
                $total      = strtotime($to) - strtotime($from);
                $hours      = floor($total / 60 / 60);
                if ($hours >= 1) {
                    $data_update = $this->SPTModel->getAllSPPD($filter);
                    $this->DashboardModel->updateAktifitasHarian($data_update);
                    $data = $this->DashboardModel->getAktifitasHarian($filter2);
                } else {
                    $data = $this->DashboardModel->getAktifitasHarian($filter2);
                }
            } else {
                $data_update = $this->SPTModel->getAllSPPD($filter);
                $this->DashboardModel->updateAktifitasHarian($data_update);
                $data = $this->DashboardModel->getAktifitasHarian($filter2);
            }
            echo json_encode(['error' => false, 'data' => $data]);
            // $this->load->view('theme/sweet-alert2');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getInfoSPTPkm()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $data = $this->DashboardModel->getInfoSPTPkm();
            if (!empty($data['update_at'])) {
                $from       = $data['update_at'];
                $to         = date('Y-m-d H:i:s');
                $total      = strtotime($to) - strtotime($from);
                $hours      = floor($total / 60 / 60);
                if ($hours >= 1) {
                    $this->DashboardModel->updateInfoSPTPkm();
                    $data = $this->DashboardModel->getInfoSPTPkm();
                } else {
                    $data = $this->DashboardModel->getInfoSPTPkm();
                }
            } else {
                $this->DashboardModel->updateInfoSPTPkm();
                $data = $this->DashboardModel->getInfoSPTPkm();
            }
            echo json_encode(['error' => false, 'data' => $data['data'], 'update_at' => $data['update_at']]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getLiveChat()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $filter = $this->input->get();
            $data = $this->DashboardModel->getLiveChat($filter);
            echo json_encode(['error' => false, 'data' => $data]);
            // $this->load->view('theme/sweet-alert2');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function send_live_chat()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $mess['id_user'] = $this->session->userdata('id');
            $mess['text'] = $this->input->get('text');
            if (!empty($mess['text'])) {
                $data = $this->DashboardModel->send_live_chat($mess);
                echo json_encode(['error' => false, 'data' => $data]);
            }
            // $this->load->view('theme/sweet-alert2');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function index()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $dataSPT = $this->DashboardModel->getInfoSPTPkm();
            if (!empty($dataSPT['update_at'])) {
                $from       = $dataSPT['update_at'];
                $to         = date('Y-m-d H:i:s');
                $total      = strtotime($to) - strtotime($from);
                $hours      = floor($total / 60 / 60);
                if ($hours >= 6) {
                    $this->DashboardModel->updateInfoSPTPkm();
                    $dataSPT = $this->DashboardModel->getInfoSPTPkm();
                } else {
                    $dataSPT = $this->DashboardModel->getInfoSPTPkm();
                }
            } else {
                $this->DashboardModel->updateInfoSPTPkm();
                $dataSPT = $this->DashboardModel->getInfoSPTPkm();
            }
            // aktifitas
            $this->load->model('SPTModel');
            $filter['dari'] = date('Y-m-d');
            $filter['sampai'] = date('Y-m-d');
            $filter['status_rekap'] = 'selesai';
            if ($this->session->userdata('jen_satker') != 1)
                $filter2['id_satuan'] = $this->session->userdata('id_satuan');
            else
                $filter2 = [];
            $dataAktifitas = $this->DashboardModel->getAktifitasHarian($filter2);
            if (!empty($dataAktifitas[0]['update_at'])) {
                $from       = $dataAktifitas[0]['update_at'];
                $to         = date('Y-m-d H:i:s');
                $total      = strtotime($to) - strtotime($from);
                $hours      = floor($total / 60 / 60);
                if ($hours >= 6) {
                    $data_update = $this->SPTModel->getAllSPPD($filter);
                    $this->DashboardModel->updateAktifitasHarian($data_update);
                    $dataAktifitas = $this->DashboardModel->getAktifitasHarian($filter2);
                } else {
                    $dataAktifitas = $this->DashboardModel->getAktifitasHarian($filter2);
                }
            } else {
                $data_update = $this->SPTModel->getAllSPPD($filter);
                $this->DashboardModel->updateAktifitasHarian($data_update);
                $dataAktifitas = $this->DashboardModel->getAktifitasHarian($filter2);
            }


            $data = array(
                'page' => 'dashboard',
                'title' => 'Dashboard',
                'dataContent' => [
                    'infoSPTPKm' => $dataSPT,
                    'aktifitasharian' => $dataAktifitas,
                ],

            );
            // echo json_encode($this->session->userdata());
            // echo json_encode(User_Access(1));
            $this->load->view('page', $data);
            // $this->load->view('theme/sweet-alert2');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function panduan()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $data = array(
                'page' => 'panduan',
                'title' => 'Panduan',
            );
            // echo json_encode($this->session->userdata());
            // echo json_encode(User_Access(1));
            $this->load->view('page', $data);
            // $this->load->view('theme/sweet-alert2');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
