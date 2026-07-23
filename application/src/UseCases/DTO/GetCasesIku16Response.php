<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku16Response
{
    private $cases;
    private $totalPermohonanCount;
    private $diselesaikanCount;
    private $dalamProsesCount;
    private $persentaseDiselesaikan;

    public function __construct(array $cases, $totalPermohonanCount, $diselesaikanCount, $dalamProsesCount, $persentaseDiselesaikan)
    {
        $this->cases = $cases;
        $this->totalPermohonanCount = $totalPermohonanCount;
        $this->diselesaikanCount = $diselesaikanCount;
        $this->dalamProsesCount = $dalamProsesCount;
        $this->persentaseDiselesaikan = $persentaseDiselesaikan;
    }

    public function getCases() { return $this->cases; }
    public function getTotalPermohonanCount() { return $this->totalPermohonanCount; }
    public function getDiselesaikanCount() { return $this->diselesaikanCount; }
    public function getDalamProsesCount() { return $this->dalamProsesCount; }
    public function getPersentaseDiselesaikan() { return $this->persentaseDiselesaikan; }
}
