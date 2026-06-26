<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration
{
    private $version;
    private $name;
    private $filename;
    private $isApplied;

    public function __construct($version, $name, $filename, $isApplied)
    {
        $this->version = $version;
        $this->name = $name;
        $this->filename = $filename;
        $this->isApplied = $isApplied;
    }

    public function getVersion() { return $this->version; }
    public function getName() { return $this->name; }
    public function getFilename() { return $this->filename; }
    public function isApplied() { return $this->isApplied; }
}
