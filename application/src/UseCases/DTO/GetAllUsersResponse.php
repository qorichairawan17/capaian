<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class GetAllUsersResponse
{
    private $success;
    private $users;
    private $error;

    private function __construct($success, array $users = [], $error = null)
    {
        $this->success = $success;
        $this->users = $users;
        $this->error = $error;
    }

    public static function success(array $users)
    {
        return new self(true, $users);
    }

    public static function failure($error)
    {
        return new self(false, [], $error);
    }

    public function isSuccess() { return $this->success; }
    public function getUsers() { return $this->users; }
    public function getError() { return $this->error; }

    public function getTotalCount() { return count($this->users); }

    public function getAdminCount()
    {
        return count(array_filter($this->users, function ($user) {
            return $user->getRole() === 'admin';
        }));
    }

    public function getOperatorCount()
    {
        return count(array_filter($this->users, function ($user) {
            return $user->getRole() === 'operator';
        }));
    }
}
