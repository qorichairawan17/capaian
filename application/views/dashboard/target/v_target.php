<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Pengisian Target</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">e-Capaian</a></li>
                    <li class="breadcrumb-item active">Pengisian Target</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- ===== Banner ===== -->
<div class="target-banner">
    <div class="d-flex align-items-center gap-3">
        <div class="target-banner-icon">
            <i class="fas fa-bullseye"></i>
        </div>
        <div>
            <h4 class="target-banner-title">Pengisian Target IKU</h4>
            <p class="target-banner-sub">
                Tetapkan target capaian untuk setiap Indikator Kinerja Utama berdasarkan periode Bulanan, Triwulan, Semester, atau Tahunan.
            </p>
        </div>
    </div>
</div>

<!-- ===== Filter Card ===== -->
<div class="target-filter-card">
    <div class="filter-title">
        <i class="fas fa-sliders-h"></i>
        Pilih Indikator & Tahun
    </div>
    <div class="row g-3">
        <div class="col-md-7">
            <label for="target-iku-select">Indikator Kinerja Utama</label>
            <select class="form-select" id="target-iku-select">
                <option value="">— Pilih IKU —</option>
                <?php foreach ($iku_list as $code => $title): ?>
                    <option value="<?= html_escape($code) ?>">
                        IKU <?= html_escape($code) ?> — <?= html_escape($title) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="target-tahun-select">Tahun Anggaran</label>
            <select class="form-select" id="target-tahun-select">
                <?php
                $currentYear = (int) date('Y');
                for ($y = $currentYear + 1; $y >= $currentYear - 3; $y--):
                ?>
                    <option value="<?= $y ?>" <?= ($y === $currentYear) ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-sm w-100" id="btn-load-target"
                    style="background:#38c66c;color:#fff;border-radius:8px;font-weight:600;padding:0.5rem;"
                    disabled>
                <i class="fas fa-sync-alt me-1"></i> Muat
            </button>
        </div>
    </div>
</div>

<!-- ===== IKU Info (hidden by default) ===== -->
<div class="target-iku-info" id="target-iku-info" style="display:none;">
    <div class="iku-info-icon">
        <i class="fas fa-info-circle"></i>
    </div>
    <div>
        <div class="iku-info-code" id="iku-info-code"></div>
        <p class="iku-info-title" id="iku-info-title"></p>
    </div>
</div>

<!-- ===== Periode Tabs ===== -->
<div class="target-tabs" id="target-tabs" style="display:none;">
    <button class="target-tab-btn active" data-type="bulanan">
        <i class="far fa-calendar"></i> Bulanan
    </button>
    <button class="target-tab-btn" data-type="triwulan">
        <i class="fas fa-layer-group"></i> Triwulan
    </button>
    <button class="target-tab-btn" data-type="semester">
        <i class="fas fa-calendar-week"></i> Semester
    </button>
    <button class="target-tab-btn" data-type="tahunan">
        <i class="fas fa-calendar-check"></i> Tahunan
    </button>
</div>

<!-- ===== Target Input Table ===== -->
<div id="target-table-container">
    <!-- Default empty state -->
    <div class="target-table-card">
        <div class="card-body">
            <div class="target-empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h5>Belum Ada Data Target</h5>
                <p>Pilih IKU dan tahun di atas, lalu klik <strong>Muat</strong> untuk mulai mengisi target.</p>
            </div>
        </div>
    </div>
</div>

<!-- ===== Toast container ===== -->
<div id="target-toast-container"></div>

