<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\UserRepositoryInterface;
use App\UseCases\DTO\DeleteUserResponse;

class DeleteUserUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute: delete a user by ID
     *
     * @param int $id
     * @return DeleteUserResponse
     */
    public function execute($id)
    {
        // Find existing user
        $user = $this->userRepository->findById($id);
        if (!$user) {
            return DeleteUserResponse::failure('Pengguna tidak ditemukan.');
        }

        try {
            $this->userRepository->delete($id);
            return DeleteUserResponse::success();
        } catch (\Exception $e) {
            return DeleteUserResponse::failure('Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}
