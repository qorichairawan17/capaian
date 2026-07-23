<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Exceptions\UserAlreadyExistsException;
use App\UseCases\DTO\CreateUserRequest;
use App\UseCases\DTO\CreateUserResponse;

class CreateUserUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute: create a new user
     *
     * @param CreateUserRequest $request
     * @return CreateUserResponse
     */
    public function execute(CreateUserRequest $request)
    {
        // Validate required fields
        if (empty($request->getUsername()) || empty($request->getPassword()) || empty($request->getName())) {
            return CreateUserResponse::failure('Username, password, dan nama wajib diisi.');
        }

        // Check username uniqueness
        if ($this->userRepository->isUsernameExists($request->getUsername())) {
            return CreateUserResponse::failure('Username sudah digunakan oleh pengguna lain.');
        }

        // Create domain entity
        $passwordHash = password_hash($request->getPassword(), PASSWORD_BCRYPT);
        $user = User::create(
            $request->getUsername(),
            $passwordHash,
            $request->getName(),
            $request->getEmail(),
            $request->getRole()
        );

        try {
            $insertId = $this->userRepository->create($user);
            return CreateUserResponse::success($insertId);
        } catch (\Exception $e) {
            return CreateUserResponse::failure('Gagal membuat pengguna: ' . $e->getMessage());
        }
    }
}
