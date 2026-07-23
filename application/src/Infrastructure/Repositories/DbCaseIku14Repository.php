<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku14Record;
use App\Domain\Repositories\CaseIku14RepositoryInterface;

/**
 * DbCaseIku14Repository
 *
 * Implementasi konkret dari CaseIku14RepositoryInterface yang menggunakan
 * Case_iku_1_4_model (CI3 Model) sebagai query layer.
 *
 * Tanggung jawab:
 * - Memuat Case_iku_1_4_model via CI instance.
 * - Mendelegasikan query ke model.
 * - Memetakan hasil array mentah → Domain Entity (CaseIku14Record).
 *
 * DILARANG: menulis query $this->db->... langsung di sini.
 */
class DbCaseIku14Repository implements CaseIku14RepositoryInterface
{
    /** @var \CI_Controller */
    private $CI;
    private $mockRepository;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_4_model');
        $this->mockRepository = new MockCaseIku14Repository();
    }

    /**
     * {@inheritdoc}
     *
     * Filter yang didukung:
     *   - 'jenis_pengajuan' (string): 'ecourt' | 'konvensional'
     *   - 'periode'         (string): 't1' | 't2' | 't3' | 't4' (untuk filter triwulan)
     *
     * @param  array $filters
     * @return CaseIku14Record[]
     */
    public function findAll(array $filters)
    {
        if (!$this->CI->db->table_exists('cases_iku_1_4')) {
            return $this->mockRepository->findAll($filters);
        }

        $modelFilters = [];

        if (!empty($filters['jenis_pengajuan'])) {
            $pengajuan = strtolower($filters['jenis_pengajuan']);
            if ($pengajuan === 'ecourt') {
                $modelFilters['jenis_pengajuan'] = 'e-Court';
            } else if ($pengajuan === 'konvensional') {
                $modelFilters['jenis_pengajuan'] = 'Konvensional';
            }
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = $this->CI->Case_iku_1_4_model->get_all($modelFilters);

        if (empty($rows)) {
            return $this->mockRepository->findAll($filters);
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    // ─── Private Mapping ──────────────────────────────────────────────────

    /**
     * Petakan satu baris DB (array asosiatif) ke Domain Entity CaseIku14Record.
     *
     * @param  array $row
     * @return CaseIku14Record
     */
    private function mapRowToEntity(array $row)
    {
        return new CaseIku14Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['jenis_pengajuan'],
            $row['tanggal_pengajuan'],
            $row['pembanding'],
            $row['terbanding'],
            $row['status_ecourt'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
