<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

class UpdateUserRequest
{
    private $id;
    private $name;
    private $email;
    private $role;
    private $password;

    public function __construct($id, $name, $email, $role, $password = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    public function getPassword() { return $this->password; }
    public function hasNewPassword() { return !empty($this->password); }
}
