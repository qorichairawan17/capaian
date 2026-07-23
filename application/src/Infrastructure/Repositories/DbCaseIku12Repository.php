<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku12Record;
use App\Domain\Repositories\CaseIku12RepositoryInterface;

/**
 * DbCaseIku12Repository
 *
 * Implementasi konkret dari CaseIku12RepositoryInterface yang menggunakan
 * Case_iku_1_2_model (CI3 Model) sebagai query layer.
 *
 * Tanggung jawab:
 * - Memuat Case_iku_1_2_model via CI instance.
 * - Mendelegasikan query ke model.
 * - Memetakan hasil array mentah → Domain Entity (CaseIku12Record).
 *
 * DILARANG: menulis query $this->db->... langsung di sini.
 */
class DbCaseIku12Repository implements CaseIku12RepositoryInterface
{
    /** @var \CI_Controller */
    private $CI;
    private $mockRepository;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_2_model');
        $this->mockRepository = new MockCaseIku12Repository();
    }

    /**
     * {@inheritdoc}
     *
     * Filter yang didukung:
     *   - 'jenis_perkara' (string): nilai asli 'Pidana' atau 'Perdata'
     *   - 'periode'       (string): 't1' | 't2' | 't3' | 't4' (untuk filter triwulan)
     *
     * @param  array $filters
     * @return CaseIku12Record[]
     */
    public function findAll(array $filters)
    {
        // Cek apakah tabel DB exists
        if (!$this->CI->db->table_exists('cases_iku_1_2')) {
            return $this->mockRepository->findAll($filters);
        }

        // Terjemahkan filter 'periode' (t1..t4) → triwulan (1..4)
        $modelFilters = [];

        if (!empty($filters['jenis_perkara'])) {
            $modelFilters['jenis_perkara'] = ucfirst(strtolower($filters['jenis_perkara']));
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = $this->CI->Case_iku_1_2_model->get_all($modelFilters);

        // Jika DB kosong, gunakan mock repository sebagai fallback data perbandingan
        if (empty($rows)) {
            return $this->mockRepository->findAll($filters);
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    // ─── Private Mapping ──────────────────────────────────────────────────

    /**
     * Petakan satu baris DB (array asosiatif) ke Domain Entity CaseIku12Record.
     *
     * @param  array $row
     * @return CaseIku12Record
     */
    private function mapRowToEntity(array $row)
    {
        return new CaseIku12Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['jenis_perkara'],
            $row['metode_pengiriman'],
            $row['tanggal_putusan'],
            $row['tanggal_pengiriman'],
            (int) $row['jumlah_hari'],
            $row['status'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
