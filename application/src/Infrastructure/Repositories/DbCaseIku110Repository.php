<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku110Record;
use App\Domain\Repositories\CaseIku110RepositoryInterface;

/**
 * DbCaseIku110Repository
 *
 * Implementasi konkret dari CaseIku110RepositoryInterface yang memanggil
 * Case_iku_1_10_model (CI3 Model) sebagai query layer, dilengkapi mock fallback.
 */
class DbCaseIku110Repository implements CaseIku110RepositoryInterface
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_10_model');
    }

    public function findAll(array $filters)
    {
        $modelFilters = [];

        if (!empty($filters['metode_pendaftaran'])) {
            $modelFilters['metode_pendaftaran'] = $filters['metode_pendaftaran'];
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = [];
        try {
            $rows = $this->CI->Case_iku_1_10_model->get_all($modelFilters);
        } catch (\Throwable $e) {
            $rows = [];
        }

        if (empty($rows)) {
            $mockRepo = new MockCaseIku110Repository();
            return $mockRepo->findAll($filters);
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    private function mapRowToEntity(array $row)
    {
        return new CaseIku110Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['para_pihak'],
            $row['jenis_perdata'],
            $row['metode_pendaftaran'],
            $row['tanggal_pendaftaran'],
            $row['nomor_register_ecourt'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
