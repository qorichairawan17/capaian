<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Detail Capaian IKU 1.6</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">e-Capaian</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Kinerja</a></li>
                    <li class="breadcrumb-item active">IKU 1.6</li>
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
                            INDIKATOR KINERJA UTAMA 1.6
                        </span>
                        <h3 class="fw-bold text-dark mb-1">Persentase Penyelesaian Permohonan Eksekusi Putusan Perdata</h3>
                        <p class="text-muted mb-0">Menampilkan rincian status penyelesaian permohonan eksekusi putusan perdata (Berhasil Eksekusi,
                            Dicabut, maupun Dicoret/Non Executable).</p>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Permohonan Eksekusi Diselesaikan</p>
                        <h3 id="stat-diselesaikan" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $diselesaikanCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalPermohonanCount; ?></span>
                                Permohonan</span>
                        </h3>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, rgba(56, 198, 108, 0.08), rgba(46, 168, 91, 0.08));">
                        <i class="fas fa-gavel"></i>
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
                        <p class="text-muted mb-1 fs-13 fw-medium">Total Dimohonkan Eksekusi</p>
                        <h3 id="stat-total-permohonan" class="fw-bold mb-0 text-dark"><?php echo $totalPermohonanCount; ?></h3>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-file-invoice"></i>
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
                        <p class="text-muted mb-0 fs-13 fw-medium">Persentase Capaian</p>
                        <h3 id="stat-persentase" class="fw-bold mb-0 text-dark"><?php echo $persentaseDiselesaikan; ?>%</h3>
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
                <form id="filterForm" method="GET" action="<?php echo site_url('indicator/iku_1_6'); ?>">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label for="jenis_eksekusi" class="form-label text-muted fs-12 fw-semibold">JENIS EKSEKUSI</label>
                            <select name="jenis_eksekusi" id="jenis_eksekusi"
                                class="form-select form-select-md border-light-subtle shadow-sm bg-body-tertiary">
                                <option value="semua" <?php echo (isset($selectedJenisEksekusi) && $selectedJenisEksekusi === 'semua') ? 'selected' : ''; ?>>Semua Jenis</option>
                                <option value="perkara" <?php echo (isset($selectedJenisEksekusi) && $selectedJenisEksekusi === 'perkara') ? 'selected' : ''; ?>>Eksekusi Terhadap Perkara</option>
                                <option value="hak_tanggungan" <?php echo (isset($selectedJenisEksekusi) && ($selectedJenisEksekusi === 'hak_tanggungan' || $selectedJenisEksekusi === 'ht')) ? 'selected' : ''; ?>>Eksekusi Hak Tanggungan</option>
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
                    <h5 class="card-title fw-bold mb-0 text-dark">Daftar Permohonan Eksekusi Putusan Perdata (IKU 1.6)</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nomor Perkara Eksekusi</th>
                                <th>Jenis Eksekusi</th>
                                <th>Pemohon Eksekusi</th>
                                <th>Termohon Eksekusi</th>
                                <th>Tanggal Permohonan</th>
                                <th>Status Eksekusi</th>
                                <th>Tanggal Selesai</th>
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
                                            <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill fs-11">
                                                <?php echo html_escape($case->getJenisEksekusi()); ?>
                                            </span>
                                        </td>
                                        <td><?php echo html_escape($case->getPemohon()); ?></td>
                                        <td><?php echo html_escape($case->getTermohon()); ?></td>
                                        <td><?php echo date('d M Y', strtotime($case->getTanggalPermohonan())); ?></td>
                                        <td>
                                            <?php
                                            $st = $case->getStatusEksekusi();
                                            if ($st === 'Berhasil Eksekusi') {
                                                echo '<span class="badge badge-done px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-check-circle me-1"></i>Berhasil Eksekusi</span>';
                                            } else if ($st === 'Dicabut') {
                                                echo '<span class="badge badge-cabut px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-undo me-1"></i>Dicabut</span>';
                                            } else if ($st === 'Dicoret / Non Executable') {
                                                echo '<span class="badge badge-dicoret px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-ban me-1"></i>Dicoret / Non Executable</span>';
                                            } else {
                                                echo '<span class="badge badge-process px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-spinner fa-spin me-1"></i>Dalam Proses</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $case->getTanggalSelesai() ? date('d M Y', strtotime($case->getTanggalSelesai())) : '-'; ?>
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
                            <span class="fraction-numerator">Jumlah permohonan eksekusi putusan perdata yang diselesaikan</span>
                            <span class="fraction-denominator">Jumlah putusan perdata yang dimohonkan eksekusi</span>
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
                            <div class="info-list-value">Laporan Bulanan dan Laporan Tahunan</div>
                        </div>
                    </div>
                </div>

                <!-- Catatan Perhitungan -->
                <div>
                    <div class="fw-bold text-uppercase text-secondary mb-2 fs-10" style="letter-spacing: 0.5px;">Catatan Penting</div>
                    <p class="fs-12 text-muted mb-2">Permohonan eksekusi yang diselesaikan meliputi:</p>
                    <ol type="a" class="catatan-list ps-3">
                        <li class="mb-2">Berhasil dilaksanakan eksekusi;</li>
                        <li class="mb-2">Dicabut; dan</li>
                        <li>Dicoret dari register termasuk <i>non executable</i>.</li>
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
                lengthMenu: "Tampilkan _MENU_ permohonan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ permohonan",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 permohonan",
                infoFiltered: "(disaring dari _MAX_ total permohonan)",
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
                        $('#stat-diselesaikan .value').text(response.diselesaikanCount);
                        $('#stat-diselesaikan .total-value').text(response.totalPermohonanCount);
                        $('#stat-total-permohonan').text(response.totalPermohonanCount);
                        $('#stat-persentase').text(response.persentaseDiselesaikan + '%');

                        table.clear();
                        if (response.cases && response.cases.length > 0) {
                            $.each(response.cases, function (index, item) {
                                var st = item.status_eksekusi;
                                var badgeStatus = '';
                                if (st === 'Berhasil Eksekusi') {
                                    badgeStatus = '<span class="badge badge-done px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-check-circle me-1"></i>Berhasil Eksekusi</span>';
                                } else if (st === 'Dicabut') {
                                    badgeStatus = '<span class="badge badge-cabut px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-undo me-1"></i>Dicabut</span>';
                                } else if (st === 'Dicoret / Non Executable') {
                                    badgeStatus = '<span class="badge badge-dicoret px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-ban me-1"></i>Dicoret / Non Executable</span>';
                                } else {
                                    badgeStatus = '<span class="badge badge-process px-2.5 py-1 rounded-pill fs-10" style="font-size: 9.5px !important; padding: 3px 8px !important;"><i class="fas fa-spinner fa-spin me-1"></i>Dalam Proses</span>';
                                }

                                var badgeJenis = '<span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill fs-11">' + escapeHtml(item.jenis_eksekusi) + '</span>';

                                table.row.add([
                                    index + 1,
                                    '<span class="fw-medium text-dark">' + escapeHtml(item.nomor_perkara) + '</span>',
                                    badgeJenis,
                                    escapeHtml(item.pemohon),
                                    escapeHtml(item.termohon),
                                    item.tanggal_permohonan,
                                    badgeStatus,
                                    item.tanggal_selesai
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

        $('#status, #jenis_eksekusi, #periode').on('change', function () {
            applyFilter();
        });
    });
</script>