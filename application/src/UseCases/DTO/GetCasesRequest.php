<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesRequest
{
    private $jenisPerkara;
    private $periode;

    public function __construct($jenisPerkara = null, $periode = null)
    {
        $this->jenisPerkara = $jenisPerkara;
        $this->periode = $periode;
    }

    public function getJenisPerkara() { return $this->jenisPerkara; }
    public function getPeriode() { return $this->periode; }
}
