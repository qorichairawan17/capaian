<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('html_escape')) {
    function html_escape($var, $double_encode = TRUE) {
        if (empty($var)) { return $var; }
        if (is_array($var)) { return array_map('html_escape', $var); }
        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8', $double_encode);
    }
}

$selectedMetode = isset($selectedMetode) ? $selectedMetode : 'semua';
$selectedPeriode = isset($selectedPeriode) ? $selectedPeriode : 'tahunan';
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Detail Capaian IKU 1.10</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">e-Capaian</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Kinerja</a></li>
                    <li class="breadcrumb-item active">IKU 1.10</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Header Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card indicator-banner">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <span class="badge welcome-badge px-3 py-1.5 rounded-pill fs-11 fw-bold text-success mb-2"
                            style="background-color: rgba(56, 198, 108, 0.08);">
                            INDIKATOR KINERJA UTAMA 1.10
                        </span>
                        <h3 class="fw-bold text-dark mb-1">Perkara Perdata Tingkat Pertama yang Menggunakan e-Court</h3>
                        <p class="text-muted mb-0">Menampilkan rincian, metode pendaftaran (e-Court / Konvensional), nomor registrasi elektronik, dan persentase penggunaan e-Court.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card info-sidebar-card">
            <div class="card-header bg-transparent border-bottom border-light py-3">
                <h6 class="card-title fw-bold mb-0 text-dark"><i class="fas fa-info-circle me-2 text-success"></i>Definisi & Aturan IKU</h6>
            </div>
            <div class="card-body">
                <!-- Rumus Formula Perhitungan -->
                <div class="formula-container text-center mb-4">
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10 text-start" style="letter-spacing: 0.5px;">Rumus Perhitungan</div>
                    <div class="d-inline-flex align-items-center flex-wrap justify-content-center">
                        <div class="formula-text me-2">Persentase =</div>
                        <div class="formula-fraction">
                            <span class="fraction-numerator">Jml Perkara Perdata Tingkat Pertama Diajukan e-Court</span>
                            <span class="fraction-denominator">Jml Perkara Perdata Tingkat Pertama Diajukan</span>
                        </div>
                        <div class="formula-text ms-2">x 100%</div>
                    </div>
                </div>

                <!-- Penanggung Jawab & Sumber Data -->
                <div class="mb-4">
                    <div class="info-list-item">
                        <div class="info-list-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="info-list-content">
                            <div class="info-list-label">Penanggung Jawab</div>
                            <div class="info-list-value">Panitera</div>
                        </div>
                    </div>

                    <div class="info-list-item">
                        <div class="info-list-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="info-list-content">
                            <div class="info-list-label">Sumber Data</div>
                            <div class="info-list-value">Laporan Bulanan & Laporan Tahunan</div>
                        </div>
                    </div>
                </div>

                <!-- Dasar Hukum -->
                <div class="mb-4">
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10" style="letter-spacing: 0.5px;">Dasar Hukum</div>
                    <div class="dasar-hukum-box">
                        <ul class="ps-2 mb-0" style="list-style-type: square; padding-left: 15px !important;">
                            <li class="mb-2">Peraturan Mahkamah Agung Nomor 7 Tahun 2022 tentang Perubahan Atas PERMA No. 1 Tahun 2019 tentang Administrasi Perkara dan Persidangan di Pengadilan Secara Elektronik.</li>
                            <li>Keputusan Ketua Mahkamah Agung Nomor 363/KMA/SK/XII/2022 tentang Petunjuk Teknis Administrasi dan Persidangan Perkara Perdata, Perkara Agama, dan Tata Usaha Negara di Pengadilan Secara Elektronik.</li>
                        </ul>
                    </div>
                </div>

                <!-- Catatan Kriteria -->
                <div>
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10" style="letter-spacing: 0.5px;">Catatan Kriteria</div>
                    <ol class="catatan-list">
                        <li>Jumlah perkara perdata yang didaftarkan meliputi jumlah perkara perdata yang diajukan secara elektronik melalui e-Court dan perkara perdata yang diajukan secara konvensional.</li>
                        <li>Pembagi jumlah perkara perdata tingkat pertama yang diajukan sama dengan didaftarkan.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4 g-3">
    <!-- Card 1: Total Perkara Perdata Diajukan (Pembagi) -->
    <div class="col-md-3">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Total Perkara Diajukan</p>
                        <h3 id="stat-total-diajukan-count" class="fw-bold mb-0 text-dark"><?php echo $totalDiajukanCount; ?></h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Perkara Via e-Court (Pembilang) -->
    <div class="col-md-3">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Perkara e-Court</p>
                        <h3 id="stat-ecourt" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $ecourtCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalDiajukanCount; ?></span> Perkara</span>
                        </h3>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, rgba(56, 198, 108, 0.08), rgba(46, 168, 91, 0.08));">
                        <i class="fas fa-laptop"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Perkara Konvensional -->
    <div class="col-md-3">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Perkara Konvensional</p>
                        <h3 id="stat-konvensional" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $konvensionalCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalDiajukanCount; ?></span> Perkara</span>
                        </h3>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, rgba(108, 117, 125, 0.08), rgba(173, 181, 189, 0.08)); color: #6c757d;">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Persentase Capaian -->
    <div class="col-md-3">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Persentase Capaian</p>
                        <h3 id="stat-persentase" class="fw-bold mb-0 text-dark"><?php echo $persentaseEcourt; ?>%</h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Filter & Table (Col 8/9) -->
    <div class="col-lg-12">
        <!-- Filter Card -->
        <div class="card filter-card mb-4">
            <div class="card-header bg-transparent border-0 pt-3 pb-0">
                <h6 class="card-title fw-bold text-dark mb-0"><i class="fas fa-filter me-2 text-success"></i>Filter Capaian Data</h6>
            </div>
            <div class="card-body pt-3">
                <form id="filterForm" method="GET" action="<?php echo site_url('indicator/iku_1_10'); ?>">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label for="metode_pendaftaran" class="form-label text-muted fs-12 fw-semibold">METODE PENDAFTARAN</label>
                            <select name="metode" id="metode_pendaftaran" class="form-select form-select-md border-light-subtle shadow-sm bg-body-tertiary">
                                <option value="semua" <?php echo $selectedMetode === 'semua' ? 'selected' : ''; ?>>Semua Metode</option>
                                <option value="ecourt" <?php echo $selectedMetode === 'ecourt' ? 'selected' : ''; ?>>e-Court</option>
                                <option value="konvensional" <?php echo $selectedMetode === 'konvensional' ? 'selected' : ''; ?>>Konvensional</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="periode" class="form-label text-muted fs-12 fw-semibold">PERIODE DATA</label>
                            <select name="periode" id="periode" class="form-select form-select-md border-light-subtle shadow-sm bg-body-tertiary">
                                <option value="tahunan" <?php echo $selectedPeriode === 'tahunan' ? 'selected' : ''; ?>>Tahunan (1 Tahun)</option>
                                <option value="t1" <?php echo $selectedPeriode === 't1' ? 'selected' : ''; ?>>Triwulan 1 (Jan - Mar)</option>
                                <option value="t2" <?php echo $selectedPeriode === 't2' ? 'selected' : ''; ?>>Triwulan 2 (Apr - Jun)</option>
                                <option value="t3" <?php echo $selectedPeriode === 't3' ? 'selected' : ''; ?>>Triwulan 3 (Jul - Sep)</option>
                                <option value="t4" <?php echo $selectedPeriode === 't4' ? 'selected' : ''; ?>>Triwulan 4 (Okt - Des)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="button" id="btnExport" class="btn btn-filter-apply w-100 shadow-sm">
                                    <i class="fas fa-file-export me-1.5"></i>&nbsp;Export
                                </button>
                                <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-outline-secondary btn-filter-reset shadow-sm w-50">
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Datatable Card -->
        <div class="card data-card mb-4">
            <div class="card-header bg-transparent border-bottom border-light py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-bold mb-0 text-dark">Daftar Rincian Perkara Perdata (IKU 1.10)</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nomor Perkara</th>
                                <th>Para Pihak</th>
                                <th>Jenis Perdata</th>
                                <th>Tgl Pendaftaran</th>
                                <th>Metode Pendaftaran</th>
                                <th>No. Register e-Court</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cases)): ?>
                                <?php foreach ($cases as $index => $case): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $index + 1; ?></td>
                                        <td class="fw-medium text-dark"><?php echo html_escape($case->getNomorPerkara()); ?></td>
                                        <td class="fw-semibold text-dark"><?php echo html_escape($case->getParaPihak()); ?></td>
                                        <td><span class="badge badge-jenis px-2 py-1 rounded"><?php echo html_escape($case->getJenisPerdata()); ?></span></td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalPendaftaran())); ?></td>
                                        <td>
                                            <?php if ($case->isEcourt()): ?>
                                                <span class="badge badge-ecourt px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;">
                                                    <i class="fas fa-laptop me-1"></i>e-Court
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-konvensional px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;">
                                                    Konvensional
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="fs-12 text-dark font-monospace"><?php echo html_escape($case->getNomorRegisterEcourt()); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize DataTable
        var table = $('#datatable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            order: [[0, 'asc']],
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination");
                $(".dataTables_length select").addClass("form-select form-select-sm");
            }
        });

        // Function to fetch data via AJAX
        function applyFilter() {
            var form = $('#filterForm');
            var url = form.attr('action');
            var data = form.serialize();

            // Fade stats cards and table wrapper to indicate loading
            $('.indicator-stat-card, #datatable_wrapper').css('opacity', '0.5');
            $('.btn-filter-apply').prop('disabled', true);
            $('.btn-filter-apply i').removeClass('fa-file-export').addClass('fa-spinner fa-spin');

            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (response) {
                    if (response.success) {
                        // Update stats
                        $('#stat-total-count').text(response.totalDiajukanCount);
                        $('#stat-ecourt .value').text(response.ecourtCount);
                        $('#stat-ecourt .total-value').text(response.totalDiajukanCount);
                        $('#stat-konvensional .value').text(response.konvensionalCount);
                        $('#stat-konvensional .total-value').text(response.totalDiajukanCount);
                        $('#stat-persentase').text(response.persentaseEcourt + '%');

                        // Update datatable
                        table.clear();
                        if (response.cases && response.cases.length > 0) {
                            $.each(response.cases, function (index, item) {
                                var isEcourt = item.is_ecourt;
                                var badgeMetode = '';
                                if (isEcourt) {
                                    badgeMetode = '<span class="badge badge-ecourt px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-laptop me-1"></i>e-Court</span>';
                                } else {
                                    badgeMetode = '<span class="badge badge-konvensional px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;">Konvensional</span>';
                                }

                                var nomorRegister = item.nomor_register_ecourt ? escapeHtml(item.nomor_register_ecourt) : '-';

                                table.row.add([
                                    index + 1,
                                    '<span class="fw-medium text-dark">' + escapeHtml(item.nomor_perkara) + '</span>',
                                    '<span class="fw-semibold text-dark">' + escapeHtml(item.para_pihak) + '</span>',
                                    '<span class="badge badge-jenis px-2 py-1 rounded">' + escapeHtml(item.jenis_perdata) + '</span>',
                                    item.tanggal_pendaftaran,
                                    badgeMetode,
                                    '<span class="fs-12 text-dark font-monospace">' + nomorRegister + '</span>'
                                ]);
                            });
                        }
                        table.draw();
                    } else {
                        console.error('Error fetching data:', response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                },
                complete: function () {
                    // Restore opacity and button state
                    $('.indicator-stat-card, #datatable_wrapper').css('opacity', '1');
                    $('.btn-filter-apply').prop('disabled', false);
                    $('.btn-filter-apply i').removeClass('fa-spinner fa-spin').addClass('fa-file-export');
                }
            });
        }

        // HTML escaping helper
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return text
                .toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Form submission behavior
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            applyFilter();
        });

        // Trigger filter on dropdown changes automatically
        $('#metode_pendaftaran, #periode').on('change', function () {
            applyFilter();
        });
    });
</script>
