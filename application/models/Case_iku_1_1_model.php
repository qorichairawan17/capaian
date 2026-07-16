<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Case_iku_1_1_model
 *
 * Query layer (CI3 Model) untuk tabel `cases_iku_1_1`.
 * HANYA berisi query Active Record / raw SQL — tanpa logika bisnis.
 * Selalu mengembalikan data mentah (array/stdClass), BUKAN Domain Entity.
 * Dipanggil HANYA dari App\Infrastructure\Repositories\DbCaseRepository.
 */
class Case_iku_1_1_model extends CI_Model
{
    private $table = 'cases_iku_1_1';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil semua data perkara berdasarkan filter yang diberikan.
     *
     * @param array $filters  Kunci yang didukung:
     *                          - 'jenis_perkara' (string): 'Pidana' atau 'Perdata'
     *                          - 'triwulan'      (int):    1 | 2 | 3 | 4
     *                          - 'tahun'         (int):    misal 2026
     * @return array  Array of associative arrays (data mentah dari DB)
     */
    public function get_all(array $filters = []): array
    {
        if (!empty($filters['jenis_perkara'])) {
            $this->db->where('jenis_perkara', $filters['jenis_perkara']);
        }

        if (!empty($filters['triwulan'])) {
            $this->db->where('triwulan', (int) $filters['triwulan']);
        }

        if (!empty($filters['tahun'])) {
            $this->db->where('tahun', (int) $filters['tahun']);
        }

        $this->db->order_by('tanggal_pendaftaran', 'ASC');

        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * Cari satu perkara berdasarkan ID.
     *
     * @param int $id
     * @return array|null
     */
    public function find_by_id(int $id): ?array
    {
        $query = $this->db->get_where($this->table, ['id' => $id], 1);
        return $query->row_array() ?: null;
    }

    /**
     * Cari satu perkara berdasarkan Nomor Perkara.
     *
     * @param string $nomorPerkara
     * @return array|null
     */
    public function find_by_nomor(string $nomorPerkara): ?array
    {
        $query = $this->db->get_where($this->table, ['nomor_perkara' => $nomorPerkara], 1);
        return $query->row_array() ?: null;
    }

    /**
     * Insert satu record perkara baru.
     *
     * @param array $data
     * @return int  Insert ID
     */
    public function insert_case(array $data): int
    {
        $this->db->insert($this->table, $data);
        return (int) $this->db->insert_id();
    }

    /**
     * Update satu record perkara berdasarkan ID.
     *
     * @param int   $id
     * @param array $data
     * @return bool
     */
    public function update_case(int $id, array $data): bool
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    /**
     * Hapus satu record perkara berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete_case(int $id): bool
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
