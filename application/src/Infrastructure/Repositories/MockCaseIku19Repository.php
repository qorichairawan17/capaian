<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku19Record;
use App\Domain\Repositories\CaseIku19RepositoryInterface;

class MockCaseIku19Repository implements CaseIku19RepositoryInterface
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
     * @return CaseIku19Record[]
     */
    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        // Filter by Status Diversi
        if (isset($filters['status_diversi'])) {
            $statusDiversi = strtolower($filters['status_diversi']);
            $filtered = array_filter($filtered, function(CaseIku19Record $case) use ($statusDiversi) {
                if ($statusDiversi === 'berhasil') {
                    return $case->isBerhasilDiversi();
                } else if ($statusDiversi === 'gagal' || $statusDiversi === 'tidak_berhasil') {
                    return $case->isSelesaiDiversi() && !$case->isBerhasilDiversi();
                }
                return true;
            });
        }

        // Filter by Triwulan (Periode)
        if (isset($filters['periode'])) {
            $periode = strtolower($filters['periode']); // 't1', 't2', 't3', 't4'
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $triwulanTarget = (int)$matches[1];
                $filtered = array_filter($filtered, function(CaseIku19Record $case) use ($triwulanTarget) {
                    return $case->getTriwulan() === $triwulanTarget;
                });
            }
        }

        return array_values($filtered);
    }

    /**
     * Generate 50 realistic juvenile diversion case records
     */
    private function generateMockData()
    {
        $namaAnakList = [
            'Anak A.R. (15 th)',
            'Anak B.S. (16 th)',
            'Anak C.D. (14 th)',
            'Anak D.P. (17 th)',
            'Anak E.F. (15 th)',
            'Anak G.H. (16 th)'
        ];

        $dakwaanList = [
            'Pasal 362 KUHP (Pencurian ringan, ancaman 5 th)',
            'Pasal 351 ayat (1) KUHP (Penganiayaan ringan, ancaman 2 th 8 bln)',
            'Pasal 170 ayat (1) KUHP (Kekerasan bersama, ancaman 5 th 6 bln)',
            'Pasal 363 ayat (1) KUHP (Pencurian pemberatan, ancaman 7 th)'
        ];

        $statusOptions = [
            'Berhasil',
            'Berhasil',
            'Berhasil',
            'Gagal',
            'Tidak Memenuhi Syarat'
        ];

        for ($i = 1; $i <= 50; $i++) {
            $id = $i;
            $namaAnak = $namaAnakList[$i % count($namaAnakList)];
            $dakwaan = $dakwaanList[$i % count($dakwaanList)];
            $statusDiversi = $statusOptions[$i % count($statusOptions)];

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 5) % 25) + 1;
            $tahun = 2026;

            $tanggalDiversiStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $divTime = strtotime($tanggalDiversiStr);

            $durasiHari = 5 + ($i % 15);
            $tanggalSelesaiStr = date('Y-m-d', strtotime("+$durasiHari days", $divTime));

            $nomorPerkara = sprintf('%d/Pid.Sus-Anak/%04d/PN.Cpn', $i + 5, $tahun);
            $nomorPenetapanKetua = sprintf('%d/Pen.Div/%04d/PN.Cpn', $i + 2, $tahun);

            $this->cases[] = new CaseIku19Record(
                $id,
                $nomorPerkara,
                $namaAnak,
                $dakwaan,
                $tanggalDiversiStr,
                $tanggalSelesaiStr,
                $statusDiversi,
                $nomorPenetapanKetua,
                $triwulan,
                $tahun
            );
        }
    }
}
