<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Drop_Files_Table extends CI_Migration {

	public function up()
	{
		$this->dbforge->drop_table('files');

	}

	public function down()
	{
		
	}
}