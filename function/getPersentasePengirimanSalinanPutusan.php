<?php
require_once __DIR__ . '/../config/database.php';

class getPersentasePengirimanSalinanPutusan
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function total($year)
    {
        // Rumus Indikator (Jumlah salinan putusan yang dikirimkan ke pengadilanpengaju secara tepat waktu / Jumlah perkara yang diputus  ) * 100%

        // Jumlah salinan perkara perdata
        $salinanPerdata = "SELECT COUNT(*) AS total_salinan FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id LEFT JOIN alur_perkara ON perkara.alur_perkara_id = alur_perkara.id
                            WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan.amar_putusan IS NOT NULL 
                            AND alur_perkara.id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);";
        $resultPerdata = $this->conn->query($salinanPerdata);
        $rowPerdata = $resultPerdata->fetch_assoc();
        $dataPerdata = $rowPerdata ? $rowPerdata['total_salinan'] : 0;

        // Jumlah salinan perkara pidana
        $salinanPidana = "SELECT COUNT(*) AS total_salinan FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id LEFT JOIN alur_perkara ON perkara.alur_perkara_id = alur_perkara.id
            LEFT JOIN perkara_putusan_pemberitahuan_putusan ON perkara.perkara_id = perkara_putusan_pemberitahuan_putusan.perkara_id
            WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan.amar_putusan IS NOT NULL 
            AND alur_perkara.id IN(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,129,130,131)
            AND perkara_putusan_pemberitahuan_putusan.tanggal_menerima_putusan IS NOT NULL AND perkara_putusan_pemberitahuan_putusan.tanggal_kirim_salinan_putusan IS NOT NULL;";
        $resultPidana = $this->conn->query($salinanPidana);
        $rowPidana = $resultPidana->fetch_assoc();
        $dataPidana = $rowPidana ? $rowPidana['total_salinan'] : 0;

        // Totalkan jumlah salinan
        $totalSalinan = $dataPerdata + $dataPidana;

        // Jumlah perkara yang diputus
        $perkaraMinutasi = "SELECT COUNT(perkara.perkara_id) AS total_putus FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id 
            WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND perkara_putusan.tanggal_putusan IS NOT NULL;";
        $result2 = $this->conn->query($perkaraMinutasi);
        $row2 = $result2->fetch_assoc();
        $dataPerkaraDiputus = $row2 ? $row2['total_putus'] : 0;

        return [
            'jlhSalinan' => $totalSalinan,
            'jlhPerkaraDiputus' => $dataPerkaraDiputus,
            'persentase' => ($dataPerkaraDiputus == 0) ? 0 : ($totalSalinan / $dataPerkaraDiputus * 100)
        ];
    }

    public function perbulan($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            // Jumlah salinan perkara perdata per bulan
            $salinanPerdata = "SELECT COUNT(*) AS total_salinan FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id LEFT JOIN alur_perkara ON perkara.alur_perkara_id = alur_perkara.id
                WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND MONTH(perkara_putusan.tanggal_putusan)='$month' AND perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan.amar_putusan IS NOT NULL 
                AND alur_perkara.id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);";
            $resultPerdata = $this->conn->query($salinanPerdata);
            $rowPerdata = $resultPerdata->fetch_assoc();
            $dataPerdata = $rowPerdata ? $rowPerdata['total_salinan'] : 0;

            // Jumlah salinan perkara pidana per bulan
            $salinanPidana = "SELECT COUNT(*) AS total_salinan FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id LEFT JOIN alur_perkara ON perkara.alur_perkara_id = alur_perkara.id
                LEFT JOIN perkara_putusan_pemberitahuan_putusan ON perkara.perkara_id = perkara_putusan_pemberitahuan_putusan.perkara_id
                WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND MONTH(perkara_putusan.tanggal_putusan)='$month' AND perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan.amar_putusan IS NOT NULL 
                AND alur_perkara.id IN(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,129,130,131)
                AND perkara_putusan_pemberitahuan_putusan.tanggal_menerima_putusan IS NOT NULL AND perkara_putusan_pemberitahuan_putusan.tanggal_kirim_salinan_putusan IS NOT NULL;";
            $resultPidana = $this->conn->query($salinanPidana);
            $rowPidana = $resultPidana->fetch_assoc();
            $dataPidana = $rowPidana ? $rowPidana['total_salinan'] : 0;

            $totalSalinan = $dataPerdata + $dataPidana;

            // Jumlah perkara yang diputus per bulan
            $perkaraMinutasi = "SELECT COUNT(perkara.perkara_id) AS total_putus FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id 
                WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND MONTH(perkara_putusan.tanggal_putusan)='$month' AND perkara_putusan.tanggal_putusan IS NOT NULL;";
            $result2 = $this->conn->query($perkaraMinutasi);
            $row2 = $result2->fetch_assoc();
            $dataPerkaraDiputus = $row2 ? $row2['total_putus'] : 0;

            $persentase = ($dataPerkaraDiputus == 0) ? 0 : ($totalSalinan / $dataPerkaraDiputus * 100);

            $resultArray[$month] = [
                'jlhSalinan' => $totalSalinan,
                'jlhPerkaraDiputus' => $dataPerkaraDiputus,
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
            // Jumlah salinan perkara perdata per triwulan
            $salinanPerdata = "SELECT COUNT(*) AS total_salinan FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id LEFT JOIN alur_perkara ON perkara.alur_perkara_id = alur_perkara.id
                WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND MONTH(perkara_putusan.tanggal_putusan) IN ($bulanIn) AND perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan.amar_putusan IS NOT NULL 
                AND alur_perkara.id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);";
            $resultPerdata = $this->conn->query($salinanPerdata);
            $rowPerdata = $resultPerdata->fetch_assoc();
            $dataPerdata = $rowPerdata ? $rowPerdata['total_salinan'] : 0;

            // Jumlah salinan perkara pidana per triwulan
            $salinanPidana = "SELECT COUNT(*) AS total_salinan FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id LEFT JOIN alur_perkara ON perkara.alur_perkara_id = alur_perkara.id
                LEFT JOIN perkara_putusan_pemberitahuan_putusan ON perkara.perkara_id = perkara_putusan_pemberitahuan_putusan.perkara_id
                WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND MONTH(perkara_putusan.tanggal_putusan) IN ($bulanIn) AND perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan.amar_putusan IS NOT NULL 
                AND alur_perkara.id IN(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,129,130,131)
                AND perkara_putusan_pemberitahuan_putusan.tanggal_menerima_putusan IS NOT NULL AND perkara_putusan_pemberitahuan_putusan.tanggal_kirim_salinan_putusan IS NOT NULL;";
            $resultPidana = $this->conn->query($salinanPidana);
            $rowPidana = $resultPidana->fetch_assoc();
            $dataPidana = $rowPidana ? $rowPidana['total_salinan'] : 0;

            $totalSalinan = $dataPerdata + $dataPidana;

            // Jumlah perkara yang diputus per triwulan
            $perkaraMinutasi = "SELECT COUNT(perkara.perkara_id) AS total_putus FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id 
                WHERE YEAR(perkara_putusan.tanggal_putusan)='$year' AND MONTH(perkara_putusan.tanggal_putusan) IN ($bulanIn) AND perkara_putusan.tanggal_putusan IS NOT NULL;";
            $result2 = $this->conn->query($perkaraMinutasi);
            $row2 = $result2->fetch_assoc();
            $dataPerkaraDiputus = $row2 ? $row2['total_putus'] : 0;

            $persentase = ($dataPerkaraDiputus == 0) ? 0 : ($totalSalinan / $dataPerkaraDiputus * 100);

            $resultArray[$triwulan] = [
                'jlhSalinan' => $totalSalinan,
                'jlhPerkaraDiputus' => $dataPerkaraDiputus,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }
}
