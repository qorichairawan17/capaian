<?php
namespace App\Infrastructure\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class DbUserRepository implements UserRepositoryInterface
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        // Load the model using CodeIgniter's loader
        $this->CI->load->model('User_model');
    }

    public function findByUsername($username)
    {
        // Use the CI Model to access the database
        $row = $this->CI->User_model->find_by_username($username);

        if (!$row) {
            return null;
        }

        return $this->mapRowToEntity($row);
    }

    public function findById($id)
    {
        $row = $this->CI->User_model->find_by_id($id);

        if (!$row) {
            return null;
        }

        return $this->mapRowToEntity($row);
    }

    public function findAll()
    {
        $rows = $this->CI->User_model->find_all();
        $users = [];

        foreach ($rows as $row) {
            $users[] = $this->mapRowToEntity($row);
        }

        return $users;
    }

    public function create(User $user)
    {
        $data = [
            'username'   => $user->getUsername(),
            'password'   => $user->getPasswordHash(),
            'name'       => $user->getName(),
            'email'      => $user->getEmail(),
            'role'       => $user->getRole(),
            'created_at' => $user->getCreatedAt() ?: date('Y-m-d H:i:s')
        ];

        return $this->CI->User_model->insert_user($data);
    }

    public function save(User $user)
    {
        $data = [
            'name'     => $user->getName(),
            'email'    => $user->getEmail(),
            'role'     => $user->getRole(),
            'password' => $user->getPasswordHash()
        ];

        return $this->CI->User_model->update_user($user->getId(), $data);
    }

    public function delete($id)
    {
        return $this->CI->User_model->delete_user($id);
    }

    public function isUsernameExists($username, $excludeId = null)
    {
        return $this->CI->User_model->is_username_exists($username, $excludeId);
    }

    /**
     * Map raw database array row to Domain Entity
     *
     * @param array $row
     * @return User
     */
    private function mapRowToEntity(array $row)
    {
        return new User(
            (int) $row['id'],
            $row['username'],
            $row['password'],
            isset($row['name']) ? $row['name'] : $row['username'],
            isset($row['email']) ? $row['email'] : '',
            isset($row['role']) ? $row['role'] : 'operator',
            isset($row['created_at']) ? $row['created_at'] : null
        );
    }
}
