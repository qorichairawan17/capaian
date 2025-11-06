<?php
require_once __DIR__ . '/../config/database.php';

class GetPersentase12
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function total($year)
    {
        // Rumus Indikator 
        /* Jumlah Salinan putusan yang tersedia/dikirm kepada para pihak secara tepat Waktu dibagi
        Jumlah perkara yang diputus * 100% */

        // Cari total perkara tingkat pertama yang didaftarkan melalui ecourt
        $totalSalput = "SELECT COUNT(DISTINCT perkara_putusan_pemberitahuan_putusan.perkara_id) AS total_salput FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id 
        LEFT JOIN perkara_putusan_pemberitahuan_putusan ON perkara.perkara_id = perkara_putusan_pemberitahuan_putusan.perkara_id
        WHERE YEAR(perkara.tanggal_pendaftaran)='$year' AND perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan_pemberitahuan_putusan.tanggal_kirim_salinan_putusan IS NOT NULL;";
        $resultSalput = $this->conn->query($totalSalput);
        $countSalput = $resultSalput->fetch_assoc();
        $dataSalput = $countSalput ? $countSalput['total_salput'] : 0;

        // Cari total perkara tingkat banding yang didaftarkan
        $totalPerkaraPutus = "SELECT COUNT(*) AS total_perkara FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
        WHERE YEAR(perkara.tanggal_pendaftaran)='$year' AND perkara_putusan.tanggal_putusan IS NOT NULL;";
        $resultPerkaraPutus = $this->conn->query($totalPerkaraPutus);
        $countPerkaraPutus = $resultPerkaraPutus->fetch_assoc();
        $dataPerkaraPutus = $countPerkaraPutus ? $countPerkaraPutus['total_perkara'] : 0;


        // Untuk mencari perkara yang diputus berdasarkan jenis perkara
        $totalJenisPerkara = "SELECT 
            COUNT(DISTINCT perkara_putusan.perkara_id) AS total_jenis_perkara, 
            perkara.jenis_perkara_nama, 
            perkara.jenis_perkara_text
            FROM perkara 
            LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
            WHERE YEAR(perkara.tanggal_pendaftaran) = '$year'
              AND perkara_putusan.tanggal_putusan IS NOT NULL
            GROUP BY perkara.jenis_perkara_nama, perkara.jenis_perkara_text";
        $queryJenisPerkara = $this->conn->query($totalJenisPerkara);
        $resultJenisPerkara = [];
        if ($queryJenisPerkara) {
            while ($row = $queryJenisPerkara->fetch_assoc()) {
                $resultJenisPerkara[] = $row;
            }
        }

        return [
            'jlhSalput' => $dataSalput,
            'jlhPerkaraPutus' => $dataPerkaraPutus,
            'persentase' => ($dataPerkaraPutus == 0) ? 0 : ($dataSalput / $dataPerkaraPutus * 100),
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
            // Jumlah salinan putusan yang dikirim per bulan
            $sqlSalput = "SELECT COUNT(DISTINCT perkara_putusan_pemberitahuan_putusan.perkara_id) AS total_salput FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id 
                    LEFT JOIN perkara_putusan_pemberitahuan_putusan ON perkara.perkara_id = perkara_putusan_pemberitahuan_putusan.perkara_id
                    WHERE YEAR(perkara.tanggal_pendaftaran)='$year' AND MONTH(perkara.tanggal_pendaftaran)='$month' AND perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan_pemberitahuan_putusan.tanggal_kirim_salinan_putusan IS NOT NULL;";
            $resultSalput = $this->conn->query($sqlSalput);
            $rowSalput = $resultSalput->fetch_assoc();
            $jlhSalput = $rowSalput ? $rowSalput['total_salput'] : 0;

            // Jumlah perkara yang diputus per bulan
            $sqlPerkaraPutus = "SELECT COUNT(*) AS total_perkara FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
                WHERE YEAR(perkara.tanggal_pendaftaran)='$year' AND MONTH(perkara.tanggal_pendaftaran)='$month' AND perkara_putusan.tanggal_putusan IS NOT NULL;";
            $resultPerkaraPutus = $this->conn->query($sqlPerkaraPutus);
            $rowPerkaraPutus = $resultPerkaraPutus->fetch_assoc();
            $jlhPerkaraPutus = $rowPerkaraPutus ? $rowPerkaraPutus['total_perkara'] : 0;

            $persentase = ($jlhPerkaraPutus == 0) ? 0 : ($jlhSalput / $jlhPerkaraPutus * 100);

            $resultArray[$month] = [
                'jlhSalput' => $jlhSalput,
                'jlhPerkaraPutus' => $jlhPerkaraPutus,
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
            // Jumlah salinan putusan yang dikirim per triwulan
            $sqlSalput = "SELECT COUNT(DISTINCT perkara_putusan_pemberitahuan_putusan.perkara_id) AS total_salput FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id 
                    LEFT JOIN perkara_putusan_pemberitahuan_putusan ON perkara.perkara_id = perkara_putusan_pemberitahuan_putusan.perkara_id
                    WHERE YEAR(perkara.tanggal_pendaftaran)='$year' AND MONTH(perkara.tanggal_pendaftaran) IN ($bulanIn) AND perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan_pemberitahuan_putusan.tanggal_kirim_salinan_putusan IS NOT NULL;";
            $resultSalput = $this->conn->query($sqlSalput);
            $rowSalput = $resultSalput->fetch_assoc();
            $jlhSalput = $rowSalput ? $rowSalput['total_salput'] : 0;

            // Jumlah perkara yang diputus per triwulan
            $sqlPerkaraPutus = "SELECT COUNT(*) AS total_perkara FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
                WHERE YEAR(perkara.tanggal_pendaftaran)='$year' AND MONTH(perkara.tanggal_pendaftaran) IN ($bulanIn) AND perkara_putusan.tanggal_putusan IS NOT NULL;";
            $resultPerkaraPutus = $this->conn->query($sqlPerkaraPutus);
            $rowPerkaraPutus = $resultPerkaraPutus->fetch_assoc();
            $jlhPerkaraPutus = $rowPerkaraPutus ? $rowPerkaraPutus['total_perkara'] : 0;

            $persentase = ($jlhPerkaraPutus == 0) ? 0 : ($jlhSalput / $jlhPerkaraPutus * 100);

            $resultArray[$triwulan] = [
                'jlhSalput' => $jlhSalput,
                'jlhPerkaraPutus' => $jlhPerkaraPutus,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }
}
