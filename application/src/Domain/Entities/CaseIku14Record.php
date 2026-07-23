<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class CaseIku14Record
{
    private $id;
    private $nomorPerkara;
    private $tingkatPeradilan; // 'Banding' | 'Kasasi' | 'PK'
    private $metodePengiriman; // 'Jurusita' | 'Elektronik' | 'Surat Tercatat'
    private $tanggalDiterima;
    private $tanggalDikirimkan;
    private $durasiHari;
    private $status; // 'Tepat Waktu' | 'Terlambat'
    private $triwulan;
    private $tahun;

    public function __construct($id, $nomorPerkara, $tingkatPeradilan, $metodePengiriman, $tanggalDiterima, $tanggalDikirimkan, $durasiHari, $status, $triwulan, $tahun)
    {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->tingkatPeradilan = $tingkatPeradilan;
        $this->metodePengiriman = $metodePengiriman;
        $this->tanggalDiterima = $tanggalDiterima;
        $this->tanggalDikirimkan = $tanggalDikirimkan;
        $this->durasiHari = $durasiHari;
        $this->status = $status;
        $this->triwulan = $triwulan;
        $this->tahun = $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getTingkatPeradilan() { return $this->tingkatPeradilan; }
    public function getMetodePengiriman() { return $this->metodePengiriman; }
    public function getTanggalDiterima() { return $this->tanggalDiterima; }
    public function getTanggalDikirimkan() { return $this->tanggalDikirimkan; }
    public function getDurasiHari() { return $this->durasiHari; }
    public function getStatus() { return $this->status; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }
}
