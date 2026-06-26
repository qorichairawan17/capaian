<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$base_url = config_item('base_url') ?: '/capaian/';
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kesalahan Basis Data | e-Capaian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pembantu Rekapitulasi Data Capain Kinerja" name="description" />
    <meta content="Qori Chairawan" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/images/favicon.ico">
    <!-- Bootstrap CSS -->
    <link href="<?php echo $base_url; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS -->
    <link href="<?php echo $base_url; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom Error CSS -->
    <link href="<?php echo $base_url; ?>assets/css/custom-errors.css" rel="stylesheet" type="text/css" />
</head>
<body class="error-body">
    <div class="error-container" style="max-width: 700px;">
        <div class="error-card error-danger text-start">
            <div class="text-center">
                <div class="error-icon-wrapper danger-bg">
                    <i class="mdi mdi-database-off" style="font-size: 2.5rem; line-height: 1;"></i>
                </div>
                <h1 class="error-title"><?php echo $heading; ?></h1>
            </div>
            <div class="error-desc text-muted mt-3">
                <p>Terjadi kendala saat melakukan operasi database. Berikut detail kesalahan yang ditemui:</p>
            </div>
            <div class="error-code-box">
                <?php echo $message; ?>
            </div>
            <div class="error-btn-wrapper">
                <a href="<?php echo $base_url; ?>index.php/home" class="error-btn">
                    <i class="mdi mdi-home-outline me-2"></i> Kembali ke Dashboard
                </a>
                <button onclick="window.location.reload();" class="error-btn error-btn-outline">
                    <i class="mdi mdi-refresh me-2"></i> Coba Lagi
                </button>
            </div>
        </div>
    </div>
</body>
</html>