<!-- ===== Script ===== -->
<script>
(function() {
    'use strict';

    // ─── Config ───────────────────────────────────────────────
    var BASE_URL = '<?= site_url() ?>';
    var CSRF_NAME = '<?= $this->security->get_csrf_token_name() ?>';
    var CSRF_HASH = '<?= $this->security->get_csrf_hash() ?>';

    // IKU list from PHP
    var ikuList = <?= json_encode($iku_list) ?>;

    // Periode definitions
    var periodeConfig = {
        bulanan: {
            label: 'Bulanan',
            count: 12,
            names: ['Januari','Februari','Maret','April','Mei','Juni',
                    'Juli','Agustus','September','Oktober','November','Desember']
        },
        triwulan: {
            label: 'Triwulan',
            count: 4,
            names: ['Triwulan I (Jan—Mar)','Triwulan II (Apr—Jun)',
                    'Triwulan III (Jul—Sep)','Triwulan IV (Okt—Des)']
        },
        semester: {
            label: 'Semester',
            count: 2,
            names: ['Semester I (Jan—Jun)','Semester II (Jul—Des)']
        },
        tahunan: {
            label: 'Tahunan',
            count: 1,
            names: ['Target Tahunan']
        }
    };

    // State
    var currentPeriodeType = 'bulanan';
    var loadedTargets = {};
    var isSaving = false;

    // ─── DOM Elements ─────────────────────────────────────────
    var elIkuSelect = document.getElementById('target-iku-select');
    var elTahunSelect = document.getElementById('target-tahun-select');
    var elBtnLoad = document.getElementById('btn-load-target');
    var elIkuInfo = document.getElementById('target-iku-info');
    var elIkuInfoCode = document.getElementById('iku-info-code');
    var elIkuInfoTitle = document.getElementById('iku-info-title');
    var elTabs = document.getElementById('target-tabs');
    var elTableContainer = document.getElementById('target-table-container');
    var elToastContainer = document.getElementById('target-toast-container');

    // ─── Enable load button when IKU is selected ──────────────
    elIkuSelect.addEventListener('change', function() {
        elBtnLoad.disabled = !this.value;
    });

    // ─── Load button ──────────────────────────────────────────
    elBtnLoad.addEventListener('click', function() {
        var ikuCode = elIkuSelect.value;
        if (!ikuCode) return;

        // Show IKU info
        elIkuInfoCode.textContent = 'IKU ' + ikuCode;
        elIkuInfoTitle.textContent = ikuList[ikuCode] || '';
        elIkuInfo.style.display = '';

        // Show tabs
        elTabs.style.display = '';

        // Reset to bulanan tab
        currentPeriodeType = 'bulanan';
        updateActiveTabs();

        // Load data
        loadTargets();
    });

    // ─── Tab clicks ───────────────────────────────────────────
    elTabs.addEventListener('click', function(e) {
        var btn = e.target.closest('.target-tab-btn');
        if (!btn) return;

        currentPeriodeType = btn.getAttribute('data-type');
        updateActiveTabs();
        loadTargets();
    });

    function updateActiveTabs() {
        var btns = elTabs.querySelectorAll('.target-tab-btn');
        for (var i = 0; i < btns.length; i++) {
            btns[i].classList.toggle('active', btns[i].getAttribute('data-type') === currentPeriodeType);
        }
    }

    // ─── Load targets via AJAX ────────────────────────────────
    function loadTargets() {
        var ikuCode = elIkuSelect.value;
        var tahun = elTahunSelect.value;

        if (!ikuCode || !tahun) return;

        // Show loading
        elTableContainer.innerHTML = '<div class="target-table-card"><div class="card-body text-center py-4">' +
            '<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>' +
            '<p class="mt-2 mb-0 text-muted" style="font-size:0.85rem;">Memuat data target...</p></div></div>';

        var url = BASE_URL + 'target/get_targets?iku_code=' + encodeURIComponent(ikuCode) +
                  '&tahun=' + encodeURIComponent(tahun) +
                  '&periode_type=' + encodeURIComponent(currentPeriodeType);

        fetch(url, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(resp) { return resp.json(); })
        .then(function(json) {
            if (json.success) {
                loadedTargets = json.data.targets_map || {};
                renderTable();
            } else {
                showToast(json.message || 'Gagal memuat data.', 'error');
                renderEmptyState();
            }
        })
        .catch(function(err) {
            console.error(err);
            showToast('Terjadi kesalahan jaringan.', 'error');
            renderEmptyState();
        });
    }

    // ─── Render target input table ────────────────────────────
    function renderTable() {
        var config = periodeConfig[currentPeriodeType];
        if (!config) return;

        var ikuCode = elIkuSelect.value;
        var tahun = elTahunSelect.value;

        var html = '<div class="target-table-card">';
        html += '<div class="card-header">';
        html += '<h6><i class="fas fa-edit me-2" style="color:#38c66c"></i>Input Target ' + config.label + ' — IKU ' + escapeHtml(ikuCode) + ' Tahun ' + escapeHtml(tahun) + '</h6>';
        html += '<span style="font-size:0.78rem;color:#94a3b8;">' + config.count + ' periode</span>';
        html += '</div>';
        html += '<div class="card-body">';

        html += '<table class="target-input-table">';
        html += '<thead><tr>';
        html += '<th style="width:50%">Periode</th>';
        html += '<th style="width:30%">Target (%)</th>';
        html += '<th style="width:20%">Status</th>';
        html += '</tr></thead>';
        html += '<tbody>';

        for (var i = 1; i <= config.count; i++) {
            var savedVal = loadedTargets[i] !== undefined ? loadedTargets[i] : '';
            var hasSaved = savedVal !== '';

            html += '<tr>';
            html += '<td>';
            html += '<div class="periode-label">';
            html += '<span class="periode-badge">' + i + '</span>';
            html += escapeHtml(config.names[i - 1]);
            html += '</div>';
            html += '</td>';
            html += '<td>';
            html += '<input type="number" class="target-input" ';
            html += 'data-periode="' + i + '" ';
            html += 'value="' + (hasSaved ? savedVal : '') + '" ';
            html += 'placeholder="0.00" min="0" max="100" step="0.01">';
            html += '</td>';
            html += '<td class="unit-label">';
            if (hasSaved) {
                html += '<span class="target-saved-dot"></span>Tersimpan';
            } else {
                html += '<span style="color:#cbd5e1">—</span>';
            }
            html += '</td>';
            html += '</tr>';
        }

        html += '</tbody></table>';

        // Actions
        html += '<div class="target-actions mt-4">';
        html += '<button type="button" class="btn-target-reset" id="btn-target-reset">';
        html += '<i class="fas fa-undo me-1"></i> Reset</button>';
        html += '<button type="button" class="btn-target-save" id="btn-target-save">';
        html += '<i class="fas fa-save me-1"></i> Simpan Target</button>';
        html += '</div>';

        html += '</div></div>';

        elTableContainer.innerHTML = html;

        // Bind save button
        var btnSave = document.getElementById('btn-target-save');
        if (btnSave) {
            btnSave.addEventListener('click', saveTargets);
        }

        // Bind reset button
        var btnReset = document.getElementById('btn-target-reset');
        if (btnReset) {
            btnReset.addEventListener('click', function() {
                var inputs = elTableContainer.querySelectorAll('.target-input');
                for (var j = 0; j < inputs.length; j++) {
                    inputs[j].value = '';
                }
            });
        }
    }

    // ─── Save targets via AJAX ────────────────────────────────
    function saveTargets() {
        if (isSaving) return;

        var ikuCode = elIkuSelect.value;
        var tahun = elTahunSelect.value;
        var inputs = elTableContainer.querySelectorAll('.target-input');
        var targets = [];

        for (var i = 0; i < inputs.length; i++) {
            var val = inputs[i].value.trim();
            if (val === '') continue; // skip empty

            var fVal = parseFloat(val);
            if (isNaN(fVal) || fVal < 0) {
                showToast('Nilai target harus berupa angka positif.', 'error');
                inputs[i].focus();
                return;
            }

            targets.push({
                periode_value: parseInt(inputs[i].getAttribute('data-periode')),
                target_value: fVal
            });
        }

        if (targets.length === 0) {
            showToast('Tidak ada target yang diisi. Harap isi minimal satu periode.', 'error');
            return;
        }

        // Disable button & show spinner
        isSaving = true;
        var btnSave = document.getElementById('btn-target-save');
        btnSave.disabled = true;
        btnSave.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Menyimpan...';

        var payload = {
            iku_code: ikuCode,
            tahun: parseInt(tahun),
            periode_type: currentPeriodeType,
            targets: targets
        };

        fetch(BASE_URL + 'target/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        })
        .then(function(resp) { return resp.json(); })
        .then(function(json) {
            if (json.success) {
                showToast(json.message || 'Target berhasil disimpan!', 'success');
                // Reload to reflect saved status
                loadTargets();
            } else {
                showToast(json.message || 'Gagal menyimpan target.', 'error');
            }
        })
        .catch(function(err) {
            console.error(err);
            showToast('Terjadi kesalahan jaringan.', 'error');
        })
        .finally(function() {
            isSaving = false;
            if (btnSave) {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="fas fa-save me-1"></i> Simpan Target';
            }
        });
    }

    // ─── Render empty state ───────────────────────────────────
    function renderEmptyState() {
        elTableContainer.innerHTML = '<div class="target-table-card"><div class="card-body">' +
            '<div class="target-empty-state">' +
            '<div class="empty-icon"><i class="fas fa-clipboard-list"></i></div>' +
            '<h5>Belum Ada Data Target</h5>' +
            '<p>Pilih IKU dan tahun di atas, lalu klik <strong>Muat</strong> untuk mulai mengisi target.</p>' +
            '</div></div></div>';
    }

    // ─── Toast notification ───────────────────────────────────
    function showToast(message, type) {
        var icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        var toast = document.createElement('div');
        toast.className = 'target-toast ' + type;
        toast.innerHTML = '<i class="' + icon + '"></i><span>' + escapeHtml(message) + '</span>';
        elToastContainer.appendChild(toast);

        setTimeout(function() {
            toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(30px)';
            setTimeout(function() {
                if (toast.parentNode) toast.parentNode.removeChild(toast);
            }, 300);
        }, 4000);
    }

    // ─── Helpers ──────────────────────────────────────────────
    function escapeHtml(str) {
        if (!str) return '';
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

})();
</script>
