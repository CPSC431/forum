<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'mailbox',
  'fields' => 
  array (
    0 => 'id',
    1 => 'subject',
    2 => 'message',
    3 => 'sender',
    4 => 'receiver',
    5 => 'receiver_read_at',
    6 => 'sender_deleted_at',
    7 => 'receiver_deleted_at',
    8 => 'created_at',
  ),
  'validation' => 
  array (
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'subject' => 
    array (
      'field' => 'subject',
      'rules' => 
      array (
      ),
    ),
    'message' => 
    array (
      'field' => 'message',
      'rules' => 
      array (
      ),
    ),
    'sender' => 
    array (
      'field' => 'sender',
      'rules' => 
      array (
      ),
    ),
    'receiver' => 
    array (
      'field' => 'receiver',
      'rules' => 
      array (
      ),
    ),
    'receiver_read_at' => 
    array (
      'field' => 'receiver_read_at',
      'rules' => 
      array (
      ),
    ),
    'sender_deleted_at' => 
    array (
      'field' => 'sender_deleted_at',
      'rules' => 
      array (
      ),
    ),
    'receiver_deleted_at' => 
    array (
      'field' => 'receiver_deleted_at',
      'rules' => 
      array (
      ),
    ),
    'created_at' => 
    array (
      'field' => 'created_at',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
  ),
  'has_many' => 
  array (
  ),
  '_field_tracking' => 
  array (
    'get_rules' => 
    array (
    ),
    'matches' => 
    array (
    ),
    'intval' => 
    array (
      0 => 'id',
    ),
  ),
);