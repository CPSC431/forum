<?php

class User_Model extends DataMapper
{
    public $table = 'users';

    protected $user_access_model;

    public function __construct()
    {
        parent::__construct();

        $this->message_model = new Message_Model;
    }

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

    public function is_moderator_of($forum, $checkAdmin = true)
    {
        if ($checkAdmin) {
            if ($this->admin == 1) return true;
        }

        $user_access = $this->user_access_model
            ->where('user_id', $this->id)
            ->where('forum_id', $forum->id)
            ->where('access', 'moderator')
            ->get(1);

        return (bool) $user_access->exists();

    }

    public function is_banned_from($forum, $checkAdmin = true)
    {
        if ($checkAdmin) {
            if ($this->admin == 1) return false;
        }

        $user_access = $this->user_access_model
            ->where('user_id', $this->id)
            ->where('forum_id', $forum->id)
            ->where('access', 'banned')
            ->get(1);

        return (bool) $user_access->exists();

    }

    public function unread_message_count()
    {
        return $this->message_model
            ->where('receiver', $this->id)
            ->where('receiver_read_at', '0000-00-00 00:00:00')
            ->where('receiver_deleted_at', '0000-00-00 00:00:00')
            ->count();
    }
}