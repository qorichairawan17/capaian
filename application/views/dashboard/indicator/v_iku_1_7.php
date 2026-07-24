<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Detail Capaian IKU 1.7</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">e-Capaian</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Kinerja</a></li>
                    <li class="breadcrumb-item active">IKU 1.7</li>
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
                            INDIKATOR KINERJA UTAMA 1.7
                        </span>
                        <h3 class="fw-bold text-dark mb-1">Perkara yang Berhasil Diselesaikan Melalui Pendekatan Keadilan Restoratif</h3>
                        <p class="text-muted mb-0">Menampilkan rincian, kriteria penerapannya (PERMA 1 Tahun 2024), dan rasio keberhasilan Restorative Justice.</p>
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
                            <span class="fraction-numerator">Jml Perkara Berhasil Diselesaikan Melalui Keadilan Restoratif</span>
                            <span class="fraction-denominator">Jml Perkara Memenuhi Kriteria Penerapan Keadilan Restoratif</span>
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

                <!-- Dasar Hukum & Kriteria -->
                <div class="mb-4">
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10" style="letter-spacing: 0.5px;">Dasar Hukum & Kriteria</div>
                    <div class="dasar-hukum-box">
                        <p class="fs-12 fw-semibold text-dark mb-2">PERMA Nomor 1 Tahun 2024 tentang Pedoman Mengadili Perkara Pidana berdasarkan Keadilan Restoratif.</p>
                        <p class="fs-11 text-muted fw-bold mb-1">Ketentuan Kinerja Penerapan Keadilan Restoratif:</p>
                        <ol class="catatan-list ps-3 mb-0" style="font-size: 11.5px;">
                            <li class="mb-1.5">Tindak pidana ringan atau kerugian Korban bernilai &le; Rp2.500.000,00 atau UMP setempat.</li>
                            <li class="mb-1.5">Tindak pidana merupakan delik aduan.</li>
                            <li class="mb-1.5">Tindak pidana dengan ancaman hukuman maksimal 5 tahun penjara (termasuk jinayat qanun).</li>
                            <li class="mb-1.5">Tindak pidana dengan pelaku Anak yang diversinya tidak berhasil.</li>
                            <li>Tindak pidana lalu lintas yang berupa kejahatan.</li>
                        </ol>
                    </div>
                </div>

                <!-- Pengecualian & Syarat Keberhasilan -->
                <div>
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10" style="letter-spacing: 0.5px;">Pengecualian & Keberhasilan</div>
                    <p class="fs-11 text-danger fw-bold mb-1">Hakim Tidak Berwenang Menerapkan Keadilan Restoratif Dalam Hal:</p>
                    <ul class="catatan-list ps-3 mb-3 text-muted" style="font-size: 11.5px; list-style-type: disc;">
                        <li>Korban atau terdakwa menolak untuk melakukan perdamaian.</li>
                        <li>Terdapat relasi kuasa.</li>
                        <li>Terdakwa mengulangi tindak pidana sejenis (residivis 3 tahun).</li>
                    </ul>

                    <p class="fs-11 text-success fw-bold mb-1">Keberhasilan Berdasarkan PERMA 1/2024:</p>
                    <ul class="catatan-list ps-3 mb-0 text-muted" style="font-size: 11.5px; list-style-type: circle;">
                        <li>Pemulihan korban dipertimbangkan dalam putusan.</li>
                        <li>Penjatuhan pidana percobaan, pengawasan, atau kerja sosial.</li>
                    </ul>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Kriteria Restorative Justice</p>
                        <h3 id="stat-kriteria-count" class="fw-bold mb-0 text-dark"><?php echo $kriteriaRjCount; ?></h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-balance-scale"></i>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Berhasil RJ</p>
                        <h3 id="stat-berhasil-rj" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $berhasilRjCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $kriteriaRjCount; ?></span> Perkara</span>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Tidak Berhasil RJ</p>
                        <h3 id="stat-tidak-berhasil-rj" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $tidakBerhasilRjCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $kriteriaRjCount; ?></span> Perkara</span>
                        </h3>
                    </div>
                    <div class="stat-icon"
                        style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.08), rgba(248, 113, 113, 0.08)); color: #ef4444;">
                        <i class="fas fa-times-circle"></i>
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
                        <h3 id="stat-persentase" class="fw-bold mb-0 text-dark"><?php echo $persentaseBerhasilRj; ?>%</h3>
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
                <form id="filterForm" method="GET" action="<?php echo site_url('indicator/iku_1_7'); ?>">
                    <div class="row align-items-end g-3">
                        <div class="col-md-8">
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
                    <h5 class="card-title fw-bold mb-0 text-dark">Daftar Rincian Perkara (IKU 1.7)</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nomor Perkara</th>
                                <th>Terdakwa</th>
                                <th>Kategori Kriteria</th>
                                <th>Tanggal Registrasi</th>
                                <th>Tanggal Putusan</th>
                                <th>Status Restorative Justice</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cases)): ?>
                                <?php $no = 1;
                                foreach ($cases as $case): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td class="fw-medium text-dark"><?php echo html_escape($case->getNomorPerkara()); ?></td>
                                        <td><span class="fw-semibold text-dark"><?php echo html_escape($case->getTerdakwa()); ?></span></td>
                                        <td>
                                            <span class="badge badge-kategori px-2.5 py-1.5 rounded-2 fs-11">
                                                <?php echo html_escape($case->getKategoriKriteria()); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalRegistrasi())); ?></td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalPutusan())); ?></td>
                                        <td>
                                            <?php if ($case->isBerhasil()): ?>
                                                <span class="badge badge-berhasil px-2.5 py-1 rounded-pill fs-10"
                                                    style="font-size: 9.5px !important; padding: 3px 8px !important;">
                                                    <i class="fas fa-check me-1"></i>Berhasil RJ
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-gagal px-2.5 py-1 rounded-pill fs-10"
                                                    style="font-size: 9.5px !important; padding: 3px 8px !important;">
                                                    <i class="fas fa-times me-1"></i>Tidak Berhasil
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
</div>

