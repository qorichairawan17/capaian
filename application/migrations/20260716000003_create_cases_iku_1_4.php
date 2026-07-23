<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_4 extends CI_Migration
{
    public function up()
    {
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
            'jenis_pengajuan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ],
            'tanggal_pengajuan' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'pembanding' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'terbanding' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'status_ecourt' => [
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
            'idx_cases_iku14_pengajuan',
            'ADD INDEX `idx_cases_iku14_pengajuan` (`jenis_pengajuan`)'
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

        $pembandingList = [
            'PT Bank Central Nusantara',
            'H. Bambang Sugiarto',
            'CV Tri Jaya Mandiri',
            'Drs. Irwan Wijaya',
            'Siti Rahmawati, S.H.',
            'PT Graha Pembangunan',
            'Koperasi Simpan Pinjam Sejahtera',
            'Dr. Hendra Saputra'
        ];

        $terbandingList = [
            'Dinas Perumahan Rakyat & Kawasan Pemukiman',
            'Hj. Nurul Hasanah',
            'PT Asuransi Jiwa Utama',
            'Budi Santoso',
            'CV Sukses Bersama',
            'Ahmad Fauzi',
            'PT Citra Perdana',
            'Yayasan Pendidikan Bangsa'
        ];

        $rows = [];

        for ($i = 1; $i <= 60; $i++) {
            $isECourt = ($i % 5 !== 0);
            $jenisPengajuan = $isECourt ? 'e-Court' : 'Konvensional';
            $statusECourt = $isECourt ? 'e-Court Active' : 'Konvensional';

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 7) % 28) + 1;
            $tahun = 2026;

            $pengajuanStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $nomorPerkara = sprintf('%d/PDT/%04d/PT.Cpn', $i + 15, $tahun);

            $rows[] = [
                'nomor_perkara' => $nomorPerkara,
                'jenis_pengajuan' => $jenisPengajuan,
                'tanggal_pengajuan' => $pengajuanStr,
                'pembanding' => $pembandingList[$i % count($pembandingList)],
                'terbanding' => $terbandingList[$i % count($terbandingList)],
                'status_ecourt' => $statusECourt,
                'triwulan' => $triwulan,
                'tahun' => $tahun,
            ];
        }

        $this->db->insert_batch('cases_iku_1_4', $rows);
    }
}
