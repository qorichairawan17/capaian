<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_9 extends CI_Migration
{
    private $table = 'cases_iku_1_9';

    public function up()
    {
        if ($this->db->table_exists($this->table)) {
            return;
        }

        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
            ],
            'nomor_perkara' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_anak' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'dakwaan' => [
                'type'       => 'TEXT',
                'null'       => TRUE,
            ],
            'tanggal_diversi' => [
                'type' => 'DATE',
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
            ],
            'status_diversi' => [
                'type'       => 'ENUM',
                'constraint' => ['Berhasil', 'Gagal', 'Tidak Memenuhi Syarat'],
                'default'    => 'Berhasil',
            ],
            'nomor_penetapan_ketua' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => TRUE,
            ],
            'triwulan' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'comment'    => '1=Q1, 2=Q2, 3=Q3, 4=Q4',
            ],
            'tahun' => [
                'type'       => 'YEAR',
                'constraint' => 4,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => NULL,
                'null'    => TRUE,
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => NULL,
                'null'    => TRUE,
            ],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($this->table, TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->table, TRUE);
    }
}
