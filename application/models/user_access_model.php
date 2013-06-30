<?php

class User_Access_Model extends DataMapper
{
    public $table = 'user_access';

    protected $user_model;

    public $has_one = array(
        'forum_model' => array(
            'class' => 'forum_model',
            'join_other_as' => 'forum',
            'join_self_as' => 'user_access',
        ),
        'user_model' => array(
            'class' => 'user_model',
            'join_other_as' => 'user',
            'join_self_as' => 'user_access',
        ),
    );

    public function __construct()
    {
        parent::__construct();

        $this->user_model = new User_Model;
    }

    public function user()
    {
        return $this->user_model->where_related('user_access_model', 'id', $this->id)->get(1);
    }
}