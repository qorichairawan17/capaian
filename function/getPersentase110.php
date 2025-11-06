<?php
require_once __DIR__ . '/../config/database.php';

class GetPersentase110
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function total($year)
    {
        // Rumus Indikator (Jumlah perkara perdata,perdata agama dan tata usaha negara tingkat pertama dan tingkat banding yang diajukan menggunakan e-court / Jumlah perkara perdata,perdata agama dan tata usaha negara tingkat pertama dan tingkat banding yang diajukan ) * 100%

        // Cari total perkara tingkat pertama yang didaftarkan melalui ecourt
        $totalPerkaraTkPertamaEcourt = "SELECT COUNT(perkara_efiling.nomor_perkara) AS total_perkara
                            FROM perkara_efiling LEFT JOIN alur_perkara ON perkara_efiling.alur_perkara_id = alur_perkara.id
                            WHERE YEAR(tgl_pendaftaran_perkara) = '$year' AND perkara_efiling.alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);";
        $resultTkPertamaEcourt = $this->conn->query($totalPerkaraTkPertamaEcourt);
        $rowTkPertamaEcourt = $resultTkPertamaEcourt->fetch_assoc();
        $data1 = $rowTkPertamaEcourt ? $rowTkPertamaEcourt['total_perkara'] : 0;

        // Cari total perkara tingkat banding yang didaftarkan melalui ecourt
        $totalPerkaraTkBandingEcourt = "SELECT COUNT(*) AS total_perkara FROM ecourt_banding WHERE YEAR(tanggal_permohonan_banding)='$year'";
        $resultTkBandingEcourt = $this->conn->query($totalPerkaraTkBandingEcourt);
        $rowTkBandingEcourt = $resultTkBandingEcourt->fetch_assoc();
        $data2 = $rowTkBandingEcourt ? $rowTkBandingEcourt['total_perkara'] : 0;

        // Kalkulasikan total perkara ecourt tk pertama dan banding
        $totalPerkaraEcourt = $data1 + $data2;

        // Cari total perkara tingkat pertama yang didaftarkan
        $totalPerkaraTkPertama = "SELECT COUNT(*) AS total_perkara FROM perkara WHERE alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32) 
                                AND YEAR(tanggal_pendaftaran)='$year';";
        $resultTkPertama = $this->conn->query($totalPerkaraTkPertama);
        $rowTkPertama = $resultTkPertama->fetch_assoc();
        $data3 = $rowTkPertama ? $rowTkPertama['total_perkara'] : 0;

        // Cari total perkara tingkat banding yang didaftarkan
        $totalPerkaraTkBanding = "SELECT COUNT(*) AS total_perkara FROM perkara_banding WHERE alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32) 
                                AND YEAR(permohonan_banding)='$year';";
        $resultTkBanding = $this->conn->query($totalPerkaraTkBanding);
        $rowTkBanding = $resultTkBanding->fetch_assoc();
        $data4 = $rowTkBanding ? $rowTkBanding['total_perkara'] : 0;

        $totalPerkara = $data3 + $data4;

        return [
            'jlhPerkaraEcourt' => $totalPerkaraEcourt,
            'jlhPerkara' => $totalPerkara,
            'persentase' => ($totalPerkara == 0) ? 0 : ($totalPerkaraEcourt / $totalPerkara * 100)
        ];
    }

    public function perbulan($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            // Perkara e-court tingkat pertama per bulan
            $sqlTkPertamaEcourt = "SELECT COUNT(perkara_efiling.nomor_perkara) AS total_perkara
                FROM perkara_efiling LEFT JOIN alur_perkara ON perkara_efiling.alur_perkara_id = alur_perkara.id
                WHERE YEAR(tgl_pendaftaran_perkara) = '$year' AND MONTH(tgl_pendaftaran_perkara) = '$month' AND perkara_efiling.alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);";
            $resultTkPertamaEcourt = $this->conn->query($sqlTkPertamaEcourt);
            $rowTkPertamaEcourt = $resultTkPertamaEcourt->fetch_assoc();
            $data1 = $rowTkPertamaEcourt ? $rowTkPertamaEcourt['total_perkara'] : 0;

            // Perkara e-court tingkat banding per bulan
            $sqlTkBandingEcourt = "SELECT COUNT(*) AS total_perkara FROM ecourt_banding WHERE YEAR(tanggal_permohonan_banding)='$year' AND MONTH(tanggal_permohonan_banding)='$month';";
            $resultTkBandingEcourt = $this->conn->query($sqlTkBandingEcourt);
            $rowTkBandingEcourt = $resultTkBandingEcourt->fetch_assoc();
            $data2 = $rowTkBandingEcourt ? $rowTkBandingEcourt['total_perkara'] : 0;

            $totalPerkaraEcourt = $data1 + $data2;

            // Total perkara tingkat pertama per bulan
            $sqlTkPertama = "SELECT COUNT(*) AS total_perkara FROM perkara WHERE alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32) 
                AND YEAR(tanggal_pendaftaran)='$year' AND MONTH(tanggal_pendaftaran)='$month';";
            $resultTkPertama = $this->conn->query($sqlTkPertama);
            $rowTkPertama = $resultTkPertama->fetch_assoc();
            $data3 = $rowTkPertama ? $rowTkPertama['total_perkara'] : 0;

            // Total perkara tingkat banding per bulan
            $sqlTkBanding = "SELECT COUNT(*) AS total_perkara FROM perkara_banding WHERE alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32) 
                AND YEAR(permohonan_banding)='$year' AND MONTH(permohonan_banding)='$month';";
            $resultTkBanding = $this->conn->query($sqlTkBanding);
            $rowTkBanding = $resultTkBanding->fetch_assoc();
            $data4 = $rowTkBanding ? $rowTkBanding['total_perkara'] : 0;

            $totalPerkara = $data3 + $data4;

            $persentase = ($totalPerkara == 0) ? 0 : ($totalPerkaraEcourt / $totalPerkara * 100);

            $resultArray[$month] = [
                'jlhPerkaraEcourt' => $totalPerkaraEcourt,
                'jlhPerkara' => $totalPerkara,
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
            // Perkara e-court tingkat pertama per triwulan
            $sqlTkPertamaEcourt = "SELECT COUNT(perkara_efiling.nomor_perkara) AS total_perkara
                FROM perkara_efiling LEFT JOIN alur_perkara ON perkara_efiling.alur_perkara_id = alur_perkara.id
                WHERE YEAR(tgl_pendaftaran_perkara) = '$year' AND MONTH(tgl_pendaftaran_perkara) IN ($bulanIn) AND perkara_efiling.alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);";
            $resultTkPertamaEcourt = $this->conn->query($sqlTkPertamaEcourt);
            $rowTkPertamaEcourt = $resultTkPertamaEcourt->fetch_assoc();
            $data1 = $rowTkPertamaEcourt ? $rowTkPertamaEcourt['total_perkara'] : 0;

            // Perkara e-court tingkat banding per triwulan
            $sqlTkBandingEcourt = "SELECT COUNT(*) AS total_perkara FROM ecourt_banding WHERE YEAR(tanggal_permohonan_banding)='$year' AND MONTH(tanggal_permohonan_banding) IN ($bulanIn);";
            $resultTkBandingEcourt = $this->conn->query($sqlTkBandingEcourt);
            $rowTkBandingEcourt = $resultTkBandingEcourt->fetch_assoc();
            $data2 = $rowTkBandingEcourt ? $rowTkBandingEcourt['total_perkara'] : 0;

            $totalPerkaraEcourt = $data1 + $data2;

            // Total perkara tingkat pertama per triwulan
            $sqlTkPertama = "SELECT COUNT(*) AS total_perkara FROM perkara WHERE alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32) 
                AND YEAR(tanggal_pendaftaran)='$year' AND MONTH(tanggal_pendaftaran) IN ($bulanIn);";
            $resultTkPertama = $this->conn->query($sqlTkPertama);
            $rowTkPertama = $resultTkPertama->fetch_assoc();
            $data3 = $rowTkPertama ? $rowTkPertama['total_perkara'] : 0;

            // Total perkara tingkat banding per triwulan
            $sqlTkBanding = "SELECT COUNT(*) AS total_perkara FROM perkara_banding WHERE alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32) 
                AND YEAR(permohonan_banding)='$year' AND MONTH(permohonan_banding) IN ($bulanIn);";
            $resultTkBanding = $this->conn->query($sqlTkBanding);
            $rowTkBanding = $resultTkBanding->fetch_assoc();
            $data4 = $rowTkBanding ? $rowTkBanding['total_perkara'] : 0;

            $totalPerkara = $data3 + $data4;

            $persentase = ($totalPerkara == 0) ? 0 : ($totalPerkaraEcourt / $totalPerkara * 100);

            $resultArray[$triwulan] = [
                'jlhPerkaraEcourt' => $totalPerkaraEcourt,
                'jlhPerkara' => $totalPerkara,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }
}
