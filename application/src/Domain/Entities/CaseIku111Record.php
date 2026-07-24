<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CaseIku111Record Entity
 *
 * Representasi domain murni untuk perkara pidana yang dilimpahkan secara elektronik (e-Berpadu) (IKU 1.11).
 */
class CaseIku111Record
{
    private $id;
    private $nomorPerkara;
    private $namaTerdakwa;
    private $jenisPidana;            // 'Pidana Biasa', 'Pidana Singkat', 'Pidana Cepat', 'Pidana Anak'
    private $metodePelimpahan;       // 'e-Berpadu', 'Konvensional'
    private $tanggalPelimpahan;
    private $nomorRegisterEberpadu;
    private $kejaksaanPenuntut;
    private $triwulan;
    private $tahun;

    public function __construct(
        $id,
        $nomorPerkara,
        $namaTerdakwa,
        $jenisPidana,
        $metodePelimpahan,
        $tanggalPelimpahan,
        $nomorRegisterEberpadu,
        $kejaksaanPenuntut,
        $triwulan,
        $tahun
    ) {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->namaTerdakwa = $namaTerdakwa;
        $this->jenisPidana = $jenisPidana;
        $this->metodePelimpahan = $metodePelimpahan;
        $this->tanggalPelimpahan = $tanggalPelimpahan;
        $this->nomorRegisterEberpadu = $nomorRegisterEberpadu;
        $this->kejaksaanPenuntut = $kejaksaanPenuntut;
        $this->triwulan = (int) $triwulan;
        $this->tahun = (int) $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getNamaTerdakwa() { return $this->namaTerdakwa; }
    public function getJenisPidana() { return $this->jenisPidana; }
    public function getMetodePelimpahan() { return $this->metodePelimpahan; }
    public function getTanggalPelimpahan() { return $this->tanggalPelimpahan; }
    public function getNomorRegisterEberpadu() { return $this->nomorRegisterEberpadu; }
    public function getKejaksaanPenuntut() { return $this->kejaksaanPenuntut; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }

    /**
     * Memeriksa apakah pelimpahan perkara menggunakan e-Berpadu
     */
    public function isEberpadu()
    {
        return strtolower($this->metodePelimpahan) === 'e-berpadu';
    }

    /**
     * Memeriksa apakah pelimpahan perkara dilakukan secara konvensional
     */
    public function isKonvensional()
    {
        return strtolower($this->metodePelimpahan) === 'konvensional';
    }
}
