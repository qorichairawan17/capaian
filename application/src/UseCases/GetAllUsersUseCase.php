<?php
namespace App\UseCases;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Repositories\UserRepositoryInterface;
use App\UseCases\DTO\GetAllUsersResponse;

class GetAllUsersUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute: retrieve all users
     *
     * @return GetAllUsersResponse
     */
    public function execute()
    {
        try {
            $users = $this->userRepository->findAll();
            return GetAllUsersResponse::success($users);
        } catch (\Exception $e) {
            return GetAllUsersResponse::failure('Gagal mengambil data pengguna: ' . $e->getMessage());
        }
    }
}
