<?php
// File handler untuk export Excel Persentase 11
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/getPersentase11.php';

// Validasi parameter
if (!isset($_GET['tahun']) || !isset($_GET['type']) || !isset($_GET['status'])) {
    die('Parameter tidak lengkap. Mohon sertakan tahun, type, dan status.');
}

$tahun = (int)$_GET['tahun'];
$type = $_GET['type']; // 'berjalan' atau 'lalu'
$status = $_GET['status']; // 'all', 'tepat_waktu', atau 'tidak_tepat_waktu'

// Validasi input
if ($tahun < 2020 || $tahun > date('Y')) {
    die('Tahun tidak valid.');
}

if (!in_array($type, ['berjalan', 'lalu'])) {
    die('Type tidak valid. Gunakan "berjalan" atau "lalu".');
}

if (!in_array($status, ['all', 'tepat_waktu', 'tidak_tepat_waktu'])) {
    die('Status tidak valid. Gunakan "all", "tepat_waktu", atau "tidak_tepat_waktu".');
}

try {
    // Buat instance class dan export
    $persentase = new GetPersentase11();
    $persentase->exportToExcel($tahun, $type, $status);
} catch (Exception $e) {
    die('Error saat export: ' . $e->getMessage());
}
