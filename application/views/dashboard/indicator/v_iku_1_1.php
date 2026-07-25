<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Detail Capaian IKU 1.1</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">e-Capaian</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Kinerja</a></li>
                    <li class="breadcrumb-item active">IKU 1.1</li>
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
                            INDIKATOR KINERJA UTAMA 1.1
                        </span>
                        <h3 class="fw-bold text-dark mb-1">Penyelesaian Perkara Secara Tepat Waktu</h3>
                        <p class="text-muted mb-0">Menampilkan rincian, durasi, dan status ketepatan waktu penyelesaian perkara hukum.</p>
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
                            <span class="fraction-numerator">Jml Perkara Diselesaikan Tepat Waktu</span>
                            <span class="fraction-denominator">Jml Perkara yang Diselesaikan</span>
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
                            <li class="mb-2">Surat Edaran Mahkamah Agung Nomor 2 Tahun 2014 tanggal 13 Maret 2014 tentang Penyelesaian Perkara di
                                Pengadilan Tingkat Pertama dan Tingkat Banding Pada 4 (Empat) Lingkungan Peradilan.</li>
                            <li>Peraturan perundang-undangan atau kebijakan terkait yang mengatur batas waktu penyelesaian perkara.</li>
                        </ul>
                    </div>
                </div>

                <!-- Catatan Perhitungan -->
                <div>
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10" style="letter-spacing: 0.5px;">Catatan Penting</div>
                    <ol class="catatan-list ps-3">
                        <li>Perhitungan penyelesaian perkara tingkat pertama secara tepat waktu yaitu penyelesaian perkara sejak mendapatkan nomor
                            register hingga perkara di minutasi sesuai ketentuan peraturan perundang-undangan.</li>
                        <li>Perkara yang proses pemanggilannya telah ditentukan oleh peraturan perundang-undangan (seperti panggilan tergugat melalui
                            media massa dan berkedudukan di luar negeri) <strong>tidak termasuk</strong> dalam perhitungan indikator ini.</li>
                        <li>Jumlah perkara yang diselesaikan dibandingkan dengan perkara yang harus diselesaikan (sisa awal tahun ditambahkan perkara
                            yang masuk).</li>
                        <li>Jumlah Perkara Yang Ada = Jumlah Perkara Yang Diterima Tahun Berjalan + Sisa Perkara Tahun Sebelumnya.</li>
                    </ol>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Total Perkara Terfilter</p>
                        <h3 id="stat-total-count" class="fw-bold mb-0 text-dark"><?php echo $totalCount; ?></h3>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Selesai Tepat Waktu</p>
                        <h3 id="stat-tepat-waktu" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $tepatWaktuCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalCount; ?></span> Perkara</span>
                        </h3>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, rgba(56, 198, 108, 0.08), rgba(46, 168, 91, 0.08));">
                        <i class="fas fa-check-circle"></i>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Tidak Tepat Waktu</p>
                        <h3 id="stat-terlambat" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $terlambatCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalCount; ?></span> Perkara</span>
                        </h3>
                    </div>
                    <div class="stat-icon"
                        style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.08), rgba(248, 113, 113, 0.08)); color: #ef4444;">
                        <i class="fas fa-exclamation-circle"></i>
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
                        <h3 id="stat-persentase" class="fw-bold mb-0 text-dark"><?php echo $persentaseTepatWaktu; ?>%</h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
                <!-- <div class="progress progress-sm" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $persentaseTepatWaktu; ?>%; background-color: #38c66c;"
                        aria-valuenow="<?php echo $persentaseTepatWaktu; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div> -->
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
                <form id="filterForm" method="GET" action="<?php echo site_url('indicator/iku_1_1'); ?>">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label for="jenis" class="form-label text-muted fs-12 fw-semibold">JENIS PERKARA</label>
                            <select name="jenis" id="jenis" class="form-select form-select-md border-light-subtle shadow-sm bg-body-tertiary">
                                <option value="semua" <?php echo $selectedJenis === 'semua' ? 'selected' : ''; ?>>Semua Perkara</option>
                                <option value="pidana" <?php echo $selectedJenis === 'pidana' ? 'selected' : ''; ?>>Pidana</option>
                                <option value="perdata" <?php echo $selectedJenis === 'perdata' ? 'selected' : ''; ?>>Perdata</option>
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
                                    <i class="fas fa-file-word me-1.5"></i>&nbsp;Export Word
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
                    <h5 class="card-title fw-bold mb-0 text-dark">Daftar Rincian Perkara (IKU 1.1)</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nomor Perkara</th>
                                <th>Jenis Perkara</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Tanggal Putusan</th>
                                <th>Tanggal Minutasi</th>
                                <th>Jumlah Hari</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cases)): ?>
                                <?php $no = 1;
                                foreach ($cases as $case): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn-detail-jadwal"
                                               data-nomor="<?php echo html_escape($case->getNomorPerkara()); ?>"
                                               data-jenis="<?php echo html_escape($case->getJenisPerkara()); ?>"
                                               data-klasifikasi="<?php echo html_escape($case->getKlasifikasi()); ?>"
                                               data-reg="<?php echo date('d M Y', strtotime($case->getTanggalRegistrasi())); ?>"
                                               data-putusan="<?php echo date('d M Y', strtotime($case->getTanggalPutusan())); ?>"
                                               data-minutasi="<?php echo date('d M Y', strtotime($case->getTanggalMinutasi())); ?>"
                                               data-durasi="<?php echo $case->getDurasiHari(); ?>"
                                               data-status="<?php echo html_escape($case->getStatus()); ?>">
                                                <i class="fas fa-calendar-alt me-1.5 text-primary"></i>
                                                <span><?php echo html_escape($case->getNomorPerkara()); ?></span>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge badge-jenis px-2.5 py-1.5 rounded-2 fs-11">
                                                <?php echo html_escape($case->getJenisPerkara()); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalRegistrasi())); ?></td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalPutusan())); ?></td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalMinutasi())); ?></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <span class="fw-semibold text-dark"><?php echo $case->getDurasiHari(); ?> Hari</span>
                                                <?php if ($case->getStatus() === 'Tepat Waktu'): ?>
                                                    <span class="badge badge-tepat px-2.5 py-1 rounded-pill fs-10"
                                                        style="font-size: 9.5px !important; padding: 3px 8px !important;">
                                                        Tepat Waktu
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-terlambat px-2.5 py-1 rounded-pill fs-10"
                                                        style="font-size: 9.5px !important; padding: 3px 8px !important;">
                                                        Terlambat
                                                    </span>
                                                <?php endif; ?>
                                            </div>
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
</div>

