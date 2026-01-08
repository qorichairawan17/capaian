<?php
require_once __DIR__ . '/../config/database.php';

class getRasioPenangananPerkara
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getRasioPenangananPerkara($year)
    {
        /**
         * RUMUS RASIO PENANGANAN PERKARA:
         * Persentase Kinerja = (Jumlah Perkara Diminutasi / (Jumlah Perkara Masuk + Jumlah Sisa Perkara)) × 100%
         * Tunggakan = (Jumlah Perkara Masuk + Jumlah Sisa Perkara) - Jumlah Perkara Diminutasi
         * 
         * KOMPONEN QUERY:
         * 1. sisa      = Perkara yang terdaftar sebelum tahun terpilih (≤ tahun-1) dan belum diminutasi 
         *                atau diminutasi di tahun terpilih atau setelahnya
         * 2. masuk     = Perkara yang terdaftar pada tahun yang dipilih
         * 3. minutasi  = Perkara yang diminutasi pada tahun yang dipilih (dari perkara yang terdaftar ≤ tahun terpilih)
         * 4. kinerjaPN = Persentase rasio penanganan = (minutasi / (masuk + sisa)) × 100
         * 5. tunggakan = Total perkara yang belum diselesaikan = (masuk + sisa) - minutasi
         * 6. warnaPN   = Indikator warna berdasarkan persentase kinerja:
         *                - Merah (#red): kinerja < 50%
         *                - Hijau (green): kinerja > 90%
         *                - Kuning (#EFB019): kinerja antara 50% - 90%
         * 
         * CATATAN: Query mengecualikan alur_perkara_id = 114 (perkara khusus)
         */
        // $rasioPenangananPerkara = "SELECT C.masuk AS masuk, C.minutasi AS minutasi, C.sisa AS sisa,
        // (SELECT VALUE FROM sys_config WHERE id = 62) AS namaPN,
        // (SELECT VALUE FROM sys_config WHERE id = 80) AS versiSIPP,
        // (ROUND(SUM(C.minutasi)*100/(SUM(C.masuk)+SUM(C.sisa)),2)) AS kinerjaPN,
        // (ROUND(SUM(C.masuk)+SUM(C.sisa)-(SUM(C.minutasi)))) AS tunggakan,
        // (CASE WHEN (ROUND(SUM(C.minutasi)*100/(SUM(C.masuk)+SUM(C.sisa)),2)) < 50.00 THEN 'red' 
        //     WHEN (ROUND(SUM(C.minutasi)*100/(SUM(C.masuk)+SUM(C.sisa)),2)) > 90.00 THEN 'green' 
        //     ELSE '#EFB019' END) AS warnaPN
        // FROM (SELECT
        // SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<='$year'-1 AND (YEAR(B.tanggal_minutasi)>='$year' OR (B.tanggal_minutasi IS NULL OR B.tanggal_minutasi='')) THEN 1 ELSE 0 END) AS sisa,
        // SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)='$year' THEN 1 ELSE 0 END) AS masuk,
        // SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<='$year' AND YEAR(B.tanggal_minutasi)='$year' THEN 1 ELSE 0 END) AS minutasi
        // FROM perkara AS A LEFT JOIN perkara_putusan AS B ON A.perkara_id=B.perkara_id WHERE A.alur_perkara_id <> 114) AS C;";
        $rasioPenangananPerkara = "SELECT C.masuk AS masuk, C.minutasi AS minutasi, C.sisa AS sisa,
        (SELECT VALUE FROM sys_config WHERE id = 62) AS namaPN,
        (SELECT VALUE FROM sys_config WHERE id = 80) AS versiSIPP,
        (ROUND(SUM(C.minutasi)*100/(SUM(C.masuk)+SUM(C.sisa)),2)) AS kinerjaPN,
        (ROUND(SUM(C.masuk)+SUM(C.sisa)-(SUM(C.minutasi)))) AS tunggakan,
        (CASE WHEN (ROUND(SUM(C.minutasi)*100/(SUM(C.masuk)+SUM(C.sisa)),2)) < 50.00 THEN 'red' 
            WHEN (ROUND(SUM(C.minutasi)*100/(SUM(C.masuk)+SUM(C.sisa)),2)) > 90.00 THEN 'green' 
            ELSE '#EFB019' END) AS warnaPN
        FROM (SELECT
        SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<='$year'-1 AND (YEAR(B.tanggal_minutasi)>='$year' OR (B.tanggal_minutasi IS NULL OR B.tanggal_minutasi='')) THEN 1 ELSE 0 END) AS sisa,
        SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)='$year' THEN 1 ELSE 0 END) AS masuk,
        SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<='$year' AND YEAR(B.tanggal_minutasi)='$year' THEN 1 ELSE 0 END) AS minutasi
        FROM perkara AS A LEFT JOIN perkara_putusan AS B ON A.perkara_id=B.perkara_id) AS C;";
        $result = $this->conn->query($rasioPenangananPerkara);
        $row = $result->fetch_assoc();

        $masuk = $row ? $row['masuk'] : 0;
        $minutasi = $row ? $row['minutasi'] : 0;
        $sisa = $row ? $row['sisa'] : 0;
        $kinerjaPN = $row ? $row['kinerjaPN'] : 0;
        $tunggakan = $row ? $row['tunggakan'] : 0;

        return [
            'masuk' => $masuk,
            'minutasi' => $minutasi,
            'sisa' => $sisa,
            'kinerjaPN' => $kinerjaPN,
            'tunggakan' => $tunggakan,
            'persentase' => $kinerjaPN
        ];
    }

    /**
     * Mengambil daftar detail perkara tunggakan
     * Tunggakan = perkara yang masuk di tahun terpilih + sisa dari tahun sebelumnya yang belum diminutasi
     * 
     * @param int $year Tahun filter
     * @return array Daftar perkara tunggakan
     */
    public function getTunggakanPerkara($year)
    {
        // Query untuk mengambil perkara tunggakan:
        // 1. Perkara yang terdaftar pada tahun terpilih dan belum diminutasi
        // 2. Perkara sisa dari tahun sebelumnya (terdaftar <= tahun-1) yang belum diminutasi atau diminutasi di tahun >= terpilih
        $queryTunggakan = "SELECT 
            A.nomor_perkara,
            A.tanggal_pendaftaran,
            CASE 
                WHEN YEAR(A.tanggal_pendaftaran) <= '$year'-1 THEN 'Sisa Tahun Lalu'
                ELSE 'Perkara Masuk'
            END AS kategori,
            CASE 
                WHEN B.tanggal_minutasi IS NULL OR B.tanggal_minutasi = '' THEN 'Belum Diminutasi'
                ELSE 'Dalam Proses'
            END AS status_minutasi
        FROM perkara AS A 
        LEFT JOIN perkara_putusan AS B ON A.perkara_id = B.perkara_id
        WHERE 
            (
                -- Perkara masuk tahun ini yang belum diminutasi
                (YEAR(A.tanggal_pendaftaran) = '$year' AND (B.tanggal_minutasi IS NULL OR B.tanggal_minutasi = '' OR YEAR(B.tanggal_minutasi) > '$year'))
                OR
                -- Sisa perkara dari tahun lalu yang belum diminutasi atau diminutasi di tahun >= terpilih
                (YEAR(A.tanggal_pendaftaran) <= '$year'-1 AND (B.tanggal_minutasi IS NULL OR B.tanggal_minutasi = '' OR YEAR(B.tanggal_minutasi) >= '$year'))
            )
        ORDER BY A.tanggal_pendaftaran DESC";

        $result = $this->conn->query($queryTunggakan);

        $tunggakanList = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tunggakanList[] = [
                    'nomor_perkara' => $row['nomor_perkara'],
                    'tanggal_pendaftaran' => $row['tanggal_pendaftaran'],
                    'kategori' => $row['kategori'],
                    'status_minutasi' => $row['status_minutasi']
                ];
            }
        }

        return $tunggakanList;
    }
}
