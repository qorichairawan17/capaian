<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku17Record;
use App\Domain\Repositories\CaseIku17RepositoryInterface;

/**
 * DbCaseIku17Repository
 *
 * Implementasi konkret dari CaseIku17RepositoryInterface yang menggunakan
 * Case_iku_1_7_model (CI3 Model) sebagai query layer.
 *
 * Tanggung jawab:
 * - Memuat Case_iku_1_7_model via CI instance.
 * - Mendelegasikan query ke model.
 * - Memetakan hasil array mentah -> Domain Entity (CaseIku17Record).
 *
 * DILARANG: menulis query $this->db->... langsung di sini.
 */
class DbCaseIku17Repository implements CaseIku17RepositoryInterface
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Case_iku_1_7_model');
    }

    /**
     * {@inheritdoc}
     *
     * @param  array $filters
     * @return CaseIku17Record[]
     */
    public function findAll(array $filters)
    {
        $modelFilters = [];

        if (!empty($filters['kategori_kriteria'])) {
            $modelFilters['kategori_kriteria'] = $filters['kategori_kriteria'];
        }

        if (!empty($filters['status_rj'])) {
            $modelFilters['status_rj'] = $filters['status_rj'];
        }

        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $modelFilters['triwulan'] = (int) $matches[1];
            }
        }

        $rows = $this->CI->Case_iku_1_7_model->get_all($modelFilters);

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    // --- Private Mapping --------------------------------------------------

    /**
     * Petakan satu baris DB (array asosiatif) ke Domain Entity CaseIku17Record.
     *
     * @param  array $row
     * @return CaseIku17Record
     */
    private function mapRowToEntity(array $row)
    {
        return new CaseIku17Record(
            (int) $row['id'],
            $row['nomor_perkara'],
            $row['kategori_kriteria'],
            $row['terdakwa'],
            $row['tanggal_registrasi'],
            $row['tanggal_putusan'],
            $row['status_rj'],
            (int) $row['triwulan'],
            (int) $row['tahun']
        );
    }
}
