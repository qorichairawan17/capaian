<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\User;

class LoginResponse
{
    private $success;
    private $error;
    private $user;

    private function __construct($success, $error = null, User $user = null)
    {
        $this->success = $success;
        $this->error = $error;
        $this->user = $user;
    }

    public static function success(User $user)
    {
        return new self(true, null, $user);
    }

    public static function failure($error)
    {
        return new self(false, $error);
    }

    public function isSuccess() { return $this->success; }
    public function getError() { return $this->error; }
    public function getUser() { return $this->user; }
}
