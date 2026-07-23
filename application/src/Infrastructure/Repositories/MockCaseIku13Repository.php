<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku13Record;
use App\Domain\Repositories\CaseIku13RepositoryInterface;

class MockCaseIku13Repository implements CaseIku13RepositoryInterface
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
     * @return CaseIku13Record[]
     */
    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        // Filter by Jenis Perkara
        if (isset($filters['jenis_perkara'])) {
            $filtered = array_filter($filtered, function(CaseIku13Record $case) use ($filters) {
                return strtolower($case->getJenisPerkara()) === strtolower($filters['jenis_perkara']);
            });
        }

        // Filter by Triwulan (Periode)
        if (isset($filters['periode'])) {
            $periode = strtolower($filters['periode']); // 't1', 't2', 't3', 't4'
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $triwulanTarget = (int)$matches[1];
                $filtered = array_filter($filtered, function(CaseIku13Record $case) use ($triwulanTarget) {
                    return $case->getTriwulan() === $triwulanTarget;
                });
            }
        }

        return array_values($filtered);
    }

    /**
     * Generate 60 realistic IKU 1.3 directory upload case records
     */
    private function generateMockData()
    {
        for ($i = 1; $i <= 60; $i++) {
            $id = $i;
            
            // Determine case type
            $isPidana = ($i % 2 === 0);
            $jenisPerkara = $isPidana ? 'Pidana' : 'Perdata';
            $suffix = $isPidana ? (($i % 4 === 0) ? 'Pid.Sus' : 'Pid.B') : (($i % 3 === 0) ? 'Pdt.P' : 'Pdt.G');

            // Quarter distribution (1 to 4)
            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 7) % 28) + 1;
            $tahun = 2026;

            $minutasiDateStr = sprintf('%04d-%02d-%02d', $tahun, $month, $day);
            $minutasiDateTime = new \DateTime($minutasiDateStr);

            // Upload Status (Approx 90% uploaded, 10% pending)
            $isUploaded = ($i % 10 !== 0);
            $statusUpload = $isUploaded ? 'Diunggah' : 'Belum Diunggah';

            if ($isUploaded) {
                // Uploaded on the same day or 1 day after minutasi
                $delayDays = ($i % 2);
                $unggahDateTime = clone $minutasiDateTime;
                $unggahDateTime->modify("+$delayDays days");
                $tanggalUnggahStr = $unggahDateTime->format('Y-m-d');
                $urlDirektori = 'https://putusan3.mahkamahagung.go.id/direktori/putusan/' . md5($i . 'putusan');
            } else {
                $tanggalUnggahStr = null;
                $urlDirektori = '';
            }

            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 10, $suffix, $tahun);

            $this->cases[] = new CaseIku13Record(
                $id,
                $nomorPerkara,
                $jenisPerkara,
                $minutasiDateStr,
                $tanggalUnggahStr,
                $statusUpload,
                $urlDirektori,
                $triwulan,
                $tahun
            );
        }
    }
}
