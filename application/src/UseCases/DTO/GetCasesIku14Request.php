<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku14Request
{
    private $jenisPengajuan; // 'semua' | 'ecourt' | 'konvensional'
    private $periode;

    public function __construct($jenisPengajuan = null, $periode = null)
    {
        $this->jenisPengajuan = $jenisPengajuan;
        $this->periode = $periode;
    }

    public function getJenisPengajuan() { return $this->jenisPengajuan; }
    public function getPeriode() { return $this->periode; }
}
