<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicator extends CI_Controller
{
    private $getCasesUseCase;

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
        // Note: Using MockCaseRepository since case detail tables do not exist in current DB.
        $caseRepository = new \App\Infrastructure\Repositories\MockCaseRepository();
        $this->getCasesUseCase = new \App\UseCases\GetCasesUseCase($caseRepository);
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

        // 4. Map response data to layout view
        $data = [
            'title' => 'IKU 1.1 - Penyelesaian Perkara Tepat Waktu',
            'content_view' => 'dashboard/indicator/v_iku_1_1',
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
