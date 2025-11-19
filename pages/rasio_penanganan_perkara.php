<?php
// Proses filter data
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'function/getRasioPenangananPerkara.php';
$tahunFilter = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

try {
    $rasio = new getRasioPenangananPerkara();
    $dataTotal = $rasio->getRasioPenangananPerkara($tahunFilter);
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

// Hitung total untuk grafik
$totalPerkara = $dataTotal['masuk'] + $dataTotal['sisa'];
?>

<div class="container px-4">

    <!-- Filter Section -->
    <div class="filter-card animate-fade-in">
        <form method="GET" action="">
            <input type="hidden" name="page" value="rasio_penanganan_perkara">
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


    <!-- Persentase Rasio Penanganan Perkara Tepat Waktu -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-bar-chart-line"></i> Persentase Rasio Penanganan Perkara Tepat Waktu - Tahun <?php echo $tahunFilter; ?>
            </h5>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Jumlah Perkara Masuk</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['masuk']); ?></div>
                            <small class="text-success"> Perkara Masuk</small>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-folder-plus"></i>
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
                            <div class="stat-label">Jumlah Minutasi Perkara</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['minutasi']); ?></div>
                            <small class="text-success"> Perkara Diminutasi</small>
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
                            <div class="stat-label">Jumlah Sisa Perkara Tahun Lalu</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['sisa']); ?></div>
                            <small class="text-warning"> Sisa Perkara</small>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.4s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Jumlah Tunggakan Perkara</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['tunggakan']); ?></div>
                            <small class="text-danger"> Perkara Tunggakan</small>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.5s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Kinerja PN / Persentase %</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['persentase'], 2); ?>%</div>
                            <small class="text-success"> Capaian Kinerja</small>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-lg-4 mb-4">
            <div class="chart-container animate-fade-in">
                <h5 class="section-title">
                    <i class="bi bi-pie-chart"></i> Grafik Rasio Penanganan Perkara
                </h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
        <div class="col-lg-8 mb-4">
            <div class="chart-container animate-fade-in">
                <h5 class="section-title">
                    <i class="bi bi-bar-chart"></i> Grafik Perbandingan Status Perkara
                </h5>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5">
        <p class="text-muted">&copy; 2025 Perencanaan TI dan Pelaporan. All rights reserved.</p>
    </footer>

</div>

<script>
    // Pie Chart - Rasio Penanganan Perkara
    const ctxPie = document.getElementById("pieChart").getContext("2d");
    const pieChart = new Chart(ctxPie, {
        type: "doughnut",
        data: {
            labels: ["Perkara Diminutasi", "Sisa Perkara", "Tunggakan"],
            datasets: [{
                data: [
                    <?php echo $dataTotal['minutasi']; ?>,
                    <?php echo $dataTotal['sisa']; ?>,
                    <?php echo $dataTotal['tunggakan']; ?>
                ],
                backgroundColor: ["#198754", "#ffc107", "#dc3545"],
                borderWidth: 3,
                borderColor: "#fff",
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: "bottom",
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            weight: "bold",
                        },
                    },
                },
                tooltip: {
                    backgroundColor: "rgba(0, 0, 0, 0.8)",
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: "bold",
                    },
                    bodyFont: {
                        size: 13,
                    },
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || "";
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ": " + value.toLocaleString() + " (" + percentage + "%)";
                        },
                    },
                },
            },
        },
    });

    // Bar Chart - Perbandingan Status Perkara
    const ctxBar = document.getElementById("barChart").getContext("2d");
    const barChart = new Chart(ctxBar, {
        type: "bar",
        data: {
            labels: ["Masuk", "Minutasi", "Sisa", "Tunggakan"],
            datasets: [{
                label: "Jumlah Perkara",
                data: [
                    <?php echo $dataTotal['masuk']; ?>,
                    <?php echo $dataTotal['minutasi']; ?>,
                    <?php echo $dataTotal['sisa']; ?>,
                    <?php echo $dataTotal['tunggakan']; ?>
                ],
                backgroundColor: [
                    "rgba(13, 110, 253, 0.8)",
                    "rgba(25, 135, 84, 0.8)",
                    "rgba(255, 193, 7, 0.8)",
                    "rgba(220, 53, 69, 0.8)"
                ],
                borderColor: [
                    "rgb(13, 110, 253)",
                    "rgb(25, 135, 84)",
                    "rgb(255, 193, 7)",
                    "rgb(220, 53, 69)"
                ],
                borderWidth: 2,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: "rgba(0, 0, 0, 0.8)",
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: "bold",
                    },
                    bodyFont: {
                        size: 13,
                    },
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return "Jumlah: " + context.parsed.y.toLocaleString() + " perkara";
                        },
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        },
                    },
                },
            },
        },
    });
</script>