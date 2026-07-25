<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\IkuTarget;
use App\Domain\Repositories\IkuTargetRepositoryInterface;

/**
 * DbIkuTargetRepository
 *
 * Implementasi konkret dari IkuTargetRepositoryInterface.
 * Mendelegasikan query ke Iku_target_model (CI3 Model),
 * lalu memetakan hasil array mentah → Domain Entity (IkuTarget).
 *
 * DILARANG: menulis query $this->db->... langsung di sini.
 */
class DbIkuTargetRepository implements IkuTargetRepositoryInterface
{
    /** @var \CI_Controller */
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Iku_target_model');
    }

    /**
     * {@inheritdoc}
     */
    public function findByFilters($ikuCode, $tahun, $periodeType)
    {
        $rows = $this->CI->Iku_target_model->get_by_filters($ikuCode, $tahun, $periodeType);

        if (empty($rows)) {
            return [];
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function findOne($ikuCode, $tahun, $periodeType, $periodeValue)
    {
        $row = $this->CI->Iku_target_model->get_one($ikuCode, $tahun, $periodeType, $periodeValue);

        return $row ? $this->mapRowToEntity($row) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function upsert(IkuTarget $target)
    {
        return $this->CI->Iku_target_model->upsert([
            'iku_code'      => $target->getIkuCode(),
            'tahun'         => $target->getTahun(),
            'periode_type'  => $target->getPeriodeType(),
            'periode_value' => $target->getPeriodeValue(),
            'target_value'  => $target->getTargetValue(),
            'created_by'    => $target->getCreatedBy(),
            'updated_by'    => $target->getUpdatedBy(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByYear($tahun)
    {
        $rows = $this->CI->Iku_target_model->get_all_by_year($tahun);

        if (empty($rows)) {
            return [];
        }

        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    // ─── Private Mapping ──────────────────────────────────────────────────

    /**
     * Petakan satu baris DB (array asosiatif) ke Domain Entity IkuTarget.
     *
     * @param  array $row
     * @return IkuTarget
     */
    private function mapRowToEntity(array $row)
    {
        return new IkuTarget(
            isset($row['id']) ? (int) $row['id'] : null,
            $row['iku_code'],
            (int) $row['tahun'],
            $row['periode_type'],
            (int) $row['periode_value'],
            (float) $row['target_value'],
            isset($row['created_by']) ? (int) $row['created_by'] : null,
            isset($row['updated_by']) ? (int) $row['updated_by'] : null,
            isset($row['created_at']) ? $row['created_at'] : null,
            isset($row['updated_at']) ? $row['updated_at'] : null
        );
    }
}
