<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Datatables CSS -->
<link href="<?php echo base_url('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css'); ?>" rel="stylesheet" type="text/css" />

<style>
    /* Styling specifically for this indicator view */
    .indicator-banner {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.015);
        position: relative;
        overflow: hidden;
    }
    .indicator-banner::before {
        content: '';
        position: absolute;
        width: 6px;
        height: 100%;
        background-color: #38c66c;
        left: 0;
        top: 0;
    }
    .indicator-stat-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.01);
    }
    .indicator-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(56, 198, 108, 0.06);
    }
    .indicator-stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        background: linear-gradient(135deg, rgba(56, 198, 108, 0.08), rgba(65, 195, 169, 0.08));
        color: #38c66c;
    }
    .filter-card {
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.01);
    }
    .data-card {
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background-color: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.015);
    }
    .btn-filter-apply {
        background-color: #38c66c;
        border-color: #38c66c;
        color: #ffffff;
        font-weight: 600;
        padding: 0.55rem 1.5rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-filter-apply:hover, .btn-filter-apply:focus {
        background-color: #2ea85b;
        border-color: #2ea85b;
        color: #ffffff;
    }
    .btn-filter-reset {
        border-radius: 8px;
        padding: 0.55rem 1.25rem;
        font-weight: 500;
    }
    .badge-tepat {
        background-color: rgba(56, 198, 108, 0.1);
        color: #1e824c;
        font-weight: 600;
        border: 1px solid rgba(56, 198, 108, 0.2);
    }
    .badge-terlambat {
        background-color: rgba(239, 68, 68, 0.1);
        color: #b91c1c;
        font-weight: 600;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    .badge-jenis {
        background-color: #f1f5f9;
        color: #475569;
        font-weight: 550;
    }
    /* Customize table look */
    table.dataTable {
        border-collapse: collapse !important;
    }
    table.dataTable thead th {
        background-color: #f8fafc;
        color: #334155;
        font-weight: 600;
        border-bottom: 2px solid #e2e8f0 !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 16px !important;
    }
    table.dataTable tbody td {
        padding: 12px 16px !important;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9 !important;
        color: #334155;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.active .page-link {
        background-color: #38c66c !important;
        border-color: #38c66c !important;
    }

    /* Info Sidebar Styles */
    .info-sidebar-card {
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background-color: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.015);
        height: fit-content;
    }
    .formula-container {
        background-color: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        padding: 15px 10px;
    }
    .formula-fraction {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        vertical-align: middle;
        line-height: 1.2;
    }
    .fraction-numerator {
        border-bottom: 1px solid #475569;
        padding-bottom: 4px;
        margin-bottom: 4px;
        font-size: 11px;
        font-weight: 600;
        color: #1e293b;
    }
    .fraction-denominator {
        font-size: 11px;
        font-weight: 600;
        color: #1e293b;
    }
    .formula-text {
        font-size: 12px;
        font-weight: 700;
        color: #0f172a;
    }
    .info-list-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 16px;
    }
    .info-list-item:last-child {
        margin-bottom: 0;
    }
    .info-list-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background-color: rgba(56, 198, 108, 0.08);
        color: #38c66c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .info-list-content {
        flex-grow: 1;
    }
    .info-list-label {
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 2px;
        letter-spacing: 0.5px;
    }
    .info-list-value {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }
    .dasar-hukum-box {
        background-color: rgba(56, 198, 108, 0.02);
        border-left: 3px solid #38c66c;
        border-radius: 4px;
        padding: 12px;
        font-size: 12px;
        color: #334155;
        line-height: 1.5;
    }
    .catatan-list {
        font-size: 12px;
        color: #475569;
        padding-left: 18px;
        margin-bottom: 0;
    }
    .catatan-list li {
        margin-bottom: 8px;
    }
    .catatan-list li:last-child {
        margin-bottom: 0;
    }
