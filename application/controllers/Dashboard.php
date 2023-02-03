<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'UserModel'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }
    public function index()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            // $filter = $this->input->get();
            // $data = $this->AdministrationModel->getJenisDokumen($filter);
            // $data = $this->UserModel->getNotification();
            // echo json_encode(array("data" => $data));
            $data = array(
                'page' => 'dashboard',
                'title' => 'Dashboard'
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
