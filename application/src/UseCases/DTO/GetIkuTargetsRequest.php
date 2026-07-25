<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * GetIkuTargetsRequest DTO
 *
 * Data masuk untuk mengambil target IKU berdasarkan filter.
 */
class GetIkuTargetsRequest
{
    private $ikuCode;
    private $tahun;
    private $periodeType;

    public function __construct($ikuCode, $tahun, $periodeType)
    {
        $this->ikuCode = $ikuCode;
        $this->tahun = (int) $tahun;
        $this->periodeType = $periodeType;
    }

    public function getIkuCode() { return $this->ikuCode; }
    public function getTahun() { return $this->tahun; }
    public function getPeriodeType() { return $this->periodeType; }
}
