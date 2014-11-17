<?php
/**
 * Created by PhpStorm.
 * Date: 15.11.14., 18.50 
 */
class Admin_Controller extends MY_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->data['meta_title'] = 'Admin';
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('user_m');

        $exception_uris = array(
            'admin/user/login',
            'admin/user/logout'
        );
        if(in_array(uri_string(), $exception_uris) == FALSE){
            if($this->user_m->loggedin() == FALSE){
                redirect('admin/user/login');
            }
        }
    }
}