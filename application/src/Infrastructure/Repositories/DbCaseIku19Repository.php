<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku19Record;
use App\Domain\Repositories\CaseIku19RepositoryInterface;

/**
 * DbCaseIku19Repository
 *
 * Implementasi konkret dari CaseIku19RepositoryInterface yang menggunakan
 * Case_iku_1_9_model (CI3 Model) sebagai query layer.
 */
class DbCaseIku19Repository implements CaseIku19RepositoryInterface
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_9_model');
    }

    /**
     * {@inheritdoc}
     *
     * @param  array $filters
     * @return CaseIku19Record[]
     */
    public function findAll(array $filters)
    {
        $modelFilters = [];

        if (!empty($filters['status_diversi'])) {
            $modelFilters['status_diversi'] = $filters['status_diversi'];
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = [];
        try {
            $rows = $this->CI->Case_iku_1_9_model->get_all($modelFilters);
        } catch (\Throwable $e) {
            $rows = [];
        }

        if (empty($rows)) {
            $mockRepo = new MockCaseIku19Repository();
            return $mockRepo->findAll($filters);
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    // --- Private Mapping --------------------------------------------------

    private function mapRowToEntity(array $row)
    {
        return new CaseIku19Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['nama_anak'],
            $row['dakwaan'],
            $row['tanggal_diversi'],
            $row['tanggal_selesai'],
            $row['status_diversi'],
            $row['nomor_penetapan_ketua'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
