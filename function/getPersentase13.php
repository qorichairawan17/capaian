<?php
require_once __DIR__ . '/../config/database.php';

class GetPersentase13
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
        /* Jumlah pemberitahuan petikan atau amar putusan tingkat banding, kasasi, PK yang disampaikan kepada para pihak secara tepat waktu dibagi
        Jumlah petikan atau amar putusan banding, kasasi, PK yang diterima pengadilan pengaju * 100% */

        // Cari total petikan tingkat banding
        $totalPetikanBanding = "SELECT COUNT(DISTINCT perkara_banding.perkara_id) AS total_petikan FROM perkara_banding LEFT JOIN perkara_banding_detil ON perkara_banding.perkara_id = perkara_banding_detil.perkara_id 
        WHERE perkara_banding_detil.pemberitahuan_putusan_banding IS NOT NULL AND YEAR(perkara_banding.permohonan_banding)='$year';";
        $resultPetikanBanding = $this->conn->query($totalPetikanBanding);
        $countPetikanBanding = $resultPetikanBanding->fetch_assoc();
        $dataPetikanBanding = $countPetikanBanding ? $countPetikanBanding['total_petikan'] : 0;

        // Cari total petikan tingkat kasasi
        $totalPetikanKasasi = "SELECT COUNT(DISTINCT perkara_kasasi.perkara_id) AS total_petikan FROM perkara_kasasi LEFT JOIN perkara_kasasi_detil ON perkara_kasasi.perkara_id = perkara_kasasi_detil.perkara_id 
        WHERE perkara_kasasi_detil.pemberitahuan_putusan_kasasi IS NOT NULL AND YEAR(perkara_kasasi.permohonan_kasasi)='$year';";
        $resultPetikanKasasi = $this->conn->query($totalPetikanKasasi);
        $countPetikanKasasi = $resultPetikanKasasi->fetch_assoc();
        $dataPetikanKasasi = $countPetikanKasasi ? $countPetikanKasasi['total_petikan'] : 0;

        // Cari total petikan tingkat PK
        $totalPetikanPK = "SELECT COUNT(DISTINCT perkara_pk.perkara_id) AS total_petikan FROM perkara_pk LEFT JOIN perkara_pk_detil ON perkara_pk.perkara_id = perkara_pk_detil.perkara_id 
        WHERE perkara_pk_detil.pemberitahuan_putusan_pk IS NOT NULL AND YEAR(perkara_pk.permohonan_pk)='$year';";
        $resultPetikanPK = $this->conn->query($totalPetikanPK);
        $countPetikanPK = $resultPetikanPK->fetch_assoc();
        $dataPetikanPK = $countPetikanPK ? $countPetikanPK['total_petikan'] : 0;

        // Cari total petikan yang diterima tingkat banding
        $totalDiterimaPetikanBanding = "SELECT COUNT(*) AS total_diterima FROM perkara_banding WHERE pemberitahuan_putusan_banding IS NOT NULL AND YEAR(permohonan_banding)='$year';";
        $resultDiterimaPetikanBanding = $this->conn->query($totalDiterimaPetikanBanding);
        $countDiterimaPetikanBanding = $resultDiterimaPetikanBanding->fetch_assoc();
        $dataDiterimaPetikanBanding = $countDiterimaPetikanBanding ? $countDiterimaPetikanBanding['total_diterima'] : 0;

        // Cari total petikan yang diterima tingkat kasasi
        $totalDiterimaPetikanKasasi = "SELECT COUNT(*) AS total_diterima FROM perkara_kasasi WHERE pemberitahuan_putusan_kasasi IS NOT NULL AND YEAR(permohonan_kasasi)='$year';";
        $resultDiterimaPetikanKasasi = $this->conn->query($totalDiterimaPetikanKasasi);
        $countDiterimaPetikanKasasi = $resultDiterimaPetikanKasasi->fetch_assoc();
        $dataDiterimaPetikanKasasi = $countDiterimaPetikanKasasi ? $countDiterimaPetikanKasasi['total_diterima'] : 0;

        // Cari total petikan yang diterima tingkat PK
        $totalDiterimaPetikanPK = "SELECT COUNT(*) AS total_diterima FROM perkara_pk WHERE pemberitahuan_putusan_pk IS NOT NULL AND YEAR(permohonan_pk)='$year';";
        $resultDiterimaPetikanPK = $this->conn->query($totalDiterimaPetikanPK);
        $countDiterimaPetikanPK = $resultDiterimaPetikanPK->fetch_assoc();
        $dataDiterimaPetikanPK = $countDiterimaPetikanPK ? $countDiterimaPetikanPK['total_diterima'] : 0;


        $totalPetikanDikirim = $dataPetikanBanding + $dataPetikanKasasi + $dataPetikanPK;
        $totalPetikanDiterima = $dataDiterimaPetikanBanding + $dataDiterimaPetikanKasasi + $dataDiterimaPetikanPK;

        return [
            'jlhPetikanDikirim' => $totalPetikanDikirim,
            'jlhPetikanDiterima' => $totalPetikanDiterima,
            'persentase' => ($totalPetikanDikirim == 0) ? 0 : ($totalPetikanDikirim / $totalPetikanDiterima * 100),
        ];
    }

    public function perbulan($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            // Petikan banding dikirim
            $sqlPetikanBanding = "SELECT COUNT(DISTINCT perkara_banding.perkara_id) AS total_petikan FROM perkara_banding LEFT JOIN perkara_banding_detil ON perkara_banding.perkara_id = perkara_banding_detil.perkara_id WHERE perkara_banding_detil.pemberitahuan_putusan_banding IS NOT NULL AND YEAR(perkara_banding.permohonan_banding)='$year' AND MONTH(perkara_banding.permohonan_banding)='$month';";
            $resultPetikanBanding = $this->conn->query($sqlPetikanBanding);
            $rowPetikanBanding = $resultPetikanBanding->fetch_assoc();
            $dataPetikanBanding = $rowPetikanBanding ? $rowPetikanBanding['total_petikan'] : 0;

            // Petikan kasasi dikirim
            $sqlPetikanKasasi = "SELECT COUNT(DISTINCT perkara_kasasi.perkara_id) AS total_petikan FROM perkara_kasasi LEFT JOIN perkara_kasasi_detil ON perkara_kasasi.perkara_id = perkara_kasasi_detil.perkara_id WHERE perkara_kasasi_detil.pemberitahuan_putusan_kasasi IS NOT NULL AND YEAR(perkara_kasasi.permohonan_kasasi)='$year' AND MONTH(perkara_kasasi.permohonan_kasasi)='$month';";
            $resultPetikanKasasi = $this->conn->query($sqlPetikanKasasi);
            $rowPetikanKasasi = $resultPetikanKasasi->fetch_assoc();
            $dataPetikanKasasi = $rowPetikanKasasi ? $rowPetikanKasasi['total_petikan'] : 0;

            // Petikan PK dikirim
            $sqlPetikanPK = "SELECT COUNT(DISTINCT perkara_pk.perkara_id) AS total_petikan FROM perkara_pk LEFT JOIN perkara_pk_detil ON perkara_pk.perkara_id = perkara_pk_detil.perkara_id WHERE perkara_pk_detil.pemberitahuan_putusan_pk IS NOT NULL AND YEAR(perkara_pk.permohonan_pk)='$year' AND MONTH(perkara_pk.permohonan_pk)='$month';";
            $resultPetikanPK = $this->conn->query($sqlPetikanPK);
            $rowPetikanPK = $resultPetikanPK->fetch_assoc();
            $dataPetikanPK = $rowPetikanPK ? $rowPetikanPK['total_petikan'] : 0;

            // Petikan banding diterima
            $sqlDiterimaBanding = "SELECT COUNT(*) AS total_diterima FROM perkara_banding WHERE pemberitahuan_putusan_banding IS NOT NULL AND YEAR(permohonan_banding)='$year' AND MONTH(permohonan_banding)='$month';";
            $resultDiterimaBanding = $this->conn->query($sqlDiterimaBanding);
            $rowDiterimaBanding = $resultDiterimaBanding->fetch_assoc();
            $dataDiterimaBanding = $rowDiterimaBanding ? $rowDiterimaBanding['total_diterima'] : 0;

            // Petikan kasasi diterima
            $sqlDiterimaKasasi = "SELECT COUNT(*) AS total_diterima FROM perkara_kasasi WHERE pemberitahuan_putusan_kasasi IS NOT NULL AND YEAR(permohonan_kasasi)='$year' AND MONTH(permohonan_kasasi)='$month';";
            $resultDiterimaKasasi = $this->conn->query($sqlDiterimaKasasi);
            $rowDiterimaKasasi = $resultDiterimaKasasi->fetch_assoc();
            $dataDiterimaKasasi = $rowDiterimaKasasi ? $rowDiterimaKasasi['total_diterima'] : 0;

            // Petikan PK diterima
            $sqlDiterimaPK = "SELECT COUNT(*) AS total_diterima FROM perkara_pk WHERE pemberitahuan_putusan_pk IS NOT NULL AND YEAR(permohonan_pk)='$year' AND MONTH(permohonan_pk)='$month';";
            $resultDiterimaPK = $this->conn->query($sqlDiterimaPK);
            $rowDiterimaPK = $resultDiterimaPK->fetch_assoc();
            $dataDiterimaPK = $rowDiterimaPK ? $rowDiterimaPK['total_diterima'] : 0;

            $totalPetikanDikirim = $dataPetikanBanding + $dataPetikanKasasi + $dataPetikanPK;
            $totalPetikanDiterima = $dataDiterimaBanding + $dataDiterimaKasasi + $dataDiterimaPK;

            $persentase = ($totalPetikanDikirim == 0) ? 0 : ($totalPetikanDikirim / $totalPetikanDiterima * 100);

            $resultArray[$month] = [
                'jlhPetikanDikirim' => $totalPetikanDikirim,
                'jlhPetikanDiterima' => $totalPetikanDiterima,
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
            // Petikan banding dikirim
            $sqlPetikanBanding = "SELECT COUNT(DISTINCT perkara_banding.perkara_id) AS total_petikan FROM perkara_banding LEFT JOIN perkara_banding_detil ON perkara_banding.perkara_id = perkara_banding_detil.perkara_id WHERE perkara_banding_detil.pemberitahuan_putusan_banding IS NOT NULL AND YEAR(perkara_banding.permohonan_banding)='$year' AND MONTH(perkara_banding.permohonan_banding) IN ($bulanIn);";
            $resultPetikanBanding = $this->conn->query($sqlPetikanBanding);
            $rowPetikanBanding = $resultPetikanBanding->fetch_assoc();
            $dataPetikanBanding = $rowPetikanBanding ? $rowPetikanBanding['total_petikan'] : 0;

            // Petikan kasasi dikirim
            $sqlPetikanKasasi = "SELECT COUNT(DISTINCT perkara_kasasi.perkara_id) AS total_petikan FROM perkara_kasasi LEFT JOIN perkara_kasasi_detil ON perkara_kasasi.perkara_id = perkara_kasasi_detil.perkara_id WHERE perkara_kasasi_detil.pemberitahuan_putusan_kasasi IS NOT NULL AND YEAR(perkara_kasasi.permohonan_kasasi)='$year' AND MONTH(perkara_kasasi.permohonan_kasasi) IN ($bulanIn);";
            $resultPetikanKasasi = $this->conn->query($sqlPetikanKasasi);
            $rowPetikanKasasi = $resultPetikanKasasi->fetch_assoc();
            $dataPetikanKasasi = $rowPetikanKasasi ? $rowPetikanKasasi['total_petikan'] : 0;

            // Petikan PK dikirim
            $sqlPetikanPK = "SELECT COUNT(DISTINCT perkara_pk.perkara_id) AS total_petikan FROM perkara_pk LEFT JOIN perkara_pk_detil ON perkara_pk.perkara_id = perkara_pk_detil.perkara_id WHERE perkara_pk_detil.pemberitahuan_putusan_pk IS NOT NULL AND YEAR(perkara_pk.permohonan_pk)='$year' AND MONTH(perkara_pk.permohonan_pk) IN ($bulanIn);";
            $resultPetikanPK = $this->conn->query($sqlPetikanPK);
            $rowPetikanPK = $resultPetikanPK->fetch_assoc();
            $dataPetikanPK = $rowPetikanPK ? $rowPetikanPK['total_petikan'] : 0;

            // Petikan banding diterima
            $sqlDiterimaBanding = "SELECT COUNT(*) AS total_diterima FROM perkara_banding WHERE pemberitahuan_putusan_banding IS NOT NULL AND YEAR(permohonan_banding)='$year' AND MONTH(permohonan_banding) IN ($bulanIn);";
            $resultDiterimaBanding = $this->conn->query($sqlDiterimaBanding);
            $rowDiterimaBanding = $resultDiterimaBanding->fetch_assoc();
            $dataDiterimaBanding = $rowDiterimaBanding ? $rowDiterimaBanding['total_diterima'] : 0;

            // Petikan kasasi diterima
            $sqlDiterimaKasasi = "SELECT COUNT(*) AS total_diterima FROM perkara_kasasi WHERE pemberitahuan_putusan_kasasi IS NOT NULL AND YEAR(permohonan_kasasi)='$year' AND MONTH(permohonan_kasasi) IN ($bulanIn);";
            $resultDiterimaKasasi = $this->conn->query($sqlDiterimaKasasi);
            $rowDiterimaKasasi = $resultDiterimaKasasi->fetch_assoc();
            $dataDiterimaKasasi = $rowDiterimaKasasi ? $rowDiterimaKasasi['total_diterima'] : 0;

            // Petikan PK diterima
            $sqlDiterimaPK = "SELECT COUNT(*) AS total_diterima FROM perkara_pk WHERE pemberitahuan_putusan_pk IS NOT NULL AND YEAR(permohonan_pk)='$year' AND MONTH(permohonan_pk) IN ($bulanIn);";
            $resultDiterimaPK = $this->conn->query($sqlDiterimaPK);
            $rowDiterimaPK = $resultDiterimaPK->fetch_assoc();
            $dataDiterimaPK = $rowDiterimaPK ? $rowDiterimaPK['total_diterima'] : 0;

            $totalPetikanDikirim = $dataPetikanBanding + $dataPetikanKasasi + $dataPetikanPK;
            $totalPetikanDiterima = $dataDiterimaBanding + $dataDiterimaKasasi + $dataDiterimaPK;

            $persentase = ($totalPetikanDikirim == 0) ? 0 : ($totalPetikanDikirim / $totalPetikanDiterima * 100);

            $resultArray[$triwulan] = [
                'jlhPetikanDikirim' => $totalPetikanDikirim,
                'jlhPetikanDiterima' => $totalPetikanDiterima,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }
}
