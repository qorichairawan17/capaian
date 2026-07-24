<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CaseIku110Record Entity
 *
 * Representasi domain murni untuk perkara perdata tingkat pertama pengguna e-Court (IKU 1.10).
 */
class CaseIku110Record
{
    private $id;
    private $nomorPerkara;
    private $paraPihak;
    private $jenisPerdata;          // 'Gugatan', 'Permohonan', 'Gugatan Sederhana'
    private $metodePendaftaran;     // 'e-Court', 'Konvensional'
    private $tanggalPendaftaran;
    private $nomorRegisterEcourt;
    private $triwulan;
    private $tahun;

    public function __construct(
        $id,
        $nomorPerkara,
        $paraPihak,
        $jenisPerdata,
        $metodePendaftaran,
        $tanggalPendaftaran,
        $nomorRegisterEcourt,
        $triwulan,
        $tahun
    ) {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->paraPihak = $paraPihak;
        $this->jenisPerdata = $jenisPerdata;
        $this->metodePendaftaran = $metodePendaftaran;
        $this->tanggalPendaftaran = $tanggalPendaftaran;
        $this->nomorRegisterEcourt = $nomorRegisterEcourt;
        $this->triwulan = (int) $triwulan;
        $this->tahun = (int) $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getParaPihak() { return $this->paraPihak; }
    public function getJenisPerdata() { return $this->jenisPerdata; }
    public function getMetodePendaftaran() { return $this->metodePendaftaran; }
    public function getTanggalPendaftaran() { return $this->tanggalPendaftaran; }
    public function getNomorRegisterEcourt() { return $this->nomorRegisterEcourt; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }

    /**
     * Memeriksa apakah perkara didaftarkan melalui e-Court
     */
    public function isEcourt()
    {
        return strtolower($this->metodePendaftaran) === 'e-court';
    }

    /**
     * Memeriksa apakah perkara didaftarkan secara konvensional
     */
    public function isKonvensional()
    {
        return strtolower($this->metodePendaftaran) === 'konvensional';
    }
}
