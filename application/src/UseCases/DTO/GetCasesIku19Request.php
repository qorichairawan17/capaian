<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku19Request
{
    private $periode;       // 't1', 't2', 't3', 't4', 'tahunan'
    private $statusDiversi; // 'berhasil', 'gagal', 'semua'

    public function __construct($periode = null, $statusDiversi = null)
    {
        $this->periode = $periode;
        $this->statusDiversi = $statusDiversi;
    }

    public function getPeriode() { return $this->periode; }
    public function getStatusDiversi() { return $this->statusDiversi; }
}
