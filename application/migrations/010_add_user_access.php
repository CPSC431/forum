<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_User_Access extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			),
			'user_id' => array(
				'type' => 'INT',
				'unsigned' => true,
			),
			'forum_id' => array(
				'type' => 'INT',
				'unsigned' => true,
			),
			'access' => array(
				'type' => 'ENUM',
				'constraint' => '"moderator", "banned"'
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('user_access');
	}

	public function down()
	{
		$this->dbforge->drop_table('user_access');
	}
}