<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\IkuTarget;

/**
 * IkuTargetRepositoryInterface
 *
 * Kontrak akses data untuk target IKU.
 * Implementasi konkret di Infrastructure layer.
 */
interface IkuTargetRepositoryInterface
{
    /**
     * Ambil semua target berdasarkan kode IKU, tahun, dan tipe periode.
     *
     * @param string $ikuCode
     * @param int    $tahun
     * @param string $periodeType
     * @return IkuTarget[]
     */
    public function findByFilters($ikuCode, $tahun, $periodeType);

    /**
     * Ambil satu target spesifik.
     *
     * @param string $ikuCode
     * @param int    $tahun
     * @param string $periodeType
     * @param int    $periodeValue
     * @return IkuTarget|null
     */
    public function findOne($ikuCode, $tahun, $periodeType, $periodeValue);

    /**
     * Insert atau update target (upsert).
     *
     * @param IkuTarget $target
     * @return bool
     */
    public function upsert(IkuTarget $target);

    /**
     * Ambil semua target untuk tahun tertentu.
     *
     * @param int $tahun
     * @return IkuTarget[]
     */
    public function findAllByYear($tahun);
}
