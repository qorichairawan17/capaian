<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_6 extends CI_Migration
{
    public function up()
    {
        // Drop existing table if structure changed
        if ($this->db->table_exists('cases_iku_1_6')) {
            $this->dbforge->drop_table('cases_iku_1_6', TRUE);
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
            'jenis_eksekusi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
                'default' => 'Eksekusi Terhadap Perkara',
            ],
            'pemohon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'termohon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'tanggal_permohonan' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => TRUE,
            ],
            'status_eksekusi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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
        $this->dbforge->create_table('cases_iku_1_6', TRUE);

        $this->_add_index_if_not_exists(
            'cases_iku_1_6',
            'idx_cases_iku16_nomor',
            'ADD UNIQUE INDEX `idx_cases_iku16_nomor` (`nomor_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_6',
            'idx_cases_iku16_status',
            'ADD INDEX `idx_cases_iku16_status` (`status_eksekusi`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_6',
            'idx_cases_iku16_jenis',
            'ADD INDEX `idx_cases_iku16_jenis` (`jenis_eksekusi`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_6',
            'idx_cases_iku16_triwulan_tahun',
            'ADD INDEX `idx_cases_iku16_triwulan_tahun` (`triwulan`, `tahun`)'
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
        $this->dbforge->drop_table('cases_iku_1_6', TRUE);
    }

    private function _seed_data()
    {
        $count = $this->db->count_all('cases_iku_1_6');
        if ($count > 0) {
            return;
        }

        $pemohonList = ['PT Bank Rakyat Indonesia', 'PT Bank Mandiri', 'H. Ahmad Subardjo', 'CV Maju Bersama', 'PT Central Capital', 'Ir. Budi Santoso'];
        $termohonList = ['CV Karya Mandiri', 'PT Surya Perdana', 'Drs. Hendra Wijaya', 'Siti Rahmawati', 'PT Buana Graha', 'Joko Susilo'];
        $statusOptions = ['Berhasil Eksekusi', 'Berhasil Eksekusi', 'Berhasil Eksekusi', 'Dicabut', 'Dicoret / Non Executable', 'Dalam Proses'];

        $rows = [];

        for ($i = 1; $i <= 60; $i++) {
            $statusEksekusi = $statusOptions[$i % 6];
            $jenisEksekusi = ($i % 3 === 0) ? 'Eksekusi Hak Tanggungan' : 'Eksekusi Terhadap Perkara';

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 5) % 25) + 1;
            $tahun = 2026;

            $permohonanTime = mktime(0, 0, 0, $month, $day, $tahun);
            $tanggalPermohonanStr = date('Y-m-d', $permohonanTime);

            $isDone = ($statusEksekusi !== 'Dalam Proses');
            $tanggalSelesaiStr = $isDone ? date('Y-m-d', strtotime("+" . rand(14, 60) . " days", $permohonanTime)) : null;

            $pemohon = $pemohonList[$i % count($pemohonList)];
            $termohon = $termohonList[$i % count($termohonList)];
            $prefix = ($jenisEksekusi === 'Eksekusi Hak Tanggungan') ? 'Pdt.Eks.HT' : 'Pdt.Eks';
            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 5, $prefix, $tahun);

            $rows[] = [
                'nomor_perkara' => $nomorPerkara,
                'jenis_eksekusi' => $jenisEksekusi,
                'pemohon' => $pemohon,
                'termohon' => $termohon,
                'tanggal_permohonan' => $tanggalPermohonanStr,
                'tanggal_selesai' => $tanggalSelesaiStr,
                'status_eksekusi' => $statusEksekusi,
                'triwulan' => $triwulan,
                'tahun' => $tahun,
            ];
        }

        $this->db->insert_batch('cases_iku_1_6', $rows);
    }
}
