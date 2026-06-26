<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\UserRepositoryInterface;
use App\UseCases\DTO\LoginRequest;
use App\UseCases\DTO\LoginResponse;

class LoginUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute authentication logic
     *
     * @param LoginRequest $request
     * @return LoginResponse
     */
    public function execute(LoginRequest $request)
    {
        $username = $request->getUsername();
        $password = $request->getPassword();

        if (empty($username) || empty($password)) {
            return LoginResponse::failure('Username and password are required.');
        }

        // Retrieve user by username
        $user = $this->userRepository->findByUsername($username);

        if (!$user) {
            return LoginResponse::failure('Invalid username or password.');
        }

        // Verify password
        if (!$user->verifyPassword($password)) {
            return LoginResponse::failure('Invalid username or password.');
        }

        return LoginResponse::success($user);
    }
}
