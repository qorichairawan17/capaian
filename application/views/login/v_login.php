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

</head>

<body>
    <div class="container-fluid overflow-hidden">
        <div class="bg-overlay"></div>
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-10 col-md-6 col-lg-4 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center">
                            <h4 class="mt-4">e-Capaian</h4>
                            <p class="text-muted">Pembantu Rekapitulasi Data Capaian Kinerja</p>
                        </div>

                        <div class="p-2 mt-4">
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
                            <div class="input-group auth-form-group-custom mb-3">
                                <span class="input-group-text bg-primary bg-opacity-10 fs-16" id="basic-addon1"><i
                                        class="mdi mdi-account-outline auti-custom-input-icon"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Enter username" aria-label="Username"
                                    aria-describedby="basic-addon1" value="<?php echo set_value('username'); ?>">
                            </div>

                            <div class="input-group auth-form-group-custom mb-3">
                                <span class="input-group-text bg-primary bg-opacity-10 fs-16" id="basic-addon2"><i
                                        class="mdi mdi-lock-outline auti-custom-input-icon"></i></span>
                                <input type="password" name="password" class="form-control" id="userpassword" placeholder="Enter password"
                                    aria-label="Password" aria-describedby="basic-addon2">
                            </div>

                            <div class="pt-3 text-center">
                                <button class="btn btn-primary w-xl waves-effect waves-light" type="submit">Login</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>

                        <div class="mt-5 text-center">
                            <p>&copy;
                                <script>document.write(new Date().getFullYear())</script> e-Capaian.
                                Made by Qori Chairawan
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