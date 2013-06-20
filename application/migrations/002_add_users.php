<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Users extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			),
			'full_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 64,
            )
		));

        $this->dbforge->add_key('id', true);
		$this->dbforge->create_table('users');
	}

	public function down()
	{
		$this->dbforge->drop_table('users');
	}
}