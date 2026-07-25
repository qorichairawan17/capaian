<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SaveIkuTargetRequest DTO
 *
 * Data masuk untuk menyimpan satu target IKU.
 */
class SaveIkuTargetRequest
{
    private $ikuCode;
    private $tahun;
    private $periodeType;
    private $periodeValue;
    private $targetValue;
    private $userId;

    public function __construct($ikuCode, $tahun, $periodeType, $periodeValue, $targetValue, $userId = null)
    {
        $this->ikuCode = $ikuCode;
        $this->tahun = (int) $tahun;
        $this->periodeType = $periodeType;
        $this->periodeValue = (int) $periodeValue;
        $this->targetValue = (float) $targetValue;
        $this->userId = $userId;
    }

    public function getIkuCode() { return $this->ikuCode; }
    public function getTahun() { return $this->tahun; }
    public function getPeriodeType() { return $this->periodeType; }
    public function getPeriodeValue() { return $this->periodeValue; }
    public function getTargetValue() { return $this->targetValue; }
    public function getUserId() { return $this->userId; }
}
