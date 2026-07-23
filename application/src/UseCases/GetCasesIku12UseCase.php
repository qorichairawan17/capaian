<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku12RepositoryInterface;
use App\UseCases\DTO\GetCasesIku12Request;
use App\UseCases\DTO\GetCasesIku12Response;

class GetCasesIku12UseCase
{
    private $caseRepository;

    public function __construct(CaseIku12RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Get IKU 1.2 cases list and statistics based on filters
     *
     * @param GetCasesIku12Request $request
     * @return GetCasesIku12Response
     */
    public function execute(GetCasesIku12Request $request)
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
        $persentaseTepatWaktu = round($persentaseTepatWaktu, 2);

        return new GetCasesIku12Response(
            $cases,
            $totalCount,
            $tepatWaktuCount,
            $terlambatCount,
            $persentaseTepatWaktu
        );
    }
}
