<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk IKU 1.9 (Perkara Anak yang Berhasil Diselesaikan Melalui Diversi)
 */
class Iku_1_9 extends CI_Controller
{
    private $getCasesIku19UseCase;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $caseIku19Repository = new \App\Infrastructure\Repositories\DbCaseIku19Repository();
        $this->getCasesIku19UseCase = new \App\UseCases\GetCasesIku19UseCase($caseIku19Repository);
    }

    public function index()
    {
        $statusDiversi = $this->input->get('status', TRUE);
        $periode = $this->input->get('periode', TRUE);

        $request = new \App\UseCases\DTO\GetCasesIku19Request($periode, $statusDiversi);
        $response = $this->getCasesIku19UseCase->execute($request);

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

        $this->load->view('dashboard/layouts/body', $data);
    }
}
