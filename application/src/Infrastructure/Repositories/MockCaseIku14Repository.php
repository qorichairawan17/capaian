<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku14Record;
use App\Domain\Repositories\CaseIku14RepositoryInterface;

class MockCaseIku14Repository implements CaseIku14RepositoryInterface
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
     * @return CaseIku14Record[]
     */
    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        // Filter by Jenis Pengajuan
        if (isset($filters['jenis_pengajuan'])) {
            $pengajuan = strtolower($filters['jenis_pengajuan']);
            $filtered = array_filter($filtered, function(CaseIku14Record $case) use ($pengajuan) {
                if ($pengajuan === 'ecourt') {
                    return strtolower($case->getJenisPengajuan()) === 'e-court';
                }
                return strtolower($case->getJenisPengajuan()) === strtolower($pengajuan);
            });
        }

        // Filter by Triwulan (Periode)
        if (isset($filters['periode'])) {
            $periode = strtolower($filters['periode']); // 't1', 't2', 't3', 't4'
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $triwulanTarget = (int)$matches[1];
                $filtered = array_filter($filtered, function(CaseIku14Record $case) use ($triwulanTarget) {
                    return $case->getTriwulan() === $triwulanTarget;
                });
            }
        }

        return array_values($filtered);
    }

    /**
     * Generate 60 realistic IKU 1.4 civil appeal case records
     */
    private function generateMockData()
    {
        $pembandingList = [
            'PT Bank Central Nusantara',
            'H. Bambang Sugiarto',
            'CV Tri Jaya Mandiri',
            'Drs. Irwan Wijaya',
            'Siti Rahmawati, S.H.',
            'PT Graha Pembangunan',
            'Koperasi Simpan Pinjam Sejahtera',
            'Dr. Hendra Saputra'
        ];

        $terbandingList = [
            'Dinas Perumahan Rakyat & Kawasan Pemukiman',
            'Hj. Nurul Hasanah',
            'PT Asuransi Jiwa Utama',
            'Budi Santoso',
            'CV Sukses Bersama',
            'Ahmad Fauzi',
            'PT Citra Perdana',
            'Yayasan Pendidikan Bangsa'
        ];

        for ($i = 1; $i <= 60; $i++) {
            $id = $i;
            
            // Submission type (Approx 80% e-Court, 20% Konvensional)
            $isECourt = ($i % 5 !== 0);
            $jenisPengajuan = $isECourt ? 'e-Court' : 'Konvensional';
            $statusECourt = $isECourt ? 'e-Court Active' : 'Konvensional';

            // Quarter distribution (1 to 4)
            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 7) % 28) + 1;
            $tahun = 2026;

            $pengajuanDateStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $nomorPerkara = sprintf('%d/PDT/%04d/PT.Cpn', $i + 15, $tahun);

            $pembanding = $pembandingList[$i % count($pembandingList)];
            $terbanding = $terbandingList[$i % count($terbandingList)];

            $this->cases[] = new CaseIku14Record(
                $id,
                $nomorPerkara,
                $jenisPengajuan,
                $pengajuanDateStr,
                $pembanding,
                $terbanding,
                $statusECourt,
                $triwulan,
                $tahun
            );
        }
    }
}
