<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_8 extends CI_Migration
{
    public function up()
    {
        // Drop existing table if structure changed
        if ($this->db->table_exists('cases_iku_1_8')) {
            $this->dbforge->drop_table('cases_iku_1_8', TRUE);
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
            'para_pihak' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'mediator' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'jenis_mediator' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
                'default' => 'Mediator Hakim',
            ],
            'tanggal_mediasi' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'hasil_mediasi' => [
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
        $this->dbforge->create_table('cases_iku_1_8', TRUE);

        $this->_add_index_if_not_exists(
            'cases_iku_1_8',
            'idx_cases_iku18_nomor',
            'ADD UNIQUE INDEX `idx_cases_iku18_nomor` (`nomor_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_8',
            'idx_cases_iku18_hasil',
            'ADD INDEX `idx_cases_iku18_hasil` (`hasil_mediasi`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_8',
            'idx_cases_iku18_triwulan_tahun',
            'ADD INDEX `idx_cases_iku18_triwulan_tahun` (`triwulan`, `tahun`)'
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
        $this->dbforge->drop_table('cases_iku_1_8', TRUE);
    }

    private function _seed_data()
    {
        $count = $this->db->count_all('cases_iku_1_8');
        if ($count > 0) {
            return;
        }

        $pihakList = [
            'Siti Aminah / Budi Santoso',
            'PT Maju Bersama / CV Karya Mandiri',
            'H. Abdul Rahman / Drs. Hendra Wijaya',
            'Dewi Lestari / Ahmad Subardjo',
            'Rizky Pratama / PT Bank Mandiri',
            'Ir. Bambang Tri / Joko Susilo'
        ];

        $mediatorHakimList = [
            'Dr. H. Ahmad Yani, S.H., M.H.',
            'Siti Rahmah, S.H., M.H.',
            'Bambang Sujipto, S.H., M.Hum.'
        ];

        $mediatorNonHakimList = [
            'Prof. Dr. Irfan, S.H., C.Med.',
            'Dewi Sartika, S.H., M.Kn., C.Med.',
            'H. Lukman Hakim, S.Ag., M.H., C.Med.'
        ];

        $hasilOptions = [
            'Berhasil Seluruhnya (Akta Perdamaian)',
            'Berhasil Seluruhnya (Akta Perdamaian)',
            'Berhasil Seluruhnya (Pencabutan)',
            'Berhasil Sebagian',
            'Tidak Berhasil',
            'Tidak Dapat Dilaksanakan'
        ];

        $rows = [];

        for ($i = 1; $i <= 60; $i++) {
            $paraPihak = $pihakList[$i % count($pihakList)];
            
            $isHakim = ($i % 2 === 0);
            $jenisMediator = $isHakim ? 'Mediator Hakim' : 'Mediator Non-Hakim';
            $mediator = $isHakim 
                ? $mediatorHakimList[$i % count($mediatorHakimList)] 
                : $mediatorNonHakimList[$i % count($mediatorNonHakimList)];

            $hasilMediasi = $hasilOptions[$i % count($hasilOptions)];

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 5) % 25) + 1;
            $tahun = 2026;

            $tanggalMediasiStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $medTime = strtotime($tanggalMediasiStr);

            $durasiHari = 7 + ($i % 21);
            $tanggalSelesaiStr = date('Y-m-d', strtotime("+$durasiHari days", $medTime));

            $nomorPerkara = sprintf('%d/Pdt.G/%04d/PN.Cpn', $i + 15, $tahun);

            $rows[] = [
                'nomor_perkara' => $nomorPerkara,
                'para_pihak' => $paraPihak,
                'mediator' => $mediator,
                'jenis_mediator' => $jenisMediator,
                'tanggal_mediasi' => $tanggalMediasiStr,
                'tanggal_selesai' => $tanggalSelesaiStr,
                'hasil_mediasi' => $hasilMediasi,
                'triwulan' => $triwulan,
                'tahun' => $tahun,
            ];
        }

        $this->db->insert_batch('cases_iku_1_8', $rows);
    }
}
