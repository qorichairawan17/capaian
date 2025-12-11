<?php
// Proses filter data
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');
require_once 'function/getPersentase11.php';
$tahunFilter = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

try {
    $persentase = new GetPersentase11();
    $dataShowTotal = $persentase->showTotal($tahunFilter);
    $dataShowPerbulan = $persentase->showPerbulan($tahunFilter);
    $dataShowPertriwulan = $persentase->showPertriwulan($tahunFilter);
    $dataListPerkara = $persentase->showListPerkara($tahunFilter);
    $dataShowJenisPerkara = $persentase->showJenisPerkara($tahunFilter);
} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    exit;
}

// Array nama bulan
$namaBulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];
?>

<div class="container px-4">

    <!-- Filter Section -->
    <div class="filter-card animate-fade-in">
        <form method="GET" action="">
            <input type="hidden" name="page" value="capaian_persentase_11">
            <div class="row align-items-end">
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Periode Tahun</label>
                    <select class="form-select" name="tahun">
                        <?php
                        foreach (range(2020, date('Y')) as $year) {
                            echo "<option value='$year' " . ($year == $tahunFilter ? 'selected' : '') . ">$year</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <button type="submit" class="btn btn-warning-custom w-100">
                        <i class="bi bi-search"></i> Filter Data
                    </button>
                </div>
            </div>
        </form>
    </div>


    <!-- Persentase Penyelesaian Perkara Tepat Waktu -->
    <!-- Data Tahun Berjalan -->
    <div class="row mb-2">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-bar-chart-line"></i> Persentase Penyelesaian Perkara Tepat Waktu - Tahun Berjalan (<?php echo $tahunFilter; ?>)
            </h5>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Jumlah Perkara Diselesaikan Tepat Waktu</div>
                            <div class="stat-value"><?php echo number_format($dataShowTotal['totalTahunBerjalan']['jlhPerkaraSelesaiTepatWaktu']); ?></div>
                            <small class="text-success"> Selesai Tepat Waktu</small>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-folder"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Jumlah Perkara Diselesaikan</div>
                            <div class="stat-value"><?php echo number_format($dataShowTotal['totalTahunBerjalan']['jlhPerkaraSelesai']); ?></div>
                            <small class="text-success"> Perkara Selesai</small>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.3s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Persentase %</div>
                            <div class="stat-value"><?php echo number_format($dataShowTotal['totalTahunBerjalan']['persentase'], 2); ?>%</div>
                            <small class="text-success"> Capaian</small>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tahun Lalu -->
    <div class="row mb-2">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-calendar-check"></i> Persentase Penyelesaian Perkara Tepat Waktu - Tahun Lalu yang Selesai di <?php echo $tahunFilter; ?> (Pendaftaran <?php echo $tahunFilter - 1; ?>)
            </h5>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.1s; border-left: 4px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Jumlah Perkara Diselesaikan Tepat Waktu</div>
                            <div class="stat-value"><?php echo number_format($dataShowTotal['totalTahunBelakang']['jlhPerkaraSelesaiTepatWaktu']); ?></div>
                            <small class="text-warning"> Selesai Tepat Waktu</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="bi bi-folder"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.2s; border-left: 4px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Jumlah Perkara Diselesaikan</div>
                            <div class="stat-value"><?php echo number_format($dataShowTotal['totalTahunBelakang']['jlhPerkaraSelesai']); ?></div>
                            <small class="text-warning"> Perkara Selesai</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.3s; border-left: 4px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Persentase %</div>
                            <div class="stat-value"><?php echo number_format($dataShowTotal['totalTahunBelakang']['persentase'], 2); ?>%</div>
                            <small class="text-warning"> Capaian</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="bi bi-graph-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Gabungan -->
    <div class="row mb-2">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-calculator"></i> Total Gabungan Persentase (Rata-Rata Tahun Berjalan & Tahun Lalu)
            </h5>
        </div>
    </div>
    <div class="row mb-4">
        <?php
        // Hitung total gabungan
        $totalTepatWaktuGabungan = $dataShowTotal['totalTahunBerjalan']['jlhPerkaraSelesaiTepatWaktu'] + $dataShowTotal['totalTahunBelakang']['jlhPerkaraSelesaiTepatWaktu'];
        $totalSelesaiGabungan = $dataShowTotal['totalTahunBerjalan']['jlhPerkaraSelesai'] + $dataShowTotal['totalTahunBelakang']['jlhPerkaraSelesai'];
        $persentaseGabungan = ($totalSelesaiGabungan == 0) ? 0 : ($totalTepatWaktuGabungan / $totalSelesaiGabungan * 100);
        ?>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.1s; border-left: 4px solid #28a745;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Perkara Diselesaikan Tepat Waktu</div>
                            <div class="stat-value"><?php echo number_format($totalTepatWaktuGabungan); ?></div>
                            <small class="text-success"><i class="bi bi-plus-circle"></i> Gabungan</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="bi bi-folder-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.2s; border-left: 4px solid #28a745;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Perkara Diselesaikan</div>
                            <div class="stat-value"><?php echo number_format($totalSelesaiGabungan); ?></div>
                            <small class="text-success"><i class="bi bi-plus-circle"></i> Gabungan</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="bi bi-check-all"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.3s; border-left: 4px solid #28a745;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Persentase Gabungan %</div>
                            <div class="stat-value"><?php echo number_format($persentaseGabungan, 2); ?>%</div>
                            <small class="text-success"><i class="bi bi-calculator"></i> Rata-Rata</small>
                        </div>
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Wrapper -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="section-title mb-3"><i class="bi bi-bar-chart-line"></i> Detail Penyelesaian & Jenis Perkara</h5>
            <ul class="nav nav-tabs" id="pers11Tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="triwulan-tab" data-bs-toggle="tab" data-bs-target="#triwulan" type="button" role="tab">Per Triwulan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bulan-tab" data-bs-toggle="tab" data-bs-target="#bulan" type="button" role="tab">Per Bulan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="jenis-tab" data-bs-toggle="tab" data-bs-target="#jenis" type="button" role="tab">Jenis Perkara</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="grafik-tab" data-bs-toggle="tab" data-bs-target="#grafik" type="button" role="tab">Grafik</button>
                </li>
            </ul>
            <div class="tab-content border border-top-0 p-3 bg-white rounded-bottom shadow-sm">
                <div class="tab-pane fade show active" id="triwulan" role="tabpanel">
                    <h6 class="mb-3">Data Tahun Berjalan (<?php echo $tahunFilter; ?>)</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-responsive align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Triwulan</th>
                                    <th>Jumlah Perkara Diselesaikan Tepat Waktu</th>
                                    <th>Jumlah Perkara Diselesaikan</th>
                                    <th>Persentase %</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dataShowPertriwulan['pertriwulanTahunBerjalan'] as $triwulan => $data) {
                                    echo "<tr><td>{$no}</td><td>Triwulan {$triwulan}</td><td>" . number_format($data['jlhPerkaraSelesaiTepatWaktu']) . "</td><td>" . number_format($data['jlhPerkaraSelesai']) . "</td><td>" . number_format($data['persentase'], 2) . "%</td></tr>";
                                    $no++;
                                } ?>
                                <tr>
                                    <td colspan="2" class="fw-bold text-center">Total</td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBerjalan']['jlhPerkaraSelesaiTepatWaktu']); ?></td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBerjalan']['jlhPerkaraSelesai']); ?></td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBerjalan']['persentase'], 2); ?>%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mb-3">Data Tahun Lalu yang Selesai di Tahun <?php echo $tahunFilter; ?> (Pendaftaran <?php echo $tahunFilter - 1; ?>)</h6>
                    <div class="table-responsive">
                        <table class="table table-responsive align-middle">
                            <thead class="table-warning">
                                <tr>
                                    <th>No</th>
                                    <th>Triwulan</th>
                                    <th>Jumlah Perkara Diselesaikan Tepat Waktu</th>
                                    <th>Jumlah Perkara Diselesaikan</th>
                                    <th>Persentase %</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dataShowPertriwulan['pertriwulanTahunBelakang'] as $triwulan => $data) {
                                    echo "<tr><td>{$no}</td><td>Triwulan {$triwulan}</td><td>" . number_format($data['jlhPerkaraSelesaiTepatWaktu']) . "</td><td>" . number_format($data['jlhPerkaraSelesai']) . "</td><td>" . number_format($data['persentase'], 2) . "%</td></tr>";
                                    $no++;
                                } ?>
                                <tr>
                                    <td colspan="2" class="fw-bold text-center">Total</td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBelakang']['jlhPerkaraSelesaiTepatWaktu']); ?></td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBelakang']['jlhPerkaraSelesai']); ?></td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBelakang']['persentase'], 2); ?>%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="bulan" role="tabpanel">
                    <h6 class="mb-3">Data Tahun Berjalan (<?php echo $tahunFilter; ?>)</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-responsive align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Jumlah Perkara Diselesaikan Tepat Waktu</th>
                                    <th>Jumlah Perkara Diselesaikan</th>
                                    <th>Persentase %</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dataShowPerbulan['perbulanTahunBerjalan'] as $bulan => $data) {
                                    echo "<tr><td>{$no}</td><td>{$namaBulan[$bulan]}</td><td>" . number_format($data['jlhPerkaraSelesaiTepatWaktu']) . "</td><td>" . number_format($data['jlhPerkaraSelesai']) . "</td><td>" . number_format($data['persentase'], 2) . "%</td></tr>";
                                    $no++;
                                } ?>
                                <tr>
                                    <td colspan="2" class="fw-bold text-center">Total</td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBerjalan']['jlhPerkaraSelesaiTepatWaktu']); ?></td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBerjalan']['jlhPerkaraSelesai']); ?></td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBerjalan']['persentase'], 2); ?>%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mb-3">Data Tahun Lalu yang Selesai di Tahun <?php echo $tahunFilter; ?> (Pendaftaran <?php echo $tahunFilter - 1; ?>)</h6>
                    <div class="table-responsive">
                        <table class="table table-responsive align-middle">
                            <thead class="table-warning">
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Jumlah Perkara Diselesaikan Tepat Waktu</th>
                                    <th>Jumlah Perkara Diselesaikan</th>
                                    <th>Persentase %</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dataShowPerbulan['perbulanTahunBelakang'] as $bulan => $data) {
                                    echo "<tr><td>{$no}</td><td>{$namaBulan[$bulan]}</td><td>" . number_format($data['jlhPerkaraSelesaiTepatWaktu']) . "</td><td>" . number_format($data['jlhPerkaraSelesai']) . "</td><td>" . number_format($data['persentase'], 2) . "%</td></tr>";
                                    $no++;
                                } ?>
                                <tr>
                                    <td colspan="2" class="fw-bold text-center">Total</td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBelakang']['jlhPerkaraSelesaiTepatWaktu']); ?></td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBelakang']['jlhPerkaraSelesai']); ?></td>
                                    <td><?php echo number_format($dataShowTotal['totalTahunBelakang']['persentase'], 2); ?>%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="jenis" role="tabpanel">
                    <h6 class="mb-3">Data Tahun Berjalan (<?php echo $tahunFilter; ?>)</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-responsive align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Perkara</th>
                                    <th>Jumlah Perkara Diputus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dataShowJenisPerkara['jenisPerkaraTahunBerjalan'] as $jenis) {
                                    $namaJenis = !empty($jenis['jenis_perkara_text']) ? $jenis['jenis_perkara_text'] : $jenis['jenis_perkara_nama'];
                                    echo "<tr><td>{$no}</td><td>{$namaJenis}</td><td>" . number_format($jenis['total_jenis_perkara']) . "</td></tr>";
                                    $no++;
                                } ?>
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mb-3">Data Tahun Lalu yang Diputus di Tahun <?php echo $tahunFilter; ?> (Pendaftaran <?php echo $tahunFilter - 1; ?>)</h6>
                    <div class="table-responsive">
                        <table class="table table-responsive align-middle">
                            <thead class="table-warning">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Perkara</th>
                                    <th>Jumlah Perkara Diputus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dataShowJenisPerkara['jenisPerkaraTahunBelakang'] as $jenis) {
                                    $namaJenis = !empty($jenis['jenis_perkara_text']) ? $jenis['jenis_perkara_text'] : $jenis['jenis_perkara_nama'];
                                    echo "<tr><td>{$no}</td><td>{$namaJenis}</td><td>" . number_format($jenis['total_jenis_perkara']) . "</td></tr>";
                                    $no++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="grafik" role="tabpanel">
                    <h6 class="mb-3">Grafik Data Tahun Berjalan (<?php echo $tahunFilter; ?>)</h6>
                    <div class="chart-container mb-4"><canvas id="barChartBerjalan"></canvas></div>

                    <h6 class="mb-3">Grafik Data Tahun Lalu yang Diputus di Tahun <?php echo $tahunFilter; ?> (Pendaftaran <?php echo $tahunFilter - 1; ?>)</h6>
                    <div class="chart-container"><canvas id="barChartBelakang"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail List Perkara -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="section-title mb-3"><i class="bi bi-list-ul"></i> Detail List Perkara Tahun <?php echo $tahunFilter; ?></h5>
            <ul class="nav nav-tabs" id="listPerkaraTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tahun-berjalan-tab" data-bs-toggle="tab" data-bs-target="#tahun-berjalan" type="button" role="tab">Perkara Tahun Berjalan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tahun-lalu-tab" data-bs-toggle="tab" data-bs-target="#tahun-lalu" type="button" role="tab">Perkara Tahun Lalu (<?php echo $tahunFilter - 1; ?>)</button>
                </li>
            </ul>
            <div class="tab-content border border-top-0 p-3 bg-white rounded-bottom shadow-sm">
                <!-- Tab Perkara Tahun Berjalan -->
                <div class="tab-pane fade show active" id="tahun-berjalan" role="tabpanel">
                    <!-- Export Buttons -->
                    <div class="mb-3 d-flex gap-2">
                        <a href="function/exportPersentase11.php?tahun=<?php echo $tahunFilter; ?>&type=berjalan&status=all" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Semua Data
                        </a>
                        <a href="function/exportPersentase11.php?tahun=<?php echo $tahunFilter; ?>&type=berjalan&status=tepat_waktu" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Tepat Waktu
                        </a>
                        <a href="function/exportPersentase11.php?tahun=<?php echo $tahunFilter; ?>&type=berjalan&status=tidak_tepat_waktu" class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Tidak Tepat Waktu
                        </a>
                    </div>

                    <h6 class="mb-3"><i class="bi bi-check-circle-fill text-success"></i> Perkara Tepat Waktu (≤150 hari)</h6>
                    <div class="table-responsive mb-4">
                        <table id="tableTepatWaktuBerjalan" class="table table-striped table-hover align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Perkara</th>
                                    <th>Tanggal Pendaftaran</th>
                                    <th>Tanggal Minutasi</th>
                                    <th>Jumlah Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($dataListPerkara['perkaraTahunBerjalan']['perkaraTepatWaktu'] as $perkara) {
                                    echo "<tr>";
                                    echo "<td>{$no}</td>";
                                    echo "<td>{$perkara['nomor_perkara']}</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($perkara['tanggal_pendaftaran'])) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($perkara['tanggal_minutasi'])) . "</td>";
                                    echo "<td><span class='badge bg-success'>{$perkara['jumlah_hari']} hari</span></td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mb-3"><i class="bi bi-exclamation-circle-fill text-danger"></i> Perkara Tidak Tepat Waktu (>150 hari)</h6>
                    <div class="table-responsive">
                        <table id="tableTidakTepatWaktuBerjalan" class="table table-striped table-hover align-middle">
                            <thead class="table-danger">
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Perkara</th>
                                    <th>Tanggal Pendaftaran</th>
                                    <th>Tanggal Minutasi</th>
                                    <th>Jumlah Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($dataListPerkara['perkaraTahunBerjalan']['perkaraTidakTepatWaktu'] as $perkara) {
                                    echo "<tr>";
                                    echo "<td>{$no}</td>";
                                    echo "<td>{$perkara['nomor_perkara']}</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($perkara['tanggal_pendaftaran'])) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($perkara['tanggal_minutasi'])) . "</td>";
                                    echo "<td><span class='badge bg-danger'>{$perkara['jumlah_hari']} hari</span></td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Perkara Tahun Lalu -->
                <div class="tab-pane fade" id="tahun-lalu" role="tabpanel">
                    <!-- Export Buttons -->
                    <div class="mb-3 d-flex gap-2">
                        <a href="function/exportPersentase11.php?tahun=<?php echo $tahunFilter; ?>&type=lalu&status=all" class="btn btn-warning btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Semua Data
                        </a>
                        <a href="function/exportPersentase11.php?tahun=<?php echo $tahunFilter; ?>&type=lalu&status=tepat_waktu" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Tepat Waktu
                        </a>
                        <a href="function/exportPersentase11.php?tahun=<?php echo $tahunFilter; ?>&type=lalu&status=tidak_tepat_waktu" class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Tidak Tepat Waktu
                        </a>
                    </div>

                    <h6 class="mb-3"><i class="bi bi-check-circle-fill text-success"></i> Perkara Tepat Waktu (≤150 hari)</h6>
                    <div class="table-responsive mb-4">
                        <table id="tableTepatWaktuLalu" class="table table-striped table-hover align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Perkara</th>
                                    <th>Tanggal Pendaftaran</th>
                                    <th>Tanggal Minutasi</th>
                                    <th>Jumlah Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($dataListPerkara['perkaraTahunBelakang']['perkaraTepatWaktu'] as $perkara) {
                                    echo "<tr>";
                                    echo "<td>{$no}</td>";
                                    echo "<td>{$perkara['nomor_perkara']}</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($perkara['tanggal_pendaftaran'])) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($perkara['tanggal_minutasi'])) . "</td>";
                                    echo "<td><span class='badge bg-success'>{$perkara['jumlah_hari']} hari</span></td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mb-3"><i class="bi bi-exclamation-circle-fill text-danger"></i> Perkara Tidak Tepat Waktu (>150 hari)</h6>
                    <div class="table-responsive">
                        <table id="tableTidakTepatWaktuLalu" class="table table-striped table-hover align-middle">
                            <thead class="table-danger">
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Perkara</th>
                                    <th>Tanggal Pendaftaran</th>
                                    <th>Tanggal Minutasi</th>
                                    <th>Jumlah Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($dataListPerkara['perkaraTahunBelakang']['perkaraTidakTepatWaktu'] as $perkara) {
                                    echo "<tr>";
                                    echo "<td>{$no}</td>";
                                    echo "<td>{$perkara['nomor_perkara']}</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($perkara['tanggal_pendaftaran'])) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($perkara['tanggal_minutasi'])) . "</td>";
                                    echo "<td><span class='badge bg-danger'>{$perkara['jumlah_hari']} hari</span></td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables untuk semua tabel
            $('#tableTepatWaktuBerjalan').DataTable({
                order: [
                    [0, 'asc']
                ],
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                // }
            });

            $('#tableTidakTepatWaktuBerjalan').DataTable({
                order: [
                    [0, 'asc']
                ],
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                // }
            });

            $('#tableTepatWaktuLalu').DataTable({
                order: [
                    [0, 'asc']
                ],
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                // }
            });

            $('#tableTidakTepatWaktuLalu').DataTable({
                order: [
                    [0, 'asc']
                ],
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                // }
            });
        });
        // Data untuk Bar Chart Tahun Berjalan
        const jenisPerkaraBerjalan = <?php echo json_encode(array_map(function ($item) {
                                            return !empty($item['jenis_perkara_text']) ? $item['jenis_perkara_text'] : $item['jenis_perkara_nama'];
                                        }, $dataShowJenisPerkara['jenisPerkaraTahunBerjalan'])); ?>;

        const jumlahPerkaraBerjalan = <?php echo json_encode(array_map(function ($item) {
                                            return $item['total_jenis_perkara'];
                                        }, $dataShowJenisPerkara['jenisPerkaraTahunBerjalan'])); ?>;

        // Data untuk Bar Chart Tahun Belakang
        const jenisPerkaraBelakang = <?php echo json_encode(array_map(function ($item) {
                                            return !empty($item['jenis_perkara_text']) ? $item['jenis_perkara_text'] : $item['jenis_perkara_nama'];
                                        }, $dataShowJenisPerkara['jenisPerkaraTahunBelakang'])); ?>;

        const jumlahPerkaraBelakang = <?php echo json_encode(array_map(function ($item) {
                                            return $item['total_jenis_perkara'];
                                        }, $dataShowJenisPerkara['jenisPerkaraTahunBelakang'])); ?>;

        const chartColors = [
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 99, 132, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(199, 199, 199, 0.8)',
            'rgba(83, 102, 255, 0.8)',
            'rgba(255, 99, 255, 0.8)',
            'rgba(99, 255, 132, 0.8)'
        ];

        const chartBorderColors = [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(199, 199, 199, 1)',
            'rgba(83, 102, 255, 1)',
            'rgba(255, 99, 255, 1)',
            'rgba(99, 255, 132, 1)'
        ];

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' perkara';
                        }
                    }
                }
            }
        };

        // Konfigurasi Bar Chart Tahun Berjalan
        const ctxBerjalan = document.getElementById('barChartBerjalan').getContext('2d');
        const barChartBerjalan = new Chart(ctxBerjalan, {
            type: 'bar',
            data: {
                labels: jenisPerkaraBerjalan,
                datasets: [{
                    label: 'Jumlah Perkara Tahun Berjalan',
                    data: jumlahPerkaraBerjalan,
                    backgroundColor: chartColors,
                    borderColor: chartBorderColors,
                    borderWidth: 1
                }]
            },
            options: chartOptions
        });

        // Konfigurasi Bar Chart Tahun Belakang
        const ctxBelakang = document.getElementById('barChartBelakang').getContext('2d');
        const barChartBelakang = new Chart(ctxBelakang, {
            type: 'bar',
            data: {
                labels: jenisPerkaraBelakang,
                datasets: [{
                    label: 'Jumlah Perkara Tahun Lalu',
                    data: jumlahPerkaraBelakang,
                    backgroundColor: chartColors,
                    borderColor: chartBorderColors,
                    borderWidth: 1
                }]
            },
            options: chartOptions
        });

        // Resize saat tab grafik ditampilkan
        document.getElementById('grafik-tab').addEventListener('shown.bs.tab', () => {
            barChartBerjalan.resize();
            barChartBelakang.resize();
        });
    </script>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5">
        <p class="text-muted">&copy; 2025 Perencanaan TI dan Pelaporan. All rights reserved.</p>
    </footer>

</div>