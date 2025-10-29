<?php
require_once __DIR__ . '/../config/database.php';

class getPersentasePutusanPadaDirektori
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function total($year)
    {
        // Rumus Indikator (Jumlah putusan yang diunggah pada direktori putusan / Jumlah putusan yang telah diminutasi ) * 100%

        // Jumlah putusan yang diunggah pada direktori putusan
        $putusanTerupload = "SELECT COUNT(dp.putusan_id) AS total_putusan
            FROM dirput_perkara AS dp
            LEFT JOIN perkara_putusan AS a ON dp.perkara_id=a.perkara_id
            LEFT JOIN perkara AS b ON a.perkara_id=b.perkara_id
            LEFT JOIN alur_perkara AS c ON b.alur_perkara_id=c.id
            LEFT JOIN perkara_penetapan AS d ON a.perkara_id=d.perkara_id
            WHERE b.alur_perkara_id NOT IN (112,113,114) AND YEAR(a.tanggal_putusan)='$year'";
        $result = $this->conn->query($putusanTerupload);
        $row = $result->fetch_assoc();
        $data = $row ? $row['total_putusan'] : 0;

        // Jumlah perkara yang telah diminutasi (LEFT JOIN perkara_putusan, tanggal_minutasi IS NOT NULL)
        $perkaraMinutasi = "SELECT COUNT(*) FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id 
            WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND perkara_putusan.tanggal_minutasi IS NOT NULL;";
        $result2 = $this->conn->query($perkaraMinutasi);
        $data2 = $result2->fetch_row();

        return [
            'jlhPutusanTerupload' => $data,
            'jlhPerkaraMinutasi' => $data2[0],
            'persentase' => ($data2[0] == 0) ? 0 : ($data / $data2[0] * 100)
        ];
    }

    public function perbulan($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            // Jumlah putusan yang diunggah pada direktori putusan per bulan
            $sqlPutusanTerupload = "SELECT COUNT(dp.putusan_id) AS total_putusan FROM dirput_perkara AS dp
                LEFT JOIN perkara_putusan AS a ON dp.perkara_id=a.perkara_id
                LEFT JOIN perkara AS b ON a.perkara_id=b.perkara_id
                LEFT JOIN alur_perkara AS c ON b.alur_perkara_id=c.id
                LEFT JOIN perkara_penetapan AS d ON a.perkara_id=d.perkara_id
                WHERE b.alur_perkara_id NOT IN (112,113,114) AND YEAR(a.tanggal_putusan)='$year' AND MONTH(a.tanggal_putusan)='$month';";
            $result = $this->conn->query($sqlPutusanTerupload);
            $row = $result->fetch_assoc();
            $putusanTerupload = $row ? $row['total_putusan'] : 0;

            // Jumlah perkara yang telah diminutasi per bulan
            $sqlPerkaraMinutasi = "SELECT COUNT(*) FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id 
                WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND MONTH(perkara_putusan.tanggal_putusan)='$month' AND perkara_putusan.tanggal_minutasi IS NOT NULL;";
            $result2 = $this->conn->query($sqlPerkaraMinutasi);
            $data2 = $result2->fetch_row();
            $perkaraMinutasi = $data2[0];

            $persentase = ($perkaraMinutasi == 0) ? 0 : ($putusanTerupload / $perkaraMinutasi * 100);

            $resultArray[$month] = [
                'jlhPutusanTerupload' => $putusanTerupload,
                'jlhPerkaraMinutasi' => $perkaraMinutasi,
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
            // Jumlah putusan yang diunggah pada direktori putusan per triwulan
            $sqlPutusanTerupload = "SELECT COUNT(dp.putusan_id) AS total_putusan FROM dirput_perkara AS dp
                LEFT JOIN perkara_putusan AS a ON dp.perkara_id=a.perkara_id
                LEFT JOIN perkara AS b ON a.perkara_id=b.perkara_id
                LEFT JOIN alur_perkara AS c ON b.alur_perkara_id=c.id
                LEFT JOIN perkara_penetapan AS d ON a.perkara_id=d.perkara_id
                WHERE b.alur_perkara_id NOT IN (112,113,114) AND YEAR(a.tanggal_putusan)='$year' AND MONTH(a.tanggal_putusan) IN ($bulanIn);";
            $result = $this->conn->query($sqlPutusanTerupload);
            $row = $result->fetch_assoc();
            $putusanTerupload = $row ? $row['total_putusan'] : 0;

            // Jumlah perkara yang telah diminutasi per triwulan
            $sqlPerkaraMinutasi = "SELECT COUNT(*) FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id 
                WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND MONTH(perkara_putusan.tanggal_putusan) IN ($bulanIn) AND perkara_putusan.tanggal_minutasi IS NOT NULL;";
            $result2 = $this->conn->query($sqlPerkaraMinutasi);
            $data2 = $result2->fetch_row();
            $perkaraMinutasi = $data2[0];

            $persentase = ($perkaraMinutasi == 0) ? 0 : ($putusanTerupload / $perkaraMinutasi * 100);

            $resultArray[$triwulan] = [
                'jlhPutusanTerupload' => $putusanTerupload,
                'jlhPerkaraMinutasi' => $perkaraMinutasi,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }
}
