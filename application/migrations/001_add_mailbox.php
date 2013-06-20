<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Mailbox extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field('id');

		$this->dbforge->add_field(array(
			'subject' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'message' => array(
				'type' => 'TEXT',
			),
			'sender' => array(
				'type' => 'INT',
                'unsigned' => true,
			),
            'receiver' => array(
                'type' => 'INT',
                'unsigned' => true,
            ),
            'sender_read_at' => array(
                'type' => 'DATETIME',
            ),
            'receiver_read_at' => array(
                'type' => 'DATETIME',
            ),
            'sender_deleted_at' => array(
                'type' => 'DATETIME',
            ),
            'receiver_deleted_at' => array(
                'type' => 'DATETIME',
            ),
		));

		$this->dbforge->create_table('mailbox');
	}

	public function down()
	{
		$this->dbforge->drop_table('mailbox');
	}
}