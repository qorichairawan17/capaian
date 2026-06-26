<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Database Migration Dashboard | Capaian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Database Migration Management Panel" name="description" />
    <meta content="Antigravity" name="author" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">

    <!-- dark layout js -->
    <script src="<?php echo base_url('assets/js/pages/layout.js'); ?>"></script>

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url('assets/css/app.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    
    <!-- Google Fonts for outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f4f6fa;
        }
        
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .hero-section {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: white;
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .badge-pulse-success {
            background-color: #d1fae5;
            color: #065f46;
            font-weight: 600;
            padding: 0.5rem 0.8rem;
            border-radius: 30px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
        }

        .badge-pulse-success::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            margin-right: 6px;
            animation: pulse 1.5s infinite;
        }

        .badge-pulse-danger {
            background-color: #fee2e2;
            color: #991b1b;
            font-weight: 600;
            padding: 0.5rem 0.8rem;
            border-radius: 30px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
        }

        .badge-pulse-danger::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            margin-right: 6px;
            animation: pulse 1.5s infinite;
        }

        .badge-pulse-warning {
            background-color: #fef3c7;
            color: #92400e;
            font-weight: 600;
            padding: 0.4rem 0.7rem;
            border-radius: 30px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
        }

        .badge-pulse-warning::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            background-color: #f59e0b;
            border-radius: 50%;
            margin-right: 6px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .table-custom th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6b7280;
            border-bottom: 2px solid #e5e7eb;
        }

        .table-custom td {
            vertical-align: middle;
        }

        .table-custom tbody tr {
            transition: background-color 0.2s ease;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
            transition: all 0.2s ease;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
            color: white;
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
            transform: translateY(-1px);
        }

        .btn-gradient-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(107, 114, 128, 0.2);
            transition: all 0.2s ease;
        }

        .btn-gradient-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            color: white;
            box-shadow: 0 6px 15px rgba(107, 114, 128, 0.3);
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
    <!-- Topbar Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo base_url('migrate'); ?>">
                <img src="<?php echo base_url('assets/images/logo-light.png'); ?>" alt="" height="20" class="me-2">
                <span class="fw-semibold">Migration Desk</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('welcome'); ?>"><i class="mdi mdi-home-outline me-1"></i>Back to Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Hero Title -->
        <div class="hero-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-6 fw-bold mb-2">Database Migration Dashboard</h1>
                    <p class="lead mb-0 text-white-50">Trace, execute, and rollback database schemas using the clean architecture migration system.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <?php if ($status->isEnabled): ?>
                        <span class="badge-pulse-success">MIGRATION ACTIVE</span>
                    <?php else: ?>
                        <span class="badge-pulse-danger">MIGRATION DISABLED</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if ($success_message): ?>
            <div class="alert alert-success alert-dismissible fade show card-custom border-0 border-start border-4 border-success p-3 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-check-circle-outline fs-24 text-success me-2"></i>
                    <div>
                        <h6 class="alert-heading mb-1 fw-bold text-success">Execution Success</h6>
                        <p class="mb-0 text-muted"><?php echo $success_message; ?></p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-dismissible fade show card-custom border-0 border-start border-4 border-danger p-3 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-alert-circle-outline fs-24 text-danger me-2"></i>
                    <div>
                        <h6 class="alert-heading mb-1 fw-bold text-danger">Execution Failure</h6>
                        <p class="mb-0 text-muted"><?php echo $error_message; ?></p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Configuration & Diagnostics Info Cards -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card card-custom h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary-subtle text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="mdi mdi-database fs-24"></i>
                        </div>
                        <div>
                            <span class="text-muted text-uppercase font-size-11 fw-bold">Active Database</span>
                            <h5 class="fw-bold mb-0 mt-1"><?php echo htmlspecialchars($status->databaseName); ?></h5>
                            <small class="text-muted"><?php echo htmlspecialchars($status->databaseHost); ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card card-custom h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-success-subtle text-success rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="mdi mdi-tag-outline fs-24"></i>
                        </div>
                        <div>
                            <span class="text-muted text-uppercase font-size-11 fw-bold">Current Version</span>
                            <h5 class="fw-bold mb-0 mt-1">
                                <?php if ($status->currentVersion === '0'): ?>
                                    <span class="text-warning">0 (Not Initialized)</span>
                                <?php else: ?>
                                    <code class="text-success"><?php echo $status->currentVersion; ?></code>
                                <?php endif; ?>
                            </h5>
                            <small class="text-muted">
                                <?php 
                                if ($status->currentVersion !== '0') {
                                    echo preg_replace('/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1-$2-$3 $4:$5:$6', $status->currentVersion);
                                } else {
                                    echo 'No schema changes applied';
                                }
                                ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 mb-3">
                <div class="card card-custom h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-info-subtle text-info rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="mdi mdi-folder-outline fs-24"></i>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-muted text-uppercase font-size-11 fw-bold">Metadata Properties</span>
                            <h5 class="fw-bold mb-0 mt-1 text-truncate" title="Table: <?php echo htmlspecialchars($status->tableName); ?>">
                                Table: <code><?php echo htmlspecialchars($status->tableName); ?></code>
                            </h5>
                            <small class="text-muted text-truncate d-block" title="<?php echo htmlspecialchars($status->path); ?>">
                                <?php echo htmlspecialchars(str_replace(FCPATH, './', $status->path)); ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls Card -->
        <div class="card card-custom p-4 mb-4">
            <h5 class="fw-bold mb-3 d-flex align-items-center">
                <i class="mdi mdi-play-circle-outline text-primary me-2"></i>
                Migration Commands
            </h5>
            <div class="d-flex flex-wrap gap-3">
                <?php if ($status->isEnabled): ?>
                    <?php echo form_open('migrate/latest', array('class' => 'm-0')); ?>
                        <button type="submit" class="btn btn-gradient-primary px-4 py-2 fw-semibold">
                            <i class="mdi mdi-arrow-up-bold-circle-outline me-1"></i> Migrate to Latest Version
                        </button>
                    <?php echo form_close(); ?>

                    <?php if ($status->currentVersion !== '0'): ?>
                        <?php echo form_open('migrate/version', array('class' => 'm-0', 'id' => 'rollback-zero-form')); ?>
                            <input type="hidden" name="version" value="0">
                            <button type="button" class="btn btn-gradient-secondary px-4 py-2 fw-semibold" onclick="confirmRollbackZero()">
                                <i class="mdi mdi-arrow-down-bold-circle-outline me-1"></i> Rollback All (Reset to 0)
                            </button>
                        <?php echo form_close(); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-warning border-0 m-0 w-100 p-3 card-custom" role="alert">
                        <i class="mdi mdi-alert-outline me-2 fs-16"></i>
                        <strong>Migration is currently disabled!</strong> To execute migration, please open <code>application/config/migration.php</code> and set <code>$config['migration_enabled'] = TRUE;</code>.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Migration Timeline & History -->
        <div class="card card-custom p-4">
            <h5 class="fw-bold mb-4 d-flex align-items-center">
                <i class="mdi mdi-history text-primary me-2"></i>
                Migration History & Local Files
            </h5>

            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Version (Timestamp)</th>
                            <th>Description</th>
                            <th>File Name</th>
                            <th class="text-end">Interactive Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($status->migrations)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="mdi mdi-folder-open-outline d-block fs-36 text-muted mb-2"></i>
                                    No migration files found in <code>application/migrations/</code>.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($status->migrations as $migration): ?>
                                <tr>
                                    <td>
                                        <?php if ($migration->isApplied): ?>
                                            <span class="badge-pulse-success">APPLIED</span>
                                        <?php else: ?>
                                            <span class="badge-pulse-warning">PENDING</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <code class="text-dark fw-semibold"><?php echo $migration->version; ?></code>
                                        <br>
                                        <small class="text-muted">
                                            <?php echo preg_replace('/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1-$2-$3 $4:$5:$6', $migration->version); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <h6 class="fw-bold mb-0 text-dark"><?php echo $migration->name; ?></h6>
                                    </td>
                                    <td>
                                        <small class="text-muted"><i class="mdi mdi-file-code-outline me-1"></i><?php echo $migration->filename; ?></small>
                                    </td>
                                    <td class="text-end">
                                        <?php if ($status->isEnabled): ?>
                                            <?php if ($migration->isApplied): ?>
                                                <!-- Rollback button -->
                                                <?php echo form_open('migrate/version', array('class' => 'd-inline')); ?>
                                                    <!-- In CodeIgniter 3, versioning back rolls back to the SPECIFIED version. 
                                                         So if we specify a version, it will revert all migrations AFTER this version. 
                                                         Hence, we keep this version. -->
                                                    <input type="hidden" name="version" value="<?php echo $migration->version; ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" title="Rollback all migrations executed after this version">
                                                        Keep Up To Here
                                                    </button>
                                                <?php echo form_close(); ?>
                                            <?php else: ?>
                                                <!-- Migrate to here button -->
                                                <?php echo form_open('migrate/version', array('class' => 'd-inline')); ?>
                                                    <input type="hidden" name="version" value="<?php echo $migration->version; ?>">
                                                    <button type="submit" class="btn btn-outline-success btn-sm rounded-pill px-3" title="Migrate up to this specific version">
                                                        Migrate To Here
                                                    </button>
                                                <?php echo form_close(); ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted font-size-12">Disabled</span>
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
        <footer class="text-center text-muted py-5">
            <p class="mb-0">© <?php echo date('Y'); ?> Capaian Application. Powered by Clean Architecture & CodeIgniter 3.</p>
        </footer>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url('assets/libs/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/metismenu/metisMenu.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/simplebar/simplebar.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/libs/node-waves/waves.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>

    <script>
        function confirmRollbackZero() {
            if (confirm("WARNING: Are you absolutely sure you want to rollback all migrations? This will reset your database schema back to version 0, dropping all tables managed by migrations. THIS ACTION CANNOT BE UNDONE.")) {
                document.getElementById('rollback-zero-form').submit();
            }
        }
    </script>
</body>

</html>
