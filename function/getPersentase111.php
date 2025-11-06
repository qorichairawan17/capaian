<?php
require_once __DIR__ . '/../config/database.php';

class GetPersentase111
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function total($year)
    {
        // Rumus Indikator (Jumlah perkara pidana yang dilimpahkan secara elektronik / Jumlah perkara pidana yang dilimpahkan ) * 100%

        // Cari total perkara pidana eberpadu
        $totalPerkaraEberpadu = "SELECT COUNT(berpadu_pelimpahan_register.`perkara_id`) AS total_perkara FROM berpadu_pelimpahan_register
                                        LEFT JOIN perkara ON berpadu_pelimpahan_register.perkara_id = perkara.perkara_id 
                                        LEFT JOIN alur_perkara ON perkara.alur_perkara_id = alur_perkara.id WHERE alur_perkara.id IN(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,129,130,131) AND YEAR(berpadu_pelimpahan_register.tanggal_pendaftaran)='$year'";
        $resultPerkaraEberpadu = $this->conn->query($totalPerkaraEberpadu);
        $rowPerkaraEberpadu = $resultPerkaraEberpadu->fetch_assoc();
        $data1 = $rowPerkaraEberpadu ? $rowPerkaraEberpadu['total_perkara'] : 0;

        // Cari total perkara pidana yang dilimpahkan
        $totalPelimpahanPerkara = "SELECT COUNT(*) AS total_perkara FROM perkara WHERE alur_perkara_id IN(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,129,130,131) AND YEAR(tanggal_pendaftaran)='$year'";
        $resultPelimpahanPerkara = $this->conn->query($totalPelimpahanPerkara);
        $rowPelimpahanPerkara = $resultPelimpahanPerkara->fetch_assoc();
        $data2 = $rowPelimpahanPerkara ? $rowPelimpahanPerkara['total_perkara'] : 0;


        return [
            'jlhPerkaraEberpadu' => $data1,
            'jlhPelimpahanPerkara' => $data2,
            'persentase' => ($data2 == 0) ? 0 : ($data1 / $data2 * 100)
        ];
    }

    public function perbulan($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            // Perkara pidana eberpadu per bulan
            $sqlPerkaraEberpadu = "SELECT COUNT(berpadu_pelimpahan_register.perkara_id) AS total_perkara FROM berpadu_pelimpahan_register
                LEFT JOIN perkara ON berpadu_pelimpahan_register.perkara_id = perkara.perkara_id 
                LEFT JOIN alur_perkara ON perkara.alur_perkara_id = alur_perkara.id 
                WHERE alur_perkara.id IN(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,129,130,131) AND YEAR(berpadu_pelimpahan_register.tanggal_pendaftaran)='$year' AND MONTH(berpadu_pelimpahan_register.tanggal_pendaftaran)='$month'";
            $resultPerkaraEberpadu = $this->conn->query($sqlPerkaraEberpadu);
            $rowPerkaraEberpadu = $resultPerkaraEberpadu->fetch_assoc();
            $data1 = $rowPerkaraEberpadu ? $rowPerkaraEberpadu['total_perkara'] : 0;

            // Total perkara pidana yang dilimpahkan per bulan
            $sqlPelimpahanPerkara = "SELECT COUNT(*) AS total_perkara FROM perkara WHERE alur_perkara_id IN(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,129,130,131) AND YEAR(tanggal_pendaftaran)='$year' AND MONTH(tanggal_pendaftaran)='$month'";
            $resultPelimpahanPerkara = $this->conn->query($sqlPelimpahanPerkara);
            $rowPelimpahanPerkara = $resultPelimpahanPerkara->fetch_assoc();
            $data2 = $rowPelimpahanPerkara ? $rowPelimpahanPerkara['total_perkara'] : 0;

            $persentase = ($data2 == 0) ? 0 : ($data1 / $data2 * 100);

            $resultArray[$month] = [
                'jlhPerkaraEberpadu' => $data1,
                'jlhPelimpahanPerkara' => $data2,
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
            // Perkara pidana eberpadu per triwulan
            $sqlPerkaraEberpadu = "SELECT COUNT(berpadu_pelimpahan_register.perkara_id) AS total_perkara FROM berpadu_pelimpahan_register
                LEFT JOIN perkara ON berpadu_pelimpahan_register.perkara_id = perkara.perkara_id 
                LEFT JOIN alur_perkara ON perkara.alur_perkara_id = alur_perkara.id 
                WHERE alur_perkara.id IN(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,129,130,131) AND YEAR(berpadu_pelimpahan_register.tanggal_pendaftaran)='$year' AND MONTH(berpadu_pelimpahan_register.tanggal_pendaftaran) IN ($bulanIn)";
            $resultPerkaraEberpadu = $this->conn->query($sqlPerkaraEberpadu);
            $rowPerkaraEberpadu = $resultPerkaraEberpadu->fetch_assoc();
            $data1 = $rowPerkaraEberpadu ? $rowPerkaraEberpadu['total_perkara'] : 0;

            // Total perkara pidana yang dilimpahkan per triwulan
            $sqlPelimpahanPerkara = "SELECT COUNT(*) AS total_perkara FROM perkara WHERE alur_perkara_id IN(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,129,130,131) AND YEAR(tanggal_pendaftaran)='$year' AND MONTH(tanggal_pendaftaran) IN ($bulanIn)";
            $resultPelimpahanPerkara = $this->conn->query($sqlPelimpahanPerkara);
            $rowPelimpahanPerkara = $resultPelimpahanPerkara->fetch_assoc();
            $data2 = $rowPelimpahanPerkara ? $rowPelimpahanPerkara['total_perkara'] : 0;

            $persentase = ($data2 == 0) ? 0 : ($data1 / $data2 * 100);

            $resultArray[$triwulan] = [
                'jlhPerkaraEberpadu' => $data1,
                'jlhPelimpahanPerkara' => $data2,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }
}
