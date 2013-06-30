<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Forum_Photo_Fields extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_column('forums', array(
            'picture_mime' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
            )
        ), 'picture');

        $this->dbforge->add_column('forums', array(
            'picture_size' => array(
                'type' => 'INTEGER',
            )
        ), 'picture_mime');
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'picture_mime');
        $this->dbforge->drop_column('users', 'picture_size');
    }
}