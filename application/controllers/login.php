<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('username')) {
            //if username is already set up, then check the level of username is admin or member
            if ($this->session->userdata('level') == 'admin') {
                redirect('/admin/index');
            }elseif ($this->session->userdata('level') == 'manajer') {
                redirect('/manajer/index');
            }
    }
}


    public function index()
    {
        $this->load->view('login');
    }

    public function cobalogin()
    {

        $this->load->model('mtabel_user');
        $username = $this->input->post('user');
        $password =md5($this->input->post('pass'));
        //calling chech_user() function in Login_model.php

        $result = $this->mtabel_user->ceklogin($username, $password);

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $username = $row->username;
                $level = $row->level;
            }

            $newdata = array(
                'username' => $username,
                'level' => $level,
                'logged_in' => TRUE
            );

            //set up session data
            $this->session->set_userdata($newdata);
            if ($this->session->userdata('level') == 'admin') {
                redirect('/admin');
            }elseif ($this->session->userdata('level') == 'manajer') {
                redirect('/manajer');
            }
             }else{
            echo "<script>alert('Gagal login: Cek username, password!');history.go(-1);</script>";
        }
    }

 }

/* End of file login.php */
/* Location: ./application/controllers/login.php */