<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Case_iku_1_10_model
 *
 * Query layer mentah CI3 Active Record untuk IKU 1.10.
 * Hanya mengembalikan array data mentah (stdClass/array), bukan Domain Entity.
 */
class Case_iku_1_10_model extends CI_Model
{
    private $table = 'cases_iku_1_10';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get raw array rows based on filters
     *
     * @param array $filters
     * @return array
     */
    public function get_all(array $filters = [])
    {
        if (!empty($filters['metode_pendaftaran'])) {
            $metode = strtolower($filters['metode_pendaftaran']);
            if ($metode === 'ecourt') {
                $this->db->where('metode_pendaftaran', 'e-Court');
            } elseif ($metode === 'konvensional') {
                $this->db->where('metode_pendaftaran', 'Konvensional');
            }
        }

        if (!empty($filters['triwulan'])) {
            $this->db->where('triwulan', (int) $filters['triwulan']);
        }

        if (!empty($filters['tahun'])) {
            $this->db->where('tahun', (int) $filters['tahun']);
        }

        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->table);

        return $query ? $query->result_array() : [];
    }

    public function insert(array $data)
    {
        $this->db->insert($this->table, $data);
        return (int) $this->db->insert_id();
    }
}
