<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'UserModel', 'GeneralModel'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = false;
    }

    public function berita_puskesmas()
    {
        $filter = $this->input->get();
        $this->GeneralModel->test_cross($filter);
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
}
