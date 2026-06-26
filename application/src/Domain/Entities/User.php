<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

class User
{
    private $id;
    private $username;
    private $password_hash;
    private $name;
    private $email;

    public function __construct($id, $username, $password_hash, $name, $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getPasswordHash() { return $this->password_hash; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password_hash);
    }
}
