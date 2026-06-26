<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Dashboard Migrasi Database | e-Capaian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Panel Manajemen Migrasi Database" name="description" />
    <meta content="Qori Chairawan" name="author" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url('assets/css/app.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    
    <!-- Google Fonts for Outfit (Clean & Minimalist typography) -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Migrate Css -->
    <link href="<?php echo base_url('assets/css/custom-migrate.css'); ?>" rel="stylesheet" type="text/css" />
</head>

<body class="migrate-body">
    <!-- Topbar Navigation -->
    <nav class="migrate-nav">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="brand" href="<?php echo base_url('migrate'); ?>">
                <span>e-Capaian</span>&nbsp;Desk Migrasi
            </a>
            <div>
                <a class="nav-link" href="<?php echo base_url('welcome'); ?>">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="migrate-container">
        <!-- Header Section -->
        <div class="migrate-header-section">
            <div>
                <h1 class="migrate-title">Migrasi Database</h1>
                <p class="migrate-subtitle">Lacak, jalankan, dan kembalikan skema basis data menggunakan sistem migrasi arsitektur bersih.</p>
            </div>
            <div>
                <?php if ($status->isEnabled): ?>
                    <span class="badge-clean-success">MIGRASI AKTIF</span>
                <?php else: ?>
                    <span class="badge-clean-danger">MIGRASI DINONAKTIFKAN</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if ($success_message): ?>
            <div class="custom-alert-banner alert-success alert-dismissible fade show" role="alert">
                <div class="alert-icon">
                    <i class="mdi mdi-check-circle-outline"></i>
                </div>
                <div class="alert-content">
                    <strong>Sukses:</strong> <?php echo $success_message; ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="custom-alert-banner alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-icon">
                    <i class="mdi mdi-alert-circle-outline"></i>
                </div>
                <div class="alert-content">
                    <strong>Gagal:</strong> <?php echo $error_message; ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Configuration & Diagnostics Grid -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="diagnostic-card d-flex align-items-center">
                    <div class="icon-wrapper icon-primary me-3">
                        <i class="mdi mdi-database"></i>
                    </div>
                    <div>
                        <div class="label">Database Aktif</div>
                        <div class="value"><?php echo htmlspecialchars($status->databaseName); ?></div>
                        <div class="subtext text-muted"><?php echo htmlspecialchars($status->databaseHost); ?></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="diagnostic-card d-flex align-items-center">
                    <div class="icon-wrapper icon-success me-3">
                        <i class="mdi mdi-tag-outline"></i>
                    </div>
                    <div>
                        <div class="label">Versi Saat Ini</div>
                        <div class="value">
                            <?php if ($status->currentVersion === '0'): ?>
                                <span class="text-warning">0 (Belum Diinisialisasi)</span>
                            <?php else: ?>
                                <code><?php echo $status->currentVersion; ?></code>
                            <?php endif; ?>
                        </div>
                        <div class="subtext text-muted">
                            <?php 
                            if ($status->currentVersion !== '0') {
                                echo preg_replace('/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1-$2-$3 $4:$5:$6', $status->currentVersion);
                            } else {
                                echo 'Belum ada perubahan skema yang diterapkan';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 mb-3">
                <div class="diagnostic-card d-flex align-items-center">
                    <div class="icon-wrapper icon-info me-3">
                        <i class="mdi mdi-folder-outline"></i>
                    </div>
                    <div class="overflow-hidden">
                        <div class="label">Tabel & Path Metadata</div>
                        <div class="value text-truncate" title="Table: <?php echo htmlspecialchars($status->tableName); ?>">
                            <code><?php echo htmlspecialchars($status->tableName); ?></code>
                        </div>
                        <div class="subtext text-muted text-truncate" title="<?php echo htmlspecialchars($status->path); ?>">
                            <?php echo htmlspecialchars(str_replace(FCPATH, './', $status->path)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls Card -->
        <div class="migrate-card">
            <h5 class="migrate-card-title">
                <i class="mdi mdi-play-circle-outline"></i>
                Tindakan Migrasi
            </h5>
            <div class="d-flex flex-wrap gap-3">
                <?php if ($status->isEnabled): ?>
                    <?php echo form_open('migrate/latest', array('class' => 'm-0')); ?>
                        <button type="submit" class="btn-migrate-primary">
                            <i class="mdi mdi-arrow-up-bold-circle-outline"></i> Migrasi ke Versi Terbaru
                        </button>
                    <?php echo form_close(); ?>

                    <?php if ($status->currentVersion !== '0'): ?>
                        <?php echo form_open('migrate/version', array('class' => 'm-0', 'id' => 'rollback-zero-form')); ?>
                            <input type="hidden" name="version" value="0">
                            <button type="button" class="btn-migrate-secondary" onclick="showRollbackConfirm('rollback-zero-form', 'Apakah Anda yakin ingin membatalkan semua migrasi? Ini akan menyetel skema database Anda kembali ke versi 0, menghapus seluruh tabel yang dikelola oleh migrasi. Tindakan ini tidak dapat dibatalkan.')">
                                <i class="mdi mdi-arrow-down-bold-circle-outline"></i> Kembalikan Semua (Reset ke 0)
                            </button>
                        <?php echo form_close(); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="custom-alert-banner alert-danger m-0 w-100" role="alert">
                        <div class="alert-icon">
                            <i class="mdi mdi-alert-outline"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Migrasi saat ini dinonaktifkan!</strong> Untuk menjalankan migrasi, silakan buka <code>application/config/migration.php</code> dan atur <code>$config['migration_enabled'] = TRUE;</code>.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Migration Timeline & History -->
        <div class="migrate-card">
            <h5 class="migrate-card-title">
                <i class="mdi mdi-history"></i>
                Riwayat Migrasi & File Skema
            </h5>

            <div class="table-responsive">
                <table class="table table-migrate">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 25%;">Versi (Timestamp)</th>
                            <th style="width: 25%;">Deskripsi</th>
                            <th style="width: 20%;">Nama File</th>
                            <th style="width: 15%; text-align: right;">Kontrol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($status->migrations)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="mdi mdi-folder-open-outline d-block fs-36 mb-2" style="color: #cbd5e1;"></i>
                                    Tidak ditemukan file migrasi di dalam folder <code>application/migrations/</code>.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($status->migrations as $migration): ?>
                                <tr>
                                    <td>
                                        <?php if ($migration->isApplied): ?>
                                            <span class="badge-clean-success">Diterapkan</span>
                                        <?php else: ?>
                                            <span class="badge-clean-warning">Tertunda</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <code class="text-dark fw-bold"><?php echo $migration->version; ?></code>
                                        <br>
                                        <small class="text-muted">
                                            <?php echo preg_replace('/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1-$2-$3 $4:$5:$6', $migration->version); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark"><?php echo $migration->name; ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted"><i class="mdi mdi-file-code-outline me-1"></i><?php echo $migration->filename; ?></small>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php if ($status->isEnabled): ?>
                                            <?php if ($migration->isApplied): ?>
                                                <!-- Rollback button -->
                                                <?php echo form_open('migrate/version', array('class' => 'd-inline', 'id' => 'rollback-form-' . $migration->version)); ?>
                                                    <input type="hidden" name="version" value="<?php echo $migration->version; ?>">
                                                    <button type="button" class="btn-action-outline-danger" onclick="showRollbackConfirm('rollback-form-<?php echo $migration->version; ?>', 'Apakah Anda yakin ingin mempertahankan skema database hanya sampai versi <?php echo $migration->version; ?>? Seluruh migrasi yang dijalankan setelah versi ini akan dibatalkan/di-rollback.')" title="Rollback semua migrasi yang dijalankan setelah versi ini">
                                                        Pertahankan Sampai Sini
                                                    </button>
                                                <?php echo form_close(); ?>
                                            <?php else: ?>
                                                <!-- Migrate to here button -->
                                                <?php echo form_open('migrate/version', array('class' => 'd-inline')); ?>
                                                    <input type="hidden" name="version" value="<?php echo $migration->version; ?>">
                                                    <button type="submit" class="btn-action-outline-success" title="Migrasikan naik sampai versi spesifik ini">
                                                        Migrasikan Ke Sini
                                                    </button>
                                                <?php echo form_close(); ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="btn-action-disabled">Dinonaktifkan</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center text-muted py-1" style="border-top: 1px solid #f1f5f9; margin-top: 3rem;">
            <p class="mb-1" style="font-size: 0.82rem;">&copy; <?php echo date('Y'); ?> <strong>e-Capaian</strong>. Hak Cipta Dilindungi.</p>
            <p class="mb-0" style="font-size: 0.78rem;">Dibuat oleh Qori Chairawan</p>
        </footer>
    </div>

    <!-- Rollback Confirmation Modal -->
    <div class="modal fade" id="rollbackModal" tabindex="-1" aria-labelledby="rollbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 16px;">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger d-flex align-items-center" id="rollbackModalLabel">
                        <i class="mdi mdi-alert-circle-outline fs-24 me-2"></i> Konfirmasi Rollback
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0 text-muted" id="rollbackModalMessage">Tindakan ini akan merubah skema database Anda. Apakah Anda yakin ingin melanjutkannya?</p>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn-migrate-secondary py-2 px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmRollbackBtn" class="btn-migrate-primary bg-danger hover-bg-danger py-2 px-3">Ya, Rollback</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url('assets/libs/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/metismenu/metisMenu.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/simplebar/simplebar.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/node-waves/waves.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>

    <script>
        let formToSubmit = null;

        function showRollbackConfirm(formId, message) {
            formToSubmit = document.getElementById(formId);
            document.getElementById('rollbackModalMessage').innerText = message;
            
            // Show bootstrap modal
            const rollbackModal = new bootstrap.Modal(document.getElementById('rollbackModal'));
            rollbackModal.show();
        }

        document.getElementById('confirmRollbackBtn').addEventListener('click', function() {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });
    </script>
</body>

</html>