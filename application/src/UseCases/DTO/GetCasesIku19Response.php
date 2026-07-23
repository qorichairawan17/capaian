<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku19Record;

class GetCasesIku19Response
{
    /** @var CaseIku19Record[] */
    private $cases;
    private $totalSelesaiDiversiCount;
    private $berhasilDiversiCount;
    private $gagalDiversiCount;
    private $persentaseBerhasilDiversi;

    public function __construct(
        array $cases,
        $totalSelesaiDiversiCount,
        $berhasilDiversiCount,
        $gagalDiversiCount,
        $persentaseBerhasilDiversi
    ) {
        $this->cases = $cases;
        $this->totalSelesaiDiversiCount = (int) $totalSelesaiDiversiCount;
        $this->berhasilDiversiCount = (int) $berhasilDiversiCount;
        $this->gagalDiversiCount = (int) $gagalDiversiCount;
        $this->persentaseBerhasilDiversi = (float) $persentaseBerhasilDiversi;
    }

    /** @return CaseIku19Record[] */
    public function getCases() { return $this->cases; }
    public function getTotalSelesaiDiversiCount() { return $this->totalSelesaiDiversiCount; }
    public function getBerhasilDiversiCount() { return $this->berhasilDiversiCount; }
    public function getGagalDiversiCount() { return $this->gagalDiversiCount; }
    public function getPersentaseBerhasilDiversi() { return $this->persentaseBerhasilDiversi; }
}
