<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class CaseIku13Record
{
    private $id;
    private $nomorPerkara;
    private $jenisPerkara; // 'Pidana' | 'Perdata'
    private $tanggalMinutasi;
    private $tanggalUnggah;
    private $statusUpload; // 'Diunggah' | 'Belum Diunggah'
    private $urlDirektori;
    private $triwulan; // 1 | 2 | 3 | 4
    private $tahun;

    public function __construct($id, $nomorPerkara, $jenisPerkara, $tanggalMinutasi, $tanggalUnggah, $statusUpload, $urlDirektori, $triwulan, $tahun)
    {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->jenisPerkara = $jenisPerkara;
        $this->tanggalMinutasi = $tanggalMinutasi;
        $this->tanggalUnggah = $tanggalUnggah;
        $this->statusUpload = $statusUpload;
        $this->urlDirektori = $urlDirektori;
        $this->triwulan = $triwulan;
        $this->tahun = $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getJenisPerkara() { return $this->jenisPerkara; }
    public function getTanggalMinutasi() { return $this->tanggalMinutasi; }
    public function getTanggalUnggah() { return $this->tanggalUnggah; }
    public function getStatusUpload() { return $this->statusUpload; }
    public function getUrlDirektori() { return $this->urlDirektori; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }
}
