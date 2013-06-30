<?php

class Forum_Model extends DataMapper
{
    public $table = 'forums';

    public $has_many = array(
        'thread_model' => array(
            'class' => 'thread_model',
            'join_other_as' => 'thread',
            'join_self_as' => 'forum',
        ),
        'user_access_model' => array(
            'class' => 'user_access_model',
            'join_other_as' => 'user_access',
            'join_self_as' => 'forum',
        ),
    );

    protected $thread_model;

    public function __construct()
    {
        parent::__construct();

        $this->thread_model = new Thread_Model;
    }

    public function url()
    {
        return base_url('forum/' . $this->slug);
    }

    public function photoUrl()
    {
        return base_url('photo/forum/' . $this->id);
    }

    public function threads()
    {
        return $this->thread_model->where_related('forum_model', 'id', $this->id)->get();
    }

    public function latest_thread()
    {
        return $this->thread_model->where_related('forum_model', 'id', $this->id)->order_by('updated_at', 'desc')->get(1);
    }
}