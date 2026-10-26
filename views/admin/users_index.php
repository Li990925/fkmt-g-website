<?php $title = "Kelola Pengguna | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 class="page-title" style="margin-bottom: 0.25rem;">Kelola Pengguna & Hak Akses</h1>
        <p style="color: #64748B; font-size: 0.95rem; margin: 0;">Kelola akun pengurus, peran (*role*), dan akses ke panel administrasi.</p>
    </div>
    
    <div>
        <a href="/admin/users/tambah" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.92rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Pengguna Baru
        </a>
    </div>
</div>

<!-- Info Alert Hak Akses -->
<div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-left: 4px solid #8B5CF6; border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 1.75rem; display: flex; align-items: flex-start; gap: 0.85rem;">
    <div style="color: #8B5CF6; font-size: 1.25rem; line-height: 1; margin-top: 2px;">🛡️</div>
    <div style="font-size: 0.88rem; color: #475569; line-height: 1.5;">
        <strong style="color: #1E293B;">Struktur Peran (*Role Hierarchy*):</strong><br>
        <span class="role-pill-super" style="padding: 0.1rem 0.5rem; font-size: 0.72rem; margin-right: 0.35rem;">Super Admin</span> Memiliki hak akses penuh, termasuk mengelola akun pengguna, membuat pengurus baru, dan mengubah peran.<br>
        <span class="role-pill-admin" style="padding: 0.1rem 0.5rem; font-size: 0.72rem; margin-right: 0.35rem; margin-top: 0.25rem; display: inline-flex;">Admin</span> Pengurus operasional untuk mengelola berita, galeri, anggota, slider, dan pengurus harian.
    </div>
</div>

<div class="card">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #E2E8F0; color: #64748B; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 1rem 0.5rem; width: 50px;">No</th>
                    <th style="padding: 1rem;">Pengguna</th>
                    <th style="padding: 1rem;">Username</th>
                    <th style="padding: 1rem;">Peran (*Role*)</th>
                    <th style="padding: 1rem;">Terdaftar Sejak</th>
                    <th style="padding: 1rem; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($semuaAdmin)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 3rem 1rem; color: #94A3B8;">
                            Belum ada pengguna terdaftar.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php 
                    $no = 1; 
                    $currentUserId = (int)($_SESSION['admin_id'] ?? 0);
                    foreach ($semuaAdmin as $u): 
                        $isSelf = ($currentUserId === (int)$u['id']);
                        $isSuper = ($u['role'] === 'super_admin');
                    ?>
                    <tr style="border-bottom: 1px solid #F1F5F9; transition: background 0.15s;" onmouseover="this.style.backgroundColor='#F8FAFC'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 1rem 0.5rem; color: #94A3B8; font-weight: 500;"><?= $no++ ?></td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: <?= $isSuper ? 'linear-gradient(135deg, #7C3AED, #4F46E5)' : 'linear-gradient(135deg, #059669, #0D9488)' ?>; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.95rem; box-shadow: 0 2px 4px <?= $isSuper ? 'rgba(124, 58, 237, 0.25)' : 'rgba(5, 150, 105, 0.2)' ?>;">
                                    <?= strtoupper(mb_substr($u['nama'] ?: $u['username'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #1E293B; font-size: 0.95rem; display: flex; align-items: center; gap: 0.4rem;">
                                        <?= htmlspecialchars($u['nama'] ?: $u['username']) ?>
                                        <?php if ($isSelf): ?>
                                            <span style="background: #E2E8F0; color: #475569; font-size: 0.68rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 4px; text-transform: uppercase;">Anda</span>
                                        <?php endif; ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: #64748B;">ID: #<?= (int)$u['id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1rem;">
                            <code style="background: #F1F5F9; color: #0F172A; padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.88rem; font-family: monospace;">@<?= htmlspecialchars($u['username']) ?></code>
                        </td>
                        <td style="padding: 1rem;">
                            <?php if ($isSuper): ?>
                                <span class="role-pill-super">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                    Super Admin
                                </span>
                            <?php else: ?>
                                <span class="role-pill-admin">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg>
                                    Admin / Pengurus
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 1rem; color: #64748B; font-size: 0.88rem;">
                            <?= !empty($u['created_at']) ? date('d M Y, H:i', strtotime($u['created_at'])) : '-' ?>
                        </td>
                        <td style="padding: 1rem; text-align: right; white-space: nowrap;">
                            <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <a href="/admin/users/edit/<?= (int)$u['id'] ?>" class="btn-primary" style="padding: 0.45rem 0.85rem; font-size: 0.82rem; background: #3B82F6; text-decoration: none; border-radius: 6px;">
                                    Edit
                                </a>
                                <?php if (!$isSelf): ?>
                                    <a href="/admin/users/hapus/<?= (int)$u['id'] ?>" class="btn-danger btn-delete" style="padding: 0.45rem 0.85rem; font-size: 0.82rem; text-decoration: none; border-radius: 6px;">
                                        Hapus
                                    </a>
                                <?php else: ?>
                                    <span style="font-size: 0.8rem; color: #CBD5E1; padding: 0.45rem 0.5rem;" title="Tidak dapat menghapus akun sendiri">Terkunci</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>
