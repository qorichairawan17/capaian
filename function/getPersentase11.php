<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

class GetPersentase11
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function listPerkara($year, $minYear = null)
    {
        if ($minYear === null) {
            $minYear = $year;
        }
        $perkaraTepatWaktu = "SELECT 
                        a.nomor_perkara, 
                        a.tanggal_pendaftaran, 
                        b.tanggal_minutasi,
                        c.agenda,
                        DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) AS jumlah_hari
                    FROM perkara a 
                    LEFT JOIN perkara_putusan b 
                        ON b.perkara_id = a.perkara_id
                    LEFT JOIN perkara_jadwal_sidang c
                        ON c.perkara_id = a.perkara_id 
                    WHERE 
                        YEAR(a.tanggal_pendaftaran) = '$minYear' 
                        AND b.tanggal_minutasi IS NOT NULL 
                        AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150
                        AND YEAR(b.tanggal_minutasi) = '$year'
                        AND c.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar)'
                        GROUP BY a.nomor_perkara";
        $queryPerkaraTepatWaktu = $this->conn->query($perkaraTepatWaktu);
        $resultPerkaraTepatWaktu = [];
        if ($queryPerkaraTepatWaktu) {
            while ($row = $queryPerkaraTepatWaktu->fetch_assoc()) {
                $resultPerkaraTepatWaktu[] = $row;
            }
        }

        $perkaraTidakTepatWaktu = "SELECT 
                        a.nomor_perkara, 
                        a.tanggal_pendaftaran, 
                        b.tanggal_minutasi,
                        c.agenda,
                        DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) AS jumlah_hari
                    FROM perkara a 
                    LEFT JOIN perkara_putusan b 
                        ON b.perkara_id = a.perkara_id 
                    LEFT JOIN perkara_jadwal_sidang c
                        ON c.perkara_id = a.perkara_id
                    WHERE 
                        YEAR(a.tanggal_pendaftaran) = '$minYear' 
                        AND b.tanggal_minutasi IS NOT NULL 
                        AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) > 150
                        AND YEAR(b.tanggal_minutasi) = '$year'
                        AND c.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar)'
                        GROUP BY a.nomor_perkara";
        $queryPerkaraTidakTepatWaktu = $this->conn->query($perkaraTidakTepatWaktu);
        $resultPerkaraTidakTepatWaktu = [];
        if ($queryPerkaraTidakTepatWaktu) {
            while ($row = $queryPerkaraTidakTepatWaktu->fetch_assoc()) {
                $resultPerkaraTidakTepatWaktu[] = $row;
            }
        }
        return [
            'perkaraTidakTepatWaktu' => $resultPerkaraTidakTepatWaktu,
            'perkaraTepatWaktu' => $resultPerkaraTepatWaktu
        ];
    }

    public function showListPerkara($year)
    {
        $minYear = $year - 1;
        $perkaraTahunBerjalan = $this->listPerkara($year);
        $perkaraTahunBelakang = $this->listPerkara($year, $minYear);
        return [
            'perkaraTahunBerjalan' => $perkaraTahunBerjalan,
            'perkaraTahunBelakang' => $perkaraTahunBelakang
        ];
    }

    public function total($year, $minYear = null)
    {
        if ($minYear === null) {
            $minYear = $year;
        }
        // Rumus Indikator (Jumlah Perkara Diselesaikan Tepat Waktu / Jumlah Perkara Diselesaikan ) * 100%
        $jlhPerkaraSelesaiTepatWaktu = "SELECT COUNT(DISTINCT a.perkara_id) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id
                                        LEFT JOIN perkara_jadwal_sidang c ON c.perkara_id = a.perkara_id 
                                        WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND YEAR(b.tanggal_minutasi) = $year 
                                        AND b.tanggal_minutasi IS NOT NULL AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150
                                        AND c.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar)'";
        $result = $this->conn->query($jlhPerkaraSelesaiTepatWaktu);
        $data = $result->fetch_row();

        $jlhPerkaraSelesai = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL;";
        $result2 = $this->conn->query($jlhPerkaraSelesai);
        $data2 = $result2->fetch_row();

        return $result = [
            'jlhPerkaraSelesaiTepatWaktu' => $data[0],
            'jlhPerkaraSelesai' => $data2[0],
            'persentase' => ($data2[0] == 0) ? 0 : ($data[0] / $data2[0] * 100)
        ];
    }

    public function showTotal($year)
    {
        $minYear = $year - 1;
        $totalTahunBerjalan = $this->total($year);
        $totalTahunBelakang = $this->total($year, $minYear);
        return [
            'totalTahunBerjalan' => $totalTahunBerjalan,
            'totalTahunBelakang' => $totalTahunBelakang
        ];
    }

    public function jenisPerkara($year, $minYear = null)
    {
        if ($minYear === null) {
            $minYear = $year;
        }
        // Untuk mencari perkara yang diputus berdasarkan jenis perkara
        $totalJenisPerkara = "SELECT 
            COUNT(DISTINCT perkara_putusan.perkara_id) AS total_jenis_perkara, 
            perkara.jenis_perkara_nama, 
            perkara.jenis_perkara_text
            FROM perkara 
            LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id
            LEFT JOIN perkara_jadwal_sidang ON perkara.perkara_id = perkara_jadwal_sidang.perkara_id
            WHERE YEAR(perkara.tanggal_pendaftaran) = '$minYear'
              AND YEAR(perkara_putusan.tanggal_putusan) = '$year'
              AND perkara_putusan.tanggal_putusan IS NOT NULL
              AND perkara_jadwal_sidang.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar)'
            GROUP BY perkara.jenis_perkara_nama, perkara.jenis_perkara_text ORDER BY total_jenis_perkara DESC LIMIT 20;";
        $queryJenisPerkara = $this->conn->query($totalJenisPerkara);
        $resultJenisPerkara = [];
        if ($queryJenisPerkara) {
            while ($row = $queryJenisPerkara->fetch_assoc()) {
                $resultJenisPerkara[] = $row;
            }
        }

        return $resultJenisPerkara;
    }

    public function showJenisPerkara($year)
    {
        $minYear = $year - 1;
        $jenisPerkaraTahunBerjalan = $this->jenisPerkara($year);
        $jenisPerkaraTahunBelakang = $this->jenisPerkara($year, $minYear);
        return [
            'jenisPerkaraTahunBerjalan' => $jenisPerkaraTahunBerjalan,
            'jenisPerkaraTahunBelakang' => $jenisPerkaraTahunBelakang
        ];
    }

    public function perbulan($year = null, $minYear = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        if ($minYear === null) {
            $minYear = $year;
        }
        $resultArray = [];
        for ($month = 1; $month <= 12; $month++) {
            $sqlTepatWaktu = "SELECT COUNT(DISTINCT a.perkara_id) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id
                              LEFT JOIN perkara_jadwal_sidang c ON c.perkara_id = a.perkara_id
                              WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND MONTH(b.tanggal_minutasi) = $month 
                              AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL 
                              AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150
                              AND c.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar)'";
            $result = $this->conn->query($sqlTepatWaktu);
            $data = $result->fetch_row();
            $tepatWaktu = $data[0];

            $sqlSelesai = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND MONTH(b.tanggal_minutasi) = $month AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL;";
            $result2 = $this->conn->query($sqlSelesai);
            $data2 = $result2->fetch_row();
            $selesai = $data2[0];

            $persentase = ($selesai == 0) ? 0 : ($tepatWaktu / $selesai * 100);

            $resultArray[$month] = [
                'jlhPerkaraSelesaiTepatWaktu' => $tepatWaktu,
                'jlhPerkaraSelesai' => $selesai,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }

    public function pertriwulan($year = null, $minYear = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        if ($minYear === null) {
            $minYear = $year;
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
            $sqlTepatWaktu = "SELECT COUNT(DISTINCT a.perkara_id) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id 
                              LEFT JOIN perkara_jadwal_sidang c ON c.perkara_id = a.perkara_id
                              WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND MONTH(b.tanggal_minutasi) IN ($bulanIn) 
                              AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL 
                              AND DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150
                              AND c.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar)'";
            $result = $this->conn->query($sqlTepatWaktu);
            $data = $result->fetch_row();
            $tepatWaktu = $data[0];

            $sqlSelesai = "SELECT COUNT(*) AS total FROM perkara a LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id WHERE YEAR(a.tanggal_pendaftaran) = $minYear AND MONTH(b.tanggal_minutasi) IN ($bulanIn) AND YEAR(b.tanggal_minutasi) = $year AND b.tanggal_minutasi IS NOT NULL;";
            $result2 = $this->conn->query($sqlSelesai);
            $data2 = $result2->fetch_row();
            $selesai = $data2[0];

            $persentase = ($selesai == 0) ? 0 : ($tepatWaktu / $selesai * 100);

            $resultArray[$triwulan] = [
                'jlhPerkaraSelesaiTepatWaktu' => $tepatWaktu,
                'jlhPerkaraSelesai' => $selesai,
                'persentase' => $persentase
            ];
        }
        return $resultArray;
    }

    public function showPerbulan($year)
    {
        $minYear = $year - 1;
        $perbulanTahunBerjalan = $this->perbulan($year);
        $perbulanTahunBelakang = $this->perbulan($year, $minYear);
        return [
            'perbulanTahunBerjalan' => $perbulanTahunBerjalan,
            'perbulanTahunBelakang' => $perbulanTahunBelakang
        ];
    }

    public function showPertriwulan($year)
    {
        $minYear = $year - 1;
        $pertriwulanTahunBerjalan = $this->pertriwulan($year);
        $pertriwulanTahunBelakang = $this->pertriwulan($year, $minYear);
        return [
            'pertriwulanTahunBerjalan' => $pertriwulanTahunBerjalan,
            'pertriwulanTahunBelakang' => $pertriwulanTahunBelakang
        ];
    }

    public function exportToExcel($year, $type = 'berjalan', $status = 'all')
    {
        $phpExcel = new PHPExcel();
        $phpExcel->getProperties()
            ->setCreator("Perencanaan TI dan Pelaporan")
            ->setTitle("Export Data Perkara Tahun " . $year)
            ->setSubject("Data Perkara")
            ->setDescription("File Excel di-generate oleh PHPExcel");

        // Ambil data dari listPerkara
        $dataListPerkara = $this->showListPerkara($year);

        // Tentukan data berdasarkan type dan status
        if ($type == 'berjalan') {
            $perkaraTepatWaktu = $dataListPerkara['perkaraTahunBerjalan']['perkaraTepatWaktu'];
            $perkaraTidakTepatWaktu = $dataListPerkara['perkaraTahunBerjalan']['perkaraTidakTepatWaktu'];
            $titleYear = "Tahun Berjalan ($year)";
        } else {
            $perkaraTepatWaktu = $dataListPerkara['perkaraTahunBelakang']['perkaraTepatWaktu'];
            $perkaraTidakTepatWaktu = $dataListPerkara['perkaraTahunBelakang']['perkaraTidakTepatWaktu'];
            $yearBefore = $year - 1;
            $titleYear = "Tahun Lalu ($yearBefore) yang Selesai di $year";
        }

        // Gabungkan data berdasarkan status yang diminta
        $allData = [];
        if ($status == 'tepat_waktu' || $status == 'all') {
            $allData = array_merge($allData, $perkaraTepatWaktu);
        }
        if ($status == 'tidak_tepat_waktu' || $status == 'all') {
            $allData = array_merge($allData, $perkaraTidakTepatWaktu);
        }

        // Setup sheet
        $sheet = $phpExcel->setActiveSheetIndex(0);
        $sheet->setTitle('Data Perkara');

        // Header styling
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => '4472C4']
            ],
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ]
        ];

        // Title
        $sheet->setCellValue('A1', 'LAPORAN DATA PERKARA PERSENTASE PENYELESAIAN PERKARA TEPAT WAKTU');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER]
        ]);

        $sheet->setCellValue('A2', $titleYear);
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER]
        ]);

        if ($status == 'tepat_waktu') {
            $statusText = 'Perkara Tepat Waktu (≤150 hari)';
        } elseif ($status == 'tidak_tepat_waktu') {
            $statusText = 'Perkara Tidak Tepat Waktu (>150 hari)';
        } else {
            $statusText = 'Semua Perkara';
        }
        $sheet->setCellValue('A3', $statusText);
        $sheet->mergeCells('A3:E3');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER]
        ]);

        // Headers
        $headers = ['No', 'Nomor Perkara', 'Tanggal Pendaftaran', 'Tanggal Minutasi', 'Jumlah Hari'];
        $colIndex = 0;
        foreach ($headers as $h) {
            $cell = PHPExcel_Cell::stringFromColumnIndex($colIndex) . '4';
            $sheet->setCellValue($cell, $h);
            $colIndex++;
        }
        $sheet->getStyle('A4:E4')->applyFromArray($headerStyle);

        // Data rows
        $row = 5;
        $no = 1;
        foreach ($allData as $perkara) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $perkara['nomor_perkara']);
            $sheet->setCellValue('C' . $row, date('d-m-Y', strtotime($perkara['tanggal_pendaftaran'])));
            $sheet->setCellValue('D' . $row, date('d-m-Y', strtotime($perkara['tanggal_minutasi'])));
            $sheet->setCellValue('E' . $row, $perkara['jumlah_hari'] . ' hari');

            // Color coding untuk jumlah hari
            if ($perkara['jumlah_hari'] <= 150) {
                $sheet->getStyle('E' . $row)->applyFromArray([
                    'fill' => [
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => ['rgb' => 'C6EFCE']
                    ],
                    'font' => ['color' => ['rgb' => '006100']]
                ]);
            } else {
                $sheet->getStyle('E' . $row)->applyFromArray([
                    'fill' => [
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => ['rgb' => 'FFC7CE']
                    ],
                    'font' => ['color' => ['rgb' => '9C0006']]
                ]);
            }

            $row++;
            $no++;
        }

        // Borders untuk semua data
        $lastRow = $row - 1;
        $sheet->getStyle('A4:E' . $lastRow)->applyFromArray([
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Auto size columns
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Summary
        $summaryRow = $row + 1;
        $sheet->setCellValue('A' . $summaryRow, 'Total Perkara:');
        $sheet->setCellValue('B' . $summaryRow, count($allData) . ' perkara');
        $sheet->getStyle('A' . $summaryRow . ':B' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true]
        ]);

        // Generate filename
        $statusFileName = $status == 'tepat_waktu' ? 'tepat_waktu' : ($status == 'tidak_tepat_waktu' ? 'tidak_tepat_waktu' : 'semua');
        $typeFileName = $type == 'berjalan' ? 'tahun_berjalan' : 'tahun_lalu';
        $filename = 'laporan_perkara_' . $typeFileName . '_' . $statusFileName . '_' . $year . '_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Pragma: public');

        $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }
}
