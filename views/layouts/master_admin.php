<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin | FKMT-G' ?></title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/logo.png">
    <link rel="apple-touch-icon" href="/assets/images/logo.png">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header" style="display: flex; align-items: center; gap: 0.75rem; padding: 1.25rem 1.25rem;">
            <img src="/assets/images/logo.png" alt="Logo FKMT-G" style="width: 38px; height: 38px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.25));">
            <div>
                <div style="font-weight: 800; font-size: 1.05rem; line-height: 1.2; color: #FFFFFF;">FKMT-G</div>
                <div style="font-size: 0.7rem; color: #34D399; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Admin Panel</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="/admin" class="<?= ($uri ?? '') === '/admin' ? 'active' : '' ?>">Dashboard</a>
            <a href="/admin/berita" class="<?= strpos($uri ?? '', '/admin/berita') === 0 ? 'active' : '' ?>">Kelola Berita</a>
            <a href="/admin/pengurus" class="<?= strpos($uri ?? '', '/admin/pengurus') === 0 ? 'active' : '' ?>">Kelola Pengurus</a>
            <a href="/admin/anggota" class="<?= strpos($uri ?? '', '/admin/anggota') === 0 ? 'active' : '' ?>">Kelola Anggota</a>
            <a href="/admin/galeri" class="<?= strpos($uri ?? '', '/admin/galeri') === 0 ? 'active' : '' ?>">Galeri Kegiatan</a>
            <a href="/admin/slider" class="<?= strpos($uri ?? '', '/admin/slider') === 0 ? 'active' : '' ?>">Kelola Slider</a>
            <a href="/admin/password" class="<?= ($uri ?? '') === '/admin/password' ? 'active' : '' ?>">Ganti Password</a>
            <a href="/" target="_blank" style="margin-top:2rem; border-top:1px solid rgba(255,255,255,0.1); padding-top:1rem;">Lihat Website &nearr;</a>
        </nav>
        
        <div style="margin-top: auto; padding: 1.5rem;">
            <a href="/logout" id="logoutBtn" style="background-color: #EF4444; color: white; text-align: center; padding: 0.75rem 1rem; border-radius: 6px; font-weight: 600; text-decoration: none; display: block; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#DC2626'" onmouseout="this.style.backgroundColor='#EF4444'">Log Out</a>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <header class="topbar">
            <div class="breadcrumb">Admin Panel</div>
            <div class="user-profile">Halo, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Administrator') ?></div>
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

            <?= $content ?? '' ?>
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
                <a href="#" id="confirmDeleteBtn" class="btn-danger">Ya, Hapus</a>
            </div>
        </div>
    </div>

    <!-- Loading Overlay untuk Logout -->
    <div class="loading-overlay-admin" id="logoutLoadingOverlay">
        <div class="loader-container-admin">
            <div class="spinner-admin"></div>
            <p class="loader-text-admin">Sedang Keluar...</p>
            <p class="loader-subtext-admin">Menutup sesi admin Anda dengan aman</p>
        </div>
    </div>

    <script>
        function openDeleteModal(url) {
            document.getElementById('confirmDeleteBtn').href = url;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
        
        // Replace all default confirms with custom modal
        document.addEventListener('DOMContentLoaded', function() {
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
