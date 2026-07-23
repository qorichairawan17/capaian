<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cases_iku_1_2 extends CI_Migration
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
            'metode_pengiriman' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
            ],
            'tanggal_putusan' => [
                'type' => 'DATE',
                'null' => FALSE,
            ],
            'tanggal_pengiriman' => [
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
        $this->dbforge->create_table('cases_iku_1_2', TRUE);

        $this->_add_index_if_not_exists(
            'cases_iku_1_2',
            'idx_cases_iku12_nomor',
            'ADD UNIQUE INDEX `idx_cases_iku12_nomor` (`nomor_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_2',
            'idx_cases_iku12_jenis',
            'ADD INDEX `idx_cases_iku12_jenis` (`jenis_perkara`)'
        );
        $this->_add_index_if_not_exists(
            'cases_iku_1_2',
            'idx_cases_iku12_triwulan_tahun',
            'ADD INDEX `idx_cases_iku12_triwulan_tahun` (`triwulan`, `tahun`)'
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
        $this->dbforge->drop_table('cases_iku_1_2', TRUE);
    }

    private function _seed_data()
    {
        $count = $this->db->count_all('cases_iku_1_2');
        if ($count > 0) {
            return;
        }

        $rows = [];

        for ($i = 1; $i <= 60; $i++) {
            $isPidana = ($i % 2 === 0);
            $jenisPerkara = $isPidana ? 'Pidana' : 'Perdata';
            $suffix = $isPidana ? (($i % 4 === 0) ? 'Pid.Sus' : 'Pid.B') : (($i % 3 === 0) ? 'Pdt.P' : 'Pdt.G');

            $isElektronik = ($i % 3 !== 0);
            $metodePengiriman = $isElektronik ? 'Elektronik (SIP)' : 'Pihak Ketiga (Pos/Ekspedisi)';

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 7) % 28) + 1;
            $tahun = 2026;

            $putusanStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $putusanDateTime = new DateTime($putusanStr);

            $isLate = ($i % 6 === 0);
            $durasiHari = $isLate ? (16 + ($i % 12)) : (1 + ($i % 13));

            $pengirimanDateTime = clone $putusanDateTime;
            $pengirimanDateTime->modify("+$durasiHari days");
            $tanggalPengiriman = $pengirimanDateTime->format('Y-m-d');

            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 10, $suffix, $tahun);
            $status = ($durasiHari <= 14) ? 'Tepat Waktu' : 'Terlambat';

            $rows[] = [
                'nomor_perkara' => $nomorPerkara,
                'jenis_perkara' => $jenisPerkara,
                'metode_pengiriman' => $metodePengiriman,
                'tanggal_putusan' => $putusanStr,
                'tanggal_pengiriman' => $tanggalPengiriman,
                'jumlah_hari' => $durasiHari,
                'status' => $status,
                'triwulan' => $triwulan,
                'tahun' => $tahun,
            ];
        }

        $this->db->insert_batch('cases_iku_1_2', $rows);
    }
}
