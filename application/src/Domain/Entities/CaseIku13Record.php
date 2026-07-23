<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class CaseIku13Record
{
    private $id;
    private $nomorPerkara;
    private $jenisPerkara; // 'Pidana' | 'Perdata'
    private $tingkatPeradilan; // 'Banding' | 'Kasasi' | 'PK'
    private $tanggalDiterima;
    private $tanggalDiberitahukan;
    private $durasiHari;
    private $status; // 'Tepat Waktu' | 'Terlambat'
    private $triwulan;
    private $tahun;

    public function __construct($id, $nomorPerkara, $jenisPerkara, $tingkatPeradilan, $tanggalDiterima, $tanggalDiberitahukan, $durasiHari, $status, $triwulan, $tahun)
    {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->jenisPerkara = $jenisPerkara;
        $this->tingkatPeradilan = $tingkatPeradilan;
        $this->tanggalDiterima = $tanggalDiterima;
        $this->tanggalDiberitahukan = $tanggalDiberitahukan;
        $this->durasiHari = $durasiHari;
        $this->status = $status;
        $this->triwulan = $triwulan;
        $this->tahun = $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getJenisPerkara() { return $this->jenisPerkara; }
    public function getTingkatPeradilan() { return $this->tingkatPeradilan; }
    public function getTanggalDiterima() { return $this->tanggalDiterima; }
    public function getTanggalDiberitahukan() { return $this->tanggalDiberitahukan; }
    public function getDurasiHari() { return $this->durasiHari; }
    public function getStatus() { return $this->status; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }
}
