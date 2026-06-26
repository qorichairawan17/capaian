<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class MigrationStatus
{
    private $currentVersion;
    private $isEnabled;
    private $tableName;
    private $path;
    private $databaseName;
    private $databaseHost;
    private $migrations;

    /**
     * @param string $currentVersion
     * @param bool $isEnabled
     * @param string $tableName
     * @param string $path
     * @param string $databaseName
     * @param string $databaseHost
     * @param Migration[] $migrations
     */
    public function __construct($currentVersion, $isEnabled, $tableName, $path, $databaseName, $databaseHost, array $migrations)
    {
        $this->currentVersion = $currentVersion;
        $this->isEnabled = $isEnabled;
        $this->tableName = $tableName;
        $this->path = $path;
        $this->databaseName = $databaseName;
        $this->databaseHost = $databaseHost;
        $this->migrations = $migrations;
    }

    public function getCurrentVersion() { return $this->currentVersion; }
    public function isEnabled() { return $this->isEnabled; }
    public function getTableName() { return $this->tableName; }
    public function getPath() { return $this->path; }
    public function getDatabaseName() { return $this->databaseName; }
    public function getDatabaseHost() { return $this->databaseHost; }
    public function getMigrations() { return $this->migrations; }
}
