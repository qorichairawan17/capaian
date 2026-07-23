<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku16Record;
use App\Domain\Repositories\CaseIku16RepositoryInterface;

class MockCaseIku16Repository implements CaseIku16RepositoryInterface
{
    private $cases = [];

    public function __construct()
    {
        $this->generateMockData();
    }

    public function findAll(array $filters)
    {
        $filtered = $this->cases;

        if (isset($filters['status_eksekusi'])) {
            $statusTarget = strtolower($filters['status_eksekusi']);
            if ($statusTarget === 'diselesaikan') {
                $filtered = array_filter($filtered, function(CaseIku16Record $case) {
                    return $case->isDiselesaikan();
                });
            } else if ($statusTarget === 'dalam_proses') {
                $filtered = array_filter($filtered, function(CaseIku16Record $case) {
                    return !$case->isDiselesaikan();
                });
            }
        }

        if (isset($filters['jenis_eksekusi'])) {
            $jenisTarget = strtolower($filters['jenis_eksekusi']);
            if ($jenisTarget === 'perkara') {
                $filtered = array_filter($filtered, function(CaseIku16Record $case) {
                    return $case->getJenisEksekusi() === 'Eksekusi Terhadap Perkara';
                });
            } else if ($jenisTarget === 'hak_tanggungan' || $jenisTarget === 'ht') {
                $filtered = array_filter($filtered, function(CaseIku16Record $case) {
                    return $case->getJenisEksekusi() === 'Eksekusi Hak Tanggungan';
                });
            }
        }

        if (isset($filters['periode'])) {
            $periode = strtolower($filters['periode']); // 't1', 't2', 't3', 't4'
            if (preg_match('/^t([1-4])$/', $periode, $matches)) {
                $triwulanTarget = (int)$matches[1];
                $filtered = array_filter($filtered, function(CaseIku16Record $case) use ($triwulanTarget) {
                    return $case->getTriwulan() === $triwulanTarget;
                });
            }
        }

        return array_values($filtered);
    }

    private function generateMockData()
    {
        $pemohonList = ['PT Bank Rakyat Indonesia', 'PT Bank Mandiri', 'H. Ahmad Subardjo', 'CV Maju Bersama', 'PT Central Capital', 'Ir. Budi Santoso'];
        $termohonList = ['CV Karya Mandiri', 'PT Surya Perdana', 'Drs. Hendra Wijaya', 'Siti Rahmawati', 'PT Buana Graha', 'Joko Susilo'];
        $statusOptions = ['Berhasil Eksekusi', 'Berhasil Eksekusi', 'Berhasil Eksekusi', 'Dicabut', 'Dicoret / Non Executable', 'Dalam Proses'];

        for ($i = 1; $i <= 60; $i++) {
            $id = $i;
            $statusEksekusi = $statusOptions[$i % 6];
            $jenisEksekusi = ($i % 3 === 0) ? 'Eksekusi Hak Tanggungan' : 'Eksekusi Terhadap Perkara';

            $triwulan = ($i % 4) + 1;
            $month = ($triwulan - 1) * 3 + (($i % 3) + 1);
            $day = (($i * 5) % 25) + 1;
            $tahun = 2026;

            $permohonanTime = mktime(0, 0, 0, $month, $day, $tahun);
            $tanggalPermohonanStr = date('Y-m-d', $permohonanTime);

            $isDone = ($statusEksekusi !== 'Dalam Proses');
            $tanggalSelesaiStr = $isDone ? date('Y-m-d', strtotime("+" . rand(14, 60) . " days", $permohonanTime)) : null;

            $pemohon = $pemohonList[$i % count($pemohonList)];
            $termohon = $termohonList[$i % count($termohonList)];
            $prefix = ($jenisEksekusi === 'Eksekusi Hak Tanggungan') ? 'Pdt.Eks.HT' : 'Pdt.Eks';
            $nomorPerkara = sprintf('%d/%s/%04d/PN.Cpn', $i + 5, $prefix, $tahun);

            $this->cases[] = new CaseIku16Record(
                $id,
                $nomorPerkara,
                $jenisEksekusi,
                $pemohon,
                $termohon,
                $tanggalPermohonanStr,
                $tanggalSelesaiStr,
                $statusEksekusi,
                $triwulan,
                $tahun
            );
        }
    }
}
