<?php

class User_Model extends DataMapper
{
    public $table = 'users';

    public $has_many = array(
        'thread_model' => array(
            'class' => 'thread_model',
            'join_other_as' => 'thread',
            'join_self_as' => 'creator',
        ),
        'post_model' => array(
            'class' => 'post_model',
            'join_other_as' => 'post',
            'join_self_as' => 'user',
        ),
        'user_access_model' => array(
            'class' => 'user_access_model',
            'join_other_as' => 'user_access',
            'join_self_as' => 'user',
        ),
    );
}