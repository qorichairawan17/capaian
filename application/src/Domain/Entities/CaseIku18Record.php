<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class CaseIku18Record
{
    private $id;
    private $nomorPerkara;
    private $paraPihak;
    private $mediator;
    private $jenisMediator; // 'Mediator Hakim' | 'Mediator Non-Hakim'
    private $tanggalMediasi;
    private $tanggalSelesai;
    private $hasilMediasi; // 'Berhasil Seluruhnya (Akta Perdamaian)' | 'Berhasil Seluruhnya (Pencabutan)' | 'Berhasil Sebagian' | 'Tidak Berhasil' | 'Tidak Dapat Dilaksanakan'
    private $triwulan;
    private $tahun;

    public function __construct($id, $nomorPerkara, $paraPihak, $mediator, $jenisMediator, $tanggalMediasi, $tanggalSelesai, $hasilMediasi, $triwulan, $tahun)
    {
        $this->id = $id;
        $this->nomorPerkara = $nomorPerkara;
        $this->paraPihak = $paraPihak;
        $this->mediator = $mediator;
        $this->jenisMediator = $jenisMediator;
        $this->tanggalMediasi = $tanggalMediasi;
        $this->tanggalSelesai = $tanggalSelesai;
        $this->hasilMediasi = $hasilMediasi;
        $this->triwulan = $triwulan;
        $this->tahun = $tahun;
    }

    public function getId() { return $this->id; }
    public function getNomorPerkara() { return $this->nomorPerkara; }
    public function getParaPihak() { return $this->paraPihak; }
    public function getMediator() { return $this->mediator; }
    public function getJenisMediator() { return $this->jenisMediator; }
    public function getTanggalMediasi() { return $this->tanggalMediasi; }
    public function getTanggalSelesai() { return $this->tanggalSelesai; }
    public function getHasilMediasi() { return $this->hasilMediasi; }
    public function getTriwulan() { return $this->triwulan; }
    public function getTahun() { return $this->tahun; }

    /**
     * Catatan 3: Jumlah perkara yang wajib dilaksanakan mediasi tidak termasuk
     * perkara yang tidak dapat dilaksanakan mediasi karena ketidakhadiran salah satu pihak.
     */
    public function isWajibMediasi()
    {
        return $this->hasilMediasi !== 'Tidak Dapat Dilaksanakan';
    }

    /**
     * Catatan 1: Perkara yang berhasil diselesaikan mediasi meliputi:
     * a. Perkara yang berhasil didamaikan seluruhnya (Akta Perdamaian / Pencabutan)
     * b. Perkara yang berhasil didamaikan sebagian.
     */
    public function isBerhasilMediasi()
    {
        return in_array($this->hasilMediasi, [
            'Berhasil Seluruhnya (Akta Perdamaian)',
            'Berhasil Seluruhnya (Pencabutan)',
            'Berhasil Sebagian'
        ]);
    }
}
