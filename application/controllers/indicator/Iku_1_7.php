<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk IKU 1.7 (Perkara yang Berhasil Diselesaikan Melalui Keadilan Restoratif)
 */
class Iku_1_7 extends CI_Controller
{
    private $getCasesIku17UseCase;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $caseIku17Repository = new \App\Infrastructure\Repositories\DbCaseIku17Repository();
        $this->getCasesIku17UseCase = new \App\UseCases\GetCasesIku17UseCase($caseIku17Repository);
    }

    public function index()
    {
        $kategoriKriteria = $this->input->get('kategori', TRUE);
        $statusRj = $this->input->get('status', TRUE);
        $periode = $this->input->get('periode', TRUE);

        $request = new \App\UseCases\DTO\GetCasesIku17Request($kategoriKriteria, $statusRj, $periode);
        $response = $this->getCasesIku17UseCase->execute($request);

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

        $this->load->view('dashboard/layouts/body', $data);
    }
}
