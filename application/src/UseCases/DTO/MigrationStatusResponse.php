<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class MigrationStatusResponse
{
    public $currentVersion;
    public $isEnabled;
    public $tableName;
    public $path;
    public $databaseName;
    public $databaseHost;
    public $migrations; // Array of MigrationDTO

    /**
     * @param string $currentVersion
     * @param bool $isEnabled
     * @param string $tableName
     * @param string $path
     * @param string $databaseName
     * @param string $databaseHost
     * @param MigrationDTO[] $migrations
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
}
