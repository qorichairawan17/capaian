<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku17Record;
use App\Domain\Repositories\CaseIku17RepositoryInterface;

class MockCaseIku17Repository implements CaseIku17RepositoryInterface
{
    private $cases = [];

    public function __construct()
    {
        $this->generateMockData();
    }

    /**
     * Find all cases with given filters
     *
     * @param array $filters
     * @return CaseIku17Record[]
     */
    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        // Filter by Kategori Kriteria
        if (isset($filters['kategori_kriteria'])) {
            $kategori = strtolower($filters['kategori_kriteria']);
            $filtered = array_filter($filtered, function(CaseIku17Record $case) use ($kategori) {
                $katName = strtolower($case->getKategoriKriteria());
                if ($kategori === 'tindak_pidana_ringan' || $kategori === 'tipiring') {
                    return strpos($katName, 'tindak pidana ringan') !== false;
                } else if ($kategori === 'delik_aduan') {
                    return strpos($katName, 'delik aduan') !== false;
                } else if ($kategori === 'ancaman_max_5_tahun') {
                    return strpos($katName, 'ancaman hukuman max 5 tahun') !== false;
                } else if ($kategori === 'anak_diversi_gagal') {
                    return strpos($katName, 'anak') !== false;
                } else if ($kategori === 'lalu_lintas') {
                    return strpos($katName, 'lalu lintas') !== false;
                }
                return true;
            });
        }

        // Filter by Status RJ
        if (isset($filters['status_rj'])) {
            $statusRj = strtolower($filters['status_rj']);
            $filtered = array_filter($filtered, function(CaseIku17Record $case) use ($statusRj) {
                if ($statusRj === 'berhasil') {
                    return $case->isBerhasil();
                } else if ($statusRj === 'gagal' || $statusRj === 'tidak_berhasil') {
                    return !$case->isBerhasil();
                }
                return true;
            });
        }

        // Filter by Triwulan (Periode)
        if (isset($filters['periode'])) {
            $periode = strtolower($filters['periode']); // 't1', 't2', 't3', 't4'
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $triwulanTarget = (int)$matches[1];
                $filtered = array_filter($filtered, function(CaseIku17Record $case) use ($triwulanTarget) {
                    return $case->getTriwulan() === $triwulanTarget;
                });
            }
        }

        return array_values($filtered);
    }

    /**
     * Generate 60 realistic RJ case records
     */
    private function generateMockData()
    {
        $kategoriOptions = [
            'Tindak Pidana Ringan / Kerugian <= 2.5 Juta',
            'Delik Aduan',
            'Ancaman Hukuman Max 5 Tahun',
            'Anak (Diversi Tidak Berhasil)',
            'Kejahatan Lalu Lintas'
        ];

        $terdakwaList = [
            'Ahmad Fauzi', 'Budi Harjo', 'Chandra Wijaya', 'Dedi Kurniawan',
            'Eko Prasetyo', 'Fajar Ramadhan', 'Gilang Purnama', 'Hendra Setiawan',
            'Irfan Hakim', 'Joko Susanto', 'Kiki Pratama', 'Lukman Hakim'
        ];

        for ($i = 1; $i <= 60; $i++) {
            $id = $i;
            $kategoriKriteria = $kategoriOptions[$i % count($kategoriOptions)];
            $terdakwa = $terdakwaList[$i % count($terdakwaList)];

            // Status RJ: 80% Berhasil, 20% Tidak Berhasil
            $statusRj = ($i % 5 === 0) ? 'Tidak Berhasil' : 'Berhasil';

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 6) % 25) + 1;
            $tahun = 2026;

            $registrasiDateStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $regTime = strtotime($registrasiDateStr);

            $durasiPutusanHari = 15 + ($i % 45);
            $tanggalPutusanStr = date('Y-m-d', strtotime("+$durasiPutusanHari days", $regTime));

            $suffix = ($i % 3 === 0) ? 'Pid.C' : 'Pid.B';
            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 12, $suffix, $tahun);

            $this->cases[] = new CaseIku17Record(
                $id,
                $nomorPerkara,
                $kategoriKriteria,
                $terdakwa,
                $registrasiDateStr,
                $tanggalPutusanStr,
                $statusRj,
                $triwulan,
                $tahun
            );
        }
    }
}
