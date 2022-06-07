<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'UserModel', 'GeneralModel'));
        // $this->load->helper(array('DataStructure'));
        $this->db->db_debug = TRUE;
    }

    public function pegawai()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Pegawai');
            $data = array(
                'page' => 'master/users',
                'title' => 'Users & Hak Aksess'
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function detail_pegawai($id)
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Pegawai');
            $data_profile = $this->GeneralModel->getAllUser(array('id' => $id))[$id];

            $data = array(
                'page' => 'master/detail_pegawai',
                'title' => 'Users & Hak Aksess',
                'data_profile' => $data_profile
            );
            // echo json_encode($data_profile);
            // die();
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }




    public function satuan()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Satuan / Unit');
            $data = array(
                'page' => 'master/satuan',
                'title' => 'Satuan / Unit'
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function roles()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Roles');
            $data = array(
                'page' => 'master/roles',
                'title' => 'Master > Roles'
            );
            $this->load->view('page', $data);
            // $this->load->view('test', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function role_edit($id)
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Roles');
            $res_data['roles'] =  $this->UserModel->getDetailRole($id);
            $res_data['users'] = $this->GeneralModel->getAllRole(array('id_role' => $id, 'key_id' => 1))[$id];
            $res_data['form_url'] = 'master/edit_role_process';
            // echo json_encode($res_data);
            // die();
            $data = array(
                'page' => 'master/edit_role',
                'title' => 'Master > Roles',
                'dataContent' => $res_data
            );
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function tambah_role()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Roles');
            $res_data['roles'] =  $this->UserModel->getDetailRole();
            $res_data['form_url'] = 'master/add_role_process';

            $data = array(
                'page' => 'master/edit_role',
                'title' => 'Master > Roles',
                'dataContent' => $res_data
            );
            // echo json_encode($data);
            $this->load->view('page', $data);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function edit_role_process()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Roles');
            $data = $this->input->post();
            // die();
            $mdata['id_role'] = $data['id_role'];
            $mdata['nama_role'] = $data['nama_role'];
            $mdata['level'] = $data['level'];
            unset($data['level']);
            unset($data['nama_role']);
            $ndata = array();
            foreach ($data as $k => $dt) {
                $n = array();
                $n = explode('_', $k);
                // var_dump($k);
                // die();
                if ($n[0] == 'view') $ndata[$n[1]]['view'] = 1;
                if ($n[0] == 'create') $ndata[$n[1]]['hk_create'] = 1;
                if ($n[0] == 'update') $ndata[$n[1]]['hk_update'] = 1;
                if ($n[0] == 'delete') $ndata[$n[1]]['hk_delete'] = 1;
            }
            $mdata['hak_aksess'] = $ndata;
            $this->UserModel->edit_hak_akses($mdata);
            echo json_encode($mdata);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }



    public function add_role_process()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Roles');
            $data = $this->input->post();
            // die();
            // $mdata['id_role'] = $data['id_role'];
            $mdata['nama_role'] = $data['nama_role'];
            // unset($data['id_user']);
            unset($data['nama_role']);
            $ndata = array();
            foreach ($data as $k => $dt) {
                $n = array();
                $n = explode('_', $k);
                // var_dump($k);
                // die();
                if ($n[0] == 'view') $ndata[$n[1]]['view'] = 1;
                if ($n[0] == 'create') $ndata[$n[1]]['hk_create'] = 1;
                if ($n[0] == 'update') $ndata[$n[1]]['hk_update'] = 1;
                if ($n[0] == 'delete') $ndata[$n[1]]['hk_delete'] = 1;
            }
            $mdata['hak_aksess'] = $ndata;
            $this->UserModel->add_hak_akses($mdata);
            echo json_encode($mdata);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function editUser()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Pegawai');
            $data = $this->input->post();

            $this->UserModel->editUser($data);
            $data = $this->GeneralModel->getAllUser(array('id' => $data['id']))[$data['id']];
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }



    public function addUser()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Pegawai');
            $data = $this->input->post();
            $id =  $this->UserModel->addUser($data);
            $data = $this->GeneralModel->getAllUser(array('id' => $id))[$id];

            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function editPosition()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Pegawai');
            $data = $this->input->post();

            $this->UserModel->editPosition($data);
            $data = $this->GeneralModel->getAllPostion(array('id' => $data['id']))[$data['id']];
            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }



    public function addPosition()
    {
        try {
            $this->SecurityModel->multiRole('Master', 'Pegawai');
            $data = $this->input->post();
            $id =  $this->UserModel->addPosition($data);
            // $data = $this->GeneralModel->getAllPostion(array('id' => $id))[$id];

            echo json_encode(array('error' => false, 'data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
