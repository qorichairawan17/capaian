<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_11 extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'nomor_perkara' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ],
            'nama_terdakwa' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'jenis_pidana' => [
                'type' => 'ENUM',
                'constraint' => ['Pidana Biasa', 'Pidana Singkat', 'Pidana Cepat', 'Pidana Anak'],
                'default' => 'Pidana Biasa',
                'null' => FALSE
            ],
            'metode_pelimpahan' => [
                'type' => 'ENUM',
                'constraint' => ['e-Berpadu', 'Konvensional'],
                'default' => 'e-Berpadu',
                'null' => FALSE
            ],
            'tanggal_pelimpahan' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
            'nomor_register_eberpadu' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'kejaksaan_penuntut' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => FALSE
            ],
            'triwulan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'tahun' => [
                'type' => 'YEAR',
                'null' => FALSE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('cases_iku_1_11', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('cases_iku_1_11', TRUE);
    }
}
