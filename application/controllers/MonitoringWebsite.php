<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MonitoringWebsite extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'CrossModel'));
        // $this->load->helper(array('DataStructure'));
        $this->SecurityModel->userOnlyGuard();

        $this->db->db_debug = false;
    }
    public function getAll()
    {
        try {
            $filter = $this->input->get();
            $data = $this->CrossModel->getBeritaPuskesmas($filter);
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function index()
    {
        try {
            $this->SecurityModel->multiRole('Monitoring Website', ['Postingan Website']);
            $filter['tahun'] = date('Y');
            $filter['bulan'] = date('m');
            $filter['id_user'] = $this->session->userdata('id');

            $data = array(
                'page' => 'single/monitoring_website',
                'title' => 'Monitoring Website',
            );

            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
