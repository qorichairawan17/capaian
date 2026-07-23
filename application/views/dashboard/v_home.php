<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Beranda</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">e-Capaian</a></li>
                    <li class="breadcrumb-item active">Beranda</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- start welcome card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card welcome-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h2 class="fw-bold mb-1">Selamat Datang, <?= html_escape($this->session->userdata('name') ?: 'User') ?>!</h2>
                        <p class="mb-0">E-Capaian • Sistem Rekapitulasi Data Capaian Target Kinerja Utama</p>
                    </div>
                    <div>
                        <span class="badge welcome-badge px-3 py-2 rounded-3 fs-12">
                            <i class="far fa-calendar-alt me-2"></i><?= date('d M Y') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end welcome card -->

<div class="row g-4 mb-5">
    <!-- Card 1.1 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('indicator/iku_1_1'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.1</span>
                    <div class="icon-container">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Penyelesaian perkara secara tepat waktu</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.2 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('indicator/iku_1_2'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.2</span>
                    <div class="icon-container">
                        <i class="fas fa-file-export"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Penyediaan/pengiriman salinan putusan tepat waktu oleh pengadilan tingkat pertama kepada para pihak</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.3 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('indicator/iku_1_3'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.3</span>
                    <div class="icon-container">
                        <i class="fas fa-upload"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Persentase putusan pengadilan yang diunggah pada direktori putusan</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.4 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('indicator/iku_1_4'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.4</span>
                    <div class="icon-container">
                        <i class="fas fa-gavel"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Persentase perkara perdata pada tingkat banding yang menggunakan e-Court</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.5 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('dashboard/indicator/1_5'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.5</span>
                    <div class="icon-container">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Putusan pengadilan yang diunggah pada direktori putusan</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.6 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('dashboard/indicator/1_6'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.6</span>
                    <div class="icon-container">
                        <i class="fas fa-gavel"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Penyelesaian permohonan eksekusi putusan perdata</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.7 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('dashboard/indicator/1_7'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.7</span>
                    <div class="icon-container">
                        <i class="fas fa-handshake"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Perkara yang berhasil diselesaikan melalui pendekatan keadilan restorative</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.8 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('dashboard/indicator/1_8'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.8</span>
                    <div class="icon-container">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Perkara yang berhasil diselesaikan melalui mediasi</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.9 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('dashboard/indicator/1_9'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.9</span>
                    <div class="icon-container">
                        <i class="fas fa-child"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Perkara anak yang berhasil diselesaikan melalui diversi</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.10 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('dashboard/indicator/1_10'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.10</span>
                    <div class="icon-container">
                        <i class="fas fa-laptop"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Perkara perdata tingkat pertama yang menggunakan e-Court</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.11 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('dashboard/indicator/1_11'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.11</span>
                    <div class="icon-container">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Perkara pidana yang dilimpahkan secara elektronik (e-Berpadu)</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Card 1.12 -->
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo site_url('dashboard/indicator/1_12'); ?>" class="indicator-menu-card">
            <div class="card-body">
                <div class="indicator-header">
                    <span class="code-badge">IKU 1.12</span>
                    <div class="icon-container">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
                <h5 class="indicator-title">Layanan perkara pidana yang diajukan secara elektronik (e-Berpadu)</h5>
                <div class="indicator-footer">
                    <span>Lihat Rincian</span>
                    <i class="fas fa-arrow-right arrow-icon"></i>
                </div>
            </div>
        </a>
    </div>
</div>