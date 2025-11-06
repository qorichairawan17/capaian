<?php
require_once __DIR__ . '/../config/database.php';

class GetPersentase14
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
        /* Jumlah salinan putusan yang dikirimkan kepada para pihak secara tepat waktu dibagi
        Jumlah salinan putusan banding kasasi dan PK yang diterima pengadilan pengaju * 100% */

        // Cari total salinan tingkat banding
        $totalSalinanBanding = "SELECT COUNT(DISTINCT perkara_banding.perkara_id) AS total_salinan FROM perkara_banding LEFT JOIN perkara_banding_detil ON perkara_banding.perkara_id = perkara_banding_detil.perkara_id 
        WHERE perkara_banding_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_banding.permohonan_banding)='$year';";
        $resultSalinanBanding = $this->conn->query($totalSalinanBanding);
        $countSalinanBanding = $resultSalinanBanding->fetch_assoc();
        $dataSalinanBanding = $countSalinanBanding ? $countSalinanBanding['total_salinan'] : 0;

        // Cari total salinan tingkat kasasi
        $totalSalinanKasasi = "SELECT COUNT(DISTINCT perkara_kasasi.perkara_id) AS total_salinan FROM perkara_kasasi LEFT JOIN perkara_kasasi_detil ON perkara_kasasi.perkara_id = perkara_kasasi_detil.perkara_id 
        WHERE perkara_kasasi_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_kasasi.permohonan_kasasi)='$year';";
        $resultSalinanKasasi = $this->conn->query($totalSalinanKasasi);
        $countSalinanKasasi = $resultSalinanKasasi->fetch_assoc();
        $dataSalinanKasasi = $countSalinanKasasi ? $countSalinanKasasi['total_salinan'] : 0;

        // Cari total salinan tingkat PK
        $totalSalinanPK = "SELECT COUNT(DISTINCT perkara_pk.perkara_id) AS total_salinan FROM perkara_pk LEFT JOIN perkara_pk_detil ON perkara_pk.perkara_id = perkara_pk_detil.perkara_id 
        WHERE perkara_pk_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_pk.permohonan_pk)='$year';";
        $resultSalinanPK = $this->conn->query($totalSalinanPK);
        $countSalinanPK = $resultSalinanPK->fetch_assoc();
        $dataSalinanPK = $countSalinanPK ? $countSalinanPK['total_salinan'] : 0;

        // Cari total salinan yang diterima tingkat banding
        $totalDiterimaSalinanBanding = "SELECT COUNT(*) AS total_diterima FROM perkara_banding WHERE tgl_pengiriman_berkas_putusan IS NOT NULL AND YEAR(permohonan_banding)='$year';";
        $resultDiterimaSalinanBanding = $this->conn->query($totalDiterimaSalinanBanding);
        $countDiterimaSalinanBanding = $resultDiterimaSalinanBanding->fetch_assoc();
        $dataDiterimaSalinanBanding = $countDiterimaSalinanBanding ? $countDiterimaSalinanBanding['total_diterima'] : 0;

        // Cari total salinan yang diterima tingkat kasasi
        $totalDiterimaSalinanKasasi = "SELECT COUNT(*) AS total_diterima FROM perkara_kasasi WHERE putusan_kasasi IS NOT NULL AND YEAR(permohonan_kasasi)='$year';";
        $resultDiterimaSalinanKasasi = $this->conn->query($totalDiterimaSalinanKasasi);
        $countDiterimaSalinanKasasi = $resultDiterimaSalinanKasasi->fetch_assoc();
        $dataDiterimaSalinanKasasi = $countDiterimaSalinanKasasi ? $countDiterimaSalinanKasasi['total_diterima'] : 0;

        // Cari total salinan yang diterima tingkat PK
        $totalDiterimaSalinanPK = "SELECT COUNT(*) AS total_diterima FROM perkara_pk WHERE putusan_pk IS NOT NULL AND YEAR(permohonan_pk)='$year';";
        $resultDiterimaSalinanPK = $this->conn->query($totalDiterimaSalinanPK);
        $countDiterimaSalinanPK = $resultDiterimaSalinanPK->fetch_assoc();
        $dataDiterimaSalinanPK = $countDiterimaSalinanPK ? $countDiterimaSalinanPK['total_diterima'] : 0;


        $totalSalinanDikirim = $dataSalinanBanding + $dataSalinanKasasi + $dataSalinanPK;
        $totalSalinanDiterima = $dataDiterimaSalinanBanding + $dataDiterimaSalinanKasasi + $dataDiterimaSalinanPK;

        return [
            'jlhPetikanDikirim' => $totalSalinanDikirim,
            'jlhPetikanDiterima' => $totalSalinanDiterima,
            'persentase' => ($totalSalinanDikirim == 0) ? 0 : ($totalSalinanDiterima / $totalSalinanDikirim * 100),
        ];
    }

    public function perbulan($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            // Salinan banding dikirim
            $sqlSalinanBanding = "SELECT COUNT(DISTINCT perkara_banding.perkara_id) AS total_salinan FROM perkara_banding LEFT JOIN perkara_banding_detil ON perkara_banding.perkara_id = perkara_banding_detil.perkara_id WHERE perkara_banding_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_banding.permohonan_banding)='$year' AND MONTH(perkara_banding.permohonan_banding)='$month';";
            $sqlSalinanBanding = "SELECT COUNT(DISTINCT perkara_banding.perkara_id) AS total_salinan FROM perkara_banding LEFT JOIN perkara_banding_detil ON perkara_banding.perkara_id = perkara_banding_detil.perkara_id WHERE perkara_banding_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_banding.permohonan_banding)='$year' AND MONTH(perkara_banding.permohonan_banding)='$month';";
            $resultSalinanBanding = $this->conn->query($sqlSalinanBanding);
            $rowSalinanBanding = $resultSalinanBanding->fetch_assoc();
            $dataSalinanBanding = $rowSalinanBanding ? $rowSalinanBanding['total_salinan'] : 0;

            $sqlSalinanKasasi = "SELECT COUNT(DISTINCT perkara_kasasi.perkara_id) AS total_salinan FROM perkara_kasasi LEFT JOIN perkara_kasasi_detil ON perkara_kasasi.perkara_id = perkara_kasasi_detil.perkara_id WHERE perkara_kasasi_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_kasasi.permohonan_kasasi)='$year' AND MONTH(perkara_kasasi.permohonan_kasasi)='$month';";
            $resultSalinanKasasi = $this->conn->query($sqlSalinanKasasi);
            $rowSalinanKasasi = $resultSalinanKasasi->fetch_assoc();
            $dataSalinanKasasi = $rowSalinanKasasi ? $rowSalinanKasasi['total_salinan'] : 0;

            $sqlSalinanPK = "SELECT COUNT(DISTINCT perkara_pk.perkara_id) AS total_salinan FROM perkara_pk LEFT JOIN perkara_pk_detil ON perkara_pk.perkara_id = perkara_pk_detil.perkara_id WHERE perkara_pk_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_pk.permohonan_pk)='$year' AND MONTH(perkara_pk.permohonan_pk)='$month';";
            $resultSalinanPK = $this->conn->query($sqlSalinanPK);
            $rowSalinanPK = $resultSalinanPK->fetch_assoc();
            $dataSalinanPK = $rowSalinanPK ? $rowSalinanPK['total_salinan'] : 0;

            $sqlDiterimaBanding = "SELECT COUNT(*) AS total_diterima FROM perkara_banding WHERE tgl_pengiriman_berkas_putusan IS NOT NULL AND YEAR(permohonan_banding)='$year' AND MONTH(permohonan_banding)='$month';";
            $resultDiterimaBanding = $this->conn->query($sqlDiterimaBanding);
            $rowDiterimaBanding = $resultDiterimaBanding->fetch_assoc();
            $dataDiterimaBanding = $rowDiterimaBanding ? $rowDiterimaBanding['total_diterima'] : 0;

            $sqlDiterimaKasasi = "SELECT COUNT(*) AS total_diterima FROM perkara_kasasi WHERE putusan_kasasi IS NOT NULL AND YEAR(permohonan_kasasi)='$year' AND MONTH(permohonan_kasasi)='$month';";
            $resultDiterimaKasasi = $this->conn->query($sqlDiterimaKasasi);
            $rowDiterimaKasasi = $resultDiterimaKasasi->fetch_assoc();
            $dataDiterimaKasasi = $rowDiterimaKasasi ? $rowDiterimaKasasi['total_diterima'] : 0;

            $sqlDiterimaPK = "SELECT COUNT(*) AS total_diterima FROM perkara_pk WHERE putusan_pk IS NOT NULL AND YEAR(permohonan_pk)='$year' AND MONTH(permohonan_pk)='$month';";
            $resultDiterimaPK = $this->conn->query($sqlDiterimaPK);
            $rowDiterimaPK = $resultDiterimaPK->fetch_assoc();
            $dataDiterimaPK = $rowDiterimaPK ? $rowDiterimaPK['total_diterima'] : 0;

            $totalSalinanDikirim = $dataSalinanBanding + $dataSalinanKasasi + $dataSalinanPK;
            $totalSalinanDiterima = $dataDiterimaBanding + $dataDiterimaKasasi + $dataDiterimaPK;

            $persentase = ($totalSalinanDikirim == 0) ? 0 : ($totalSalinanDiterima / $totalSalinanDikirim * 100);

            $resultArray[$month] = [
                'jlhPetikanDikirim' => $totalSalinanDikirim,
                'jlhPetikanDiterima' => $totalSalinanDiterima,
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
            // Salinan banding dikirim
            $sqlSalinanBanding = "SELECT COUNT(DISTINCT perkara_banding.perkara_id) AS total_salinan FROM perkara_banding LEFT JOIN perkara_banding_detil ON perkara_banding.perkara_id = perkara_banding_detil.perkara_id WHERE perkara_banding_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_banding.permohonan_banding)='$year' AND MONTH(perkara_banding.permohonan_banding) IN ($bulanIn);";
            $resultSalinanBanding = $this->conn->query($sqlSalinanBanding);
            $rowSalinanBanding = $resultSalinanBanding->fetch_assoc();
            $dataSalinanBanding = $rowSalinanBanding ? $rowSalinanBanding['total_salinan'] : 0;

            // Salinan kasasi dikirim
            $sqlSalinanKasasi = "SELECT COUNT(DISTINCT perkara_kasasi.perkara_id) AS total_salinan FROM perkara_kasasi LEFT JOIN perkara_kasasi_detil ON perkara_kasasi.perkara_id = perkara_kasasi_detil.perkara_id WHERE perkara_kasasi_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_kasasi.permohonan_kasasi)='$year' AND MONTH(perkara_kasasi.permohonan_kasasi) IN ($bulanIn);";
            $resultSalinanKasasi = $this->conn->query($sqlSalinanKasasi);
            $rowSalinanKasasi = $resultSalinanKasasi->fetch_assoc();
            $dataSalinanKasasi = $rowSalinanKasasi ? $rowSalinanKasasi['total_salinan'] : 0;

            // Salinan PK dikirim
            $sqlSalinanPK = "SELECT COUNT(DISTINCT perkara_pk.perkara_id) AS total_salinan FROM perkara_pk LEFT JOIN perkara_pk_detil ON perkara_pk.perkara_id = perkara_pk_detil.perkara_id WHERE perkara_pk_detil.tanggal_kirim_salinan_putusan IS NOT NULL AND YEAR(perkara_pk.permohonan_pk)='$year' AND MONTH(perkara_pk.permohonan_pk) IN ($bulanIn);";
            $resultSalinanPK = $this->conn->query($sqlSalinanPK);
            $rowSalinanPK = $resultSalinanPK->fetch_assoc();
            $dataSalinanPK = $rowSalinanPK ? $rowSalinanPK['total_salinan'] : 0;

            // Salinan banding diterima
            $sqlDiterimaBanding = "SELECT COUNT(*) AS total_diterima FROM perkara_banding WHERE tgl_pengiriman_berkas_putusan IS NOT NULL AND YEAR(permohonan_banding)='$year' AND MONTH(permohonan_banding) IN ($bulanIn);";
            $resultDiterimaBanding = $this->conn->query($sqlDiterimaBanding);
            $rowDiterimaBanding = $resultDiterimaBanding->fetch_assoc();
            $dataDiterimaBanding = $rowDiterimaBanding ? $rowDiterimaBanding['total_diterima'] : 0;

            // Salinan kasasi diterima
            $sqlDiterimaKasasi = "SELECT COUNT(*) AS total_diterima FROM perkara_kasasi WHERE putusan_kasasi IS NOT NULL AND YEAR(permohonan_kasasi)='$year' AND MONTH(permohonan_kasasi) IN ($bulanIn);";
            $resultDiterimaKasasi = $this->conn->query($sqlDiterimaKasasi);
            $rowDiterimaKasasi = $resultDiterimaKasasi->fetch_assoc();
            $dataDiterimaKasasi = $rowDiterimaKasasi ? $rowDiterimaKasasi['total_diterima'] : 0;

            // Salinan PK diterima
            $sqlDiterimaPK = "SELECT COUNT(*) AS total_diterima FROM perkara_pk WHERE putusan_pk IS NOT NULL AND YEAR(permohonan_pk)='$year' AND MONTH(permohonan_pk) IN ($bulanIn);";
            $resultDiterimaPK = $this->conn->query($sqlDiterimaPK);
            $rowDiterimaPK = $resultDiterimaPK->fetch_assoc();
            $dataDiterimaPK = $rowDiterimaPK ? $rowDiterimaPK['total_diterima'] : 0;

            $totalSalinanDikirim = $dataSalinanBanding + $dataSalinanKasasi + $dataSalinanPK;
            $totalSalinanDiterima = $dataDiterimaBanding + $dataDiterimaKasasi + $dataDiterimaPK;

            $persentase = ($totalSalinanDikirim == 0) ? 0 : ($totalSalinanDiterima / $totalSalinanDikirim * 100);

            $resultArray[$triwulan] = [
                'jlhPetikanDikirim' => $totalSalinanDikirim,
                'jlhPetikanDiterima' => $totalSalinanDiterima,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }
}
