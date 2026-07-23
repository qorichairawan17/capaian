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
                'null' => TRUE
            ),
            'role' => array(
                'type' => "ENUM('admin', 'operator')",
                'default' => 'operator',
                'null' => FALSE
            ),
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ));

        // Tentukan Primary Key
        $this->dbforge->add_key('id', TRUE);

        // Buat tabel 'users'
        // Parameter kedua TRUE digunakan untuk menambahkan IF NOT EXISTS
        $this->dbforge->create_table('users', TRUE);

        // Menambahkan Unique index untuk username (Standard MariaDB) jika belum ada
        $indexQuery = $this->db->query("SHOW INDEX FROM `users` WHERE Key_name = 'idx_users_username'");
        if ($indexQuery && $indexQuery->num_rows() === 0) {
            $this->db->query('ALTER TABLE `users` ADD UNIQUE INDEX `idx_users_username` (`username`)');
        }

        // Jalankan ALTER TABLE jika kolom belum ada pada tabel users yang sudah ada
        if (!$this->db->field_exists('email', 'users')) {
            $this->db->query("ALTER TABLE `users` ADD COLUMN `email` VARCHAR(100) NULL AFTER `name`");
        }

        if (!$this->db->field_exists('role', 'users')) {
            $this->db->query("ALTER TABLE `users` ADD COLUMN `role` ENUM('admin', 'operator') NOT NULL DEFAULT 'operator' AFTER `email`");
        }

        if (!$this->db->field_exists('created_at', 'users')) {
            $this->db->query("ALTER TABLE `users` ADD COLUMN `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `role`");
        }

        // Tambahkan user default admin jika belum ada
        $checkAdmin = $this->db->get_where('users', array('username' => 'admin'), 1);
        if ($checkAdmin->num_rows() === 0) {
            $passwordHash = password_hash('password123', PASSWORD_BCRYPT);
            $data = array(
                'username' => 'admin',
                'password' => $passwordHash,
                'name'     => 'Administrator',
                'email'    => 'admin@example.com',
                'role'     => 'admin'
            );
            $this->db->insert('users', $data);
        }
    }

    public function down()
    {
        $this->dbforge->drop_table('users', TRUE);
    }
}
