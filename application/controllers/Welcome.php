<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/mlogin');
     
    }
 
    public function index() {
        $this->load->view('html_header');
        $this->load->view('login');
        $this->load->view('html_footer');
    }

    public function login() {

        $data['username'] = $this->input->get_post('username');
        $data['password'] = $this->input->get_post('password');
        if ($this->mlogin->login($data['username'], $data['password'])) {
            echo '{ "retval": true,"url" : "' . base_url() . 'index.php/dashboard' . '" }';
        } else {
            echo '{ "retval": false,"url" : "' . base_url() . '" }';
        }
    }

    public function logout() {
        $this->session->unset_userdata('user_group_id');
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('user_group');
        $this->session->unset_userdata('sys_user_group_id');
        $this->session->unset_userdata('username');
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }

    public function change_password() {
        $current_pass = md5($this->input->post('current_pass'));
        $new_pass = md5($this->input->post('new_pass'));


        if ($this->mlogin->password_match($current_pass)) {

            $this->mlogin->password_update($new_pass);
            $this->session->unset_userdata('user_group_id');
            $this->session->unset_userdata('login');
            $this->session->unset_userdata('user_group');
            $this->session->unset_userdata('sys_user_group_id');
            $this->session->unset_userdata('username');
            $this->session->sess_destroy();
            echo 'Password has been Changed..';
           
        } else {
        
            echo 'Sorry...!Current Password is Wrong';
        }
    }

}
