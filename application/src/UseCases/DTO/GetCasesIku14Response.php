<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku14Response
{
    private $cases;
    private $totalDiterimaCount;
    private $tepatWaktuCount;
    private $terlambatCount;
    private $persentaseTepatWaktu;

    public function __construct(array $cases, $totalDiterimaCount, $tepatWaktuCount, $terlambatCount, $persentaseTepatWaktu)
    {
        $this->cases = $cases;
        $this->totalDiterimaCount = $totalDiterimaCount;
        $this->tepatWaktuCount = $tepatWaktuCount;
        $this->terlambatCount = $terlambatCount;
        $this->persentaseTepatWaktu = $persentaseTepatWaktu;
    }

    public function getCases() { return $this->cases; }
    public function getTotalDiterimaCount() { return $this->totalDiterimaCount; }
    public function getTepatWaktuCount() { return $this->tepatWaktuCount; }
    public function getTerlambatCount() { return $this->terlambatCount; }
    public function getPersentaseTepatWaktu() { return $this->persentaseTepatWaktu; }
}
