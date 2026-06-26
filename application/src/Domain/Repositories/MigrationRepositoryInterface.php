<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\MigrationStatus;

interface MigrationRepositoryInterface
{
    /**
     * Get the current migration status
     *
     * @return MigrationStatus
     */
    public function getMigrationStatus();

    /**
     * Migrate to the latest version
     *
     * @return array ['success' => bool, 'message' => string, 'version' => string]
     */
    public function migrateToLatest();

    /**
     * Migrate/Rollback to a specific version
     *
     * @param string $version
     * @return array ['success' => bool, 'message' => string, 'version' => string]
     */
    public function migrateToVersion($version);
}
