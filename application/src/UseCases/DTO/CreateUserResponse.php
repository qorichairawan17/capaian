<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class CreateUserResponse
{
    private $success;
    private $error;
    private $userId;

    private function __construct($success, $error = null, $userId = null)
    {
        $this->success = $success;
        $this->error = $error;
        $this->userId = $userId;
    }

    public static function success($userId)
    {
        return new self(true, null, $userId);
    }

    public static function failure($error)
    {
        return new self(false, $error);
    }

    public function isSuccess() { return $this->success; }
    public function getError() { return $this->error; }
    public function getUserId() { return $this->userId; }
}
