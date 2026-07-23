<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>
        <?= isset($title) ? html_escape($title) : 'e-Capaian' ?> - e-Capaian
    </title>
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
    <!-- Custom Dashboard Css -->
    <link href="<?php echo base_url('assets/css/custom-dashboard.css?v=' . time()); ?>" rel="stylesheet" type="text/css" />

    <!-- Dynamic page-specific CSS -->
    <?php if (isset($extra_css) && is_array($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link href="<?php echo base_url($css); ?>" rel="stylesheet" type="text/css" />
        <?php endforeach; ?>
    <?php endif; ?>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">


        <!-- Start topbar -->
        <header id="page-topbar">
            <div class="navbar-header">

                <!-- Logo -->

                <!-- Start Navbar-Brand -->
                <div class="navbar-logo-box">
                    <a href="<?php echo site_url('dashboard'); ?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <span class="logo-text fw-bold text-dark fs-20">e-C</span>
                        </span>
                        <span class="logo-lg">
                            <span class="logo-text fw-bold text-primary fs-22">e-Capaian</span>
                        </span>
                    </a>

                    <a href="<?php echo site_url('dashboard'); ?>" class="logo logo-light">
                        <span class="logo-sm">
                            <span class="logo-text fw-bold text-white fs-20">e-C</span>
                        </span>
                        <span class="logo-lg">
                            <span class="logo-text fw-bold text-white fs-22">e-Capaian</span>
                        </span>
                    </a>

                    <button type="button" class="btn btn-sm top-icon sidebar-btn" id="sidebar-btn">
                        <i class="mdi mdi-menu-open align-middle fs-19"></i>
                    </button>
                </div>
                <!-- End navbar brand -->

                <!-- Start menu -->
                <div class="d-flex justify-content-end menu-sm px-3 ms-auto">

                    <div class="d-flex align-items-center gap-2">

                        <!-- Start Activities -->
                        <div class="d-inline-block activities">
                            <button type="button" class="btn btn-sm top-icon" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-rightsidabar">
                                <i class="fas fa-table align-middle"></i>
                            </button>
                        </div>
                        <!-- End Activities -->

                        <!-- Start Profile -->
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-sm top-icon p-0" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img class="rounded avatar-2xs p-0" src="<?php echo base_url('assets/images/users/avatar-6.png'); ?>"
                                    alt="Header Avatar">
                            </button>
                            <div class="dropdown-menu dropdown-menu-wide dropdown-menu-end dropdown-menu-animated overflow-hidden py-0">
                                <div class="card border-0">
                                    <div class="card-header bg-primary rounded-0">
                                        <div class="rich-list-item w-100 p-0">
                                            <div class="rich-list-prepend">
                                                <div class="avatar avatar-label-light avatar-circle">
                                                    <div class="avatar-display"><i class="fa fa-user-alt"></i></div>
                                                </div>
                                            </div>
                                            <div class="rich-list-content">
                                                <h3 class="rich-list-title text-white">
                                                    <?= html_escape($this->session->userdata('name') ?: 'Charlie Stone') ?>
                                                </h3>
                                                <span
                                                    class="rich-list-subtitle text-white"><?= html_escape($this->session->userdata('email') ?: 'admin@codubucks.in') ?></span>
                                            </div>
                                            <div class="rich-list-append"><span class="badge badge-label-light fs-6">6+</span></div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="grid-nav grid-nav-flush grid-nav-action grid-nav-no-rounded">
                                            <div class="grid-nav-row">
                                                <a href="#" class="grid-nav-item">
                                                    <div class="grid-nav-icon"><i class="far fa-address-card"></i></div>
                                                    <span class="grid-nav-content">Profile</span>
                                                </a>
                                                <a href="#!" class="grid-nav-item">
                                                    <div class="grid-nav-icon"><i class="far fa-comments"></i></div>
                                                    <span class="grid-nav-content">Messages</span>
                                                </a>
                                                <a href="#!" class="grid-nav-item">
                                                    <div class="grid-nav-icon"><i class="far fa-clone"></i></div>
                                                    <span class="grid-nav-content">Activities</span>
                                                </a>
                                            </div>
                                            <div class="grid-nav-row">
                                                <a href="#!" class="grid-nav-item">
                                                    <div class="grid-nav-icon"><i class="far fa-calendar-check"></i>
                                                    </div>
                                                    <span class="grid-nav-content">Tasks</span>
                                                </a>
                                                <a href="#!" class="grid-nav-item">
                                                    <div class="grid-nav-icon"><i class="far fa-sticky-note"></i></div>
                                                    <span class="grid-nav-content">Notes</span>
                                                </a>
                                                <a href="#!" class="grid-nav-item">
                                                    <div class="grid-nav-icon"><i class="far fa-bell"></i></div>
                                                    <span class="grid-nav-content">Notification</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer card-footer-bordered rounded-0"><a href="<?php echo site_url('auth/logout'); ?>"
                                            class="btn btn-label-danger">Sign out</a></div>
                                </div>
                            </div>
                        </div>
                        <!-- End Profile -->
                    </div>
                </div>
                <!-- End menu -->
            </div>
        </header>
        <!-- End topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="sidebar-left">

            <div data-simplebar class="h-100">

                <!--- Sidebar-menu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="left-menu list-unstyled" id="side-menu">
                        <li>
                            <a href="<?php echo site_url('dashboard'); ?>" class="">
                                <i class="fas fa-home"></i>
                                <span>Beranda</span>
                            </a>
                        </li>

                        <li class="menu-title">Manajemen Akun</li>

                        <li>
                            <a href="<?php echo site_url('usermanagement'); ?>" class="">
                                <i class="fas fa-users-cog"></i>
                                <span>Akun</span>
                            </a>
                        </li>

                        <li class="menu-title">Manajemen Target</li>

                        <li>
                            <a href="#" class="">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Target Tahunan</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="">
                                <i class="fas fa-chart-pie"></i>
                                <span>Target Triwulan</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="">
                                <i class="fas fa-calendar-minus"></i>
                                <span>Target Perbulan</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->