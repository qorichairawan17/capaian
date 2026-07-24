<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku110RepositoryInterface;
use App\UseCases\DTO\GetCasesIku110Request;
use App\UseCases\DTO\GetCasesIku110Response;

class GetCasesIku110UseCase
{
    private $caseRepository;

    public function __construct(CaseIku110RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Execute UseCase to fetch IKU 1.10 civil case e-Court statistics and list
     *
     * @param GetCasesIku110Request $request
     * @return GetCasesIku110Response
     */
    public function execute(GetCasesIku110Request $request)
    {
        $filters = [];
        if ($request->getPeriode() !== null && $request->getPeriode() !== 'tahunan') {
            $filters['periode'] = $request->getPeriode();
        }
        if ($request->getMetodePendaftaran() !== null && $request->getMetodePendaftaran() !== 'semua') {
            $filters['metode_pendaftaran'] = $request->getMetodePendaftaran();
        }

        $allCases = $this->caseRepository->findAll($filters);

        $totalDiajukanCount = count($allCases);
        $ecourtCount = 0;
        $konvensionalCount = 0;

        foreach ($allCases as $case) {
            if ($case->isEcourt()) {
                $ecourtCount++;
            } else {
                $konvensionalCount++;
            }
        }

        $persentaseEcourt = $totalDiajukanCount > 0 ? ($ecourtCount / $totalDiajukanCount) * 100 : 100.0;
        $persentaseEcourt = round($persentaseEcourt, 2);

        return new GetCasesIku110Response(
            $allCases,
            $totalDiajukanCount,
            $ecourtCount,
            $konvensionalCount,
            $persentaseEcourt
        );
    }
}
