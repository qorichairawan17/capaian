<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku14RepositoryInterface;
use App\UseCases\DTO\GetCasesIku14Request;
use App\UseCases\DTO\GetCasesIku14Response;

class GetCasesIku14UseCase
{
    private $caseRepository;

    public function __construct(CaseIku14RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Get IKU 1.4 cases list and statistics based on filters
     *
     * @param GetCasesIku14Request $request
     * @return GetCasesIku14Response
     */
    public function execute(GetCasesIku14Request $request)
    {
        // Build filters array
        $filters = [];
        if ($request->getJenisPengajuan() !== null && $request->getJenisPengajuan() !== 'semua') {
            $filters['jenis_pengajuan'] = $request->getJenisPengajuan();
        }
        if ($request->getPeriode() !== null && $request->getPeriode() !== 'tahunan') {
            $filters['periode'] = $request->getPeriode();
        }

        // Fetch filtered cases from repository
        $cases = $this->caseRepository->findAll($filters);

        // Calculate statistics
        $totalDiajukanCount = count($cases);
        $eCourtCount = 0;
        $konvensionalCount = 0;

        foreach ($cases as $case) {
            if (strtolower($case->getJenisPengajuan()) === 'e-court') {
                $eCourtCount++;
            } else {
                $konvensionalCount++;
            }
        }

        $persentaseECourt = $totalDiajukanCount > 0 ? ($eCourtCount / $totalDiajukanCount) * 100 : 100.0;
        $persentaseECourt = round($persentaseECourt, 2);

        return new GetCasesIku14Response(
            $cases,
            $totalDiajukanCount,
            $eCourtCount,
            $konvensionalCount,
            $persentaseECourt
        );
    }
}
