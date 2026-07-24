<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku111Record;

class GetCasesIku111Response
{
    /** @var CaseIku111Record[] */
    private $cases;
    private $totalDilimpahkanCount;
    private $eberpaduCount;
    private $konvensionalCount;
    private $persentaseEberpadu;

    public function __construct(
        array $cases,
        $totalDilimpahkanCount,
        $eberpaduCount,
        $konvensionalCount,
        $persentaseEberpadu
    ) {
        $this->cases = $cases;
        $this->totalDilimpahkanCount = (int) $totalDilimpahkanCount;
        $this->eberpaduCount = (int) $eberpaduCount;
        $this->konvensionalCount = (int) $konvensionalCount;
        $this->persentaseEberpadu = (float) $persentaseEberpadu;
    }

    /** @return CaseIku111Record[] */
    public function getCases() { return $this->cases; }
    public function getTotalDilimpahkanCount() { return $this->totalDilimpahkanCount; }
    public function getEberpaduCount() { return $this->eberpaduCount; }
    public function getKonvensionalCount() { return $this->konvensionalCount; }
    public function getPersentaseEberpadu() { return $this->persentaseEberpadu; }
}
