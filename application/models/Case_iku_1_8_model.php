<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Case_iku_1_8_model
 *
 * Query layer (CI3 Model) untuk tabel `cases_iku_1_8`.
 * HANYA berisi query Active Record / raw SQL — tanpa logika bisnis.
 * Selalu mengembalikan data mentah (array/stdClass), BUKAN Domain Entity.
 * Dipanggil HANYA dari App\Infrastructure\Repositories\DbCaseIku18Repository.
 */
class Case_iku_1_8_model extends CI_Model
{
    private $table = 'cases_iku_1_8';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil semua data perkara IKU 1.8 berdasarkan filter.
     *
     * @param array $filters  Kunci yang didukung:
     *                          - 'status_mediasi' (string): 'berhasil' / 'gagal'
     *                          - 'triwulan'        (int): 1 | 2 | 3 | 4
     *                          - 'tahun'           (int): misal 2026
     * @return array  Array of associative arrays (data mentah dari DB)
     */
    public function get_all(array $filters = [])
    {
        if (!empty($filters['status_mediasi'])) {
            $status = strtolower($filters['status_mediasi']);
            if ($status === 'berhasil') {
                $this->db->where_in('hasil_mediasi', [
                    'Berhasil Seluruhnya (Akta Perdamaian)',
                    'Berhasil Seluruhnya (Pencabutan)',
                    'Berhasil Sebagian'
                ]);
            } else if ($status === 'gagal' || $status === 'tidak_berhasil') {
                $this->db->where('hasil_mediasi', 'Tidak Berhasil');
            }
        }

        if (!empty($filters['triwulan'])) {
            $this->db->where('triwulan', (int) $filters['triwulan']);
        }

        if (!empty($filters['tahun'])) {
            $this->db->where('tahun', (int) $filters['tahun']);
        }

        $this->db->order_by('tanggal_mediasi', 'ASC');

        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function find_by_id($id)
    {
        $query = $this->db->get_where($this->table, ['id' => $id], 1);
        return $query->row_array() ?: null;
    }

    public function insert_case(array $data)
    {
        $this->db->insert($this->table, $data);
        return (int) $this->db->insert_id();
    }

    public function update_case($id, array $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete_case($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
