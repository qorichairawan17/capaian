<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicator extends CI_Controller
{
    private $getCasesUseCase;
    private $getCasesIku12UseCase;
    private $getCasesIku13UseCase;
    private $getCasesIku14UseCase;
    private $getCasesIku15UseCase;
    private $getCasesIku16UseCase;

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

        $caseIku13Repository = new \App\Infrastructure\Repositories\DbCaseIku13Repository();
        $this->getCasesIku13UseCase = new \App\UseCases\GetCasesIku13UseCase($caseIku13Repository);

        $caseIku14Repository = new \App\Infrastructure\Repositories\DbCaseIku14Repository();
        $this->getCasesIku14UseCase = new \App\UseCases\GetCasesIku14UseCase($caseIku14Repository);

        $caseIku15Repository = new \App\Infrastructure\Repositories\DbCaseIku15Repository();
        $this->getCasesIku15UseCase = new \App\UseCases\GetCasesIku15UseCase($caseIku15Repository);

        $caseIku16Repository = new \App\Infrastructure\Repositories\DbCaseIku16Repository();
        $this->getCasesIku16UseCase = new \App\UseCases\GetCasesIku16UseCase($caseIku16Repository);
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

    /**
     * Render details page for IKU 1.3 (Persentase Pengiriman Pemberitahuan Petikan/Amar Putusan Tepat Waktu)
     */
    public function iku_1_3()
    {
        // 1. Get input parameters from GET query string
        $jenisPerkara = $this->input->get('jenis', TRUE); // e.g. 'pidana', 'perdata', 'semua'
        $periode = $this->input->get('periode', TRUE);       // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku13Request($jenisPerkara, $periode);

        // 3. Execute application use case
        $response = $this->getCasesIku13UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'jenis_perkara' => $case->getJenisPerkara(),
                    'tingkat_peradilan' => $case->getTingkatPeradilan(),
                    'tanggal_diterima' => date('d M Y', strtotime($case->getTanggalDiterima())),
                    'tanggal_diberitahukan' => date('d M Y', strtotime($case->getTanggalDiberitahukan())),
                    'durasi_hari' => $case->getDurasiHari(),
                    'status' => $case->getStatus()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalDiterimaCount' => $response->getTotalDiterimaCount(),
                    'tepatWaktuCount' => $response->getTepatWaktuCount(),
                    'terlambatCount' => $response->getTerlambatCount(),
                    'persentaseTepatWaktu' => $response->getPersentaseTepatWaktu(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.3 - Pengiriman Pemberitahuan Petikan/Amar Putusan Tepat Waktu',
            'content_view' => 'dashboard/indicator/v_iku_1_3',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_3.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalDiterimaCount' => $response->getTotalDiterimaCount(),
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
     * Render details page for IKU 1.4 (Persentase Pengiriman Salinan Putusan Perkara Pidana Banding/Kasasi/PK Tepat Waktu)
     */
    public function iku_1_4()
    {
        // 1. Get input parameters from GET query string
        $tingkatPeradilan = $this->input->get('tingkat', TRUE); // e.g. 'banding', 'kasasi', 'pk', 'semua'
        $periode = $this->input->get('periode', TRUE);              // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku14Request($tingkatPeradilan, $periode);

        // 3. Execute application use case
        $response = $this->getCasesIku14UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'tingkat_peradilan' => $case->getTingkatPeradilan(),
                    'metode_pengiriman' => $case->getMetodePengiriman(),
                    'tanggal_diterima' => date('d M Y', strtotime($case->getTanggalDiterima())),
                    'tanggal_dikirimkan' => date('d M Y', strtotime($case->getTanggalDikirimkan())),
                    'durasi_hari' => $case->getDurasiHari(),
                    'status' => $case->getStatus()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalDiterimaCount' => $response->getTotalDiterimaCount(),
                    'tepatWaktuCount' => $response->getTepatWaktuCount(),
                    'terlambatCount' => $response->getTerlambatCount(),
                    'persentaseTepatWaktu' => $response->getPersentaseTepatWaktu(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.4 - Pengiriman Salinan Putusan Perkara Pidana Tepat Waktu',
            'content_view' => 'dashboard/indicator/v_iku_1_4',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_4.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalDiterimaCount' => $response->getTotalDiterimaCount(),
            'tepatWaktuCount' => $response->getTepatWaktuCount(),
            'terlambatCount' => $response->getTerlambatCount(),
            'persentaseTepatWaktu' => $response->getPersentaseTepatWaktu(),
            'selectedTingkat' => $tingkatPeradilan ? $tingkatPeradilan : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }

    /**
     * Render details page for IKU 1.5 (Persentase Putusan Pengadilan yang Diunggah pada Direktori Putusan)
     */
    public function iku_1_5()
    {
        // 1. Get input parameters from GET query string
        $jenisPerkara = $this->input->get('jenis', TRUE); // e.g. 'pidana', 'perdata', 'semua'
        $periode = $this->input->get('periode', TRUE);       // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku15Request($jenisPerkara, $periode);

        // 3. Execute application use case
        $response = $this->getCasesIku15UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'jenis_perkara' => $case->getJenisPerkara(),
                    'tanggal_minutasi' => date('d M Y', strtotime($case->getTanggalMinutasi())),
                    'tanggal_unggah' => $case->getTanggalUnggah() ? date('d M Y', strtotime($case->getTanggalUnggah())) : '-',
                    'status_upload' => $case->getStatusUpload(),
                    'url_direktori' => $case->getUrlDirektori()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalMinutasiCount' => $response->getTotalMinutasiCount(),
                    'diunggahCount' => $response->getDiunggahCount(),
                    'belumDiunggahCount' => $response->getBelumDiunggahCount(),
                    'persentaseDiunggah' => $response->getPersentaseDiunggah(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.5 - Putusan Pengadilan yang Diunggah pada Direktori Putusan',
            'content_view' => 'dashboard/indicator/v_iku_1_5',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_5.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalMinutasiCount' => $response->getTotalMinutasiCount(),
            'diunggahCount' => $response->getDiunggahCount(),
            'belumDiunggahCount' => $response->getBelumDiunggahCount(),
            'persentaseDiunggah' => $response->getPersentaseDiunggah(),
            'selectedJenis' => $jenisPerkara ? $jenisPerkara : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }

    /**
     * Render details page for IKU 1.6 (Persentase Penyelesaian Permohonan Eksekusi Putusan Perdata)
     */
    public function iku_1_6()
    {
        // 1. Get input parameters from GET query string
        $statusEksekusi = $this->input->get('status', TRUE);         // e.g. 'diselesaikan', 'dalam_proses', 'semua'
        $jenisEksekusi = $this->input->get('jenis_eksekusi', TRUE); // e.g. 'perkara', 'hak_tanggungan', 'semua'
        $periode = $this->input->get('periode', TRUE);                  // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku16Request($statusEksekusi, $jenisEksekusi, $periode);

        // 3. Execute application use case
        $response = $this->getCasesIku16UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'jenis_eksekusi' => $case->getJenisEksekusi(),
                    'pemohon' => $case->getPemohon(),
                    'termohon' => $case->getTermohon(),
                    'tanggal_permohonan' => date('d M Y', strtotime($case->getTanggalPermohonan())),
                    'tanggal_selesai' => $case->getTanggalSelesai() ? date('d M Y', strtotime($case->getTanggalSelesai())) : '-',
                    'status_eksekusi' => $case->getStatusEksekusi(),
                    'is_diselesaikan' => $case->isDiselesaikan()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalPermohonanCount' => $response->getTotalPermohonanCount(),
                    'diselesaikanCount' => $response->getDiselesaikanCount(),
                    'dalamProsesCount' => $response->getDalamProsesCount(),
                    'persentaseDiselesaikan' => $response->getPersentaseDiselesaikan(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.6 - Penyelesaian Permohonan Eksekusi Putusan Perdata',
            'content_view' => 'dashboard/indicator/v_iku_1_6',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_6.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalPermohonanCount' => $response->getTotalPermohonanCount(),
            'diselesaikanCount' => $response->getDiselesaikanCount(),
            'dalamProsesCount' => $response->getDalamProsesCount(),
            'persentaseDiselesaikan' => $response->getPersentaseDiselesaikan(),
            'selectedStatus' => $statusEksekusi ? $statusEksekusi : 'semua',
            'selectedJenisEksekusi' => $jenisEksekusi ? $jenisEksekusi : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }
}
