<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Futuristic Home CSS -->
<link href="<?php echo base_url('assets/css/custom-home.css?v=' . time()); ?>" rel="stylesheet" type="text/css" />

<!-- Floating particles background -->
<div class="home-particles">
    <span></span><span></span><span></span><span></span>
    <span></span><span></span><span></span><span></span>
</div>

<div class="home-page-wrapper">

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

    <!-- ===== Hero Welcome Card ===== -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="home-hero">
                <div class="home-hero-grid"></div>
                <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
                    <div class="home-hero-content">
                        <div class="home-hero-greeting">
                            <span class="pulse-dot"></span>
                            Sistem Aktif
                        </div>
                        <h2 class="home-hero-name">
                            Selamat Datang, <span class="text-gradient"><?= html_escape($this->session->userdata('name') ?: 'User') ?></span>
                        </h2>
                        <p class="home-hero-sub">
                            E-Capaian &mdash; Sistem Rekapitulasi Data Capaian Target Indikator Kinerja Utama
                        </p>
                    </div>
                    <div class="home-hero-meta">
                        <div class="home-hero-badge">
                            <i class="far fa-calendar-alt"></i>
                            <?= date('l, d F Y') ?>
                        </div>
                        <div class="home-hero-badge">
                            <i class="far fa-clock"></i>
                            <span id="home-live-clock"><?= date('H:i:s') ?></span>
                        </div>
                    </div>
                </div>
                <!-- Quick stats -->
                <div class="home-stats-strip">
                    <div class="home-stat-item">
                        <div class="home-stat-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <div>
                            <div class="home-stat-value">12</div>
                            <div class="home-stat-label">Total Indikator</div>
                        </div>
                    </div>
                    <div class="home-stat-item">
                        <div class="home-stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="home-stat-value">Q<?= ceil(date('n') / 3) ?></div>
                            <div class="home-stat-label">Triwulan Aktif</div>
                        </div>
                    </div>
                    <div class="home-stat-item">
                        <div class="home-stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="home-stat-value"><?= date('Y') ?></div>
                            <div class="home-stat-label">Tahun Anggaran</div>
                        </div>
                    </div>
                    <div class="home-stat-item">
                        <div class="home-stat-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <div class="home-stat-value">Aktif</div>
                            <div class="home-stat-label">Status Sistem</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Section Header ===== -->
    <div class="home-section-header">
        <div class="home-section-icon">
            <i class="fas fa-th-large"></i>
        </div>
        <div>
            <h3 class="home-section-title">Indikator Kinerja Utama</h3>
            <span class="home-section-subtitle">Pilih indikator untuk melihat rincian capaian</span>
        </div>
        <span class="home-section-count">12 IKU</span>
    </div>

    <!-- ===== Indicator Cards Grid ===== -->
    <?php
    $indicators = [
        [
            'code'  => 'IKU 1.1',
            'url'   => site_url('indicator/iku_1_1'),
            'icon'  => 'fas fa-hourglass-half',
            'title' => 'Penyelesaian perkara secara tepat waktu',
        ],
        [
            'code'  => 'IKU 1.2',
            'url'   => site_url('indicator/iku_1_2'),
            'icon'  => 'fas fa-file-export',
            'title' => 'Persentase penyediaan/pengiriman salinan putusan tepat waktu oleh pengadilan tingkat pertama kepada para pihak',
        ],
        [
            'code'  => 'IKU 1.3',
            'url'   => site_url('indicator/iku_1_3'),
            'icon'  => 'fas fa-paper-plane',
            'title' => 'Persentase pengiriman pemberitahuan petikan/amar putusan tingkat banding, kasasi dan PK secara tepat waktu oleh pengadilan pengaju kepada para pihak',
        ],
        [
            'code'  => 'IKU 1.4',
            'url'   => site_url('indicator/iku_1_4'),
            'icon'  => 'fas fa-file-export',
            'title' => 'Persentase pengiriman salinan putusan perkara pidana tingkat banding, kasasi dan PK tepat waktu oleh pengadilan pengaju kepada para pihak',
        ],
        [
            'code'  => 'IKU 1.5',
            'url'   => site_url('indicator/iku_1_5'),
            'icon'  => 'fas fa-upload',
            'title' => 'Persentase putusan pengadilan yang diunggah pada direktori putusan',
        ],
        [
            'code'  => 'IKU 1.6',
            'url'   => site_url('indicator/iku_1_6'),
            'icon'  => 'fas fa-gavel',
            'title' => 'Persentase penyelesaian permohonan eksekusi putusan perdata',
        ],
        [
            'code'  => 'IKU 1.7',
            'url'   => site_url('indicator/iku_1_7'),
            'icon'  => 'fas fa-handshake',
            'title' => 'Perkara yang berhasil diselesaikan melalui pendekatan keadilan restorative',
        ],
        [
            'code'  => 'IKU 1.8',
            'url'   => site_url('indicator/iku_1_8'),
            'icon'  => 'fas fa-users',
            'title' => 'Perkara yang berhasil diselesaikan melalui mediasi',
        ],
        [
            'code'  => 'IKU 1.9',
            'url'   => site_url('indicator/iku_1_9'),
            'icon'  => 'fas fa-child',
            'title' => 'Perkara anak yang berhasil diselesaikan melalui diversi',
        ],
        [
            'code'  => 'IKU 1.10',
            'url'   => site_url('dashboard/indicator/1_10'),
            'icon'  => 'fas fa-laptop',
            'title' => 'Perkara perdata tingkat pertama yang menggunakan e-Court',
        ],
        [
            'code'  => 'IKU 1.11',
            'url'   => site_url('dashboard/indicator/1_11'),
            'icon'  => 'fas fa-exchange-alt',
            'title' => 'Perkara pidana yang dilimpahkan secara elektronik (e-Berpadu)',
        ],
        [
            'code'  => 'IKU 1.12',
            'url'   => site_url('dashboard/indicator/1_12'),
            'icon'  => 'fas fa-user-shield',
            'title' => 'Layanan perkara pidana yang diajukan secara elektronik (e-Berpadu)',
        ],
    ];
    ?>

    <div class="home-grid mb-5">
        <?php foreach ($indicators as $i => $ind): ?>
        <a href="<?= $ind['url'] ?>" class="home-indicator-card" data-delay="<?= $i + 1 ?>">
            <div class="home-card-accent"></div>
            <div class="home-card-body">
                <div class="home-card-header">
                    <span class="home-code-badge">
                        <i class="fas fa-circle" style="font-size:5px;vertical-align:middle;color:var(--home-primary)"></i>
                        <?= $ind['code'] ?>
                    </span>
                    <div class="home-card-icon">
                        <i class="<?= $ind['icon'] ?>"></i>
                    </div>
                </div>
                <h5 class="home-card-title"><?= $ind['title'] ?></h5>
                <div class="home-card-footer">
                    <span class="home-card-action">
                        Lihat Rincian
                        <span class="arrow-circle"><i class="fas fa-arrow-right"></i></span>
                    </span>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Footer -->
    <div class="home-footer-note">
        &copy; <?= date('Y') ?> <span>e-Capaian</span> &mdash; Sistem Rekapitulasi Data Capaian Kinerja
    </div>

</div><!-- /.home-page-wrapper -->

<!-- Live Clock Script -->
<script>
(function() {
    var clockEl = document.getElementById('home-live-clock');
    if (!clockEl) return;
    function updateClock() {
        var now = new Date();
        var h = String(now.getHours()).padStart(2, '0');
        var m = String(now.getMinutes()).padStart(2, '0');
        var s = String(now.getSeconds()).padStart(2, '0');
        clockEl.textContent = h + ':' + m + ':' + s;
    }
    setInterval(updateClock, 1000);
})();
</script>