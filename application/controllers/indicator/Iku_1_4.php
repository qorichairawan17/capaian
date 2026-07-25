<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk IKU 1.4 (Pengiriman Salinan Putusan Perkara Pidana Tepat Waktu)
 */
class Iku_1_4 extends CI_Controller
{
    private $getCasesIku14UseCase;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $caseIku14Repository = new \App\Infrastructure\Repositories\DbCaseIku14Repository();
        $this->getCasesIku14UseCase = new \App\UseCases\GetCasesIku14UseCase($caseIku14Repository);
    }

    public function index()
    {
        $tingkatPeradilan = $this->input->get('tingkat', TRUE);
        $periode = $this->input->get('periode', TRUE);

        $request = new \App\UseCases\DTO\GetCasesIku14Request($tingkatPeradilan, $periode);
        $response = $this->getCasesIku14UseCase->execute($request);

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

        $this->load->view('dashboard/layouts/body', $data);
    }
}
