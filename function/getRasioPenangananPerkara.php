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
        FROM perkara AS A LEFT JOIN perkara_putusan AS B ON A.perkara_id=B.perkara_id WHERE A.alur_perkara_id <> 114) AS C;";
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
}
