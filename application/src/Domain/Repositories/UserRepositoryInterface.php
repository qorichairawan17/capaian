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

    /**
     * Find user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById($id);

    /**
     * Get all users
     *
     * @return User[]
     */
    public function findAll();

    /**
     * Create a new user
     *
     * @param User $user
     * @return int Insert ID
     */
    public function create(User $user);

    /**
     * Update an existing user
     *
     * @param User $user
     * @return bool
     */
    public function save(User $user);

    /**
     * Delete a user by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete($id);

    /**
     * Check if username already exists (optionally excluding a given user ID)
     *
     * @param string $username
     * @param int|null $excludeId
     * @return bool
     */
    public function isUsernameExists($username, $excludeId = null);
}
