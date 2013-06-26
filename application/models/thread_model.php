<?php

class Thread_Model extends DataMapper
{
    public $table = 'threads';

    public $has_one = array(
        'forum_model' => array(
            'class' => 'forum_model',
            'join_other_as' => 'forum',
            'join_self_as' => 'thread',
        ),
        'user_model' => array(
            'class' => 'user_model',
            'join_other_as' => 'creator',
            'join_self_as' => 'thread',
        )
    );

    public $has_many = array(
        'post_model' => array(
            'class' => 'post_model',
            'join_other_as' => 'post',
            'join_self_as' => 'thread',
        )
    );

    public function __construct()
    {
        parent::__construct();

        $this->user_model = new User_Model;
        $this->post_model = new Post_Model;
    }

    public function posts()
    {
        return $this->post_model->where_related('thread_model', 'id', $this->id)->get();
    }

    public function latest_post()
    {
        return $this->post_model->where_related('thread_model', 'id', $this->id)->order_by('updated_at', 'desc')->get(1);
    }

    public function url()
    {
        return base_url('threads/' . $this->id);
    }

    public function user()
    {
        return $this->user_model->where_related('thread_model', 'id', $this->id)->get(1);
    }
}