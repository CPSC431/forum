<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends MY_Controller
{
    protected $forum_model;

    public function __construct()
    {
        parent::__construct();

        $this->forum_model = new Forum_Model;
        $this->post_model = new Post_Model;
    }

    public function forum($id)
    {
        $forum = $this->forum_model->where('id', $id)->get(1);

        $this->output->set_content_type($forum->picture_mime);
        $this->output->set_output($forum->picture);

    }

    public function post($id)
    {
        $post = $this->post_model->where('id', $id)->get(1);

        $this->output->set_content_type($post->picture_mime);
        $this->output->set_output($post->picture);

    }
}