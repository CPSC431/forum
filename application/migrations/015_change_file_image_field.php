<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_File_Image_Field extends CI_Migration {

	public function up()
	{
		$this->dbforge->drop_column('files', 'image');

		$this->dbforge->add_field('files', array(
			'file' => array(
				'type' => 'MEDIUMBLOB',
			)
		), 'type');

	}

	public function down()
	{
		$this->dbforge->drop_column('files', 'file');

		$this->dbforge->add_field('files', array(
			'image' => array(
				'type' => 'MEDIUMBLOB',
			)
		), 'type');
	}
}