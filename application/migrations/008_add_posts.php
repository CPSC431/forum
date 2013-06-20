<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Posts extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			),
			'thread_id' => array(
				'type' => 'INT',
				'unsigned' => true,
			),
			'user_id' => array(
				'type' => 'INT',
				'unsigned' => true,
			),
			'content' => array(
				'type' => 'TEXT',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('posts');
	}

	public function down()
	{
		$this->dbforge->drop_table('posts');
	}
}