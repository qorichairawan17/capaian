<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku14Record;
use App\Domain\Repositories\CaseIku14RepositoryInterface;

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

    public function findAll(array $filters)
    {
        if (!$this->CI->db->table_exists('cases_iku_1_4')) {
            return $this->mockRepository->findAll($filters);
        }

        $modelFilters = [];

        if (!empty($filters['tingkat_peradilan'])) {
            $tingkat = strtolower($filters['tingkat_peradilan']);
            if ($tingkat === 'banding') {
                $modelFilters['tingkat_peradilan'] = 'Banding';
            } else if ($tingkat === 'kasasi') {
                $modelFilters['tingkat_peradilan'] = 'Kasasi';
            } else if ($tingkat === 'pk') {
                $modelFilters['tingkat_peradilan'] = 'PK';
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

    private function mapRowToEntity(array $row)
    {
        return new CaseIku14Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['tingkat_peradilan'],
            $row['metode_pengiriman'],
            $row['tanggal_diterima'],
            $row['tanggal_dikirimkan'],
            (int) $row['durasi_hari'],
            $row['status'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
