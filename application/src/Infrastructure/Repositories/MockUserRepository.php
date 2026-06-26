<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class MockUserRepository implements UserRepositoryInterface
{
    private $users = [];

    public function __construct()
    {
        // Add default mock user for verification (username: admin, password: password123)
        $this->users['admin'] = new User(
            1,
            'admin',
            password_hash('password123', PASSWORD_BCRYPT),
            'Administrator',
            'admin@example.com'
        );
    }

    public function findByUsername($username)
    {
        return isset($this->users[$username]) ? $this->users[$username] : null;
    }
}
