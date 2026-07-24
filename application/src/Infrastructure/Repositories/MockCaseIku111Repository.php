<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku111Record;
use App\Domain\Repositories\CaseIku111RepositoryInterface;

/**
 * MockCaseIku111Repository
 *
 * Repository penyedia 60 mock records realistis untuk pengembangan & pengujian IKU 1.11.
 */
class MockCaseIku111Repository implements CaseIku111RepositoryInterface
{
    private $mockRecords = [];

    public function __construct()
    {
        $this->generateMockData();
    }

    public function findAll(array $filters)
    {
        $filtered = $this->mockRecords;

        // Filter Metode Pelimpahan
        if (!empty($filters['metode_pelimpahan'])) {
            $metodeFilter = strtolower($filters['metode_pelimpahan']);
            $filtered = array_filter($filtered, function (CaseIku111Record $record) use ($metodeFilter) {
                if ($metodeFilter === 'eberpadu') {
                    return $record->isEberpadu();
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
                $filtered = array_filter($filtered, function (CaseIku111Record $record) use ($targetTriwulan) {
                    return $record->getTriwulan() === $targetTriwulan;
                });
            }
        }

        return array_values($filtered);
    }

    private function generateMockData()
    {
        $jenisPidanaList = ['Pidana Biasa', 'Pidana Singkat', 'Pidana Cepat', 'Pidana Anak'];

        $terdakwaList = [
            'Rahmat Hidayat bin Abdullah',
            'Suryadi Perkasa',
            'Agus Supriyanto bin Sukarno',
            'Iwan Setiawan alias Coban',
            'M. Nur Rofiq',
            'Hendra Pratama',
            'Andi Susanto bin H. Hasan',
            'Bambang Herman',
            'Fikri Ardiansyah',
            'Zulkarnain bin Muchtar'
        ];

        $kejaksaanList = [
            'Kejaksaan Negeri Jakarta Pusat',
            'Kejaksaan Negeri Jakarta Selatan',
            'Kejaksaan Negeri Jakarta Barat'
        ];

        // Generate 60 records (51 e-Berpadu = 85%, 9 Konvensional = 15%)
        for ($i = 1; $i <= 60; $i++) {
            $triwulan = (($i - 1) % 4) + 1;
            $month = str_pad(($triwulan - 1) * 3 + rand(1, 3), 2, '0', STR_PAD_LEFT);
            $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
            $tanggalPelimpahan = "2026-{$month}-{$day}";

            $jenisPidana = $jenisPidanaList[$i % 4];
            $namaTerdakwa = $terdakwaList[($i - 1) % count($terdakwaList)];
            $kejaksaanPenuntut = $kejaksaanList[($i - 1) % count($kejaksaanList)];

            // 85% e-Berpadu, 15% Konvensional
            $isEberpadu = ($i % 7 !== 0);
            $metodePelimpahan = $isEberpadu ? 'e-Berpadu' : 'Konvensional';
            $nomorRegisterEberpadu = $isEberpadu ? 'EBD/PID/2026/' . str_pad($i, 4, '0', STR_PAD_LEFT) : '-';

            $kodePerkara = ($jenisPidana === 'Pidana Biasa') ? 'Pid.B' : (($jenisPidana === 'Pidana Singkat') ? 'Pid.S' : (($jenisPidana === 'Pidana Cepat') ? 'Pid.C' : 'Pid.Sus-Anak'));
            $nomorPerkara = "{$i}/{$kodePerkara}/2026/PN Jkt";

            $this->mockRecords[] = new CaseIku111Record(
                $i,
                $nomorPerkara,
                $namaTerdakwa,
                $jenisPidana,
                $metodePelimpahan,
                $tanggalPelimpahan,
                $nomorRegisterEberpadu,
                $kejaksaanPenuntut,
                $triwulan,
                2026
            );
        }
    }
}
