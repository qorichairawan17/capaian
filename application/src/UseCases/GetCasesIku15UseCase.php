<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku15RepositoryInterface;
use App\UseCases\DTO\GetCasesIku15Request;
use App\UseCases\DTO\GetCasesIku15Response;

class GetCasesIku15UseCase
{
    private $caseRepository;

    public function __construct(CaseIku15RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Get IKU 1.5 decision directory upload cases list and statistics based on filters
     *
     * @param GetCasesIku15Request $request
     * @return GetCasesIku15Response
     */
    public function execute(GetCasesIku15Request $request)
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

        return new GetCasesIku15Response(
            $cases,
            $totalMinutasiCount,
            $diunggahCount,
            $belumDiunggahCount,
            $persentaseDiunggah
        );
    }
}
