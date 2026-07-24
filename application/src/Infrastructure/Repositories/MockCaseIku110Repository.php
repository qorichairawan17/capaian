<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku110Record;
use App\Domain\Repositories\CaseIku110RepositoryInterface;

/**
 * MockCaseIku110Repository
 *
 * Repository penyedia 60 mock records realistis untuk pengembangan & pengujian IKU 1.10.
 */
class MockCaseIku110Repository implements CaseIku110RepositoryInterface
{
    private $mockRecords = [];

    public function __construct()
    {
        $this->generateMockData();
    }

    public function findAll(array $filters)
    {
        $filtered = $this->mockRecords;

        // Filter Metode Pendaftaran
        if (!empty($filters['metode_pendaftaran'])) {
            $metodeFilter = strtolower($filters['metode_pendaftaran']);
            $filtered = array_filter($filtered, function (CaseIku110Record $record) use ($metodeFilter) {
                if ($metodeFilter === 'ecourt') {
                    return $record->isEcourt();
                } elseif ($metodeFilter === 'konvensional') {
                    return $record->isKonvensional();
                }
                return true;
            });
        }

        // Filter Periode / Triwulan
        if (!empty($filters['periode'])) {
            $periode = strtolower($filters['periode']);
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $targetTriwulan = (int) $matches[1];
                $filtered = array_filter($filtered, function (CaseIku110Record $record) use ($targetTriwulan) {
                    return $record->getTriwulan() === $targetTriwulan;
                });
            }
        }

        return array_values($filtered);
    }

    private function generateMockData()
    {
        $jenisPerdataList = ['Gugatan', 'Permohonan', 'Gugatan Sederhana'];

        $pihakList = [
            'PT. Maju Sejahtera vs Hendra Gunawan',
            'Siti Aminah vs Ahmad Dahlan',
            'CV. Karya Mandiri vs Budi Santoso',
            'Bambang Wijaya vs PT. Bank Rakyat Indonesia',
            'Rina Rosdiana vs Dedi Supriadi',
            'Ir. H. Mansyur vs PT. Asuransi Jiwa',
            'Hj. Fatimah vs Koperasi Simpan Pinjam',
            'Yusuf Habibie vs PT. Pembangunan Jaya',
            'Dewi Lestari vs Anton Wibowo',
            'CV. Berkah Utama vs PT. Mitra Sarana'
        ];

        // Generate 60 records (48 e-Court = 80%, 12 Konvensional = 20%)
        for ($i = 1; $i <= 60; $i++) {
            $triwulan = (($i - 1) % 4) + 1;
            $month = str_pad(($triwulan - 1) * 3 + rand(1, 3), 2, '0', STR_PAD_LEFT);
            $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
            $tanggalPendaftaran = "2026-{$month}-{$day}";

            $jenisPerdata = $jenisPerdataList[$i % 3];
            $paraPihak = $pihakList[($i - 1) % count($pihakList)];

            // 80% e-Court, 20% Konvensional
            $isEcourt = ($i % 5 !== 0);
            $metodePendaftaran = $isEcourt ? 'e-Court' : 'Konvensional';
            $nomorRegisterEcourt = $isEcourt ? 'EC-PN.JAG/2026/' . str_pad($i, 4, '0', STR_PAD_LEFT) : '-';

            $kodePerkara = ($jenisPerdata === 'Gugatan') ? 'Pdt.G' : (($jenisPerdata === 'Permohonan') ? 'Pdt.P' : 'Pdt.GS');
            $nomorPerkara = "{$i}/{$kodePerkara}/2026/PN Jkt";

            $this->mockRecords[] = new CaseIku110Record(
                $i,
                $nomorPerkara,
                $paraPihak,
                $jenisPerdata,
                $metodePendaftaran,
                $tanggalPendaftaran,
                $nomorRegisterEcourt,
                $triwulan,
                2026
            );
        }
    }
}
