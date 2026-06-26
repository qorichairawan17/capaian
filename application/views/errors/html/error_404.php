<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$base_url = config_item('base_url') ?: '/capaian/';
?><!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Halaman Tidak Ditemukan | e-Capaian</title>
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
    <div class="error-container">
        <div class="error-card error-warning">
            <div class="error-icon-wrapper warning-bg">
                <i class="mdi mdi-alert-circle-outline" style="font-size: 2.5rem; line-height: 1;"></i>
            </div>
            <h1 class="error-title"><?php echo $heading; ?></h1>
            <div class="error-desc">
                <?php echo $message; ?>
            </div>
            <div class="error-btn-wrapper">
                <a href="<?php echo $base_url; ?>" class="error-btn">
                    <i class="mdi mdi-home-outline me-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</body>

</html>