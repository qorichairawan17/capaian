<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk IKU 1.5 (Putusan Pengadilan yang Diunggah pada Direktori Putusan)
 */
class Iku_1_5 extends CI_Controller
{
    private $getCasesIku15UseCase;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $caseIku15Repository = new \App\Infrastructure\Repositories\DbCaseIku15Repository();
        $this->getCasesIku15UseCase = new \App\UseCases\GetCasesIku15UseCase($caseIku15Repository);
    }

    public function index()
    {
        $jenisPerkara = $this->input->get('jenis', TRUE);
        $periode = $this->input->get('periode', TRUE);

        $request = new \App\UseCases\DTO\GetCasesIku15Request($jenisPerkara, $periode);
        $response = $this->getCasesIku15UseCase->execute($request);

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

        $this->load->view('dashboard/layouts/body', $data);
    }
}
