<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk IKU 1.6 (Penyelesaian Permohonan Eksekusi Putusan Perdata)
 */
class Iku_1_6 extends CI_Controller
{
    private $getCasesIku16UseCase;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $caseIku16Repository = new \App\Infrastructure\Repositories\DbCaseIku16Repository();
        $this->getCasesIku16UseCase = new \App\UseCases\GetCasesIku16UseCase($caseIku16Repository);
    }

    public function index()
    {
        $statusEksekusi = $this->input->get('status', TRUE);
        $jenisEksekusi = $this->input->get('jenis_eksekusi', TRUE);
        $periode = $this->input->get('periode', TRUE);

        $request = new \App\UseCases\DTO\GetCasesIku16Request($statusEksekusi, $jenisEksekusi, $periode);
        $response = $this->getCasesIku16UseCase->execute($request);

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

        $this->load->view('dashboard/layouts/body', $data);
    }
}
