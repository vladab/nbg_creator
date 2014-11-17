<?php
class Article_m extends MY_Model
{
    protected $_table_name = 'articles';
    protected $_order_by = 'id desc';

    protected $_timestamps = TRUE;
    public $rules = array(
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required|max_length[100]|xss_clean'
        ),
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'trim|required|max_length[100]|url_title|xss_clean'
        ),
        'body' => array(
            'field' => 'body',
            'label' => 'Body',
            'rules' => 'trim|required'
        )
    );
    public function get_new ()
    {
        $article = new stdClass();
        $article->title = '';
        $article->slug = '';
        $article->body = '';
        $article->files = '';
        return $article;
    }

    /**
     * Get all media for selected article
     *
     * @param $id
     * @return mixed
     */
    public function get_images_for_article( $id )
    {

        $table_name = 'media';
        $filter = $this->_primary_filter;
        $id = $filter($id);
        $this->db->where( 'article_id', $id );
        $method = 'result';

        return $this->db->get($table_name)->$method();
    }

    /**
     * Removing Media for selected article
     *
     * @param $id
     * @return mixed
     */
    public function remove_images_for_article( $id )
    {
        $table_name = 'media';
        $filter = $this->_primary_filter;
        $id = $filter($id);
        $this->db->where( 'article_id', $id );

        return $this->db->delete($table_name);
    }
}