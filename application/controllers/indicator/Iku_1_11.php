<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk IKU 1.11 (Perkara Pidana Dilimpahkan Secara Elektronik e-Berpadu)
 */
class Iku_1_11 extends CI_Controller
{
    private $getCasesIku111UseCase;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $caseIku111Repository = new \App\Infrastructure\Repositories\DbCaseIku111Repository();
        $this->getCasesIku111UseCase = new \App\UseCases\GetCasesIku111UseCase($caseIku111Repository);
    }

    public function index()
    {
        $metodePelimpahan = $this->input->get('metode', TRUE);
        $periode = $this->input->get('periode', TRUE);

        $request = new \App\UseCases\DTO\GetCasesIku111Request($periode, $metodePelimpahan);
        $response = $this->getCasesIku111UseCase->execute($request);

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

        $this->load->view('dashboard/layouts/body', $data);
    }
}
