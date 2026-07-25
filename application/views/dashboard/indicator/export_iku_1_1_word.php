<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * View Template Export Word untuk IKU 1.1 (Penyelesaian Perkara Tepat Waktu)
 * MSOffice Compatible HTML Document
 */

// Mapping label periode
$periodeLabels = [
    'tahunan' => 'Tahunan (1 Tahun)',
    't1' => 'Triwulan 1 (Januari - Maret)',
    't2' => 'Triwulan 2 (April - Juni)',
    't3' => 'Triwulan 3 (Juli - September)',
    't4' => 'Triwulan 4 (Oktober - Desember)',
];
$periodeText = isset($periodeLabels[$selectedPeriode]) ? $periodeLabels[$selectedPeriode] : 'Tahunan (1 Tahun)';

// Mapping label jenis
$jenisLabels = [
    'semua' => 'Semua Perkara (Pidana & Perdata)',
    'pidana' => 'Pidana',
    'perdata' => 'Perdata',
];
$jenisText = isset($jenisLabels[$selectedJenis]) ? $jenisLabels[$selectedJenis] : 'Semua Perkara';
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="utf-8">
    <title>Laporan Capaian IKU 1.1</title>
    <!--[if gte mso 9]>
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>100</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
    <![endif]-->
    <style>
        @page {
            size: A4 portrait;
            margin: 2cm 2cm 2cm 2cm;
            mso-header-margin: 1cm;
            mso-footer-margin: 1cm;
        }
        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            font-size: 11pt;
            color: #1e293b;
            line-height: 1.4;
        }
        .header-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
            color: #0f172a;
        }
        .header-subtitle {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            color: #334155;
            margin-bottom: 4px;
        }
        .header-app {
            text-align: center;
            font-size: 10pt;
            color: #64748b;
            margin-bottom: 20px;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .meta-table td {
            padding: 4px 8px;
            font-size: 10.5pt;
            vertical-align: top;
        }
        .meta-label {
            font-weight: bold;
            width: 160px;
            color: #475569;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .stats-table th, .stats-table td {
            border: 1px solid #cbd5e1;
            padding: 10px;
            text-align: center;
            font-size: 10.5pt;
        }
        .stats-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #0f172a;
        }
        .stats-value {
            font-size: 14pt;
            font-weight: bold;
            color: #0f172a;
        }
        .section-heading {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            margin-top: 15px;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th, .data-table td {
            border: 1px solid #94a3b8;
            padding: 7px 9px;
            font-size: 9.5pt;
            vertical-align: middle;
        }
        .data-table th {
            background-color: #e2e8f0;
            font-weight: bold;
            color: #0f172a;
            text-align: center;
        }
        .data-table td.center {
            text-align: center;
        }
        .badge-tepat {
            color: #166534;
            font-weight: bold;
        }
        .badge-terlambat {
            color: #991b1b;
            font-weight: bold;
        }
        .footer-sign {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .footer-sign td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10.5pt;
        }
        .sign-space {
            height: 75px;
        }
    </style>
</head>
<body>

    <!-- Header Laporan -->
    <div class="header-title">LAPORAN CAPAIAN INDIKATOR KINERJA UTAMA (IKU 1.1)</div>
    <div class="header-subtitle">PENYELESAIAN PERKARA SECARA TEPAT WAKTU</div>
    <div class="header-app">e-Capaian &mdash; Sistem Rekapitulasi Data Capaian Target Indikator Kinerja Utama</div>

    <!-- Parameter Filter Laporan -->
    <table class="meta-table">
        <tr>
            <td class="meta-label">Jenis Perkara</td>
            <td width="10">:</td>
            <td><strong><?= html_escape($jenisText) ?></strong></td>
            <td class="meta-label">Tanggal Cetak</td>
            <td width="10">:</td>
            <td><?= date('d F Y H:i') ?> WIB</td>
        </tr>
        <tr>
            <td class="meta-label">Periode Data</td>
            <td>:</td>
            <td><strong><?= html_escape($periodeText) ?></strong></td>
            <td class="meta-label">Penanggung Jawab</td>
            <td>:</td>
            <td>Panitera</td>
        </tr>
    </table>

    <!-- Ringkasan Statistik Capaian -->
    <div class="section-heading">I. RINGKASAN CAPAIAN KINERJA</div>
    <table class="stats-table">
        <thead>
            <tr>
                <th>Total Perkara Terfilter</th>
                <th>Selesai Tepat Waktu</th>
                <th>Tidak Tepat Waktu (Terlambat)</th>
                <th>Persentase Capaian (%)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="stats-value"><?= $totalCount ?> Perkara</td>
                <td class="stats-value" style="color:#15803d;"><?= $tepatWaktuCount ?> Perkara</td>
                <td class="stats-value" style="color:#b91c1c;"><?= $terlambatCount ?> Perkara</td>
                <td class="stats-value" style="color:#0284c7;"><?= number_format($persentaseTepatWaktu, 2, ',', '.') ?>%</td>
            </tr>
        </tbody>
    </table>

    <!-- Data Terinci Perkara -->
    <div class="section-heading">II. DAFTAR RINCIAN PERKARA</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nomor Perkara</th>
                <th>Jenis Perkara</th>
                <th>Klasifikasi / Perihal</th>
                <th>Tgl Registrasi</th>
                <th>Tgl Putusan</th>
                <th>Tgl Minutasi</th>
                <th>Durasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cases)): ?>
                <?php $no = 1; foreach ($cases as $case): ?>
                    <tr>
                        <td class="center"><?= $no++ ?></td>
                        <td><strong><?= html_escape($case->getNomorPerkara()) ?></strong></td>
                        <td class="center"><?= html_escape($case->getJenisPerkara()) ?></td>
                        <td><?= html_escape($case->getKlasifikasi()) ?></td>
                        <td class="center"><?= date('d/m/Y', strtotime($case->getTanggalRegistrasi())) ?></td>
                        <td class="center"><?= date('d/m/Y', strtotime($case->getTanggalPutusan())) ?></td>
                        <td class="center"><?= date('d/m/Y', strtotime($case->getTanggalMinutasi())) ?></td>
                        <td class="center"><?= $case->getDurasiHari() ?> Hari</td>
                        <td class="center">
                            <?php if ($case->getStatus() === 'Tepat Waktu'): ?>
                                <span class="badge-tepat">Tepat Waktu</span>
                            <?php else: ?>
                                <span class="badge-terlambat">Terlambat</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="center"><em>Tidak ada data perkara untuk filter yang dipilih.</em></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tanda Tangan / Lembar Pengesahan -->
    <table class="footer-sign">
        <tr>
            <td></td>
            <td>
                Mengetahui / Mengesahkan,<br>
                <strong>Panitera Pengadilan</strong>
                <div class="sign-space"></div>
                <strong><u>________________________</u></strong><br>
                NIP. ........................................
            </td>
        </tr>
    </table>

</body>
</html>
