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
    private $getCasesIku17UseCase;
    private $getCasesIku18UseCase;
    private $getCasesIku19UseCase;
    private $getCasesIku110UseCase;
    private $getCasesIku111UseCase;

    public function __construct()
    {
        parent::__construct();
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

        $caseIku17Repository = new \App\Infrastructure\Repositories\DbCaseIku17Repository();
        $this->getCasesIku17UseCase = new \App\UseCases\GetCasesIku17UseCase($caseIku17Repository);

        $caseIku18Repository = new \App\Infrastructure\Repositories\DbCaseIku18Repository();
        $this->getCasesIku18UseCase = new \App\UseCases\GetCasesIku18UseCase($caseIku18Repository);

        $caseIku19Repository = new \App\Infrastructure\Repositories\DbCaseIku19Repository();
        $this->getCasesIku19UseCase = new \App\UseCases\GetCasesIku19UseCase($caseIku19Repository);

        $caseIku110Repository = new \App\Infrastructure\Repositories\DbCaseIku110Repository();
        $this->getCasesIku110UseCase = new \App\UseCases\GetCasesIku110UseCase($caseIku110Repository);

        $caseIku111Repository = new \App\Infrastructure\Repositories\DbCaseIku111Repository();
        $this->getCasesIku111UseCase = new \App\UseCases\GetCasesIku111UseCase($caseIku111Repository);
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

    /**
     * Render details page for IKU 1.7 (Perkara yang Berhasil Diselesaikan Melalui Pendekatan Keadilan Restoratif)
     */
    public function iku_1_7()
    {
        // 1. Get input parameters from GET query string
        $kategoriKriteria = $this->input->get('kategori', TRUE); // e.g. 'tindak_pidana_ringan', 'delik_aduan', 'ancaman_max_5_tahun', etc.
        $statusRj = $this->input->get('status', TRUE);            // e.g. 'berhasil', 'gagal', 'semua'
        $periode = $this->input->get('periode', TRUE);            // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku17Request($kategoriKriteria, $statusRj, $periode);

        // 3. Execute application use case
        $response = $this->getCasesIku17UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'kategori_kriteria' => $case->getKategoriKriteria(),
                    'terdakwa' => $case->getTerdakwa(),
                    'tanggal_registrasi' => date('d M Y', strtotime($case->getTanggalRegistrasi())),
                    'tanggal_putusan' => date('d M Y', strtotime($case->getTanggalPutusan())),
                    'status_rj' => $case->getStatusRj(),
                    'is_berhasil' => $case->isBerhasil()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalMemenuhiKriteriaCount' => $response->getTotalMemenuhiKriteriaCount(),
                    'berhasilRjCount' => $response->getBerhasilRjCount(),
                    'gagalRjCount' => $response->getGagalRjCount(),
                    'persentaseBerhasilRj' => $response->getPersentaseBerhasilRj(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.7 - Perkara Berhasil Diselesaikan Melalui Keadilan Restoratif',
            'content_view' => 'dashboard/indicator/v_iku_1_7',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_7.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalMemenuhiKriteriaCount' => $response->getTotalMemenuhiKriteriaCount(),
            'berhasilRjCount' => $response->getBerhasilRjCount(),
            'gagalRjCount' => $response->getGagalRjCount(),
            'persentaseBerhasilRj' => $response->getPersentaseBerhasilRj(),
            'selectedKategori' => $kategoriKriteria ? $kategoriKriteria : 'semua',
            'selectedStatus' => $statusRj ? $statusRj : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }

    /**
     * Render details page for IKU 1.8 (Perkara yang Berhasil Diselesaikan Melalui Mediasi)
     */
    public function iku_1_8()
    {
        // 1. Get input parameters from GET query string
        $statusMediasi = $this->input->get('status', TRUE); // e.g. 'berhasil', 'gagal', 'semua'
        $periode = $this->input->get('periode', TRUE);       // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku18Request($periode, $statusMediasi);

        // 3. Execute application use case
        $response = $this->getCasesIku18UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'para_pihak' => $case->getParaPihak(),
                    'mediator' => $case->getMediator(),
                    'jenis_mediator' => $case->getJenisMediator(),
                    'tanggal_mediasi' => date('d M Y', strtotime($case->getTanggalMediasi())),
                    'tanggal_selesai' => date('d M Y', strtotime($case->getTanggalSelesai())),
                    'hasil_mediasi' => $case->getHasilMediasi(),
                    'is_wajib' => $case->isWajibMediasi(),
                    'is_berhasil' => $case->isBerhasilMediasi()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalWajibMediasiCount' => $response->getTotalWajibMediasiCount(),
                    'berhasilMediasiCount' => $response->getBerhasilMediasiCount(),
                    'gagalMediasiCount' => $response->getGagalMediasiCount(),
                    'persentaseBerhasilMediasi' => $response->getPersentaseBerhasilMediasi(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.8 - Perkara Berhasil Diselesaikan Melalui Mediasi',
            'content_view' => 'dashboard/indicator/v_iku_1_8',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_8.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalWajibMediasiCount' => $response->getTotalWajibMediasiCount(),
            'berhasilMediasiCount' => $response->getBerhasilMediasiCount(),
            'gagalMediasiCount' => $response->getGagalMediasiCount(),
            'persentaseBerhasilMediasi' => $response->getPersentaseBerhasilMediasi(),
            'selectedStatus' => $statusMediasi ? $statusMediasi : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }

    /**
     * Render details page for IKU 1.9 (Perkara Anak yang Berhasil Diselesaikan Melalui Diversi)
     */
    public function iku_1_9()
    {
        // 1. Get input parameters from GET query string
        $statusDiversi = $this->input->get('status', TRUE); // e.g. 'berhasil', 'gagal', 'semua'
        $periode = $this->input->get('periode', TRUE);       // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku19Request($periode, $statusDiversi);

        // 3. Execute application use case
        $response = $this->getCasesIku19UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'nama_anak' => $case->getNamaAnak(),
                    'dakwaan' => $case->getDakwaan(),
                    'tanggal_diversi' => date('d M Y', strtotime($case->getTanggalDiversi())),
                    'tanggal_selesai' => date('d M Y', strtotime($case->getTanggalSelesai())),
                    'status_diversi' => $case->getStatusDiversi(),
                    'nomor_penetapan_ketua' => $case->getNomorPenetapanKetua(),
                    'is_selesai' => $case->isSelesaiDiversi(),
                    'is_berhasil' => $case->isBerhasilDiversi()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalSelesaiDiversiCount' => $response->getTotalSelesaiDiversiCount(),
                    'berhasilDiversiCount' => $response->getBerhasilDiversiCount(),
                    'gagalDiversiCount' => $response->getGagalDiversiCount(),
                    'persentaseBerhasilDiversi' => $response->getPersentaseBerhasilDiversi(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.9 - Perkara Anak Diselesaikan Melalui Diversi',
            'content_view' => 'dashboard/indicator/v_iku_1_9',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_9.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalSelesaiDiversiCount' => $response->getTotalSelesaiDiversiCount(),
            'berhasilDiversiCount' => $response->getBerhasilDiversiCount(),
            'gagalDiversiCount' => $response->getGagalDiversiCount(),
            'persentaseBerhasilDiversi' => $response->getPersentaseBerhasilDiversi(),
            'selectedStatus' => $statusDiversi ? $statusDiversi : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }

    /**
     * Render details page for IKU 1.10 (Persentase Perkara Perdata Tingkat Pertama Menggunakan e-Court)
     */
    public function iku_1_10()
    {
        // 1. Get input parameters from GET query string
        $metodePendaftaran = $this->input->get('metode', TRUE); // e.g. 'ecourt', 'konvensional', 'semua'
        $periode = $this->input->get('periode', TRUE);          // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku110Request($periode, $metodePendaftaran);

        // 3. Execute application use case
        $response = $this->getCasesIku110UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'para_pihak' => $case->getParaPihak(),
                    'jenis_perdata' => $case->getJenisPerdata(),
                    'metode_pendaftaran' => $case->getMetodePendaftaran(),
                    'tanggal_pendaftaran' => date('d M Y', strtotime($case->getTanggalPendaftaran())),
                    'nomor_register_ecourt' => $case->getNomorRegisterEcourt(),
                    'is_ecourt' => $case->isEcourt(),
                    'is_konvensional' => $case->isKonvensional()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalDiajukanCount' => $response->getTotalDiajukanCount(),
                    'ecourtCount' => $response->getEcourtCount(),
                    'konvensionalCount' => $response->getKonvensionalCount(),
                    'persentaseEcourt' => $response->getPersentaseEcourt(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.10 - Perkara Perdata Menggunakan e-Court',
            'content_view' => 'dashboard/indicator/v_iku_1_10',
            'extra_css' => [
                'assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                'assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
                'assets/css/indicator/iku_1_10.css'
            ],
            'extra_js' => [
                'assets/libs/datatables.net/js/jquery.dataTables.min.js',
                'assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
                'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
                'assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js'
            ],
            'cases' => $response->getCases(),
            'totalDiajukanCount' => $response->getTotalDiajukanCount(),
            'ecourtCount' => $response->getEcourtCount(),
            'konvensionalCount' => $response->getKonvensionalCount(),
            'persentaseEcourt' => $response->getPersentaseEcourt(),
            'selectedMetode' => $metodePendaftaran ? $metodePendaftaran : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }

    /**
     * Render details page for IKU 1.11 (Persentase Perkara Pidana yang Dilimpahkan Secara Elektronik e-Berpadu)
     */
    public function iku_1_11()
    {
        // 1. Get input parameters from GET query string
        $metodePelimpahan = $this->input->get('metode', TRUE); // e.g. 'eberpadu', 'konvensional', 'semua'
        $periode = $this->input->get('periode', TRUE);          // e.g. 't1', 't2', 't3', 't4', 'tahunan'

        // 2. Map input to Request DTO
        $request = new \App\UseCases\DTO\GetCasesIku111Request($periode, $metodePelimpahan);

        // 3. Execute application use case
        $response = $this->getCasesIku111UseCase->execute($request);

        // If AJAX request, return statistics and case list as JSON
        if ($this->input->is_ajax_request()) {
            $casesArray = [];
            foreach ($response->getCases() as $case) {
                $casesArray[] = [
                    'id' => $case->getId(),
                    'nomor_perkara' => $case->getNomorPerkara(),
                    'nama_terdakwa' => $case->getNamaTerdakwa(),
                    'jenis_pidana' => $case->getJenisPidana(),
                    'metode_pelimpahan' => $case->getMetodePelimpahan(),
                    'tanggal_pelimpahan' => date('d M Y', strtotime($case->getTanggalPelimpahan())),
                    'nomor_register_eberpadu' => $case->getNomorRegisterEberpadu(),
                    'kejaksaan_penuntut' => $case->getKejaksaanPenuntut(),
                    'is_eberpadu' => $case->isEberpadu(),
                    'is_konvensional' => $case->isKonvensional()
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'totalDilimpahkanCount' => $response->getTotalDilimpahkanCount(),
                    'eberpaduCount' => $response->getEberpaduCount(),
                    'konvensionalCount' => $response->getKonvensionalCount(),
                    'persentaseEberpadu' => $response->getPersentaseEberpadu(),
                    'cases' => $casesArray
                ]));
            return;
        }

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.11 - Perkara Pidana Dilimpahkan Secara Elektronik (e-Berpadu)',
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
            'cases' => $response->getCases(),
            'totalDilimpahkanCount' => $response->getTotalDilimpahkanCount(),
            'eberpaduCount' => $response->getEberpaduCount(),
            'konvensionalCount' => $response->getKonvensionalCount(),
            'persentaseEberpadu' => $response->getPersentaseEberpadu(),
            'selectedMetode' => $metodePelimpahan ? $metodePelimpahan : 'semua',
            'selectedPeriode' => $periode ? $periode : 'tahunan'
        ];

        // 5. Load standard layout
        $this->load->view('dashboard/layouts/body', $data);
    }
}
