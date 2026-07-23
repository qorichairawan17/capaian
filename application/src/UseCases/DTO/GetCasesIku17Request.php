<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku17Request
{
    private $kategoriKriteria; // 'tindak_pidana_ringan', 'delik_aduan', 'ancaman_max_5_tahun', 'anak_diversi_gagal', 'lalu_lintas', 'semua'
    private $statusRj;          // 'berhasil', 'gagal', 'semua'
    private $periode;           // 't1', 't2', 't3', 't4', 'tahunan'

    public function __construct($kategoriKriteria = null, $statusRj = null, $periode = null)
    {
        $this->kategoriKriteria = $kategoriKriteria;
        $this->statusRj = $statusRj;
        $this->periode = $periode;
    }

    public function getKategoriKriteria() { return $this->kategoriKriteria; }
    public function getStatusRj() { return $this->statusRj; }
    public function getPeriode() { return $this->periode; }
}
