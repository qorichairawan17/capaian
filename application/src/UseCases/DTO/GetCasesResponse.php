<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesResponse
{
    private $cases;
    private $totalCount;
    private $tepatWaktuCount;
    private $terlambatCount;
    private $persentaseTepatWaktu;

    public function __construct(array $cases, $totalCount, $tepatWaktuCount, $terlambatCount, $persentaseTepatWaktu)
    {
        $this->cases = $cases;
        $this->totalCount = $totalCount;
        $this->tepatWaktuCount = $tepatWaktuCount;
        $this->terlambatCount = $terlambatCount;
        $this->persentaseTepatWaktu = $persentaseTepatWaktu;
    }

    public function getCases() { return $this->cases; }
    public function getTotalCount() { return $this->totalCount; }
    public function getTepatWaktuCount() { return $this->tepatWaktuCount; }
    public function getTerlambatCount() { return $this->terlambatCount; }
    public function getPersentaseTepatWaktu() { return $this->persentaseTepatWaktu; }
}
