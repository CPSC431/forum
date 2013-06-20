<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Foreign_Keys extends CI_Migration {

    public function up()
    {
        $this->db->query('ALTER TABLE `mailbox` ADD INDEX sender(sender);');
        $this->db->query('ALTER TABLE `mailbox` ADD INDEX receiver(receiver);');

        $this->db->query('ALTER TABLE `mailbox` ADD CONSTRAINT mailbox_sender_foreign FOREIGN KEY(`sender`) REFERENCES users(`id`);');
        $this->db->query('ALTER TABLE `mailbox` ADD CONSTRAINT mailbox_receiver_foreign FOREIGN KEY(`receiver`) REFERENCES users(`id`);');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `mailbox` DROP CONSTRAINT mailbox_sender_foreign');
        $this->db->query('ALTER TABLE `mailbox` DROP CONSTRAINT mailbox_receiver_foreign');
    }
}