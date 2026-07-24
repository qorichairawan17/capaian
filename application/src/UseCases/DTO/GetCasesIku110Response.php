<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku110Record;

class GetCasesIku110Response
{
    /** @var CaseIku110Record[] */
    private $cases;
    private $totalDiajukanCount;
    private $ecourtCount;
    private $konvensionalCount;
    private $persentaseEcourt;

    public function __construct(
        array $cases,
        $totalDiajukanCount,
        $ecourtCount,
        $konvensionalCount,
        $persentaseEcourt
    ) {
        $this->cases = $cases;
        $this->totalDiajukanCount = (int) $totalDiajukanCount;
        $this->ecourtCount = (int) $ecourtCount;
        $this->konvensionalCount = (int) $konvensionalCount;
        $this->persentaseEcourt = (float) $persentaseEcourt;
    }

    /** @return CaseIku110Record[] */
    public function getCases() { return $this->cases; }
    public function getTotalDiajukanCount() { return $this->totalDiajukanCount; }
    public function getEcourtCount() { return $this->ecourtCount; }
    public function getKonvensionalCount() { return $this->konvensionalCount; }
    public function getPersentaseEcourt() { return $this->persentaseEcourt; }
}
