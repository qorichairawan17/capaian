<?php
// Data menu cards
$menuCards = [
    [
        'icon' => 'bi-database',
        'title' => 'Rasio Penanganan Perkara',
        'text' => 'Monitoring rasio penanganan perkara secara keseluruhan',
        'href' => '?page=rasio_penanganan_perkara'
    ],
    [
        'icon' => 'bi-database-check',
        'title' => '1.1 Penyelesaian Perkara',
        'text' => 'Monitoring capaian persentase penyelesaian perkara tepat waktu',
        'href' => '?page=capaian_persentase_11'
    ],
    [
        'icon' => 'bi-database-check',
        'title' => '1.2 Pengiriman Salinan Putusan',
        'text' => 'Monitoring capaian persentase Pengiriman Salinan Putusan tepat waktu',
        'href' => '?page=capaian_persentase_12'
    ],
    [
        'icon' => 'bi-send-check',
        'title' => '1.3 Pemberitahuan Petikan/Amar Putusan Upaya Hukum',
        'text' => 'Monitoring capaian persentase Pemberitahuan Petikan/Amar Putusan tepat waktu',
        'href' => '?page=capaian_persentase_13'
    ],
    [
        'icon' => 'bi-send-check',
        'title' => '1.4 Pengiriman Salinan Putusan Upaya Hukum',
        'text' => 'Monitoring capaian persentase Pengiriman Salinan Putusan Upaya Hukum tepat waktu',
        'href' => '?page=capaian_persentase_14'
    ],
    [
        'icon' => 'bi-folder-check',
        'title' => '1.5 Putusan Pengadilan Pada Direktori',
        'text' => 'Monitoring capaian persentase Putusan Pengadilan Pada Direktori Putusan',
        'href' => '?page=capaian_persentase_15'
    ],
    [
        'icon' => 'bi-person-check',
        'title' => '1.10 Pendaftaran Perkara Pada Ecourt',
        'text' => 'Monitoring capaian persentase Pendaftaran Perkara Perdata Pada Ecourt',
        'href' => '?page=capaian_persentase_110'
    ],
    [
        'icon' => 'bi-person-lines-fill',
        'title' => '1.11 Pendaftaran Perkara Pada Eberpadu',
        'text' => 'Monitoring capaian persentase Pendaftaran Perkara Pidana Pada Eberpadu',
        'href' => '?page=capaian_persentase_111'
    ]
];
?>

<!-- Beranda - Daftar Menu -->
<div class="container py-4">
    <!-- Header -->
    <div class="text-center mb-5 animate-fade-in">
        <h2 class="section-title">
            Monitoring Capaian Penyelesaian Perkara
        </h2>
        <p class="text-muted">Pilih menu untuk melihat data capaian penyelesaian</p>
    </div>

    <!-- Menu Cards -->
    <div class="row g-4">
        <?php foreach ($menuCards as $index => $card): ?>
            <div class="col-lg-4 col-md-6 col-sm-12 animate-fade-in" style="animation-delay: <?= $index * 0.1 ?>s;">
                <div class="stat-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="stat-icon mx-auto mb-3">
                            <i class="bi <?= $card['icon'] ?>"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3"><?= $card['title'] ?></h5>
                        <p class="card-text text-muted mb-4">
                            <?= $card['text'] ?>
                        </p>
                        <a href="<?= $card['href'] ?>" class="btn btn-warning-custom w-100">
                            <i class="bi bi-arrow-right-circle"></i> Lihat Data
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Info Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="chart-container text-center">
                <h4 class="text-warning-dark mb-3">
                    <i class="bi bi-info-circle"></i> Informasi Sistem
                </h4>
                <p class="text-muted mb-0">
                    Sistem Monitoring Capaian Penyelesaian Perkara - Membantu memantau dan menganalisis kinerja penyelesaian perkara secara real-time
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Additional animation delays */
    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Card hover effects enhancement */
    .stat-card {
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 193, 7, 0.1), transparent);
        transition: left 0.5s;
    }

    .stat-card:hover::before {
        left: 100%;
    }

    .text-warning-dark {
        color: var(--warning-dark);
    }
</style>