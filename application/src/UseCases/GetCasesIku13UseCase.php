<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku13RepositoryInterface;
use App\UseCases\DTO\GetCasesIku13Request;
use App\UseCases\DTO\GetCasesIku13Response;

class GetCasesIku13UseCase
{
    private $caseRepository;

    public function __construct(CaseIku13RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Get IKU 1.3 cases list and statistics based on filters
     *
     * @param GetCasesIku13Request $request
     * @return GetCasesIku13Response
     */
    public function execute(GetCasesIku13Request $request)
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
        $totalMinutasiCount = count($cases);
        $diunggahCount = 0;
        $belumDiunggahCount = 0;

        foreach ($cases as $case) {
            if ($case->getStatusUpload() === 'Diunggah') {
                $diunggahCount++;
            } else {
                $belumDiunggahCount++;
            }
        }

        $persentaseDiunggah = $totalMinutasiCount > 0 ? ($diunggahCount / $totalMinutasiCount) * 100 : 100.0;
        $persentaseDiunggah = round($persentaseDiunggah, 2);

        return new GetCasesIku13Response(
            $cases,
            $totalMinutasiCount,
            $diunggahCount,
            $belumDiunggahCount,
            $persentaseDiunggah
        );
    }
}
