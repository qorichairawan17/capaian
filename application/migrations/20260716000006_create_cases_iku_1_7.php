<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_7 extends CI_Migration
{
    public function up()
    {
        // Drop existing table if structure changed
        if ($this->db->table_exists('cases_iku_1_7')) {
            $this->dbforge->drop_table('cases_iku_1_7', TRUE);
        }

        // --- 1. Create Table ----------------------------------------------
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
            'kategori_kriteria' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'terdakwa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'tanggal_registrasi' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'tanggal_putusan' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'status_rj' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
                'default' => 'Berhasil',
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
        $this->dbforge->create_table('cases_iku_1_7', TRUE);

        $this->_add_index_if_not_exists(
            'cases_iku_1_7',
            'idx_cases_iku17_nomor',
            'ADD UNIQUE INDEX `idx_cases_iku17_nomor` (`nomor_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_7',
            'idx_cases_iku17_status',
            'ADD INDEX `idx_cases_iku17_status` (`status_rj`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_7',
            'idx_cases_iku17_kategori',
            'ADD INDEX `idx_cases_iku17_kategori` (`kategori_kriteria`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_7',
            'idx_cases_iku17_triwulan_tahun',
            'ADD INDEX `idx_cases_iku17_triwulan_tahun` (`triwulan`, `tahun`)'
        );

        // --- 2. Seed Data ------------------------------------------------
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
        $this->dbforge->drop_table('cases_iku_1_7', TRUE);
    }

    private function _seed_data()
    {
        $count = $this->db->count_all('cases_iku_1_7');
        if ($count > 0) {
            return;
        }

        $kategoriOptions = [
            'Tindak Pidana Ringan / Kerugian <= 2.5 Juta',
            'Delik Aduan',
            'Ancaman Hukuman Max 5 Tahun',
            'Anak (Diversi Tidak Berhasil)',
            'Kejahatan Lalu Lintas'
        ];

        $terdakwaList = [
            'Ahmad Fauzi', 'Budi Harjo', 'Chandra Wijaya', 'Dedi Kurniawan',
            'Eko Prasetyo', 'Fajar Ramadhan', 'Gilang Purnama', 'Hendra Setiawan',
            'Irfan Hakim', 'Joko Susanto', 'Kiki Pratama', 'Lukman Hakim'
        ];

        $rows = [];

        for ($i = 1; $i <= 60; $i++) {
            $kategoriKriteria = $kategoriOptions[$i % count($kategoriOptions)];
            $terdakwa = $terdakwaList[$i % count($terdakwaList)];
            $statusRj = ($i % 5 === 0) ? 'Tidak Berhasil' : 'Berhasil';

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 6) % 25) + 1;
            $tahun = 2026;

            $registrasiDateStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $regTime = strtotime($registrasiDateStr);

            $durasiPutusanHari = 15 + ($i % 45);
            $tanggalPutusanStr = date('Y-m-d', strtotime("+$durasiPutusanHari days", $regTime));

            $suffix = ($i % 3 === 0) ? 'Pid.C' : 'Pid.B';
            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 12, $suffix, $tahun);

            $rows[] = [
                'nomor_perkara' => $nomorPerkara,
                'kategori_kriteria' => $kategoriKriteria,
                'terdakwa' => $terdakwa,
                'tanggal_registrasi' => $registrasiDateStr,
                'tanggal_putusan' => $tanggalPutusanStr,
                'status_rj' => $statusRj,
                'triwulan' => $triwulan,
                'tahun' => $tahun,
            ];
        }

        $this->db->insert_batch('cases_iku_1_7', $rows);
    }
}
