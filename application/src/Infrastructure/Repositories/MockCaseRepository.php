<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseRecord;
use App\Domain\Repositories\CaseRepositoryInterface;

class MockCaseRepository implements CaseRepositoryInterface
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
     * @return CaseRecord[]
     */
    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        // Filter by Jenis Perkara
        if (isset($filters['jenis_perkara'])) {
            $filtered = array_filter($filtered, function(CaseRecord $case) use ($filters) {
                return strtolower($case->getJenisPerkara()) === strtolower($filters['jenis_perkara']);
            });
        }

        // Filter by Triwulan (Periode)
        if (isset($filters['periode'])) {
            $periode = strtolower($filters['periode']); // 't1', 't2', 't3', 't4'
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $triwulanTarget = (int)$matches[1];
                $filtered = array_filter($filtered, function(CaseRecord $case) use ($triwulanTarget) {
                    return $case->getTriwulan() === $triwulanTarget;
                });
            }
        }

        // Return values array
        return array_values($filtered);
    }

    /**
     * Generate 60 realistic district court case records
     */
    private function generateMockData()
    {
        $pidanaClassifications = [
            'Pencurian dengan Pemberatan',
            'Penganiayaan Ringan',
            'Penyalahgunaan Narkotika',
            'Pelanggaran Lalu Lintas',
            'Penipuan Kontrak Kerja',
            'Penggelapan dalam Jabatan',
            'Pengeroyokan',
            'KDRT (Kekerasan Dalam Rumah Tangga)'
        ];

        $perdataClassifications = [
            'Wanprestasi Perjanjian Kredit',
            'Perbuatan Melawan Hukum (Sengketa Lahan)',
            'Cerai Gugat',
            'Cerai Talak',
            'Pembagian Harta Bersama',
            'Gugatan Sederhana Wanprestasi',
            'Permohonan Ganti Nama',
            'Sengketa Waris'
        ];

        for ($i = 1; $i <= 60; $i++) {
            $id = $i;
            
            // Determine case type
            $isPidana = ($i % 2 === 0);
            $jenisPerkara = $isPidana ? 'Pidana' : 'Perdata';
            
            // Select classification & code suffix
            if ($isPidana) {
                $klasifikasi = $pidanaClassifications[$i % count($pidanaClassifications)];
                $suffix = ($i % 4 === 0) ? 'Pid.Sus' : 'Pid.B';
            } else {
                $klasifikasi = $perdataClassifications[$i % count($perdataClassifications)];
                $suffix = ($i % 3 === 0) ? 'Pdt.P' : 'Pdt.G';
            }

            // Distribute across quarters (Q1 - Q4)
            $triwulan = ($i % 4) + 1;
            
            // Determine month in the target quarter
            // Q1: 1, 2, 3; Q2: 4, 5, 6; Q3: 7, 8, 9; Q4: 10, 11, 12
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 7) % 28) + 1;
            $tahun = 2026;
            
            $registrasiDateStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $registrasiDateTime = new \DateTime($registrasiDateStr);

            // Determine duration to Putusan
            $isSlow = ($i % 7 === 0);
            if ($isSlow) {
                // Decision duration (140 to 165 days)
                $durasiPutusanHari = 140 + ($i % 26);
            } else {
                // Decision duration (10 to 105 days)
                $durasiPutusanHari = 10 + (($i * 17) % 96);
            }

            // Calculate putusan date
            $putusanDateTime = clone $registrasiDateTime;
            $putusanDateTime->modify("+$durasiPutusanHari days");
            $tanggalPutusanStr = $putusanDateTime->format('Y-m-d');

            // Determine duration from Putusan to Minutasi (1 to 7 days)
            $durasiMinutasiHari = 1 + ($i % 7);
            $minutasiDateTime = clone $putusanDateTime;
            $minutasiDateTime->modify("+$durasiMinutasiHari days");
            $tanggalMinutasiStr = $minutasiDateTime->format('Y-m-d');

            // Total duration (Registrasi to Minutasi)
            $durasiHari = $registrasiDateTime->diff($minutasiDateTime)->days;

            // Format case number
            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 10, $suffix, $tahun);

            // Status based on total duration (SEMA No 2 Tahun 2014 limit is 5 months / 150 days)
            $status = ($durasiHari <= 150) ? 'Tepat Waktu' : 'Terlambat';

            $this->cases[] = new CaseRecord(
                $id,
                $nomorPerkara,
                $jenisPerkara,
                $klasifikasi,
                $registrasiDateStr,
                $tanggalPutusanStr,
                $tanggalMinutasiStr,
                $durasiHari,
                $status,
                $triwulan,
                $tahun
            );
        }
    }
}
