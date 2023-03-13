<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ikm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'AbsenModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = TRUE;
    }

    public function index()
    {
        try {
            $this->SecurityModel->multiRole('Index Kepuasan Masyarakat', ['Index Kepuasan Masyarakat']);
            $filter['tahun'] = date('Y');
            $filter['bulan'] = date('m');
            $filter['id_user'] = $this->session->userdata('id');

            $data = array(
                'page' => 'single/ikm',
                'title' => 'Index Kepuasan Masyarakat',
            );

            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
