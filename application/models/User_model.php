<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Load database in case it's not loaded
        $this->load->database();
    }

    /**
     * Find a user by username
     *
     * @param string $username
     * @return object|null
     */
    public function find_by_username($username)
    {
        // Safety check if connection wasn't successfully established
        try {
            if (!$this->db->conn_id) {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }

        // Search users table
        $query = $this->db->get_where('users', ['username' => $username], 1);
        return $query->row();
    }
}
