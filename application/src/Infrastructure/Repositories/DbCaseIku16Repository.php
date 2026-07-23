<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku16Record;
use App\Domain\Repositories\CaseIku16RepositoryInterface;

class DbCaseIku16Repository implements CaseIku16RepositoryInterface
{
    /** @var \CI_Controller */
    private $CI;
    private $mockRepository;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_6_model');
        $this->mockRepository = new MockCaseIku16Repository();
    }

    public function findAll(array $filters)
    {
        if (!$this->CI->db->table_exists('cases_iku_1_6')) {
            return $this->mockRepository->findAll($filters);
        }

        $modelFilters = [];

        if (!empty($filters['status_eksekusi'])) {
            $modelFilters['status_eksekusi'] = $filters['status_eksekusi'];
        }

        if (!empty($filters['jenis_eksekusi'])) {
            $modelFilters['jenis_eksekusi'] = $filters['jenis_eksekusi'];
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = $this->CI->Case_iku_1_6_model->get_all($modelFilters);

        if (empty($rows)) {
            return $this->mockRepository->findAll($filters);
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    private function mapRowToEntity(array $row)
    {
        return new CaseIku16Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            isset($row['jenis_eksekusi']) ? $row['jenis_eksekusi'] : 'Eksekusi Terhadap Perkara',
            $row['pemohon'],
            $row['termohon'],
            $row['tanggal_permohonan'],
            $row['tanggal_selesai'],
            $row['status_eksekusi'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
