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

    <!-- dark layout js -->
    <script src="<?php echo base_url('assets/js/pages/layout.js'); ?>"></script>

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- simplebar css -->
    <link href="<?php echo base_url('assets/libs/simplebar/simplebar.min.css'); ?>" rel="stylesheet">
    <!-- App Css-->
    <link href="<?php echo base_url('assets/css/app.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Custom Login Css -->
    <link href="<?php echo base_url('assets/css/custom-login.css'); ?>" rel="stylesheet" type="text/css" />

</head>

<body class="login-body">
    <!-- Background glowing decorations -->
    <div class="glow-orb-1"></div>
    <div class="glow-orb-2"></div>

    <div class="container-fluid overflow-hidden position-relative" style="z-index: 1;">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-11 col-sm-8 col-md-6 col-lg-4 col-xxl-3">
                <div class="card card-login mb-0">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h2 class="app-title">e-Capaian</h2>
                            <p class="app-subtitle text-uppercase">Pembantu Rekapitulasi Data Capaian Kinerja</p>
                            <div class="border-bottom border-secondary border-opacity-10 my-3 w-50 mx-auto"></div>
                        </div>

                        <div class="p-1">
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-block-helper me-2"></i>
                                    <?php echo $this->session->flashdata('error'); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (validation_errors()): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-block-helper me-2"></i>
                                    <?php echo validation_errors(); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($is_mock) && $is_mock): ?>
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-information-outline me-2"></i>
                                    <strong>Mock Mode Active:</strong> Use <code>admin</code> / <code>password123</code>.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php echo form_open('auth/login'); ?>
                            <div class="input-group auth-input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="mdi mdi-account-outline fs-18"></i></span>
                                <input type="text" name="username" class="form-control text-white" placeholder="Enter username" aria-label="Username"
                                    aria-describedby="basic-addon1" value="<?php echo set_value('username'); ?>">
                            </div>

                            <div class="input-group auth-input-group mb-4">
                                <span class="input-group-text" id="basic-addon2"><i class="mdi mdi-lock-outline fs-18"></i></span>
                                <input type="password" name="password" class="form-control text-white" id="userpassword" placeholder="Enter password"
                                    aria-label="Password" aria-describedby="basic-addon2">
                            </div>

                            <div class="pt-2 text-center">
                                <button class="btn btn-login w-100 waves-effect waves-light" type="submit">Sign In</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>

                        <div class="text-center footer-text">
                            <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> <strong>e-Capaian</strong>. <br>
                                Made by <a href="#" target="_blank">Qori Chairawan</a>
                            </p>
                        </div>
                    </div>
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

</body>

</html>