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
     * Get IKU 1.4 criminal appeal/cassation/PK decision copy delivery cases list and statistics
     *
     * @param GetCasesIku14Request $request
     * @return GetCasesIku14Response
     */
    public function execute(GetCasesIku14Request $request)
    {
        // Build filters array
        $filters = [];
        if ($request->getTingkatPeradilan() !== null && $request->getTingkatPeradilan() !== 'semua') {
            $filters['tingkat_peradilan'] = $request->getTingkatPeradilan();
        }
        if ($request->getPeriode() !== null && $request->getPeriode() !== 'tahunan') {
            $filters['periode'] = $request->getPeriode();
        }

        // Fetch filtered cases from repository
        $cases = $this->caseRepository->findAll($filters);

        // Calculate statistics
        $totalDiterimaCount = count($cases);
        $tepatWaktuCount = 0;
        $terlambatCount = 0;

        foreach ($cases as $case) {
            if ($case->getStatus() === 'Tepat Waktu') {
                $tepatWaktuCount++;
            } else {
                $terlambatCount++;
            }
        }

        $persentaseTepatWaktu = $totalDiterimaCount > 0 ? ($tepatWaktuCount / $totalDiterimaCount) * 100 : 100.0;
        $persentaseTepatWaktu = round($persentaseTepatWaktu, 2);

        return new GetCasesIku14Response(
            $cases,
            $totalDiterimaCount,
            $tepatWaktuCount,
            $terlambatCount,
            $persentaseTepatWaktu
        );
    }
}
