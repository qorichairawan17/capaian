<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk IKU 1.10 (Perkara Perdata Menggunakan e-Court)
 */
class Iku_1_10 extends CI_Controller
{
    private $getCasesIku110UseCase;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $caseIku110Repository = new \App\Infrastructure\Repositories\DbCaseIku110Repository();
        $this->getCasesIku110UseCase = new \App\UseCases\GetCasesIku110UseCase($caseIku110Repository);
    }

    public function index()
    {
        $metodePendaftaran = $this->input->get('metode', TRUE);
        $periode = $this->input->get('periode', TRUE);

        $request = new \App\UseCases\DTO\GetCasesIku110Request($periode, $metodePendaftaran);
        $response = $this->getCasesIku110UseCase->execute($request);

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

        $this->load->view('dashboard/layouts/body', $data);
    }
}
