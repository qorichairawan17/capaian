<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku15Response
{
    private $cases;
    private $totalMinutasiCount;
    private $diunggahCount;
    private $belumDiunggahCount;
    private $persentaseDiunggah;

    public function __construct(array $cases, $totalMinutasiCount, $diunggahCount, $belumDiunggahCount, $persentaseDiunggah)
    {
        $this->cases = $cases;
        $this->totalMinutasiCount = $totalMinutasiCount;
        $this->diunggahCount = $diunggahCount;
        $this->belumDiunggahCount = $belumDiunggahCount;
        $this->persentaseDiunggah = $persentaseDiunggah;
    }

    public function getCases() { return $this->cases; }
    public function getTotalMinutasiCount() { return $this->totalMinutasiCount; }
    public function getDiunggahCount() { return $this->diunggahCount; }
    public function getBelumDiunggahCount() { return $this->belumDiunggahCount; }
    public function getPersentaseDiunggah() { return $this->persentaseDiunggah; }
}
