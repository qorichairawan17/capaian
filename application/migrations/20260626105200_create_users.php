<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            // Menggunakan raw string untuk timestamp default MariaDB
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ));

        // Tentukan Primary Key
        $this->dbforge->add_key('id', TRUE);

        // Buat tabel 'users'
        // Parameter kedua TRUE digunakan untuk menambahkan IF NOT EXISTS
        $this->dbforge->create_table('users', TRUE);

        // Menambahkan Unique index untuk username dan email (Standard MariaDB)
        $this->db->query('ALTER TABLE `users` ADD UNIQUE INDEX `idx_users_username` (`username`)');
        $this->db->query('ALTER TABLE `users` ADD UNIQUE INDEX `idx_users_email` (`email`)');
    }

    public function down()
    {
        $this->dbforge->drop_table('users', TRUE);
    }
}
