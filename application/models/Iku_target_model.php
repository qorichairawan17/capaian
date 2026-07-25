<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Iku_target_model
 *
 * Query layer (CI3 Model) untuk tabel `iku_targets`.
 * HANYA berisi query Active Record — tanpa logika bisnis.
 * Selalu mengembalikan data mentah (array), BUKAN Domain Entity.
 * Dipanggil HANYA dari App\Infrastructure\Repositories\DbIkuTargetRepository.
 */
class Iku_target_model extends CI_Model
{
    private $table = 'iku_targets';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil target berdasarkan kode IKU, tahun, dan tipe periode.
     *
     * @param string $iku_code
     * @param int    $tahun
     * @param string $periode_type
     * @return array Array of associative arrays
     */
    public function get_by_filters($iku_code, $tahun, $periode_type)
    {
        $this->db->where('iku_code', $iku_code);
        $this->db->where('tahun', (int) $tahun);
        $this->db->where('periode_type', $periode_type);
        $this->db->order_by('periode_value', 'ASC');

        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * Ambil satu record target spesifik.
     *
     * @param string $iku_code
     * @param int    $tahun
     * @param string $periode_type
     * @param int    $periode_value
     * @return array|null
     */
    public function get_one($iku_code, $tahun, $periode_type, $periode_value)
    {
        $query = $this->db->get_where($this->table, [
            'iku_code'     => $iku_code,
            'tahun'        => (int) $tahun,
            'periode_type' => $periode_type,
            'periode_value' => (int) $periode_value,
        ], 1);

        return $query->row_array() ?: null;
    }

    /**
     * Insert atau update target (upsert) menggunakan ON DUPLICATE KEY UPDATE.
     *
     * @param array $data Kolom: iku_code, tahun, periode_type, periode_value, target_value, created_by, updated_by
     * @return bool
     */
    public function upsert(array $data)
    {
        $sql = "INSERT INTO `{$this->table}` 
                (`iku_code`, `tahun`, `periode_type`, `periode_value`, `target_value`, `created_by`, `updated_by`, `created_at`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE 
                    `target_value` = VALUES(`target_value`),
                    `updated_by` = VALUES(`updated_by`)";

        return $this->db->query($sql, [
            $data['iku_code'],
            (int) $data['tahun'],
            $data['periode_type'],
            (int) $data['periode_value'],
            (float) $data['target_value'],
            $data['created_by'],
            $data['updated_by'],
        ]);
    }

    /**
     * Ambil semua target untuk tahun tertentu.
     *
     * @param int $tahun
     * @return array
     */
    public function get_all_by_year($tahun)
    {
        $this->db->where('tahun', (int) $tahun);
        $this->db->order_by('iku_code', 'ASC');
        $this->db->order_by('periode_type', 'ASC');
        $this->db->order_by('periode_value', 'ASC');

        $query = $this->db->get($this->table);
        return $query->result_array();
    }
}
