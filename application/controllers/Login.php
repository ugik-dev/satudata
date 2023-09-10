<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
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
            $this->SecurityModel->guestOnlyGuard();
            $filter = $this->input->get();
            $this->load->view('login');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function loginProcess()
    {
        try {
            // $this->SecurityModel->guestOnlyGuard(TRUE);
            // Validation::ajaxValidateForm($this->SecurityModel->loginValidation());

            $loginData = $this->input->post();

            $user = $this->UserModel->login($loginData);

            $this->session->set_userdata($user);
            echo json_encode(array("error" => FALSE, "user" => $user));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function logout($ajax = false)
    {
        $this->session->sess_destroy();
        if (!empty($ajax)) echo json_encode(["error" => FALSE, 'data' => 'Logout berhasil.']);
        else redirect(base_url());
    }
}
