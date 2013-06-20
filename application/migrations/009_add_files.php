<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Files extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			),
			'post_id' => array(
				'type' => 'INT',
				'unsigned' => true,
			),
			'user_id' => array(
				'type' => 'INT',
				'unsigned' => true,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'type' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
			),
			'image' => array(
				'type' => 'MEDIUMBLOB',
			),
			'size' => array(
				'type' => 'INT',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('files');
	}

	public function down()
	{
		$this->dbforge->drop_table('files');
	}
}