<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku15Record;
use App\Domain\Repositories\CaseIku15RepositoryInterface;

class DbCaseIku15Repository implements CaseIku15RepositoryInterface
{
    /** @var \CI_Controller */
    private $CI;
    private $mockRepository;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_5_model');
        $this->mockRepository = new MockCaseIku15Repository();
    }

    public function findAll(array $filters)
    {
        if (!$this->CI->db->table_exists('cases_iku_1_5')) {
            return $this->mockRepository->findAll($filters);
        }

        $modelFilters = [];

        if (!empty($filters['jenis_perkara'])) {
            $jenis = strtolower($filters['jenis_perkara']);
            if ($jenis === 'pidana') {
                $modelFilters['jenis_perkara'] = 'Pidana';
            } else if ($jenis === 'perdata') {
                $modelFilters['jenis_perkara'] = 'Perdata';
            }
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = $this->CI->Case_iku_1_5_model->get_all($modelFilters);

        if (empty($rows)) {
            return $this->mockRepository->findAll($filters);
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    private function mapRowToEntity(array $row)
    {
        return new CaseIku15Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['jenis_perkara'],
            $row['tanggal_minutasi'],
            $row['tanggal_unggah'],
            $row['status_upload'],
            $row['url_direktori'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
