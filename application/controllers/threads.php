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

    public function create()
    {
        if ($this->input->post('forum_id') && $this->input->post('subject')) {

            $forum = $this->forum_model->where('id', $this->input->post('forum_id'))->get(1);

            if ($forum->exists()) {

                $thread = $this->thread_model;

                $thread->forum_id = $this->input->post('forum_id');
                $thread->creator_id = $this->user('id');
                $thread->subject = $this->input->post('subject');

                $thread->updated_at = date("Y-m-d H:i:s");
                $thread->created_at = date("Y-m-d H:i:s");

                $thread->save();

                $this->session->set_flashdata('alert', array(
                    'class'   => 'alert-success',
                    'message' => 'Your new thread has been created.',
                ));

                redirect(base_url('threads/' . $thread->id));
            }
        }
    }

}