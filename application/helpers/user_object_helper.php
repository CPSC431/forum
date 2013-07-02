<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_user_object'))
{
    function get_user_object()
    {
        $CI =& get_instance();
        $CI->load->library('session');

        if ($user_array = $CI->session->userdata('user')) {
        	$user = new User_Model;
        	$user->where('id', $user_array['id'])->get(1);

       		return $user;
        }

        return null;
    }
}