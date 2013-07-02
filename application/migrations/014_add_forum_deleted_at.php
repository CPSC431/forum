<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Forum_Deleted_At extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_column('forums', array(
            'deleted_at' => array(
                'type'       => 'DATETIME',
            )
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('forums', 'deleted_at');
    }
}