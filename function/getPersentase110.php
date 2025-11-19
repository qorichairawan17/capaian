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
        // 11 adalah status efiling yang menandakan bahwa Pendaftaran Tidak Dapat Dilanjutkan
        $totalPerkaraTkPertamaEcourt = "SELECT COUNT(perkara_efiling.nomor_perkara) AS total_perkara FROM perkara_efiling LEFT JOIN perkara ON perkara_efiling.`nomor_perkara` = perkara.`nomor_perkara` LEFT JOIN alur_perkara ON perkara_efiling.alur_perkara_id = alur_perkara.id
                                WHERE perkara_efiling.status_pendaftaran_id <> '11' AND perkara_efiling.`nomor_perkara`<>'' AND YEAR(tgl_pendaftaran_perkara) = '$year' AND perkara_efiling.alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);";
        $resultTkPertamaEcourt = $this->conn->query($totalPerkaraTkPertamaEcourt);
        $rowTkPertamaEcourt = $resultTkPertamaEcourt->fetch_assoc();
        $totalPerkaraEcourt = $rowTkPertamaEcourt ? $rowTkPertamaEcourt['total_perkara'] : 0;

        // Cari total perkara tingkat pertama yang didaftarkan
        $totalPerkaraTkPertama = "SELECT COUNT(*) AS total_perkara FROM perkara WHERE alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32) 
                                AND YEAR(tanggal_pendaftaran)='$year';";
        $resultTkPertama = $this->conn->query($totalPerkaraTkPertama);
        $rowTkPertama = $resultTkPertama->fetch_assoc();
        $totalPerkara = $rowTkPertama ? $rowTkPertama['total_perkara'] : 0;

        return [
            'jlhPerkaraEcourt' => $totalPerkaraEcourt,
            'jlhPerkara' => $totalPerkara,
            'persentase' => ($totalPerkaraEcourt == 0) ? 0 : ($totalPerkaraEcourt / $totalPerkara * 100)
        ];
    }

    public function perbulan($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            // Perkara e-court tingkat pertama per bulan (mengikuti logika total)
            $sqlTkPertamaEcourt = "SELECT COUNT(perkara_efiling.nomor_perkara) AS total_perkara FROM perkara_efiling LEFT JOIN perkara ON perkara_efiling.`nomor_perkara` = perkara.`nomor_perkara` LEFT JOIN alur_perkara ON perkara_efiling.alur_perkara_id = alur_perkara.id
                WHERE perkara_efiling.status_pendaftaran_id <> '11' AND perkara_efiling.`nomor_perkara`<>'' AND YEAR(tgl_pendaftaran_perkara) = '$year' AND MONTH(tgl_pendaftaran_perkara) = '$month' AND perkara_efiling.alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);";
            $resultTkPertamaEcourt = $this->conn->query($sqlTkPertamaEcourt);
            $rowTkPertamaEcourt = $resultTkPertamaEcourt->fetch_assoc();
            $totalPerkaraEcourt = $rowTkPertamaEcourt ? $rowTkPertamaEcourt['total_perkara'] : 0;

            // Total perkara tingkat pertama per bulan (tanpa banding) mengikuti logika total
            $sqlTkPertama = "SELECT COUNT(*) AS total_perkara FROM perkara WHERE alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32) 
                AND YEAR(tanggal_pendaftaran)='$year' AND MONTH(tanggal_pendaftaran)='$month';";
            $resultTkPertama = $this->conn->query($sqlTkPertama);
            $rowTkPertama = $resultTkPertama->fetch_assoc();
            $totalPerkara = $rowTkPertama ? $rowTkPertama['total_perkara'] : 0;

            // Persentase mengikuti perhitungan di function total
            $persentase = ($totalPerkaraEcourt == 0) ? 0 : ($totalPerkaraEcourt / $totalPerkara * 100);

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
            // Perkara e-court tingkat pertama per triwulan (mengikuti logika total)
            $sqlTkPertamaEcourt = "SELECT COUNT(perkara_efiling.nomor_perkara) AS total_perkara FROM perkara_efiling LEFT JOIN perkara ON perkara_efiling.`nomor_perkara` = perkara.`nomor_perkara` LEFT JOIN alur_perkara ON perkara_efiling.alur_perkara_id = alur_perkara.id
                WHERE perkara_efiling.status_pendaftaran_id <> '11' AND perkara_efiling.`nomor_perkara`<>'' AND YEAR(tgl_pendaftaran_perkara) = '$year' AND MONTH(tgl_pendaftaran_perkara) IN ($bulanIn) AND perkara_efiling.alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32);";
            $resultTkPertamaEcourt = $this->conn->query($sqlTkPertamaEcourt);
            $rowTkPertamaEcourt = $resultTkPertamaEcourt->fetch_assoc();
            $totalPerkaraEcourt = $rowTkPertamaEcourt ? $rowTkPertamaEcourt['total_perkara'] : 0;

            // Total perkara tingkat pertama per triwulan (tanpa banding) mengikuti logika total
            $sqlTkPertama = "SELECT COUNT(*) AS total_perkara FROM perkara WHERE alur_perkara_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32) 
                AND YEAR(tanggal_pendaftaran)='$year' AND MONTH(tanggal_pendaftaran) IN ($bulanIn);";
            $resultTkPertama = $this->conn->query($sqlTkPertama);
            $rowTkPertama = $resultTkPertama->fetch_assoc();
            $totalPerkara = $rowTkPertama ? $rowTkPertama['total_perkara'] : 0;

            // Persentase mengikuti perhitungan di function total
            $persentase = ($totalPerkaraEcourt == 0) ? 0 : ($totalPerkaraEcourt / $totalPerkara * 100);

            $resultArray[$triwulan] = [
                'jlhPerkaraEcourt' => $totalPerkaraEcourt,
                'jlhPerkara' => $totalPerkara,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }
}
