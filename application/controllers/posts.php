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

        $this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[1]|xss_clean');

        if ( ! $this->form_validation->run()) {
            $this->session->set_flashdata('validation_errors', validation_errors());
            $this->session->set_flashdata('old_data', $this->input->post());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $post = $this->post_model;

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] != 4) {
                                
            if (!in_array($_FILES['photo']['type'], array('image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/bmp', 'image/x-windows-bmp', 'image/gif'))) {
                
                $this->session->set_flashdata('alert', array(
                    'class'   => 'alert-error',
                    'message' => "Image must be a jpg, png, or gif."
                ));

                $this->session->set_flashdata('forum_values', $this->input->post());

                redirect($_SERVER['HTTP_REFERER']);

            // Image greater than 2 mb?
            } else if ($_FILES['photo']['size'] > 1024 * 1024 * 2) {

                $this->session->set_flashdata('alert', array(
                    'class'   => 'alert-error',
                    'message' => "Image size must be less than 2 MB."
                ));

                $this->session->set_flashdata('forum_values', $this->input->post());

                redirect($_SERVER['HTTP_REFERER']);

            }

            $post->picture = file_get_contents($_FILES['photo']['tmp_name']);
            $post->picture_mime = $_FILES['photo']['type'];
            $post->picture_size = $_FILES['photo']['size'];
        }

        $post->thread_id = $this->input->get('thread');
        $post->user_id = $this->user('id');
        $post->content = $this->input->post('content');

        $post->updated_at = date("Y-m-d H:i:s");
        $post->created_at = date("Y-m-d H:i:s");

        $post->save();

        $this->session->set_flashdata('alert', array(
            'class'   => 'alert-success',
            'message' => 'Your reply has been posted.',
        ));

        redirect(base_url('threads/' . $post->thread_id));
    }

}