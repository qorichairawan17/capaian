<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\IkuTarget;
use App\Domain\Repositories\IkuTargetRepositoryInterface;
use App\UseCases\DTO\SaveIkuTargetRequest;
use App\UseCases\DTO\SaveIkuTargetResponse;

/**
 * SaveIkuTargetUseCase
 *
 * Mengorkestrasi penyimpanan (upsert) target IKU.
 * Mendukung batch save — menerima array of requests.
 */
class SaveIkuTargetUseCase
{
    private $repository;

    public function __construct(IkuTargetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Simpan satu target IKU (upsert).
     *
     * @param SaveIkuTargetRequest $request
     * @return SaveIkuTargetResponse
     */
    public function execute(SaveIkuTargetRequest $request)
    {
        // Buat entity baru
        $target = new IkuTarget(
            null,
            $request->getIkuCode(),
            $request->getTahun(),
            $request->getPeriodeType(),
            $request->getPeriodeValue(),
            $request->getTargetValue(),
            $request->getUserId(),
            $request->getUserId()
        );

        // Validasi bisnis di Entity
        $target->validate();

        // Upsert via repository
        $result = $this->repository->upsert($target);

        if ($result) {
            return new SaveIkuTargetResponse(true, 'Target berhasil disimpan.', 1);
        }

        return new SaveIkuTargetResponse(false, 'Gagal menyimpan target.');
    }

    /**
     * Simpan batch target IKU (multiple periods sekaligus).
     *
     * @param SaveIkuTargetRequest[] $requests
     * @return SaveIkuTargetResponse
     */
    public function executeBatch(array $requests)
    {
        $savedCount = 0;
        $errors = [];

        foreach ($requests as $request) {
            try {
                $response = $this->execute($request);
                if ($response->isSuccess()) {
                    $savedCount++;
                } else {
                    $errors[] = "Periode {$request->getPeriodeValue()}: {$response->getMessage()}";
                }
            } catch (\App\Domain\Exceptions\InvalidTargetException $e) {
                $errors[] = "Periode {$request->getPeriodeValue()}: {$e->getMessage()}";
            }
        }

        if (!empty($errors)) {
            $message = "Tersimpan {$savedCount} dari " . count($requests) . " target. Error: " . implode('; ', $errors);
            return new SaveIkuTargetResponse($savedCount > 0, $message, $savedCount);
        }

        return new SaveIkuTargetResponse(true, "Semua {$savedCount} target berhasil disimpan.", $savedCount);
    }
}
