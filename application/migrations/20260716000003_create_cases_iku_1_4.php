<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_4 extends CI_Migration
{
    public function up()
    {
        // Drop existing table if structure changed
        if ($this->db->table_exists('cases_iku_1_4')) {
            $this->dbforge->drop_table('cases_iku_1_4', TRUE);
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
            'tingkat_peradilan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ],
            'metode_pengiriman' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ],
            'tanggal_diterima' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'tanggal_dikirimkan' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'durasi_hari' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => FALSE,
                'default' => 0,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
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
        $this->dbforge->create_table('cases_iku_1_4', TRUE);

        $this->_add_index_if_not_exists(
            'cases_iku_1_4',
            'idx_cases_iku14_nomor',
            'ADD UNIQUE INDEX `idx_cases_iku14_nomor` (`nomor_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_4',
            'idx_cases_iku14_tingkat',
            'ADD INDEX `idx_cases_iku14_tingkat` (`tingkat_peradilan`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_4',
            'idx_cases_iku14_triwulan_tahun',
            'ADD INDEX `idx_cases_iku14_triwulan_tahun` (`triwulan`, `tahun`)'
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
        $this->dbforge->drop_table('cases_iku_1_4', TRUE);
    }

    private function _seed_data()
    {
        $count = $this->db->count_all('cases_iku_1_4');
        if ($count > 0) {
            return;
        }

        $tingkatList = ['Banding', 'Kasasi', 'PK'];
        $metodeList = ['Jurusita', 'Elektronik', 'Surat Tercatat'];
        $rows = [];

        for ($i = 1; $i <= 60; $i++) {
            $tingkatPeradilan = $tingkatList[$i % 3];
            $metodePengiriman = $metodeList[$i % 3];

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 5) % 25) + 1;
            $tahun = 2026;

            $diterimaTime = mktime(0, 0, 0, $month, $day, $tahun);
            $tanggalDiterimaStr = date('Y-m-d', $diterimaTime);

            $isTepat = ($i % 7 !== 0);
            $durasiHari = $isTepat ? rand(0, 2) : rand(4, 8);
            $status = $isTepat ? 'Tepat Waktu' : 'Terlambat';

            $dikirimkanTime = strtotime("+{$durasiHari} days", $diterimaTime);
            $tanggalDikirimkanStr = date('Y-m-d', $dikirimkanTime);

            $suffix = ($i % 3 === 0) ? 'Pid.Sus' : 'Pid.B';
            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 15, $suffix, $tahun);

            $rows[] = [
                'nomor_perkara' => $nomorPerkara,
                'tingkat_peradilan' => $tingkatPeradilan,
                'metode_pengiriman' => $metodePengiriman,
                'tanggal_diterima' => $tanggalDiterimaStr,
                'tanggal_dikirimkan' => $tanggalDikirimkanStr,
                'durasi_hari' => $durasiHari,
                'status' => $status,
                'triwulan' => $triwulan,
                'tahun' => $tahun,
            ];
        }

        $this->db->insert_batch('cases_iku_1_4', $rows);
    }
}
