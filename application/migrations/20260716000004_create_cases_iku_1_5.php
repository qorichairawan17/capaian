<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_5 extends CI_Migration
{
    public function up()
    {
        // Drop existing table if structure changed
        if ($this->db->table_exists('cases_iku_1_5')) {
            $this->dbforge->drop_table('cases_iku_1_5', TRUE);
        }

        // ─── 1. Create Table ──────────────────────────────────────────────
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'nomor_perkara' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
            ],
            'jenis_perkara' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ],
            'tanggal_minutasi' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'tanggal_unggah' => [
                'type' => 'DATE',
                'null' => TRUE,
            ],
            'status_upload' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ],
            'url_direktori' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ],
            'triwulan' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
            ],
            'tahun' => [
                'type' => 'SMALLINT',
                'constraint' => 4,
                'unsigned' => TRUE,
                'null' => FALSE,
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('cases_iku_1_5', TRUE);

        $this->_add_index_if_not_exists(
            'cases_iku_1_5',
            'idx_cases_iku15_nomor',
            'ADD UNIQUE INDEX `idx_cases_iku15_nomor` (`nomor_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_5',
            'idx_cases_iku15_jenis',
            'ADD INDEX `idx_cases_iku15_jenis` (`jenis_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_5',
            'idx_cases_iku15_triwulan_tahun',
            'ADD INDEX `idx_cases_iku15_triwulan_tahun` (`triwulan`, `tahun`)'
        );

        // ─── 2. Seed Data ────────────────────────────────────────────────
        $this->_seed_data();
    }

    private function _add_index_if_not_exists($table, $indexName, $addClause)
    {
        $query = $this->db->query("SHOW INDEX FROM `{$table}`");
        $exists = FALSE;
        if ($query) {
            foreach ($query->result_array() as $row) {
                $key = isset($row['Key_name']) ? $row['Key_name'] : (isset($row['key_name']) ? $row['key_name'] : null);
                if ($key !== null && strcasecmp($key, $indexName) === 0) {
                    $exists = TRUE;
                    break;
                }
            }
        }
        if (!$exists) {
            $this->db->query("ALTER TABLE `{$table}` {$addClause}");
        }
    }

    public function down()
    {
        $this->dbforge->drop_table('cases_iku_1_5', TRUE);
    }

    private function _seed_data()
    {
        $count = $this->db->count_all('cases_iku_1_5');
        if ($count > 0) {
            return;
        }

        $rows = [];

        for ($i = 1; $i <= 60; $i++) {
            $isPidana = ($i % 2 === 0);
            $jenisPerkara = $isPidana ? 'Pidana' : 'Perdata';

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 5) % 25) + 1;
            $tahun = 2026;

            $minutasiTime = mktime(0, 0, 0, $month, $day, $tahun);
            $tanggalMinutasiStr = date('Y-m-d', $minutasiTime);

            $isUploaded = ($i % 10 !== 0);
            $statusUpload = $isUploaded ? 'Diunggah' : 'Belum Diunggah';

            $tanggalUnggahStr = $isUploaded ? date('Y-m-d', strtotime("+" . rand(0, 1) . " days", $minutasiTime)) : null;
            $urlDirektori = $isUploaded ? "https://putusan3.mahkamahagung.go.id/direktori/putusan/doc{$i}.html" : null;

            $prefix = $isPidana ? 'Pid.B' : 'Pdt.G';
            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 10, $prefix, $tahun);

            $rows[] = [
                'nomor_perkara' => $nomorPerkara,
                'jenis_perkara' => $jenisPerkara,
                'tanggal_minutasi' => $tanggalMinutasiStr,
                'tanggal_unggah' => $tanggalUnggahStr,
                'status_upload' => $statusUpload,
                'url_direktori' => $urlDirektori,
                'triwulan' => $triwulan,
                'tahun' => $tahun,
            ];
        }

        $this->db->insert_batch('cases_iku_1_5', $rows);
    }
}
