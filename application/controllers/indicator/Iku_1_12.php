<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk IKU 1.12 (Layanan Perkara Pidana Secara Elektronik e-Berpadu)
 */
class Iku_1_12 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data = [
            'title' => 'IKU 1.12 - Layanan Perkara Pidana (e-Berpadu)',
            'content_view' => 'dashboard/indicator/v_iku_1_11',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_11.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => [],
            'totalDilimpahkanCount' => 0,
            'eberpaduCount' => 0,
            'konvensionalCount' => 0,
            'persentaseEberpadu' => 0,
            'selectedMetode' => 'semua',
            'selectedPeriode' => 'tahunan'
        ];

        $this->load->view('dashboard/layouts/body', $data);
    }
}
