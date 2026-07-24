<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku110Request
{
    private $periode;           // 't1', 't2', 't3', 't4', 'tahunan'
    private $metodePendaftaran; // 'ecourt', 'konvensional', 'semua'

    public function __construct($periode = null, $metodePendaftaran = null)
    {
        $this->periode = $periode;
        $this->metodePendaftaran = $metodePendaftaran;
    }

    public function getPeriode() { return $this->periode; }
    public function getMetodePendaftaran() { return $this->metodePendaftaran; }
}
