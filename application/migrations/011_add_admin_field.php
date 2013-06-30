<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Admin_Field extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('users', array(
            'admin' => array(
                'type' => 'BOOLEAN',
            )
        ));
	}

	public function down()
	{
		$this->dbforge->drop_column('users', 'admin');
	}
}