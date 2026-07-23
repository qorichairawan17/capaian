<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku15Record;
use App\Domain\Repositories\CaseIku15RepositoryInterface;

class MockCaseIku15Repository implements CaseIku15RepositoryInterface
{
    private $cases = [];

    public function __construct()
    {
        $this->generateMockData();
    }

    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        if (isset($filters['jenis_perkara'])) {
            $jenisTarget = strtolower($filters['jenis_perkara']);
            $filtered = array_filter($filtered, function(CaseIku15Record $case) use ($jenisTarget) {
                return strtolower($case->getJenisPerkara()) === $jenisTarget;
            });
        }

        if (isset($filters['periode'])) {
            $periode = strtolower($filters['periode']); // 't1', 't2', 't3', 't4'
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $triwulanTarget = (int)$matches[1];
                $filtered = array_filter($filtered, function(CaseIku15Record $case) use ($triwulanTarget) {
                    return $case->getTriwulan() === $triwulanTarget;
                });
            }
        }

        return array_values($filtered);
    }

    private function generateMockData()
    {
        for ($i = 1; $i <= 60; $i++) {
            $id = $i;
            $isPidana = ($i % 2 === 0);
            $jenisPerkara = $isPidana ? 'Pidana' : 'Perdata';

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 5) % 25) + 1;
            $tahun = 2026;

            $minutasiTime = mktime(0, 0, 0, $month, $day, $tahun);
            $tanggalMinutasiStr = date('Y-m-d', $minutasiTime);

            // Approx 90% Uploaded on time, 10% Belum Diunggah
            $isUploaded = ($i % 10 !== 0);
            $statusUpload = $isUploaded ? 'Diunggah' : 'Belum Diunggah';

            $tanggalUnggahStr = $isUploaded ? date('Y-m-d', strtotime("+" . rand(0, 1) . " days", $minutasiTime)) : null;
            $urlDirektori = $isUploaded ? "https://putusan3.mahkamahagung.go.id/direktori/putusan/doc{$i}.html" : null;

            $prefix = $isPidana ? 'Pid.B' : 'Pdt.G';
            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 10, $prefix, $tahun);

            $this->cases[] = new CaseIku15Record(
                $id,
                $nomorPerkara,
                $jenisPerkara,
                $tanggalMinutasiStr,
                $tanggalUnggahStr,
                $statusUpload,
                $urlDirektori,
                $triwulan,
                $tahun
            );
        }
    }
}
