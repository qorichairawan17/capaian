<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class MockUserRepository implements UserRepositoryInterface
{
    private $users = [];
    private $nextId = 3;

    public function __construct()
    {
        // Add default mock users
        $this->users[1] = new User(
            1,
            'admin',
            password_hash('password123', PASSWORD_BCRYPT),
            'Administrator',
            'admin@example.com',
            'admin',
            '2025-01-01 00:00:00'
        );

        $this->users[2] = new User(
            2,
            'operator1',
            password_hash('password123', PASSWORD_BCRYPT),
            'Operator Satu',
            'operator1@example.com',
            'operator',
            '2025-06-15 10:30:00'
        );
    }

    public function findByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
        return null;
    }

    public function findById($id)
    {
        return isset($this->users[$id]) ? $this->users[$id] : null;
    }

    public function findAll()
    {
        return array_values($this->users);
    }

    public function create(User $user)
    {
        $id = $this->nextId++;
        $newUser = new User(
            $id,
            $user->getUsername(),
            $user->getPasswordHash(),
            $user->getName(),
            $user->getEmail(),
            $user->getRole(),
            $user->getCreatedAt()
        );
        $this->users[$id] = $newUser;
        return $id;
    }

    public function save(User $user)
    {
        if (!isset($this->users[$user->getId()])) {
            return false;
        }
        $this->users[$user->getId()] = $user;
        return true;
    }

    public function delete($id)
    {
        if (!isset($this->users[$id])) {
            return false;
        }
        unset($this->users[$id]);
        return true;
    }

    public function isUsernameExists($username, $excludeId = null)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username && $user->getId() !== $excludeId) {
                return true;
            }
        }
        return false;
    }
}
