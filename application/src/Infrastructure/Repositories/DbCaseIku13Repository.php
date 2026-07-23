<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku13Record;
use App\Domain\Repositories\CaseIku13RepositoryInterface;

/**
 * DbCaseIku13Repository
 *
 * Implementasi konkret dari CaseIku13RepositoryInterface yang menggunakan
 * Case_iku_1_3_model (CI3 Model) sebagai query layer.
 *
 * Tanggung jawab:
 * - Memuat Case_iku_1_3_model via CI instance.
 * - Mendelegasikan query ke model.
 * - Memetakan hasil array mentah → Domain Entity (CaseIku13Record).
 *
 * DILARANG: menulis query $this->db->... langsung di sini.
 */
class DbCaseIku13Repository implements CaseIku13RepositoryInterface
{
    /** @var \CI_Controller */
    private $CI;
    private $mockRepository;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_3_model');
        $this->mockRepository = new MockCaseIku13Repository();
    }

    /**
     * {@inheritdoc}
     *
     * Filter yang didukung:
     *   - 'jenis_perkara' (string): nilai asli 'Pidana' atau 'Perdata'
     *   - 'periode'       (string): 't1' | 't2' | 't3' | 't4' (untuk filter triwulan)
     *
     * @param  array $filters
     * @return CaseIku13Record[]
     */
    public function findAll(array $filters)
    {
        if (!$this->CI->db->table_exists('cases_iku_1_3')) {
            return $this->mockRepository->findAll($filters);
        }

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

        $rows = $this->CI->Case_iku_1_3_model->get_all($modelFilters);

        if (empty($rows)) {
            return $this->mockRepository->findAll($filters);
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    // ─── Private Mapping ──────────────────────────────────────────────────

    /**
     * Petakan satu baris DB (array asosiatif) ke Domain Entity CaseIku13Record.
     *
     * @param  array $row
     * @return CaseIku13Record
     */
    private function mapRowToEntity(array $row)
    {
        return new CaseIku13Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['jenis_perkara'],
            $row['tanggal_minutasi'],
            $row['tanggal_unggah'],
            $row['status_upload'],
            isset($row['url_direktori']) ? $row['url_direktori'] : '',
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
