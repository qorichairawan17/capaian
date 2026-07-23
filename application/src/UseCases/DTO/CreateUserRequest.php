<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class CreateUserRequest
{
    private $username;
    private $password;
    private $name;
    private $email;
    private $role;

    public function __construct($username, $password, $name, $email, $role = 'operator')
    {
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
}
