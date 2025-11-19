<?php
// Proses filter data
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'function/getPersentase111.php';
$tahunFilter = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

try {
    $persentase = new GetPersentase111();
    $dataTotal = $persentase->total($tahunFilter);
    $dataPerbulan = $persentase->perbulan($tahunFilter);
    $dataPertriwulan = $persentase->pertriwulan($tahunFilter);
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
            <input type="hidden" name="page" value="capaian_persentase_111">
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


    <!-- Persentase Pelimpahan Perkara Pidana E-Berpadu -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-bar-chart-line"></i> Persentase Pelimpahan Perkara Pidana E-Berpadu - Tahun <?php echo $tahunFilter; ?>
            </h5>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Jumlah Perkara E-Berpadu</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['jlhPerkaraEberpadu']); ?></div>
                            <small class="text-success"> Perkara E-Berpadu</small>
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
                            <div class="stat-label">Jumlah Pelimpahan Perkara</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['jlhPelimpahanPerkara']); ?></div>
                            <small class="text-success"> Pelimpahan Perkara</small>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-check-circle"></i>
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
                            <div class="stat-label">Total Persentase %</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['persentase'], 2); ?>%</div>
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

    <!-- Tabs Wrapper -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="section-title mb-3"><i class="bi bi-bar-chart-line"></i> Detail Pelimpahan & Jenis Perkara</h5>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#triwulan" type="button">Per Triwulan</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#bulan" type="button">Per Bulan</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jenis" type="button">Jenis Perkara</button></li>
                <li class="nav-item"><button class="nav-link" id="grafik-tab" data-bs-toggle="tab" data-bs-target="#grafik" type="button">Grafik</button></li>
            </ul>
            <div class="tab-content border border-top-0 p-3 bg-white rounded-bottom shadow-sm">
                <div class="tab-pane fade show active" id="triwulan">
                    <div class="table-responsive">
                        <table class="table table-responsive align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Triwulan</th>
                                    <th>Jumlah Perkara E-Berpadu</th>
                                    <th>Jumlah Pelimpahan Perkara</th>
                                    <th>Persentase %</th>
                                </tr>
                            </thead>
                            <tbody><?php $totalJlhPerkaraEberpadu = 0;
                                    $totalJlhPerkaraPelimpahan = 0;
                                    $overallPersentaseTotal = 0;
                                    $no = 1;
                                    foreach ($dataPertriwulan as $triwulan => $data) {
                                        $totalJlhPerkaraEberpadu += $data['jlhPerkaraEberpadu'];
                                        $totalJlhPerkaraPelimpahan += $data['jlhPelimpahanPerkara'];
                                        $overallPersentaseTotal += $data['persentase'];
                                        echo "<tr><td>{$no}</td><td>Triwulan {$triwulan}</td><td>" . number_format($data['jlhPerkaraEberpadu']) . "</td><td>" . number_format($data['jlhPelimpahanPerkara']) . "</td><td>" . number_format($data['persentase'], 2) . "%</td></tr>";
                                        $no++;
                                    }
                                    echo "<tr class='table-light fw-bold'><td colspan='2' class='text-center'>Total</td><td>" . number_format($totalJlhPerkaraEberpadu) . "</td><td>" . number_format($totalJlhPerkaraPelimpahan) . "</td><td>" . number_format($overallPersentaseTotal, 2) . "%</td></tr>"; ?></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="bulan">
                    <div class="table-responsive">
                        <table class="table table-responsive align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Jumlah Perkara E-Berpadu</th>
                                    <th>Jumlah Pelimpahan Perkara</th>
                                    <th>Persentase %</th>
                                </tr>
                            </thead>
                            <tbody><?php $no = 1;
                                    $totalJlhPerkaraEberpaduBulan = 0;
                                    $totalJlhPerkaraPelimpahanBulan = 0;
                                    $overallPersentaseTotalBulan = 0;
                                    foreach ($dataPerbulan as $bulan => $data) {
                                        $totalJlhPerkaraEberpaduBulan += $data['jlhPerkaraEberpadu'];
                                        $totalJlhPerkaraPelimpahanBulan += $data['jlhPelimpahanPerkara'];
                                        $overallPersentaseTotalBulan += $data['persentase'];
                                        echo "<tr><td>{$no}</td><td>{$namaBulan[$bulan]}</td><td>" . number_format($data['jlhPerkaraEberpadu']) . "</td><td>" . number_format($data['jlhPelimpahanPerkara']) . "</td><td>" . number_format($data['persentase'], 2) . "%</td></tr>";
                                        $no++;
                                    }
                                    echo "<tr class='table-light fw-bold'><td colspan='2' class='text-center'>Total</td><td>" . number_format($totalJlhPerkaraEberpaduBulan) . "</td><td>" . number_format($totalJlhPerkaraPelimpahanBulan) . "</td><td>" . number_format($overallPersentaseTotalBulan, 2) . "%</td></tr>"; ?></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="jenis">
                    <div class="table-responsive">
                        <table class="table table-responsive align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Perkara</th>
                                    <th>Jumlah Perkara Dilimpahkan</th>
                                </tr>
                            </thead>
                            <tbody><?php $no = 1;
                                    foreach ($dataTotal['detailJenisPerkara'] as $jenis) {
                                        $namaJenis = !empty($jenis['jenis_perkara_text']) ? $jenis['jenis_perkara_text'] : $jenis['jenis_perkara_nama'];
                                        echo "<tr><td>{$no}</td><td>{$namaJenis}</td><td>" . number_format($jenis['total_jenis_perkara']) . "</td></tr>";
                                        $no++;
                                    } ?></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="grafik">
                    <div class="chart-container"><canvas id="barChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data untuk Bar Chart
        const jenisPerkara = <?php echo json_encode(array_map(function ($item) {
                                    return !empty($item['jenis_perkara_text']) ? $item['jenis_perkara_text'] : $item['jenis_perkara_nama'];
                                }, $dataTotal['detailJenisPerkara'])); ?>;

        const jumlahPerkara = <?php echo json_encode(array_map(function ($item) {
                                    return $item['total_jenis_perkara'];
                                }, $dataTotal['detailJenisPerkara'])); ?>;

        // Konfigurasi Bar Chart
        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: jenisPerkara,
                datasets: [{
                    label: 'Jumlah Perkara',
                    data: jumlahPerkara,
                    backgroundColor: [
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
                    ],
                    borderColor: [
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
                    ],
                    borderWidth: 1
                }]
            },
            options: {
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
            }
        });
        document.getElementById('grafik-tab').addEventListener('shown.bs.tab', () => {
            barChart.resize();
        });
    </script>




    <!-- Footer -->
    <footer class="text-center py-4 mt-5">
        <p class="text-muted">&copy; 2025 Perencanaan TI dan Pelaporan. All rights reserved.</p>
    </footer>

</div>