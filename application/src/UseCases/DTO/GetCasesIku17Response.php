<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku17Record;

class GetCasesIku17Response
{
    /** @var CaseIku17Record[] */
    private $cases;
    private $totalMemenuhiKriteriaCount;
    private $berhasilRjCount;
    private $gagalRjCount;
    private $persentaseBerhasilRj;

    public function __construct(array $cases, $totalMemenuhiKriteriaCount, $berhasilRjCount, $gagalRjCount, $persentaseBerhasilRj)
    {
        $this->cases = $cases;
        $this->totalMemenuhiKriteriaCount = $totalMemenuhiKriteriaCount;
        $this->berhasilRjCount = $berhasilRjCount;
        $this->gagalRjCount = $gagalRjCount;
        $this->persentaseBerhasilRj = $persentaseBerhasilRj;
    }

    public function getCases() { return $this->cases; }
    public function getTotalMemenuhiKriteriaCount() { return $this->totalMemenuhiKriteriaCount; }
    public function getBerhasilRjCount() { return $this->berhasilRjCount; }
    public function getGagalRjCount() { return $this->gagalRjCount; }
    public function getPersentaseBerhasilRj() { return $this->persentaseBerhasilRj; }
}