<script>
    // Execute when DOM is fully loaded and all dependencies are ready
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
                        $('#stat-total-count').text(response.totalMemenuhiKriteriaCount);
                        $('#stat-berhasil .value').text(response.berhasilRjCount);
                        $('#stat-berhasil .total-value').text(response.totalMemenuhiKriteriaCount);
                        $('#stat-gagal .value').text(response.gagalRjCount);
                        $('#stat-gagal .total-value').text(response.totalMemenuhiKriteriaCount);
                        $('#stat-persentase').text(response.persentaseBerhasilRj + '%');

                        // Update datatable
                        table.clear();
                        if (response.cases && response.cases.length > 0) {
                            $.each(response.cases, function (index, item) {
                                var badgeKategori = '<span class="badge badge-kategori px-2.5 py-1.5 rounded-2 fs-11">' + escapeHtml(item.kategori_kriteria) + '</span>';

                                var badgeStatus = item.status_rj === 'Berhasil'
                                    ? '<span class="badge badge-berhasil px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-check me-1"></i>Berhasil RJ</span>'
                                    : '<span class="badge badge-gagal px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-times me-1"></i>Tidak Berhasil</span>';

                                table.row.add([
                                    index + 1,
                                    '<span class="fw-medium text-dark">' + escapeHtml(item.nomor_perkara) + '</span>',
                                    '<span class="fw-semibold text-dark">' + escapeHtml(item.terdakwa) + '</span>',
                                    badgeKategori,
                                    item.tanggal_registrasi,
                                    item.tanggal_putusan,
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

        // Form submission behavior
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            applyFilter();
        });

        // Trigger filter on dropdown changes automatically
        $('#periode').on('change', function () {
            applyFilter();
        });
    });
</script>
