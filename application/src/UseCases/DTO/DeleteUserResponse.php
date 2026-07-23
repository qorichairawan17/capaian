<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class DeleteUserResponse
{
    private $success;
    private $error;

    private function __construct($success, $error = null)
    {
        $this->success = $success;
        $this->error = $error;
    }

    public static function success()
    {
        return new self(true);
    }

    public static function failure($error)
    {
        return new self(false, $error);
    }

    public function isSuccess() { return $this->success; }
    public function getError() { return $this->error; }
}
