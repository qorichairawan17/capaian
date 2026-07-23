<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku12Record;
use App\Domain\Repositories\CaseIku12RepositoryInterface;

class MockCaseIku12Repository implements CaseIku12RepositoryInterface
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
     * @return CaseIku12Record[]
     */
    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        // Filter by Jenis Perkara
        if (isset($filters['jenis_perkara'])) {
            $filtered = array_filter($filtered, function(CaseIku12Record $case) use ($filters) {
                return strtolower($case->getJenisPerkara()) === strtolower($filters['jenis_perkara']);
            });
        }

        // Filter by Triwulan (Periode)
        if (isset($filters['periode'])) {
            $periode = strtolower($filters['periode']); // 't1', 't2', 't3', 't4'
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $triwulanTarget = (int)$matches[1];
                $filtered = array_filter($filtered, function(CaseIku12Record $case) use ($triwulanTarget) {
                    return $case->getTriwulan() === $triwulanTarget;
                });
            }
        }

        return array_values($filtered);
    }

    /**
     * Generate 60 realistic IKU 1.2 case delivery records
     */
    private function generateMockData()
    {
        for ($i = 1; $i <= 60; $i++) {
            $id = $i;
            
            // Determine case type
            $isPidana = ($i % 2 === 0);
            $jenisPerkara = $isPidana ? 'Pidana' : 'Perdata';
            $suffix = $isPidana ? (($i % 4 === 0) ? 'Pid.Sus' : 'Pid.B') : (($i % 3 === 0) ? 'Pdt.P' : 'Pdt.G');

            // Shipping method
            $isElektronik = ($i % 3 !== 0);
            $metodePengiriman = $isElektronik ? 'Elektronik (SIP)' : 'Pihak Ketiga (Pos/Ekspedisi)';

            // Quarter distribution (1 to 4)
            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 7) % 28) + 1;
            $tahun = 2026;

            // Putusan Date
            $putusanDateStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $putusanDateTime = new \DateTime($putusanDateStr);

            // Delivery Duration (Tepat waktu <= 14 hari)
            $isLate = ($i % 6 === 0);
            $durasiHari = $isLate ? (16 + ($i % 12)) : (1 + ($i % 13));

            $pengirimanDateTime = clone $putusanDateTime;
            $pengirimanDateTime->modify("+$durasiHari days");
            $tanggalPengirimanStr = $pengirimanDateTime->format('Y-m-d');

            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 10, $suffix, $tahun);
            $status = ($durasiHari <= 14) ? 'Tepat Waktu' : 'Terlambat';

            $this->cases[] = new CaseIku12Record(
                $id,
                $nomorPerkara,
                $jenisPerkara,
                $metodePengiriman,
                $putusanDateStr,
                $tanggalPengirimanStr,
                $durasiHari,
                $status,
                $triwulan,
                $tahun
            );
        }
    }
}
