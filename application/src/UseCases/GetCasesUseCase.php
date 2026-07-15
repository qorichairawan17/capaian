<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseRepositoryInterface;
use App\UseCases\DTO\GetCasesRequest;
use App\UseCases\DTO\GetCasesResponse;

class GetCasesUseCase
{
    private $caseRepository;

    public function __construct(CaseRepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Get cases list and statistics based on filters
     *
     * @param GetCasesRequest $request
     * @return GetCasesResponse
     */
    public function execute(GetCasesRequest $request)
    {
        // Build filters array
        $filters = [];
        if ($request->getJenisPerkara() !== null && $request->getJenisPerkara() !== 'semua') {
            $filters['jenis_perkara'] = $request->getJenisPerkara();
        }
        if ($request->getPeriode() !== null && $request->getPeriode() !== 'tahunan') {
            $filters['periode'] = $request->getPeriode();
        }

        // Fetch filtered cases from repository
        $cases = $this->caseRepository->findAll($filters);

        // Calculate statistics
        $totalCount = count($cases);
        $tepatWaktuCount = 0;
        $terlambatCount = 0;

        foreach ($cases as $case) {
            if ($case->getStatus() === 'Tepat Waktu') {
                $tepatWaktuCount++;
            } else {
                $terlambatCount++;
            }
        }

        $persentaseTepatWaktu = $totalCount > 0 ? ($tepatWaktuCount / $totalCount) * 100 : 100.0;
        // Format to 2 decimal places as a float
        $persentaseTepatWaktu = round($persentaseTepatWaktu, 2);

        return new GetCasesResponse(
            $cases,
            $totalCount,
            $tepatWaktuCount,
            $terlambatCount,
            $persentaseTepatWaktu
        );
    }
}