</style>

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
                        <span class="badge welcome-badge px-3 py-1.5 rounded-pill fs-11 fw-bold text-success mb-2" style="background-color: rgba(56, 198, 108, 0.08);">
                            INDIKATOR KINERJA UTAMA 1.1
                        </span>
                        <h3 class="fw-bold text-dark mb-1">Penyelesaian Perkara Secara Tepat Waktu</h3>
                        <p class="text-muted mb-0">Menampilkan rincian, durasi, dan status ketepatan waktu penyelesaian perkara hukum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4 g-3">
    <div class="col-md-4">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Total Perkara Terfilter</p>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo $totalCount; ?></h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Selesai Tepat Waktu</p>
                        <h3 class="fw-bold mb-0 text-dark">
                            <?php echo $tepatWaktuCount; ?>
                            <span class="fs-14 text-muted fw-normal">/ <?php echo $totalCount; ?> Perkara</span>
                        </h3>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, rgba(56, 198, 108, 0.08), rgba(46, 168, 91, 0.08));">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card indicator-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <p class="text-muted mb-0 fs-13 fw-medium">Persentase Capaian</p>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo $persentaseTepatWaktu; ?>%</h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
                <div class="progress progress-sm" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $persentaseTepatWaktu; ?>%; background-color: #38c66c;" 
                         aria-valuenow="<?php echo $persentaseTepatWaktu; ?>" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <button type="submit" class="btn btn-filter-apply w-100 shadow-sm">
                                    <i class="fas fa-sync-alt me-1.5"></i>Terapkan Filter
                                </button>
                                <a href="<?php echo site_url('indicator/iku_1_1'); ?>" class="btn btn-outline-secondary btn-filter-reset shadow-sm">
                                    Reset
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
                                <th>Jenis</th>
                                <th>Klasifikasi</th>
                                <th>Tgl Registrasi</th>
                                <th>Tgl Putusan</th>
                                <th>Durasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cases)): ?>
                                <?php $no = 1; foreach ($cases as $case): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td class="fw-medium text-dark"><?php echo html_escape($case->getNomorPerkara()); ?></td>
                                        <td>
                                            <span class="badge badge-jenis px-2 py-1.5 rounded-2 fs-11">
                                                <?php echo html_escape($case->getJenisPerkara()); ?>
                                            </span>
                                        </td>
                                        <td><?php echo html_escape($case->getKlasifikasi()); ?></td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalRegistrasi())); ?></td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalPutusan())); ?></td>
                                        <td class="fw-semibold"><?php echo $case->getDurasiHari(); ?> Hari</td>
                                        <td>
                                            <?php if ($case->getStatus() === 'Tepat Waktu'): ?>
                                                <span class="badge badge-tepat px-2.5 py-1.5 rounded-pill fs-11">
                                                    <i class="fas fa-check-circle me-1"></i>Tepat Waktu
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-terlambat px-2.5 py-1.5 rounded-pill fs-11">
                                                    <i class="fas fa-exclamation-circle me-1"></i>Terlambat
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
                            <li class="mb-2">Surat Edaran Mahkamah Agung Nomor 2 Tahun 2014 tanggal 13 Maret 2014 tentang Penyelesaian Perkara di Pengadilan Tingkat Pertama dan Tingkat Banding Pada 4 (Empat) Lingkungan Peradilan.</li>
                            <li>Peraturan perundang-undangan atau kebijakan terkait yang mengatur batas waktu penyelesaian perkara.</li>
                        </ul>
                    </div>
                </div>

                <!-- Catatan Perhitungan -->
                <div>
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10" style="letter-spacing: 0.5px;">Catatan Penting</div>
                    <ol class="catatan-list ps-3">
                        <li>Perhitungan penyelesaian perkara tingkat pertama secara tepat waktu yaitu penyelesaian perkara sejak mendapatkan nomor register hingga perkara di minutasi sesuai ketentuan peraturan perundang-undangan.</li>
                        <li>Perkara yang proses pemanggilannya telah ditentukan oleh peraturan perundang-undangan (seperti panggilan tergugat melalui media massa dan berkedudukan di luar negeri) <strong>tidak termasuk</strong> dalam perhitungan indikator ini.</li>
                        <li>Jumlah perkara yang diselesaikan dibandingkan dengan perkara yang harus diselesaikan (sisa awal tahun ditambahkan perkara yang masuk).</li>
                        <li>Jumlah Perkara Yang Ada = Jumlah Perkara Yang Diterima Tahun Berjalan + Sisa Perkara Tahun Sebelumnya.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Datatable JS Dependencies -->
<script src="<?php echo base_url('assets/libs/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'); ?>"></script>

<script>
    $(document).ready(function() {
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
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination");
                $(".dataTables_length select").addClass("form-select form-select-sm");
            }
        });

        // Submit form automatically when dropdown selection changes
        $('#jenis, #periode').on('change', function() {
            $('#filterForm').submit();
        });
    });
</script>
