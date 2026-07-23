<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$selectedStatus = isset($selectedStatus) ? $selectedStatus : 'semua';
$selectedPeriode = isset($selectedPeriode) ? $selectedPeriode : 'tahunan';
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Detail Capaian IKU 1.8</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">e-Capaian</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Kinerja</a></li>
                    <li class="breadcrumb-item active">IKU 1.8</li>
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
                            INDIKATOR KINERJA UTAMA 1.8
                        </span>
                        <h3 class="fw-bold text-dark mb-1">Perkara yang Berhasil Diselesaikan Melalui Mediasi</h3>
                        <p class="text-muted mb-0">Menampilkan rincian, status keberhasilan mediasi oleh mediator hakim maupun non-hakim, dan
                            persentase capaian.</p>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Wajib Dilaksanakan Mediasi</p>
                        <h3 id="stat-total-count" class="fw-bold mb-0 text-dark"><?php echo $totalWajibMediasiCount; ?></h3>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Berhasil Mediasi</p>
                        <h3 id="stat-berhasil" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $berhasilMediasiCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalWajibMediasiCount; ?></span>
                                Perkara</span>
                        </h3>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, rgba(56, 198, 108, 0.08), rgba(46, 168, 91, 0.08));">
                        <i class="fas fa-users"></i>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Tidak Berhasil Mediasi</p>
                        <h3 id="stat-gagal" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $gagalMediasiCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalWajibMediasiCount; ?></span>
                                Perkara</span>
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
                        <h3 id="stat-persentase" class="fw-bold mb-0 text-dark"><?php echo $persentaseBerhasilMediasi; ?>%</h3>
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
                <form id="filterForm" method="GET" action="<?php echo site_url('indicator/iku_1_8'); ?>">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label for="status_mediasi" class="form-label text-muted fs-12 fw-semibold">STATUS MEDIASI</label>
                            <select name="status" id="status_mediasi" class="form-select form-select-md border-light-subtle shadow-sm bg-body-tertiary">
                                <option value="semua" <?php echo $selectedStatus === 'semua' ? 'selected' : ''; ?>>Semua Status</option>
                                <option value="berhasil" <?php echo $selectedStatus === 'berhasil' ? 'selected' : ''; ?>>Berhasil</option>
                                <option value="gagal" <?php echo $selectedStatus === 'gagal' ? 'selected' : ''; ?>>Tidak Berhasil</option>
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
                    <h5 class="card-title fw-bold mb-0 text-dark">Daftar Rincian Perkara (IKU 1.8)</h5>
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
                                <th>Mediator</th>
                                <th>Jenis Mediator</th>
                                <th>Tanggal Mediasi</th>
                                <th>Hasil Mediasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cases)): ?>
                                <?php $no = 1;
                                foreach ($cases as $case): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td class="fw-medium text-dark"><?php echo html_escape($case->getNomorPerkara()); ?></td>
                                        <td><span class="fw-semibold text-dark"><?php echo html_escape($case->getParaPihak()); ?></span></td>
                                        <td><?php echo html_escape($case->getMediator()); ?></td>
                                        <td>
                                            <span class="badge badge-mediator px-2.5 py-1.5 rounded-2 fs-11">
                                                <?php echo html_escape($case->getJenisMediator()); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalMediasi())); ?></td>
                                        <td>
                                            <?php
                                            $hasil = $case->getHasilMediasi();
                                            if (strpos($hasil, 'Berhasil Seluruhnya') !== false) {
                                                echo '<span class="badge badge-berhasil-akta px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-check-double me-1"></i>' . html_escape($hasil) . '</span>';
                                            } else if (strpos($hasil, 'Berhasil Sebagian') !== false) {
                                                echo '<span class="badge badge-berhasil-sebagian px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-check me-1"></i>' . html_escape($hasil) . '</span>';
                                            } else if ($hasil === 'Tidak Berhasil') {
                                                echo '<span class="badge badge-tidak-berhasil px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-times me-1"></i>Tidak Berhasil</span>';
                                            } else {
                                                echo '<span class="badge badge-tidak-dapat px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-user-slash me-1"></i>Tidak Dapat Dilaksanakan</span>';
                                            }
                                            ?>
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
                            <span class="fraction-numerator">Jml Perkara Berhasil Diselesaikan Melalui Mediasi</span>
                            <span class="fraction-denominator">Jml Perkara yang Wajib Dilaksanakan Mediasi</span>
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

                <!-- Catatan Penjelasan -->
                <div>
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10" style="letter-spacing: 0.5px;">Catatan Penjelasan</div>
                    <ol class="catatan-list ps-3 mb-0" style="font-size: 11.5px;">
                        <li class="mb-2">
                            <strong>Perkara yang berhasil diselesaikan mediasi meliputi:</strong>
                            <ul class="ps-3 mt-1 mb-0" style="list-style-type: circle;">
                                <li>Perkara yang berhasil didamaikan seluruhnya dengan akta perdamaian atau pencabutan perkara;</li>
                                <li>Perkara yang berhasil didamaikan sebagian.</li>
                            </ul>
                        </li>
                        <li class="mb-2">Kinerja mediasi dihitung atas keberhasilan mediasi yang dilaksanakan oleh <strong>mediator hakim</strong>
                            ataupun <strong>non hakim</strong>.</li>
                        <li>Jumlah perkara yang wajib dilaksanakan mediasi <strong>tidak termasuk</strong> perkara yang tidak dapat dilaksanakan
                            mediasi karena ketidakhadiran salah satu pihak.</li>
                    </ol>
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
                        $('#stat-total-count').text(response.totalWajibMediasiCount);
                        $('#stat-berhasil .value').text(response.berhasilMediasiCount);
                        $('#stat-berhasil .total-value').text(response.totalWajibMediasiCount);
                        $('#stat-gagal .value').text(response.gagalMediasiCount);
                        $('#stat-gagal .total-value').text(response.totalWajibMediasiCount);
                        $('#stat-persentase').text(response.persentaseBerhasilMediasi + '%');

                        // Update datatable
                        table.clear();
                        if (response.cases && response.cases.length > 0) {
                            $.each(response.cases, function (index, item) {
                                var badgeMediator = '<span class="badge badge-mediator px-2.5 py-1.5 rounded-2 fs-11">' + escapeHtml(item.jenis_mediator) + '</span>';

                                var hasil = item.hasil_mediasi;
                                var badgeHasil = '';
                                if (hasil.indexOf('Berhasil Seluruhnya') !== -1) {
                                    badgeHasil = '<span class="badge badge-berhasil-akta px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-check-double me-1"></i>' + escapeHtml(hasil) + '</span>';
                                } else if (hasil.indexOf('Berhasil Sebagian') !== -1) {
                                    badgeHasil = '<span class="badge badge-berhasil-sebagian px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-check me-1"></i>' + escapeHtml(hasil) + '</span>';
                                } else if (hasil === 'Tidak Berhasil') {
                                    badgeHasil = '<span class="badge badge-tidak-berhasil px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-times me-1"></i>Tidak Berhasil</span>';
                                } else {
                                    badgeHasil = '<span class="badge badge-tidak-dapat px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-user-slash me-1"></i>Tidak Dapat Dilaksanakan</span>';
                                }

                                table.row.add([
                                    index + 1,
                                    '<span class="fw-medium text-dark">' + escapeHtml(item.nomor_perkara) + '</span>',
                                    '<span class="fw-semibold text-dark">' + escapeHtml(item.para_pihak) + '</span>',
                                    escapeHtml(item.mediator),
                                    badgeMediator,
                                    item.tanggal_mediasi,
                                    badgeHasil
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
        $('#status_mediasi, #status, #periode').on('change', function () {
            applyFilter();
        });
    });
</script>