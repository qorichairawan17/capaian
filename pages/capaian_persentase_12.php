<?php
// Proses filter data
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'function/getPersentase12.php';
$tahunFilter = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

try {
    $persentase = new GetPersentase12();
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
            <input type="hidden" name="page" value="capaian_persentase_12">
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


    <!-- Persentase Pengiriman Salinan Putusan -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-bar-chart-line"></i> Persentase Pengiriman Salinan Putusan - Tahun <?php echo $tahunFilter; ?>
            </h5>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Jumlah Salinan Putusan</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['jlhSalput']); ?></div>
                            <small class="text-success"> Salinan Putusan</small>
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
                            <div class="stat-label">Jumlah Perkara Diputus</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['jlhPerkaraPutus']); ?></div>
                            <small class="text-success"> Perkara Diputus</small>
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

    <div class="row mb-4">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-bar-chart-line"></i> Detail Pengiriman Salinan Putusan Per Triwulan
            </h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive align-middle animate-fade-in" style="animation-delay: 0.3s">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Triwulan</th>
                                <th>Jumlah Salinan Putusan</th>
                                <th>Jumlah Perkara Diputus</th>
                                <th>Persentase %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($dataPertriwulan as $triwulan => $data) {
                                echo "<tr>";
                                echo "<td>{$no}</td>";
                                echo "<td>Triwulan {$triwulan}</td>";
                                echo "<td>" . number_format($data['jlhSalput']) . "</td>";
                                echo "<td>" . number_format($data['jlhPerkaraPutus']) . "</td>";
                                echo "<td>" . number_format($data['persentase'], 2) . "%</td>";
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

    <div class="row mb-4">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-bar-chart-line"></i> Detail Pengiriman Salinan Putusan Per Bulan
            </h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive align-middle animate-fade-in" style="animation-delay: 0.3s">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>Jumlah Salinan Putusan</th>
                                <th>Jumlah Perkara Diputus</th>
                                <th>Persentase %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($dataPerbulan as $bulan => $data) {
                                echo "<tr>";
                                echo "<td>{$no}</td>";
                                echo "<td>{$namaBulan[$bulan]}</td>";
                                echo "<td>" . number_format($data['jlhSalput']) . "</td>";
                                echo "<td>" . number_format($data['jlhPerkaraPutus']) . "</td>";
                                echo "<td>" . number_format($data['persentase'], 2) . "%</td>";
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

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-bar-chart-line"></i> Detail Jenis Perkara yang Diputus
            </h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive align-middle animate-fade-in" style="animation-delay: 0.3s">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis Perkara</th>
                                <th>Jumlah Perkara Diputus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($dataTotal['detailJenisPerkara'] as $jenis) {
                                $namaJenis = !empty($jenis['jenis_perkara_text']) ? $jenis['jenis_perkara_text'] : $jenis['jenis_perkara_nama'];
                                echo "<tr>";
                                echo "<td>{$no}</td>";
                                echo "<td>{$namaJenis}</td>";
                                echo "<td>" . number_format($jenis['total_jenis_perkara']) . "</td>";
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

    <div class="chart-container animate-fade-in">
        <h5 class="section-title">
            <i class="bi bi-bar-chart-fill"></i> Grafik Jenis Perkara yang Diputus (Teratas 20)
        </h5>
        <canvas id="barChart"></canvas>
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
    </script>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5">
        <p class="text-muted">&copy; 2025 Perencanaan TI dan Pelaporan. All rights reserved.</p>
    </footer>

</div>