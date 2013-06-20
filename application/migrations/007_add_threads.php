<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Threads extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			),
			'forum_id' => array(
				'type' => 'INT',
				'unsigned' => true,
			),
			'creator_id' => array(
				'type' => 'INT',
				'unsigned' => true,
			),
			'subject' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('threads');
	}

	public function down()
	{
		$this->dbforge->drop_table('threads');
	}
}