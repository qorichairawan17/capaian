<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk IKU 1.8 (Perkara yang Berhasil Diselesaikan Melalui Mediasi)
 */
class Iku_1_8 extends CI_Controller
{
    private $getCasesIku18UseCase;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $caseIku18Repository = new \App\Infrastructure\Repositories\DbCaseIku18Repository();
        $this->getCasesIku18UseCase = new \App\UseCases\GetCasesIku18UseCase($caseIku18Repository);
    }

    public function index()
    {
        $statusMediasi = $this->input->get('status', TRUE);
        $periode = $this->input->get('periode', TRUE);

        $request = new \App\UseCases\DTO\GetCasesIku18Request($periode, $statusMediasi);
        $response = $this->getCasesIku18UseCase->execute($request);

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

        $this->load->view('dashboard/layouts/body', $data);
    }
}
