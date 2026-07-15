<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('dashboard/layouts/header');
?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- Dynamic Content -->
            <?php 
            if (isset($content_view)) {
                $this->load->view($content_view); 
            }
            ?>

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php $this->load->view('dashboard/layouts/footer'); ?>
