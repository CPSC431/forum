<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'forums',
  'fields' => 
  array (
    0 => 'id',
    1 => 'name',
    2 => 'slug',
    3 => 'description',
    4 => 'picture',
    5 => 'created_at',
    6 => 'updated_at',
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
    'name' => 
    array (
      'field' => 'name',
      'rules' => 
      array (
      ),
    ),
    'slug' => 
    array (
      'field' => 'slug',
      'rules' => 
      array (
      ),
    ),
    'description' => 
    array (
      'field' => 'description',
      'rules' => 
      array (
      ),
    ),
    'picture' => 
    array (
      'field' => 'picture',
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