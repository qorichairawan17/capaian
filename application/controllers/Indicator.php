<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicator extends CI_Controller
{
    private $getCasesUseCase;
    private $getCasesIku12UseCase;

    public function __construct()
    {
        parent::__construct();
        // Load libraries & helpers
        $this->load->library('session');
        $this->load->helper('url');

        // Redirect to login if not logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Dependency Resolution (Clean Architecture)
        $caseRepository = new \App\Infrastructure\Repositories\DbCaseRepository();
        $this->getCasesUseCase = new \App\UseCases\GetCasesUseCase($caseRepository);

        $caseIku12Repository = new \App\Infrastructure\Repositories\DbCaseIku12Repository();
        $this->getCasesIku12UseCase = new \App\UseCases\GetCasesIku12UseCase($caseIku12Repository);
    }

    /**
     * Render details page for IKU 1.1 (Penyelesaian Perkara Tepat Waktu)
     */
    public function iku_1_1()
    {
        // 1. Get input parameters from GET query string
        $jenisPerkara = $this->input->get('jenis', TRUE); // e.g. 'pidana', 'perdata', 'semua'
        $periode = $this->input->get('periode', TRUE);       // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesRequest($jenisPerkara, $periode);

        // 3. Execute application use case
        $response = $this->getCasesUseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'jenis_perkara' => $case->getJenisPerkara(),
                    'tanggal_registrasi' => date('d M Y', strtotime($case->getTanggalRegistrasi())),
                    'tanggal_putusan' => date('d M Y', strtotime($case->getTanggalPutusan())),
                    'tanggal_minutasi' => date('d M Y', strtotime($case->getTanggalMinutasi())),
                    'durasi_hari' => $case->getDurasiHari(),
                    'status' => $case->getStatus()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalCount' => $response->getTotalCount(),
                    'tepatWaktuCount' => $response->getTepatWaktuCount(),
                    'terlambatCount' => $response->getTerlambatCount(),
                    'persentaseTepatWaktu' => $response->getPersentaseTepatWaktu(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.1 - Penyelesaian Perkara Tepat Waktu',
            'content_view' => 'dashboard/indicator/v_iku_1_1',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_1.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalCount' => $response->getTotalCount(),
            'tepatWaktuCount' => $response->getTepatWaktuCount(),
            'terlambatCount' => $response->getTerlambatCount(),
            'persentaseTepatWaktu' => $response->getPersentaseTepatWaktu(),
            'selectedJenis' => $jenisPerkara ? $jenisPerkara : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }

    /**
     * Render details page for IKU 1.2 (Pengiriman Salinan Putusan Tepat Waktu)
     */
    public function iku_1_2()
    {
        // 1. Get input parameters from GET query string
        $jenisPerkara = $this->input->get('jenis', TRUE); // e.g. 'pidana', 'perdata', 'semua'
        $periode = $this->input->get('periode', TRUE);       // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku12Request($jenisPerkara, $periode);

        // 3. Execute application use case
        $response = $this->getCasesIku12UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'jenis_perkara' => $case->getJenisPerkara(),
                    'metode_pengiriman' => $case->getMetodePengiriman(),
                    'tanggal_putusan' => date('d M Y', strtotime($case->getTanggalPutusan())),
                    'tanggal_pengiriman' => date('d M Y', strtotime($case->getTanggalPengiriman())),
                    'durasi_hari' => $case->getDurasiHari(),
                    'status' => $case->getStatus()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalCount' => $response->getTotalCount(),
                    'tepatWaktuCount' => $response->getTepatWaktuCount(),
                    'terlambatCount' => $response->getTerlambatCount(),
                    'persentaseTepatWaktu' => $response->getPersentaseTepatWaktu(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.2 - Pengiriman Salinan Putusan Tepat Waktu',
            'content_view' => 'dashboard/indicator/v_iku_1_2',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_2.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalCount' => $response->getTotalCount(),
            'tepatWaktuCount' => $response->getTepatWaktuCount(),
            'terlambatCount' => $response->getTerlambatCount(),
            'persentaseTepatWaktu' => $response->getPersentaseTepatWaktu(),
            'selectedJenis' => $jenisPerkara ? $jenisPerkara : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }
}
