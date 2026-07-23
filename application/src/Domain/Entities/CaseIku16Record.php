<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class CaseIku16Record
{
    private $id;
    private $nomorPerkara;
    private $jenisEksekusi; // 'Eksekusi Terhadap Perkara' | 'Eksekusi Hak Tanggungan'
    private $pemohon;
    private $termohon;
    private $tanggalPermohonan;
    private $tanggalSelesai;
    private $statusEksekusi; // 'Berhasil Eksekusi' | 'Dicabut' | 'Dicoret / Non Executable' | 'Dalam Proses'
    private $triwulan;
    private $tahun;

    public function __construct($id, $nomorPerkara, $jenisEksekusi, $pemohon, $termohon, $tanggalPermohonan, $tanggalSelesai, $statusEksekusi, $triwulan, $tahun)
    {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->jenisEksekusi = $jenisEksekusi;
        $this->pemohon = $pemohon;
        $this->termohon = $termohon;
        $this->tanggalPermohonan = $tanggalPermohonan;
        $this->tanggalSelesai = $tanggalSelesai;
        $this->statusEksekusi = $statusEksekusi;
        $this->triwulan = $triwulan;
        $this->tahun = $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getJenisEksekusi() { return $this->jenisEksekusi; }
    public function getPemohon() { return $this->pemohon; }
    public function getTermohon() { return $this->termohon; }
    public function getTanggalPermohonan() { return $this->tanggalPermohonan; }
    public function getTanggalSelesai() { return $this->tanggalSelesai; }
    public function getStatusEksekusi() { return $this->statusEksekusi; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }

    public function isDiselesaikan()
    {
        return in_array($this->statusEksekusi, ['Berhasil Eksekusi', 'Dicabut', 'Dicoret / Non Executable']);
    }
}
