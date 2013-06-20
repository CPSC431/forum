<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Forums extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'description' => array(
				'type' => 'TEXT',
			),
			'picture' => array(
				'type' => 'MEDIUMBLOB',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('forums');
	}

	public function down()
	{
		$this->dbforge->drop_table('forums');
	}
}