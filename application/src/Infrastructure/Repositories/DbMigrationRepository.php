<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\Migration;
use App\Domain\Entities\MigrationStatus;
use App\Domain\Repositories\MigrationRepositoryInterface;

class DbMigrationRepository implements MigrationRepositoryInterface
{
    private $CI;
    private $config;

    public function __construct()
    {
        $this->CI =& get_instance();
        // Load database in case it's not loaded
        $this->CI->load->database();
        // Load config file
        $this->CI->config->load('migration', TRUE);
        $this->config = $this->CI->config->item('migration');
    }

    public function getMigrationStatus()
    {
        $isEnabled = isset($this->config['migration_enabled']) ? $this->config['migration_enabled'] : FALSE;
        $tableName = isset($this->config['migration_table']) ? $this->config['migration_table'] : 'migrations';
        $path = isset($this->config['migration_path']) ? $this->config['migration_path'] : APPPATH . 'migrations/';

        // Get database diagnostics
        $databaseName = isset($this->CI->db->database) ? $this->CI->db->database : 'Unknown';
        $databaseHost = isset($this->CI->db->hostname) ? $this->CI->db->hostname : 'Unknown';

        // Get current version from DB
        $currentVersion = '0';
        
        // Load migration library to ensure migrations table is initialized if enabled
        if ($isEnabled) {
            try {
                $this->CI->load->library('migration');
            } catch (\Exception $e) {
                // Keep default
            }
        }

        if ($this->CI->db->conn_id && $this->CI->db->table_exists($tableName)) {
            $query = $this->CI->db->get($tableName);
            $row = $query->row();
            if ($row) {
                $currentVersion = $row->version;
            }
        }

        // Get files on disk
        $files = glob($path . '*_*.php');
        $migrations = [];

        if ($files) {
            foreach ($files as $file) {
                $filename = basename($file);
                if (preg_match('/^(\d{14})_(.+)\.php$/', $filename, $matches)) {
                    $version = $matches[1];
                    $name = str_replace('_', ' ', $matches[2]);
                    $name = ucwords($name);
                    
                    // A migration is applied if its version is <= current version in DB
                    $isApplied = ($currentVersion !== '0' && strcmp($version, $currentVersion) <= 0);

                    $migrations[] = new Migration(
                        $version,
                        $name,
                        $filename,
                        $isApplied
                    );
                }
            }
            
            // Sort by version ascending
            usort($migrations, function($a, $b) {
                return strcmp($a->getVersion(), $b->getVersion());
            });
        }

        return new MigrationStatus(
            $currentVersion,
            $isEnabled,
            $tableName,
            $path,
            $databaseName,
            $databaseHost,
            $migrations
        );
    }

    public function migrateToLatest()
    {
        $isEnabled = isset($this->config['migration_enabled']) ? $this->config['migration_enabled'] : FALSE;
        if (!$isEnabled) {
            return [
                'success' => false,
                'message' => 'Migration is currently disabled in config/migration.php.',
                'version' => null
            ];
        }

        $this->CI->load->library('migration');
        
        $result = $this->CI->migration->latest();
        
        if ($result === FALSE) {
            return [
                'success' => false,
                'message' => $this->CI->migration->error_string(),
                'version' => null
            ];
        }
        
        $newVersion = is_bool($result) ? $this->getCurrentDbVersion() : $result;
        return [
            'success' => true,
            'message' => 'Successfully migrated to version ' . $newVersion,
            'version' => $newVersion
        ];
    }

    public function migrateToVersion($version)
    {
        $isEnabled = isset($this->config['migration_enabled']) ? $this->config['migration_enabled'] : FALSE;
        if (!$isEnabled) {
            return [
                'success' => false,
                'message' => 'Migration is currently disabled in config/migration.php.',
                'version' => null
            ];
        }

        $this->CI->load->library('migration');
        
        $result = $this->CI->migration->version($version);
        
        if ($result === FALSE) {
            return [
                'success' => false,
                'message' => $this->CI->migration->error_string(),
                'version' => null
            ];
        }

        $newVersion = is_bool($result) ? $version : $result;
        return [
            'success' => true,
            'message' => 'Successfully migrated/rolled back to version ' . $newVersion,
            'version' => $newVersion
        ];
    }

    private function getCurrentDbVersion()
    {
        $tableName = isset($this->config['migration_table']) ? $this->config['migration_table'] : 'migrations';
        if ($this->CI->db->conn_id && $this->CI->db->table_exists($tableName)) {
            $query = $this->CI->db->get($tableName);
            $row = $query->row();
            if ($row) {
                return $row->version;
            }
        }
        return '0';
    }
}
