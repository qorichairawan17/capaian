<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Target Controller
 *
 * Presentation layer untuk fitur Pengisian Target IKU.
 * Bertindak sebagai Dependency Resolver — instansiasi Repository → inject ke UseCase.
 */
class Target extends CI_Controller
{
    private $saveTargetUseCase;
    private $getTargetsUseCase;

    /**
     * Daftar IKU yang didukung (kecuali 1.12).
     * Digunakan untuk render dropdown dan validasi input.
     */
    private $ikuList = [
        '1.1'  => 'Penyelesaian perkara secara tepat waktu',
        '1.2'  => 'Persentase penyediaan/pengiriman salinan putusan tepat waktu oleh pengadilan tingkat pertama kepada para pihak',
        '1.3'  => 'Persentase pengiriman pemberitahuan petikan/amar putusan tingkat banding, kasasi dan PK secara tepat waktu oleh pengadilan pengaju kepada para pihak',
        '1.4'  => 'Persentase pengiriman salinan putusan perkara pidana tingkat banding, kasasi dan PK tepat waktu oleh pengadilan pengaju kepada para pihak',
        '1.5'  => 'Persentase putusan pengadilan yang diunggah pada direktori putusan',
        '1.6'  => 'Persentase penyelesaian permohonan eksekusi putusan perdata',
        '1.7'  => 'Persentase Perkara yang berhasil diselesaikan melalui pendekatan keadilan restorative',
        '1.8'  => 'Persentase Perkara yang berhasil diselesaikan melalui mediasi',
        '1.9'  => 'Persentase Perkara anak yang berhasil diselesaikan melalui diversi',
        '1.10' => 'Persentase Perkara perdata tingkat pertama yang menggunakan e-Court',
        '1.11' => 'Persentase Perkara pidana yang dilimpahkan secara elektronik (e-Berpadu)',
    ];

    public function __construct()
    {
        parent::__construct();

        // Auth guard
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Dependency Resolution (Clean Architecture)
        $repository = new \App\Infrastructure\Repositories\DbIkuTargetRepository();
        $this->saveTargetUseCase = new \App\UseCases\SaveIkuTargetUseCase($repository);
        $this->getTargetsUseCase = new \App\UseCases\GetIkuTargetsUseCase($repository);
    }

    /**
     * Halaman utama Pengisian Target.
     */
    public function index()
    {
        $data = [
            'title'        => 'Pengisian Target',
            'content_view' => 'dashboard/target/v_target',
            'iku_list'     => $this->ikuList,
            'extra_css'    => ['assets/css/custom-target.css?v=' . time()],
        ];
        $this->load->view('dashboard/layouts/body', $data);
    }

    /**
     * AJAX endpoint: ambil data target berdasarkan filter.
     * GET /target/get_targets?iku_code=1.1&tahun=2026&periode_type=bulanan
     */
    public function get_targets()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $ikuCode = $this->input->get('iku_code', TRUE);
        $tahun = $this->input->get('tahun', TRUE);
        $periodeType = $this->input->get('periode_type', TRUE);

        // Validasi input
        if (empty($ikuCode) || empty($tahun) || empty($periodeType)) {
            $this->_json_response(false, 'Parameter iku_code, tahun, dan periode_type wajib diisi.', null, 400);
            return;
        }

        if (!array_key_exists($ikuCode, $this->ikuList)) {
            $this->_json_response(false, 'Kode IKU tidak valid.', null, 400);
            return;
        }

        try {
            $request = new \App\UseCases\DTO\GetIkuTargetsRequest($ikuCode, $tahun, $periodeType);
            $response = $this->getTargetsUseCase->execute($request);

            $targetsData = [];
            foreach ($response->getTargets() as $target) {
                $targetsData[] = [
                    'id'            => $target->getId(),
                    'iku_code'      => $target->getIkuCode(),
                    'tahun'         => $target->getTahun(),
                    'periode_type'  => $target->getPeriodeType(),
                    'periode_value' => $target->getPeriodeValue(),
                    'target_value'  => $target->getTargetValue(),
                ];
            }

            $this->_json_response(true, 'Data target berhasil dimuat.', [
                'targets'      => $targetsData,
                'targets_map'  => $response->toMap(),
                'iku_code'     => $response->getIkuCode(),
                'tahun'        => $response->getTahun(),
                'periode_type' => $response->getPeriodeType(),
            ]);

        } catch (\Exception $e) {
            $this->_json_response(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * AJAX endpoint: simpan target (batch).
     * POST /target/save
     * Body JSON: { iku_code, tahun, periode_type, targets: [{periode_value, target_value}, ...] }
     */
    public function save()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Ambil raw JSON body
        $json = $this->input->raw_input_stream;
        $payload = json_decode($json, true);

        if (empty($payload)) {
            $this->_json_response(false, 'Request body tidak valid (JSON).', null, 400);
            return;
        }

        $ikuCode = isset($payload['iku_code']) ? $payload['iku_code'] : '';
        $tahun = isset($payload['tahun']) ? (int) $payload['tahun'] : 0;
        $periodeType = isset($payload['periode_type']) ? $payload['periode_type'] : '';
        $targets = isset($payload['targets']) ? $payload['targets'] : [];

        // Validasi input
        if (empty($ikuCode) || empty($tahun) || empty($periodeType) || empty($targets)) {
            $this->_json_response(false, 'Semua field (iku_code, tahun, periode_type, targets) wajib diisi.', null, 400);
            return;
        }

        if (!array_key_exists($ikuCode, $this->ikuList)) {
            $this->_json_response(false, 'Kode IKU tidak valid.', null, 400);
            return;
        }

        $userId = $this->session->userdata('user_id');

        // Map ke array of SaveIkuTargetRequest DTO
        $requests = [];
        foreach ($targets as $t) {
            $periodeValue = isset($t['periode_value']) ? (int) $t['periode_value'] : 0;
            $targetValue = isset($t['target_value']) ? (float) $t['target_value'] : 0;

            $requests[] = new \App\UseCases\DTO\SaveIkuTargetRequest(
                $ikuCode,
                $tahun,
                $periodeType,
                $periodeValue,
                $targetValue,
                $userId
            );
        }

        try {
            $response = $this->saveTargetUseCase->executeBatch($requests);

            $this->_json_response(
                $response->isSuccess(),
                $response->getMessage(),
                ['saved_count' => $response->getSavedCount()]
            );

        } catch (\App\Domain\Exceptions\InvalidTargetException $e) {
            $this->_json_response(false, $e->getMessage(), null, 422);
        } catch (\Exception $e) {
            $this->_json_response(false, 'Terjadi kesalahan server: ' . $e->getMessage(), null, 500);
        }
    }

    // ─── Private Helpers ──────────────────────────────────────────────────

    /**
     * Helper untuk mengirim JSON response konsisten.
     *
     * @param bool        $success
     * @param string      $message
     * @param mixed|null  $data
     * @param int         $httpCode
     */
    private function _json_response($success, $message, $data = null, $httpCode = 200)
    {
        $response = [
            'success' => (bool) $success,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        $this->output
            ->set_status_header($httpCode)
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
