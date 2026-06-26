<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login | e-Capaian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pembantu Rekapitulasi Data Capain Kinerja" name="description" />
    <meta content="Qori Chairawan" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url('assets/css/app.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Google Fonts for Outfit (Clean Typography) -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Login Css -->
    <link href="<?php echo base_url('assets/css/custom-login.css'); ?>" rel="stylesheet" type="text/css" />

</head>

<body class="login-body">

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="app-logo">e-Capaian</h1>
                <p class="app-tagline">Pembantu Rekapitulasi Data Capaian Kinerja</p>
            </div>

            <div class="login-body-content">
                <!-- Session Flash Messages -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="custom-alert alert-danger" role="alert">
                        <div class="alert-icon">
                            <i class="mdi mdi-alert-circle-outline"></i>
                        </div>
                        <div class="alert-content">
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Form Validation Errors (Corrected Block Layout) -->
                <?php if (validation_errors()): ?>
                    <div class="custom-alert alert-danger" role="alert">
                        <div class="alert-icon">
                            <i class="mdi mdi-alert-circle-outline"></i>
                        </div>
                        <div class="alert-content">
                            <?php echo validation_errors(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mock Mode Information -->
                <?php if (isset($is_mock) && $is_mock): ?>
                    <div class="custom-alert alert-info" role="alert">
                        <div class="alert-icon">
                            <i class="mdi mdi-information-outline"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Mock Mode Active:</strong> Use <code>admin</code> / <code>password123</code>.
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <?php echo form_open('auth/login'); ?>
                <div class="form-group-custom">
                    <label for="username" class="form-label-custom">Username</label>
                    <div class="input-wrapper-custom">
                        <input type="text" name="username" id="username" class="form-control-custom" placeholder="Enter your username" value="<?php echo set_value('username'); ?>" required>
                        <i class="mdi mdi-account-outline input-icon-custom"></i>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label for="password" class="form-label-custom">Password</label>
                    <div class="input-wrapper-custom">
                        <input type="password" name="password" id="password" class="form-control-custom" placeholder="Enter your password" required>
                        <i class="mdi mdi-lock-outline input-icon-custom"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit-custom">Sign In</button>
                <?php echo form_close(); ?>
            </div>

            <!-- Footer Details -->
            <div class="login-footer">
                <p>&copy; <script>document.write(new Date().getFullYear())</script> <span>e-Capaian</span>. All rights reserved.</p>
                <p class="author-credits">Made with <i class="mdi mdi-heart text-danger"></i> by <strong>Qori Chairawan</strong></p>
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

</body>

</html>