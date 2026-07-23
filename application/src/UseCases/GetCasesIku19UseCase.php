<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku19RepositoryInterface;
use App\UseCases\DTO\GetCasesIku19Request;
use App\UseCases\DTO\GetCasesIku19Response;

class GetCasesIku19UseCase
{
    private $caseRepository;

    public function __construct(CaseIku19RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Execute UseCase to fetch IKU 1.9 juvenile diversion cases list and statistics
     *
     * @param GetCasesIku19Request $request
     * @return GetCasesIku19Response
     */
    public function execute(GetCasesIku19Request $request)
    {
        $filters = [];
        if ($request->getPeriode() !== null && $request->getPeriode() !== 'tahunan') {
            $filters['periode'] = $request->getPeriode();
        }
        if ($request->getStatusDiversi() !== null && $request->getStatusDiversi() !== 'semua') {
            $filters['status_diversi'] = $request->getStatusDiversi();
        }

        $allCases = $this->caseRepository->findAll($filters);

        $totalSelesaiDiversiCount = 0;
        $berhasilDiversiCount = 0;
        $gagalDiversiCount = 0;

        foreach ($allCases as $case) {
            if ($case->isSelesaiDiversi()) {
                $totalSelesaiDiversiCount++;
                if ($case->isBerhasilDiversi()) {
                    $berhasilDiversiCount++;
                } else {
                    $gagalDiversiCount++;
                }
            }
        }

        $persentaseBerhasilDiversi = $totalSelesaiDiversiCount > 0 ? ($berhasilDiversiCount / $totalSelesaiDiversiCount) * 100 : 100.0;
        $persentaseBerhasilDiversi = round($persentaseBerhasilDiversi, 2);

        return new GetCasesIku19Response(
            $allCases,
            $totalSelesaiDiversiCount,
            $berhasilDiversiCount,
            $gagalDiversiCount,
            $persentaseBerhasilDiversi
        );
    }
}
