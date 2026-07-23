<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku18Request
{
    private $periode;       // 't1', 't2', 't3', 't4', 'tahunan'
    private $statusMediasi; // 'berhasil', 'gagal', 'semua'

    public function __construct($periode = null, $statusMediasi = null)
    {
        $this->periode = $periode;
        $this->statusMediasi = $statusMediasi;
    }

    public function getPeriode() { return $this->periode; }
    public function getStatusMediasi() { return $this->statusMediasi; }
}
