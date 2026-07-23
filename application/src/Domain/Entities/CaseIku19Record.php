<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CaseIku19Record Entity
 *
 * Representasi domain murni untuk perkara anak yang dilakukan proses diversi (IKU 1.9).
 */
class CaseIku19Record
{
    private $id;
    private $nomorPerkara;
    private $namaAnak;
    private $dakwaan;
    private $tanggalDiversi;
    private $tanggalSelesai;
    private $statusDiversi;       // 'Berhasil', 'Gagal', 'Tidak Memenuhi Syarat'
    private $nomorPenetapanKetua;
    private $triwulan;
    private $tahun;

    public function __construct(
        $id,
        $nomorPerkara,
        $namaAnak,
        $dakwaan,
        $tanggalDiversi,
        $tanggalSelesai,
        $statusDiversi,
        $nomorPenetapanKetua,
        $triwulan,
        $tahun
    ) {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->namaAnak = $namaAnak;
        $this->dakwaan = $dakwaan;
        $this->tanggalDiversi = $tanggalDiversi;
        $this->tanggalSelesai = $tanggalSelesai;
        $this->statusDiversi = $statusDiversi;
        $this->nomorPenetapanKetua = $nomorPenetapanKetua;
        $this->triwulan = (int) $triwulan;
        $this->tahun = (int) $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getNamaAnak() { return $this->namaAnak; }
    public function getDakwaan() { return $this->dakwaan; }
    public function getTanggalDiversi() { return $this->tanggalDiversi; }
    public function getTanggalSelesai() { return $this->tanggalSelesai; }
    public function getStatusDiversi() { return $this->statusDiversi; }
    public function getNomorPenetapanKetua() { return $this->nomorPenetapanKetua; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }

    /**
     * Memeriksa apakah perkara anak telah selesai proses musyawarah diversi
     */
    public function isSelesaiDiversi()
    {
        return $this->statusDiversi === 'Berhasil' || $this->statusDiversi === 'Gagal';
    }

    /**
     * Memeriksa apakah diversi berhasil (adanya penetapan diversi berhasil dari Ketua Pengadilan)
     */
    public function isBerhasilDiversi()
    {
        return $this->statusDiversi === 'Berhasil';
    }
}
