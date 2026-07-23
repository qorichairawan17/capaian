<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku18Record;

class GetCasesIku18Response
{
    /** @var CaseIku18Record[] */
    private $cases;
    private $totalWajibMediasiCount;
    private $berhasilMediasiCount;
    private $gagalMediasiCount;
    private $persentaseBerhasilMediasi;

    public function __construct(array $cases, $totalWajibMediasiCount, $berhasilMediasiCount, $gagalMediasiCount, $persentaseBerhasilMediasi)
    {
        $this->cases = $cases;
        $this->totalWajibMediasiCount = $totalWajibMediasiCount;
        $this->berhasilMediasiCount = $berhasilMediasiCount;
        $this->gagalMediasiCount = $gagalMediasiCount;
        $this->persentaseBerhasilMediasi = $persentaseBerhasilMediasi;
    }

    public function getCases() { return $this->cases; }
    public function getTotalWajibMediasiCount() { return $this->totalWajibMediasiCount; }
    public function getBerhasilMediasiCount() { return $this->berhasilMediasiCount; }
    public function getGagalMediasiCount() { return $this->gagalMediasiCount; }
    public function getPersentaseBerhasilMediasi() { return $this->persentaseBerhasilMediasi; }
}
