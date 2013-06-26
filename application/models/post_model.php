<?php

class Post_Model extends DataMapper
{
    public $table = 'posts';

    public $has_one = array(
        'thread_model' => array(
            'class' => 'thread_model',
            'join_other_as' => 'thread',
            'join_self_as' => 'post',
        ),
        'user_model' => array(
            'class' => 'user_model',
            'join_other_as' => 'user',
            'join_self_as' => 'thread',
        ),
    );

    protected $user_model;

    public function __construct()
    {
        parent::__construct();

        $this->user_model = new User_Model;
    }

    public function user()
    {
        return $this->user_model->where_related('post_model', 'id', $this->id)->get(1);
    }
}