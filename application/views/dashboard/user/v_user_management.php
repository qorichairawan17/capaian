<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Kelola Akun Pengguna</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">e-Capaian</a></li>
                    <li class="breadcrumb-item active">Kelola Akun</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card um-banner">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <span class="badge welcome-badge px-3 py-1 rounded-pill fs-11 fw-bold text-success mb-2"
                            style="background-color: rgba(56, 198, 108, 0.08);">
                            MANAJEMEN AKUN
                        </span>
                        <h3 class="fw-bold text-dark mb-1">Kelola Akun Pengguna Sistem</h3>
                        <p class="text-muted mb-0">Tambah, edit, dan hapus akun pengguna dengan peran Admin atau Operator.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-medium shadow-sm">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="button" class="btn btn-add-user" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                            <i class="fas fa-plus me-2"></i>Tambah Pengguna
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4 g-3">
    <div class="col-md-4">
        <div class="card um-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Total Pengguna</p>
                        <h3 id="stat-total" class="fw-bold mb-0 text-dark"><?php echo $totalCount; ?></h3>
                    </div>
                    <div class="stat-icon icon-total">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card um-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Admin</p>
                        <h3 id="stat-admin" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $adminCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalCount; ?></span> Akun</span>
                        </h3>
                    </div>
                    <div class="stat-icon icon-admin">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card um-stat-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fs-13 fw-medium">Operator</p>
                        <h3 id="stat-operator" class="fw-bold mb-0 text-dark">
                            <span class="value"><?php echo $operatorCount; ?></span>
                            <span class="fs-14 text-muted fw-normal">/ <span class="total-value"><?php echo $totalCount; ?></span> Akun</span>
                        </h3>
                    </div>
                    <div class="stat-icon icon-operator">
                        <i class="fas fa-user-cog"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTable Card -->
