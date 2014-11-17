<?php
/**
 * Created by PhpStorm.
 * Date: 15.11.14., 19.05 
 */
class Migration extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->load->library('migration');
        if ( ! $this->migration->current())
        {
            show_error($this->migration->error_string());
        } else {
            echo 'Migration success!';
        }
    }
}