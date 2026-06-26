<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\MigrationRepositoryInterface;
use App\UseCases\DTO\MigrationDTO;
use App\UseCases\DTO\MigrationStatusResponse;

class GetMigrationStatusUseCase
{
    private $repository;

    public function __construct(MigrationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        $status = $this->repository->getMigrationStatus();
        
        $migrationDTOs = [];
        foreach ($status->getMigrations() as $migration) {
            $migrationDTOs[] = new MigrationDTO(
                $migration->getVersion(),
                $migration->getName(),
                $migration->getFilename(),
                $migration->isApplied()
            );
        }

        return new MigrationStatusResponse(
            $status->getCurrentVersion(),
            $status->isEnabled(),
            $status->getTableName(),
            $status->getPath(),
            $status->getDatabaseName(),
            $status->getDatabaseHost(),
            $migrationDTOs
        );
    }
}
