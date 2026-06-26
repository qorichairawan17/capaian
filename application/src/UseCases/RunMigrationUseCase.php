<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\MigrationRepositoryInterface;
use App\UseCases\DTO\MigrateResponse;

class RunMigrationUseCase
{
    private $repository;

    public function __construct(MigrationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        $result = $this->repository->migrateToLatest();
        return new MigrateResponse(
            $result['success'],
            $result['message'],
            $result['version']
        );
    }
}
