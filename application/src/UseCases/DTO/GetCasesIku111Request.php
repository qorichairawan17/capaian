<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku111Request
{
    private $periode;           // 't1', 't2', 't3', 't4', 'tahunan'
    private $metodePelimpahan;  // 'eberpadu', 'konvensional', 'semua'

    public function __construct($periode = null, $metodePelimpahan = null)
    {
        $this->periode = $periode;
        $this->metodePelimpahan = $metodePelimpahan;
    }

    public function getPeriode() { return $this->periode; }
    public function getMetodePelimpahan() { return $this->metodePelimpahan; }
}
