<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class CaseRecord
{
    private $id;
    private $nomorPerkara;
    private $jenisPerkara; // 'Pidana' | 'Perdata'
    private $klasifikasi;
    private $tanggalRegistrasi;
    private $tanggalPutusan;
    private $durasiHari;
    private $status; // 'Tepat Waktu' | 'Terlambat'
    private $triwulan; // 1 | 2 | 3 | 4
    private $tahun;

    public function __construct($id, $nomorPerkara, $jenisPerkara, $klasifikasi, $tanggalRegistrasi, $tanggalPutusan, $durasiHari, $status, $triwulan, $tahun)
    {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->jenisPerkara = $jenisPerkara;
        $this->klasifikasi = $klasifikasi;
        $this->tanggalRegistrasi = $tanggalRegistrasi;
        $this->tanggalPutusan = $tanggalPutusan;
        $this->durasiHari = $durasiHari;
        $this->status = $status;
        $this->triwulan = $triwulan;
        $this->tahun = $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getJenisPerkara() { return $this->jenisPerkara; }
    public function getKlasifikasi() { return $this->klasifikasi; }
    public function getTanggalRegistrasi() { return $this->tanggalRegistrasi; }
    public function getTanggalPutusan() { return $this->tanggalPutusan; }
    public function getDurasiHari() { return $this->durasiHari; }
    public function getStatus() { return $this->status; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }
}
