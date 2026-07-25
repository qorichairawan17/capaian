<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\IkuTargetRepositoryInterface;
use App\UseCases\DTO\GetIkuTargetsRequest;
use App\UseCases\DTO\GetIkuTargetsResponse;

/**
 * GetIkuTargetsUseCase
 *
 * Mengambil data target IKU berdasarkan filter (kode IKU, tahun, tipe periode).
 */
class GetIkuTargetsUseCase
{
    private $repository;

    public function __construct(IkuTargetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Ambil target berdasarkan filter.
     *
     * @param GetIkuTargetsRequest $request
     * @return GetIkuTargetsResponse
     */
    public function execute(GetIkuTargetsRequest $request)
    {
        $targets = $this->repository->findByFilters(
            $request->getIkuCode(),
            $request->getTahun(),
            $request->getPeriodeType()
        );

        return new GetIkuTargetsResponse(
            $targets,
            $request->getIkuCode(),
            $request->getTahun(),
            $request->getPeriodeType()
        );
    }
}
