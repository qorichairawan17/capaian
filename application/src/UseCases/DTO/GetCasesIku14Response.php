<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku14Response
{
    private $cases;
    private $totalDiajukanCount;
    private $eCourtCount;
    private $konvensionalCount;
    private $persentaseECourt;

    public function __construct(array $cases, $totalDiajukanCount, $eCourtCount, $konvensionalCount, $persentaseECourt)
    {
        $this->cases = $cases;
        $this->totalDiajukanCount = $totalDiajukanCount;
        $this->eCourtCount = $eCourtCount;
        $this->konvensionalCount = $konvensionalCount;
        $this->persentaseECourt = $persentaseECourt;
    }

    public function getCases() { return $this->cases; }
    public function getTotalDiajukanCount() { return $this->totalDiajukanCount; }
    public function getECourtCount() { return $this->eCourtCount; }
    public function getKonvensionalCount() { return $this->konvensionalCount; }
    public function getPersentaseECourt() { return $this->persentaseECourt; }
}
