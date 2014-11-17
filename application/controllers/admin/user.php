<?php
/**
 * Created by PhpStorm.
 * Date: 16.11.14., 18.46 
 */
class User extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->data['users'] = $this->user_m->get();
        $this->data['rights_levels'] = $this->user_m->rights_levels;
        $this->data['subview'] = 'admin/user/index';
        $this->load->view('admin/_layout_main', $this->data);
    }
    public function login()
    {
        $dashboard = 'admin/article/index';
        $this->user_m->loggedin() == FALSE || redirect($dashboard);

        $rules = $this->user_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            // login and redirect
            if($this->user_m->login() == TRUE){
                redirect($dashboard);
            } else {
                $this->session->set_flashdata('error', 'That email/password doest exist.');
                redirect('admin/user/login', 'refresh');
            }
        }
        $this->data['subview'] = 'admin/user/login';
        $this->load->view('admin/_layout_modal', $this->data);
    }
    public function logout()
    {
        $this->user_m->logout();
        redirect('admin/user/login');
    }
}