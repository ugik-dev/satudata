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
            // $data = array(
            //     'page' => 'dashboard',
            //     'title' => 'Dashboard',
            // );
            // // echo json_encode($this->session->userdata());
            // // echo json_encode(User_Access(1));
            $data = $this->DashboardModel->getInfoSPT();
            echo json_encode(['error' => false, 'data' => $data]);
            // $this->load->view('theme/sweet-alert2');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function index()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $data = array(
                'page' => 'dashboard',
                'title' => 'Dashboard',
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
