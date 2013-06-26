<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends MY_Controller
{
    protected $user_model, $forum_model;

    public function __construct()
    {
        parent::__construct();

        $this->user_model    = new User_Model;
        $this->forum_model   = new Forum_Model;

        // All paths in this controller require an active, authenticated session
        $this->check_for_login();
    }

    public function index($id = null)
    {
        $forums = $this->forum_model->get();
        

        $this->twig->display('forum/index.html', array(
            'active' => 'forum',
            'forums' => $forums,
        ));
    }

    public function view($slug)
    {
        $forum = $this->forum_model->where('slug', $slug)->get(1);
        $threads = $forum->threads();

        $this->twig->display('forum/view.html', array(
            'active' => 'forum',
            'forum'  => $forum,
            'threads' => $threads
        ));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */