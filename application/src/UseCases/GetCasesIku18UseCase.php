<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku18RepositoryInterface;
use App\UseCases\DTO\GetCasesIku18Request;
use App\UseCases\DTO\GetCasesIku18Response;

class GetCasesIku18UseCase
{
    private $caseRepository;

    public function __construct(CaseIku18RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Execute UseCase to fetch IKU 1.8 mediation cases list and statistics
     *
     * @param GetCasesIku18Request $request
     * @return GetCasesIku18Response
     */
    public function execute(GetCasesIku18Request $request)
    {
        $filters = [];
        if ($request->getPeriode() !== null && $request->getPeriode() !== 'tahunan') {
            $filters['periode'] = $request->getPeriode();
        }
        if ($request->getStatusMediasi() !== null && $request->getStatusMediasi() !== 'semua') {
            $filters['status_mediasi'] = $request->getStatusMediasi();
        }

        $allCases = $this->caseRepository->findAll($filters);

        $totalWajibMediasiCount = 0;
        $berhasilMediasiCount = 0;
        $gagalMediasiCount = 0;

        foreach ($allCases as $case) {
            if ($case->isWajibMediasi()) {
                $totalWajibMediasiCount++;
                if ($case->isBerhasilMediasi()) {
                    $berhasilMediasiCount++;
                } else {
                    $gagalMediasiCount++;
                }
            }
        }

        $persentaseBerhasilMediasi = $totalWajibMediasiCount > 0 ? ($berhasilMediasiCount / $totalWajibMediasiCount) * 100 : 100.0;
        $persentaseBerhasilMediasi = round($persentaseBerhasilMediasi, 2);

        return new GetCasesIku18Response(
            $allCases,
            $totalWajibMediasiCount,
            $berhasilMediasiCount,
            $gagalMediasiCount,
            $persentaseBerhasilMediasi
        );
    }
}
