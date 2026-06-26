<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class MigrateResponse
{
    public $success;
    public $message;
    public $version;

    public function __construct($success, $message, $version = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->version = $version;
    }
}
