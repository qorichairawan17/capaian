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

        $PerkaraTepatDanTidakTepatWaktu = "SELECT 
                                a.nomor_perkara, 
                                a.tanggal_pendaftaran, 
                                b.tanggal_minutasi,
                                DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) AS jumlah_hari,
                                CASE
                                WHEN a.alur_perkara_id IN (1,2,3,4,5,6,7,32) THEN 'Perdata'
                                ELSE 'Pidana'
                                END AS jenis_perkara,
                                d.nama AS klasifikasi_perkara,
                                CASE
                                WHEN a.alur_perkara_id IN (1,3,4,5,6,7,32) THEN e.tgl_laporan_mediator
                                END AS tanggal_laporan_mediator,
                                CASE
                                WHEN a.alur_perkara_id IN (1,3,4,5,6,7,32) THEN DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran)
                                END AS jumlah_hari_dari_mediasi,
                                CASE
                                WHEN a.alur_perkara_id IN (1,3,4,5,6,7,32) THEN 
                                CASE
                                        WHEN DATEDIFF(b.tanggal_minutasi, e.tgl_laporan_mediator) <= 150 THEN 'Tepat Waktu'
                                            ELSE 'Tidak Tepat Waktu'
                                        END
                                    ELSE
                                    CASE
                                        WHEN DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 150 THEN 'Tepat Waktu'
                                            ELSE 'Tidak Tepat Waktu'
                                        END
                                END AS status_waktu,
                                CASE
                                    WHEN a.alur_perkara_id = 8 THEN
                                        CASE
                                            WHEN DATEDIFF(b.tanggal_minutasi, a.tanggal_pendaftaran) <= 25 THEN 'Tepat Waktu'
                                            ELSE 'Tidak Tepat Waktu'
                                        END
                                    ELSE NULL
                                END AS status_waktu_gs
                            FROM perkara a
                            LEFT JOIN perkara_putusan b ON b.perkara_id = a.perkara_id
                            LEFT JOIN (
                                SELECT perkara_id, agenda
                                FROM perkara_jadwal_sidang
                                ORDER BY tanggal_sidang DESC
                            ) c ON c.perkara_id = a.perkara_id
                            LEFT JOIN alur_perkara d ON d.id = a.alur_perkara_id
                            LEFT JOIN perkara_mediasi e ON a.perkara_id = e.perkara_id
                            WHERE 
                                YEAR(a.tanggal_pendaftaran) = '$minYear'
                                AND b.tanggal_minutasi IS NOT NULL
                                AND YEAR(b.tanggal_minutasi) = '$year'
                                AND c.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar|media massa|surat kabar)'
                                AND e.tgl_laporan_mediator IS NOT NULL
                            GROUP BY 
                                a.perkara_id
                            ORDER BY 
                                b.tanggal_minutasi ASC;
                            ";
        $queryPerkaraTepatDanTidakTepatWaktu = $this->conn->query($PerkaraTepatDanTidakTepatWaktu);
        $resultPerkaraTepatDanTidakTepatWaktu = [];
        if ($queryPerkaraTepatDanTidakTepatWaktu) {
            while ($row = $queryPerkaraTepatDanTidakTepatWaktu->fetch_assoc()) {
                $resultPerkaraTepatDanTidakTepatWaktu[] = $row;
            }
        }

        return [
            'PerkaraTepatDanTidakTepatWaktu' => $resultPerkaraTepatDanTidakTepatWaktu
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
                                        AND c.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar|media massa|surat kabar)'";
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
              AND perkara_jadwal_sidang.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar|media massa|surat kabar)'
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
                              AND c.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar|media massa|surat kabar)'";
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
                              AND c.agenda NOT REGEXP '(koran|media|panggilan umum|pgl umum|surat kabar|media massa|surat kabar)'";
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

        // Tentukan data berdasarkan type
        if ($type == 'berjalan') {
            $perkaraData = $dataListPerkara['perkaraTahunBerjalan']['PerkaraTepatDanTidakTepatWaktu'];
            $titleYear = "Tahun Berjalan ($year)";
        } else {
            $perkaraData = $dataListPerkara['perkaraTahunBelakang']['PerkaraTepatDanTidakTepatWaktu'];
            $yearBefore = $year - 1;
            $titleYear = "Tahun Lalu ($yearBefore) yang Selesai di $year";
        }

        // Filter data berdasarkan status yang diminta
        $allData = [];
        foreach ($perkaraData as $perkara) {
            if ($status == 'all') {
                $allData[] = $perkara;
            } elseif ($status == 'tepat_waktu' && $perkara['status_waktu'] == 'Tepat Waktu') {
                $allData[] = $perkara;
            } elseif ($status == 'tidak_tepat_waktu' && $perkara['status_waktu'] == 'Tidak Tepat Waktu') {
                $allData[] = $perkara;
            }
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
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER]
        ]);

        $sheet->setCellValue('A2', $titleYear);
        $sheet->mergeCells('A2:J2');
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
        $sheet->mergeCells('A3:J3');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER]
        ]);

        // Headers
        $headers = ['No', 'Nomor Perkara', 'Jenis Perkara', 'Klasifikasi Perkara', 'Tanggal Pendaftaran', 'Tanggal Laporan Mediator', 'Tanggal Minutasi', 'Jumlah Hari', 'Status Waktu', 'Status Gugatan Sederhana'];
        $colIndex = 0;
        foreach ($headers as $h) {
            $cell = PHPExcel_Cell::stringFromColumnIndex($colIndex) . '4';
            $sheet->setCellValue($cell, $h);
            $colIndex++;
        }
        $sheet->getStyle('A4:J4')->applyFromArray($headerStyle);

        // Data rows
        $row = 5;
        $no = 1;
        foreach ($allData as $perkara) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $perkara['nomor_perkara']);
            $sheet->setCellValue('C' . $row, $perkara['jenis_perkara']);
            $sheet->setCellValue('D' . $row, $perkara['klasifikasi_perkara']);
            $sheet->setCellValue('E' . $row, date('d-m-Y', strtotime($perkara['tanggal_pendaftaran'])));
            $sheet->setCellValue('F' . $row, !empty($perkara['tanggal_laporan_mediator']) ? date('d-m-Y', strtotime($perkara['tanggal_laporan_mediator'])) : '-');
            $sheet->setCellValue('G' . $row, date('d-m-Y', strtotime($perkara['tanggal_minutasi'])));
            $sheet->setCellValue('H' . $row, $perkara['jumlah_hari'] . ' hari');
            $sheet->setCellValue('I' . $row, $perkara['status_waktu']);

            // Status Gugatan Sederhana
            $statusGugatanSederhana = !empty($perkara['status_waktu_gs']) ? $perkara['status_waktu_gs'] : '-';
            $sheet->setCellValue('J' . $row, $statusGugatanSederhana);

            // Color coding untuk jumlah hari
            if ($perkara['jumlah_hari'] <= 150) {
                $sheet->getStyle('H' . $row)->applyFromArray([
                    'fill' => [
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => ['rgb' => 'C6EFCE']
                    ],
                    'font' => ['color' => ['rgb' => '006100']]
                ]);
            } else {
                $sheet->getStyle('H' . $row)->applyFromArray([
                    'fill' => [
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => ['rgb' => 'FFC7CE']
                    ],
                    'font' => ['color' => ['rgb' => '9C0006']]
                ]);
            }

            // Color coding untuk Status Waktu
            if ($perkara['status_waktu'] == 'Tepat Waktu') {
                $sheet->getStyle('I' . $row)->applyFromArray([
                    'fill' => [
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => ['rgb' => 'C6EFCE']
                    ],
                    'font' => ['color' => ['rgb' => '006100']]
                ]);
            } else {
                $sheet->getStyle('I' . $row)->applyFromArray([
                    'fill' => [
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => ['rgb' => 'FFC7CE']
                    ],
                    'font' => ['color' => ['rgb' => '9C0006']]
                ]);
            }

            // Color coding untuk Status Gugatan Sederhana
            if ($statusGugatanSederhana == 'Tepat Waktu') {
                $sheet->getStyle('J' . $row)->applyFromArray([
                    'fill' => [
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => ['rgb' => 'C6EFCE']
                    ],
                    'font' => ['color' => ['rgb' => '006100']]
                ]);
            } elseif ($statusGugatanSederhana == 'Tidak Tepat Waktu') {
                $sheet->getStyle('J' . $row)->applyFromArray([
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
        $sheet->getStyle('A4:J' . $lastRow)->applyFromArray([
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Auto size columns
        foreach (range('A', 'J') as $col) {
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
