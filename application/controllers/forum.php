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
        $forums = $this->forum_model->where('deleted_at', '0000-00-00 00:00:00')->get();
        

        $this->twig->display('forum/index.html', array(
            'active' => 'forum',
            'forums' => $forums,
        ));
    }

    public function view($slug)
    {
        $forum = $this->forum_model->where('slug', $slug)->where('deleted_at', '0000-00-00 00:00:00')->get(1);
        $threads = $forum->threads();
        $user = $this->user_model->where('id', $this->user('id'))->get(1);

        if ($user->is_banned_from($forum)) {
            $this->session->set_flashdata('alert', array(
                'class'   => 'alert-error',
                'message' => "Sorry, you have been banned from {$forum->name}."
            ));

            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->twig->display('forum/view.html', array(
            'active'  => 'forum',
            'forum'   => $forum,
            'threads' => $threads,
            'user'    => $user,
        ));
    }
}