<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Detail Capaian IKU 1.4</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">e-Capaian</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Kinerja</a></li>
                    <li class="breadcrumb-item active">IKU 1.4</li>
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
                            INDIKATOR KINERJA UTAMA 1.4
                        </span>
                        <h3 class="fw-bold text-dark mb-1">Persentase Perkara Perdata pada Tingkat Banding yang Menggunakan e-Court</h3>
                        <p class="text-muted mb-0">Menampilkan rincian pengajuan upaya hukum banding perkara perdata secara elektronik (e-Court) dan
                            konvensional.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4 g-3">
    <div class="col-md-3">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Menggunakan e-Court</p>
                        <h3 id="stat-ecourt-count" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $eCourtCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalDiajukanCount; ?></span>
                                Perkara</span>
                        </h3>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, rgba(56, 198, 108, 0.08), rgba(46, 168, 91, 0.08));">
                        <i class="fas fa-laptop text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Total Diajukan Banding</p>
                        <h3 id="stat-total-count" class="fw-bold mb-0 text-dark">
                            <?php echo $totalDiajukanCount; ?>
                        </h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Pengajuan Konvensional</p>
                        <h3 id="stat-konvensional-count" class="fw-bold mb-0 text-dark"><?php echo $konvensionalCount; ?></h3>
                    </div>
                    <div class="stat-icon" style="background: rgba(100, 116, 139, 0.08); color: #475569;">
                        <i class="fas fa-file-signature"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-0 fs-13 fw-medium">Persentase Capaian</p>
                        <h3 id="stat-persentase" class="fw-bold mb-0 text-dark"><?php echo $persentaseECourt; ?>%</h3>
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
    <div class="col-lg-8 col-xl-9">
        <!-- Filter Card -->
        <div class="card filter-card mb-4">
            <div class="card-header bg-transparent border-0 pt-3 pb-0">
                <h6 class="card-title fw-bold text-dark mb-0"><i class="fas fa-filter me-2 text-success"></i>Filter Capaian Data</h6>
            </div>
            <div class="card-body pt-3">
                <form id="filterForm" method="GET" action="<?php echo site_url('indicator/iku_1_4'); ?>">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label for="jenis" class="form-label text-muted fs-12 fw-semibold">METODE PENGAJUAN</label>
                            <select name="jenis" id="jenis" class="form-select form-select-md border-light-subtle shadow-sm bg-body-tertiary">
                                <option value="semua" <?php echo $selectedJenis === 'semua' ? 'selected' : ''; ?>>Semua Metode</option>
                                <option value="ecourt" <?php echo $selectedJenis === 'ecourt' ? 'selected' : ''; ?>>e-Court</option>
                                <option value="konvensional" <?php echo $selectedJenis === 'konvensional' ? 'selected' : ''; ?>>Konvensional</option>
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
                    <h5 class="card-title fw-bold mb-0 text-dark">Daftar Perkara Perdata Banding (IKU 1.4)</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nomor Perkara Banding</th>
                                <th>Jenis Pengajuan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Pembanding</th>
                                <th>Terbanding</th>
                                <th>Status e-Court</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cases)): ?>
                                <?php $no = 1;
                                foreach ($cases as $case): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td class="fw-medium text-dark"><?php echo html_escape($case->getNomorPerkara()); ?></td>
                                        <td>
                                            <?php if (strtolower($case->getJenisPengajuan()) === 'e-court'): ?>
                                                <span class="badge badge-ecourt px-2.5 py-1.5 rounded-2 fs-11">
                                                    <i class="fas fa-laptop me-1"></i>e-Court
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-konvensional px-2.5 py-1.5 rounded-2 fs-11">
                                                    <i class="fas fa-file-alt me-1"></i>Konvensional
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalPengajuan())); ?></td>
                                        <td><?php echo html_escape($case->getPembanding()); ?></td>
                                        <td><?php echo html_escape($case->getTerbanding()); ?></td>
                                        <td>
                                            <?php if (strtolower($case->getJenisPengajuan()) === 'e-court'): ?>
                                                <span class="badge badge-ecourt px-2.5 py-1 rounded-pill fs-10"
                                                    style="font-size: 9.5px !important; padding: 3px 8px !important;">
                                                    <i class="fas fa-check-circle me-1"></i>e-Court Active
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-konvensional px-2.5 py-1 rounded-pill fs-10"
                                                    style="font-size: 9.5px !important; padding: 3px 8px !important;">
                                                    Konvensional
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: IKU Metadata Sidebar (Col 4/3) -->
    <div class="col-lg-4 col-xl-3 mb-4">
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
                            <span class="fraction-numerator">Jumlah perkara perdata tingkat banding yang diajukan menggunakan e-Court</span>
                            <span class="fraction-denominator">Jumlah perkara perdata tingkat banding yang diajukan</span>
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
                            <li class="mb-2">Peraturan Mahkamah Agung Nomor 7 Tahun 2022 tentang Perubahan Atas Peraturan Mahkamah Agung Nomor 1 Tahun
                                2019 tentang Administrasi Perkara dan Persidangan di Pengadilan Secara Elektronik.</li>
                            <li>Keputusan Ketua Mahkamah Agung Nomor 363/KMA/SK/SK/XII/2022 tentang Petunjuk Teknis Administrasi dan Persidangan
                                Perkara Perdata, Perkara Agama, dan Tata Usaha Negara di Pengadilan Secara Elektronik.</li>
                        </ul>
                    </div>
                </div>

                <!-- Catatan Perhitungan -->
                <div>
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10" style="letter-spacing: 0.5px;">Catatan Penting</div>
                    <ol class="catatan-list ps-3">
                        <li class="mb-2">Perkara perdata tingkat banding adalah perkara perdata yang diajukan upaya hukum banding.</li>
                        <li>Jumlah perkara perdata yang mengajukan upaya hukum banding meliputi jumlah perkara perdata yang mengajukan upaya hukum
                            banding secara elektronik melalui e-Court dan perkara perdata yang mengajukan upaya hukum banding secara konvensional.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ perkara",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ perkara",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 perkara",
                infoFiltered: "(disaring dari _MAX_ total perkara)",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination");
                $(".dataTables_length select").addClass("form-select form-select-sm");
            }
        });

        function applyFilter() {
            var form = $('#filterForm');
            var url = form.attr('action');
            var data = form.serialize();

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
                        $('#stat-ecourt-count .value').text(response.eCourtCount);
                        $('#stat-ecourt-count .total-value').text(response.totalDiajukanCount);
                        $('#stat-total-count').text(response.totalDiajukanCount);
                        $('#stat-konvensional-count').text(response.konvensionalCount);
                        $('#stat-persentase').text(response.persentaseECourt + '%');

                        table.clear();
                        if (response.cases && response.cases.length > 0) {
                            $.each(response.cases, function (index, item) {
                                var isECourt = item.jenis_pengajuan.toLowerCase() === 'e-court';

                                var badgeJenis = isECourt
                                    ? '<span class="badge badge-ecourt px-2.5 py-1.5 rounded-2 fs-11"><i class="fas fa-laptop me-1"></i>e-Court</span>'
                                    : '<span class="badge badge-konvensional px-2.5 py-1.5 rounded-2 fs-11"><i class="fas fa-file-alt me-1"></i>Konvensional</span>';

                                var badgeStatus = isECourt
                                    ? '<span class="badge badge-ecourt px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-check-circle me-1"></i>e-Court Active</span>'
                                    : '<span class="badge badge-konvensional px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;">Konvensional</span>';

                                table.row.add([
                                    index + 1,
                                    '<span class="fw-medium text-dark">' + escapeHtml(item.nomor_perkara) + '</span>',
                                    badgeJenis,
                                    item.tanggal_pengajuan,
                                    escapeHtml(item.pembanding),
                                    escapeHtml(item.terbanding),
                                    badgeStatus
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
                    $('.indicator-stat-card, #datatable_wrapper').animate({ opacity: 1 }, 150);
                    $('.btn-filter-apply').prop('disabled', false);
                    $('.btn-filter-apply i').removeClass('fa-spinner fa-spin').addClass('fa-file-export');
                }
            });
        }

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

        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            applyFilter();
        });

        $('#jenis, #periode').on('change', function () {
            applyFilter();
        });
    });
</script>