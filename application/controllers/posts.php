<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends MY_Controller
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

    public function create()
    {
        if ( ! $this->input->get('thread')) {
            $this->session->set_flashdata('alert', array(
                'class'   => 'alert-error',
                'message' => 'Thread id must be specified.',
            ));
            redirect($_SERVER['HTTP_REFERER']);
        }

        // if ( strlen($this->input->post('content')) < 1) {
        //     $this->session->set_flashdata('alert', array(
        //         'class'   => 'alert-error',
        //         'message' => 'You cannot insert an empty post.',
        //     ));
        //     redirect($_SERVER['HTTP_REFERER']);
        // }

        $this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[100]|xss_clean');

        if ( ! $this->form_validation->run()) {
            $this->session->set_flashdata('validation_errors', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            die('h');
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */