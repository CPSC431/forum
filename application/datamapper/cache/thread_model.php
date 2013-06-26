<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'threads',
  'fields' => 
  array (
    0 => 'id',
    1 => 'forum_id',
    2 => 'creator_id',
    3 => 'subject',
    4 => 'created_at',
    5 => 'updated_at',
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
    'forum_id' => 
    array (
      'field' => 'forum_id',
      'rules' => 
      array (
      ),
    ),
    'creator_id' => 
    array (
      'field' => 'creator_id',
      'rules' => 
      array (
      ),
    ),
    'subject' => 
    array (
      'field' => 'subject',
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
    'updated_at' => 
    array (
      'field' => 'updated_at',
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