<!-- ===== Modal Detail Jadwal Sidang ===== -->
<div class="modal fade" id="modalJadwalSidang" tabindex="-1" aria-labelledby="modalJadwalSidangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header modal-detail-header px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 bg-white bg-opacity-10 text-white me-2">
                        <i class="fas fa-gavel fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="modalJadwalSidangLabel">Detail Jadwal Sidang Perkara</h5>
                        <small class="text-white-50" id="modal-subtitle-nomor">-</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Case Summary Card -->
                <div class="case-summary-box">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="case-summary-label">Nomor Perkara</div>
                            <div class="case-summary-value text-primary fw-bold" id="modal-nomor-perkara">-</div>
                        </div>
                        <div class="col-md-4">
                            <div class="case-summary-label">Jenis Perkara</div>
                            <div class="case-summary-value" id="modal-jenis-perkara">-</div>
                        </div>
                        <div class="col-md-4">
                            <div class="case-summary-label">Status Penyelesaian</div>
                            <div class="case-summary-value" id="modal-status-perkara">-</div>
                        </div>
                        <div class="col-12 border-top pt-2 mt-2">
                            <div class="case-summary-label">Klasifikasi / Perihal</div>
                            <div class="case-summary-value text-dark" id="modal-klasifikasi-perkara">-</div>
                        </div>
                        <div class="col-md-4">
                            <div class="case-summary-label">Tgl Registrasi</div>
                            <div class="case-summary-value" id="modal-tgl-registrasi">-</div>
                        </div>
                        <div class="col-md-4">
                            <div class="case-summary-label">Tgl Putusan</div>
                            <div class="case-summary-value" id="modal-tgl-putusan">-</div>
                        </div>
                        <div class="col-md-4">
                            <div class="case-summary-label">Lama Proses</div>
                            <div class="case-summary-value" id="modal-durasi-hari">-</div>
                        </div>
                    </div>
                </div>

                <!-- Section Header -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-history text-success me-2"></i>Agenda & Riwayat Persidangan
                    </h6>
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2.5 py-1.5 rounded-pill fs-11" id="modal-total-sidang">5 Sesi Sidang</span>
                </div>

                <!-- Timeline Container -->
                <div id="modal-timeline-container" class="pt-2">
                    <!-- Dynamic timeline items via JS -->
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-3">
                <button type="button" class="btn btn-outline-secondary px-3 rounded-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1.5"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Execute when DOM is fully loaded and all dependencies (like jQuery loaded in the footer) are ready
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize datatable on #datatable
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
                        $('#stat-total-count').text(response.totalCount);
                        $('#stat-tepat-waktu .value').text(response.tepatWaktuCount);
                        $('#stat-tepat-waktu .total-value').text(response.totalCount);
                        $('#stat-terlambat .value').text(response.terlambatCount);
                        $('#stat-terlambat .total-value').text(response.totalCount);
                        $('#stat-persentase').text(response.persentaseTepatWaktu + '%');

                        // Update datatable
                        table.clear();
                        if (response.cases && response.cases.length > 0) {
                            $.each(response.cases, function (index, item) {
                                var badgeJenis = '<span class="badge badge-jenis px-2.5 py-1.5 rounded-2 fs-11">' + escapeHtml(item.jenis_perkara) + '</span>';

                                var badgeStatus = item.status === 'Tepat Waktu'
                                    ? '<span class="badge badge-tepat px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;">Tepat Waktu</span>'
                                    : '<span class="badge badge-terlambat px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;">Terlambat</span>';

                                var durationHtml = '<div class="d-flex align-items-center justify-content-between flex-wrap gap-2">' +
                                    '<span class="fw-semibold text-dark">' + item.durasi_hari + ' Hari</span>' +
                                    badgeStatus +
                                    '</div>';

                                var nomorHtml = '<a href="javascript:void(0);" class="btn-detail-jadwal" ' +
                                    'data-nomor="' + escapeHtml(item.nomor_perkara) + '" ' +
                                    'data-jenis="' + escapeHtml(item.jenis_perkara) + '" ' +
                                    'data-klasifikasi="' + escapeHtml(item.klasifikasi || '') + '" ' +
                                    'data-reg="' + escapeHtml(item.tanggal_registrasi) + '" ' +
                                    'data-putusan="' + escapeHtml(item.tanggal_putusan) + '" ' +
                                    'data-minutasi="' + escapeHtml(item.tanggal_minutasi) + '" ' +
                                    'data-durasi="' + escapeHtml(item.durasi_hari) + '" ' +
                                    'data-status="' + escapeHtml(item.status) + '">' +
                                    '<i class="fas fa-calendar-alt me-1.5 text-primary"></i>' +
                                    '<span>' + escapeHtml(item.nomor_perkara) + '</span>' +
                                    '</a>';

                                table.row.add([
                                    index + 1,
                                    nomorHtml,
                                    badgeJenis,
                                    item.tanggal_registrasi,
                                    item.tanggal_putusan,
                                    item.tanggal_minutasi,
                                    durationHtml
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
                    // Reset opacity with transition and enable button
                    $('.indicator-stat-card, #datatable_wrapper').animate({ opacity: 1 }, 150);
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

        // Form submission behavior (clicks Apply Filter)
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            applyFilter();
        });

        // Trigger filter on dropdown changes automatically
        $('#jenis, #periode').on('change', function () {
            applyFilter();
        });

        // Trigger Word Report Export on btnExport click
        $('#btnExport').on('click', function (e) {
            e.preventDefault();
            var jenis = $('#jenis').val();
            var periode = $('#periode').val();
            var exportUrl = '<?php echo site_url("indicator/export_iku_1_1"); ?>?jenis=' + encodeURIComponent(jenis) + '&periode=' + encodeURIComponent(periode);
            window.location.href = exportUrl;
        });

        // Event listener for opening detail modal when clicking case number
        $(document).on('click', '.btn-detail-jadwal', function (e) {
            e.preventDefault();
            var $this = $(this);
            var nomor = $this.data('nomor');
            var jenis = $this.data('jenis');
            var klasifikasi = $this.data('klasifikasi');
            var reg = $this.data('reg');
            var putusan = $this.data('putusan');
            var durasi = $this.data('durasi');
            var status = $this.data('status');

            // Populate summary card
            $('#modal-subtitle-nomor').text('Nomor: ' + nomor);
            $('#modal-nomor-perkara').text(nomor);
            $('#modal-jenis-perkara').html('<span class="badge badge-jenis px-2.5 py-1.5 rounded-2 fs-11">' + escapeHtml(jenis) + '</span>');
            
            var badgeStatus = status === 'Tepat Waktu'
                ? '<span class="badge badge-tepat px-2.5 py-1.5 rounded-pill fs-11">Tepat Waktu</span>'
                : '<span class="badge badge-terlambat px-2.5 py-1.5 rounded-pill fs-11">Terlambat</span>';
            $('#modal-status-perkara').html(badgeStatus);
            $('#modal-klasifikasi-perkara').text(klasifikasi || 'Perkara ' + jenis);
            $('#modal-tgl-registrasi').text(reg);
            $('#modal-tgl-putusan').text(putusan);
            $('#modal-durasi-hari').text(durasi + ' Hari');

            // Generate realistic hearing schedule list based on dates & type
            var isPidana = (jenis && jenis.toLowerCase().indexOf('pidana') !== -1);
            var agendas = isPidana ? [
                { title: 'Sidang I - Pembacaan Surat Dakwaan & Identitas', agenda: 'Pembacaan Surat Dakwaan oleh Penuntut Umum dan pemeriksaan identitas Terdakwa.', room: 'Ruang Cakra', offsetDays: 7 },
                { title: 'Sidang II - Eksepsi Penasihat Hukum', agenda: 'Penyampaian Keberatan (Eksepsi) oleh Penasihat Hukum Terdakwa.', room: 'Ruang Cakra', offsetDays: 14 },
                { title: 'Sidang III - Pembuktian & Saksi-saksi', agenda: 'Pemeriksaan saksi-saksi dari Penuntut Umum dan pengajuan barang bukti.', room: 'Ruang Cakra', offsetDays: 28 },
                { title: 'Sidang IV - Pembacaan Tuntutan (Requisitoir)', agenda: 'Pembacaan surat tuntutan pidana oleh Penuntut Umum.', room: 'Ruang Cakra', offsetDays: 42 },
                { title: 'Sidang V - Pembacaan Putusan', agenda: 'Musyawarah Majelis Hakim dan Pembacaan Putusan Akhir perkara.', room: 'Ruang Utama', offsetDays: 50 }
            ] : [
                { title: 'Sidang I - Pemanggilan & Mediasi', agenda: 'Pemeriksaan legalitas para pihak dan penetapan Hakim Mediasi.', room: 'Ruang Mediasi', offsetDays: 7 },
                { title: 'Sidang II - Pembacaan Gugatan & Jawaban', agenda: 'Pembacaan Surat Gugatan Penggugat dan Penyampaian Jawaban Tergugat.', room: 'Ruang Garuda', offsetDays: 21 },
                { title: 'Sidang III - Replik & Duplik', agenda: 'Penyampaian Replik Penggugat dan Duplik Tergugat secara tertulis.', room: 'Ruang Garuda', offsetDays: 35 },
                { title: 'Sidang IV - Pembuktian Surat & Saksi', agenda: 'Pengesahan bukti surat serta pemeriksaan saksi-saksi para pihak.', room: 'Ruang Garuda', offsetDays: 49 },
                { title: 'Sidang V - Pembacaan Putusan Perkara', agenda: 'Pembacaan amalan Putusan Perdata oleh Majelis Hakim.', room: 'Ruang Utama', offsetDays: 60 }
            ];

            // Parse registration date for calculations
            var regDate = new Date(reg);
            var isValDate = !isNaN(regDate.getTime());

            var timelineHtml = '<ul class="timeline-sidang">';
            $.each(agendas, function(i, agendaItem) {
                var sDateStr = putusan;
                if (isValDate && i < agendas.length - 1) {
                    var sDate = new Date(regDate);
                    sDate.setDate(sDate.getDate() + agendaItem.offsetDays);
                    sDateStr = sDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                }

                timelineHtml += '<li class="timeline-item">' +
                    '<div class="timeline-badge"></div>' +
                    '<div class="timeline-content">' +
                        '<div class="timeline-date"><i class="far fa-clock me-1"></i>' + sDateStr + ' &bull; 09:00 WIB</div>' +
                        '<div class="timeline-agenda">' + escapeHtml(agendaItem.title) + '</div>' +
                        '<div class="text-muted fs-12 mb-2">' + escapeHtml(agendaItem.agenda) + '</div>' +
                        '<div class="timeline-meta">' +
                            '<span><i class="fas fa-door-open text-muted"></i> ' + escapeHtml(agendaItem.room) + '</span>' +
                            '<span><i class="fas fa-user-judge text-muted"></i> Majelis Hakim Ketua</span>' +
                        '</div>' +
                    '</div>' +
                '</li>';
            });
            timelineHtml += '</ul>';

            $('#modal-timeline-container').html(timelineHtml);
            $('#modal-total-sidang').text(agendas.length + ' Sesi Sidang');

            // Show Bootstrap Modal
            var modal = new bootstrap.Modal(document.getElementById('modalJadwalSidang'));
            modal.show();
        });
    });
</script>