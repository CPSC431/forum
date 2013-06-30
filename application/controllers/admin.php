<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller
{
    protected $user_model, $message_model;

    public function __construct()
    {
        parent::__construct();

        $this->user_model        = new User_Model;
        $this->message_model     = new Message_Model;
        $this->forum_model       = new Forum_Model;
        $this->user_access_model = new User_Access_Model;

        // All paths in this controller require an active, authenticated session
        $this->check_for_login();

        // All paths in this controller (except for login) require the user to be an administrator
        // $this->check_for_admin();
        
        $this->load->helper('url');
        $this->load->library('upload');
    }

    public function index($id = null)
    {
        $forums = $this->forum_model->get();

        $this->twig->display('admin/index.html', array(
            'admin' => true,
            'forums' => $forums,
        ));
    }

    public function forum($method)
    {
        if ($method == 'create') {

            $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|xss_clean');
            // $this->form_validation->set_rules('photo', 'Photo', '');

            if ( ! $this->form_validation->run()) {
                $this->session->set_flashdata('validation_errors', validation_errors());
                $this->session->set_flashdata('old_data', $this->input->post());
                redirect($_SERVER['HTTP_REFERER']);
            } else if (!isset($_FILES['photo']) || empty($_FILES['photo']['name'])) {
                // Deal with no photo uploaded...
            }

            $forum = $this->forum_model;

            $forum->name = $this->input->post('name');
            $forum->slug = url_title($this->input->post('name'), '-', true);
            $forum->description = $this->input->post('description');

            $forum->picture = file_get_contents($_FILES['photo']['tmp_name']);
            $forum->picture_mime = $_FILES['photo']['type'];
            $forum->picture_size = $_FILES['photo']['size'];

            $forum->updated_at = date("Y-m-d H:i:s");
            $forum->created_at = date("Y-m-d H:i:s");

            $forum->save();

            $this->session->set_flashdata('alert', array(
                'class'   => 'alert-success',
                'message' => "{$forum->name} forum created."
            ));

            redirect(base_url('admin'));
        }
    }

    public function user_list()
    {
        if ($this->input->is_ajax_request()) {

            $users = $this->user_model->get();

            foreach ($users as $user) {
                $user_array[] = $user->username;
            }

            $this->json_response(array('users' => $user_array));

        } else {
            echo 'This method can only be accessed from ajax';
        }
    }

    public function moderators($method = null)
    {
        if ($method == 'create') {
            return $this->create_moderator();
        } else if ($method == 'delete') {
            return $this->delete_moderator();
        }

        if ($this->input->get('forum_id')) {
            $forum = $this->forum_model->where('id', $this->input->get('forum_id'))->get(1);

            $moderators = $this->user_access_model
                ->where('forum_id', $forum->id)
                ->where('access', 'moderator')
                ->get();

            $this->twig->display('admin/moderators.html', array(
                'admin'      => true,
                'moderators' => $moderators,
                'forum'      => $forum,
            ));
        } else {
            //
        }
    }

    private function create_moderator()
    {
        if ($this->input->post('username')) {

            $user = $this->user_model->where('username', $this->input->post('username'))->get(1);

            if ($user->exists()) {
                $moderator_exists = clone $this->user_access_model
                    ->where('forum_id', $this->input->post('forum_id'))
                    ->where('user_id', $user->id)
                    ->where('access', 'moderator')
                    ->get(1);

                if ( ! $moderator_exists->exists()) {
                    $newModerator = clone $this->user_access_model;
                    $newModerator->forum_id = $this->input->post('forum_id');
                    $newModerator->user_id = $user->id;
                    $newModerator->access = 'moderator';

                    $newModerator->updated_at = date("Y-m-d H:i:s");
                    $newModerator->created_at = date("Y-m-d H:i:s");

                    $newModerator->save();

                    $this->session->set_flashdata('alert', array(
                        'class'   => 'alert-success',
                        'message' => "{$user->username} added successfully."
                    ));

                    redirect(base_url('admin/moderators?forum_id=' . $this->input->post('forum_id')));
                } else {
                    // Redirect with warning: moderator already exists
                }
            } else {
                // Redirect with error: invalid user
            }
        } else {
            // Invalid parameters
        }
    }

    private function delete_moderator()
    {
        if ($this->input->get('user_id') && $this->input->get('forum_id')) {

            $moderator = $this->user_access_model
                ->where('forum_id', $this->input->get('forum_id'))
                ->where('user_id', $this->input->get('user_id'))
                ->where('access', 'moderator')
                ->get(1);

            if ($moderator->exists()) {
                $moderator->delete();

                $this->session->set_flashdata('alert', array(
                    'class'   => 'alert-success',
                    'message' => "Moderator removed successfully."
                ));

                redirect(base_url('admin/moderators?forum_id=' . $this->input->get('forum_id')));
            } else {
                // Redirect with error: invalid user
            }
        } else {
            // Invalid parameters
        }
    }
}