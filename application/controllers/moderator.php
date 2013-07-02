<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Moderator extends MY_Controller
{
    protected $user_model, $forum_model;

    public function __construct()
    {
        parent::__construct();

        $this->user_model        = new User_Model;
        $this->forum_model       = new Forum_Model;
        $this->user_access_model = new User_Access_Model;

        // All paths in this controller require an active, authenticated session
        $this->check_for_login();

        // $this->check_for_moderator();
    }

    public function edit()
    {
        if ($this->input->post('forum_id')) {

            $user = $this->user_object();

            if ($user->is_moderator_of($this->input->post('forum_id'))) {

                $forum = $this->forum_model->where('id', $this->input->post('forum_id'))->get(1);

                if ($forum->exists()) {
                    $forum_data = array();

                    $forum_data['name']        = $this->input->post('name');
                    $forum_data['description'] = $this->input->post('description');
                    $forum_data['slug']        = url_title($this->input->post('name'), '-', true);

                    if (isset($_FILES['photo']) && $_FILES['photo']['error'] != 4) {
                        
                        if (!in_array($_FILES['photo']['type'], array('image/jpeg', 'image/pjpeg', 'image/x-png', 'image/bmp', 'image/x-windows-bmp', 'image/gif'))) {
                            
                            $this->session->set_flashdata('alert', array(
                                'class'   => 'alert-error',
                                'message' => "Image must be a jpg, png, or gif."
                            ));

                            $this->session->set_flashdata('forum_values', $this->input->post());

                            redirect(base_url('moderator/forum/' . $forum->id));

                        // Image greater than 2 mb?
                        } else if ($_FILES['photo']['size'] > 1024 * 1024 * 2) {

                            $this->session->set_flashdata('alert', array(
                                'class'   => 'alert-error',
                                'message' => "Image size must be less than 2 MB."
                            ));

                            $this->session->set_flashdata('forum_values', $this->input->post());

                            redirect(base_url('moderator/forum/' . $forum->id));

                        } else {
                            $forum_data['picture'] = file_get_contents($_FILES['photo']['tmp_name']);
                            $forum_data['picture_mime'] = $_FILES['photo']['type'];
                            $forum_data['picture_size'] = $_FILES['photo']['size'];
                        }
                    }

                    $forum_data['updated_at'] = date("Y-m-d H:i:s");

                    $this->forum_model->where('id', $this->input->post('forum_id'))->update($forum_data);

                    $this->session->set_flashdata('alert', array(
                        'class'   => 'alert-success',
                        'message' => "{$forum->name} forum updated."
                    ));

                    redirect(base_url('moderator/forum/' . $forum->id));
                } else {
                    die('Error: forum does not exist');
                }
            } else {
                die('User not allowed to access');
            }
        } else {
            die('No forum specified');
        }
    }

    public function user_action($action)
    {
        if ($this->input->get('user_id') && $this->input->get('forum_id')) {

            $user = $this->user_model->where('id', $this->input->get('user_id'))->get(1);
            $forum = $this->forum_model->where('id', $this->input->get('forum_id'))->get(1);

            if ($user->exists() && $forum->exists()) {

                if ($action == 'reinstate') {
                    $user_access = $this->user_access_model
                        ->where('user_id', $user->id)
                        ->where('forum_id', $forum->id)
                        ->where('access', 'banned')
                        ->get(1);

                    if ($user_access->exists()) {
                        $user_access->delete();

                        $this->session->set_flashdata('alert', array(
                            'class'   => 'alert-success',
                            'message' => "{$user->username} has been reinstated on {$forum->name}."
                        ));

                        redirect(base_url('moderator/users/' . $forum->id));
                    } else {
                        $this->session->set_flashdata('alert', array(
                            'class'   => 'alert-warning',
                            'message' => "{$user->username} was not banned on {$forum->name}."
                        ));

                        redirect(base_url('moderator/users/' . $forum->id));
                    }
                } else if ($action == 'ban') {

                    if ($user->admin) {
                        $this->session->set_flashdata('alert', array(
                            'class'   => 'alert-error',
                            'message' => "{$user->username} is an admin and cannot be banned from any forums."
                        ));

                        redirect(base_url('moderator/users/' . $forum->id));
                    }

                    $user_access = $this->user_access_model;

                    $user_access->user_id = $user->id;
                    $user_access->forum_id = $forum->id;
                    $user_access->access = 'banned';
                    $user_access->updated_at = date("Y-m-d H:i:s");
                    $user_access->created_at = date("Y-m-d H:i:s");

                    $user_access->save();

                    $this->session->set_flashdata('alert', array(
                        'class'   => 'alert-success',
                        'message' => "{$user->username} has been banned from {$forum->name}."
                    ));

                    redirect(base_url('moderator/users/' . $forum->id));

                }

            } else {
                die('user or forum do not exist.');
            }
        }
    }

    public function users($forum_id)
    {
        $forum = $this->forum_model->where('id', $forum_id)->get(1);

        $users = $this->user_model
            ->where_not_in('id', $this->user('id'))
            ->where('deleted_at', null)
            ->get();

        $this->twig->display('moderator/users.html', array(
            'admin' => true,
            'users' => $users,
            'forum' => $forum,
        ));
    }

    public function forum($id = null)
    {
        $forum = $this->forum_model->where('id', $id)->get(1);

        $this->twig->display('moderator/index.html', array(
            'admin' => true,
            'forum' => $forum,
            'forum_values' => ($this->session->userdata('forum_values')) ? $this->session->userdata('forum_values') : $forum,
        ));
    }

    public function view($slug)
    {
        $forum = $this->forum_model->where('slug', $slug)->where('deleted_at', '0000-00-00 00:00:00')->get(1);
        $threads = $forum->threads();
        $user = $this->user_model->where('id', $this->user('id'))->get(1);

        $this->twig->display('forum/view.html', array(
            'active'  => 'forum',
            'forum'   => $forum,
            'threads' => $threads,
            'user'    => $user,
        ));
    }
}