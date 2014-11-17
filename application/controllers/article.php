<?php
/**
 * Forontend controller for articles for displaying articles with pagination
 *
 * Date: 16.11.14., 14.24 
 */
class Article extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_m');

    }
    public function index( $start = 0 )
    {
        // Pagination Initialization
        $number_per_page = 3;
        $this->data['articles'] = $this->article_m->get_offset( $number_per_page, $start );
        $this->load->library('pagination');
        // Pagination parameters
        $config['base_url'] = base_url('article/index');
        $config['total_rows'] = $this->article_m->get_count();
        $config['per_page'] = $number_per_page;
        $this->pagination->initialize($config);
        // Data for the page
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['subview'] = 'pages/home';
        // Load view
        $this->load->view('_layout_main', $this->data);
    }

    /**
     * View single article
     *
     * @param null $slug
     */
    public function view( $slug = NULL )
    {
        // Get article based on the slug
        $article = $this->article_m->get_by('`slug` = "'.$slug.'"', TRUE);
        $id = $article->id;
        // Get article images
        $article->files = $this->article_m->get_images_for_article($id);
        if( empty( $article ) ) {
            $article = new stdClass();
            $article->title = "NBG Creator Article";
            $article->body = "No article selected";
        }
        $this->data['article'] = $article;
        $this->data['subview'] = 'pages/one_page';

        // Load view
        $this->load->view('_layout_main', $this->data);
    }
}