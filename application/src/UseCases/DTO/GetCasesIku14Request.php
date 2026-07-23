<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetCasesIku14Request
{
    private $tingkatPeradilan; // 'semua' | 'banding' | 'kasasi' | 'pk'
    private $periode;

    public function __construct($tingkatPeradilan = null, $periode = null)
    {
        $this->tingkatPeradilan = $tingkatPeradilan;
        $this->periode = $periode;
    }

    public function getTingkatPeradilan() { return $this->tingkatPeradilan; }
    public function getPeriode() { return $this->periode; }
}
