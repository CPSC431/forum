<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_Sender_Read_At extends CI_Migration {

    public function up()
    {
        $this->dbforge->drop_column('mailbox', 'sender_read_at');
    }

    public function down()
    {
        $this->dbforge->add_column('mailbox', array('sender_read_at' => array('type' => 'DATETIME')));
    }
}