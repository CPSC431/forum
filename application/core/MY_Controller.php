<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $_secure;
    protected $_dir;
    protected $_controller;
    protected $_method;

    public function __construct()
    {
        parent::__construct();

        if ($this->input->get('profiler'))
            $this->output->enable_profiler(TRUE);

        $this->load->library('form_validation');
        $this->load->database();

        $this->load->library('twig');
        $this->load->helper('date');

        $this->twig->add_function('base_url');
        $this->twig->add_function('get_userdata');
        $this->twig->add_function('form_open');
        $this->twig->add_function('timespan');
        $this->twig->add_function('now');
        $this->twig->add_function('validation_errors');


        // Gather info about the request
        $this->_secure = ! empty($_SERVER['HTTPS']);
        $this->_dir = $this->router->fetch_directory();
        $this->_controller = $this->router->fetch_class();
        $this->_method = $this->router->fetch_method();
    }

    public function login_user(User_Model $user)
    {
        $this->session->set_userdata('user', array(
            'id'        => $user->id,
            'username'  => $user->username,
            'full_name' => $user->full_name,
        ));
    }

    protected function check_for_login()
    {
        // Check if the user is not logged in
        if ( ! $this->session->userdata('user')) {
            $this->session->set_flashdata('alert', array(
                'class'   => 'alert-error',
                'message' => 'You must be logged in to access this page.'
            ));

            $this->session->set_userdata('pre_login_url', current_url());

            redirect(base_url('account/login'));
        }
    }

    protected function user($attr = null)
    {
        if ( ! $this->session->userdata('user'))
            throw new RuntimeException('Logged in user could not be identified. Please reauthenticate.');

        if ($attr) {
            $user = $this->session->userdata('user');
            return $user[$attr];
        } else {
            return $this->session->userdata('user');
        }
    }

    protected function json_response(array $data, $status = 200)
    {
        $this->load->helper('json_encode');
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($data))
                     ->set_status_header($status);
    }
}