<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_1 extends CI_Migration
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
            'jenis_perkara' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE,
            ],
            'klasifikasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ],
            'tanggal_pendaftaran' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'tanggal_putusan' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'tanggal_minutasi' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'jumlah_hari' => [
                'type' => 'INT',
                'constraint' => 6,
                'null' => FALSE,
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
        $this->dbforge->create_table('cases_iku_1_1', TRUE);

        // Unique index on nomor_perkara
        // Tambahkan index hanya jika belum ada (idempotent — aman dijalankan ulang)
        $this->_add_index_if_not_exists(
            'cases_iku_1_1',
            'idx_cases_nomor_perkara',
            'ADD UNIQUE INDEX `idx_cases_nomor_perkara` (`nomor_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_1',
            'idx_cases_jenis',
            'ADD INDEX `idx_cases_jenis` (`jenis_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_1',
            'idx_cases_triwulan_tahun',
            'ADD INDEX `idx_cases_triwulan_tahun` (`triwulan`, `tahun`)'
        );

        // ─── 2. Seed Data (idempotent — skip jika sudah ada data) ────────
        $this->_seed_data();
    }

    // ─── Helper: tambah index hanya jika belum ada ─────────────────────────
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
        $this->dbforge->drop_table('cases_iku_1_1', TRUE);
    }

    // ─── Private: Seed 60 Realistic Case Records ──────────────────────────
    private function _seed_data()
    {
        // Idempotent: skip jika data sudah ada (misal sudah di-seed via run_migration.php)
        $count = $this->db->count_all('cases_iku_1_1');
        if ($count > 0) {
            return;
        }

        $pidanaClassifications = [
            'Pencurian dengan Pemberatan',
            'Penganiayaan Ringan',
            'Penyalahgunaan Narkotika',
            'Pelanggaran Lalu Lintas',
            'Penipuan Kontrak Kerja',
            'Penggelapan dalam Jabatan',
            'Pengeroyokan',
            'KDRT (Kekerasan Dalam Rumah Tangga)',
        ];

        $perdataClassifications = [
            'Wanprestasi Perjanjian Kredit',
            'Perbuatan Melawan Hukum (Sengketa Lahan)',
            'Cerai Gugat',
            'Cerai Talak',
            'Pembagian Harta Bersama',
            'Gugatan Sederhana Wanprestasi',
            'Permohonan Ganti Nama',
            'Sengketa Waris',
        ];

        $rows = [];

        for ($i = 1; $i <= 60; $i++) {
            // Jenis Perkara
            $isPidana = ($i % 2 === 0);
            $jenisPerkara = $isPidana ? 'Pidana' : 'Perdata';

            if ($isPidana) {
                $klasifikasi = $pidanaClassifications[$i % count($pidanaClassifications)];
                $suffix = ($i % 4 === 0) ? 'Pid.Sus' : 'Pid.B';
            } else {
                $klasifikasi = $perdataClassifications[$i % count($perdataClassifications)];
                $suffix = ($i % 3 === 0) ? 'Pdt.P' : 'Pdt.G';
            }

            // Quarter distribution (1–4)
            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 7) % 28) + 1;
            $tahun = 2026;

            $registrasiStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $registrasiDateTime = new DateTime($registrasiStr);

            // Duration: "slow" cases take 140–165 days, normal 10–105 days
            $isSlow = ($i % 7 === 0);
            $durasiPutusan = $isSlow ? 140 + ($i % 26) : 10 + (($i * 17) % 96);

            $putusanDateTime = clone $registrasiDateTime;
            $putusanDateTime->modify("+$durasiPutusan days");
            $tanggalPutusan = $putusanDateTime->format('Y-m-d');

            $durasiMinutasi = 1 + ($i % 7);
            $minutasiDateTime = clone $putusanDateTime;
            $minutasiDateTime->modify("+$durasiMinutasi days");
            $tanggalMinutasi = $minutasiDateTime->format('Y-m-d');

            $jumlahHari = $registrasiDateTime->diff($minutasiDateTime)->days;

            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 10, $suffix, $tahun);

            // SEMA No.2 Tahun 2014 – batas 5 bulan / 150 hari
            $status = ($jumlahHari <= 150) ? 'Tepat Waktu' : 'Terlambat';

            $rows[] = [
                'nomor_perkara' => $nomorPerkara,
                'jenis_perkara' => $jenisPerkara,
                'klasifikasi' => $klasifikasi,
                'tanggal_pendaftaran' => $registrasiStr,
                'tanggal_putusan' => $tanggalPutusan,
                'tanggal_minutasi' => $tanggalMinutasi,
                'jumlah_hari' => $jumlahHari,
                'status' => $status,
                'triwulan' => $triwulan,
                'tahun' => $tahun,
            ];
        }

        $this->db->insert_batch('cases_iku_1_1', $rows);
    }
}
