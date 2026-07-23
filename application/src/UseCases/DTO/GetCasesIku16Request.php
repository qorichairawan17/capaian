<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku16Request
{
    private $statusEksekusi; // 'semua' | 'diselesaikan' | 'dalam_proses'
    private $jenisEksekusi;  // 'semua' | 'perkara' | 'hak_tanggungan'
    private $periode;        // 'tahunan' | 't1' | 't2' | 't3' | 't4'

    public function __construct($statusEksekusi = null, $jenisEksekusi = null, $periode = null)
    {
        $this->statusEksekusi = $statusEksekusi;
        $this->jenisEksekusi = $jenisEksekusi;
        $this->periode = $periode;
    }

    public function getStatusEksekusi() { return $this->statusEksekusi; }
    public function getJenisEksekusi() { return $this->jenisEksekusi; }
    public function getPeriode() { return $this->periode; }
}
