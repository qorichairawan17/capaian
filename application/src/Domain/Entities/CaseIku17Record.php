<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class CaseIku17Record
{
    private $id;
    private $nomorPerkara;
    private $kategoriKriteria; // 'Tindak Pidana Ringan / Kerugian <= 2.5 Juta' | 'Delik Aduan' | 'Ancaman Hukuman Max 5 Tahun' | 'Anak (Diversi Tidak Berhasil)' | 'Kejahatan Lalu Lintas'
    private $terdakwa;
    private $tanggalRegistrasi;
    private $tanggalPutusan;
    private $statusRj; // 'Berhasil' | 'Tidak Berhasil'
    private $triwulan;
    private $tahun;

    public function __construct($id, $nomorPerkara, $kategoriKriteria, $terdakwa, $tanggalRegistrasi, $tanggalPutusan, $statusRj, $triwulan, $tahun)
    {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->kategoriKriteria = $kategoriKriteria;
        $this->terdakwa = $terdakwa;
        $this->tanggalRegistrasi = $tanggalRegistrasi;
        $this->tanggalPutusan = $tanggalPutusan;
        $this->statusRj = $statusRj;
        $this->triwulan = $triwulan;
        $this->tahun = $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getKategoriKriteria() { return $this->kategoriKriteria; }
    public function getTerdakwa() { return $this->terdakwa; }
    public function getTanggalRegistrasi() { return $this->tanggalRegistrasi; }
    public function getTanggalPutusan() { return $this->tanggalPutusan; }
    public function getStatusRj() { return $this->statusRj; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }

    public function isBerhasil()
    {
        return $this->statusRj === 'Berhasil';
    }
}
