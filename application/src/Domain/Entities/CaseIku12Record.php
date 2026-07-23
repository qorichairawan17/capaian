<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class CaseIku12Record
{
    private $id;
    private $nomorPerkara;
    private $jenisPerkara; // 'Pidana' | 'Perdata'
    private $metodePengiriman; // 'Elektronik (SIP)' | 'Pihak Ketiga (Pos/Ekspedisi)'
    private $tanggalPutusan;
    private $tanggalPengiriman;
    private $durasiHari;
    private $status; // 'Tepat Waktu' | 'Terlambat'
    private $triwulan; // 1 | 2 | 3 | 4
    private $tahun;

    public function __construct($id, $nomorPerkara, $jenisPerkara, $metodePengiriman, $tanggalPutusan, $tanggalPengiriman, $durasiHari, $status, $triwulan, $tahun)
    {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->jenisPerkara = $jenisPerkara;
        $this->metodePengiriman = $metodePengiriman;
        $this->tanggalPutusan = $tanggalPutusan;
        $this->tanggalPengiriman = $tanggalPengiriman;
        $this->durasiHari = $durasiHari;
        $this->status = $status;
        $this->triwulan = $triwulan;
        $this->tahun = $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getJenisPerkara() { return $this->jenisPerkara; }
    public function getMetodePengiriman() { return $this->metodePengiriman; }
    public function getTanggalPutusan() { return $this->tanggalPutusan; }
    public function getTanggalPengiriman() { return $this->tanggalPengiriman; }
    public function getDurasiHari() { return $this->durasiHari; }
    public function getStatus() { return $this->status; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }
}
