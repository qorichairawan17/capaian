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
        // Load database in case it's not loaded
        $this->CI->load->database();
    }

    public function findByUsername($username)
    {
        // Safety check if connection wasn't successfully established
        try {
            if (!$this->CI->db->conn_id) {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }

        // Search users table
        $query = $this->CI->db->get_where('users', ['username' => $username], 1);
        $row = $query->row();

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
