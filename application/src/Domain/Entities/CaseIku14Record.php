<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class CaseIku14Record
{
    private $id;
    private $nomorPerkara;
    private $jenisPengajuan; // 'e-Court' | 'Konvensional'
    private $tanggalPengajuan;
    private $pembanding;
    private $terbanding;
    private $statusECourt;
    private $triwulan; // 1 | 2 | 3 | 4
    private $tahun;

    public function __construct($id, $nomorPerkara, $jenisPengajuan, $tanggalPengajuan, $pembanding, $terbanding, $statusECourt, $triwulan, $tahun)
    {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->jenisPengajuan = $jenisPengajuan;
        $this->tanggalPengajuan = $tanggalPengajuan;
        $this->pembanding = $pembanding;
        $this->terbanding = $terbanding;
        $this->statusECourt = $statusECourt;
        $this->triwulan = $triwulan;
        $this->tahun = $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getJenisPengajuan() { return $this->jenisPengajuan; }
    public function getTanggalPengajuan() { return $this->tanggalPengajuan; }
    public function getPembanding() { return $this->pembanding; }
    public function getTerbanding() { return $this->terbanding; }
    public function getStatusECourt() { return $this->statusECourt; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }
}
