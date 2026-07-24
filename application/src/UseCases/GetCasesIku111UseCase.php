<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku111RepositoryInterface;
use App\UseCases\DTO\GetCasesIku111Request;
use App\UseCases\DTO\GetCasesIku111Response;

class GetCasesIku111UseCase
{
    private $caseRepository;

    public function __construct(CaseIku111RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Execute UseCase to fetch IKU 1.11 criminal case e-Berpadu delegation statistics and list
     *
     * @param GetCasesIku111Request $request
     * @return GetCasesIku111Response
     */
    public function execute(GetCasesIku111Request $request)
    {
        $filters = [];
        if ($request->getPeriode() !== null && $request->getPeriode() !== 'tahunan') {
            $filters['periode'] = $request->getPeriode();
        }
        if ($request->getMetodePelimpahan() !== null && $request->getMetodePelimpahan() !== 'semua') {
            $filters['metode_pelimpahan'] = $request->getMetodePelimpahan();
        }

        $allCases = $this->caseRepository->findAll($filters);

        $totalDilimpahkanCount = count($allCases);
        $eberpaduCount = 0;
        $konvensionalCount = 0;

        foreach ($allCases as $case) {
            if ($case->isEberpadu()) {
                $eberpaduCount++;
            } else {
                $konvensionalCount++;
            }
        }

        $persentaseEberpadu = $totalDilimpahkanCount > 0 ? ($eberpaduCount / $totalDilimpahkanCount) * 100 : 100.0;
        $persentaseEberpadu = round($persentaseEberpadu, 2);

        return new GetCasesIku111Response(
            $allCases,
            $totalDilimpahkanCount,
            $eberpaduCount,
            $konvensionalCount,
            $persentaseEberpadu
        );
    }
}
