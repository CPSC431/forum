<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Mailbox_Created_At extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_column('mailbox', array(
        	'created_at' => array(
        		'type' => 'DATETIME',
        	)
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('mailbox', 'created_at');
    }
}