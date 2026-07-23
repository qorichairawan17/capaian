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

    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        if (isset($filters['tingkat_peradilan'])) {
            $tingkatTarget = strtolower($filters['tingkat_peradilan']);
            $filtered = array_filter($filtered, function(CaseIku14Record $case) use ($tingkatTarget) {
                return strtolower($case->getTingkatPeradilan()) === $tingkatTarget;
            });
        }

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

    private function generateMockData()
    {
        $tingkatList = ['Banding', 'Kasasi', 'PK'];
        $metodeList = ['Jurusita', 'Elektronik', 'Surat Tercatat'];

        for ($i = 1; $i <= 60; $i++) {
            $id = $i;
            $tingkatPeradilan = $tingkatList[$i % 3];
            $metodePengiriman = $metodeList[$i % 3];

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 5) % 25) + 1;
            $tahun = 2026;

            $diterimaTime = mktime(0, 0, 0, $month, $day, $tahun);
            $tanggalDiterimaStr = date('Y-m-d', $diterimaTime);

            // Approx 85% Tepat Waktu (<= 3 days for notification), 15% Terlambat (> 3 days)
            $isTepat = ($i % 7 !== 0);
            $durasiHari = $isTepat ? rand(0, 2) : rand(4, 8);
            $status = $isTepat ? 'Tepat Waktu' : 'Terlambat';

            $dikirimkanTime = strtotime("+{$durasiHari} days", $diterimaTime);
            $tanggalDikirimkanStr = date('Y-m-d', $dikirimkanTime);

            $suffix = ($i % 3 === 0) ? 'Pid.Sus' : 'Pid.B';
            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 15, $suffix, $tahun);

            $this->cases[] = new CaseIku14Record(
                $id,
                $nomorPerkara,
                $tingkatPeradilan,
                $metodePengiriman,
                $tanggalDiterimaStr,
                $tanggalDikirimkanStr,
                $durasiHari,
                $status,
                $triwulan,
                $tahun
            );
        }
    }
}
