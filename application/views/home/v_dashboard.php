<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Starter page | e-Capaian - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pembantu Rekapitulasi Data Capain Kinerja" name="description" />
    <meta content="Qori Chairawan" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- dark layout js -->
    <script src="assets/js/pages/layout.js"></script>

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- simplebar css -->
    <link href="assets/libs/simplebar/simplebar.min.css" rel="stylesheet">
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

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
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="logo-sm-dark" height="20">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-dark.png" alt="logo-dark" height="18">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="logo-sm-light" height="20">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-light.png" alt="logo-light" height="18">
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
                                <img class="rounded avatar-2xs p-0" src="assets/images/users/avatar-6.png" alt="Header Avatar">
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
                                                <h3 class="rich-list-title text-white">Charlie Stone</h3>
                                                <span class="rich-list-subtitle text-white">admin@codubucks.in</span>
                                            </div>
                                            <div class="rich-list-append"><span class="badge badge-label-light fs-6">6+</span></div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="grid-nav grid-nav-flush grid-nav-action grid-nav-no-rounded">
                                            <div class="grid-nav-row">
                                                <a href="apps-contact.html" class="grid-nav-item">
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
                                    <div class="card-footer card-footer-bordered rounded-0"><a href="auth-login.html"
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
                            <a href="index.html" class="">
                                <i class="fas fa-desktop"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-title">Elements</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow ">
                                <i class="fa fa-palette"></i>
                                <span>Base</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="ui-accordions.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>Accordions</a></li>
                                <li><a href="ui-alerts.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Alerts</a></li>
                                <li><a href="ui-badge.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Badges</a></li>
                                <li><a href="ui-breadcrumb.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Breadcrumb</a></li>
                                <li><a href="ui-buttons.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Buttons</a></li>
                                <li><a href="ui-buttons-group.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Button Group</a>
                                </li>
                                <li><a href="ui-cards.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Cards</a></li>
                                <li><a href="ui-colors.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Colors</a></li>
                                <li><a href="ui-dropdowns.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Dropdowns</a></li>
                                <li><a href="ui-list-group.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> List Group</a></li>
                                <li><a href="ui-maker.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>Makers</a></li>
                                <li><a href="ui-modals.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Modals</a></li>
                                <li><a href="ui-nav.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Navigation</a></li>
                                <li><a href="ui-offcanvas.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Offcavas</a></li>
                                <li><a href="ui-pagination.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Pagination</a></li>
                                <li><a href="ui-placeholder.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Placeholder</a></li>
                                <li><a href="ui-popover.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Popover</a></li>
                                <li><a href="ui-progress-bars.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Progress bar</a>
                                </li>
                                <li><a href="ui-spinner.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Spinners</a></li>
                                <li><a href="ui-tabs.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Tabs</a></li>
                                <li><a href="ui-tables.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Tables</a></li>
                                <li><a href="ui-tooltip.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Tooltips</a></li>
                                <li><a href="ui-typography.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Typography</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow ">
                                <i class="fa fa-adjust"></i>
                                <span>Advanced</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="ui-avatar.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Avatar</a></li>
                                <li><a href="ui-blockUI.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Block UI</a></li>
                                <li><a href="ui-slick-carousel.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Carousel</a></li>
                                <li><a href="ui-chat.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Chat</a></li>
                                <li><a href="ui-context-menu.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Context menu</a>
                                </li>
                                <li><a href="ui-grid-nav.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Grid nav</a></li>
                                <li><a href="ui-rich-list.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Rich list</a></li>
                                <li><a href="ui-sortable.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Sortable</a></li>
                                <li><a href="ui-sweet-alert.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Sweetalert 2</a>
                                </li>
                                <li><a href="ui-timeline.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Timeline</a></li>
                                <li><a href="ui-toaster.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Toaster</a></li>
                                <li><a href="ui-treeview.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Tree View</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="fa fa-icons"></i>
                                <span>Icons</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="icons-materialdesign.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Material Design</a>
                                </li>
                                <li><a href="icons-fontawesome.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Font awesome 5</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow ">
                                <i class="fa fa-window-restore"></i>
                                <span>Cards</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="ui-card-base.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Base</a></li>
                                <li><a href="ui-card-draggable.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Draggable</a></li>
                                <li><a href="ui-card-tab.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Tab</a></li>
                                <li><a href="ui-card-tool.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Tool</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow ">
                                <i class="fa fa-shapes"></i>
                                <span>Widget</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="widget-general.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> General</a></li>
                                <li><a href="widget-chart.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Chart</a></li>
                            </ul>
                        </li>

                        <li class="menu-title">Data</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow "><i class="fa fa-chart-pie align-middle"></i> Apexcharts</a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="charts-apex-line.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Line</a></li>
                                <li><a href="charts-apex-area.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Area</a></li>
                                <li><a href="charts-apex-column.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Column</a></li>
                                <li><a href="charts-apex-bar.html"><i class="mdi mdi-checkbox-blank-circle"></i> Bar</a>
                                </li>
                                <li><a href="charts-apex-mixed.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Mixed/Combo</a></li>
                                <li><a href="charts-apex-range.html"><i class="mdi mdi-checkbox-blank-circle"></i> Range
                                        Area</a></li>
                                <li><a href="charts-apex-timeline.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Timeline</a></li>
                                <li><a href="charts-apex-candle.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Candlestick</a></li>
                                <li><a href="charts-apex-box&whisker.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Box & Whisker</a></li>
                                <li><a href="charts-apex-pie.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Pie/Donut</a></li>
                                <li><a href="charts-apex-radar.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Radar</a></li>
                                <li><a href="charts-apex-polar.html"><i class="mdi mdi-checkbox-blank-circle"></i> Polar
                                        Area</a></li>
                                <li><a href="charts-apex-radial.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Radial/Circle</a></li>
                                <li><a href="charts-apex-bubble.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Bubble</a></li>
                                <li><a href="charts-apex-scatter.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Scatter</a></li>
                                <li><a href="charts-apex-heatmap.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Heatmap</a></li>
                                <li><a href="charts-apex-treemap.html"><i class="mdi mdi-checkbox-blank-circle"></i>
                                        Treemap</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow ">
                                <i class="fas fa-table"></i>
                                <span>Datatable</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow "><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Basic</a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="datatable-base.html"><i class="mdi mdi-circle-outline"></i>
                                                Base</a></li>
                                        <li><a href="datatable-footer.html"><i class="mdi mdi-circle-outline"></i>
                                                Footer</a></li>
                                        <li><a href="datatable-scrollable.html"><i class="mdi mdi-circle-outline"></i>
                                                Scrollable</a></li>
                                        <li><a href="datatable-pagination.html"><i class="mdi mdi-circle-outline"></i>
                                                Pagination</a></li>
                                        <li><a href="datatable-page-length.html"><i class="mdi mdi-circle-outline"></i>
                                                Length menu</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#!" class="has-arrow "><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Advanced</a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="datatable-adv-col-render.html"><i class="mdi mdi-circle-outline"></i> Column rendering</a></li>
                                        <li><a href="datatable-adv-col-visibility.html"><i class="mdi mdi-circle-outline"></i> Column visibility</a>
                                        </li>
                                        <li><a href="datatable-adv-footer-callback.html"><i class="mdi mdi-circle-outline"></i> Footer callback</a>
                                        </li>
                                        <li><a href="datatable-adv-multi-control.html"><i class="mdi mdi-circle-outline"></i> Multiple controls</a>
                                        </li>
                                        <li><a href="datatable-adv-row-callback.html"><i class="mdi mdi-circle-outline"></i> Row callback</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#!" class="has-arrow "><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Extension</a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="datatable-ext-autofill.html"><i class="mdi mdi-circle-outline"></i>
                                                Auto fill</a></li>
                                        <li><a href="datatable-ext-buttons.html"><i class="mdi mdi-circle-outline"></i>
                                                Buttons</a></li>
                                        <li><a href="datatable-ext-col-reorder.html"><i class="mdi mdi-circle-outline"></i> Column reorder</a></li>
                                        <li><a href="datatable-ext-fixed-header.html"><i class="mdi mdi-circle-outline"></i> Fixed header</a></li>
                                        <li><a href="datatable-ext-fixed-column.html"><i class="mdi mdi-circle-outline"></i> Fixed column</a></li>
                                        <li><a href="datatable-ext-keytable.html"><i class="mdi mdi-circle-outline"></i>
                                                Key table</a></li>
                                        <li><a href="datatable-ext-row-group.html"><i class="mdi mdi-circle-outline"></i> Row group</a></li>
                                        <li><a href="datatable-ext-row-reorder.html"><i class="mdi mdi-circle-outline"></i> Row reorder</a></li>
                                        <li><a href="datatable-ext-scrollable.html"><i class="mdi mdi-circle-outline"></i> Scrollable</a></li>
                                        <li><a href="datatable-ext-searchpanes.html"><i class="mdi mdi-circle-outline"></i> Search panes</a></li>
                                        <li><a href="datatable-ext-select.html"><i class="mdi mdi-circle-outline"></i>
                                                Select</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-title">Form</li>

                        <li><a href="form-base.html"><i class="fa fa-dice"></i> <span>Base</span></a></li>

                        <li>
                            <a href="#!" class="has-arrow"><i class="fa fa-fill-drip"></i> <span>Advanced</span></a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="form-autosize.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Autosize</a></li>
                                <li><a href="form-bs-maxlength.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Bootstrap
                                        maxlength</a></li>
                                <li><a href="form-clipboard.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Clipboard</a></li>
                                <li><a href="form-datepicker.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Date picker</a></li>
                                <li><a href="form-datetimepicker.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Date time picker</a>
                                </li>
                                <li><a href="form-rangepicker.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Range picker</a>
                                </li>
                                <li><a href="form-inputmask.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Input mask</a></li>
                                <li><a href="form-select2.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Select2</a></li>
                                <li><a href="form-rangeslider.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Slider</a></li>
                                <li><a href="form-touchspin.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Touchspin</a></li>
                                <li><a href="form-typeahead.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Typeahead</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#!" class="has-arrow"><i class="fa fa-pencil-ruler"></i> <span>Editors</span></a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="form-basic-editors.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Basic</a></li>
                                <li><a href="form-bubble-editors.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Bubble</a></li>
                                <li><a href="form-complex-editors.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Complex</a></li>
                            </ul>
                        </li>

                        <li><a href="form-input-group.html"><i class="fa fa-th-list"></i> <span>Group</span></a></li>
                        <li><a href="form-layout.html"><i class="fa fa-ruler-combined"></i> <span>Layout</span></a></li>
                        <li><a href="form-validation.html"><i class="fa fa-check"></i> <span>Validation</span></a></li>

                        <li class="menu-title">Pages</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow ">
                                <i class="fa fa-unlock-alt"></i>
                                <span>Authentication</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="auth-login.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Login</a></li>
                                <li><a href="auth-register.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i> Register</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow ">
                                <i class="fa fa-unlink"></i>
                                <span>Error</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="pages-404.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Error 404</a></li>
                                <li><a href="pages-500.html"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                        Error 500</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="pages-starter.html"><i class="fas fa-pager"></i> <span>Starter Page</span></a>
                        </li>

                        <li>
                            <a href="pages-pricing.html"><i class="fas fa-dollar-sign"></i> <span>Pricing</span></a>
                        </li>

                        <li>
                            <a href="pages-faqs.html"><i class="fas fa-question"></i> <span>FAQs</span></a>
                        </li>

                        <li>
                            <a href="pages-comingsoon.html"><i class="fas fa-tape"></i> <span>Coming Soon</span></a>
                        </li>

                        <li class="menu-title">Apps</li>

                        <li>
                            <a href="apps-chat.html" class="">
                                <i class="fas fa-comment"></i>
                                <span>Chat</span>
                            </a>
                        </li>

                        <li>
                            <a href="apps-kanban.html" class="">
                                <i class="fas fa-grip-horizontal"></i>
                                <span>Kanban Board</span>
                            </a>
                        </li>

                        <li>
                            <a href="apps-contact.html" class="">
                                <i class="fas fa-id-badge"></i>
                                <span>Contacts</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Starter page</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Elements</a></li>
                                        <li class="breadcrumb-item active">Starter page</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © e-Capaian.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="http://codebucks.in/" target="_blank"
                                    class="text-muted">Codebucks</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <div class="custom-setting bg-primary pe-0 d-flex flex-column rounded-start">
        <button type="button" class="btn btn-wide border-0 text-white fs-20 avatar-sm rounded-end-0" id="light-dark-mode">
            <i class="mdi mdi-brightness-7 align-middle"></i>
            <i class="mdi mdi-white-balance-sunny align-middle"></i>
        </button>
        <button type="button" class="btn btn-wide border-0 text-white fs-20 avatar-sm" data-toggle="fullscreen">
            <i class="mdi mdi-arrow-expand-all align-middle"></i>
        </button>
        <button type="button" class="btn btn-wide border-0 text-white fs-16 avatar-sm" id="layout-dir-btn">
            <span>RTL</span>
        </button>
    </div>


    <!-- Rightbar Sidebar -->
    <div class="offcanvas offcanvas-end" id="offcanvas-rightsidabar">
        <div class="card h-100 rounded-0" data-simplebar="init">
            <div class="card-header bg-light">
                <h6 class="card-title text-uppercase">Activities</h6>
                <div class="card-addon">
                    <button class="btn btn-label-danger" data-bs-dismiss="offcanvas">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <h3 class="card-title">Company summary</h3>
                    <div class="border rounded p-2">
                        <p class="text-muted mb-2">Server Load</p>
                        <h4 class="fs-16 mb-2">489</h4>
                        <div class="progress progress-sm" style="height:4px;">
                            <div class="progress-bar bg-success" style="width: 49.4%"></div>
                        </div>
                        <p class="text-muted mb-0 mt-1">49.4% <span>Avg</span></p>
                    </div>
                    <div class="border rounded p-2">
                        <p class="text-muted mb-2">Members online</p>
                        <h4 class="fs-16 mb-2">3,450</h4>
                        <div class="progress progress-sm" style="height:4px;">
                            <div class="progress-bar bg-danger" style="width: 34.6%"></div>
                        </div>
                        <p class="text-muted mb-0 mt-1">34.6% <span>Avg</span></p>
                    </div>
                    <div class="border rounded p-2">
                        <p class="text-muted mb-2">Today's revenue</p>
                        <h4 class="fs-16 mb-2">$18,390</h4>
                        <div class="progress progress-sm" style="height:4px;">
                            <div class="progress-bar bg-warning" style="width: 20%"></div>
                        </div>
                        <p class="text-muted mb-0 mt-1">$37,578 <span>Avg</span></p>
                    </div>
                    <div class="border rounded p-2">
                        <p class="text-muted mb-2">Expected profit</p>
                        <h4 class="fs-16 mb-2">$23,461</h4>
                        <div class="progress progress-sm" style="height:4px;">
                            <div class="progress-bar bg-info" style="width: 60%"></div>
                        </div>
                        <p class="text-muted mb-0 mt-1">$23,461 <span>Avg</span></p>
                    </div>
                </div>

                <div class="mt-4">
                    <h3 class="card-title">Latest log</h3>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-pin"><i class="marker marker-dot text-primary"></i></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">12 new users registered</p>
                                    <span class="text-muted">Just now</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-pin"><i class="marker marker-dot text-success"></i></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">System shutdown <span class="badge badge-label-success">pending</span></p>
                                    <span class="text-muted">2 mins</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-pin"><i class="marker marker-dot text-primary"></i></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">New invoice received</p>
                                    <span class="text-muted">3 mins</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-pin"><i class="marker marker-dot text-danger"></i></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">New order received <span class="badge badge-label-danger">urgent</span></p>
                                    <span class="text-muted">10 mins</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-pin"><i class="marker marker-dot text-warning"></i></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Production server down</p>
                                    <span class="text-muted">1 hrs</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-pin"><i class="marker marker-dot text-info"></i></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">System error <a href="#">check</a></p>
                                    <span class="text-muted">2 hrs</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-pin"><i class="marker marker-dot text-secondary"></i></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">DB overloaded 80%</p>
                                    <span class="text-muted">5 hrs</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-pin"><i class="marker marker-dot text-success"></i></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Production server up</p>
                                    <span class="text-muted">6 hrs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h3 class="card-title">Upcoming activities</h3>
                    <div class="timeline timeline-timed">
                        <div class="timeline-item">
                            <span class="timeline-time">10:00</span>
                            <div class="timeline-pin"><i class="marker marker-circle text-primary"></i></div>
                            <div class="timeline-content">
                                <div>
                                    <span>Meeting with</span>
                                    <div class="avatar-group ms-2">
                                        <div class="avatar avatar-circle">
                                            <img src="assets/images/users/avatar-1.png" alt="Avatar image" class="avatar-2xs" />
                                        </div>
                                        <div class="avatar avatar-circle">
                                            <img src="assets/images/users/avatar-2.png" alt="Avatar image" class="avatar-2xs" />
                                        </div>
                                        <div class="avatar avatar-circle">
                                            <img src="assets/images/users/avatar-3.png" alt="Avatar image" class="avatar-2xs" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-time">12:45</span>
                            <div class="timeline-pin"><i class="marker marker-circle text-warning"></i></div>
                            <div class="timeline-content">
                                <p class="mb-0">Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                    labore et dolore magna elit enim at minim veniam quis nostrud</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-time">14:00</span>
                            <div class="timeline-pin"><i class="marker marker-circle text-danger"></i></div>
                            <div class="timeline-content">
                                <p class="mb-0">Received a new feedback on <a href="#">GoFinance</a> App product.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-time">15:20</span>
                            <div class="timeline-pin"><i class="marker marker-circle text-success"></i></div>
                            <div class="timeline-content">
                                <p class="mb-0">Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                    labore et dolore magna.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-time">17:00</span>
                            <div class="timeline-pin"><i class="marker marker-circle text-info"></i></div>
                            <div class="timeline-content">
                                <p class="mb-0">Make Deposit <a href="#">USD 700</a> o ESL.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card-->
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <script src="assets/js/app.js"></script>

</body>

</html>