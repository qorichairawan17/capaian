<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku111Record;
use App\Domain\Repositories\CaseIku111RepositoryInterface;

/**
 * DbCaseIku111Repository
 *
 * Implementasi konkret dari CaseIku111RepositoryInterface yang memanggil
 * Case_iku_1_11_model (CI3 Model) sebagai query layer, dilengkapi mock fallback.
 */
class DbCaseIku111Repository implements CaseIku111RepositoryInterface
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_11_model');
    }

    public function findAll(array $filters)
    {
        $modelFilters = [];

        if (!empty($filters['metode_pelimpahan'])) {
            $modelFilters['metode_pelimpahan'] = $filters['metode_pelimpahan'];
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = [];
        try {
            $rows = $this->CI->Case_iku_1_11_model->get_all($modelFilters);
        } catch (\Throwable $e) {
            $rows = [];
        }

        if (empty($rows)) {
            $mockRepo = new MockCaseIku111Repository();
            return $mockRepo->findAll($filters);
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    private function mapRowToEntity(array $row)
    {
        return new CaseIku111Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['nama_terdakwa'],
            $row['jenis_pidana'],
            $row['metode_pelimpahan'],
            $row['tanggal_pelimpahan'],
            $row['nomor_register_eberpadu'],
            $row['kejaksaan_penuntut'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
