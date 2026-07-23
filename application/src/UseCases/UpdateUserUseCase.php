<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Exceptions\UserNotFoundException;
use App\UseCases\DTO\UpdateUserRequest;
use App\UseCases\DTO\UpdateUserResponse;

class UpdateUserUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute: update an existing user
     *
     * @param UpdateUserRequest $request
     * @return UpdateUserResponse
     */
    public function execute(UpdateUserRequest $request)
    {
        // Validate required fields
        if (empty($request->getName())) {
            return UpdateUserResponse::failure('Nama wajib diisi.');
        }

        // Find existing user
        $user = $this->userRepository->findById($request->getId());
        if (!$user) {
            return UpdateUserResponse::failure('Pengguna tidak ditemukan.');
        }

        // Update profile
        $user->updateProfile(
            $request->getName(),
            $request->getEmail(),
            $request->getRole()
        );

        // Update password if provided
        if ($request->hasNewPassword()) {
            $newHash = password_hash($request->getPassword(), PASSWORD_BCRYPT);
            $user->changePassword($newHash);
        }

        try {
            $this->userRepository->save($user);
            return UpdateUserResponse::success();
        } catch (\Exception $e) {
            return UpdateUserResponse::failure('Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }
}
