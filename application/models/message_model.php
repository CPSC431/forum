<?php

class Message_Model extends DataMapper
{
    public $table = 'mailbox';

    public function url()
    {
        return base_url('messages/view/' . $this->id);
    }

    public function isUnread($user_id)
    {
        return ($this->receiver == $user_id && $this->receiver_read_at == '0000-00-00 00:00:00');
    }

    public function get_single_message($id, $user_id)
    {
        return $this->where('id', $id)
            ->group_start()
                ->group_start()
                    ->where('sender', $user_id)
                    ->where('sender_deleted_at', null)
                ->group_end()
                ->or_group_start()
                    ->where('receiver', $user_id)
                    ->where('receiver_deleted_at', null)
                ->group_end()
            ->group_end()
        ->get();
    }
}