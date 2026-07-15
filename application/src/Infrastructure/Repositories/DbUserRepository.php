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

        // Map database record to Domain Entity
        return new User(
            $row->id,
            $row->username,
            $row->password, // Password column containing bcrypt hash
            isset($row->name) ? $row->name : $row->username,
            isset($row->email) ? $row->email : ''
        );
    }
}
