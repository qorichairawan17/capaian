<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku18Record;
use App\Domain\Repositories\CaseIku18RepositoryInterface;

class MockCaseIku18Repository implements CaseIku18RepositoryInterface
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
     * @return CaseIku18Record[]
     */
    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        // Filter by Status Mediasi
        if (isset($filters['status_mediasi'])) {
            $statusMediasi = strtolower($filters['status_mediasi']);
            $filtered = array_filter($filtered, function(CaseIku18Record $case) use ($statusMediasi) {
                if ($statusMediasi === 'berhasil') {
                    return $case->isBerhasilMediasi();
                } else if ($statusMediasi === 'gagal' || $statusMediasi === 'tidak_berhasil') {
                    return $case->isWajibMediasi() && !$case->isBerhasilMediasi();
                }
                return true;
            });
        }

        // Filter by Triwulan (Periode)
        if (isset($filters['periode'])) {
            $periode = strtolower($filters['periode']); // 't1', 't2', 't3', 't4'
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $triwulanTarget = (int)$matches[1];
                $filtered = array_filter($filtered, function(CaseIku18Record $case) use ($triwulanTarget) {
                    return $case->getTriwulan() === $triwulanTarget;
                });
            }
        }

        return array_values($filtered);
    }

    /**
     * Generate 60 realistic mediation case records
     */
    private function generateMockData()
    {
        $pihakList = [
            'Siti Aminah / Budi Santoso',
            'PT Maju Bersama / CV Karya Mandiri',
            'H. Abdul Rahman / Drs. Hendra Wijaya',
            'Dewi Lestari / Ahmad Subardjo',
            'Rizky Pratama / PT Bank Mandiri',
            'Ir. Bambang Tri / Joko Susilo'
        ];

        $mediatorHakimList = [
            'Dr. H. Ahmad Yani, S.H., M.H.',
            'Siti Rahmah, S.H., M.H.',
            'Bambang Sujipto, S.H., M.Hum.'
        ];

        $mediatorNonHakimList = [
            'Prof. Dr. Irfan, S.H., C.Med.',
            'Dewi Sartika, S.H., M.Kn., C.Med.',
            'H. Lukman Hakim, S.Ag., M.H., C.Med.'
        ];

        $hasilOptions = [
            'Berhasil Seluruhnya (Akta Perdamaian)',
            'Berhasil Seluruhnya (Akta Perdamaian)',
            'Berhasil Seluruhnya (Pencabutan)',
            'Berhasil Sebagian',
            'Tidak Berhasil',
            'Tidak Dapat Dilaksanakan'
        ];

        for ($i = 1; $i <= 60; $i++) {
            $id = $i;
            $paraPihak = $pihakList[$i % count($pihakList)];
            
            $isHakim = ($i % 2 === 0);
            $jenisMediator = $isHakim ? 'Mediator Hakim' : 'Mediator Non-Hakim';
            $mediator = $isHakim 
                ? $mediatorHakimList[$i % count($mediatorHakimList)] 
                : $mediatorNonHakimList[$i % count($mediatorNonHakimList)];

            $hasilMediasi = $hasilOptions[$i % count($hasilOptions)];

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 5) % 25) + 1;
            $tahun = 2026;

            $tanggalMediasiStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $medTime = strtotime($tanggalMediasiStr);

            $durasiHari = 7 + ($i % 21);
            $tanggalSelesaiStr = date('Y-m-d', strtotime("+$durasiHari days", $medTime));

            $nomorPerkara = sprintf('%d/Pdt.G/%04d/PN.Cpn', $i + 15, $tahun);

            $this->cases[] = new CaseIku18Record(
                $id,
                $nomorPerkara,
                $paraPihak,
                $mediator,
                $jenisMediator,
                $tanggalMediasiStr,
                $tanggalSelesaiStr,
                $hasilMediasi,
                $triwulan,
                $tahun
            );
        }
    }
}
