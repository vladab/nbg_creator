<?php
/**
 * Created by PhpStorm.
 * Date: 16.11.14., 19.52 
 */
class Article extends Admin_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->model('article_m');
        $this->load->helper(array('form', 'url'));
    }
    public function index( $start = 0 )
    {
        // Pagination initialization
        $number_per_page = 3;
        $this->data['articles'] = $this->article_m->get_offset( $number_per_page, $start );
        $this->load->library('pagination');
        // Pagination Configuration
        $config['base_url'] = base_url('admin/article/index');
        $config['total_rows'] = $this->article_m->get_count();
        $config['per_page'] = $number_per_page;
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        // Page data
        $this->data['start'] = $start;
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['subview'] = 'admin/article/index';
        // Load view
        $this->load->view('admin/_layout_main', $this->data);
    }

    /**
     * Ajax call function for removing articles via ajax
     */
    public function remove_ajax( $start = 0 )
    {
        if( isset( $_POST['_id'] ) && $_POST['_id'] != '' ) {
            $this->delete( $_POST['_id'] );
        }
        $number_per_page = 3;
        $this->data['articles'] = $this->article_m->get_offset( $number_per_page, $start );
        $this->load->library('pagination');

        $config['base_url'] = base_url('admin/article/index');
        $config['total_rows'] = $this->article_m->get_count();
        $config['per_page'] = $number_per_page;

        $this->pagination->initialize($config);
        $this->data['start'] = $start;
        $this->data['pagination'] = $this->pagination->create_links();
        $this->load->view('admin/article/index_ajax', $this->data);
    }
    /**
     * Remove media on edit page via ajax
     */
    public function remove_media_ajax()
    {
        if( isset( $_POST['_id'] ) && $_POST['_id'] != '' ) {

            $data_ary = array(
                'id' => $_POST['_id'],
            );

            $this->load->database();
            $name = $this->db->get_where('media', array('id' => $_POST['_id']) )->row();
            $this->db->delete('media', $data_ary);
            //unlink(base_url().'/public/uploads/'.$name->location);
        }
    }

    /**
     * Edit article
     *
     * @param null $id
     */
    public function edit ($id = NULL)
    {
        // Check which button is pressed. If Cancel is pressed redirect to aticle list
        $form_submit = $this->input->post('submit');
        if( $form_submit == 'Cancel' ) {
            redirect($this->config->item('backend_folder').'admin/article/index');
        }
        // Fetch a article or set a new one
        if ( $id ) {
            $this->data['article'] = $this->article_m->get($id);
            $this->data['article']->files = $this->article_m->get_images_for_article($id);
            // If there is no article with id
            if ( count($this->data['article']) == 0 ) {
                $this->data['errors'][] = 'article could not be found';
            }
        } else {
            // Create new article object
            $this->data['article'] = $this->article_m->get_new();
        }

        // Set up the form
        $rules = $this->article_m->rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if ( $this->form_validation->run() == TRUE ) {
            $data = $this->article_m->array_from_post( array(
                'title',
                'slug',
                'body',
            ) );
            // Check if slug unique if not add number on it
            if( count($this->article_m->get_by('`slug` = "'.$data['slug'].'"', FALSE)) != 0 ) {
                $data['slug'] = increment_string($data['slug'], '-');
                $this->data['article']->slug = $data['slug'];
            }

            $id = $this->article_m->save($data, $id);
            // If tere are files in submit form process them
            if ( !empty($_FILES['userfile']['name'][0] )) {
                $this->do_upload($id);
                $this->data['article']->files = $this->article_m->get_images_for_article($id);
            }
            // Redirect to article list?
            redirect('admin/article/edit/'. $id);
        }

        // Load the view
        $this->data['subview'] = 'admin/article/edit';
        $this->load->view('admin/_layout_main', $this->data);
    }

    /**
     * Remove article and their files
     *
     * @param $id
     */
    public function delete ($id)
    {
        // Remove Article
        $this->article_m->delete($id);
        // Remove media for that article
        $this->article_m->remove_images_for_article($id);
        //redirect('admin/article');
    }

    /**
     * Upload multiple images function for article id
     *
     * @param $id
     */
    public function do_upload( $id )
    {
        // Upload configurations
        $config['upload_path'] = '../public/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $count = count($_FILES['userfile']['size']);
        foreach ( $_FILES as $key => $value ) {
            for ( $s = 0; $s <= $count - 1; $s++ ) {

                $_FILES['userfile']['name'] = $value['name'][$s];
                $_FILES['userfile']['type'] = $value['type'][$s];
                $_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
                $_FILES['userfile']['error'] = $value['error'][$s];
                $_FILES['userfile']['size'] = $value['size'][$s];

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload()) {
                    // Display errors if there is any
                    // TODO: create error handler
                    var_dump($this->upload->display_errors());
                } else {
                    // Upload and connect images to articles
                    $upload_data = $this->upload->data();
                    $data_ary = array(
                        'article_id' => $id,
                        'location' => $upload_data['file_name'],
                    );
                    // Save media for article
                    $this->load->database();
                    $this->db->insert('media', $data_ary);
                }
            }
        }
    }
}