<?php
// Proses filter data
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'function/getPersentase11.php';
$tahunFilter = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

try {
    $persentase = new GetPersentase11();
    $dataTotal = $persentase->total($tahunFilter);
    $dataPerbulan = $persentase->perbulan($tahunFilter);
    $dataPertriwulan = $persentase->pertriwulan($tahunFilter);
    $dataListPerkara = $persentase->showListPerkara($tahunFilter);
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
    <div class="row mb-4">
        <div class="col-lg-12">
            <h5 class="section-title">
                <i class="bi bi-bar-chart-line"></i> Persentase Penyelesaian Perkara Tepat Waktu - Tahun <?php echo $tahunFilter; ?>
            </h5>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card animate-fade-in" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Jumlah Perkara Diselesaikan Tepat Waktu</div>
                            <div class="stat-value"><?php echo number_format($dataTotal['jlhPerkaraSelesaiTepatWaktu']); ?></div>
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
                            <div class="stat-value"><?php echo number_format($dataTotal['jlhPerkaraSelesai']); ?></div>
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
                    <div class="table-responsive">
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
                                foreach ($dataPertriwulan as $triwulan => $data) {
                                    echo "<tr><td>{$no}</td><td>Triwulan {$triwulan}</td><td>" . number_format($data['jlhPerkaraSelesaiTepatWaktu']) . "</td><td>" . number_format($data['jlhPerkaraSelesai']) . "</td><td>" . number_format($data['persentase'], 2) . "%</td></tr>";
                                    $no++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="bulan" role="tabpanel">
                    <div class="table-responsive">
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
                                foreach ($dataPerbulan as $bulan => $data) {
                                    echo "<tr><td>{$no}</td><td>{$namaBulan[$bulan]}</td><td>" . number_format($data['jlhPerkaraSelesaiTepatWaktu']) . "</td><td>" . number_format($data['jlhPerkaraSelesai']) . "</td><td>" . number_format($data['persentase'], 2) . "%</td></tr>";
                                    $no++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="jenis" role="tabpanel">
                    <div class="table-responsive">
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
                                foreach ($dataTotal['detailJenisPerkara'] as $jenis) {
                                    $namaJenis = !empty($jenis['jenis_perkara_text']) ? $jenis['jenis_perkara_text'] : $jenis['jenis_perkara_nama'];
                                    echo "<tr><td>{$no}</td><td>{$namaJenis}</td><td>" . number_format($jenis['total_jenis_perkara']) . "</td></tr>";
                                    $no++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="grafik" role="tabpanel">
                    <div class="chart-container"><canvas id="barChart"></canvas></div>
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
        // Resize saat tab grafik ditampilkan
        document.getElementById('grafik-tab').addEventListener('shown.bs.tab', () => {
            barChart.resize();
        });
    </script>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5">
        <p class="text-muted">&copy; 2025 Perencanaan TI dan Pelaporan. All rights reserved.</p>
    </footer>

</div>