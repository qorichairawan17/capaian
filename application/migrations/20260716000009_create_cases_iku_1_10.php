<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_10 extends CI_Migration
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
            'para_pihak' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'jenis_perdata' => [
                'type' => 'ENUM',
                'constraint' => ['Gugatan', 'Permohonan', 'Gugatan Sederhana'],
                'default' => 'Gugatan',
                'null' => FALSE
            ],
            'metode_pendaftaran' => [
                'type' => 'ENUM',
                'constraint' => ['e-Court', 'Konvensional'],
                'default' => 'e-Court',
                'null' => FALSE
            ],
            'tanggal_pendaftaran' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
            'nomor_register_ecourt' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
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
        $this->dbforge->create_table('cases_iku_1_10', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('cases_iku_1_10', TRUE);
    }
}
