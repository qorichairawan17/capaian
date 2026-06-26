<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\User;

interface UserRepositoryInterface
{
    /**
     * Find user by username
     *
     * @param string $username
     * @return User|null
     */
    public function findByUsername($username);
}
