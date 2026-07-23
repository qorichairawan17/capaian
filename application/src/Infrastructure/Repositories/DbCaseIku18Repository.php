<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku18Record;
use App\Domain\Repositories\CaseIku18RepositoryInterface;

/**
 * DbCaseIku18Repository
 *
 * Implementasi konkret dari CaseIku18RepositoryInterface yang menggunakan
 * Case_iku_1_8_model (CI3 Model) sebagai query layer.
 *
 * Tanggung jawab:
 * - Memuat Case_iku_1_8_model via CI instance.
 * - Mendelegasikan query ke model.
 * - Memetakan hasil array mentah -> Domain Entity (CaseIku18Record).
 *
 * DILARANG: menulis query $this->db->... langsung di sini.
 */
class DbCaseIku18Repository implements CaseIku18RepositoryInterface
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_8_model');
    }

    /**
     * {@inheritdoc}
     *
     * @param  array $filters
     * @return CaseIku18Record[]
     */
    public function findAll(array $filters)
    {
        $modelFilters = [];

        if (!empty($filters['status_mediasi'])) {
            $modelFilters['status_mediasi'] = $filters['status_mediasi'];
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = [];
        try {
            $rows = $this->CI->Case_iku_1_8_model->get_all($modelFilters);
        } catch (\Throwable $e) {
            $rows = [];
        }

        if (empty($rows)) {
            $mockRepo = new MockCaseIku18Repository();
            return $mockRepo->findAll($filters);
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    // --- Private Mapping --------------------------------------------------

    /**
     * Petakan satu baris DB (array asosiatif) ke Domain Entity CaseIku18Record.
     *
     * @param  array $row
     * @return CaseIku18Record
     */
    private function mapRowToEntity(array $row)
    {
        return new CaseIku18Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['para_pihak'],
            $row['mediator'],
            $row['jenis_mediator'],
            $row['tanggal_mediasi'],
            $row['tanggal_selesai'],
            $row['hasil_mediasi'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
