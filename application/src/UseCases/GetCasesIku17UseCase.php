<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\CaseIku17RepositoryInterface;
use App\UseCases\DTO\GetCasesIku17Request;
use App\UseCases\DTO\GetCasesIku17Response;

class GetCasesIku17UseCase
{
    private $caseRepository;

    public function __construct(CaseIku17RepositoryInterface $caseRepository)
    {
        $this->caseRepository = $caseRepository;
    }

    /**
     * Execute UseCase to fetch IKU 1.7 Restorative Justice cases list and statistics
     *
     * @param GetCasesIku17Request $request
     * @return GetCasesIku17Response
     */
    public function execute(GetCasesIku17Request $request)
    {
        $filters = [];
        if ($request->getKategoriKriteria() !== null && $request->getKategoriKriteria() !== 'semua') {
            $filters['kategori_kriteria'] = $request->getKategoriKriteria();
        }
        if ($request->getStatusRj() !== null && $request->getStatusRj() !== 'semua') {
            $filters['status_rj'] = $request->getStatusRj();
        }
        if ($request->getPeriode() !== null && $request->getPeriode() !== 'tahunan') {
            $filters['periode'] = $request->getPeriode();
        }

        $cases = $this->caseRepository->findAll($filters);

        $totalMemenuhiKriteriaCount = count($cases);
        $berhasilRjCount = 0;
        $gagalRjCount = 0;

        foreach ($cases as $case) {
            if ($case->isBerhasil()) {
                $berhasilRjCount++;
            } else {
                $gagalRjCount++;
            }
        }

        $persentaseBerhasilRj = $totalMemenuhiKriteriaCount > 0 ? ($berhasilRjCount / $totalMemenuhiKriteriaCount) * 100 : 100.0;
        $persentaseBerhasilRj = round($persentaseBerhasilRj, 2);

        return new GetCasesIku17Response(
            $cases,
            $totalMemenuhiKriteriaCount,
            $berhasilRjCount,
            $gagalRjCount,
            $persentaseBerhasilRj
        );
    }
}
