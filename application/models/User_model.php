<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Find a user by username
     *
     * @param string $username
     * @return array|null
     */
    public function find_by_username($username)
    {
        try {
            if (!$this->db->conn_id) {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }

        $query = $this->db->get_where($this->table, ['username' => $username], 1);
        return $query->row_array() ?: null;
    }

    /**
     * Find a user by ID
     *
     * @param int $id
     * @return array|null
     */
    public function find_by_id($id)
    {
        $query = $this->db->get_where($this->table, ['id' => $id], 1);
        return $query->row_array() ?: null;
    }

    /**
     * Get all users
     *
     * @return array
     */
    public function find_all()
    {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * Insert a new user
     *
     * @param array $data
     * @return int Insert ID
     */
    public function insert_user(array $data)
    {
        $this->db->insert($this->table, $data);
        return (int) $this->db->insert_id();
    }

    /**
     * Update an existing user
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_user($id, array $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    /**
     * Delete a user by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete_user($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /**
     * Check if a username already exists, optionally excluding a specific user ID
     *
     * @param string $username
     * @param int|null $excludeId
     * @return bool
     */
    public function is_username_exists($username, $excludeId = null)
    {
        $this->db->where('username', $username);
        if ($excludeId !== null) {
            $this->db->where('id !=', $excludeId);
        }
        return $this->db->count_all_results($this->table) > 0;
    }
}
