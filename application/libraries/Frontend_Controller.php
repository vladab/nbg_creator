<?php
/**
 * Created by PhpStorm.
 * Date: 15.11.14., 18.50 
 */
class Frontend_Controller extends MY_Controller {


    public function __construct()
    {
        parent::__construct();
        // Load stuff
        $this->load->model('article_m');
        $this->data['meta_title'] = 'NBG Creator';
    }
}