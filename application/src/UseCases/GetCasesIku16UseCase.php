<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku16RepositoryInterface;
use App\UseCases\DTO\GetCasesIku16Request;
use App\UseCases\DTO\GetCasesIku16Response;

class GetCasesIku16UseCase
{
    private $caseRepository;

    public function __construct(CaseIku16RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Execute UseCase to fetch IKU 1.6 execution application cases list and statistics
     *
     * @param GetCasesIku16Request $request
     * @return GetCasesIku16Response
     */
    public function execute(GetCasesIku16Request $request)
    {
        $filters = [];
        if ($request->getStatusEksekusi() !== null && $request->getStatusEksekusi() !== 'semua') {
            $filters['status_eksekusi'] = $request->getStatusEksekusi();
        }
        if ($request->getJenisEksekusi() !== null && $request->getJenisEksekusi() !== 'semua') {
            $filters['jenis_eksekusi'] = $request->getJenisEksekusi();
        }
        if ($request->getPeriode() !== null && $request->getPeriode() !== 'tahunan') {
            $filters['periode'] = $request->getPeriode();
        }

        $cases = $this->caseRepository->findAll($filters);

        $totalPermohonanCount = count($cases);
        $diselesaikanCount = 0;
        $dalamProsesCount = 0;

        foreach ($cases as $case) {
            if ($case->isDiselesaikan()) {
                $diselesaikanCount++;
            } else {
                $dalamProsesCount++;
            }
        }

        $persentaseDiselesaikan = $totalPermohonanCount > 0 ? ($diselesaikanCount / $totalPermohonanCount) * 100 : 100.0;
        $persentaseDiselesaikan = round($persentaseDiselesaikan, 2);

        return new GetCasesIku16Response(
            $cases,
            $totalPermohonanCount,
            $diselesaikanCount,
            $dalamProsesCount,
            $persentaseDiselesaikan
        );
    }
}
