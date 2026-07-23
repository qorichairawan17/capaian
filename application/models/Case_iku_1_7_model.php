<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Case_iku_1_7_model
 *
 * Query layer (CI3 Model) untuk tabel `cases_iku_1_7`.
 * HANYA berisi query Active Record / raw SQL — tanpa logika bisnis.
 * Selalu mengembalikan data mentah (array/stdClass), BUKAN Domain Entity.
 * Dipanggil HANYA dari App\Infrastructure\Repositories\DbCaseIku17Repository.
 */
class Case_iku_1_7_model extends CI_Model
{
    private $table = 'cases_iku_1_7';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil semua data perkara IKU 1.7 berdasarkan filter.
     *
     * @param array $filters  Kunci yang didukung:
     *                          - 'kategori_kriteria' (string)
     *                          - 'status_rj'         (string): 'berhasil' / 'gagal'
     *                          - 'triwulan'          (int):    1 | 2 | 3 | 4
     *                          - 'tahun'             (int):    misal 2026
     * @return array  Array of associative arrays (data mentah dari DB)
     */
    public function get_all(array $filters = [])
    {
        if (!empty($filters['kategori_kriteria'])) {
            $kategori = strtolower($filters['kategori_kriteria']);
            if ($kategori === 'tindak_pidana_ringan' || $kategori === 'tipiring') {
                $this->db->like('kategori_kriteria', 'Tindak Pidana Ringan');
            } else if ($kategori === 'delik_aduan') {
                $this->db->like('kategori_kriteria', 'Delik Aduan');
            } else if ($kategori === 'ancaman_max_5_tahun' || $kategori === 'ancaman_5_tahun') {
                $this->db->like('kategori_kriteria', 'Ancaman Hukuman Max 5 Tahun');
            } else if ($kategori === 'anak_diversi_gagal' || $kategori === 'anak') {
                $this->db->like('kategori_kriteria', 'Anak');
            } else if ($kategori === 'lalu_lintas') {
                $this->db->like('kategori_kriteria', 'Lalu Lintas');
            }
        }

        if (!empty($filters['status_rj'])) {
            $status = strtolower($filters['status_rj']);
            if ($status === 'berhasil') {
                $this->db->where('status_rj', 'Berhasil');
            } else if ($status === 'gagal' || $status === 'tidak_berhasil') {
                $this->db->where('status_rj', 'Tidak Berhasil');
            }
        }

        if (!empty($filters['triwulan'])) {
            $this->db->where('triwulan', (int) $filters['triwulan']);
        }

        if (!empty($filters['tahun'])) {
            $this->db->where('tahun', (int) $filters['tahun']);
        }

        $this->db->order_by('tanggal_registrasi', 'ASC');

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
