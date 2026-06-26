<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login | Clivax - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Codebucks" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">


    <!-- dark layout js -->
    <script src="<?php echo base_url('assets/js/pages/layout.js'); ?>"></script>

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- simplebar css -->
    <link href="<?php echo base_url('assets/libs/simplebar/simplebar.min.css'); ?>" rel="stylesheet">
    <!-- App Css-->
    <link href="<?php echo base_url('assets/css/app.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="container-fluid authentication-bg overflow-hidden">
        <div class="bg-overlay"></div>
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-10 col-md-6 col-lg-4 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="index.html" class="logo-dark">
                                <img src="<?php echo base_url('assets/images/logo-dark.png'); ?>" alt="" height="20"
                                    class="auth-logo logo-dark mx-auto">
                            </a>
                            <a href="index.html" class="logo-dark">
                                <img src="<?php echo base_url('assets/images/logo-light.png'); ?>" alt="" height="20"
                                    class="auth-logo logo-light mx-auto">
                            </a>


                            <h4 class="mt-4">Welcome Back !</h4>
                            <p class="text-muted">Sign in to continue to Clivax.</p>
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
                                    <input type="text" name="username" class="form-control" placeholder="Enter username"
                                        aria-label="Username" aria-describedby="basic-addon1" value="<?php echo set_value('username'); ?>">
                                </div>

                                <div class="input-group auth-form-group-custom mb-3">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16" id="basic-addon2"><i
                                            class="mdi mdi-lock-outline auti-custom-input-icon"></i></span>
                                    <input type="password" name="password" class="form-control" id="userpassword"
                                        placeholder="Enter password" aria-label="Password"
                                        aria-describedby="basic-addon2">
                                </div>

                                <div class="mb-sm-5">
                                    <div class="form-check float-sm-start">
                                        <input type="checkbox" class="form-check-input" id="customControlInline">
                                        <label class="form-check-label" for="customControlInline">Remember me</label>
                                    </div>
                                    <div class="float-sm-end">
                                        <a href="#" class="text-muted"><i
                                                class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                    </div>
                                </div>

                                <div class="pt-3 text-center">
                                    <button class="btn btn-primary w-xl waves-effect waves-light" type="submit">Log
                                        In</button>
                                </div>

                                <div class="mt-3 text-center">
                                    <p class="mb-0">Don't have an account ? <a href="#"
                                            class="fw-medium text-primary"> Register </a> </p>
                                </div>

                                <div class="mt-4 text-center">
                                    <div class="signin-other-title position-relative">
                                        <h5 class="mb-0 title">or</h5>
                                    </div>
                                    <div class="mt-4 pt-1 hstack gap-3">
                                        <div class="vstack gap-2">
                                            <button type="button" class="btn btn-label-info d-block"><i
                                                    class="ri-facebook-fill fs-18 align-middle me-2"></i>Sign in with
                                                facebook</button>
                                            <button type="button" class="btn btn-label-danger d-block"><i
                                                    class="ri-google-fill fs-18 align-middle me-2"></i>Sign in with
                                                google</button>
                                        </div>
                                        <div class="vstack gap-2">
                                            <button type="button" class="btn btn-label-dark d-block"><i
                                                    class="ri-github-fill fs-18 align-middle me-2"></i>Sign in with
                                                github</button>
                                            <button type="button" class="btn btn-label-success d-block"><i
                                                    class="ri-twitter-fill fs-18 align-middle me-2"></i>Sign in with
                                                twitter</button>
                                        </div>

                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>

                        <div class="mt-5 text-center">
                            <p>©
                                <script>document.write(new Date().getFullYear())</script> Clivax. Crafted with <i
                                    class="mdi mdi-heart text-danger"></i> by Codubucks
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