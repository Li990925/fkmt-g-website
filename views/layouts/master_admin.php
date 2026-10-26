<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin | FKMT-G') ?></title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/logo.png">
    <link rel="apple-touch-icon" href="/assets/images/logo.png">
    <link rel="stylesheet" href="/assets/css/admin.css?v=<?= @filemtime(__DIR__ . '/../../public/assets/css/admin.css') ?: '1' ?>">
</head>
<body>
    <!-- Mobile Sidebar Backdrop Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <img src="/assets/images/logo.png" alt="Logo FKMT-G" class="sidebar-logo">
                <div>
                    <div class="sidebar-brand-title">FKMT-G</div>
                    <div class="sidebar-brand-sub">Admin Panel</div>
                </div>
            </div>
            <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup Menu">&times;</button>
        </div>
        <nav class="sidebar-nav">
            <a href="/admin" class="<?= ($uri ?? '') === '/admin' ? 'active' : '' ?>">Dashboard</a>
            <a href="/admin/berita" class="<?= strpos($uri ?? '', '/admin/berita') === 0 ? 'active' : '' ?>">Kelola Berita</a>
            <a href="/admin/pengurus" class="<?= strpos($uri ?? '', '/admin/pengurus') === 0 ? 'active' : '' ?>">Kelola Pengurus</a>
            <a href="/admin/anggota" class="<?= strpos($uri ?? '', '/admin/anggota') === 0 ? 'active' : '' ?>">Kelola Anggota</a>
            <a href="/admin/galeri" class="<?= strpos($uri ?? '', '/admin/galeri') === 0 ? 'active' : '' ?>">Galeri Kegiatan</a>
            <a href="/admin/slider" class="<?= strpos($uri ?? '', '/admin/slider') === 0 ? 'active' : '' ?>">Kelola Slider</a>
            <?php if (($_SESSION['admin_role'] ?? '') === 'super_admin'): ?>
            <a href="/admin/users" class="<?= strpos($uri ?? '', '/admin/users') === 0 ? 'active' : '' ?>" style="display: flex; align-items: center; justify-content: space-between;">
                <span>Kelola Pengguna</span>
                <span class="nav-badge-super">Super</span>
            </a>
            <?php endif; ?>
            <a href="/admin/password" class="<?= ($uri ?? '') === '/admin/password' ? 'active' : '' ?>">Ganti Password</a>
            <a href="/" target="_blank" class="sidebar-link-external">Lihat Website &nearr;</a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="/logout" id="logoutBtn" class="btn-logout">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Log Out</span>
            </a>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Buka Menu Sidebar">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div class="topbar-brand-mobile">
                    <img src="/assets/images/logo.png" alt="Logo FKMT-G" class="topbar-logo-mobile">
                    <span class="topbar-title-mobile">FKMT-G Admin</span>
                </div>
                <div class="breadcrumb desktop-only">Admin Panel</div>
            </div>
            <div class="user-profile">
                <div class="user-avatar-badge <?= ($_SESSION['admin_role'] ?? '') === 'super_admin' ? 'avatar-super' : '' ?>">
                    <?= strtoupper(mb_substr($_SESSION['admin_username'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="user-info-group">
                    <span class="user-name-text"><?= htmlspecialchars($_SESSION['admin_nama'] ?? $_SESSION['admin_username'] ?? 'Administrator') ?></span>
                    <?php if (($_SESSION['admin_role'] ?? '') === 'super_admin'): ?>
                        <span class="badge-role-super">Super Admin</span>
                    <?php else: ?>
                        <span class="badge-role-admin">Admin</span>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        
        <div class="content-wrapper">
            <?php if(!empty($_SESSION['flash_success'])): ?>
                <div style="background-color: #ECFDF5; border-left: 4px solid #059669; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; color: #065F46; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span style="font-weight: 500; font-size: 0.95rem;"><?= htmlspecialchars($_SESSION['flash_success']) ?></span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #065F46; font-size: 1.2rem; line-height: 1;">&times;</button>
                </div>
                <?php unset($_SESSION['flash_success']); ?>
            <?php endif; ?>

            <?php if(!empty($_SESSION['flash_error'])): ?>
                <div style="background-color: #FEF2F2; border-left: 4px solid #EF4444; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; color: #991B1B; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span style="font-weight: 500; font-size: 0.95rem;"><?= htmlspecialchars($_SESSION['flash_error']) ?></span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #991B1B; font-size: 1.2rem; line-height: 1;">&times;</button>
                </div>
                <?php unset($_SESSION['flash_error']); ?>
            <?php endif; ?>

            <?= \app\Config\Csrf::injectIntoForms($content ?? '') ?>
        </div>
    </main>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <div class="modal-icon">⚠️</div>
            <h3>Konfirmasi Penghapusan</h3>
            <p>Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
                <button type="button" id="confirmDeleteBtn" class="btn-danger" style="border: none; cursor: pointer; font: inherit;">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <!-- Form tersembunyi untuk aksi hapus via POST + token CSRF -->
    <form id="deleteForm" method="POST" action="" style="display: none;">
        <?= \app\Config\Csrf::field() ?>
    </form>

    <!-- Loading Overlay untuk Logout -->
    <div class="loading-overlay-admin" id="logoutLoadingOverlay">
        <div class="loader-container-admin">
            <div class="spinner-admin"></div>
            <p class="loader-text-admin">Sedang Keluar...</p>
            <p class="loader-subtext-admin">Menutup sesi admin Anda dengan aman</p>
        </div>
    </div>

    <script>
        let pendingDeleteUrl = null;

        function openDeleteModal(url) {
            pendingDeleteUrl = url;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            pendingDeleteUrl = null;
            document.getElementById('deleteModal').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function() {
                    if (!pendingDeleteUrl) return;
                    const form = document.getElementById('deleteForm');
                    form.action = pendingDeleteUrl;
                    confirmBtn.disabled = true;
                    confirmBtn.textContent = 'Menghapus...';
                    form.submit();
                });
            }
        });
        
        // Replace all default confirms with custom modal
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Sidebar Toggle Handlers
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const adminSidebar = document.getElementById('adminSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

            function openSidebar() {
                if (adminSidebar) adminSidebar.classList.add('active');
                if (sidebarOverlay) sidebarOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                if (adminSidebar) adminSidebar.classList.remove('active');
                if (sidebarOverlay) sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (sidebarToggleBtn) sidebarToggleBtn.addEventListener('click', openSidebar);
            if (sidebarCloseBtn) sidebarCloseBtn.addEventListener('click', closeSidebar);
            if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

            if (adminSidebar) {
                adminSidebar.querySelectorAll('.sidebar-nav a').forEach(link => {
                    link.addEventListener('click', () => {
                        if (window.innerWidth <= 768) closeSidebar();
                    });
                });
            }

            const deleteLinks = document.querySelectorAll('.btn-delete');
            deleteLinks.forEach(link => {
                // Hapus atribut onclick bawaan jika ada
                link.removeAttribute('onclick');
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    openDeleteModal(this.href);
                });
            });

            // Logout animation
            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah pindah halaman langsung
                    const targetUrl = this.href;
                    
                    // Tampilkan animasi loading
                    document.getElementById('logoutLoadingOverlay').classList.add('active');
                    
                    // Tunggu 1.5 detik agar animasi selesai lalu pindah halaman
                    setTimeout(function() {
                        window.location.href = targetUrl;
                    }, 1500);
                });
            }
        });
    </script>
</body>
</html>
