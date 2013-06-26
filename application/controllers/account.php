<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MY_Controller
{
    public $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = new User_Model;

        $this->load->library('bcrypt');
    }

    public function login()
    {
        if ($this->input->post('username')) {

            $user = $this->user;

            $user->where('username', $this->input->post('username', true))->get();

            $salted_password = $this->input->post('password') . $this->config->item('encryption_key');

            if ($this->bcrypt->check_password($salted_password, $user->password)) {

                // Log the user in
                $this->login_user($user);

                // Set a "flash data" alert, notifying the user that their login was successful
                // @more: http://ellislab.com/codeigniter/user-guide/libraries/sessions.html => "Flashdata"
                $this->session->set_flashdata('alert', array(
                    'class'   => 'alert-success',
                    'message' => 'Login successful!'
                ));

                // Redirect to the homepage
                if ($url = $this->session->userdata('pre_login_url')) {

                    $this->session->unset_userdata('pre_login_url');

                    redirect($url);

                } else {

                    redirect(base_url('/'));

                }
            } else {
                $this->twig->display('account/login.html', array(
                    'title' => 'testing',
                    'form'  => array('class' => 'form-signin'),
                    'error' => 'Invalid login. Please try again.'
                ));
            }

        } else {
            $this->twig->display('account/login.html', array(
                'title' => 'testing',
                'form' => array('class' => 'form-signin')
            ));
        }

    }

    public function logout()
    {
        $this->session->unset_userdata('user');

        $this->session->set_flashdata('alert', array(
            'class' => 'alert-success',
            'message' => 'You have been logged out successfully.'
        ));

        redirect(base_url('/'));
    }

    public function register()
    {

    	if ($this->input->post('register')) {

            $this->form_validation->set_rules('username',              'Username',              'required|is_unique[users.username]|max_length[100]');
            $this->form_validation->set_rules('password',              'Password',              'required|matches[password_confirmation]|min_length[7]');
            $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'required');
            $this->form_validation->set_rules('full_name',             'Full Name',             'required|max_length[50]');
            $this->form_validation->set_rules('terms',                 'Terms',                 'required');

            if ( ! $this->form_validation->run()) {

                $this->twig->display('account/register.html', array(
                    'errors' => true,
                    'error_messages' => validation_errors()
                ));

            } else {

                $this->user->username = $this->input->post('username', true);

                $salted_password = $this->input->post('password') . $this->config->item('encryption_key');
                $this->user->password = $this->bcrypt->hash_password($salted_password);
                $this->user->full_name = $this->input->post('full_name');

                $this->user->save();

                // Log the user in
                $this->login_user($this->user);

                $this->twig->display('account/registration_success.html', array('user' => $this->user));

            }
    	} else {
    		$this->twig->display('account/register.html', array());
    	}
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */