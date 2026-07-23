<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Case_iku_1_4_model
 *
 * Query layer (CI3 Model) untuk tabel `cases_iku_1_4`.
 * HANYA berisi query Active Record / raw SQL — tanpa logika bisnis.
 * Selalu mengembalikan data mentah (array/stdClass), BUKAN Domain Entity.
 * Dipanggil HANYA dari App\Infrastructure\Repositories\DbCaseIku14Repository.
 */
class Case_iku_1_4_model extends CI_Model
{
    private $table = 'cases_iku_1_4';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil semua data perkara perdata banding IKU 1.4 berdasarkan filter.
     *
     * @param array $filters  Kunci yang didukung:
     *                          - 'jenis_pengajuan' (string): 'e-Court' atau 'Konvensional'
     *                          - 'triwulan'        (int):    1 | 2 | 3 | 4
     *                          - 'tahun'           (int):    misal 2026
     * @return array  Array of associative arrays (data mentah dari DB)
     */
    public function get_all(array $filters = [])
    {
        if (!empty($filters['jenis_pengajuan'])) {
            $this->db->where('jenis_pengajuan', $filters['jenis_pengajuan']);
        }

        if (!empty($filters['triwulan'])) {
            $this->db->where('triwulan', (int) $filters['triwulan']);
        }

        if (!empty($filters['tahun'])) {
            $this->db->where('tahun', (int) $filters['tahun']);
        }

        $this->db->order_by('tanggal_pengajuan', 'ASC');

        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * Cari satu record berdasarkan ID.
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
     * Cari satu record berdasarkan Nomor Perkara.
     *
     * @param string $nomorPerkara
     * @return array|null
     */
    public function find_by_nomor($nomorPerkara)
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
    public function insert_case(array $data)
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
    public function update_case($id, array $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    /**
     * Hapus satu record perkara berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete_case($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
