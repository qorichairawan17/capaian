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

    public function total($year)
    {
        // Rumus Indikator (Jumlah Perkara Diselesaikan Tepat Waktu / Jumlah Perkara Diselesaikan ) * 100%
        $jlhPerkaraSelesaiTepatWaktu = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $year AND b.tanggal_minutasi IS NOT NULL AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150;";
        $result = $this->conn->query($jlhPerkaraSelesaiTepatWaktu);
        $data = $result->fetch_row();

        $jlhPerkaraSelesai = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $year AND b.tanggal_minutasi IS NOT NULL;";
        $result2 = $this->conn->query($jlhPerkaraSelesai);
        $data2 = $result2->fetch_row();

        // Untuk mencari perkara yang diputus berdasarkan jenis perkara
        $totalJenisPerkara = "SELECT 
            COUNT(DISTINCT perkara_putusan.perkara_id) AS total_jenis_perkara, 
            perkara.jenis_perkara_nama, 
            perkara.jenis_perkara_text
            FROM perkara 
            LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
            WHERE YEAR(perkara.tanggal_pendaftaran) = '$year'
              AND perkara_putusan.tanggal_putusan IS NOT NULL
            GROUP BY perkara.jenis_perkara_nama, perkara.jenis_perkara_text ORDER BY total_jenis_perkara DESC LIMIT 20;";
        $queryJenisPerkara = $this->conn->query($totalJenisPerkara);
        $resultJenisPerkara = [];
        if ($queryJenisPerkara) {
            while ($row = $queryJenisPerkara->fetch_assoc()) {
                $resultJenisPerkara[] = $row;
            }
        }

        return $result = [
            'jlhPerkaraSelesaiTepatWaktu' => $data[0],
            'jlhPerkaraSelesai' => $data2[0],
            'persentase' => ($data2[0] == 0) ? 0 : ($data[0] / $data2[0] * 100),
            'detailJenisPerkara' => $resultJenisPerkara
        ];
    }

    public function perbulan($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            $sqlTepatWaktu = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $year AND MONTH(a.tanggal_pendaftaran) = $month AND b.tanggal_minutasi IS NOT NULL AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150;";
            $result = $this->conn->query($sqlTepatWaktu);
            $data = $result->fetch_row();
            $tepatWaktu = $data[0];

            $sqlSelesai = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $year AND MONTH(a.tanggal_pendaftaran) = $month AND b.tanggal_minutasi IS NOT NULL;";
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

    public function pertriwulan($year = null)
    {
        if ($year === null) {
            $year = date('Y');
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
            $sqlTepatWaktu = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $year AND MONTH(a.tanggal_pendaftaran) IN ($bulanIn) AND b.tanggal_minutasi IS NOT NULL AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150;";
            $result = $this->conn->query($sqlTepatWaktu);
            $data = $result->fetch_row();
            $tepatWaktu = $data[0];

            $sqlSelesai = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $year AND MONTH(a.tanggal_pendaftaran) IN ($bulanIn) AND b.tanggal_minutasi IS NOT NULL;";
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
}
