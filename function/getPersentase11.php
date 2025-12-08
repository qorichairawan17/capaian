<?php
require_once __DIR__ . '/../config/database.php';

class GetPersentase11
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function listPerkara($year, $minYear = null)
    {
        if ($minYear === null) {
            $minYear = $year;
        }
        $perkaraTepatWaktu = "SELECT 
                        a.nomor_perkara, 
                        a.tanggal_pendaftaran, 
                        b.tanggal_minutasi,
                        DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) AS jumlah_hari
                    FROM perkara a 
                    LEFT JOIN perkara_putusan b 
                        ON b.perkara_id = a.perkara_id 
                    WHERE 
                        YEAR(a.tanggal_pendaftaran) = '$minYear' 
                        AND b.tanggal_minutasi IS NOT NULL 
                        AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150
                        AND YEAR(b.tanggal_minutasi) = '$year'";
        $queryPerkaraTepatWaktu = $this->conn->query($perkaraTepatWaktu);
        $resultPerkaraTepatWaktu = [];
        if ($queryPerkaraTepatWaktu) {
            while ($row = $queryPerkaraTepatWaktu->fetch_assoc()) {
                $resultPerkaraTepatWaktu[] = $row;
            }
        }

        $perkaraTidakTepatWaktu = "SELECT 
                        a.nomor_perkara, 
                        a.tanggal_pendaftaran, 
                        b.tanggal_minutasi,
                        DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) AS jumlah_hari
                    FROM perkara a 
                    LEFT JOIN perkara_putusan b 
                        ON b.perkara_id = a.perkara_id 
                    WHERE 
                        YEAR(a.tanggal_pendaftaran) = '$minYear' 
                        AND b.tanggal_minutasi IS NOT NULL 
                        AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) > 150
                        AND YEAR(b.tanggal_minutasi) = '$year'";
        $queryPerkaraTidakTepatWaktu = $this->conn->query($perkaraTidakTepatWaktu);
        $resultPerkaraTidakTepatWaktu = [];
        if ($queryPerkaraTidakTepatWaktu) {
            while ($row = $queryPerkaraTidakTepatWaktu->fetch_assoc()) {
                $resultPerkaraTidakTepatWaktu[] = $row;
            }
        }
        return [
            'perkaraTidakTepatWaktu' => $resultPerkaraTidakTepatWaktu,
            'perkaraTepatWaktu' => $resultPerkaraTepatWaktu
        ];
    }

    public function showListPerkara($year)
    {
        $minYear = $year - 1;
        $perkaraTahunBerjalan = $this->listPerkara($year);
        $perkaraTahunBelakang = $this->listPerkara($year, $minYear);
        return [
            'perkaraTahunBerjalan' => $perkaraTahunBerjalan,
            'perkaraTahunBelakang' => $perkaraTahunBelakang
        ];
    }

    public function total($year, $minYear = null)
    {
        if ($minYear === null) {
            $minYear = $year;
        }
        // Rumus Indikator (Jumlah Perkara Diselesaikan Tepat Waktu / Jumlah Perkara Diselesaikan ) * 100%
        $jlhPerkaraSelesaiTepatWaktu = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150;";
        $result = $this->conn->query($jlhPerkaraSelesaiTepatWaktu);
        $data = $result->fetch_row();

        $jlhPerkaraSelesai = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL;";
        $result2 = $this->conn->query($jlhPerkaraSelesai);
        $data2 = $result2->fetch_row();

        return $result = [
            'jlhPerkaraSelesaiTepatWaktu' => $data[0],
            'jlhPerkaraSelesai' => $data2[0],
            'persentase' => ($data2[0] == 0) ? 0 : ($data[0] / $data2[0] * 100)
        ];
    }

    public function showTotal($year)
    {
        $minYear = $year - 1;
        $totalTahunBerjalan = $this->total($year);
        $totalTahunBelakang = $this->total($year, $minYear);
        return [
            'totalTahunBerjalan' => $totalTahunBerjalan,
            'totalTahunBelakang' => $totalTahunBelakang
        ];
    }

    public function jenisPerkara($year, $minYear = null)
    {
        if ($minYear === null) {
            $minYear = $year;
        }
        // Untuk mencari perkara yang diputus berdasarkan jenis perkara
        $totalJenisPerkara = "SELECT 
            COUNT(DISTINCT perkara_putusan.perkara_id) AS total_jenis_perkara, 
            perkara.jenis_perkara_nama, 
            perkara.jenis_perkara_text
            FROM perkara 
            LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
            WHERE YEAR(perkara.tanggal_pendaftaran) = '$minYear'
              AND YEAR(perkara_putusan.tanggal_putusan) = '$year'
              AND perkara_putusan.tanggal_putusan IS NOT NULL
            GROUP BY perkara.jenis_perkara_nama, perkara.jenis_perkara_text ORDER BY total_jenis_perkara DESC LIMIT 20;";
        $queryJenisPerkara = $this->conn->query($totalJenisPerkara);
        $resultJenisPerkara = [];
        if ($queryJenisPerkara) {
            while ($row = $queryJenisPerkara->fetch_assoc()) {
                $resultJenisPerkara[] = $row;
            }
        }

        return $resultJenisPerkara;
    }

    public function showJenisPerkara($year)
    {
        $minYear = $year - 1;
        $jenisPerkaraTahunBerjalan = $this->jenisPerkara($year);
        $jenisPerkaraTahunBelakang = $this->jenisPerkara($year, $minYear);
        return [
            'jenisPerkaraTahunBerjalan' => $jenisPerkaraTahunBerjalan,
            'jenisPerkaraTahunBelakang' => $jenisPerkaraTahunBelakang
        ];
    }

    public function perbulan($year = null, $minYear = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        if ($minYear === null) {
            $minYear = $year;
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            $sqlTepatWaktu = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND MONTH(b.tanggal_minutasi) = $month AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150;";
            $result = $this->conn->query($sqlTepatWaktu);
            $data = $result->fetch_row();
            $tepatWaktu = $data[0];

            $sqlSelesai = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND MONTH(b.tanggal_minutasi) = $month AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL;";
            $result2 = $this->conn->query($sqlSelesai);
            $data2 = $result2->fetch_row();
            $selesai = $data2[0];

            $persentase = ($selesai == 0) ? 0 : ($tepatWaktu / $selesai * 100);

            $resultArray[$month] = [
                'jlhPerkaraSelesaiTepatWaktu' => $tepatWaktu,
                'jlhPerkaraSelesai' => $selesai,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }

    public function pertriwulan($year = null, $minYear = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        if ($minYear === null) {
            $minYear = $year;
        }
        $resultArray = [];
        $triwulanMap = [
            1 => [1, 2, 3],
            2 => [4, 5, 6],
            3 => [7, 8, 9],
            4 => [10, 11, 12]
        ];
        foreach ($triwulanMap as $triwulan => $months) {
            $bulanIn = implode(',', $months);
            $sqlTepatWaktu = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND MONTH(b.tanggal_minutasi) IN ($bulanIn) AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150;";
            $result = $this->conn->query($sqlTepatWaktu);
            $data = $result->fetch_row();
            $tepatWaktu = $data[0];

            $sqlSelesai = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND MONTH(b.tanggal_minutasi) IN ($bulanIn) AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL;";
            $result2 = $this->conn->query($sqlSelesai);
            $data2 = $result2->fetch_row();
            $selesai = $data2[0];

            $persentase = ($selesai == 0) ? 0 : ($tepatWaktu / $selesai * 100);

            $resultArray[$triwulan] = [
                'jlhPerkaraSelesaiTepatWaktu' => $tepatWaktu,
                'jlhPerkaraSelesai' => $selesai,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }

    public function showPerbulan($year)
    {
        $minYear = $year - 1;
        $perbulanTahunBerjalan = $this->perbulan($year);
        $perbulanTahunBelakang = $this->perbulan($year, $minYear);
        return [
            'perbulanTahunBerjalan' => $perbulanTahunBerjalan,
            'perbulanTahunBelakang' => $perbulanTahunBelakang
        ];
    }

    public function showPertriwulan($year)
    {
        $minYear = $year - 1;
        $pertriwulanTahunBerjalan = $this->pertriwulan($year);
        $pertriwulanTahunBelakang = $this->pertriwulan($year, $minYear);
        return [
            'pertriwulanTahunBerjalan' => $pertriwulanTahunBerjalan,
            'pertriwulanTahunBelakang' => $pertriwulanTahunBelakang
        ];
    }
}
