<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class MigrationDTO
{
    public $version;
    public $name;
    public $filename;
    public $isApplied;

    public function __construct($version, $name, $filename, $isApplied)
    {
        $this->version = $version;
        $this->name = $name;
        $this->filename = $filename;
        $this->isApplied = $isApplied;
    }
}
