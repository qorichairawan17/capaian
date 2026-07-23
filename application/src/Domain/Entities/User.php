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
    private $role;
    private $createdAt;

    public function __construct($id, $username, $password_hash, $name, $email, $role = 'operator', $createdAt = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->createdAt = $createdAt;
    }

    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getPasswordHash() { return $this->password_hash; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    public function getCreatedAt() { return $this->createdAt; }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password_hash);
    }

    /**
     * Update user profile data
     *
     * @param string $name
     * @param string $email
     * @param string $role
     */
    public function updateProfile($name, $email, $role)
    {
        if (trim($name) === '') {
            throw new \InvalidArgumentException('Nama tidak boleh kosong');
        }
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * Change user password hash
     *
     * @param string $newHash
     */
    public function changePassword($newHash)
    {
        $this->password_hash = $newHash;
    }

    /**
     * Factory method to create a new user
     *
     * @param string $username
     * @param string $passwordHash
     * @param string $name
     * @param string $email
     * @param string $role
     * @return self
     */
    public static function create($username, $passwordHash, $name, $email, $role = 'operator')
    {
        return new self(0, $username, $passwordHash, $name, $email, $role, date('Y-m-d H:i:s'));
    }
}