<div class="row">
    <div class="col-12">
        <div class="card um-data-card mb-4">
            <div class="card-header bg-transparent border-bottom border-light py-3">
                <h5 class="card-title fw-bold mb-0 text-dark">
                    <i class="fas fa-list-ul me-2 text-success"></i>Daftar Pengguna
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Pengguna</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php $no = 1;
                                foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="um-avatar <?php echo $user->getRole() === 'admin' ? 'um-avatar-admin' : 'um-avatar-operator'; ?>">
                                                    <?php echo strtoupper(substr($user->getName(), 0, 1)); ?>
                                                </span>
                                                <span class="fw-medium text-dark"><?php echo html_escape($user->getName()); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="text-dark bg-light px-2 py-1 rounded-2"
                                                style="font-size: 12.5px;"><?php echo html_escape($user->getUsername()); ?></code>
                                        </td>
                                        <td><?php echo html_escape($user->getEmail()); ?></td>
                                        <td>
                                            <?php if ($user->getRole() === 'admin'): ?>
                                                <span class="badge badge-role-admin">Admin</span>
                                            <?php else: ?>
                                                <span class="badge badge-role-operator">Operator</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo $user->getCreatedAt() ? date('d M Y', strtotime($user->getCreatedAt())) : '-'; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button type="button" class="btn btn-action-edit btn-sm"
                                                    onclick="openEditModal(<?php echo $user->getId(); ?>)" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button type="button" class="btn btn-action-delete btn-sm"
                                                    onclick="confirmDelete(<?php echo $user->getId(); ?>, '<?php echo html_escape(addslashes($user->getName())); ?>')"
                                                    title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add User -->
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddUserLabel">
                    <i class="fas fa-user-plus me-2 text-success"></i>Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAddUser">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add-username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="add-username" name="username" placeholder="Masukkan username" required
                            minlength="3" maxlength="50" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="add-password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="add-password" name="password" placeholder="Minimal 6 karakter" required
                                minlength="6" style="border-radius: 8px 0 0 8px;">
                            <button class="password-toggle-btn" type="button" onclick="togglePassword('add-password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add-name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="add-name" name="name" placeholder="Masukkan nama lengkap" required
                            maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="add-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="add-email" name="email" placeholder="Masukkan alamat email" maxlength="100">
                    </div>
                    <div class="mb-0">
                        <label for="add-role" class="form-label">Role</label>
                        <select class="form-select" id="add-role" name="role" required>
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-add-user" id="btnSubmitAdd">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditUserLabel">
                    <i class="fas fa-user-edit me-2" style="color: #6366f1;"></i>Edit Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser">
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-username-display" class="form-label">Username</label>
                        <input type="text" class="form-control bg-light" id="edit-username-display" disabled style="cursor: not-allowed;">
                        <small class="text-muted">Username tidak dapat diubah.</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit-password" class="form-label">Password Baru <small class="text-muted fw-normal">(kosongkan jika tidak ingin
                                mengubah)</small></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit-password" name="password" placeholder="Masukkan password baru"
                                minlength="6" style="border-radius: 8px 0 0 8px;">
                            <button class="password-toggle-btn" type="button" onclick="togglePassword('edit-password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit-name" name="name" placeholder="Masukkan nama lengkap" required
                            maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-email" name="email" placeholder="Masukkan alamat email" maxlength="100">
                    </div>
                    <div class="mb-0">
                        <label for="edit-role" class="form-label">Role</label>
                        <select class="form-select" id="edit-role" name="role" required>
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn rounded-3 text-white" id="btnSubmitEdit" style="background-color: #6366f1;">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var BASE_URL = '<?php echo site_url(); ?>';

        // Initialize DataTable
        var table = $('#userTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ pengguna",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pengguna",
                infoEmpty: "Tidak ada data pengguna",
                infoFiltered: "(disaring dari _MAX_ total pengguna)",
                zeroRecords: "Tidak ada pengguna yang cocok",
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },
            columnDefs: [
                { orderable: false, targets: [6] }
            ],
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination");
                $(".dataTables_length select").addClass("form-select form-select-sm");
            }
        });

        // ── Toast Notification ──
        function showToast(message, type) {
            var iconClass = type === 'success' ? 'fas fa-check' : 'fas fa-times';
            var toastHtml = '<div class="um-toast um-toast-' + type + '" id="umToast">' +
                '<div class="um-toast-icon"><i class="' + iconClass + '"></i></div>' +
                '<span>' + escapeHtml(message) + '</span>' +
                '</div>';

            // Remove existing toast
            $('#umToast').remove();
            $('body').append(toastHtml);

            setTimeout(function () {
                $('#umToast').fadeOut(300, function () { $(this).remove(); });
            }, 3500);
        }

        // ── Reload table and stats via AJAX ──
        function reloadData() {
            $.ajax({
                url: BASE_URL + 'usermanagement/get_all',
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        // Update stats
                        $('#stat-total').text(res.totalCount);
                        $('#stat-admin .value').text(res.adminCount);
                        $('#stat-admin .total-value').text(res.totalCount);
                        $('#stat-operator .value').text(res.operatorCount);
                        $('#stat-operator .total-value').text(res.totalCount);

                        // Rebuild table
                        table.clear();
                        if (res.data && res.data.length > 0) {
                            $.each(res.data, function (i, u) {
                                var avatarClass = u.role === 'admin' ? 'um-avatar-admin' : 'um-avatar-operator';
                                var initial = u.name ? u.name.charAt(0).toUpperCase() : '?';
                                var badgeRole = u.role === 'admin'
                                    ? '<span class="badge badge-role-admin">Admin</span>'
                                    : '<span class="badge badge-role-operator">Operator</span>';
                                var createdAt = u.created_at ? formatDate(u.created_at) : '-';
                                var nameSafe = escapeHtml(u.name).replace(/'/g, "\\'");

                                var userCol = '<div class="d-flex align-items-center gap-2">' +
                                    '<span class="um-avatar ' + avatarClass + '">' + initial + '</span>' +
                                    '<span class="fw-medium text-dark">' + escapeHtml(u.name) + '</span></div>';
                                var usernameCol = '<code class="text-dark bg-light px-2 py-1 rounded-2" style="font-size:12.5px;">' + escapeHtml(u.username) + '</code>';
                                var actions = '<div class="d-flex gap-1">' +
                                    '<button type="button" class="btn btn-action-edit btn-sm" onclick="openEditModal(' + u.id + ')" title="Edit"><i class="fas fa-pen"></i></button>' +
                                    '<button type="button" class="btn btn-action-delete btn-sm" onclick="confirmDelete(' + u.id + ',\'' + nameSafe + '\')" title="Hapus"><i class="fas fa-trash-alt"></i></button>' +
                                    '</div>';

                                table.row.add([i + 1, userCol, usernameCol, escapeHtml(u.email), badgeRole, createdAt, actions]);
                            });
                        }
                        table.draw();
                    }
                }
            });
        }

        // ── ADD USER FORM ──
        $('#formAddUser').on('submit', function (e) {
            e.preventDefault();
            var btn = $('#btnSubmitAdd');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

            $.ajax({
                url: BASE_URL + 'usermanagement/create',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        $('#modalAddUser').modal('hide');
                        $('#formAddUser')[0].reset();
                        showToast(res.message, 'success');
                        reloadData();
                    } else {
                        showToast(res.message, 'error');
                    }
                },
                error: function (xhr) {
                    var msg = 'Terjadi kesalahan.';
                    try { msg = JSON.parse(xhr.responseText).message; } catch (ex) { }
                    showToast(msg, 'error');
                },
                complete: function () {
                    btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan');
                }
            });
        });

        // ── EDIT USER FORM ──
        $('#formEditUser').on('submit', function (e) {
            e.preventDefault();
            var btn = $('#btnSubmitEdit');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

            $.ajax({
                url: BASE_URL + 'usermanagement/update',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        $('#modalEditUser').modal('hide');
                        showToast(res.message, 'success');
                        reloadData();
                    } else {
                        showToast(res.message, 'error');
                    }
                },
                error: function (xhr) {
                    var msg = 'Terjadi kesalahan.';
                    try { msg = JSON.parse(xhr.responseText).message; } catch (ex) { }
                    showToast(msg, 'error');
                },
                complete: function () {
                    btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Perubahan');
                }
            });
        });

        // ── Helpers ──
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return text.toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function formatDate(dateStr) {
            var d = new Date(dateStr);
            if (isNaN(d.getTime())) return dateStr;
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            return d.getDate().toString().padStart(2, '0') + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
        }

        // Expose globally
        window.openEditModal = function (id) {
            $.ajax({
                url: BASE_URL + 'usermanagement/get/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        var u = res.data;
                        $('#edit-id').val(u.id);
                        $('#edit-username-display').val(u.username);
                        $('#edit-name').val(u.name);
                        $('#edit-email').val(u.email);
                        $('#edit-role').val(u.role);
                        $('#edit-password').val('');
                        $('#modalEditUser').modal('show');
                    } else {
                        showToast(res.message || 'Gagal memuat data pengguna.', 'error');
                    }
                },
                error: function () {
                    showToast('Gagal memuat data pengguna.', 'error');
                }
            });
        };

        window.confirmDelete = function (id, name) {
            var overlay = $('<div class="um-confirm-overlay">' +
                '<div class="um-confirm-box">' +
                '<div class="um-confirm-icon"><i class="fas fa-trash-alt"></i></div>' +
                '<div class="um-confirm-title">Hapus Pengguna?</div>' +
                '<div class="um-confirm-text">Apakah Anda yakin ingin menghapus akun <strong>' + escapeHtml(name) + '</strong>? Tindakan ini tidak dapat dibatalkan.</div>' +
                '<div class="um-confirm-actions">' +
                '<button class="btn btn-confirm-cancel" id="confirmCancel">Batal</button>' +
                '<button class="btn btn-confirm-delete" id="confirmDelete"><i class="fas fa-trash-alt me-1"></i>Hapus</button>' +
                '</div></div></div>');

            $('body').append(overlay);

            overlay.find('#confirmCancel').on('click', function () {
                overlay.remove();
            });

            overlay.find('#confirmDelete').on('click', function () {
                var btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...');

                $.ajax({
                    url: BASE_URL + 'usermanagement/delete/' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        overlay.remove();
                        if (res.success) {
                            showToast(res.message, 'success');
                            reloadData();
                        } else {
                            showToast(res.message, 'error');
                        }
                    },
                    error: function (xhr) {
                        overlay.remove();
                        var msg = 'Terjadi kesalahan.';
                        try { msg = JSON.parse(xhr.responseText).message; } catch (ex) { }
                        showToast(msg, 'error');
                    }
                });
            });

            // Close on overlay click (outside box)
            overlay.on('click', function (e) {
                if ($(e.target).hasClass('um-confirm-overlay')) {
                    overlay.remove();
                }
            });
        };

        window.togglePassword = function (inputId, btn) {
            var input = document.getElementById(inputId);
            var icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        };
    });
</script>