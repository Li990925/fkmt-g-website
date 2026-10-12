<?php 
$title = "404 - Halaman Tidak Ditemukan | FKMT-G"; 
?>
<?php ob_start(); ?>

<div class="error-page-wrapper">
    <div class="error-card">
        <div class="error-badge-404">404</div>
        <div style="width: 72px; height: 72px; margin: 0 auto 1.5rem; background: rgba(5, 150, 105, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary);">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M16 16s-1.5-2-4-2-4 2-4 2"></path>
                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                <line x1="15" y1="9" x2="15.01" y2="9"></line>
            </svg>
        </div>
        <h1>Halaman Tidak Ditemukan</h1>
        <p>Maaf, alamat web yang Anda tuju mungkin salah ketik, telah dipindahkan, atau sudah tidak tersedia lagi di sistem kami.</p>
        
        <div class="error-buttons">
            <a href="/" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Kembali ke Beranda
            </a>
            <a href="/berita" class="btn-secondary-error" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
                Baca Berita
            </a>
            <a href="/tentang" class="btn-secondary-error" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                Tentang Kami
            </a>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_publik.php'; ?>
