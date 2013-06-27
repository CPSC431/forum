<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Threads extends MY_Controller
{
    protected $user_model, $forum_model, $thread_model, $post_model;

    public function __construct()
    {
        parent::__construct();

        $this->user_model    = new User_Model;
        $this->forum_model   = new Forum_Model;
        $this->thread_model  = new Thread_Model;
        $this->post_model    = new Post_Model;

        // All paths in this controller require an active, authenticated session
        $this->check_for_login();
    }

    public function index($id)
    {
        $thread = $this->thread_model->where('id', $id)->get(1);

        $posts = $thread->posts();

        $this->twig->display('threads/index.html', array(
            'active' => 'forum',
            'thread' => $thread,
            'validation_errors' => $this->session->flashdata('validation_errors'),
            'old_data' => $this->session->flashdata('old_data'),
            'posts' => $posts,
        ));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */