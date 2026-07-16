<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseRecord;
use App\Domain\Repositories\CaseRepositoryInterface;

/**
 * DbCaseRepository
 *
 * Implementasi konkret dari CaseRepositoryInterface yang menggunakan
 * Case_iku_1_1_model (CI3 Model) sebagai query layer.
 *
 * Tanggung jawab:
 * - Memuat Case_iku_1_1_model via CI instance.
 * - Mendelegasikan query ke model.
 * - Memetakan hasil array mentah → Domain Entity (CaseRecord).
 *
 * DILARANG: menulis query $this->db->... langsung di sini.
 */
class DbCaseRepository implements CaseRepositoryInterface
{
    /** @var \CI_Controller */
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_1_model');
    }

    /**
     * {@inheritdoc}
     *
     * Filter yang didukung:
     *   - 'jenis_perkara' (string): nilai asli 'Pidana' atau 'Perdata'
     *   - 'periode'       (string): 't1' | 't2' | 't3' | 't4' (untuk filter triwulan)
     *
     * @param  array $filters
     * @return CaseRecord[]
     */
    public function findAll(array $filters): array
    {
        // Terjemahkan filter 'periode' (t1..t4) → triwulan (1..4)
        $modelFilters = [];

        if (!empty($filters['jenis_perkara'])) {
            // Normalise ke Title Case sesuai nilai DB ('Pidana' / 'Perdata')
            $modelFilters['jenis_perkara'] = ucfirst(strtolower($filters['jenis_perkara']));
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = $this->CI->Case_iku_1_1_model->get_all($modelFilters);

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    // ─── Private Mapping ──────────────────────────────────────────────────

    /**
     * Petakan satu baris DB (array asosiatif) ke Domain Entity CaseRecord.
     *
     * @param  array $row
     * @return CaseRecord
     */
    private function mapRowToEntity(array $row): CaseRecord
    {
        return new CaseRecord(
            (int)    $row['id'],
                     $row['nomor_perkara'],
                     $row['jenis_perkara'],
                     $row['klasifikasi'] ?? '',
                     $row['tanggal_pendaftaran'],
                     $row['tanggal_putusan'],
                     $row['tanggal_minutasi'],
            (int)    $row['jumlah_hari'],
                     $row['status'],
            (int)    $row['triwulan'],
            (int)    $row['tahun']
        );
    }
}
